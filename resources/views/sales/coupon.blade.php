@extends('sales.layouts.master')
@section('page_title')
    {{$setting->title}} | Corporations
@endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
@endsection
@section('content')
    <h2 class="MainTiltle mb-5 ms-4"> Corporations </h2>
    <form class="card p-2 py-4 mt-3 ">

        <div class="d-flex justify-content-between align-items-center flex-wrap px-3 pb-3 border-bottom mb-3">
            <h6> Corporations Reservations</h6>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCoupon">
                <i class="far fa-plus me-1"></i> Add
            </button>
        </div>
        <!-- table -->
        <table class=" customDataTable table table-bordered nowrap" id="dataTable">
            <thead>
            <tr>
                <th>#</th>
                <th>Sale Number</th>
                <th>Corporation Name</th>
                <th>Phone</th>
                <th>Note</th>
                <th>Coupon Start</th>
                <th>Coupon End</th>
                <th>Visitors</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reservations as $rev)
                <tr>
                    <td>{{$rev->id}}</td>
                    <td>{{$rev->ticket_num}}</td>
                    <td>{{$rev->client_name}}</td>
                    <td>{{$rev->phone}}</td>
                    <td>{{$rev->note}}</td>
                    <td>{{$rev->coupon_start}}</td>
                    <td>{{$rev->coupon_end}}</td>
                    <td>
                        @if(count($rev->models) == 0)
                            <a href="{{route('sales.couponsVisitors',$rev->id)}}"
                               class="btn btn-rounded shadow-none btn-outline-info "> <i
                                    class="far fa-plus me-1"></i> add visitor </a>
                        @else
                            <a href="{{route('sales.couponsVisitors',$rev->id)}}"
                               class="btn btn-rounded shadow-none btn-outline-info "> <i
                                    class="far fa-plus me-1"></i> show visitor </a>
                        @endif
                    </td>
                    <td>
                        <span class="controlIcons">
                            <span class="icon" data-bs-toggle="tooltip" title="print Invoice A4"><a target="_blank" href="{{ route('printRev',$rev->id) }}"> طباعة الفاتورة الالكنرونية </a> </span>
                      @if($rev->status == 'append')
                                <span class="icon editBtn" data-id="{{$rev->id}}"> <i class="far fa-edit"></i> </span>
                      @endif
                      @if($rev->status != 'in')
                                <span class="icon deleteSpan" data-id="{{$rev->id}}" data-title="{{$rev->client_name}}"> <i
                                        class="far fa-trash-alt"></i></span>
                      @endif
                      @if($rev->status == 'append')
                                <span class="icon" data-bs-toggle="tooltip" title="Access"><a
                                        href="{{route('groupAccess.index').'?search='.$rev->ticket_num}}"><i
                                            class="fal fa-check "></i></a></span>
                      @endif

                            {{--                       <span class="icon deleteSpan" data-id="{{$rev->id}}" data-title="{{$rev->client_name}}">--}}
                            {{--                      <i class="far fa-trash-alt"></i>--}}
                            {{--                        </span>--}}

                </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{$reservations->links()}}

    </form>

    <div class="modal fade" id="addCoupon" tabindex="-1" role="dialog" aria-labelledby="addCoupon" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-print">Add New</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times text-dark fs-4"></i>
                    </button>
                </div>
                <form action="{{route('sales.store.coupon')}}" id="createForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4 p-2">
                                <label class="form-label"> <i class="fas fa-building me-1"></i> Corporation Name
                                </label>
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Type here..."
                                           name="client_name">
                                </div>
                            </div>
                            <div class="col-sm-4 p-2">
                                <label class="form-label"> <i class="fas fa-phone-alt me-1"></i> Phone Number </label>
                                <div class="input-group">
                                    <input class="form-control" type="number" placeholder="Phone" name="phone">
                                </div>
                            </div>
                            <div class="col-sm-4 p-2">
                                <label class="form-label"> <i class="fas fa-envelope me-1"></i> Email</label>
                                <div class="input-group">
                                    <input class="form-control" type="email" placeholder="Email" name="email">
                                </div>
                            </div>
                            <div class="col-sm-4 p-2">
                                <label class="form-label"> <i class="fas fa-money-bill-wave me-1"></i> Paid Amount
                                </label>
                                <div class="input-group">
                                    <input class="form-control" type="number" placeholder="Amount" name="paid_amount">
                                </div>
                            </div>
                            <div class="col-sm-4 p-2">
                                <label class="form-label"> <i class="fas fa-users me-1"></i> Visitors Count </label>
                                <div class="input-group">
                                    <input class="form-control" type="number" min="1" placeholder="Count"
                                           name="visitor_count">
                                </div>
                            </div>
                            <div class="col-sm-4 p-2">
                                <label class="form-label"> <i class="fas fa-users me-1"></i> Hours Count </label>
                                <div class="input-group">
                                    <input class="form-control" type="number" min="1" max="24" placeholder="Count"
                                           name="hours_count">
                                </div>
                            </div>
                            <div class="col-sm-6 p-2">
                                <label class="form-label"> <i class="fas fa-calendar-alt me-1"></i> Coupon Start Date
                                </label>
                                <div class="input-group">
                                    <input class="form-control" type="date" name="coupon_start"
                                           value="{{date('Y-m-d')}}">
                                </div>
                            </div>
                            <div class="col-sm-6 p-2">
                                <label class="form-label"> <i class="fas fa-calendar-alt me-1"></i> Coupon End Date
                                </label>
                                <div class="input-group">
                                    <input class="form-control" type="date" name="coupon_end" value="{{date('Y-m-d')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                            <div class="col-sm-4 p-2">
                                <label class="form-label"> <i class="fas fa-road me-1"></i> Invoice Date </label>
                                <div class="input-group">
                                    <input class="form-control" type="date"
                                           value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="day" id="day">
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
                        <div class="row">
                            <div class="col-12 p-2">
                                <label class="form-label"><i class="fas fa-feather-alt me-1"></i> Note</label>
                                <textarea name="note" id="" class="form-control" rows="5"
                                          placeholder="Add Note..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark ml-auto me-2" data-bs-dismiss="modal"> Close</button>
                        <button type="submit" class="btn btn-success" id="addButton"> Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true"
         data-bs-backdrop="static">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-print">Edit Data</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fal fa-times text-dark fs-4"></i>
                    </button>
                </div>
                <div id="modalContent">

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
                    <h5 class="modal-title" id="exampleModalLabel">Delete Data</h5>
                    <button type="button" class="close btn" data-dismiss="modal" aria-label="Close"
                            onclick="dismiss()">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="delete_id" name="id" type="hidden">
                    <p>Are You Sure Of Deleting This Reservation <span id="title" class="text-danger"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="dismiss_delete_modal"
                            onclick="dismiss()">
                        Back
                    </button>
                    <button type="button" class="btn btn-danger" id="delete_btn">Delete !</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL CLOSED -->
