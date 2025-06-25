<?php

use App\Models\Reservations;
use App\Models\CapacityDays;

if ($i < 10) {
    $newI = '0' . $i;
} else {
    $newI = $i;
}
$toDay = date('Y-m-d', strtotime($year . '-' . $month . '-' . $newI));

$capacityDay = CapacityDays::whereDate('day', $toDay)->first();

$countDay = $getAllModels->whereDate('day', $toDay)->count();

$countOfTheDay = $capacityDay->count ?? generalSetting()->capacity;

////////////////////////////// النسبة /////////////////////////////////////
$percent = ($countDay / $countOfTheDay) * 100;

$checkReservations = Reservations::with('event')->groupBy('event_id')->whereDate('day', $toDay)->take(4)->get();
$active = '';
if (session()->get('activeDate') == $toDay) {
    $active = ' active ';
}
?>
<div class="day getData <?php echo $toDay . $active;?>" data-date="<?php echo $toDay;?>">
    <span class="num"> <?php echo $i;?></span>
    <div class="capacityContainer">
        <div class="capacityPercentage" style="width: <?php echo $percent ?? 0;?>%;">
        </div>
    </div>
    <div class="events">
        <?php
        foreach ($checkReservations as $reservation) {
            $icon = $reservation->event->icon ?? '';
            echo '<div class="event"> <span class="icon"> <i class="' . $icon . '"></i> </span></div>';
        }
        ?>
    </div>
</div>
