<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Activity;
use App\Traits\PhotoTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Marketing');
    }

    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $activity = Activity::latest()->get();
            return Datatables::of($activity)
                ->addColumn('action', function ($activity) {
                    return '
                            <button type="button" data-id="' . $activity->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $activity->id . '" data-title="' . $activity->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('photo', function ($activity) {
                        return '
                         <img alt="Image" onclick="window.open(this.src)" style="cursor:pointer" class="avatar avatar-md bradius cover-image" src="' . get_user_photo($activity->photo) . '">
                        ';
                })
                ->editColumn('desc', function ($activity) {
                    return Str::limit ($activity->desc,50);
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/activity/index');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(){
        return view('Admin/activity.parts.create');
    }


    public function store(request $request)
    {
        $inputs = $request->validate([
            'photo'      => 'nullable|mimes:jpeg,jpg,png,gif',
            'title'      => 'nullable|max:255',
            'sub_title'  => 'nullable|max:255',
            'desc'       => 'required',
        ]);
        if($request->has('photo')){
            $file_name = $this->saveImage($request->photo,'assets/uploads/activities');
            $inputs['photo'] = 'assets/uploads/activities/'.$file_name;
        }
        if(Activity::create($inputs))
            return response()->json(['status'=>200]);
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


    public function edit($id){
        $activity = Activity::findOrFail($id);
        return view('Admin/activity.parts.edit',compact('activity'));
    }


    public function update(request $request)
    {
        $inputs = $request->validate([
            'id'         => 'required',
            'photo'      => 'nullable|mimes:jpeg,jpg,png,gif',
            'title'      => 'nullable|max:255',
            'sub_title'  => 'nullable|max:255',
            'desc'       => 'required',
        ]);
        $activity = Activity::findOrFail($request->id);
        if($request->has('photo')){
            if (file_exists($activity->photo)) {
                unlink($activity->photo);
            }
            $file_name = $this->saveImage($request->photo,'assets/uploads/activities');
            $inputs['photo'] = 'assets/uploads/activities/'.$file_name;
        }
        if($activity->update($inputs))
            return response()->json(['status'=>200]);
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

    public function delete(Request $request)
    {
        $activity = Activity::where('id', $request->id)->first();
        if (file_exists($activity->photo)) {
            unlink($activity->photo);
        }
        $activity->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
