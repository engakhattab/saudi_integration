<div class="row justify-content-between align-items-end">
    <div class="col text-center text-sm-start">
        <button data-href="{{route('capacity.anotherMonth.index')}}?month={{date('Y-m')}}" class="btn btn-success anotherMonth"> today </button>
    </div>
    <div class="col">
        <div class="months justify-content-center justify-content-lg-end">
            <button   data-href="{{route('capacity.anotherMonth.index')}}?month={{date('Y-m',strtotime('-1 month',strtotime($year.'-'.$month.'-'.'01')))}}"
                      class="anotherMonth icon prev"> <i class="fad fa-chevron-left"></i> </button>
            <p> {{$year}} <span> {{date("F", strtotime($year.'-'.$month.'-01'))}} </span> </p>
            <button data-href="{{route('capacity.anotherMonth.index')}}?month={{date('Y-m',strtotime('+1 month',strtotime($year.'-'.$month.'-'.'01')))}}"
                    class="anotherMonth icon next"> <i class="fad fa-chevron-right"></i> </button>
        </div>
    </div>
</div>
<div class="calendarHead">
    <div class="day">Sun</div>
    <div class="day">Mon</div>
    <div class="day">Tue</div>
    <div class="day">Wed</div>
    <div class="day">Thu</div>
    <div class="day">Fri</div>

    <div class="day">Sat</div>
</div>
<div class="calendarBody">

    <?php
    $i = 1;
    $flag = 0;
    while ($i <= $number_of_day) {
        for($j=1 ; $j<=7 ; $j++){
            if($i > $number_of_day)
                break;

            if($flag) {
                if ($year . '-' . $month . '-' . $i == date('Y') . '-' . date('m') . '-' . (int)date('d'))
                    include(resource_path('views/sales/capacity/toDay.blade.php'));
                else
                    include(resource_path('views/sales/capacity/capacity.blade.php'));

                $i++;
            }elseif($j == $start_day){
                if($year.'-'.$month.'-'.$i == date('Y').'-'.date('m').'-'.(int)date('d'))
                    include(resource_path('views/sales/capacity/toDay.blade.php'));
                else
                    include(resource_path('views/sales/capacity/capacity.blade.php'));

                $flag = 1;
                $i++;
                continue;
            }
            else {
                include(resource_path('views/sales/capacity/prevMonth.blade.php'));
            }

        }
    }
    ?>




</div>
