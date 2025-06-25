@extends('Admin.layouts.master')

@section('title')
    {{$setting->title}} | Total Today Sales
@endsection
@section('page_name')
    Total Today Sales
@endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endsection
<style>
.table-striped tbody tr:nth-of-type(odd){
display: none;
}
.table-striped tbody tr:nth-of-type(even){
display: none;
}
</style>

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$setting->title}} Total Today Sales</h3>
                </div>
                <form action="" method="get">
                    <div class="row mb-3 ml-3">
                        <div class="col-md-3 mt-3">
                            <label>Date *</label>
                            <div class="">
                                <div id="reportrange"
                                     style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                    <i class="fa fa-calendar"></i>&nbsp;
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                            <label>from</label>
                            <input type="date" class="form-control" name="starting_date" value="{{$starting_date}}"/>
                            <label>to</label>
                            <input type="date" class="form-control" name="ending_date" value="{{$ending_date}}"/>
                        </div>
                        <div class="col-md-2 mt-3">
                            <label>Payment Method *</label>
                            <div class="">
                                <select class="form-control" name="payment_method">
                                    <option value="">All</option>
                                    <option {{$request->payment_method == 'cash'?'selected':''}}>cash</option>
                                    <option {{$request->payment_method == 'visa'?'selected':''}}>visa</option>
                                    <option {{$request->payment_method == 'mastercard'?'selected':''}}>mastercard</option>
                                    <option {{$request->payment_method == 'Meeza'?'selected':''}}>Meeza</option>
                                    <option {{$request->payment_method == 'voucher'?'selected':''}}>Voucher</option>
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
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                        <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-50px">#</th>
                                <th class="min-w-50px">Ticket Price</th>
                                <th class="min-w-50px">Total TopUp</th>
                                <th class="min-w-50px">Ent Tax</th>
                                <th class="min-w-50px">VAT</th>
                                <th class="min-w-50px">Total</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th colspan="1">Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <!-- Delete Modal -->
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
                        <button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss_delete_modal">Back</button>
                        <button type="button" class="btn btn-danger" id="delete_btn">Delete !</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editOrCreate" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" id="modalContent">
                </div>
            </div>
        </div>
    </div>

    @include('Admin.layouts.myAjaxHelper')
@endsection

@section('ajaxCalls')
    <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.12.1/api/sum().js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function () {
            var columns = [
                { data: 'name', name: 'name' },
                { data: 'total_price', name: 'total_price' },
                { data: 'total_top_up_price', name: 'total_top_up_price' },
                { data: 'ent_tax', name: 'ent_tax' },
                { data: 'vat', name: 'vat' },
                { data: 'total', name: 'total' },
            ];

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('totalTodaySales') }}",
                    data: function (d) {
                        d.starting_date = $('input[name=starting_date]').val();
                        d.ending_date = $('input[name=ending_date]').val();
                        d.payment_method = $('select[name=payment_method]').val();
                        d.employee_id = $('select[name=employee_id]').val();
                        d.payment_status = $('select[name=payment_status]').val();
                    }
                },
                columns: columns,
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api(), data;

                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    var totalPrice = api
                        .column(1)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var TotalTopUpPrice = api
                        .column(2)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalEntTax = api
                        .column(3)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var totalVat = api
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    var grandTotal = api
                        .column(5)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    $(api.column(1).footer()).html(totalPrice.toFixed(2));
                    $(api.column(2).footer()).html(TotalTopUpPrice.toFixed(2));
                    $(api.column(3).footer()).html(totalEntTax.toFixed(2));
                    $(api.column(4).footer()).html(totalVat.toFixed(2));
                    $(api.column(5).footer()).html(grandTotal.toFixed(2));
                }
            });
        });

        function cb(start, end) {
            $('input[name="starting_date"]').val(start.format('YYYY-MM-DD'));
            $('input[name="ending_date"]').val(end.format('YYYY-MM-DD'));
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        var start = moment({{strtotime($starting_date) *1000}});
        var end = moment({{strtotime($ending_date)*1000}});

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            }
        }, cb);
        cb(start, end);

    </script>
@endsection
