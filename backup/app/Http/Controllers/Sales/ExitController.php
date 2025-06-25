<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Reservations;
use App\Models\Shifts;
use App\Models\Ticket;
use App\Models\TicketRevModel;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class ExitController extends Controller
{

    function __construct()
    {

        $this->middleware('permission:Exit');
    }

    public function index(Request $request)
    {
        $returnArray = [];
        $ticket = [];
        $models = [];
        $customId = [];
        $topUpPrice = 0;
        $t2 = 0;
        $t1 = 0;
        $hours = 0;
        $type = '';
        $customId = '';
        $phone = '';
        $name = '';

        if ($request->has('search')) {


            $ticket = Ticket::where(function ($query_all) use ($request) {
                $query_all->WhereHas('client', function ($query) use ($request) {
                    $query->where('phone', $request->search);
                })->whereHas('in_models', function ($query) use ($request) {
                    $query->where('status', 'in');
                })
                    ->orwhere('ticket_num', $request->search)
                    ->orWhereHas('in_models', function ($query) use ($request) {
                        $query->where('bracelet_number', $request->search);
                    });
            })
                ->with('in_models.type', 'client');

            if ($ticket->count() == 0) {
                $ticket = Reservations::whereHas('in_models', function ($query) use ($request) {
                        $query->where('status', 'in');
                    })
                    ->where(function ($query) use ($request) {
                        $query->where('custom_id', $request->search)
                            ->orWhereHas('in_models', function ($query) use ($request) {
                                $query->where('bracelet_number', $request->search);
                            })

                            ->orWhere('phone', $request->search);
                    })


                    ->with('in_models.type');
                $type = 'rev';
            } else {
                $type = 'ticket';
            }



            $customId = $ticket->first()->ticket_num ?? $ticket->first()->custom_id ?? '';
            $phone = $ticket->first()->client->phone ?? $ticket->first()->phone ?? '';
            $name = $ticket->first()->client->name ?? $ticket->first()->client_name ?? '';


            $returnArray = [];

            if ($ticket->count() > 0) {

                foreach ($ticket->first()->in_models as $key => $model) {
                    $actions = view('sales.layouts.exit.actions', compact('model', 'key'));


                    $returnArray[$model->id] = "$actions";
                    $t1 = strtotime($model->shift_end);
                    $t2 = strtotime(date('H:i:s'));
                    // case there is no top up
                    if ($model->shift_end == $model->shift_start)
                        $t1 = $t2;
                }
                $ticket = $ticket->first();
                $models = $ticket->in_models ?? [];
            }
        }
        // case there is top up then get the hours
        if ($t2 > $t1) {
            $hours = round(($t2 - $t1) / 3600);
        }

        //        return $models;
        if ($request->has('search'))
            count($models) ? '' : toastr()->warning('there is no data');
        return view('sales.exit', compact('ticket', 'returnArray', 'name', 'type', 'models', 'customId', 'phone', 'hours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = base64_decode($id);
        $model = TicketRevModel::findOrFail($id);
        $data['status'] = 'out';
        $model->update($data);

        if ($model->rev_id != '') {
            $ticket = Reservations::findOrFail($model->rev_id);
            $models = TicketRevModel::where('rev_id', $ticket->id)->where('status', 'in');
        } elseif ($model->ticket_id != '') {
            $ticket = Ticket::findOrFail($model->ticket_id);
            $models = TicketRevModel::where('ticket_id', $ticket->id)->where('status', 'in');
        } else {
            toastr()->info('not found');
            return back();
        }


        if (!$models->count()) {
            $ticket->update($data);
        }

        toastr()->success('Group exit successfully');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket_rev_model = TicketRevModel::findOrFail($id);
        return view('sales.layouts.exit.topup', compact('id'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'temp_status' => 'nullable|in:in,out',
            'top_up_hours' => 'nullable|numeric'
        ]);
        $model = TicketRevModel::findOrFail($id);
        $printUrl = '';

        if ($model->shift_end <= '24:00:00') {
            $formatted_end = Carbon::createFromFormat('H:i:s', $model->shift_end)->format('h:i A'); // Format as 12-hour time if end time is before or equal to 24:00:00
        } else {
            $formatted_end = Carbon::createFromFormat('H:i:s', $model->shift_end)->subDay()->format('h:i A'); // Format as 12-hour time if end time is after 24:00:00
        }


        $model->shift_end = $formatted_end;

        // dd($formatted_end);



        if ($model->rev_id != '')
            $ticket = Reservations::findOrFail($model->rev_id);
        elseif ($model->ticket_id != '')

            $ticket = Ticket::findOrFail($model->ticket_id);


        if ($request->has('top_up_hours')) {
            $shift = Shifts::where(function ($query) use ($model) {
                $query->where('from', '<=', $model->shift_end);
                $query->where('to', '>=', $model->shift_end);
            });
            if (!$shift->count()) {
                toastr()->warning('we can`t find the next shift');
                return back();
            }

            $method = [];
            $method['visit_date'] = date('Y-m-d');
            $method['hours_count'] = $data['top_up_hours'];
            $method['shift_id'] = $shift->first()->id;
            $method['old_hours'] = $ticket->hours_count;
            $response = Http::get(route('visitorTypesPrices'), $method);
            $top_up_hours = $request->top_up_hours - $response['latestHours'];
            $data['top_up_hours'] = $top_up_hours + $model->top_up_hours;
            $price = $response['array'][$model->visitor_type_id];
            $data['top_up_price'] = $price + $model->top_up_price;
            $model->shift_end = Carbon::parse($model->shift_end)->addHours($data['top_up_hours']);
            $model->save();

            //start increment payment

            $ticket->payments()->create([
                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => ($price * 1.15),
                'payment_method' => $request->pay
            ]);

            $ticket->total_top_up_hours =  $top_up_hours;
            $ticket->total_top_up_price += $price;
            $ticket->vat +=  ($price)  * (15 / 100);
            $ticket->grand_total +=  ($price * 1.15);
            $ticket->paid_amount += ($price * 1.15);
            $ticket->total_price += ($price * 1.15);
            $ticket->save();

            toastr()->success('top up stored successfully');
        }

        TicketRevModel::findOrFail($id)->update($data);

        if ($model->rev_id != '')
            $printUrl = route('reservations.show', $ticket->id);
        elseif ($model->ticket_id != '')
            $printUrl = route('ticket.edit', $ticket->id);


        return response()->json(['status' => 200, 'url' => $printUrl]);
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
    public function all($search)
    {
        $ticket = Ticket::where('ticket_num', $search)
            ->orWhereHas('client', function ($query) use ($search) {
                $query->where('phone', $search);
            })
            ->orWhereHas('in_models', function ($query) use ($search) {
                $query->where('bracelet_number', $search);
            })
            ->with('in_models.type')
            ->where('visit_date', date('Y-m-d'));

        if ($ticket->count() == 0) {
            $ticket = Reservations::whereHas('in_models')
                ->where('custom_id', $search)
                ->orWhereHas('in_models', function ($query) use ($search) {
                    $query->where('bracelet_number', $search);
                })
                ->orWhere('phone', $search)
                ->with('in_models.type')
                ->where('day', date('Y-m-d'));
        }
        if ($ticket->count() == 0) {
            toastr()->info('not found');
            return back();
        }
        foreach ($ticket->first()->in_models as $model) {
            $data['status'] = 'out';
            $model->update($data);

            if ($model->rev_id != '') {
                $ticket = Reservations::findOrFail($model->rev_id);
                $models = TicketRevModel::where('rev_id', $ticket->id)->where('status', 'in');
            } elseif ($model->ticket_id != '') {
                $ticket = Ticket::findOrFail($model->ticket_id);
                $models = TicketRevModel::where('ticket_id', $ticket->id)->where('status', 'in');
            } else {
                toastr()->info('not found');
                return back();
            }


            if (!$models->count()) {
                $ticket->update($data);
            }
        }
        toastr()->success('Group exit successfully');
        return redirect('capacity?month=' . date('Y-m'));
    }

    public function showTopDown($id)
    {
        $ticket_rev_model = TicketRevModel::findOrFail($id);

        $hours = (int)$ticket_rev_model->shift_end - (int)date('H');
        $diff  = (int)$ticket_rev_model->shift_end - (int)$ticket_rev_model->shift_start;

        //        return $hours.'--'.$diff;

        //        if($hours != 0){
        return view('sales.layouts.exit.topdown', compact('id', 'hours', 'diff'));
        //        }

    }

    public function topDown(Request $request, $id)
    {

        $data = $request->validate([
            'top_down_hours' => 'nullable|numeric'
        ]);
        $model = TicketRevModel::findOrFail($id);

        if ($model->rev_id != '')
            $ticket = Reservations::findOrFail($model->rev_id);
        elseif ($model->ticket_id != '')
            $ticket = Ticket::findOrFail($model->ticket_id);

        $models_count = $ticket->models->where('visitor_type_id', $model->visitor_type_id)->count();

        if ($request->top_down_hours == 1 && $ticket->hours_count == 2) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total = $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $model->total_after_discount = $model->price - (100 *  $ticket->discount_value) / $ticket->total_price * ($model->price / 100);

                $total_of_down_price = $price_of_one;
            } //end ---

            $ticket->returns()->create([
                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' =>  $model->type['2_hours'] -  $model->type['1_hours'],
                'payment_method' => $request->pay,
            ]);



            $price_of_one = $model->type['2_hours'] -  $model->type['1_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);
            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 1 && $ticket->hours_count == 3) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            }

            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' =>  $model->type['3_hours'] -  $model->type['2_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['3_hours'] -  $model->type['2_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);


            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 2 && $ticket->hours_count == 3) {


            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {


                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            }

            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $model->type['3_hours'] -  $model->type['1_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['3_hours'] -  $model->type['1_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);

            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 1 && $ticket->hours_count == 4) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);
                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            }

            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $model->type['4_hours'] -  $model->type['3_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['4_hours'] -  $model->type['3_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);

            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 2 && $ticket->hours_count == 4) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            } //end of per 8


            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $model->type['4_hours'] -  $model->type['2_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['4_hours'] -  $model->type['2_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);

            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 3 && $ticket->hours_count == 4) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            } //end of per 9

            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $model->type['4_hours'] -  $model->type['1_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['4_hours'] -  $model->type['1_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);

            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 1 && $ticket->hours_count == 5) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            } //end of per 10


            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $model->type['5_hours'] -  $model->type['4_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['5_hours'] -  $model->type['4_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);

            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 2 && $ticket->hours_count == 5) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            } //end of per

            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $model->type['5_hours'] -  $model->type['3_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['5_hours'] -  $model->type['3_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);

            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;
        } elseif ($request->top_down_hours == 3 && $ticket->hours_count == 5) {

            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([

                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))),
                    'payment_method' => $request->pay,

                ]);

                $price_of_one =  $ticket->grand_total - ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  $price_of_one;
                $ticket->paid_amount =  $price_of_one;
                $ticket->total_price =  $price_of_one;
                $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total / 1.15);
                $ticket->vat = $ticket->grand_total == 0 ? 0 : $ticket->grand_total - $ticket->ticket_price;
                $model->price = 0;
                $total_of_down_price = $price_of_one;
            }

            $ticket->returns()->create([

                'ticket_id' => $ticket->id,
                'cashier_id' => auth()->user()->id,
                'day' => Carbon::now()->format('Y-m-d'),
                'amount' => $model->type['5_hours'] -  $model->type['2_hours'],
                'payment_method' => $request->pay,

            ]);

            $price_of_one = $model->type['5_hours'] -  $model->type['2_hours'];
            $ticket->grand_total =  ($ticket->grand_total -   $price_of_one);
            $ticket->paid_amount = ($ticket->paid_amount -   $price_of_one);
            $ticket->total_price = ($ticket->total_price -   $price_of_one);
            $ticket->ticket_price = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total)  / 1.15;
            $ticket->vat = $ticket->grand_total == 0 ? 0 : ($ticket->grand_total - $ticket->ticket_price);

            $total_of_down_price = $price_of_one;
            $ticket->total_top_down_price += $total_of_down_price;


            //========================================================================================================================================

        } elseif ($request->top_down_hours == 1 && $ticket->hours_count == 1) {

            //start topdown of ticket
            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))), //done
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  ($ticket->grand_total - ($model->price - ($model->price * ($ticket->discount_value / 100)))); //done
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->ticket_price = ($ticket->grand_total / 1.15);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            } elseif ($ticket->discount_value == 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price),
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = $model->price;
                $ticket->ticket_price = ($ticket->ticket_price - ($model->price / 1.15)); //done
                $ticket->grand_total =  ($ticket->grand_total - $model->price);
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            }

            //end topdown of ticket

        } elseif ($request->top_down_hours == 2 && $ticket->hours_count == 2) {

            //start topdown of ticket
            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))), //done
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  ($ticket->grand_total - ($model->price - ($model->price * ($ticket->discount_value / 100)))); //done
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->ticket_price = ($ticket->grand_total / 1.15);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            } elseif ($ticket->discount_value == 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price),
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = $model->price;
                $ticket->ticket_price = ($ticket->ticket_price - ($model->price / 1.15)); //done
                $ticket->grand_total =  ($ticket->grand_total - $model->price);
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            }

            //end topdown of ticket

        } elseif ($request->top_down_hours == 3 && $ticket->hours_count == 3) {

            //start topdown of ticket
            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))), //done
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  ($ticket->grand_total - ($model->price - ($model->price * ($ticket->discount_value / 100)))); //done
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->ticket_price = ($ticket->grand_total / 1.15);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            } elseif ($ticket->discount_value == 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price),
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = $model->price;
                $ticket->ticket_price = ($ticket->ticket_price - ($model->price / 1.15)); //done
                $ticket->grand_total =  ($ticket->grand_total - $model->price);
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            }

            //end topdown of ticket

        } elseif ($request->top_down_hours == 4 && $ticket->hours_count == 4) {

            //start topdown of ticket
            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))), //done
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  ($ticket->grand_total - ($model->price - ($model->price * ($ticket->discount_value / 100)))); //done
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->ticket_price = ($ticket->grand_total / 1.15);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            } elseif ($ticket->discount_value == 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price),
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = $model->price;
                $ticket->ticket_price = ($ticket->ticket_price - ($model->price / 1.15)); //done
                $ticket->grand_total =  ($ticket->grand_total - $model->price);
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            }

            //end topdown of ticket
        } elseif ($request->top_down_hours == 5 && $ticket->hours_count == 5) {
            //start topdown of ticket
            if ($ticket->discount_value != 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price - ($model->price * (1 / $ticket->discount_value))), //done
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = ($model->price - ($model->price * (1 / $ticket->discount_value)));
                $ticket->grand_total =  ($ticket->grand_total - ($model->price - ($model->price * ($ticket->discount_value / 100)))); //done
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->ticket_price = ($ticket->grand_total / 1.15);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            } elseif ($ticket->discount_value == 0 && $ticket->discount_type == 'per') {

                $ticket->returns()->create([
                    'ticket_id' => $ticket->id,
                    'cashier_id' => auth()->user()->id,
                    'day' => Carbon::now()->format('Y-m-d'),
                    'amount' => ($model->price),
                    'payment_method' => $request->pay,
                ]);

                $ticket->total_top_down_price = $model->price;
                $ticket->ticket_price = ($ticket->ticket_price - ($model->price / 1.15)); //done
                $ticket->grand_total =  ($ticket->grand_total - $model->price);
                $ticket->paid_amount = ($ticket->grand_total);
                $ticket->vat = ($ticket->grand_total - $ticket->ticket_price);
                $ticket->total_price =  $ticket->total_price - $model->price; //done
                $model->price = 0;
                $model->total_after_discount = 0;
            }

            //end topdown of ticket

        }

        $model->shift_end    = Carbon::parse($model->shift_end)->subHours($data['top_down_hours']);
        $model->top_up_hours -= $data['top_down_hours'];
        if ($model->top_up_hours < 0)
            $model->top_up_hours = 0;

        // check if cancel
        if ($model->shift_start ==  $model->shift_end) {
            $model->status = 'out';
            $model->bracelet_number = null;
        }



        $ticket->save();

        $model->save();

        // check if all models canceled then mark the ticket as not paid
        if ($ticket->grand_total == 0) {
            $ticket->update([
                'payment_status'  => '0',
            ]);
        }

        toastr()->success('top Down Done successfully');

        return response()->json(['status' => 200]);
    }
}
