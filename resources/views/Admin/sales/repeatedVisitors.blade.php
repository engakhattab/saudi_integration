@extends('Admin/layouts/master')

@section('title') {{$setting->title}} | Repeated Visitors @endsection
@section('page_name') Repeated Visitors
@endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')

@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0">Repeated Visitors</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered text-nowrap w-100" id="repeatedVisitorsTable">
            <thead>
                <tr class="fw-bolder text-muted bg-light">
                    <th style="width: 5%;">#</th>
                    <th>Client Name</th>
                    <th>Phone</th>
                    <th style="width: 10%;">Total Visits</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- Modal for Visit Dates -->
<div class="modal fade" id="visitDatesModal" tabindex="-1" aria-labelledby="visitDatesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="visitDatesModalLabel">Visit Dates</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="visitDatesContent">
                <p class="text-center text-muted">Loading...</p>
            </div>
        </div>
    </div>
</div>
@include('Admin/layouts/myAjaxHelper')
@endsection
 @section('ajaxCalls')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const visitDatesModalEl = document.getElementById('visitDatesModal');
    const visitDatesModal = new bootstrap.Modal(visitDatesModalEl);

    const visitDatesRoute = "{{ route('repeatedVisitors.visitDatesByPhone', ['phone' => '__PHONE__']) }}";
let table = $('#repeatedVisitorsTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route('repeatedVisitors.data') }}',
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
        { data: 'total_visits', name: 'total_visits' },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ],

    language: {
        searchPlaceholder: "Search visitors...",
        search: "",
        sZeroRecords: "No Data",
        sProcessing: "Loading...",
        sInfo: "Showing _START_ to _END_ of _TOTAL_ entries",
        sLengthMenu: "Show _MENU_ rows",
        sInfoEmpty: "No entries",
        sInfoFiltered: "(filtered from _MAX_ total entries)",
        oPaginate: {
            sPrevious: "Previous",
            sNext: "Next"
        }
    },

    dom: 'Blfrtip',
    buttons: [
        {
            extend: 'copy',
            text: 'Copy',
            className: 'btn-primary'
        },
        {
            extend: 'print',
            text: 'Print',
            className: 'btn-primary'
        },
        {
            extend: 'excel',
            text: 'Excel',
            className: 'btn-primary'
        },
        {
            extend: 'pdf',
            text: 'PDF',
            className: 'btn-primary'
        },
        {
            extend: 'colvis',
            text: 'Visibility',
            className: 'btn-primary'
        },
    ],

    });

    $('#repeatedVisitorsTable').on('click', '.show-dates', function () {
        let phone = $(this).data('client-phone');
        $('#visitDatesContent').attr('aria-live', 'polite').html('<div class="text-center"><div class="spinner-border text-primary"></div></div>');
        visitDatesModal.show();

        $.get(visitDatesRoute.replace('__PHONE__', encodeURIComponent(phone)))
            .done(function (dates) {
                if (dates.length === 0) {
                    $('#visitDatesContent').html('<p>No visits found for this phone number.</p>');
                } else {
                    let list = '<ul class="list-group">';
                    dates.forEach(date => {
                        list += `<li class="list-group-item">${date}</li>`;
                    });
                    list += '</ul>';
                    $('#visitDatesContent').html(list);
                }
            })
            .fail(function () {
                $('#visitDatesContent').html('<p class="text-danger">Failed to load visit dates.</p>');
            });
    });
});

</script>

@endsection
