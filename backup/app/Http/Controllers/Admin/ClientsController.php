<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(request $request)
    {
        if($request->ajax()) {
            $clients = Clients::latest()->get();
            return Datatables::of($clients)
                ->addColumn('action', function ($clients) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $clients->id . '" data-title="' . $clients->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('created_at', function ($clients) {
                    return ($clients->created_at->diffForHumans()) ?? '<i class="fe fe-circle"></i>';
                })
                ->editColumn('gender', function ($clients) {
                    if($clients->gender == 'male')
                        return '<span class="text-center"><i class="fas fa-male fa-2x" style="color: #A6C64C"></i></span>';
                    elseif($clients->gender == 'female')
                        return '<span class="text-center"><i class="fas fa-female fa-2x" style="color: #A6C64C"></i></span>';
                    else
                        return 'Not Selected';
                })
                ->editColumn('gov_id', function ($clients) {
                    return ($clients->governorateYA->title) ?? 'Not Selected';
                })
                ->editColumn('city_id', function ($clients) {
                    return ($clients->cityYA->title) ?? 'Not Selected';
                })
                ->editColumn('family_size', function ($clients) {
                    return ($clients->family_size) ?? 'Not Selected';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/clients/index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
        $client = Clients::where('id', $request->id)->first();
        $client->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
