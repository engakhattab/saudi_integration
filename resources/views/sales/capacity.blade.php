@extends('sales.layouts.master')
@section('page_title')
    {{$setting->title}} | Capacity
@endsection
@section('content')
      <h2 class="MainTiltle mb-5 ms-4"> {{$setting->title}} Capacity </h2>

      <div class="card p-2 py-4">
        <div class=" row ">
          <div class="col-lg-9 p-2">
            <div class="calendar">
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
            </div>
          </div>
          <div class="col-lg-3 p-2">
              <div id="loadDay">

              </div>
          </div>

        </div>
      </div>
@endsection


@section('js')
    <script>

        $('#main-group').addClass('active')
        $('.capacity').addClass('active')
        $('#groupSale').addClass('show')
        loadDay("{{date('Y-m-d')}}")

        $(document).on('click','.anotherMonth',function (e) {
            e.preventDefault();
             var url = $(this).data('href')
            console.log(url)
            $.ajax({
                url:url,
                type: 'GET',
                beforeSend: function(){
                    $('.spinner').show()
                },
                complete: function(){


                },
                success: function (data) {
                    if (data.status == 200){
                        console.log(data.html)
                        $('.calendar').html(data.html)
                        var newurl = data.url;
                        window.history.pushState({path:newurl},'',newurl);
                    }else {
                        window.location = "{{route('capacity.index')}}?month={{date('Y-m')}}"
                    }

                    setTimeout(function () {
                        $('.spinner').hide()
                    })

                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('there in an error');
                    }else {

                        toastr.error('there in an error');
                    }
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });

        })

        $(document).on('click','.getData',function (e) {
            e.preventDefault();
            var date = $(this).data('date');
            console.log(date);
            loadDay(date)
        });

        function loadDay(date) {
            var url = "{{route('capacity.show',':id')}}";
            url = url.replace(':id',date)

            $('.spinner').show()

            $("#loadDay").load(url,function(){
                    $('.spinner').hide()
            });

            $('.day').removeClass('active')
            $('.'+date).addClass('active')
            $('.{{date('Y-m-d')}}').addClass('toDay')


            if (date == "{{date('Y-m-d')}}"){
                $('.{{date('Y-m-d')}}').removeClass('toDay')
            }
        }

    </script>
@endsection
