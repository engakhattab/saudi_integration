<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\Bracelets;
use App\Models\Reservations;
use App\Models\Ticket;
use App\Models\TicketRevModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FamilyAccessController extends Controller
{

    function __construct()
    {

        $this->middleware('permission:Family Access');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if($request->search != 'all') {
                $ticket = Ticket::whereDate('visit_date', date('Y-m-d'))
                    ->where(function ($query) use ($request) {
                        $query->where('ticket_num', $request->search)
                            ->orWhereHas('client', function ($query) use ($request) {
                                $query->where('phone', $request->search);
                            });
                    })->with('append_models.type');
            }
            else{
                $ticket = Ticket::whereDate('visit_date', date('Y-m-d'))->where('status','append');
            }


            $bracelet_numbers = [];
            $birthDays = [];
            $names = [];
            $returnArray = [];

            if ($ticket->count() > 0) {
                if ($request->search == 'all')
                    $models =  TicketRevModel::where([['status','append'],['day', date('Y-m-d')],['ticket_id','!=',null]])->get();
                else
                    $models = $ticket->first()->append_models;
                foreach ($models as $key => $model) {
                    $smallArray = [];
                    $smallArray[] = '#' . $model->ticket->ticket_num ?? '';
                    $smallArray[] = '#' . $model->type->title ?? '';
                    $custom_ids[] = $model->ticket->ticket_num ?? '';

                    ///////////////////////////// bracelet /////////////////
                    $bracelet = view('sales.layouts.familyAccess.bracelet', compact('model'));
                    $smallArray[] = "$bracelet";
                    $bracelet_numbers[] = "$bracelet";

                    ///////////////////////////// name /////////////////
                    $name = view('sales.layouts.familyAccess.name', compact('model'));
                    $smallArray[] = "$name";
                    $names[] = "$name";
                    ///////////////////////////// birthDays /////////////////
                    $birthDay = view('sales.layouts.familyAccess.birthDay', compact('model'));
                    $smallArray[] = "$birthDay";
                    $birthDays[] = "$birthDay";
                    ///////////////////////////// gender /////////////////
                    $gender = view('sales.layouts.familyAccess.gender', compact('model'));
                    $smallArray[] = "$gender";
                    ///////////////////////////// actions /////////////////
                    $actions = view('sales.layouts.familyAccess.actions', compact('model', 'key'));
                    $smallArray[] = "$actions";


                    $smallArray[] = "$gender";

                    $returnArray[] = $smallArray;
                }

                return response()->json(['status' => 200, 'backArray' => $returnArray]);

            }

            return response()->json(['status' => 300,]);
        }

        return view('sales.family-access');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'bracelet_number' => ['nullable', Rule::unique('ticket_rev_models', 'bracelet_number')->where('status', 'in')],
            'id' => ['required', Rule::exists('ticket_rev_models', 'id')->where('status', 'append')],
            'birthday' => 'nullable',
            'name' => 'nullable|max:500',
            'gender' => 'nullable|in:male,female',
        ],[
            'bracelet_number.unique'=>'This Bracelet Num Is Taken'
        ]);
        $model = TicketRevModel::findOrFail($request->id);

        if ($model->rev_id != '') {
            $ticket = Reservations::findOrFail($model->rev_id);
        } elseif ($model->ticket_id != '') {
            $ticket = Ticket::findOrFail($model->ticket_id);

        } else {
            toastr()->info('not found');
            return response(1, 500);
        }
        if($ticket->rem_amount > 0){
            return response()->json(['status'=>405,'rem_amount'=>$ticket->rem_amount,'ticket_id'=>$ticket->id]);
        }

        $status['status'] = 'in';
        $data['status'] = 'in';
        $data['start_at'] = date('H:i:s');

        $braceletData['status'] = false;

        Bracelets::where('title', $request->bracelet_number)->update($braceletData);
        $model->update($data);

        if ($model->rev_id != '') {
            $count = TicketRevModel::where([['rev_id', $model->rev_id], ['status', 'append']])->count();
        }
        elseif($model->ticket_id != '') {
            $count = TicketRevModel::where([['ticket_id', $model->ticket_id], ['status', 'append']])->count();
        }
        if($count == 0){
            $ticket->update($status);
        }
        $ticket->update($status);


        return response(['count'=>$count,'url'=>route('ticket.edit',$ticket->id)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updateAmount(request $request){
        $ticket = Ticket::findOrFail($request->id);
        $ticket->update([
            'paid_amount' => $ticket->grand_total,
            'rem_amount' => 0,
            'payment_status' => 1
        ]);
        return response(['message' => 'The remaining value is updated', 'status' => 200], 200);
    }
}
