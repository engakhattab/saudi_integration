<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Models\CapacityDays;
use App\Models\ShiftDetails;
use App\Models\Shifts;
use App\Models\TopUpPrice;
use App\Models\VisitorTypes;
use Illuminate\Http\Request;

class VisitorTypesPricesController extends Controller{


    public function visitorTypesPrices(Request $request){
        $date = $request->validate([
            'visit_date'    =>'required',
            'hours_count'   =>'required',
            'old_hours'     =>'required',
//            'shift_id'      =>'required|exists:shifts,id|exists:shift_details,shift_id',
            ]);
        $hoursCount    = $request->hours_count;
        $newHoursCount = 0;
        $oldHours = $request->old_hours;
        $visitorTypes  = VisitorTypes::latest()->get()->pluck('id');
        foreach ($visitorTypes as $type){
            $price = TopUpPrice::where('type_id',$type)->first();
            if($price){

                //$pricesArray[$type] = ($price[$hoursCount.'_hours'] * $hoursCount);

                //$pricesArray[$type] = ($price[$hoursCount.'_hours'] * $hoursCount);

                // case old is 1
                if($hoursCount == 1 && $oldHours == 1){

                    $pricesArray[$type] = ($price['1_hours']) / (1.15);

                }elseif($hoursCount == 2 && $oldHours == 1){

                    $pricesArray[$type] =  ($price['1_hours']+$price['2_hours']) / (1.15);

                }elseif($hoursCount == 3 && $oldHours == 1){

                    $pricesArray[$type] = ($price['1_hours'] + $price['2_hours']+$price['3_hours']) / (1.15);

                }elseif($hoursCount == 4 && $oldHours == 1){

                    $pricesArray[$type] = ($price['1_hours'] + $price['2_hours'] +$price['3_hours'] + $price['4_hours']) / (1.15);
                }



                // case old is 2
                elseif($hoursCount == 1 && $oldHours == 2){

                    $pricesArray[$type] = ($price['2_hours']) / (1.15);

                }elseif($hoursCount == 2 && $oldHours == 2){

                    $pricesArray[$type] = ($price['2_hours']+$price['3_hours'])  / (1.15);

                }elseif($hoursCount == 3 && $oldHours == 2){

                    $pricesArray[$type] = ($price['2_hours']+$price['3_hours'] + $price['4_hours']) / (1.15);
                }


                // case old is 3
                elseif($hoursCount == 1 && $oldHours == 3){

                    $pricesArray[$type] = ($price['3_hours']) / (1.15);

                }elseif($hoursCount == 2 && $oldHours == 3){

                    $pricesArray[$type] = ($price['3_hours']+$price['4_hours']) / (1.15);
                }
                // case old is 4
                //start change

                elseif($hoursCount == 1 && $oldHours == 4){

                    $pricesArray[$type] = ($price['4_hours']) / (1.15);

                }

                elseif($hoursCount == 2 && $oldHours == 4){

                    $pricesArray[$type] = ($price['5_hours'] + $price['6_hours']) / (1.15);

                }

                elseif($hoursCount == 3 && $oldHours == 4){

                    $pricesArray[$type] = ($price['5_hours'] + $price['6_hours'] + $price['7_hours']) / (1.15);

                }
                elseif($hoursCount == 4 && $oldHours == 4){

                    $pricesArray[$type] = ($price['5_hours'] + $price['6_hours'] + $price['7_hours'] +  $price['8_hours']) / (1.15);

                } elseif($hoursCount == 5 && $oldHours == 4){

                    $pricesArray[$type] = ($price['5_hours'] + $price['6_hours'] + $price['7_hours'] +  $price['8_hours'] +  $price['9_hours']) / (1.15);

                }elseif($hoursCount == 5 && $oldHours == 4){

                    $pricesArray[$type] = ($price['5_hours'] + $price['6_hours'] + $price['7_hours'] +  $price['8_hours'] +  $price['9_hours']) / (1.15);

                }elseif($hoursCount == 6 && $oldHours == 4){

                    $pricesArray[$type] = ($price['5_hours'] + $price['6_hours'] + $price['7_hours'] +  $price['8_hours'] +  $price['9_hours'] + $price['10_hours']) / (1.15);

                }

                //start change two
                elseif($hoursCount == 1 && $oldHours == 5){

                    $pricesArray[$type] = ($price['6_hours']) / (1.15);

                }
                elseif($hoursCount == 2 && $oldHours == 5){

                    $pricesArray[$type] = ($price['6_hours'] + $price['7_hours']) / (1.15);

                }  elseif($hoursCount == 3 && $oldHours == 5){

                    $pricesArray[$type] = ($price['6_hours'] + $price['7_hours'] + $price['8_hours'] ) / (1.15);

                }elseif($hoursCount == 4 && $oldHours == 5){

                    $pricesArray[$type] = ($price['6_hours'] + $price['7_hours'] + $price['8_hours'] + $price['9_hours']) / (1.15);

                }elseif($hoursCount == 5 && $oldHours == 5){

                    $pricesArray[$type] = ($price['6_hours'] + $price['7_hours'] + $price['8_hours'] + $price['9_hours'] + $price['10_hours']) / (1.15);

                }
                //start change three
                elseif($hoursCount == 1 && $oldHours == 6){

                    $pricesArray[$type] = ($price['7_hours']) / (1.15);

                }elseif($hoursCount == 2 && $oldHours == 6){

                    $pricesArray[$type] = ($price['7_hours'] + $price['8_hours']) / (1.15);

                }elseif($hoursCount == 3 && $oldHours == 6){

                    $pricesArray[$type] = ($price['7_hours'] + $price['8_hours'] + $price['9_hours'] ) / (1.15);

                }elseif($hoursCount == 4 && $oldHours == 6){

                    $pricesArray[$type] = ($price['7_hours'] + $price['8_hours'] + $price['9_hours'] + $price['10_hours']) / (1.15);

                }

                  //start change four
                elseif($hoursCount == 1 && $oldHours == 7){

                    $pricesArray[$type] = ($price['8_hours']) / (1.15);

                } elseif($hoursCount == 2 && $oldHours == 7){

                    $pricesArray[$type] = ($price['8_hours'] +$price['9_hours'] ) / (1.15);

                }elseif($hoursCount == 3 && $oldHours == 7){

                    $pricesArray[$type] = ($price['8_hours'] +$price['9_hours'] + $price['10_hours'] ) / (1.15);
                }

                //start change five
                elseif($hoursCount == 1 && $oldHours == 8){

                    $pricesArray[$type] = ($price['9_hours']) / (1.15);

                } elseif($hoursCount == 2 && $oldHours == 8){

                    $pricesArray[$type] = ($price['9_hours'] + $price['10_hours']) / (1.15);
                }
                //start change six == ($hoursCount == 1 && $oldHours == 9)
                else{

                    $pricesArray[$type] = ($price['10_hours']) / (1.15);
                }



            }
            else
                $pricesArray[$type] = (65 * $hoursCount);
        }



//        $pricesArray = [];
//        foreach ($visitorTypes as $type){
//            $price = TopUpPrice::where('type_id',$type)->first();
//            if($price){
//                for ($i =1; $i <= $hoursCount;$i++){
//
//                    $pricesArray[$type]  += $price[$i.'_hours'];
//
//                }
//            }
//
//        }



//
//        $hoursCount    = $request->hours_count;
//        $newHoursCount = $request->hours_count;
//        $shift  = Shifts::findOrFail($request->shift_id);
//        $shifts = [];
////        $pricesArray = [];
////        foreach($visitorTypes as $visitorType){
////            $pricesArray[$visitorType->id] = 0;
////        }
//
//        $count = 0;
//
//
//
//        while ($newHoursCount > 0){
//
//            if ($count >= 100)
//            {
//                break;
//            }
//
//
//            $from = strtotime(date('H',strtotime($shift->from)).":00");
//            $to = strtotime(date('H',strtotime($shift->to)).":00");
//            $difference = round(abs($to - $from) / 3600,2);
//            if ($hoursCount > $difference){
//                $searchHour = $difference;
//            }else{
//                $searchHour = $hoursCount;
//            }
//
//            if ($newHoursCount < $difference){
//                $searchHour = $newHoursCount;
//            }
//
//
//            foreach($visitorTypes as $visitorType){
//                $findShiftDetails = ShiftDetails::where('shift_id',$shift->id)->where('visitor_type_id',$visitorType->id)->firstOrFail();
//                $shifts[] = $findShiftDetails;
////                $pricesArray[$visitorType->id] += $searchHour * $findShiftDetails->price;
//            }
//            $nextId = Shifts::where('id','>',$shift->id)->max('id');
//            $latestShift = $shift;
//
//            $shift = Shifts::find($nextId);
//
//
//
//            $newHoursCount = $newHoursCount - $searchHour;
//
//            if (!$shift){
//                break;
//            }
//            $count++;
//        }
        return response()->json(['status'=>200,'array'=>$pricesArray,'latestHours'=>$newHoursCount]);





    }//end fun

