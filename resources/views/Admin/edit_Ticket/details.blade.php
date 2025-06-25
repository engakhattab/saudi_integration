@extends('Admin.layouts.master')

@section('title') {{ $setting->title }} | Ticket Details @endsection
@section('page_name') Ticket Details @endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ticket Details</h3>
                <a href="{{ route('tickets.select') }}" class="btn btn-secondary btn-sm float-right">Back</a>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4>General Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Ticket Number</th>
                                <td>{{ $ticket->ticket_num }}</td>
                            </tr>
                            <tr>
                                <th>Visit Date</th>
                                <td>{{ $ticket->visit_date->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <th>Client</th>
                                <td>{{ $ticket->client->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td>
                                    @if($ticket->payment_status)
                                        <span class="badge badge-success">Paid</span>
                                    @else
                                        <span class="badge badge-danger">Not Paid</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Financial Information</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Ticket Price</th>
                                <td>${{ number_format($ticket->ticket_price, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Ent Tax</th>
                                <td>${{ number_format($ticket->ent_tax, 2) }}</td>
                            </tr>
                            <tr>
                                <th>VAT</th>
                                <td>${{ number_format($ticket->vat, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total Price</th>
                                <td>${{ number_format($ticket->total_price, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <h4>Additional Details</h4>
                        <p>{{ $ticket->details ?? 'No additional details' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
