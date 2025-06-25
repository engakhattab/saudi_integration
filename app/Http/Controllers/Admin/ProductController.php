<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    public function index(request $request)
    {
        if($request->ajax()) {
            $products = Product::latest()->get();
            return Datatables::of($products)
                ->addColumn('action', function ($products) {
                    return '
                            <button type="button" data-id="' . $products->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $products->id . '" data-title="' . $products->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('vat', function ($products) {
                    return $products->vat."%";
                })
                ->editColumn('status', function ($products) {
                    if($products->status == 0)
                        return '<span class="badge badge-danger br-7">inactive</span>';
                    else
                        return '<span class="badge badge-success br-7">active</span>';
                })
                ->editColumn('price', function ($products) {
                        return '<span class="font-weight-semibold fs-15">'.$products->price.'</span>';
                })
                ->editColumn('category_id', function ($products) {
                    return $products->categoryYA->title;
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/products/index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('Admin/products.parts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(request $request)
    {
        $inputs = $request->validate([
            'title'       => 'required',
            'price'       => "required|regex:/^\d+(\.\d{1,2})?$/",
            'vat'         => "required|regex:/^\d+(\.\d{1,2})?$/",
            'category_id' => 'required',
        ]);

        // handle vat calculations
        ($request->status == 'on') ? $inputs['status'] = '1' : $inputs['status'] = '0';
        $price_before_vat = $request->price / ($request->vat / 100 + 1);
        $inputs['price_before_vat'] = round($price_before_vat, 2);

        if($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1:8000')
            $inputs['uploaded'] = true;

        if(Product::create($inputs))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
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
     * @param Product $product
     * @return Application|Factory|View
     */
    public function edit(Product $product)
    {
        $categories = Category::latest()->get();
        return view('Admin/products.parts.edit',compact('categories','product'));
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
            'title'       => 'required',
            'price'       => "required|regex:/^\d+(\.\d{1,2})?$/",
            'vat'         => "required|regex:/^\d+(\.\d{1,2})?$/",
            'category_id' => 'required',
        ]);
        ($request->status == 'on') ? $inputs['status'] = '1' : $inputs['status'] = '0';
        $price_before_vat = $request->price / ($request->vat / 100 + 1);
        $inputs['price_before_vat'] = round($price_before_vat, 2);
        $product = Product::findOrFail($request->id);
        if($product->update($inputs))
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

    public function delete(request $request){
        $product = Product::where('id', $request->id)->first();
        $product->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
