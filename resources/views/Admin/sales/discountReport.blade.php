@extends('Admin/layouts/master')

@section('title') {{$setting->title}} | Discount Reports @endsection
@section('page_name') Discount Reports @endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$setting->title}} Discount Reports</h3>
                    <div class="">
                    </div>
                </div>

                <form action="" method="get">
                    <div class="row mb-3 ml-3">
                        <div class="col-md-3 mt-3">
                            <label>Date *</label>

{{--                            <div class="">--}}
{{--                                <div id="reportrange"--}}
{{--                                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">--}}
{{--                                    <i class="fa fa-calendar"></i>&nbsp;--}}
{{--                                    <span></span> <i class="fa fa-caret-down"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <label>from</label>
                            <input type="date" class="form-control"  name="starting_date" value="{{$starting_date}}"/>
                            <label>to</label>
                            <input type="date" class="form-control"  name="ending_date" value="{{$ending_date}}"/>
                        </div>
                        {{--                        <div class="col-md-2 mt-3">--}}
                        {{--                            <label>Category *</label>--}}

                        {{--                            <div class="">--}}
                        {{--                                <select class="form-control" name="event_id">--}}
                        {{--                                    <option value="All">All</option>--}}
                        {{--                                    <option value="0">Family</option>--}}
                        {{--                                    @foreach($events as $event)--}}
                        {{--                                        <option value="{{$event->id}}">{{$event->title}}</option>--}}
                        {{--                                    @endforeach--}}
                        {{--                                </select>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="col-md-2 mt-3">
                            <label>Payment Method *</label>

                            <div class="">
                                <select class="form-control" name="payment_method">
                                    <option value="">All</option>
                                    <option {{$request->payment_method == 'cash'?'selected':''}}>cash</option>
                                    <option {{$request->payment_method == 'visa'?'selected':''}}>visa</option>
                                    <option {{$request->payment_method == 'mastercard'?'selected':''}}>mastercard</option>
                                    <option {{$request->payment_method == 'Meeza'?'selected':''}}>Meeza</option>
                                    <option {{$request->payment_method == 'Voucher'?'selected':''}}>Voucher</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label>User *</label>

                            <div class="">
                                <select class="form-control" name="employee_id">
                                    <option value="">All</option>
                                    @foreach($employees as $employee)
                                        <option value="{{$employee->id}}" {{$request->employee_id == $employee->id?'selected':''}}>{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label>Status *</label>

                            <div class="">
                                <select class="form-control" name="payment_status">
                                    <option value="">All</option>
                                    <option value="1" {{$request->payment_status == '1'?'selected':''}}>Sale</option>
                                    <option value="0" {{$request->payment_status == '0'?'selected':''}}>Cancel</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label></label>
                            <div class="">
                                <button class="btn btn-primary" type="submit">Query</button>
                            </div>
                        </div>
                    </div>
                </form>


                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">id</th>
                                <th class="min-w-25px">Date</th>
                                <th class="min-w-50px">ticket num</th>
                                <th class="min-w-50px">before discount</th>
                                <th class="min-w-50px">discounted amount</th>
                                <th class="min-w-50px">discounted reasons</th>
                                <th class="min-w-50px">cashier</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!--Delete MODAL -->
        <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Row</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_id" name="id" type="hidden">
                        <p>Are You Sure Of Deleting This Row <span id="title" class="text-danger"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss_delete_modal">
                            Back
                        </button>
                        <button type="button" class="btn btn-danger" id="delete_btn">Delete !</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL CLOSED -->

        <!-- Edit MODAL -->
        <div class="modal fade" id="editOrCreate" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="modalContent">

                </div>
            </div>
        </div>
        <!-- Edit MODAL CLOSED -->
    </div>
    @include('Admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript"
            src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;

        var columns = [
            {data: 'id', name: 'id'},
            {data: 'visit_date', name: 'visit_date'},
            {data: 'ticket_num', name: 'ticket_num'},
            {data: 'before_discount', name: 'before_discount'},
            {data: 'discount_amount', name: 'discount_amount'},
            {data: 'discount_reasons', name: 'discount_reasons'},
            {data: 'cashier', name: 'cashier'},
        ]
        showData(window.location.href, columns);

        {{--var start = moment({{strtotime($starting_date) *1000}});--}}
        {{--var end = moment({{strtotime($ending_date)*1000}});--}}

        {{--function cb(start, end) {--}}
        {{--    $('input[name="starting_date"]').val(start.format('YYYY-MM-DD'));--}}
        {{--    $('input[name="ending_date"]').val(end.format('YYYY-MM-DD'));--}}
        {{--    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));--}}
        {{--}--}}

        {{--$('#reportrange').daterangepicker({--}}
        {{--    startDate: start,--}}
        {{--    endDate: end,--}}
        {{--    ranges: {--}}
        {{--        'Today': [moment(), moment()],--}}
        {{--        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],--}}
        {{--        'Last 7 Days': [moment().subtract(6, 'days'), moment()],--}}
        {{--        'Last 30 Days': [moment().subtract(29, 'days'), moment()],--}}
        {{--        'This Month': [moment().startOf('month'), moment().endOf('month')],--}}
        {{--        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],--}}
        {{--        'This Year': [moment().startOf('year'), moment().endOf('year')],--}}
        {{--        'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]--}}
        {{--    }--}}
        {{--}, cb);--}}
        {{--cb(start, end);--}}
    </script>
@endsection