@endsection
@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function () {
            var table = $('.customDataTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                "order": [0, 'desc'],
                buttons: [
                    'excel'
                ]
            });
            // new $.fn.dataTable.FixedHeader(table);
        });
    </script>
    <script>
        var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;

        function dismiss() {
            $('#delete_modal').modal('hide');
        }

        // Get Edit View
        $(document).on('click', '.editBtn', function () {
            var id = $(this).data('id')
            var url = "{{route('sales.coupons.edit',':id')}}";
            url = url.replace(':id', id)
            $('#modalContent').html(loader)
            $('#editModal').modal('show')

            setTimeout(function () {
                $('#modalContent').load(url)
            }, 250)
        })

        // Add By Ajax
        $(document).on('submit', 'Form#createForm', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#createForm').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('#addButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
                },
                success: function (data) {
                    if (data.status == 200) {
                        toastr.success('Coupon added successfully');
                        location.reload();
                    } else
                        toastr.error('There is an error');
                    $('#addButton').html(`Create`).attr('disabled', false);
                    $('#editOrCreate').modal('hide')
                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('There is an error');
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value, key);
                                });
                            }
                        });
                    } else
                        toastr.error('there in an error');
                    $('#addButton').html(`Create`).attr('disabled', false);
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

        // Update By Ajax
        $(document).on('submit', 'Form#updateForm', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#updateForm').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('#updateButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
                },
                success: function (data) {
                    $('#updateButton').html(`Update`).attr('disabled', false);
                    if (data.status == 200) {
                        toastr.success('Coupon updated successfully');
                        location.reload();
                    } else
                        toastr.error('There is an error');

                    $('#editModal').modal('hide')
                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('There is an error');
                    } else if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value, key);
                                });
                            }
                        });
                    } else
                        toastr.error('there in an error');
                    $('#updateButton').html(`Update`).attr('disabled', false);
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

        $(document).on('click', '.deleteSpan', function (event) {
            var delete_id = $(this).attr('data-id');
            var title = $(this).attr('data-title');
            $('#delete_modal').modal('show')
            $('.delete_id').val(delete_id)
            $('#title').text(title)
        });
        $(document).on('click', '#delete_btn', function (event) {
            var id = $('.delete_id').val();
            $('#delete_btn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: "{{route('sales.delete_coupon')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': id,
                },
                success: function (data) {
                    if (data.status === 200) {
                        toastr.success(data.message)
                        location.reload();
                    } else {
                        toastr.error(data.message)
                    }
                    $('#delete_btn').html(`Delete !`).attr('disabled', false);
                    $("#delete_modal").modal('hide');
                }
            });
        });
        $('#coupon').addClass('active');

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
