@extends('sales.layouts.master')

@section('page_title')
    Query
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto">
                {{-- The Form for selecting a date and time --}}
                <div class="card">
                    <div class="card-header p-3">
                        <h5 class="mb-0"><i class="fas fa-search-dollar me-2"></i>Visitor Query</h5>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('sales.query.search') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="query_date">Select a Date</label>
                                    <input type="date" id="query_date" name="query_date" class="form-control" value="{{ $queriedDate ?? date('Y-m-d') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="query_time">Select a Time</label>
                                    <input type="time" id="query_time" name="query_time" class="form-control" value="{{ $queriedTime ?? date('H:i') }}">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100 mb-0">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- This section will only appear after a search is performed --}}
                @isset($queriedDate)
                    <div class="card mt-4">
                        <div class="card-header p-3">
                            {{-- Display the date that was searched for --}}
                            <h5 class="mb-0">Results for: {{ \Carbon\Carbon::parse($queriedDate)->format('F d, Y') }} at {{ \Carbon\Carbon::parse($queriedTime)->format('h:i A') }}</h5>
                        </div>
                        <div class="card-body p-3">
                            {{-- Results Card --}}
                            <div class="row mb-4">
                                <div class="col-sm-6 mx-auto">
                                    <div class="card text-center">
                                        <div class="card-body">
                                            <h6 class="text-uppercase text-secondary">Total Visitors at this Time</h6>
                                            <h3 class="font-weight-bolder">{{ $totalVisitors }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tickets Table --}}
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ticket #</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Client Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client Phone</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Paid Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tickets as $ticket)
                                            <tr>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $ticket->ticket_num }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $ticket->client->name ?? 'N/A' }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ $ticket->client->phone ?? 'N/A' }}</span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ number_format($ticket->paid_amount, 2) }} SAR</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4">
                                                    <p class="mb-0">No tickets found for this specific time.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endisset

            </div>
        </div>
    </div>
@endsection
