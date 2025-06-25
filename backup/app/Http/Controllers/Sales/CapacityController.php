<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\CapacityDays;
use App\Models\GeneralSetting;
use App\Models\Reservations;
use App\Models\TicketRevModel;
use Illuminate\Http\Request;

class CapacityController extends Controller
{
    function __construct()
    {

        $this->middleware('permission:Capacity');

    }


    public function index(Request $request)
    {
        ///////////////////////// فتح الكاليندر //////////////////////
        $insertDate = $request->month.'-01';
        if (in_array(date('m',strtotime($insertDate)), [10,11,12]))
            $insertDate = date('Y',strtotime('+1 year'.$insertDate)).'-01-01';
        if (CapacityDays::whereYear('day',date('Y',strtotime($insertDate)))->count() < 365){
            $this->creatCapacity($insertDate);
        }


        //////////////////////////// for calender ////////////////////////////
        $month = date('m',strtotime($request->month??date('Y-m')));
        $year = date('Y',strtotime($request->month??date('Y-m')));

        $number_of_day = date('t', mktime(0, 0, 0, $month, 1, $year));

        $start_day = date('w', strtotime($year.'-'.$month.'-01')) + 1;

        $prev_year = date('Y', strtotime('-1 year', strtotime($year.'-'.$month.'-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $next_year = date('Y', strtotime('+1 year', strtotime($year.'-'.$month.'-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));

        ///////////////////////////////// end calender //////////////////////////

        ///////////////////////////// select data ////////////////////
        $getAllModels = TicketRevModel::whereMonth('day',$month);


        return view('sales.capacity',compact('getAllModels','number_of_day','start_day','prev_year','prev_month','year','month'));
    }
    public function anotherMonth(Request $request){
        ///////////////////////// فتح الكاليندر //////////////////////
        $insertDate = $request->month.'-01';
        if (in_array(date('m',strtotime($insertDate)), [10,11,12]))
            $insertDate = date('Y',strtotime('+1 year'.$insertDate)).'-01-01';
        if (CapacityDays::whereYear('day',date('Y',strtotime($insertDate)))->count() < 365){
            $this->creatCapacity($insertDate);
        }

        //////////////////////////// for calender ////////////////////////////

        $month = date('m',strtotime($request->month??date('Y-m')));
        $year = date('Y',strtotime($request->month??date('Y-m')));

        $number_of_day = date('t', mktime(0, 0, 0, $month, 1, $year));

        $start_day = date('w', strtotime($year.'-'.$month.'-01')) + 1;



        $prev_year = date('Y', strtotime('-1 year', strtotime($year.'-'.$month.'-01')));
        $prev_month = date('m', strtotime('-1 month', strtotime($year.'-'.$month.'-01')));
        $next_year = date('Y', strtotime('+1 year', strtotime($year.'-'.$month.'-01')));
        $next_month = date('m', strtotime('+1 month', strtotime($year.'-'.$month.'-01')));

        ///////////////////////////////// end calender //////////////////////////

        ///////////////////////////// select data ////////////////////
        $getAllModels = TicketRevModel::whereMonth('day',$month);

        $html = view('sales.capacity.calendarBody',compact('getAllModels','number_of_day','start_day','prev_year','prev_month','year','month'));

        $url = route('capacity.index')."?month=".date('Y-m',strtotime($year.'-'.$month.'-01'));





        return response()->json(['html'=>"$html","status"=>200,'url'=> $url]);
    }//end fun

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
    public function show($date)
    {
        $reservations = Reservations::join('shifts' ,'reservations.shift_id', '=', 'shifts.id')
            ->orderBy('shifts.from','ASC')
            ->with('event','shift')->whereDate('day',$date)->get();


        ////////////////////////////////////// حساب النسبة //////////////////////////////
        $capacityDay = CapacityDays::whereDate('day', $date)->first();
        $countOfTheDay = $capacityDay->count ?? generalSetting()->capacity;

        $countDay = TicketRevModel::whereDate('day', $date)->where('status','in')->count();
        $percent = ($countDay / $countOfTheDay) * 100;
        ////////////////////////////////////// حساب النسبة //////////////////////////////

        session()->put('activeDate',$date);
        return view('sales.capacity.loadDay',compact('date','countOfTheDay','countDay','percent','reservations'));
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

    public function creatCapacity($date){
        $latestDayInYear = date('Y',strtotime($date)).'-12-31';

        if (in_array(date('m',strtotime($date)), [10,11,12])){
            $latestDayInYear = date('Y',strtotime('+1 year'.date('Y-m-d'))).'-12-31';
        }

        $countOfDays = date('t',strtotime($date));
        $year = date('Y',strtotime($date));
        $setting = GeneralSetting::latest()->first();
        $countInserted = CapacityDays::whereYear('day',$year)->count();
        while (!in_array($countInserted,[365,366])){
                if (CapacityDays::whereDate('day',$date)->count() == 0){
                $array = [];
                $array['count'] = $setting->capacity ?? 1250;
                $array['day'] = $date;
                $array['status'] = true;
                CapacityDays::create($array);
            }
            $countInserted = CapacityDays::whereMonth('day',$date)->count();
            if ($latestDayInYear == $date)break;
            $date = date('Y-m-d',strtotime('+1 day',strtotime($date)));

        }//end while
    }//end fun
}
