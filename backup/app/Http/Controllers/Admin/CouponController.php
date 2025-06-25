<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Reservations;
use App\Models\TicketRevModel;
use App\Models\VisitorTypes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CouponController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }

    public function index(request $request)
    {
        if($request->ajax()) {
            $coupons = Reservations::where('is_coupon','1')->get();
            return Datatables::of($coupons)
                ->addColumn('action', function ($coupons) {
                    return '
                            <button type="button" data-id="' . $coupons->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $coupons->id . '" data-title="' . $coupons->client_name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('coupon_start', function ($coupons) {
                    return $coupons->coupon_start;
                })
                ->editColumn('coupon_end', function ($coupons) {
                    return $coupons->coupon_end;
                })
                ->editColumn('note', function ($coupons) {
                    return ($coupons->note) ?? '<span class="text-gray">No Notes</span>';
                })
                ->addColumn('view', function ($coupons) {
                    $count = TicketRevModel::where('rev_id',$coupons->id)->count();
                    $url = route('couponsVisitors',$coupons->id);
                    if($count > 0)
                        return '<a href="' . $url . '" class="btn btn-pill btn-success">View All</a>';
                    else
                        return '<a href="' . $url . '" class="btn btn-pill btn-success">Add Visitor</a>';

                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/coupons/index');
        }
    }



    public function create()
    {
        return view('Admin/coupons.parts.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'coupon_start'  => 'required|date_format:Y-m-d|after:yesterday',
            'coupon_end'    => 'required|date_format:Y-m-d|after:coupon_start',
            'client_name'   => 'required|string|max:500',
            'hours_count'   => 'required',
        ],[
            'coupon_end.after' => 'Coupon End Date Should Be After Start Date'
        ]);
        $rand = strtoupper(date('D').rand(0,9999).'Co'.substr(time(), -2));
        $rev = Reservations::create([
            'add_by'        => 0,
            'client_name'   => $request->client_name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'ticket_num'    => $rand,
            'custom_id'     => $rand,
            'paid_amount'   => $request->paid_amount,
            'is_coupon'     => '1',
            'hours_count'   => $request->hours_count,
            'coupon_start'  => $request->coupon_start,
            'coupon_end'    => $request->coupon_end,
            'event_id'      => '2',
            'note'          => $request->note,
        ]);
        for ($i = 0 ; $i < $request->visitor_count; $i++){
            TicketRevModel::create([
               'rev_id'      => $rev->id,
                'coupon_num' => strtoupper(date('D').rand(0,9999).'Co'.substr(time(), -2))
            ]);
        }
        return response()->json(['status'=>200]);
    }



    public function show(request $request,$id)
    {
        if($request->ajax()) {
            $models = TicketRevModel::where('rev_id',$id)->get();
            return Datatables::of($models)
                ->addColumn('action', function ($models) {
                    return '
                            <button type="button" data-id="' . $models->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button type="button" data-url="'.route("printCoupon",$models->id).'" data-id="' . $models->id . '" class="btn btn-pill btn-default-light" title="Print" id="print"><i class="fa fa-print"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $models->id . '" data-title="' . $models->coupon_num . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('name', function ($models) {
                    return ($models->name) ?? ' ';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            $rev = Reservations::where('is_coupon','1')->where('id',$id)->first();
            if(!$rev){
                abort(404);
            }
            return view('Admin/coupons/visitors',compact('rev'));
        }
    }



    public function edit($id)
    {
        $rev = Reservations::findOrFail($id);
        return view('Admin/coupons.parts.edit',compact('rev'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'coupon_start'  => 'required|date_format:Y-m-d|after:yesterday',
            'coupon_end'    => 'required|date_format:Y-m-d|after:coupon_start',
            'client_name'   => 'required|string|max:500',
            'hours_count'   => 'required',
        ],[
            'coupon_end.after' => 'Coupon End Date Should Be After Start Date'
        ]);
        $rev = Reservations::findOrFail($request->id);
        $rev->update([
            'client_name'   => $request->client_name,
            'phone'         => $request->phone,
            'email'         => $request->email,
            'paid_amount'   => $request->paid_amount,
            'is_coupon'     => '1',
            'hours_count'   => $request->hours_count,
            'coupon_start'  => $request->coupon_start,
            'coupon_end'    => $request->coupon_end,
            'event_id'      => '2',
            'note'          => $request->note,
        ]);
        return response()->json(['status'=>200]);
    }



    public function destroy($id)
    {
        //
    }

    public function delete(request $request){
        $rev = Reservations::findOrFail($request->id);
        $models = TicketRevModel::where('rev_id',$rev->id)->get();
        foreach ($models as $model){
            $model->delete();
        }
        $rev->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }

    public function deleteVisitor(request $request){
        TicketRevModel::findOrFail($request->id)->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }

    public function addVisitor($id){
        return view('Admin/coupons.parts.createVisitor',compact('id'));
    }

    public function AddCouponsVisitor($id){
        $types = VisitorTypes::all();
        return view('Admin/coupons.parts.addVisitor',compact('id','types'));
    }

    public function storeCouponsVisitor(request $request){
        $request->validate([
            'rev_id'  => 'required',
        ]);
        TicketRevModel::create([
            'rev_id'            => $request->rev_id,
            'name'              => $request->name,
            'coupon_num'        => strtoupper(date('D').rand(0,999).$request->rev_id.'Co'.substr(time(), -2)),
            'visitor_type_id'   => $request->visitor_type_id,
        ]);
        return response()->json(['status'=>200]);
    }

    public function EditCouponsVisitor($model_id){
        $types = VisitorTypes::all();
        $model = TicketRevModel::findOrFail($model_id);
        return view('Admin/coupons.parts.editVisitor',compact('model','types'));
    }

    public function updateCouponsVisitor(request $request){
        $request->validate([
            'model_id'  => 'required',
        ]);
        $model = TicketRevModel::findOrFail($request->model_id);
        $model->update([
            'name'              => $request->name,
            'visitor_type_id'   => $request->visitor_type_id,
        ]);
        return response()->json(['status'=>200]);
    }

    public function print($id){
            $model = TicketRevModel::findOrFail($id);
            $rev   = Reservations::where('id',$model->rev_id)->first();
            $date  = Carbon::now();
            return view('layouts.print.model',compact('model','date','rev'));
    }
}
