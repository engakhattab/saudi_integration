@extends('Admin/layouts/master')

@section('title')
    {{$setting->title}} | Timing
@endsection
@section('page_name')
    Timing
@endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$setting->title}} Working Shifts</h3>
                    <div class="d-flex">
                        <div class="mr-3">
                            <button class="btn btn-secondary btn-icon text-white addBtn" disabled>
									<span>
										<i class="fe fe-plus"></i>
									</span> Add New
                            </button>
                        </div>
                        <div class="d-flex flex-column">
                            <button class="btn btn-danger mb-1 btn-icon text-white outTicketBtn">
									<span>
										Out All Tickets
									</span>
                            </button>
                            <small style="color:gray;">double click for submit</small>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">Start From</th>
                                <th class="min-w-50px">Ends at</th>
                                <th class="min-w-50px rounded-end">Actions</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">Delete Time</h5>
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
    <script>
        var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                        </div>
        `;

        var columns = [
            {data: 'id', name: 'id'},
            {data: 'from', name: 'from'},
            {data: 'to', name: 'to'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('timing.index')}}', columns, 1);
        deleteScript('{{route('timing.delete')}}');

        // Get Edit View
        $(document).on('click', '.editBtn', function () {
            var id = $(this).data('id')
            var url = "{{route('timing.edit',':id')}}";
            url = url.replace(':id', id)
            $('#modalContent').html(loader)
            $('#editOrCreate').modal('show')

            setTimeout(function () {
                $('#modalContent').load(url)
            }, 250)
            setTimeout(function () {
            }, 500)
        })

        // Get Add View
        $(document).on('click', '.addBtn', function () {
            $('#modalContent').html(loader)
            $('#editOrCreate').modal('show')
            setTimeout(function () {
                $('#modalContent').load('{{route('timing.create')}}')
            }, 250)
        });

        // Add By Ajax
        $(document).on('submit', 'Form#addForm', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#addForm').attr('action');
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
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success('Data added successfully');
                    } else if (data.status == 402) {
                        toastr.error("Shift Can't Be Between Existed Shifts");
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
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success('Data updated successfully');
                    } else
                        toastr.error('There is an error');

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
                    $('#updateButton').html(`Update`).attr('disabled', false);
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

        $(document).on('dblclick', '.outTicketBtn', function () {
            // URL to which the GET request will be sent
            var url = '{{ route('ResetTicketUpdate') }}'; // Replace '/your-endpoint-url' with your actual endpoint URL

            // Callback function to handle the response from the server
            function handleResponse(response) {
                // Handle the response here
                toastr.info(response, '', {
                    positionClass: 'toast-top-center',
                });
                console.log('Response from server:', response);
            }

            // Sending the GET request
            $.ajax({
                type: 'GET',
                url: url,
                success: handleResponse, // Success handler
                error: function (xhr, status, error) {
                    // Error handler
                    toastr.error(error);
                    console.error('Error:', error);
                }
            });
        });


    </script>
@endsection


