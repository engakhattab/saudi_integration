@extends('sales.layouts.master')
@section('page_title')
    {{$setting->title}} | Reservations
@endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
@endsection
@section('content')
    <h2 class="MainTiltle mb-5 ms-4"> Reservations </h2>
    <form class="card p-2 py-4 w-100 w-sm-80 m-auto ">
        <div class="row">
            <div class="col-12 p-2">
                <div class="row align-items-end">
                    <div class="col-sm-9 p-1">
                        <label class="form-label fs-4"> <i class="fas fa-ticket-alt me-2"></i> Search </label>
                        <div class="d-flex">
                            <input type="text" class="form-control" placeholder="Type here..." id="searchText">
                            <button type="button" id="SearchBtn"
                                    class="input-group-text ms-2 bg-gradient-primary px-4 text-body"
                                    onclick="doSearch()"><i
                                    class="fas fa-search text-white"></i></button>
                        </div>
                    </div>
                    <div class="col-sm-3 p-1">
                        <a href="{{route('capacity.index')}}?month={{date('Y-m')}}"
                           class="btn bg-gradient-primary w-100 p-3 text-white"> <i
                                class="fal fa-plus-octagon fs-5 me-2 "></i> Add Reservation </a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> Reservation Type </label>
                <select class="form-control" id="choices-type">
                    <option value="all"> All</option>
                    @foreach($events as $event)
                        <option value="{{$event->id}}"> {{$event->title}} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> shift </label>
                <select class="form-control" id="choices-shift" name="shift_id">
                    <option selected value="all">All</option>
                    @foreach($shifts as $shift)
                        <option value="{{$shift->id}}">{{date('H a', strtotime($shift->from))}}
                            : {{date('H a', strtotime($shift->to))}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </form>
    <div class="card p-2 py-4 mt-3 table-responsive">
        <!-- table -->
        <table class=" customDataTable table table-bordered nowrap" id="DataTable">
            <thead>
            <tr>
                <th>Sale Number</th>
                <th>Date</th>
                <th>Type</th>
                <th> Customer Name</th>
                <th>contact number</th>
                <th>start time</th>
                <th>end time</th>
                <th>Quantity</th>
                <th>actions</th>
            </tr>
            </thead>
            <tbody id="tableBody">

            </tbody>


        </table>
        <!--Edit MODAL -->
        <div class="modal fade bd-example-modal-lg" id="editOrCreate" tabindex="-1" role="dialog"
             aria-labelledby="editOrCreate"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-topUp"> Edit Reservation </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times text-dark fs-4"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center" id="modalBody">

                    </div>

                </div>
            </div>
        </div>

        <!--Details MODAL -->
        <div class="modal fade bd-example-modal-lg" id="detailsModal" tabindex="-1" role="dialog"
             aria-labelledby="detailsModal"
             aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="modal-title-topUp"> Reservation Details </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <i class="fal fa-times text-dark fs-4"></i>
                        </button>
                    </div>
                    <div class="modal-body text-center" id="detailsModalBody">

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
    </div>
@endsection
@section('js')
    <script>
        function dismiss() {
            $('#delete_modal').modal('hide');
        }

        $('#main-group').addClass('active')
        $('.createReservation').addClass('active')
        $('#groupSale').addClass('show')
        ////////////////////////////////////////////
        // choice Js
        ////////////////////////////////////////////
        if (document.getElementById('choices-type')) {
            var element = document.getElementById('choices-type');
            const options = new Choices(element, {
                searchEnabled: false
            });
        }
        if (document.getElementById('choices-shift')) {
            var element = document.getElementById('choices-shift');
            const options = new Choices(element, {
                searchEnabled: false
            });
        }
    </script>

    <script>
        var table = $('.customDataTable').DataTable({
            responsive: true,
        });
        new $.fn.dataTable.FixedHeader(table);

        function doSearch() {
            var searchText = $('#searchText').val(),
                choices_type = $('#choices-type').val(),
                choices_shift = $('#choices-shift').val(),
                data = {
                    'searchText': searchText,
                    'choices_type': choices_type,
                    'choices_shift': choices_shift,
                };
            $.ajax({
                type: 'GET',
                data: data,
                url: "{{route('searchForReservations')}}",
                beforeSend: function () {
                    $('#SearchBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;"></span>');
                },
                success: function (data) {
                    if (data.status === 200) {
                        table.clear().draw();
                        var Rows = data.html;
                        $.each(Rows, function (key, val) {
                            table.row.add(data.html[key]).draw(false);
                        })
                    } else {
                        toastr.error('There is an error');
                    }
                    $('#SearchBtn').html('<i class="fas fa-search text-white"></i>');
                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('There is an error');
                    }
                    $('#SearchBtn').html('<i class="fas fa-search text-white"></i>');
                },
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
                $.ajax({
                    type: 'POST',
                    url: "{{route('delete_reservation')}}",
                    data: {
                        '_token': "{{csrf_token()}}",
                        'id': id,
                    },
                    success: function (data) {
                        if (data.status === 200) {
                            toastr.success(data.message)
                            $('#SearchBtn')[0].click();
                        } else {
                            toastr.error(data.message)
                        }
                        $("#delete_modal").modal('hide');
                    }
                });
            });


            // Get Edit View
            var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;
            $(document).on('click', '.editSpan', function () {
                var id = $(this).attr('data-id');
                var url = "{{route('editReservation',':id')}}";
                url = url.replace(':id', id)
                $('#modalBody').html(loader)
                $('#editOrCreate').modal('show')
                setTimeout(function () {
                    $('#modalBody').load(url)
                }, 250)
            })
            // Get Details View
            $(document).on('click', '.showSpan', function () {
                var id = $(this).attr('data-id');
                var url = "{{route('detailsReservation',':id')}}";
                url = url.replace(':id', id)
                $('#detailsModalBody').html(loader)
                $('#detailsModal').modal('show')
                setTimeout(function () {
                    $('#detailsModalBody').load(url)
                }, 250)
            })
        }


    </script>

@endsection

