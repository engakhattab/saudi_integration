<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShift;
use App\Models\ShiftDetails;
use App\Models\Shifts;
use App\Models\VisitorTypes;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TimingController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    public function index(request $request)
    {
        if ($request->ajax()) {
            $shifts = Shifts::latest()->get();
            return Datatables::of($shifts)
                ->addColumn('action', function ($shifts) {
                    return '
                            <button type="button" data-id="' . $shifts->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $shifts->id . '" data-title="' . date('h:i A', strtotime($shifts->from)) . ' To ' . date('h:i A', strtotime($shifts->to)) . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('from', function ($shifts) {
                    return date('h:i A', strtotime($shifts->from));
                })
                ->editColumn('to', function ($shifts) {
                    return date('h:i A', strtotime($shifts->to));
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin/timing/index');
        }
    }

    public function create()
    {
        $visitors = VisitorTypes::latest()->get();
        return view('Admin/timing.parts.create',compact('visitors'));
    }


    public function store(StoreShift $request)
    {
        $wanted_time = $request->from;
        $shifts      = Shifts::all();
        foreach ($shifts as $shift) {
            if ($wanted_time > $shift->from && $wanted_time < $shift->to) {
                return response()->json(['status' => 402]);
            }
        }
        $inputs = $request->except('_token','visitor_type_id','visitor_type_price');
        $myShift = Shifts::create($inputs);
        for ($i = 0 ; $i < count($request->visitor_type_id);$i++){
            ShiftDetails::create([
                'shift_id'        => $myShift->id,
                'visitor_type_id' => $request->visitor_type_id[$i],
                'price'           => $request->visitor_type_price[$i]
            ]);
        }
//        $myShift->visitors()->attach($request->visitor_type_id,['price'=>$request->visitor_type_price]);
        return response()->json(['status' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $shift = Shifts::findOrFail($id);
        $visitors = VisitorTypes::all();
        $details  = ShiftDetails::where('shift_id',$id)->get();
        return view('Admin/timing.parts.edit', compact('shift','details','visitors'));
    }

    public function update(StoreShift $request)
    {
        $myShift = Shifts::findOrFail($request->id);
        $inputs  = $request->except('_token','details_id','visitor_type_price');
        $wanted_time = $request->from;
        $shifts = Shifts::where('id','<>',$request->id);
        foreach ($shifts as $shift) {
            if ($wanted_time > $shift->from && $wanted_time < $shift->to) {
                return response()->json(['status' => 402]);
            }
        }
        // for($i = 0 ; $i < count($request->details_id) ; $i++){
        //     $detail = ShiftDetails::where('id',$request->details_id[$i])->first();
        //     $detail->price = $request->visitor_type_price[$i];
        //     $detail->save();
        // }
        if ($myShift->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
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

    public function delete(request $request)
    {
        $shift = Shifts::findOrFail($request->id);
        if(Shifts::all()->count() > 1){
            $shift->delete();
            return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
        }else
            return response(['message' => 'At Least 1 Shift Should Be Exist', 'status' => 405], 200);
    }
}
