@extends('sales.layouts.master')
@section('page_title')
    {{$setting->title}} | Add Reservation
@endsection
@section('content')
    <h2 class="MainTiltle mb-5 ms-4"> Add Reservation </h2>

    <form action="{{route('reservations.store')}}" method="POST" enctype="multipart/form-data" id="Form"
          class="card p-2 py-4 mt-3 ">
        @csrf
        <input type="hidden" name="day" value="{{$date}}">
        <div class="row">
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-fire me-1"></i> Reservation Type </label>
                <select class="form-control" name="event_id" id="choices-Reservation">
                    <option value="" disabled selected>Choose the Reservation Type</option>
                    {!! optionForEach($events,'id','title') !!}
                </select>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-user me-1"></i> Client Name</label>
                <div class="input-group">
                    <input class="form-control" type="text" name="client_name" placeholder="Type here...">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-envelope me-1"></i> Email</label>
                <div class="input-group">
                    <input class="form-control" type="email" name="email" placeholder="Type here...">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"><i class="fas fa-phone-square me-1"></i> Phone</label>
                <div class="input-group">
                    <input class="form-control numbersOnly" type="text" name="phone" placeholder="Type here...">
                </div>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label "><i class="fas fa-venus-mars me-1"></i> gender</label>
                <div class="choose">
                    <div class="genderOption">
                        <input type="radio" class="btn-check" name="gender" value="male" id="option1">
                        <label class=" mb-0 btn btn-outline" for="option1">
                            <span class="me-2"> <i class="fas fa-male"></i> </span>
                            <span> male </span>
                        </label>
                    </div>
                    <div class="genderOption">
                        <input type="radio" class="btn-check" name="gender" value="female" id="option2">
                        <label class=" mb-0 btn btn-outline" for="option2">
                            <span class="me-2"> <i class="fas fa-female"></i> </span>
                            <span> female </span>
                        </label>
                    </div>
                </div>
            </div>

            {{--          --}}{{--start--}}{{--    --}}
            {{--          <div class="col-sm-4 p-2">--}}
            {{--            <label class="form-label"> <i class="fas fa-flag me-1"></i> Governorate </label>--}}
            {{--            <select class="form-control" name="gov_id" id="choices-governorate">--}}
            {{--                <option value="" disabled selected>Choose the Governorate </option>--}}
            {{--                {!! optionForEach($governorates,'id','title') !!}--}}
            {{--            </select>--}}
            {{--          </div>--}}
            {{--          <div class="col-sm-4 p-2">--}}
            {{--            <label class="form-label"> <i class="fas fa-city me-1"></i> City </label>--}}
            {{--            <select class="form-control" name="city_id" id="choices-city">--}}
            {{--                <option value="" disabled selected>Choose the Governorate </option>--}}
            {{--            </select>--}}
            {{--          </div>--}}
            {{--          --}}{{--end--}}


            {{--start--}}
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-flag me-1"></i> Governorate </label>
                <select class="form-control" name="gov_id" id="choices-governorate">
                    <option value="" disabled selected>Choose the Governorate</option>
                    @foreach($governorates as $governorate)

                        <option value="{{$governorate->id}}">{{$governorate->title}} </option>

                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-city me-1"></i> City </label>
                <select class="form-control" name="city_id" id="choices-city">
                    <option value="" disabled selected>Choose the Governorate</option>
                </select>
            </div>
            {{--end--}}

            <div class="col-12 p-2" id="BirthdayInfo" style="display:none;">
                <label class="form-label"> <i class="fas fa-birthday-cake me-1"></i> Birthday Info </label>
                <div class="BirthdayInfo">
                    <div class="row ">
                        <div class="col-sm-4 p-2">
                            <label class="form-label"> <i class="fas fa-user me-1"></i> Name</label>
                            <div class="input-group">
                                <input class="form-control" name="name" type="text" placeholder="Type here...">
                            </div>
                        </div>
                        <div class="col-sm-4 p-2">
                            <label class="form-label"> <i class="fas fa-envelope me-1"></i> Email</label>
                            <div class="input-group">
                                <input class="form-control" type="email" name="email_" placeholder="Type here...">
                            </div>
                        </div>
                        <div class="col-sm-4 p-2">
                            <label class="form-label"><i class="fas fa-phone-square me-1"></i> Phone</label>
                            <div class="input-group">
                                <input class="form-control numbersOnly" type="text" name="phone_"
                                       placeholder="Type here...">
                            </div>
                        </div>
                        <div class="col-sm-6 p-2">
                            <label class="form-label "><i class="fas fa-venus-mars me-1"></i> gender</label>
                            <div class="choose">
                                <div class="genderOption">
                                    <input type="radio" class="btn-check" name="gender_" value="male" id="Gender1">
                                    <label class=" mb-0 btn btn-outline" for="Gender1">
                                        <span class="me-2"> <i class="fas fa-male"></i> </span>
                                        <span> male </span>
                                    </label>
                                </div>
                                <div class="genderOption">
                                    <input type="radio" class="btn-check" name="gender_" value="female" id="Gender2">
                                    <label class=" mb-0 btn btn-outline" for="Gender2">
                                        <span class="me-2"> <i class="fas fa-female"></i> </span>
                                        <span> female </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-6 p-2">
                    <label class="form-label"> <i class="fas fa-road me-1"></i> Building No </label>
                    <div class="input-group">
                        <input class="form-control" placeholder="Type Here..." name="building" id="building">
                    </div>
                </div>
                <div class="col-sm-6 p-2">
                    <label class="form-label"> <i class="fas fa-road me-1"></i> Street Name </label>
                    <div class="input-group">
                        <input class="form-control" placeholder="Type Here..." name="street" id="street">
                    </div>
                </div>
                <div class="col-sm-6 p-2">
                    <label class="form-label"> <i class="fas fa-road me-1"></i> District Name </label>
                    <div class="input-group">
                        <input class="form-control" placeholder="Type Here..." name="district" id="district">
                    </div>
                </div>
                <div class="col-sm-6 p-2">
                    <label class="form-label"> <i class="fas fa-road me-1"></i> Address Details </label>
                    <div class="input-group">
                        <input class="form-control" placeholder="Type Here..." name="address" id="address">
                    </div>
                </div>
                <div class="col-sm-6 p-2">
                    <label class="form-label"> <i class="fas fa-road me-1"></i> VAT No </label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Type Here..." name="vat_num"
                               id="vat_num">
                    </div>
                </div>
                <div class="col-sm-6 p-2">
                    <label class="form-label"> <i class="fas fa-road me-1"></i> Zip Code </label>
                    <div class="input-group">
                        <input type="number" class="form-control" placeholder="Type Here..." name="zip" id="zip">
                    </div>
                </div>
            </div>


        </div>
        <div class="text-center w-80 w-sm-30 m-auto">
            <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Confirm</button>
        </div>
    </form>
