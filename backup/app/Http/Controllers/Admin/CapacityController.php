<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CapacityDays;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class CapacityController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    public function index(request $request)
    {
        if($request->ajax()) {
            $days = CapacityDays::latest()->get();
            return Datatables::of($days)
                ->addColumn('action', function ($days) {
                    if((Carbon::parse($days->day)->isPast()) && !Carbon::parse($days->day)->isToday())
                        return '<span class="badge badge-info br-7">Past Day</span>';
                    else
                        return '
                            <button type="button" data-id="' . $days->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                       ';
                })
                ->editColumn('status', function ($days) {
                    if($days->status == 0)
                        return '<span class="badge badge-danger br-7">Closed</span>';
                    else
                        return '<span class="badge badge-success br-7">Open</span>';
                })
                ->editColumn('day', function ($days) {
                    return '<span class="font-weight-semibold fs-15">'.$days->day.'</span>';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/capacity/index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CapacityDays $day
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $day = CapacityDays::where('id',$id)->first();
        return view('Admin/capacity.parts.edit',compact('day'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $inputs = $request->validate([
            'id'          => 'required',
            'count'       => "required",
        ]);
        ($request->status == 'on') ? $inputs['status'] = '1' : $inputs['status'] = '0';
        $day = CapacityDays::findOrFail($request->id);
        if($day->update($inputs))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
