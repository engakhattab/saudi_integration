<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:CS');
    }

    public function index(request $request)
    {
        if($request->ajax()) {
            $contact = ContactUs::latest()->get();
            return Datatables::of($contact)
                ->addColumn('action', function ($contact) {
                    return '
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $contact->id . '" data-title="' . $contact->first_name .' '.$contact->last_name. '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->addColumn('status',function ($contact){
                    if($contact->status == 0){
                        return '<span class="readSpan badge badge-success" data-id="'.$contact->id.'" style="cursor: pointer">new</span>';
                    }else
                        return '<span class="badge badge-default">read <i class="fas fa-check-circle"></i></span>';
                })
                ->editColumn('created_at', function ($contact) {
                    return $contact->created_at->diffForHumans();
                })
                ->editColumn('first_name', function ($contact) {
                    return $contact->first_name.' '.$contact->last_name;
                })
                ->escapeColumns([])
                ->make(true);
        }else{
            return view('Admin/contact_us/index');
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

    public function read_message(Request $request)
    {
        $contact = ContactUs::where('id', $request->id)->first();
        $contact->status = '1';
        $contact->save();
        $count = ContactUs::where('status','0')->count();
        return response(['message'=>'Message Read Done','count'=>$count,'status'=>200],200);
    }

    public function getCount(){
        if(ContactUs::where('status',1)->count() > 0)
            $html = '<span class="contact text-right nav-unread badge badge-danger badge-pill pulse">'.ContactUs::where('status',1)->count().'</span>';
        return $html;
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

    public function destroy($id)
    {
        //
    }

    public function delete(request $request){
        $contact = ContactUs::where('id', $request->id)->first();
        $contact->delete();
        return response(['message'=>'Data Deleted Successfully','status'=>200],200);
    }
}
