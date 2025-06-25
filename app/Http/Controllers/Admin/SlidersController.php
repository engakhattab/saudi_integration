<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\PhotoTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class SlidersController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Marketing');
    }

    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $sliders = Slider::latest()->get();
            return Datatables::of($sliders)
                ->addColumn('action', function ($sliders) {
                    return '
                            <button type="button" data-id="' . $sliders->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $sliders->id . '" data-title="' . $sliders->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('button_text', function ($sliders) {
                    return '
                        <a href="'.($sliders->button_link != null ? $sliders->button_link : '#').'" class="btn btn-pill btn-secondary">'.$sliders->button_text.'</a>
                    ';
                })
                ->editColumn('photo', function ($sliders) {
                    return '
                    <img alt="Slider" onclick="window.open(this.src)" style="cursor:pointer" class="avatar avatar-lg bradius cover-image" src="'.get_user_photo($sliders->photo).'">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/sliders/index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(){
        return view('Admin/sliders.parts.create');
    }

    public function store(request $request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->validate([
            'photo'      => 'required|mimes:jpeg,jpg,png,gif',
            'title'      => 'nullable|max:255',
            'sub_title'  => 'nullable|max:255',
            'button_text'=> 'nullable|max:255',
            'button_link'=> 'nullable|url',
        ]);
        if($request->has('photo')){
            $file_name = $this->saveImage($request->photo,'assets/uploads/sliders');
            $inputs['photo'] = 'assets/uploads/sliders/'.$file_name;
        }
        $inputs['add_by'] = loggedAdmin('name');
        if(Slider::create($inputs))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }

    public function edit(Slider $slider){
        return view('Admin/sliders.parts.edit',compact('slider'));
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

    public function update(request $request)
    {
        $inputs = $request->validate([
            'id'         => 'required',
            'photo'      => 'nullable|mimes:jpeg,jpg,png,gif',
            'title'      => 'nullable|max:255',
            'sub_title'  => 'nullable|max:255',
            'button_text'=> 'nullable|max:255',
            'button_link'=> 'nullable|url',
        ]);
        $slider = Slider::findOrFail($request->id);
        if($request->has('photo')){
            if (file_exists($slider->photo)) {
                unlink($slider->photo);
            }
            $file_name = $this->saveImage($request->photo,'assets/uploads/sliders');
            $inputs['photo'] = 'assets/uploads/sliders/'.$file_name;
        }
        if ($slider->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
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
        $slider = Slider::where('id', $request->id)->first();
        if (file_exists($slider->photo)) {
            unlink($slider->photo);
        }
        $slider->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
