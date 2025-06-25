<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Reservations;
use App\Models\TicketRevProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        if (Auth::guard('admin')->check()){
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
            return redirect('admin');
        }
        return view('Admin.auth.login');
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'email'   =>'required|exists:admins',
            'password'=>'required'
        ]);
        if (Auth::guard('admin')->attempt($data)){
            return response()->json(200);
        }
        return response()->json(405);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        toastr()->info('logged out successfully');
        return redirect('admin/login');
    }
}
