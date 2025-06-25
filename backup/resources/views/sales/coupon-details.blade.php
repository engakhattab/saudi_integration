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
          <h6> {{$rev->client_name}} Corporation Visitors </h6>
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCoupon">
            <i class="far fa-plus me-1"></i> New Visitor
          </button>
        </div>
        <!-- table -->
        <table class=" customDataTable table table-bordered nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Sale Number</th>
              <th> Name </th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          @foreach($rev->models as $model)
            <tr>
              <td>{{$model->id}}</td>
              <td>{{$model->coupon_num}}</td>
              <td>{{$model->name}}</td>
              <td>
                <span class="controlIcons">
                  <span class="icon" title="print"><a target="_blank" href="{{route("printCoupon",$model->id)}}"><i class="far fa-print"></i></a>
                  </span>
                        <span class="icon deleteSpan" data-id="{{$model->id}}" data-title="{{$model->coupon_num}}">
                      <i class="far fa-trash-alt"></i>
                        </span>
                </span>
              </td>
            </tr>
          @endforeach

          </tbody>
        </table>

      </form>

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
                      <p>Are You Sure Of Deleting This Visitor <span id="title" class="text-danger"></span>?</p>
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

      <div class="modal fade" id="addCoupon" tabindex="-1" role="dialog" aria-labelledby="addCoupon" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title" id="modal-title-print">Add New</h6>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fal fa-times text-dark fs-4"></i>
              </button>
            </div>
            <form action="{{route('sales.couponsVisitor.store')}}" id="createForm">
                @csrf
                <input type="hidden" name="rev_id" value="{{$rev->id}}">
              <div class="modal-body">
                <div class="row">
                  <div class="col-12 p-2">
                    <label class="form-label"> <i class="fas fa-user me-1"></i> Name </label>
                    <div class="input-group">
                      <input class="form-control" name="name" type="text" placeholder="Type here...">
                    </div>
                  </div>
                    <div class="col-12 p-2">
                        <label class="form-label"> <i class="fas fa-users me-1"></i> Type </label>
                        <div class="input-group">
                        <select name="visitor_type_id" class="form-control">
                            @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->title}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-dark ml-auto me-2" data-bs-dismiss="modal"> Close </button>
                <button type="submit" class="btn btn-success" id="addButton"> add </button>
              </div>
            </form>
          </div>
        </div>
      </div>
@endsection
@section('js')
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script>
    function dismiss() {
        $('#delete_modal').modal('hide');
    }
    $(document).ready(function () {
        var table = $('.customDataTable').DataTable({
            responsive: true,
            dom: 'Bfrtip',
            "order": [ 0, 'desc' ],
            buttons: [
              'excel'
            ]
        });
        // new $.fn.dataTable.FixedHeader(table);
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
            url: "{{route('sales.couponsVisitors.delete')}}",
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
                $('#addButton').html(`Add`).attr('disabled', false);
                $('#addCoupon').modal('hide')
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
</script>
@endsection
