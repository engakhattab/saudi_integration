@extends('Admin/layouts/master')

@section('title') {{$setting->title}} | Duration Clients Spent @endsection
@section('page_name') Duration Clients Spent @endsection

@section('css')
    @include('layouts.loader.formLoader.loaderCss')

@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
                <h3 class="card-title">{{$setting->title}} Clients Duration Spent</h3>
            </div>
           <form id="hoursFilterForm" method="get">
                <div class="row m-3">
                    <div class="col-md-3">
                        <label>Hour *</label>
                        <select id="hoursFilter" name="hours_filter" class="form-control">
                            <option value=""> All Hours </option>
                            <option value="1">1 Hour</option>
                            <option value="2">2 Hours</option>
                            <option value="3">3 Hours</option>
                            <option value="4">4 Hours</option>
                            <option value="5">5 Hours</option>
                            <option value="6">6 Hours</option>
                            <option value="7">7 Hours</option>
                            <option value="8">8 Hours</option>
                            <option value="9">9 Hours</option>
                            <option value="10">10 Hours</option>

                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary" type="submit">Query</button>
                    </div>
                </div>
            </form>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-nowrap w-100" id="clients-table">
                        <thead>
                            <tr class="fw-bolder text-muted bg-light">
                                <th>#</th>
                                <th>Client Name</th>
                                <th>Phone</th>
                                <th class="text-center">Duration Spent</th>
                                <th class="text-center">Visit Dates</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Visit Details Modal -->
            <div class="modal fade" id="visitDetailsModal" tabindex="-1" aria-labelledby="visitDetailsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="visitDetailsModalLabel">Client Visit Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Visit Date</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="visitDetailsBody">
                                    <tr><td colspan="2" class="text-center">Loading...</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
</div>
@include('Admin/layouts/myAjaxHelper')
@endsection
@section('ajaxCalls')


<script>
$(document).ready(function() {
    let table = $('#clients-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
        url: '{{ route("duration.data") }}',
        data: function (d) {
            d.hours_filter = $('#hoursFilter').val();
        }
    },
        pageLength: 50,
        lengthMenu: [[50, 100, 200, 300, -1], [50, 100, 200, 300, 'All']],
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: (data, type, row, meta) => meta.row + meta.settings._iDisplayStart + 1
            },
            { data: 'client_name', name: 'client_name' },
            { data: 'phone', name: 'phone' },
            { data: 'total_hours_spent', name: 'total_hours_spent', className: 'text-center' },
            { data: 'visit_dates', name: 'visit_dates', className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        dom: 'Blfrtip',
        buttons: [
            { extend: 'copy', text: 'Copy', className: 'btn-primary' },
            { extend: 'print', text: 'Print', className: 'btn-primary' },
            { extend: 'excel', text: 'Excel', className: 'btn-primary' },
            { extend: 'pdf', text: 'PDF', className: 'btn-primary' },
            { extend: 'colvis', text: 'Visibility', className: 'btn-primary' },
        ],
        language: {
            searchPlaceholder: "Search visitors...",
            search: "",
            zeroRecords: "No Data",
            processing: "Loading...",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            lengthMenu: "Show _MENU_ rows",
            infoEmpty: "No entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                previous: "Previous",
                next: "Next"
            }
        }

    });

    $('#hoursFilterForm').on('submit', function (e) {
        e.preventDefault();
        table.ajax.reload(); // Reload table with new filter
    });

    $('#clients-table').on('click', '.details-btn', function() {
        const clientPhone = $(this).data('client-phone');
        if (!clientPhone) {
            alert('Client phone not available.');
            return;
        }

        $('#visitDetailsBody').html('<tr><td colspan="2" class="text-center">Loading...</td></tr>');
        $.ajax({
            url: `duration-clients/${encodeURIComponent(clientPhone)}/visit-dates`,
            method: 'GET',
            success: function(data) {
                if (data.length === 0) {
                    $('#visitDetailsBody').html('<tr><td colspan="2" class="text-center">No visits found.</td></tr>');
                    return;
                }
                let rows = data.map(d => `<tr><td>${d.visit_date}</td><td>${d.paid_amount}</td></tr>`).join('');
                $('#visitDetailsBody').html(rows);
            },
            error: function() {
                $('#visitDetailsBody').html('<tr><td colspan="2" class="text-center text-danger">Failed to load data.</td></tr>');
            }
        });

        new bootstrap.Modal(document.getElementById('visitDetailsModal')).show();
    });

});
</script>
@endsection