@endsection
@section('js')
    <script>
        $('#main-group').addClass('active')
        $('.createReservation').addClass('active')
        $('#groupSale').addClass('show')

        ////////////////////////////////////////////
        // choice Js
        ////////////////////////////////////////////
        if (document.getElementsByClassName('choices-Reservation')) {
            var element = document.getElementById('choices-Reservation');
            const options = new Choices(element, {
                searchEnabled: false
            });
        }
        // if (document.getElementsByClassName('choices-governorate')) {
        //   var element = document.getElementById('choices-governorate');
        //   const options = new Choices(element);
        // }
        // // if (document.getElementById('choices-city')) {
        // //   var element = document.getElementById('choices-city');
        // //   const options = new Choices(element);
        // // }
        if (document.getElementById('choices-reference')) {
            var element = document.getElementById('choices-reference');
            const options = new Choices(element, {
                searchEnabled: false
            });
        }
        {{--var governorates = JSON.parse('<?php echo json_encode($governorates) ?>')--}}

        {{--$(document).on('change','#choices-governorate',function () {--}}
        {{--    var id = $(this).val();--}}
        {{--    var governorate = governorates.filter(oneObject => oneObject.id == id)--}}
        {{--    if (governorate.length > 0){--}}

        {{--        var cities = governorate[0].cities--}}

        {{--        $('#choices-city').html('<option value="">Choose the city</option>')--}}

        {{--        $.each(cities, function(index){--}}
        {{--            console.log(cities[index].title)--}}
        {{--            $('#choices-city').append('<option value="'+cities[index].id+'">'+cities[index].title+'</option>')--}}
        {{--        })--}}
        {{--    }--}}
        {{--})--}}

        $(document).on('change', '#choices-Reservation', function () {
            var id = $(this).val();
            if (id == 1) {
                $('#BirthdayInfo').show();
            } else {
                $('#BirthdayInfo').hide();

            }
        })

        $("form#Form").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#Form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('.spinner').show()
                },
                complete: function () {
                    setTimeout(function () {
                        $('.spinner').hide()
                    }, 200)
                },
                success: function (data) {


                    setTimeout(function () {
                        toastr.success('saved successfully');
                    }, 250)

                    window.setTimeout(function () {
                        window.location.href = data.url;
                    }, 700);


                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('there is an error');
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value, key);
                                });

                            } else {
                            }
                        });
                    } else {

                        toastr.error('there in an error');
                    }
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });


        //=============================================================================================================================================================
        $(document).ready(function () {

            $('select[name="gov_id"]').on('change', function () {

                var gov_id = $(this).val();
                if (gov_id) {
                    $.ajax({
                        url: "{{ URL::to('cities') }}/" + gov_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="city_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="city_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>
@endsection