    public function calculateWithVisitorType(){

    }//end fun


    public function calcCapacity(Request $request){
        $request->validate([
            'visit_date'    =>'required',
            'hours_count'   =>'required',
            'shift_id'      =>'required',
        ]);
        $capacity     = (CapacityDays::where('day',$request->visit_date)->first()->count) ?? GeneralSetting::first()->capacity;
        $booked_count = TicketRevModel::where('day',$request->visit_date)->count();

        // if booked = or > from the day wanted then the day is full
        if($booked_count >= $capacity)
            return response()->json(['day'=>$request->visit_date,'status' => false]);
        else{
            // else then there is a count for new tickets and adjust response
            $available      = $capacity - $booked_count;
            $shift          = Shifts::where('id',$request->shift_id)->first();
            $hours          = $request->hours_count;
            $shift_duration = strtotime($shift->to)-(strtotime($shift->from));
            $shift_prices   = ShiftDetails::where('shift_id',$request->shift_id)->select('visitor_type_id','price')->get();
            // now check if wanted hours is less than shift time then do direct calculations
            if($hours <= $shift_duration/3600) {
                foreach ($shift_prices as $price){
                    $price->price *= $hours;
                }
                return response()->json(['shift_prices' => $shift_prices,'available' => $available,'status' => true]);
            }else{
                // do function
            }
        }
    }


}//end class
