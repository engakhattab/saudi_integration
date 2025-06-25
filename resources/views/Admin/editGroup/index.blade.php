@extends('Admin/layouts/master')

@section('title') {{$setting->title}} | Groups @endsection
@section('page_name') Groups @endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-custom-success">
            {{ session('success') }}
            <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$setting->title}} | Groups</h3>
                    <div class=""></div>
                </div>
                <form action="" method="get">
                    <div class="row mb-3 ml-3">
                        <div class="col-md-3 mt-3">
                            <label>Date *</label>
                            <div id="reportrange" class="form-control">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
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
                                    <th class="min-w-25px">#</th>
                                    <th class="min-w-50px">Added By</th>
                                    <th class="min-w-50px">Ticket Num</th>
                                    <th class="min-w-50px">Ticket Type</th>
                                    <th class="min-w-50px">Date</th>
                                    <th class="min-w-50px">Time</th>
                                    <th class="min-w-50px">Client</th>
                                    <th class="min-w-50px">Status</th>
                                    <th class="min-w-50px">Hours</th>
                                    <th class="min-w-50px">Visitors Count</th>
                                    <th class="min-w-50px">Payment Status</th>
                                    <th class="min-w-50px">Product Price</th>
                                    <th class="min-w-50px">Ticket Price</th>
                                    <th class="min-w-50px">VAT</th>
                                    <th class="min-w-50px">Total Price</th>
                                    <th class="min-w-50px">Payment Method</th>
                                    <th class="min-w-50px">Cancel</th>
                                    <th class="min-w-50px" aria-label="Details" scope="col">Details</th>
                                    <th class="min-w-50px" aria-label="Actions" scope="col">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade bd-example-modal-lg" id="editOrCreate" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" id="modalContent"></div>
                </div>
            </div>
            <!-- Edit Modal Closed -->


        <!--Admin can Delete ticket MODAL -->
                <div class="modal fade" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_id" name="id" type="hidden">
                        <p>Do you want to Delete this Row Group<span id="title" class="text-danger"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                                id="dismiss_delete_modal">
                            Back
                        </button>
                        <input type="hidden" id="input">
                        <button type="button" class="btn btn-danger" id="delete_btn">Delete Group !</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- MODAL CLOSED -->

            <!--Admin can cancel ticket MODAL -->
            <div class="modal fade" id="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cancel Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input id="delete_id" name="id" type="hidden">
                        <p>Do you want to cancel this Row Group<span id="title" class="text-danger"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"
                                id="dismiss_cancel_modal">
                            Back
                        </button>
                        <input type="hidden" id="input">
                        <button type="button" class="btn btn-danger" id="Cancel_btn">Cancel Group!</button>
                    </div>
                </div>
            </div>
            </div>
                <!-- Cansel CLOSED -->


            <!-- Details Modal -->
            <div class="modal fade bd-example-modal-lg" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-topUp">Group Details</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeIcon">
                                <i class="fal fa-times text-dark fs-4"></i>
                            </button>
                        </div>
                        <div class="modal-body text-center" id="detailsModalBody"></div>
                    </div>
                </div>
            </div>
            <!-- Details Modal Closed -->
    </div>
    @include('Admin/layouts/myAjaxHelper')
</div>
@endsection

