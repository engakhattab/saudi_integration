<div class="dayDetails bg-gradient-primary">

    <h1 class="dateNum"> {{date('d',strtotime($date))}} </h1>
    <p class="dateName"> {{date('l',strtotime($date))}} </p>


    <div class="capacityInfo">
        <h4>Capacity <span> ( {{$countDay}} : {{$countOfTheDay}} ) </span></h4>
        <div class="capacityValue">{{$percent}}%</div>
        <div class="capacityContainer" >
            <div class="capacityPercentage" style="width: {{$percent}}%;"></div>
        </div>
    </div>


    <div class="details" style="height:300px;overflow-y: auto">
        <h6 class="title"> All Events :</h6>

        @foreach($reservations as $reservation)
        <div class="event"> <span class="icon"> <i class="{{$reservation->event->icon??''}}"></i> </span>
            <p> {{$reservation->client_name??''}} </p>
        </div>
        @endforeach
    </div>
    @if(date('Y-m-d') <= $date && $countDay < $countOfTheDay)
    <a href="{{route('reservations.create')}}?day={{base64_encode(strtotime($date))}}" class="btn btn-white w-100"> <i class="fal fa-plus-octagon fs-5 me-2"></i> Add Reservation             </a>
    @endif
</div>
