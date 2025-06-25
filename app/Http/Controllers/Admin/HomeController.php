<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\GeneralSetting;
use App\Models\Reservations;
use App\Models\Ticket;
use App\Models\TicketRevProducts;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
{
    $this->middleware('adminPermission:Branch Admin');
}
    public function index(){
        $todayTickets  = Ticket::whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('created_at','<=',  Carbon::now()->format('Y-m-d 02:00:00'))->get();
        $todayProducts = TicketRevProducts::whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('created_at','<=',  Carbon::now()->format('Y-m-d 02:00:00'))->get();
        $reservations = Reservations::whereDate('created_at', Carbon::now()->format('Y-m-d'))->where('created_at','<=',  Carbon::now()->format('Y-m-d 02:00:00'))->get();
        foreach ($todayTickets as $tic){
            $tic->update([
                'created_at' => Carbon::now()->subDay()->format('Y-m-d 23:59:00'),
            ]);
        }
        foreach ($todayProducts as $pro){
            $pro->update([
                'created_at' => Carbon::now()->subDay()->format('Y-m-d 23:59:00'),
            ]);
        }
        foreach ($reservations as $rev){
            $rev->update([
                'created_at' => Carbon::now()->subDay()->format('Y-m-d 23:59:00'),
            ]);
        }

        $product_sold          = TicketRevProducts::whereDate('created_at', Carbon::today())->pluck('total_price')->sum();
        $tickets_sales_profit  = Ticket::whereDate('created_at', Carbon::today())->pluck('grand_total')->sum();
        $rev_sales_profit      = Reservations::whereDate('created_at', Carbon::today())->pluck('grand_total')->sum();
        $new_clients           = Clients::whereDate('created_at', Carbon::today())->get()->count();
        $all_clients           = Clients::all()->count();
        $total_sales_today     = Ticket::whereDate('created_at', Carbon::today())->pluck('grand_total')->sum() + Reservations::whereDate('created_at', Carbon::today())->pluck('grand_total')->sum();
        $new_customers         = Clients::OrderBy('created_at', 'DESC')->take(7)->get();
        $latest_products       = TicketRevProducts::OrderBy('created_at', 'DESC')->take(6)->get();
        $exit_time             = date('Y-m-d').' '.GeneralSetting::first()->exit_time;
        $current_date          = date('Y-m-d H:i:s');
       /* if($exit_time < $current_date){
        $tickets      = Ticket::whereDate([['visit_date','<',$exit_time],['status','in']])->get();
        $reservations = Reservations::whereDate([['day','<',$exit_time],['status','in']])->get();
            foreach ($tickets as $ticket){
                foreach ($ticket->models as $model){
                    $model->update([
                       'temp_status' => 'out',
                       'status'      => 'out',
                       'bracelet_number' => null
                    ]);
                }
                $ticket->update([
                   'status' => 'out',
                ]);
            }
            foreach ($reservations as $reservation){
                foreach ($reservation->models as $model){
                    $model->update([
                        'temp_status' => 'out',
                        'status'      => 'out',
                        'bracelet_number' => null
                    ]);
                }
                $reservation->update([
                    'status' => 'out',
                ]);
            }
        }*/
        return view('Admin.index',compact('product_sold','latest_products','new_customers','total_sales_today','tickets_sales_profit','rev_sales_profit','new_clients','all_clients'));
    }
}
