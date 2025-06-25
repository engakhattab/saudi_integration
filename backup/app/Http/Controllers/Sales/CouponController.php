<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Governorate;
use App\Models\Reservations;
use App\Models\TicketRevModel;
use App\Models\VisitorTypes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CouponController extends Controller
{

    function __construct()
    {

        $this->middleware('permission:Corporations');

    }

    public function index()
    {
        $now = date('Y-m-d');
        $reservations = Reservations::where('is_coupon', '1')
            ->where('coupon_start', '<=', $now)
            ->where('coupon_end', '>=', $now)->latest()->paginate(10);
        $governorates = Governorate::with('cities')->get();
        return view('sales/coupon', compact('reservations','governorates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'coupon_start' => 'required|date_format:Y-m-d|after:yesterday',
            'coupon_end' => 'required|date_format:Y-m-d|after:coupon_start',
            'client_name' => 'required|string|max:500',
            'hours_count' => 'required',
        ], [
            'coupon_end.after' => 'Coupon End Date Should Be After Start Date'
        ]);
        $rev = Reservations::create([
            'add_by'         => auth()->user()->id,
            'client_name' => $request->client_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'ticket_num' => strtoupper(date('D') . rand(0, 9999) . 'Co' . substr(time(), -2)),
            'paid_amount' => $request->paid_amount,
            'is_coupon' => '1',
            'payment_status' => '1',
            'hours_count' => $request->hours_count,
            'coupon_start' => $request->coupon_start,
            'coupon_end' => $request->coupon_end,
            'event_id' => '2',
            'note' => $request->note,
            'building'=> $request->building,
            'street'=> $request->street,
            'district'=> $request->district,
            'address'=> $request->address,
            'vat_num'=> $request->vat_num,
            'zip'=> $request->zip,
            'gov_id'=>$request->gov_id,
            'city_id'=>$request->city_id,
            'day' => $request->day
        ]);
        for ($i = 0; $i < $request->visitor_count; $i++) {
            TicketRevModel::create([
                'rev_id' => $rev->id,
                'coupon_num' => strtoupper(date('D') . rand(0, 9999) . 'Co' . substr(time(), -2))
            ]);
        }
        return response()->json(['status' => 200]);
    }


    public function show($id)
    {
        $rev = Reservations::where('is_coupon', '1')->where('id', $id)->first();
        $types = VisitorTypes::all();
        if (!$rev) {
            abort(404);
        }
        return view('sales/coupon-details', compact('rev','types'));
    }


    public function edit($id)
    {
        $rev = Reservations::findOrFail($id);
        $governorates = Governorate::with('cities')->get();
        return view('sales/layouts.coupons.edit', compact('rev','governorates'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'coupon_start' => 'required|date_format:Y-m-d',
            'coupon_end' => 'required|date_format:Y-m-d|after:coupon_start',
            'client_name' => 'required|string|max:500',
            'hours_count' => 'required',
        ], [
            'coupon_end.after' => 'Coupon End Date Should Be After Start Date'
        ]);
        $rev = Reservations::findOrFail($request->id);
        $rev->update([
            'client_name' => $request->client_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'paid_amount' => $request->paid_amount,
            'is_coupon' => '1',
            'hours_count' => $request->hours_count,
            'coupon_start' => $request->coupon_start,
            'coupon_end' => $request->coupon_end,
            'event_id' => '2',
            'note' => $request->note,
            'building'=> $request->building,
            'street'=> $request->street,
            'district'=> $request->district,
            'address'=> $request->address,
            'vat_num'=> $request->vat_num,
            'zip'=> $request->zip,
            'gov_id'=>$request->gov_id,
            'city_id'=>$request->city_id,
            'day' => $request->day
        ]);
         if(!str_contains($_SERVER['HTTP_HOST'],"localhost") && $_SERVER['HTTP_HOST'] != '127.0.0.1:8000')
           $rev->update(['uploaded' => true]);
        return response()->json(['status' => 200]);
    }


    public function destroy($id)
    {
        //
    }

    public function delete(request $request)
    {
        $rev = Reservations::findOrFail($request->id);
        $models = TicketRevModel::where('rev_id', $rev->id)->get();
        foreach ($models as $model) {
            $model->delete();
        }
        $rev->delete();
        return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
    }

    public function deleteVisitor(request $request)
    {
        TicketRevModel::findOrFail($request->id)->delete();
        return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
    }


    public function storeCouponsVisitor(request $request)
    {
        $request->validate([
            'rev_id' => 'required',
        ]);
        TicketRevModel::create([
            'rev_id' => $request->rev_id,
            'name' => $request->name,
            'coupon_num' => strtoupper(date('D') . rand(0, 999) . $request->rev_id . 'Co' . substr(time(), -2)),
            'visitor_type_id' => $request->visitor_type_id,
        ]);
        return response()->json(['status' => 200]);
    }

    public function EditCouponsVisitor($model_id)
    {
        $types = VisitorTypes::all();
        $model = TicketRevModel::findOrFail($model_id);
        return view('Admin/coupons.parts.editVisitor', compact('model', 'types'));
    }

    public function updateCouponsVisitor(request $request)
    {
        $request->validate([
            'model_id' => 'required',
        ]);
        $model = TicketRevModel::findOrFail($request->model_id);
        $model->update([
            'name' => $request->name,
            'visitor_type_id' => $request->visitor_type_id,
        ]);
        return response()->json(['status' => 200]);
    }

    public function print($id)
    {
        $model = TicketRevModel::findOrFail($id);
        $rev = Reservations::where('id', $model->rev_id)->first();
        $date = Carbon::now();
        return view('layouts.print.model', compact('model', 'date', 'rev'));
    }
}
