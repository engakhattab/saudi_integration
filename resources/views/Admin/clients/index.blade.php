@extends('Admin/layouts/master')

@section('title') {{$setting->title}} | Clients @endsection
@section('page_name') Clients @endsection
@section('content')

    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$setting->title}} Clients</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table table-striped table-bordered text-nowrap w-100" id="dataTable">
                            <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th class="min-w-25px">#</th>
                                <th class="min-w-50px">name</th>
                                <th class="min-w-50px">phone</th>
                                <th class="min-w-50px">email</th>
                                <th class="min-w-50px">gender</th>
                                <th class="min-w-50px">governorates</th>
                                <th class="min-w-50px">city</th>
                                <th class="min-w-25px">family size</th>
                                <th class="min-w-25px">registered at</th>
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
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'gender', name: 'gender'},
            {data: 'gov_id', name: 'gov_id'},
            {data: 'city_id', name: 'city_id'},
            {data: 'family_size', name: 'family_size'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
        showData('{{route('clients.index')}}', columns);
        deleteScript('{{route('client.delete')}}');
    </script>
@endsection


