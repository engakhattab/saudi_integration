<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OfferController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    public function index(request $request)
    {
        if($request->ajax()) {
            $offers = Offer::latest()->get();
            return Datatables::of($offers)
                ->addColumn('action', function ($offers) {
                    return '
                            <button type="button" data-id="' . $offers->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $offers->id . '" data-title="' . $offers->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->addColumn('count',function ($offers){
                    return $offers->items->count();
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/offers/index');
        }
    }


    public function create()
    {
        return view('Admin/offers.parts.create');
    }


    public function store(request $request): JsonResponse
    {
        $inputs = $request->validate([
            'title' => 'required|unique:offers',
        ]);
        if(Offer::create($inputs))
            return response()->json(['status'=>200]);
        else
            return response()->json(['status'=>405]);
    }



    public function show($id)
    {
        //
    }



    public function edit(Offer $offer)
    {
        return view('Admin/offers.parts.edit',compact('offer'));
    }



    public function update(Request $request)
    {
        $inputs = $request->validate([
            'title'    => 'required|unique:offers,title,'.$request->id,
        ]);
        $offer = Offer::findOrFail($request->id);
        if ($offer->update($inputs))
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
        $offers = Offer::where('id', $request->id)->first();
        $offers->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
