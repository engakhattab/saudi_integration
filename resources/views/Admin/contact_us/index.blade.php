@extends('Admin/layouts/master')

@section('title') {{$setting->title}} | Contact us @endsection
@section('page_name') Contact us @endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
@endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Clients Messages</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-100px">name</th>
                                <th class="min-w-70px">phone</th>
                                <th class="min-w-50px">email</th>
                                <th class="max-w-50px">message</th>
                                <th class="min-w-25px">status</th>
                                <th class="w-10">date</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
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
    </div>
    @include('Admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')
    <script>
        var columns = [
            {data: 'id', name: 'id'},
            {data: 'first_name', name: 'first_name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'message', name: 'message'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('contact_us.index')}}', columns);
        deleteScript('{{route('contact_us.delete')}}');
        // Make Better Using Ajax
        $(document).on('click', '.readSpan', function () {
            var id = $(this).attr("data-id")
            $.ajax({
                type: 'POST',
                url: "{{route('read_message')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': id,
                },
                success: function (data) {
                    if (data.status === 200) {
                        $('#dataTable').DataTable().ajax.reload();
                        toastr.success('Message Read Done');
                        var span = $(".contact");
                        if(data.count>0)
                            span.html(data.count);
                        else
                            span.remove();
                    }
                }
            });
        });
    </script>
@endsection


