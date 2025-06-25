@extends('sales.layouts.master')
@section('links')
    Add Client
@endsection
@section('page_title')
    {{$setting->title}} | Add Client
@endsection
@section('content')
    <form action="{{route('client.search')}}" method="GET" id="SearchForm" class="card p-3 py-4  w-100 w-sm-80 m-auto mb-4 ">
        <label class="form-label fs-4"><i class="fas fa-phone-square-alt me-2"></i> Phone</label>
        <div class="d-flex">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
            <button type="submit" id="SearchBtn" class="input-group-text ms-2 bg-gradient-primary px-4 text-body"><i class="fas fa-search text-white"></i></button>
        </div>
    </form>
    <h2 class="MainTitle mb-2 mt-2 ms-4" id="addClient" style="display:none;"> Add Client</h2>
    <form action="{{route('client.store')}}" style="display: none" method="post" enctype="multipart/form-data" id="AddForm" class="card p-2 py-4 mt-3 ">
        @csrf
        <div class="row">
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-user me-1"></i> Client Name</label>
                <div class="input-group">
                    <input class="form-control" name="name" type="text" id="name" placeholder="Type Here...">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-envelope me-1"></i> Email</label>
                <div class="input-group">
                    <input class="form-control" name="email" type="email" id="email" placeholder="Type Here...">
                </div>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label "><i class="fas fa-venus-mars me-1"></i> Gender</label>
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
{{--            <div class="col-sm-4 p-2">--}}
{{--                <label class="form-label"> <i class="fas fa-flag me-1"></i> Governorate </label>--}}
{{--                <select class="form-control" id="choices-governorate" name="gov_id">--}}
{{--                    <option value="" disabled selected>Choose The Governorate</option>--}}
{{--                    {!! optionForEach($governorates,'id','title') !!}--}}
{{--                </select>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4 p-2">--}}
{{--                <label class="form-label"> <i class="fas fa-city me-1"></i> City </label>--}}
{{--                <select class="form-control" id="choices-city" name="city_id">--}}
{{--                    <option value="" disabled selected>Choose The City</option>--}}

{{--                </select>--}}
{{--            </div>--}}

            {{--start--}}
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-flag me-1"></i> Governorate </label>
                <select class="form-control" name="gov_id" id="choices-governorate">
                    <option value="" disabled selected>Choose the Governorate </option>
                    @foreach($governorates as $governorate)

                        <option value="{{$governorate->id}}" >{{$governorate->title}} </option>

                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-city me-1"></i> City </label>
                <select class="form-control" name="city_id" id="choices-city">
                    <option value="" disabled selected>Choose the Governorate </option>
                </select>
            </div>
            {{--end--}}
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="far fa-tv-retro me-1"></i> Reference </label>
                <select class="form-control" id="choices-reference" name="ref_id">
                    <option value="" disabled selected>Choose The Reference</option>
                    {!! optionForEach($references,'id','title') !!}
                </select>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-users-crown me-1"></i> family size</label>
                <div class="input-group">
                    <input class="form-control" type="number" placeholder="Type Here..." name="family_size" id="family_size" min="0">
                </div>
            </div>
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
                    <input type="number" class="form-control" placeholder="Type Here..." name="vat_num" id="vat_num">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> Zip Code </label>
                <div class="input-group">
                    <input type="number" class="form-control" placeholder="Type Here..." name="zip" id="zip">
                </div>
            </div>
        </div>
        <div class="text-center w-80 w-sm-30 m-auto">
            <button type="submit" id="addButton" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">ADD</button>
        </div>
    </form>
@endsection

@section('js')
    <script>

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
        $('#main-family').addClass('active')
        $('.createClient').addClass('active')
        $('#familySale').addClass('show')
        $("form#AddForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("phone", $('#phone').val())
            var url = $('#AddForm').attr('action');
            $.ajax({
                url:url,
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('#addButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);

                },
                complete: function(){


                },
                success: function (data) {
                    if (data.status == 200){
                        var url = "{{route('ticket.show',":id")}}";
                        url = url.replace(':id',data.data.id)
                        toastr.success('client added successfully');
                        window.setTimeout(function() {
                            window.location.href=url;
                        }, 1000);
                    }else {
                        toastr.error('Error !');
                        $('#addButton').html(`Loading`).attr('disabled', false);
                    }

                },
                error: function (data) {
                    if (data.status === 500) {
                        $('#loginButton').html(`ADD`).attr('disabled', false);
                        toastr.error('There is an error');
                    }
                    else if (data.status === 422) {
                        $('#addButton').html(`ADD`).attr('disabled', false);
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value,key);
                                });
                            }
                        });
                    }else {
                        $('#addButton').html(`ADD`).attr('disabled', false);
                        toastr.error('there in an error');
                    }
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

        $("form#SearchForm").submit(function(e) {
            e.preventDefault();
            var phone = $('#phone').val()
            var url = $('#SearchForm').attr('action')+"?phone="+phone;
            $.ajax({
                url:url,
                type: 'GET',
                data: {'phone':phone},
                beforeSend: function(){
                    $('#SearchBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;"></span>');
                },
                complete: function(){


                },
                success: function (data) {
                    if (data.status == 200){
                        toastr.success('Welcome Back ! '+data.client.name);
                        var url = "{{route('ticket.show',":id")}}";
                        url = url.replace(':id',data.client.id)
                        window.setTimeout(function() {
                            window.location.href=url;
                        }, 1000);
                        $('#SearchBtn').html('<i class="fas fa-search text-white"></i>');
                        $('#name').val(data.client.name);
                        $('#email').val(data.client.email);
                        $('#family_size').val(data.client.family_size);
                        if(data.client.gender == 'male')
                            $('#option1').prop('checked', true);
                        else
                            $('#option2').prop('checked', true);
                        $('#choices-reference').val(data.client.ref_id);
                        $('#choices-governorate').val(data.client.gov_id).change();
                        $('#choices-city').val(data.client.city_id);
                    }else {
                        // toastr.success('Welcome To SkyPark');
                        $("form#AddForm").show();
                        $("#addClient").show();
                        $('#SearchBtn').html('<i class="fas fa-search text-white"></i>');
                        $('#name').val(null);
                        $('#email').val(null);
                        $('#family_size').val(null);
                        $('#option1').prop('checked', false);
                        $('#option2').prop('checked', false);
                        $('#choices-reference').val(null);
                        $('#choices-governorate').val(null);
                        $('#choices-city').val(null);
                    }
                },
                error: function (data) {
                    if (data.status === 500) {
                        $('#SearchBtn').html('<i class="fas fa-search text-white"></i>');
                        toastr.error('There is an error');
                    }
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

        // Show Governorates
        {{--var governorates = JSON.parse('<?php echo json_encode($governorates) ?>');--}}

        {{--$(document).on('change', '#choices-governorate', function () {--}}
        {{--    var id = $(this).val();--}}
        {{--    var governorate = governorates.filter(oneObject => oneObject.id == id)--}}
        {{--    if (governorate.length > 0) {--}}
        {{--        var cities = governorate[0].cities--}}

        {{--        $('#choices-city').html('<option value="">Choose The City</option>')--}}

        {{--        $.each(cities, function (index) {--}}
        {{--            $('#choices-city').append('<option value="' + cities[index].id + '">' + cities[index].title + '</option>')--}}
        {{--        })--}}
        {{--    }--}}
        {{--})--}}
    </script>
@endsection
