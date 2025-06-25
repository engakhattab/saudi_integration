<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\CapacityDays;
use App\Models\Category;
use App\Models\Clients;
use App\Models\DiscountReason;
use App\Models\Event;
use App\Models\GeneralSetting;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Reservations;
use App\Models\ShiftDetails;
use App\Models\Shifts;
use App\Models\Ticket;
use App\Models\TicketRevModel;
use App\Models\TicketRevProducts;
use App\Models\User;
use App\Models\VisitorTypes;
use Carbon\Carbon;
use Carbon\Traits\Date;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;

class TicketController extends Controller
{

    function __construct()
    {

        $this->middleware('permission:Edit Ticket')->except('getShifts', 'calcCapacity', 'edit', 'getProductsPrices', 'ExistAllTicketRev');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sales/ticket');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'visit_date' => 'required|after:yesterday',
            'hours_count' => 'required',
            'shift_id' => 'required',
        ]);
        $request->except('_token');
        $ticket = Ticket::where('id', $request->id)->first();
        if (!$ticket) {
            $ticket = new Ticket();
        }
        $ticket->visit_date = $request->visit_date;
        $ticket->shift_id = $request->shift_id;
        $ticket->hours_count = $request->hours_count;
        $ticket->save();
        $ticket->shift_id = date('h A', strtotime($ticket->shift->from)) . " : " . date('h A', strtotime($ticket->shift->to));
        return response()->json(['ticket' => $ticket, 'success' => true]);
    }

    public function calcCapacity(Request $request)
    {
        $request->validate([
            'visit_date' => 'required|after:yesterday',
            'hours_count' => 'required',
            'shift_id' => 'required',
            'client_id' => 'nullable',
        ]);
        $tic = Ticket::where([['client_id', $request->client_id], ['visit_date', $request->visit_date], ['status', '<>', 'out']])->first();
        if ($tic) {
            return response()->json(['status' => 405, 'day' => $request->visit_date]);
        } else {

            $capacity = (CapacityDays::where('day', $request->visit_date)->first()->count) ?? GeneralSetting::first()->capacity;
            $booked_count = TicketRevModel::where('day', $request->visit_date)->where('status', '<>', 'out')->count();

            // if booked = or > from the day wanted then the day is full
            if ($booked_count >= $capacity)
                return response()->json(['day' => $request->visit_date, 'status' => false]);
            else {
                // else then there is a count for new tickets and adjust response
                $available = $capacity - $booked_count;
                $hours = $request->hours_count;
                $shift_prices = VisitorTypes::where($hours . '_hours', '!=', 0)
                    ->select('id as visitor_type_id', $hours . '_hours as price')
                    ->get();
                return response()->json(['shift_prices' => $shift_prices, 'available' => $available, 'status' => true]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $client = Clients::findOrFail($id);
        $rate = $client->rate;
        $shifts = Shifts::all();
        $first_shift_start = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H');
        $types = VisitorTypes::where('event_id', 0)->get();
        $categories = Category::with(['products' => function ($query) {
            $query->where('status', '1');
        }])
            ->whereHas('products', function ($q) {
                $q->where('status', '1');
            })
            ->get();
        $customId = strtoupper(date('D') . $id . 'Re' . substr(time(), -2));

        $discounts = DiscountReason::where('end', '>=', now()->format('Y-m-d'))->get(); //??????????????????????????????????????????????????????????????????????????????????
        $random = strtoupper(substr(Carbon::now()->format("l"), 0, 3) . $id . rand(0, 99) . Carbon::now()->format('is'));
        $id = $client->phone;
        return view('sales/ticket', compact('first_shift_start', 'client', 'discounts', 'rate', 'customId', 'shifts', 'random', 'types', 'categories', 'id'));
    }

    public function storeModels(request $request)
    {

        //        $tic = Ticket::where([['client_id', $request->client_id], ['visit_date', $request->visit_date], ['status', '<>', 'out']])->first();
        //        if ($tic) {
        //            return response()->json(['status' => false,]);
        //        } else {

        $ticket = Ticket::create([
            'add_by' => auth()->user()->id,
            'visit_date' => $request->visit_date,
            'shift_id' => $request->shift_id,
            'client_id' => $request->client_id,
            'hours_count' => $request->duration,
            'ticket_price' => $request->revenue / 1.15,
            'ent_tax' => $request->ent_tax,
            'vat' => ($request->revenue - ($request->revenue / 1.15)),
            'total_price' => $request->total_price,
            'discount_type' => $request->discount_type[0],
            'discount_value' => $request->discount_value,
            'discount_id' => $request->discount_id,
            'ticket_num' => $request->rand_ticket,
            'paid_amount' => $request->revenue,
            'grand_total' => $request->revenue,
            'rem_amount' => 0,
            'payment_method' => $request->payment_method,
        ]);

        if ($request->amount == $request->revenue) {
            $total = 0;
            if ($request->discount_type[0] == 'per') {

                $total =  $request->total_price - (($request->total_price * $request->discount_value) / 100);
            } elseif ($request->discount_type[0] == 'val') {
                $total = $request->total_price - $request->discount_value;
            } else {
                $total = $request->total_price;
            }
            Payment::create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $total,
                'payment_method' => $request->payment_method

            ]);
        } else {

            for ($i = 1; $i < 3; $i++) {

                Payment::create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => $i == 1 ? $request->amount : ($request->revenue - $request->amount),
                    'payment_method' => $i == 1 ? $request->payment_method : $request->pay,

                ]);
            }
        }

        // check if code is run on domain not local host
        if ($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1:8000')
            $ticket->update(['uploaded' => true]);

        for ($i = 0; $i < count($request->visitor_type); $i++) {

            if ($ticket->discount_type == 'per') {

                $rev = TicketRevModel::create([
                    'ticket_id' => $ticket->id,
                    'shift_start' => $request->shift_start . ':00' . ':00',
                    'shift_end' => $request->shift_end . ':00' . ':00',
                    'visitor_type_id' => $request->visitor_type[$i],
                    'day' => $request->visit_date,
                    'price' => $request->visitor_price[$i],
                    'name' => $request->visitor_name[$i],
                    'birthday' => $request->visitor_birthday[$i],
                    'gender' => $request->gender[$i],
                    'total_after_discount' => $request->visitor_price[$i] - (($request->visitor_price[$i] * $ticket->discount_value) / 100),
                ]);
            } elseif ($ticket->discount_type == 'val') {

                $rev = TicketRevModel::create([
                    'ticket_id' => $ticket->id,
                    'shift_start' => $request->shift_start . ':00' . ':00',
                    'shift_end' => $request->shift_end . ':00' . ':00',
                    'visitor_type_id' => $request->visitor_type[$i],
                    'day' => $request->visit_date,
                    'price' => $request->visitor_price[$i],
                    'name' => $request->visitor_name[$i],
                    'birthday' => $request->visitor_birthday[$i],
                    'gender' => $request->gender[$i],
                    'total_after_discount' => $request->visitor_price[$i] - (100 *  $ticket->discount_value) / $ticket->total_price * ($request->visitor_price[$i] / 100)
                ]);
            } else {
                $rev = TicketRevModel::create([
                    'ticket_id' => $ticket->id,
                    'shift_start' => $request->shift_start . ':00' . ':00',
                    'shift_end' => $request->shift_end . ':00' . ':00',
                    'visitor_type_id' => $request->visitor_type[$i],
                    'day' => $request->visit_date,
                    'price' => $request->visitor_price[$i],
                    'name' => $request->visitor_name[$i],
                    'birthday' => $request->visitor_birthday[$i],
                    'gender' => $request->gender[$i],
                    'total_after_discount' => $request->visitor_price[$i],
                ]);
            }
        }
        if ($request->has('product_id')) {
            for ($i = 0; $i < count($request->product_id); $i++) {
                TicketRevProducts::create([
                    'ticket_id' => $ticket->id,
                    'product_id' => $request->product_id[$i],
                    'category_id' => Product::where('id', $request->product_id[$i])->first()->category_id,
                    'qty' => $request->product_qty[$i],
                    'price' => $request->product_price[$i] / $request->product_qty[$i],
                    'total_price' => $request->product_price[$i],
                ]);
            }
        }
        $accessUrl = route('familyAccess.index') . '?search=' . $ticket->ticket_num;
        $printUrl = route('ticket.edit', $ticket->id);
        return response()->json([
            'status' => true,
            'accessUrl' => $accessUrl,
            'printUrl' => $printUrl,
        ]);
        //        }
    }


    public function edit($id)
    {
        $ticket = Ticket::with('products.product', 'client', 'shift')->findOrFail($id);
        $models = TicketRevModel::where('ticket_id', $id)->get();
        $date = Carbon::now()->format('h:i a');
        $product_ids = $ticket->products->pluck('product_id');
        $product_qty = $ticket->products->pluck('qty');
        for ($i = 0; $i < count($product_ids); $i++) {
            // get total prices of all products before tax
            $prices_before_tax[] = Product::where('id', $product_ids[$i])->first()->price_before_vat * $product_qty[$i];

            // for each vat -> get sum of difference between price before tax and final price
            $product = Product::where([['id', $product_ids[$i]], ['vat', '!=', '0']])->first();
            if ($product != null) {
                $titles[] = 'vat ' . $product->vat . '%';
                $vat[] = round($product->price * $product_qty[$i] - $prices_before_tax[$i], 2);
            }
        }

        // adjust the values
        if (isset($titles) > 0 && isset($vat) > 0) {
            foreach ($titles as $key => $value) {
                if (isset($titles[$key + 1]) && $value == $titles[$key + 1]) {
                    $vat[$key] = $vat[$key] + $vat[$key + 1];
                    unset($titles[$key + 1]);
                    unset($vat[$key + 1]);
                }
            }
            $titles = array_values($titles);
            $vat = array_values($vat);
            $sum = array_sum($prices_before_tax);
            return view('layouts.print.ticket', compact('ticket', 'titles', 'vat', 'sum', 'models', 'date'));
        }
        return view('layouts.print.ticket', compact('ticket', 'models', 'date'));
    }

    public function search()
    {
        $shifts = Shifts::all();
        return view('sales/editTickets', compact('shifts'));
    }

    public function searchForTicket(request $request)
    {
        $tickets = Ticket::query();
        if ($request->searchText != null) {
            $tickets->where(function ($q) use ($request) {
                $q->where('ticket_num', $request->searchText)->orWhereHas('client', function ($q) use ($request) {
                    $q->where('phone', $request->searchText)->orWhere('name', 'like', '%' . $request->searchText . '%');
                })->orWhereHas('models', function ($q) use ($request) {
                    $q->where('bracelet_number', $request->searchText);
                });
            });
        }

        if ($request->has('choices_shift') && $request->choices_shift != 'all')
            $tickets->where('shift_id', $request->choices_shift);

        $tickets = $tickets->whereDate('visit_date', Carbon::today())->get();
        $html = [];

        foreach ($tickets as $ticket) {
            $smallArray = [];
            $smallArray[] = '<span class="text-success editSpan" style="cursor:pointer" data-id="' . $ticket->id . '">#' . $ticket->ticket_num . "</span>";
            $smallArray[] = $ticket->visit_date;
            $smallArray[] = $ticket->client->name ?? $ticket->name;
            $smallArray[] = $ticket->client->phone ?? $ticket->phone;
            $smallArray[] = (Carbon::parse($ticket->models[0]->shift_start)->format('h:s a')) ?? '';

            if ($ticket->models[0]->shift_start >= '24:00:00') {
                $smallArray[] = (Carbon::createFromFormat('H:i:s',$ticket->models[0]->shift_end)->subDay()->format('h:s a')) ?? '';
            } else {
                $smallArray[] = (Carbon::createFromFormat('H:i:s',$ticket->models[0]->shift_end)->format('h:s a')) ?? '';
            }
            //            $smallArray[] = date('h a', strtotime($ticket->shift->from)).":".date('h a', strtotime($ticket->shift->to));
            $smallArray[] = $ticket->models->count();
            $accessUrl = route('familyAccess.index') . '?search=' . $ticket->ticket_num;
            $printUrl = route('ticket.edit', $ticket->id);
            $editUrl = route('updateTicket', $ticket->id);
            $title = ($ticket->client->name) ?? '' . " - " . $ticket->ticket_num;
            $editSpan = null;
            $deleteSpan = null;
            $accessSpan = null;
            if ($ticket->status == 'append')
                $editSpan = '<span class="icon" data-bs-toggle="tooltip" title="edit" data-id="' . $ticket->id . '"><a href="' . $editUrl . '"><i class="far fa-edit"></i></a></span>';

            if ($ticket->status != 'in' && $ticket->status != 'out')
                $deleteSpan = '<span class="icon deleteSpan" data-bs-toggle="tooltip" title=" delete "  data-title="' . $title . '" data-id="' . $ticket->id . '"> <i class="far fa-trash-alt"></i>  </span>';

            if ($ticket->status == 'append')
                $accessSpan = '<span class="icon" data-bs-toggle="tooltip" title="Access"><a href="' . $accessUrl . '"><i class="fal fa-check "></i></a></span>';

            $smallArray[] = '<span class="controlIcons">
                  <span class="icon" data-bs-toggle="tooltip" title="print"><a target="_blank" href="' . $printUrl . '"><i class="far fa-print"></i> </a> </span>
                  ' . $editSpan . '
                  ' . $deleteSpan . '
                  <span class="icon showSpan" data-bs-toggle="tooltip" title=" details " data-id="' . $ticket->id . '"> <i class="fas fa-eye"></i></i>  </span>
                  ' . $accessSpan . '
                </span>';
            $html[] = $smallArray;
        }
        return response()->json(['html' => $html, 'status' => 200]);
    }

    public function editTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        return view('sales.layouts.ticket.edit', compact('ticket'));
    }

    public function editTicketInfo(request $request)
    {
        $request->validate([
            'visit_day' => 'required|date_format:Y-m-d|after:yesterday',
            'name' => 'required|string|max:500',
            'email' => 'nullable|string|max:500',
            'phone' => 'nullable|string|numeric',
            'user_id' => 'required|exists:clients,id',
        ]);
        $user = Clients::find($request->user_id);
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);
        $ticket = Ticket::find($request->id);

        if ($ticket->update(['visit_date' => $request->visit_day]))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }

    public function updateTicket($id)
    {
        $ticket = Ticket::where([['id', $id], ['status', 'append']])->firstOrFail();
        $add_by = User::where('id', $ticket->add_by)->first()->name ?? 'Web Site';
        $types = VisitorTypes::where('event_id', '=', 0)->get();
        $rate = $ticket->client->rate ?? '';
        $models = TicketRevModel::where('ticket_id', $id)->get();
        $categories = Category::with(['products' => function ($query) {
            $query->where('status', '1');
        }])->whereHas('products', function ($q) {
            $q->where('status', '1');
        })->get();
        $discounts = DiscountReason::all();
        $products = TicketRevProducts::where('ticket_id', $id)->get();
        //        $prices = $this->getPrices($ticket->hours_count,$ticket->shift_id);
        $prices = [];
        $prices = VisitorTypes::where($ticket->hours_count . '_hours', '!=', 0)
            ->select('id as visitor_type_id', $ticket->hours_count . '_hours as price')
            ->get();
        //        return $prices;
        return view('sales.updateTicket', compact('ticket', 'rate', 'add_by', 'discounts', 'prices', 'products', 'models', 'types', 'categories'));
    }

    public function restoreTicket(request $request)
    {
        $ticket = Ticket::findOrFail($request->ticket_id);
        $shift_start = $ticket->models->first()->shift_start;
        $shift_end = $ticket->models->first()->shift_end;
        $day = $ticket->models->first()->day;
        foreach ($ticket->models as $model) {
            $model->delete();
        }
        //        if ($request->rem == 0)
        //            $status = '1';
        //        else
        //            $status = '0';

        $ticket->update([
            'total_price' => $request->total_price,
            'ticket_price' => $request->ticket_price,
            'ent_tax' => $request->ent_tax,
            'vat' => $request->vat,
            'discount_type' => $request->discount_type[0],
            'discount_value' => $request->discount_value,
            'paid_amount' => $request->amount,
            'grand_total' => $request->revenue,
            'rem_amount' => $request->rem,
        ]);



        Payment::create([

            'ticket_id' => $request->ticket_id,
            'cashier_id' => auth()->user()->id,
            'day' => Carbon::now()->format('Y-m-d'),
            'amount' => ($request->revenue - $request->oldPayRev),
            'payment_method' => $request->pay

        ]);


        for ($i = 0; $i < count($request->visitor_type); $i++) {
            TicketRevModel::create([
                'ticket_id' => $ticket->id,
                'shift_start' => $shift_start,
                'shift_end' => $shift_end,
                'day' => $day,
                'visitor_type_id' => $request->visitor_type[$i],
                'price' => $request->visitor_price[$i],
                'total_after_discount' => $request->visitor_price[$i] ?? 0,
                'name' => $request->visitor_name[$i],
                'birthday' => $request->visitor_birthday[$i],
                'gender' => ($request->gender[$i]) ?? null,

            ]);
        }
        foreach ($ticket->products as $product) {
            $product->delete();
        }
        if ($request->has('product_id')) {
            for ($i = 0; $i < count($request->product_id); $i++) {
                TicketRevProducts::create([
                    'ticket_id' => $ticket->id,
                    'product_id' => $request->product_id[$i],
                    'category_id' => Product::where('id', $request->product_id[$i])->first()->category_id,
                    'qty' => $request->product_qty[$i],
                    'price' => $request->product_price[$i] / $request->product_qty[$i],
                    'total_price' => $request->product_price[$i],
                ]);
            }
        }
        $accessUrl = route('familyAccess.index') . '?search=' . $ticket->ticket_num;
        $printUrl = route('ticket.edit', $ticket->id);
        return response()->json([
            'status' => true,
            'accessUrl' => $accessUrl,
            'printUrl' => $printUrl,
        ]);
    }

    public function getPrices($hours_count, $shift_id)
    {
        $shift = Shifts::where('id', $shift_id)->first();
        $hours = $hours_count;
        $shift_duration = strtotime($shift->to) - (strtotime($shift->from));
        $shift_prices = ShiftDetails::where('shift_id', $shift_id)->select('visitor_type_id', 'price')->get();
        // now check if wanted hours is less than shift time then do direct calculations
        if ($hours <= $shift_duration / 3600) {
            foreach ($shift_prices as $price) {
                $price->price *= $hours;
            }
            return $shift_prices;
        } else {
            // do function
            $visitorTypes = VisitorTypes::latest()->get();
            $hoursCount = $hours_count;
            $newHoursCount = $hours_count;
            $minHorse = 0;

            $shift = Shifts::findOrFail($shift_id);
            $shifts = [];
            $prices = [];
            $pricesArray = [];
            $searchHourArray = [];
            foreach ($visitorTypes as $visitorType) {
                $pricesArray[$visitorType->id] = 0;
            }

            while ($newHoursCount > 0) {

                $from = strtotime(date('H', strtotime($shift->from)) . ":00");
                $to = strtotime(date('H', strtotime($shift->to)) . ":00");
                $difference = round(abs($to - $from) / 3600, 2);
                if ($hoursCount > $difference) {
                    $searchHour = $difference;
                } else {
                    $searchHour = $hoursCount;
                }

                if ($newHoursCount < $difference) {
                    $searchHour = $newHoursCount;
                }


                foreach ($visitorTypes as $visitorType) {
                    $findShiftDetails = ShiftDetails::where('shift_id', $shift->id)->where('visitor_type_id', $visitorType->id)->firstOrFail();
                    $shifts[] = $findShiftDetails;
                    $pricesArray[$visitorType->id] += $searchHour * $findShiftDetails->price;
                }
                $nextId = Shifts::whereTime('from', '>=', $shift->to)->max('id');
                $latestShift = $shift;
                $shift = Shifts::find($nextId);
                $newHoursCount = $newHoursCount - $searchHour;

                if (!$shift) {
                    break;
                }
            }
            $shift_prices = [];
            foreach ($pricesArray as $key => $item) {
                $smallArray = [];
                $smallArray['visitor_type_id'] = $key;
                $smallArray['price'] = $item;
                $shift_prices[] = $smallArray;
            }
            return $shift_prices;
        }
    }


    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function details($id)
    {
        $ticket = Ticket::findOrFail($id);
        $products = TicketRevProducts::where('ticket_id', $ticket->id)->get();
        $models = $ticket->models->groupBy('visitor_type_id');
        return view('sales.layouts.ticket.details', compact('ticket', 'models', 'products'));
    }

    public function delete_ticket(request $request)
    {
        $ticket = Ticket::where('id', $request->id)->first();
        if ($ticket->status == 'append') {
            foreach ($ticket->models as $model) {
                $model->delete();
            }
            $ticket->delete();
            return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
        } else
            return response(['message' => "You Can't Delete This Ticket !", 'status' => 405], 200);
    }

    // public function getShifts(request $request)
    // {
    //     $selected_start = null;
    //     $selected_end = null;
    //     $rev = Reservations::where('id', $request->id)->first();
    //     if ($rev) {

    //         ////          $selected_start = Carbon::parse($rev->models[0]->shift_start)->format('H');
    //         ////        $selected_end   = Carbon::parse($rev->models[0]->shift_end)->format('H');

    //         $selected_start = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H');
    //         $selected_end = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H') . ':00';
    //     }
    //     $visit_date = $request->visit_date;
    //     $times = [];
    //     $shift_id = [];
    //     $starts = [];
    //     $ends = [];
    //     if (Carbon::parse($visit_date)->isToday()) {
    //         $start_time = date('H:i') . '00';
    //         $time_format = date('H:i') . ':00';
    //     } else {
    //         $start_time = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H');
    //         $time_format = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H') . ':00';
    //     }
    //     $i = (int)$start_time + $request->duration;
    //     while ($i <= 30) {
    //         $shift = Shifts::where(function ($query) use ($time_format) {
    //             $query->where('from', '<=', $time_format);
    //         })->first();
    //         if ($shift != null) {
    //             $shift_id[] = $shift->id;
    //             if (((int)$start_time + $request->duration) < 12 && ((int)$start_time + $request->duration) % 12 != 0 && ((((int)$start_time + (int)$request->duration)) % 12) != 0 && (((int)$start_time) % 12) != 0)
    //                 $times[] = 'From ' . (((int)$start_time) % 12) . ' To ' . ((((int)$start_time + (int)$request->duration)) % 12) . ' AM';
    //             else if (((int)$start_time + $request->duration) > 12 && ((int)$start_time + $request->duration) % 12 != 0 && ((((int)$start_time + (int)$request->duration)) % 12) != 0 && (((int)$start_time) % 12) != 0)
    //                 $times[] = 'From ' . (((int)$start_time) % 12) . ' To ' . ((((int)$start_time + (int)$request->duration)) % 12) . ' PM';
    //             else {
    //                 $from = (((int)$start_time) % 12) == 0 ? '12' : (((int)$start_time) % 12);
    //                 $to = ((((int)$start_time + (int)$request->duration)) == 12) == 12 ? '12 PM' : '12 AM';
    //                 if ((((int)$start_time + (int)$request->duration)) == 12) {
    //                     $to = '12 PM';
    //                 } elseif ((((int)$start_time + (int)$request->duration)) == 24) {
    //                     $to = '12 AM';
    //                 } elseif ((((int)$start_time + (int)$request->duration)) > 12 && (((int)$start_time + (int)$request->duration)) != 24) {
    //                     $to = ((((int)$start_time + (int)$request->duration)) % 12) . ' PM';
    //                 }
    //                 $times[] = 'From ' . $from . ' To ' . $to;
    //             }
    //             $starts[] = ((int)$start_time);
    //             $ends[] = (((int)$start_time + (int)$request->duration));
    //             $time_format = ((int)$start_time + (int)$request->duration) . ':00';
    //             $start_time = ((int)$start_time + 1);
    //             $i++;
    //         } else {
    //             $time_format = ((int)$start_time + (int)$request->duration) . ':00';
    //             $start_time = ((int)$start_time + 1);
    //             $i++;
    //         }
    //     }
    //     return response(['times' => $times, 'selected_start' => $selected_start, 'selected_end' => $selected_end, 'starts' => $starts, 'ends' => $ends, 'shift_id' => $shift_id, 'status' => 200], 200);
    // }

    public function getShifts(Request $request)
    {
        $selected_start = null;
        $selected_end = null;
        $rev = Reservations::where('id', $request->id)->first();
        if ($rev) {
            $selected_start = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H');
            $selected_end = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H') . ':00';
        }

        $visit_date = $request->visit_date;
        $times = [];
        $shift_id = [];
        $starts = [];
        $ends = [];

        if (Carbon::parse($visit_date)->isToday()) {
            $start_time = date('H:i') . '00';
            $time_format = date('H:i') . ':00';
        } else {
            $start_time = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H');
            $time_format = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H') . ':00';
        }

        $duration = (int) $request->duration;

        $i = (int)$start_time + $duration;
        while ($i <= 28) {
            $shift = Shifts::where(function ($query) use ($time_format) {
                $query->where('from', '<=', $time_format);
            })->first();

            if ($shift != null) {
                $shift_id[] = $shift->id;

                // Formatting start hour
                $formatted_start = ((int)$start_time) % 24 == 0 ? 12 : str_pad(((int)$start_time) % 24, 2, "0", STR_PAD_LEFT);
                // Formatting end hour
                $formatted_end = ((((int)$start_time + $duration)) % 24 == 0) ? 12 : str_pad((((int)$start_time + $duration)) % 24, 2, "0", STR_PAD_LEFT);
                $times[] = 'From ' . $formatted_start . ':00 To ' . $formatted_end . ':00';

                $starts[] = ((int)$start_time);
                $ends[] = (((int)$start_time + $duration));
                $time_format = ((int)$start_time + $duration) . ':00';
                $start_time = ((int)$start_time + 1);
                $i++;
            } else {
                $time_format = ((int)$start_time + $duration) . ':00';
                $start_time = ((int)$start_time + 1);
                $i++;
            }
        }

        return response([
            'times' => $times,
            'selected_start' => $selected_start,
            'selected_end' => $selected_end,
            'starts' => $starts,
            'ends' => $ends,
            'shift_id' => $shift_id,
            'status' => 200
        ], 200);
    }




    public function getProductsPrices(request $request)
    {
        $prices_before_tax = [];
        $titles = [];
        $vat = [];

        for ($i = 0; $i < count($request->products_id); $i++) {
            // get total prices of all products before tax
            $prices_before_tax[] = Product::where('id', $request->products_id[$i])->first()->price_before_vat * $request->product_qty[$i];

            // for each vat -> get sum of difference between price before tax and final price
            $product = Product::where([['id', $request->products_id[$i]], ['vat', '!=', '0']])->first();
            if ($product != null) {
                $titles[] = 'vat ' . $product->vat . '%';
                $vat[] = round($product->price * $request->product_qty[$i] - $prices_before_tax[$i], 2);
            }
        }

        // adjust the values
        foreach ($titles as $key => $value) {
            if (isset($titles[$key + 1]) && $value == $titles[$key + 1]) {
                $vat[$key] = $vat[$key] + $vat[$key + 1];
                unset($titles[$key + 1]);
                unset($vat[$key + 1]);
            }
        }

        return response([
            'prices_before_tax' => round(array_sum($prices_before_tax), 2),
            'titles' => array_values($titles),
            'vat' => array_values($vat),
            'status' => 200
        ]);
    }


    public function ExistAllTicketRev()
    {
        $settings = GeneralSetting::first();
        $children_ids = TicketRevModel::where('status', '=', 'in')->whereDate('day', '<', Carbon::today()->format('Y-m-d'))->pluck('id');

        foreach ($children_ids as $id) {

            TicketRevModel::where('id', '=', $id)->update([
                'status' => 'out',
            ]);
        }
    }
    public function printInvoice($id)
    {
        $ticket = Ticket::with('products.product', 'client', 'shift')->findOrFail($id);
        $models = TicketRevModel::select('visitor_type_id',
            \DB::raw('SUM(total_after_discount) as total_after_discount'),
            \DB::raw('SUM(price) as price'),\DB::raw('COUNT(ticket_id) as ticket_count'))
            ->where('ticket_id', $id)
            ->groupBy('visitor_type_id')
            ->get();

        $date = Carbon::now()->format('h:i a');
        $product_ids = $ticket->products->pluck('product_id');
        $product_qty = $ticket->products->pluck('qty');
        for ($i = 0; $i < count($product_ids); $i++) {
            // get total prices of all products before tax
            $prices_before_tax[] = Product::where('id', $product_ids[$i])->first()->price_before_vat * $product_qty[$i];

            // for each vat -> get sum of difference between price before tax and final price
            $product = Product::where([['id', $product_ids[$i]], ['vat', '!=', '0']])->first();
            if ($product != null) {
                $titles[] = 'vat ' . $product->vat . '%';
                $vat[] = round($product->price * $product_qty[$i] - $prices_before_tax[$i], 2);
            }
        }

        // adjust the values
        if (isset($titles) > 0 && isset($vat) > 0) {
            foreach ($titles as $key => $value) {
                if (isset($titles[$key + 1]) && $value == $titles[$key + 1]) {
                    $vat[$key] = $vat[$key] + $vat[$key + 1];
                    unset($titles[$key + 1]);
                    unset($vat[$key + 1]);
                }
            }
            $titles = array_values($titles);
            $vat = array_values($vat);
            $sum = array_sum($prices_before_tax);
            return view('layouts.print.invoice', compact('ticket', 'titles', 'vat', 'sum', 'models', 'date'));
        }
        return view('layouts.print.invoice', compact('ticket', 'models', 'date'));
    }
}
