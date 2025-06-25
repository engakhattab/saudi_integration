@extends('Admin.layouts.master')

@section('title') {{ $setting->title }} | Edit Ticket @endsection
@section('page_name') Edit Ticket @endsection

@section('content')
<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h4>Ticket</h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="visit_date">Visit Date</label>
                <input type="date" class="form-control @error('visit_date') is-invalid @enderror" id="visit_date" name="visit_date" value="{{ old('visit_date', $ticket->visit_date->format('Y-m-d')) }}" required>
                @error('visit_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="payment_method">Payment Method</label>
                <select class="form-control @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method">
                    <option value="cash" {{ old('payment_method', $ticket->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="visa" {{ old('payment_method', $ticket->payment_method) == 'visa' ? 'selected' : '' }}>Visa</option>
                </select>
                @error('payment_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="add_by">Employee</label>
                <select class="form-control @error('add_by') is-invalid @enderror" id="add_by" name="add_by">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('add_by', $ticket->add_by) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                @error('add_by')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="rem_amount">Remaining Amount</label>
                <input type="number" step="0.01" class="form-control @error('rem_amount') is-invalid @enderror" id="rem_amount" name="rem_amount" value="{{ old('rem_amount', $ticket->rem_amount) }}">
                @error('rem_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="status">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="in" {{ old('status', $ticket->status) == 'in' ? 'selected' : '' }}>In</option>
                    <option value="out" {{ old('status', $ticket->status) == 'out' ? 'selected' : '' }}>Out</option>
                    <option value="append" {{ old('status', $ticket->status) == 'append' ? 'selected' : '' }}>Append</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="cancel">Cancel</label>
                <select class="form-control" id="cancel" name="cancel">
                    <option value="0" {{ $ticket->cancel ? 'selected' : '' }}>Cancelled</option>
                    <option value="1" {{ !$ticket->cancel ? 'selected' : '' }}>Active</option>
                </select>
            </div>
        </div>

        <h4>Ticket Rev Model</h4>
        <div id="ticket-models">
            @if($ticket->models->isNotEmpty())
                <div class="row mb-3">
                    @foreach ($ticket->models as $model)
                        <div class="col-md-12 mb-2 ticket-model" data-model-id="{{ $model->id }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="visitor_type_{{ $model->id }}">Visitor Type</label>
                                    <select id="visitor_type_{{ $model->id }}" name="ticket_rev_models[{{ $model->id }}][visitor_type_id]" class="form-control @error("ticket_rev_models.{$model->id}.visitor_type_id") is-invalid @enderror">
                                        <option value="" disabled {{ old("ticket_rev_models.{$model->id}.visitor_type_id") ? '' : 'selected' }}>Select Visitor Type</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" {{ old("ticket_rev_models.{$model->id}.visitor_type_id", $model->visitor_type_id) == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                    @error("ticket_rev_models.{$model->id}.visitor_type_id")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <label for="price_{{ $model->id }}">Price</label>
                                    <input type="number" step="0.01" class="form-control @error("ticket_rev_models.{$model->id}.price") is-invalid @enderror" id="price_{{ $model->id }}" name="ticket_rev_models[{{ $model->id }}][price]" value="{{ old("ticket_rev_models.{$model->id}.price", $model->price) }}">
                                    @error("ticket_rev_models.{$model->id}.price")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label for="bracelet_number_{{ $model->id }}">Bracelet</label>
                                    <input type="text" class="form-control @error("ticket_rev_models.{$model->id}.bracelet_number") is-invalid @enderror"
                                           id="bracelet_number_{{ $model->id }}"
                                           name="ticket_rev_models[{{ $model->id }}][bracelet_number]"
                                           value="{{ old("ticket_rev_models.{$model->id}.bracelet_number", $model->bracelet_number) }}"
                                           >
                                    @error("ticket_rev_models.{$model->id}.bracelet_number")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="top_up_price_{{ $model->id }}">Top Up Price</label>
                                        <input type="number" step="0.01" class="form-control @error("ticket_rev_models.{$model->id}.top_up_price") is-invalid @enderror"
                                            id="top_up_price_{{ $model->id }}"
                                            name="ticket_rev_models[{{ $model->id }}][top_up_price]"
                                            value="{{ old("ticket_rev_models.{$model->id}.top_up_price", $model->top_up_price) }}"
                                            oninput="calculateValue({{ $model->id }})"
                                            placeholder="Enter price">
                                        @error("ticket_rev_models.{$model->id}.top_up_price")
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <span id="calculated_value_{{ $model->id }}" class="form-control-plaintext" style="display: none; cursor: pointer;"
                                            onclick="copyToInput({{ $model->id }})">
                                            {{ number_format(old("ticket_rev_models.{$model->id}.top_up_price", $model->top_up_price), 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label for="top_up_hours_{{ $model->id }}">Top Up Time (h)</label>
                                    <input type="number" min="0" max="24" class="form-control @error("ticket_rev_models.{$model->id}.top_up_hours") is-invalid @enderror" id="top_up_hours_{{ $model->id }}" name="ticket_rev_models[{{ $model->id }}][top_up_hours]" value="{{ old("ticket_rev_models.{$model->id}.top_up_hours", $model->top_up_hours) }}">
                                    @error("ticket_rev_models.{$model->id}.top_up_hours")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-2">
                                    <label for="shift_end_{{ $model->id }}">Shift End</label>
                                    <input type="time" class="form-control @error("ticket_rev_models.{$model->id}.shift_end") is-invalid @enderror" id="shift_end_{{ $model->id }}" name="ticket_rev_models[{{ $model->id }}][shift_end]" value="{{ old("ticket_rev_models.{$model->id}.shift_end", $model->shift_end) }}">
                                    @error("ticket_rev_models.{$model->id}.shift_end")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label for="total_after_discount_{{ $model->id }}">Total Discount</label>
                                        <input type="number" step="0.01" min="0" class="form-control @error("ticket_rev_models.{$model->id}.total_after_discount") is-invalid @enderror" id="total_after_discount_{{ $model->id }}" name="ticket_rev_models[{{ $model->id }}][total_after_discount]"
                                            value="{{ old("ticket_rev_models.{$model->id}.total_after_discount", $model->total_after_discount) }}">
                                        @error("ticket_rev_models.{$model->id}.total_after_discount")
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <button type="button" class="btn btn-danger" onclick="this.closest('.ticket-model').remove()">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mb-3">
                <button type="button" id="add-model-btn" class="btn btn-primary">Add Ticket</button>
            </div>
        </div>

        <h4>Payments</h4>

        @if($ticket->payments->isNotEmpty())
            <div class="row">
                @foreach($ticket->payments as $payment)
                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <!-- Payment Amount Field -->
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="amount_{{ $payment->id }}">Amount</label>
                                    <input type="number" step="0.01"
                                        class="form-control @error('payments.'.$payment->id.'.amount') is-invalid @enderror"
                                        id="amount_{{ $payment->id }}"
                                        name="payments[{{ $payment->id }}][amount]"
                                        value="{{ old('payments.'.$payment->id.'.amount', $payment->amount) }}">
                                    @error('payments.'.$payment->id.'.amount')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Method Field -->
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="payment_method_{{ $payment->id }}">Payment Method</label>
                                    <select class="form-control @error('payments.'.$payment->id.'.payment_method') is-invalid @enderror"
                                            id="payment_method_{{ $payment->id }}"
                                            name="payments[{{ $payment->id }}][payment_method]">
                                        <option value="cash" {{ old('payments.'.$payment->id.'.payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="visa" {{ old('payments.'.$payment->id.'.payment_method', $payment->payment_method)  == 'visa' ? 'selected' : '' }}>Visa</option>
                                    </select>
                                    @error('payments.'.$payment->id.'.payment_method')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No payments available.</p>
        @endif

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

<script src="{{ asset('js/your-script.js') }}" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    let modelCount = 0; // Track the number of models added

    function removeModelRow(index) {
        const row = document.getElementById(`model_row_${index}`);
        if (row) {
            row.remove();
        }
    }

    document.getElementById('add-model-btn').addEventListener('click', function() {
        // Increment the model count
        const newModelHTML = `
            <div class="row mb-4" id="model_row_${modelCount}">
                <div class="col-md-3">
                    <label for="visitor_type_${modelCount}">Visitor Type</label>
                    <select id="visitor_type_${modelCount}" name="ticket_rev_models[${modelCount}][visitor_type_id]" class="form-control">
                        <option value="" disabled selected>Select Visitor Type</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="price_${modelCount}">Price</label>
                    <input type="number" step="0.01" class="form-control" id="price_${modelCount}" name="ticket_rev_models[${modelCount}][price]" value="">
                </div>
                <div class="col-md-3">
                    <label for="total_after_discount_${modelCount}">Total After Discount</label>
                    <input type="number" step="0.01" class="form-control" id="total_after_discount_${modelCount}" name="ticket_rev_models[${modelCount}][total_after_discount]" value="">
                </div>

                    <button type="button" class="btn btn-danger" onclick="removeModelRow(${modelCount})">
                        <i class="fas fa-trash-alt"></i> Remove
                    </button>

            </div>
        `;

        // Insert the new model row into the DOM
        document.getElementById('ticket-models').insertAdjacentHTML('beforeend', newModelHTML);

        // Increment the model count for the next model
        modelCount++;
    });
</script>

<script>
    function calculateValue(modelId) {
        const topUpPriceInput = document.getElementById(`top_up_price_${modelId}`);
        const calculatedValueDisplay = document.getElementById(`calculated_value_${modelId}`);

        const newTopUpPrice = parseFloat(topUpPriceInput.value);

        // Update calculated value display
        const adjustedValue = isNaN(newTopUpPrice) ? '$0.00' : `${(newTopUpPrice / 1.15).toFixed(2)}`;
        calculatedValueDisplay.textContent = adjustedValue;

        // Show or hide the calculated value based on input
        calculatedValueDisplay.style.display = newTopUpPrice > 0 ? 'block' : 'none';
    }

    function copyToInput(modelId) {
        const calculatedValueDisplay = document.getElementById(`calculated_value_${modelId}`);
        const topUpPriceInput = document.getElementById(`top_up_price_${modelId}`);

        // Extract the numeric value from the displayed text
        const numericValue = parseFloat(calculatedValueDisplay.textContent.replace(/[^0-9.-]+/g, ''));

        // Set the input value to the numeric value
        if (!isNaN(numericValue)) {
            topUpPriceInput.value = numericValue.toFixed(2);
            calculateValue(modelId); // Update the calculated value
        }
    }
</script>

@endsection
