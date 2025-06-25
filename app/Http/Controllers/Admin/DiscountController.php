<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountReason;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    public function index(request $request)
    {
        if($request->ajax()) {
            $discount = DiscountReason::latest()->get();
            return Datatables::of($discount)
                ->addColumn('action', function ($discount) {
                    return '
                            <button type="button" data-id="' . $discount->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $discount->id . '" data-title="' . $discount->desc . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/discount/index');
        }
    }



    public function create()
    {
        return view('Admin/discount.parts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(request $request): JsonResponse
    {
        $inputs = $request->validate([
            'desc' => 'required|unique:discount_reasons',
            'start' => ['required','date','before:end', 'after_or_equal:' . now()->format('Y-m-d')],
            'end' =>  ['required','date','after:start']
        ]);

        if($_SERVER['HTTP_HOST'] != 'localhost' && $_SERVER['HTTP_HOST'] != '127.0.0.1:8000')
            $inputs['uploaded'] = true;
        
        if(DiscountReason::create($inputs))
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



    public function edit($id)
    {
        $discount = DiscountReason::find($id);
        return view('Admin/discount.parts.edit',compact('discount'));

    }



    public function update(Request $request, $id)
    {
        $inputs = $request->validate([
            'desc'    => 'required|unique:discount_reasons,desc,'.$id,
        ]);
        $disc = DiscountReason::findOrFail($id);
        if ($disc->update($inputs))
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

    public function delete(request $request){
        $disc = DiscountReason::find($request->id);
        $disc->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
