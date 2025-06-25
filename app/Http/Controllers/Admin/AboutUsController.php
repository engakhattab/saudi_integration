<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Traits\PhotoTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class AboutUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Marketing');
    }

    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $about = AboutUs::latest()->get();
            return Datatables::of($about)
                ->addColumn('action', function ($about) {
                    return '
                            <button type="button" data-id="' . $about->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $about->id . '" data-title="' . $about->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('video', function ($about) {
                    if($about->type == 'image') {
                        return '
                         <img alt="Image" onclick="window.open(this.src)" style="cursor:pointer" class="avatar avatar-md bradius cover-image" src="' . get_user_photo($about->video) . '">
                        ';
                    }else{
                        return '
                        <a href="'.asset($about->video).'" target="_blank" class="btn btn-pill btn-secondary"><i class="fe fe-play"></i> Play</a>
                        ';
                    }
                })
                ->editColumn('desc', function ($about) {
                        return Str::limit ($about->desc,50);
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/about_us/index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(){
        return view('Admin/about_us.parts.create');
    }

    public function store(request $request)
    {
        $inputs = $request->validate([
            'video'      => 'nullable|mimes:jpeg,jpg,png,gif,mp4,mov,ogg,qt',
            'title'      => 'required|max:255',
            'sub_title'  => 'nullable|max:255',
            'desc'       => 'required',
        ]);
        if($request->has('video')){
            $file_name = $this->saveImage($request->video,'assets/uploads/about_us');
            $inputs['video'] = 'assets/uploads/about_us/'.$file_name;
            $mime = mime_content_type($inputs['video']);
            if(strstr($mime, "video/")){
                $inputs['type'] = 'video';
            }else if(strstr($mime, "image/")){
                $inputs['type'] = 'image';
            }
        }
        if(AboutUs::create($inputs))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }

    public function edit($id){
        $aboutUs = AboutUs::findOrFail($id);
        return view('Admin/about_us.parts.edit',compact('aboutUs'));
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
            'video'      => 'nullable|mimes:jpeg,jpg,png,gif,mp4,mov,ogg,qt',
            'title'      => 'required|max:255',
            'sub_title'  => 'nullable|max:255',
            'desc'       => 'required',
        ]);
        $about = AboutUs::findOrFail($request->id);
        if($request->has('video')){
            if (file_exists($about->video)) {
                unlink($about->video);
            }
            $file_name = $this->saveImage($request->video,'assets/uploads/about_us');
            $inputs['video'] = 'assets/uploads/about_us/'.$file_name;
            $mime = mime_content_type($inputs['video']);
            if(strstr($mime, "video/")){
                $inputs['type'] = 'video';
            }else if(strstr($mime, "image/")){
                $inputs['type'] = 'image';
            }
        }
        if($about->update($inputs))
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
        $about = AboutUs::where('id', $request->id)->first();
        if (file_exists($about->video)) {
            unlink($about->video);
        }
        $about->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
