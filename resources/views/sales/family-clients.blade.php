@extends('sales.layouts.master')

@section('links')
    Family Clients
@endsection

@section('page_title')
    {{$setting->title}} | Family Clients
@endsection

@section('content')
    <div class="container-fluid pt-4">
        <h2 class="MainTiltle mb-5 ms-4"> Family Clients </h2>

        <!-- Search Form -->
        <form method="GET" action="{{ route('familyClient.index') }}" class="mb-3">
            <div class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by name or email or phone">
                <button type="submit" class="input-group-text ms-2 bg-gradient-primary px-4 text-body">
                    <i class="fas fa-search text-white"></i>
                </button>
            </div>
        </form>

        <div class="card p-2 py-4 mt-3">
            <!-- Table -->
            <table class="customDataTable table table-bordered nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Note</th>
                    <th>Rate</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td>{{$client->id}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->phone}}</td>
                        <td>{{$client->email}}</td>
                        <td>{{ ($client->cityYA->title ?? '') . ' / ' . ($client->governorateYA->title ?? '') }}</td>
                        <td>{{ $client->note ?? '---' }}</td>
                        <td>
                            @if($client->rate)
                                <ul class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <li><i class='fas fa-star {{ $client->rate >= $i ? 'gold' : '' }}'></i></li>
                                    @endfor
                                </ul>
                            @else
                                -----
                            @endif
                        </td>
                        <td>
                            <span class="controlIcons">
                                <span class="icon rateSpan" data-id="{{$client->id}}"> <i class="fas fa-star me-2"></i> Rate </span>
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No clients found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            <!-- Pagination Links -->
            {{$clients->links()}}

            <!-- Modal for Rating -->
            <div class="modal fade" id="modal-rate" tabindex="-1" role="dialog" aria-labelledby="modal-rate" aria-hidden="true">
                <div class="modal-dialog modal-danger modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-print"> Rate </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times text-dark fs-4"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <input class="client_id" name="id" type="hidden">
                                <div class="star-icon">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" id="rating{{$i}}" name="rateForm" value="{{$i}}" {{ $i == 1 ? 'checked' : '' }}>
                                        <label for="rating{{$i}}" class="fas fa-star"></label>
                                    @endfor
                                </div>
                                <textarea id="note" class="form-control" rows="5" placeholder="Add Note..."></textarea>
                                <button type="button" id="rateBtn" class="input-group-text bg-gradient-primary mt-3 m-auto py-2 px-4 text-white">
                                    Rate
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.customDataTable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                "order": [0, 'desc'],
                buttons: ['excel']
            });
        });

        $('#main-family').addClass('active');
        $('.familyClients').addClass('active');
        $('#familySale').addClass('show');

        $(document).on('click', '.rateSpan', function () {
            var client_id = $(this).data('id');
            $('#modal-rate').modal('show');
            $('.client_id').val(client_id);
        });

        $(document).on('click', '#rateBtn', function () {
            var id = $('.client_id').val(), note = $('#note').val(), rateForm = $('input[name="rateForm"]:checked').val();
            $('#rateBtn').html('<span class="spinner-border spinner-border-sm mr-2"></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
            $.ajax({
                type: 'POST',
                url: "{{ route('rateClient') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': id,
                    'rateForm': rateForm,
                    'note': note,
                },
                success: function (data) {
                    if (data.status === 200) {
                        toastr.success(data.message);
                        location.reload();
                    } else {
                        toastr.error(data.message);
                    }
                    $('#rateBtn').html(`Rate`).attr('disabled', false);
                    $("#modal-rate").modal('hide');
                }
            });
        });
    </script>
@endsection
