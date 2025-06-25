<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricesSlider;
use http\Params;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use App\Traits\PhotoTrait;

class PricesSliderController extends Controller
{
    use PhotoTrait;
    public function __construct()
    {
        $this->middleware('adminPermission:Marketing');
    }

    public function index(request $request)
    {
        if ($request->ajax()) {
            $prices = PricesSlider::latest()->get();
            return Datatables::of($prices)
                ->addColumn('action', function ($price) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $price->id . '" >
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('created_at', function ($price) {
                    return $price->created_at->diffForHumans();
                })
                ->editColumn('image', function ($price) {
                    return '<img alt="image" class="avatar avatar-md rounded-circle" src="' . get_user_photo($price->image) . '">';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin/PricesSlider/index');
        }
    }//end fun
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('Admin/PricesSlider.parts.create');
    }//end fun
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(request $request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->validate([
            'image' => 'required|mimes:jpeg,jpg,png,gif',
        ]);
        if ($request->has('image')) {
            $file_name = $this->saveImage($request->image, 'assets/uploads/admins');
            $inputs['image'] = 'assets/uploads/image/' . $file_name;
        }
        $image = PricesSlider::create($inputs);

        if ($image)
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }//end fun
    public function delete(Request $request)
    {
        $image = PricesSlider::FindOrFail($request->id);
        if (file_exists($image->image)) {
            unlink($image->image);
        }
        $image->delete();
        return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
    }//end fun
}//end class
