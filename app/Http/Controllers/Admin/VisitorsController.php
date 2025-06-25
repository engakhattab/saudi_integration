<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShiftDetails;
use App\Models\Shifts;
use App\Models\Event;
use App\Models\TopUpPrice;
use App\Models\VisitorTypes;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VisitorsController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }

    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $visitors = VisitorTypes::latest()->with('event')->get();
            return Datatables::of($visitors)
                ->addColumn('action', function ($visitors) {
                    return '
                            <button type="button" data-id="' . $visitors->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $visitors->id . '" data-title="' . $visitors->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('photo', function ($visitors) {
                    return '
                    <img alt="Visitor" onclick="window.open(this.src)" style="cursor:pointer" class="avatar avatar-lg bradius cover-image" src="'.get_user_photo($visitors->photo).'">
                    ';
                })
                
                ->editColumn('status', function ($visitors) {
                    if($visitors->status == 0)
                        return '<span class="badge badge-danger br-7">inactive</span>';
                    else
                        return '<span class="badge badge-success br-7">active</span>';
                })
                ->editColumn('event', function ($visitors) {
                   $text = $visitors->event->title??'Family';

                   return $text;

                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/visitors/index');
        }
    }


    public function create()
    {
//        $shifts = Shifts::all();
        $events = Event::all();
        return view('Admin/visitors.parts.create',compact('events'));
    }

    public function store(request $request)
    {
        $request->validate([
            'photo'      => 'required|mimes:jpeg,jpg,png,gif',
            'title'      => 'required|max:255',
            'event_id'         => 'required',
        ]);
        ($request->status == 'on') ? $request['status'] = '1' : $request['status'] = '0';
        $visitorData = $request->except('_token','top_1_hours','top_2_hours','top_3_hours','top_4_hours','top_5_hours','top_6_hours','top_7_hours','top_8_hours','top_9_hours','top_10_hours');
        if($request->has('photo')){
            $file_name = $this->saveImage($request->photo,'assets/uploads/visitors');
            $visitorData['photo'] = 'assets/uploads/visitors/'.$file_name;
        }
        $visitor = VisitorTypes::create($visitorData);
        if($visitor){
            TopUpPrice::create([
                'type_id' => $visitor->id,
                '1_hours' => $request->top_1_hours,
                '2_hours' => $request->top_2_hours,
                '3_hours' => $request->top_3_hours,
                '4_hours' => $request->top_4_hours,
                '5_hours' => $request->top_5_hours,
                '6_hours' => $request->top_6_hours,
                '7_hours' => $request->top_7_hours,
                '8_hours' => $request->top_8_hours,
                '9_hours' => $request->top_9_hours,
                '10_hours' => $request->top_10_hours,

            ]);
//            for($i = 0 ; $i < count($request->shifts_id); $i++){
//                ShiftDetails::create([
//                    'visitor_type_id' => $visitor->id,
//                    'shift_id' => $request->shifts_id[$i],
//                    'price'    => $request->price[$i],
//                ]);
//            }
            return response()->json(['status'=>200]);
        }
        else
            return response()->json(['status'=>405]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }



    public function edit($id)
    {
        $visitor = VisitorTypes::findOrFail($id);
        $events = Event::all();
//        $details = ShiftDetails::where('visitor_type_id',$id)->get();
        return view('Admin/visitors.parts.edit',compact('visitor','events'));
    }



    public function update(Request $request)
    {
        $request->validate([
            'event_id'         => 'required',
            'id'         => 'required',
            'photo'      => 'nullable|mimes:jpeg,jpg,png,gif',
            'title'      => 'required|max:255',
        ]);
        $request['status'] = ($request->status == 'on') ? '1' : '0';
        $visitorData = $request->except('_token','top_1_hours','top_2_hours','top_3_hours','top_4_hours','top_5_hours','top_6_hours','top_7_hours','top_8_hours','top_9_hours','top_10_hours');
        if($request->has('photo') && $request->photo != null){
            $file_name = $this->saveImage($request->photo,'assets/uploads/visitors');
            $visitorData['photo'] = 'assets/uploads/visitors/'.$file_name;
        }
        $visitor = VisitorTypes::findOrFail($request->id);
        if($visitor->update($visitorData)){
            if($request->top_1_hours != null && $request->top_2_hours != null && $request->top_3_hours != null && $request->top_4_hours != null && $request->top_5_hours != null){
                $top_up = TopUpPrice::where('type_id',$visitor->id)->first();
                if(!$top_up){
                    TopUpPrice::create([
                        'type_id' => $visitor->id,
                        '1_hours' => $request->top_1_hours,
                        '2_hours' => $request->top_2_hours,
                        '3_hours' => $request->top_3_hours,
                        '4_hours' => $request->top_4_hours,
                        '5_hours' => $request->top_5_hours,
                        '6_hours' => $request->top_6_hours,
                        '7_hours' => $request->top_7_hours,
                        '8_hours' => $request->top_8_hours,
                        '9_hours' => $request->top_9_hours,
                        '10_hours' => $request->top_10_hours,
                    ]);
                }
                else{
                    $top_up->update([
                        'type_id' => $visitor->id,
                        '1_hours' => $request->top_1_hours,
                        '2_hours' => $request->top_2_hours,
                        '3_hours' => $request->top_3_hours,
                        '4_hours' => $request->top_4_hours,
                        '5_hours' => $request->top_5_hours,
                        '6_hours' => $request->top_6_hours,
                        '7_hours' => $request->top_7_hours,
                        '8_hours' => $request->top_8_hours,
                        '9_hours' => $request->top_9_hours,
                        '10_hours' => $request->top_10_hours,
                    ]);
                }
            }

//            for($i = 0 ; $i < count($request->details_id); $i++){
//                $shift_details = ShiftDetails::findOrFail($request->details_id[$i]);
//                $shift_details->price = $request->price[$i];
//                $shift_details->save();
//            }
            return response()->json(['status'=>200]);
        }
        else
            return response()->json(['status'=>405]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(request $request)
    {
        $visitor = VisitorTypes::findOrFail($request->id);
        if(VisitorTypes::all()->count() > 1){
            if (file_exists($visitor->photo)) {
                unlink($visitor->photo);
            }
            $visitor->delete();
            return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
        }else
            return response(['message' => 'At Least 1 Type Should Be Exist', 'status' => 405], 200);
    }
}
