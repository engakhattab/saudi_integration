<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clients;
use App\Models\Reference;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class RefernceController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index(request $request)
    {
        if($request->ajax()) {
            $References = Reference::latest()->get();
            return Datatables::of($References)
                ->addColumn('action', function ($References) {
                    return '
                            <button type="button" data-id="' . $References->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $References->id . '" data-title="' . $References->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->addColumn('count', function ($References) {
                    return Clients::where('ref_id',$References->id)->count();
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/references/index');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('Admin/references.parts.create');
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
            'title' => 'required|unique:references',
        ]);
        if(Reference::create($inputs))
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
     * @return Application|Factory|View
     */
    public function edit(Reference $Reference)
    {
        return view('Admin/references.parts.edit',compact('Reference'));
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
            'title'    => 'required|unique:references,title,'.$request->id,
        ]);
        $Reference = Reference::findOrFail($request->id);
        if ($Reference->update($inputs))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
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
        $Reference = Reference::where('id', $request->id)->first();
        $Reference->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
