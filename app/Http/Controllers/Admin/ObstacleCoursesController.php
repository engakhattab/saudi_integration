<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ObstacleCources;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class ObstacleCoursesController extends Controller
{
    use PhotoTrait;
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $cources = ObstacleCources::get();
            return Datatables::of($cources)
                ->addColumn('action', function ($cource) {
                    return '
                            <button type="button" data-id="' . $cource->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $cource->id . '" >
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('image', function ($cource) {
                    return '<img alt="image" class="avatar avatar-md rounded-circle" src="' . get_user_photo($cource->image) . '">';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin/ObstacleCources/index');
        }
    }//end fun

    public function create()
    {
        return view('Admin/ObstacleCources/parts.create');
    }//end fun

    public function store(request $request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->validate([
            'title' => 'required',
            'name' => 'required',
            'text' => 'required|min:6',
            'image' => 'required|mimes:jpeg,jpg,png,gif',
        ]);
        if ($request->has('image')) {
            $file_name = $this->saveImage($request->image, 'assets/uploads/ObstacleCources');
            $inputs['image'] = 'assets/uploads/ObstacleCources/' . $file_name;
        }
         ObstacleCources::create($inputs);

            return response()->json(['status' => 200]);
    }//end fun
    public function update(request $request,$id): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->validate([
            'title' => 'required',
            'name' => 'required',
            'text' => 'required|min:6',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif',
        ]);
        $cource = ObstacleCources::find($id);
        if ($request->hasFile('image')) {
            $file_name = $this->saveImage($request->image, 'assets/uploads/ObstacleCources');
            $inputs['image'] = 'assets/uploads/ObstacleCources/' . $file_name;
            if (file_exists($cource->image)) {
                unlink($cource->image);
            }
        }
         $cource->update($inputs);

            return response()->json(['status' => 200]);
    }//end fun
    public function edit($id)
    {
        $cource = ObstacleCources::find($id);
        return view('Admin/ObstacleCources/parts.edit',compact('cource'));
    }//end fun
    public function delete(Request $request)
    {
        $cource = ObstacleCources::find($request->id);

            if (file_exists($cource->image))
                unlink($cource->image);

                $cource->delete();
            return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
        
    }
}//end class
