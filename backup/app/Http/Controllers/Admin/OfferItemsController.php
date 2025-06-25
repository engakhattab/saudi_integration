<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\OfferItem;
use App\Traits\PhotoTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class OfferItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    use PhotoTrait;
    public function index(request $request)
    {
        if($request->ajax()) {
            $items = OfferItem::latest()->get();
            return Datatables::of($items)
                ->addColumn('action', function ($items) {
                    return '
                            <button type="button" data-id="' . $items->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $items->id . '" data-title="' . $items->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('title', function ($items) {
                    return '
                         <img alt="Image" onclick="window.open(this.src)" style="cursor:pointer" class="brround  avatar-sm w-32 ml-2" src="' . get_user_photo($items->photo) . '">
                          '.$items->title.'
                        ';
                })
                ->editColumn('offer_id', function ($items) {
                    return $items->offer->title;
                })
                ->editColumn('desc', function ($items) {
                    return Str::limit ($items->desc,50);
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/offers_items/index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(){
        $offers = Offer::latest()->get();
        return view('Admin/offers_items.parts.create',compact('offers'));
    }

    public function store(request $request)
    {
        $inputs = $request->validate([
            'photo'      => 'required|mimes:jpeg,jpg,png,gif',
            'title'      => 'required|max:255',
            'offer_id'   => 'required',
            'desc'       => 'required',
        ]);
        if($request->has('photo')){
            $file_name = $this->saveImage($request->photo,'assets/uploads/offers_items');
            $inputs['photo'] = 'assets/uploads/offers_items/'.$file_name;
        }
        if(OfferItem::create($inputs))
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
        $item   = OfferItem::findOrFail($id);
        $offers = Offer::latest()->get();
        return view('Admin/offers_items.parts.edit',compact('item','offers'));
    }



    public function update(request $request)
    {
        $inputs = $request->validate([
            'id'         => 'required',
            'photo'      => 'nullable|mimes:jpeg,jpg,png,gif',
            'title'      => 'nullable|max:255',
            'offer_id'   => 'required',
            'desc'       => 'required',
        ]);
        $item = OfferItem::findOrFail($request->id);
        if($request->has('photo')){
            if (file_exists($item->photo)) {
                unlink($item->photo);
            }
            $file_name = $this->saveImage($request->photo,'assets/uploads/offers_items');
            $inputs['photo'] = 'assets/uploads/offers_items/'.$file_name;
        }
        if($item->update($inputs))
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
        $item = OfferItem::where('id', $request->id)->first();
        if (file_exists($item->photo)) {
            unlink($item->photo);
        }
        $item->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
