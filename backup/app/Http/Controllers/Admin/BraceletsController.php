<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bracelets;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class BraceletsController extends Controller
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
            $bracelets = Bracelets::latest()->get();
            return Datatables::of($bracelets)
                ->addColumn('action', function ($bracelets) {
                    return '
                            <button type="button" data-id="' . $bracelets->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $bracelets->id . '" data-title="' . $bracelets->title . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/bracelets/index');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('Admin/bracelets.parts.create');
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
            'title' => 'required|unique:bracelets',
        ]);
        if(Bracelets::create($inputs))
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
    public function edit(Bracelets $bracelet)
    {
        return view('Admin/bracelets.parts.edit',compact('bracelet'));
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
            'title'    => 'required|unique:bracelets,title,'.$request->id,
        ]);
        $bracelet = Bracelets::findOrFail($request->id);
        if ($bracelet->update($inputs))
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
        $bracelet = Bracelets::where('id', $request->id)->first();
        $bracelet->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