@section('ajaxCalls')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    var loader = `<div class="linear-background">
                    <div class="inter-crop"></div>
                    <div class="inter-right--top"></div>
                    <div class="inter-right--bottom"></div>
                  </div>`;

    var columns = [
    {data: 'id', name: 'id'},
    {data: 'add_by', name: 'add_by'},
    {data: 'ticket_num', name: 'ticket_num'},
    {data: 'event_id', name: 'event_id'},
    {data: 'day', name: 'day'},
    {data: 'created_at', name: 'created_at'},
    {data: 'client_id', name: 'client_id'},
    {data: 'status', name: 'status'},
    {data: 'hours_count', name: 'hours_count'},
    {data: 'visitors', name: 'visitors'},
    {data: 'payment_status', name: 'payment_status'},
    {data: 'product_price', name: 'product_price'},
    {data: 'ticket_price', name: 'ticket_price'},
    {data: 'vat', name: 'vat'},
    {data: 'total_price', name: 'total_price'},
    {data: 'payment_method', name: 'payment_method'},
    {data: 'cancel', name: 'cancel'},
    {data: 'ticket_types', name: 'ticket_types', orderable: false, searchable: false },
    {data: 'actions', name: 'actions', orderable: false, searchable: false },

];

        showData(window.location.href, columns);

        var start = moment({{ strtotime($starting_date) * 1000 }});
        var end = moment({{ strtotime($ending_date) * 1000 }});

        function cb(start, end) {
            $('input[name="starting_date"]').val(start.format('YYYY-MM-DD'));
            $('input[name="ending_date"]').val(end.format('YYYY-MM-DD'));
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

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

         // Get Details View
                $(document).on('click', '.showSpan', function () {
            var id = $(this).attr('data-id');
            var url = "{{ route('detailsOfReservation', ':id') }}".replace(':id', id);

            console.log("Fetching details from: ", url); // Debugging line

            $('#detailsModalBody').html(loader);
            $('#detailsModal').modal('show');

            $.ajax({
                url: url,
                method: 'GET',
                success: function (data) {
                    $('#detailsModalBody').html(data);
                },
                error: function (xhr, status, error) {
                    console.error("Error fetching details: ", error); // Debugging line
                    $('#detailsModalBody').html('<p>Error loading details.</p>');
                }
            });
        });

     // Delete Ticket By Admin
                    $(document).on('click','.delete',function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $("#input").val(id);
                    $('#delete_modal').modal('show');

                });

                $(document).on('click','#delete_btn',function(e) {
                    e.preventDefault();
                    var id = $("#input").val();
                    $.ajax({
                        url: '{{ route('groups.delete_reservation')}}',
                        type: 'POST',
                        data: {
                            '_token': "{{csrf_token()}}",
                            'id': id,
                        },
                        beforeSend: function () {
                            $('#delete_btn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                                ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
                        },

                        success: function (data) {

                        if (data.status === 200) {
                        $('#dataTable').DataTable().ajax.reload();
                        $('#delete_modal').modal('hide');
                        toastr.success('Ticket number ' + data.ticket_number + ' deleted successfully');

                        // Reload the page after a brief delay (optional)
                        setTimeout(function() {
                            location.reload();
                        }, 2000); // Adjust the delay (in milliseconds) as needed
                        } else {
                        toastr.error('There is an error');

                        }
                    },

                    });
                });

                // Cancel Ticket By Admin
                $(document).on('click','.cancel',function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    $("#input").val(id);
                    $('#cancel_modal').modal('show');

                });

                $(document).on('click','#Cancel_btn',function(e) {
                    e.preventDefault();
                    var id = $("#input").val();
                    $.ajax({
                        url: '{{route('admin.sales.CancelGroupUpdateMethod')}}',
                        type: 'POST',
                        data: {
                            '_token': "{{csrf_token()}}",
                            'id': id,
                        },
                        beforeSend: function () {
                            $('#Cancel_btn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                                ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
                        },

                        success: function (data) {

                            if (data.status == 200){
                                $('#dataTable').DataTable().ajax.reload();
                                $('#cancel_modal').modal('hide');
                                toastr.success('Ticket number ' + data.ticket_number + ' canceled successfully');
                            }
                            else
                                toastr.error('There is an error');
                        },

                    });
                });



    </script>
    <style>
        .alert-custom-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-custom-success');
        const successSound = document.getElementById('success-sound');

        if (successAlert) {
            successSound.addEventListener('canplaythrough', function() {
                successSound.play().catch(error => {
                    console.error('Audio play error:', error);
                });
            });

            setTimeout(function() {
                successAlert.style.opacity = 0;
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 500);
            }, 5000);

            const closeButton = document.querySelector('.alert-custom-success .close');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    const alert = this.parentElement;
                    alert.style.opacity = 0;
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);
                });
            }
        }
    });

 </script>


@endsection
