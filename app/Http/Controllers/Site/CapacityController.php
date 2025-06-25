<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\CapacityDays;
use App\Models\Category;
use App\Models\Clients;
use App\Models\DiscountReason;
use App\Models\Event;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\Reservations;
use App\Models\ShiftDetails;
use App\Models\Shifts;
use App\Models\Ticket;
use App\Models\TicketRevModel;
use App\Models\TicketRevProducts;
use App\Models\User;
use App\Models\VisitorTypes;
use Carbon\Traits\Date;
use DateTime;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ramsey\Uuid\Type\Integer;
class CapacityController extends Controller
{
    public function createCapacity()
    {
        $shifts = Shifts::all();
        $first_shift_start = Carbon::parse(Shifts::orderBy('from', 'ASC')->first()->from)->format('H');
        $types = VisitorTypes::all();
        $categories = Category::with(['products' => function ($query) {
            $query->where('status', '1');
        }])
            ->whereHas('products', function ($q) {
                $q->where('status', '1');
            })
            ->get();
        $customId = strtoupper(date('D') . 'WebSite' . substr(time(), -2));
        $discounts = DiscountReason::all();
        $random = strtoupper(substr(Carbon::now()->format("l"), 0, 3) . 'WebSite' . rand(0, 99) . Carbon::now()->format('is'));
        return view('site/book-stay', compact('first_shift_start','discounts', 'customId', 'shifts', 'random', 'types', 'categories'));
    }//end fun

    public function storeTicket(Request $request)
    {
        if($request->rem == 0)
            $status = '1';
        else
            $status = '0';
        $ticket = Ticket::create([
            'visit_date'     => $request->visit_date,
            'shift_id'       => $request->shift_id,
            'hours_count'    => $request->duration,
            'ticket_price'   => $request->ticket_price,
            'ent_tax'        => $request->ent_tax,
            'client_id'        => $request->client_id,
            'vat'            => $request->vat,
            'total_price'    => $request->total_price,
            'ticket_num'     => $request->rand_ticket,
            'paid_amount'    => $request->amount,
            'grand_total'    => $request->revenue,
            'rem_amount'     => $request->rem,
            'payment_method' => $request->payment_method,
            'payment_status' => $status,
        ]);
        for ($i = 0; $i < count($request->visitor_type); $i++) {
            TicketRevModel::create([
                'ticket_id' => $ticket->id,
                'shift_start' => $request->shift_start.':00'.':00',
                'shift_end' => $request->shift_end.':00'.':00',
                'visitor_type_id' => $request->visitor_type[$i],
                'day' => $request->visit_date,
                'price' => $request->visitor_price[$i],
                'name' => $request->visitor_name[$i],
                'birthday' => $request->visitor_birthday[$i],
                'gender' => $request->gender[$i],
                'status'=>'append'
            ]);
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
        $accessUrl    = route('familyAccess.index').'?search='.$ticket->ticket_num;
        $printUrl     = route('printTicket',$ticket->id);
        return response()->json([
            'status' => true,
            'accessUrl' => $accessUrl,
            'printUrl'  => $printUrl,
        ]);
    }//end fun

}//end class
