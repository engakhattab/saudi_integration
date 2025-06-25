@extends('sales.layouts.master')
@section('links')
    Family Clients
@endsection
@section('page_title')
    {{$setting->title}} | Family Clients
@endsection
@section('content')
    <content class="container-fluid pt-4">
        <!-- ((((((((((((((((((((((((((((((((((((((((((())))))))))))))))))))))))))))))))))))))))))) -->
        <!-- ((((((((((((((((((((((((((((((((((((((((((())))))))))))))))))))))))))))))))))))))))))) -->
        <!-- ((((((((((((((((((((((((((((((((((((((((((())))))))))))))))))))))))))))))))))))))))))) -->
        <!-- ((((((((((((((((((((((((((((((((((((((((((())))))))))))))))))))))))))))))))))))))))))) -->
        <h2 class="MainTiltle mb-5 ms-4"> Family Clients </h2>
{{--        <form class="card p-3 py-4 w-100 w-sm-80 m-auto ">--}}
{{--            <label class="form-label fs-4"> <i class="fas fa-phone-alt me-2"></i> phone number </label>--}}
{{--            <div class="d-flex">--}}
{{--                <input type="text" class="form-control" placeholder="Type here...">--}}
{{--                <button type="submit" class="input-group-text ms-2 bg-gradient-primary px-4 text-body"><i--}}
{{--                        class="fas fa-search text-white"></i></button>--}}
{{--            </div>--}}
{{--        </form>--}}
        <div class="card p-2 py-4 mt-3 ">
            <!-- table -->
            <table class=" customDataTable table table-bordered nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>note</th>
                    <th>Rate</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($clients as $clinet)
                <tr>
                    <td>{{$clinet->id}}</td>
                    <td> {{$clinet->name}} </td>
                    <td> {{$clinet->phone}} </td>
                    <td> {{$clinet->email}} </td>
                    <td> {{($clinet->cityYA->title) ?? ''}} / {{($clinet->governorateYA->title) ?? ''}} </td>
                    <td> {{ ($clinet->note) ?? '---'}} </td>
                @if($clinet->rate != 0 && $clinet->rate != null)
                    <td>
                        <ul class="rating">
                            @for($i = 1 ;$i <= 5;$i++)
                            <li> <i class='fas fa-star {{($clinet->rate >= $i) ? 'gold' : ''}}'></i> </li>
                            @endfor
                        </ul>
                    </td>
                    @else
                        <td>-----</td>
                    @endif
                    <td>
                <span class="controlIcons">
                  <span class="icon rateSpan" data-id="{{$clinet->id}}"> <i
                          class="fas fa-star me-2"></i> Rate </span>
                </span>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{$clients->links()}}
            <div class="modal fade" id="modal-rate" tabindex="-1" role="dialog" aria-labelledby="modal-rate"
                 aria-hidden="true">
                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-print"> Rate </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times text-dark fs-4"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form >
                                <input class="client_id" name="id" type="hidden">
                                <div class="star-icon">
                                    <input type="radio" checked name="rateForm" id="rating1" value="1">
                                    <label for="rating1" class="fas fa-star"></label>

                                    <input type="radio" name="rateForm" id="rating2" value="2">
                                    <label for="rating2" class="fas fa-star"></label>

                                    <input type="radio" name="rateForm" id="rating3" value="3">
                                    <label for="rating3" class="fas fa-star"></label>

                                    <input type="radio" name="rateForm" id="rating4" value="4">
                                    <label for="rating4" class="fas fa-star"></label>

                                    <input type="radio" name="rateForm" id="rating5" value="5">
                                    <label for="rating5" class="fas fa-star"></label>
                                </div>

                                <textarea name="" id="note" class="form-control" rows="5" placeholder="Add Note..."></textarea>

                                <button type="button" id="rateBtn" class="input-group-text bg-gradient-primary mt-3 m-auto py-2 px-4 text-white">
                                    Rate
                                </button>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        $('#main-family').addClass('active')
        $('.familyClients').addClass('active')
        $('#familySale').addClass('show')

        function dismiss() {
            $('#modal-rate').modal('hide');
        }
        $(document).on('click', '.rateSpan', function (event) {
            var client_id = $(this).attr('data-id');
            var title = $(this).attr('data-title');
            $('#modal-rate').modal('show')
            $('.client_id').val(client_id)
            $('#title').text(title)
        });
        $(document).on('click', '#rateBtn', function (event) {
            var id = $('.client_id').val(), note = $('#note').val(), rateForm = $('input[name = "rateForm"]:checked').val();
            $('#rateBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: "{{route('rateClient')}}",
                data: {
                    '_token': "{{csrf_token()}}",
                    'id': id,
                    'rateForm': rateForm,
                    'note': note,
                },
                success: function (data) {
                    if (data.status === 200) {
                        toastr.success(data.message)
                        location.reload();
                    } else {
                        toastr.error(data.message)
                    }
                    $('#rateBtn').html(`Rate`).attr('disabled', false);
                    $("#modal-rate").modal('hide');
                }
            });
        });

    </script>
@endsection
