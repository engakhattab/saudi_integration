@extends('Admin.layouts.master')

@section('title') {{ $setting->title }} | Edit Group @endsection
@section('page_name') Edit Group @endsection

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

    <form action="{{ route('groups.update', $reservation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <h4>Reservation Info</h4>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="day">Visit Date</label>
                <input type="date" class="form-control @error('day') is-invalid @enderror" id="day" name="day" value="{{ old('day', $reservation->day->format('Y-m-d')) }}" required>
                @error('day')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="payment_method">Payment Method</label>
                <select class="form-control @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method">
                    <option value="cash" {{ old('payment_method', $reservation->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="visa" {{ old('payment_method', $reservation->payment_method) == 'visa' ? 'selected' : '' }}>Visa</option>
                </select>
                @error('payment_method')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="paid_amount">Paid Amount</label>
                <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount" name="paid_amount" value="{{ old('paid_amount', $reservation->paid_amount) }}">
                @error('paid_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="rem_amount">Remaining Amount</label>
                <input type="number" class="form-control @error('rem_amount') is-invalid @enderror" id="rem_amount" name="rem_amount" value="{{ old('rem_amount', $reservation->rem_amount) }}">
                @error('rem_amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

       {{-- Tickets --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="status">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                    <option value="in" {{ old('status', $reservation->status) == 'in' ? 'selected' : '' }}>In</option>
                    <option value="out" {{ old('status', $reservation->status) == 'out' ? 'selected' : '' }}>Out</option>
                    <option value="append" {{ old('status', $reservation->status) == 'append' ? 'selected' : '' }}>Append</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="cancel">Cancel</label>
                <select class="form-control" id="cancel" name="cancel">
                    <option value="0" {{ $reservation->cancel ? 'selected' : '' }}>Cancelled</option>
                    <option value="1" {{ !$reservation->cancel ? 'selected' : '' }}>Active</option>
                </select>
            </div>
        </div>
            <div class="row mb-3">
            <div class="col-md-6">
                <label for="add_by">Reservation Type</label>
                <select class="form-control @error('event_id') is-invalid @enderror" id="event_id" name="event_id">
                    <option value="">Select Reservation Type</option>
                    @foreach($events as $event)
                        <option value="{{ $event->id }}" {{ old('event_id', $reservation->event_id) == $event->id ? 'selected' : '' }}>
                            {{ $event->title }}
                        </option>
                    @endforeach
                </select>
                @error('event_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label for="add_by">Employee</label>
                <select class="form-control @error('add_by') is-invalid @enderror" id="add_by" name="add_by">
                    <option value="">Select Employee</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('add_by', $reservation->add_by) == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
                @error('add_by')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <br>


        <h4>Ticket Rev Model</h4>
        <div id="ticket-models">
            @if($reservation->models->isNotEmpty())
                <div class="row mb-3">
                    @foreach ($reservation->models as $model)
                        <div class="col-md-12 mb-2 ticket-model" data-model-id="{{ $model->id }}">
                            <div class="row">
                                <div class="col-md-3">
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

                                <div class="col-md-3">
                                    <label for="price_{{ $model->id }}">Price</label>
                                    <input type="number" step="0.01" class="form-control @error("ticket_rev_models.{$model->id}.price") is-invalid @enderror" id="price_{{ $model->id }}" name="ticket_rev_models[{{ $model->id }}][price]" value="{{ old("ticket_rev_models.{$model->id}.price", $model->price) }}">
                                    @error("ticket_rev_models.{$model->id}.price")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-3">
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



                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <label for="total_after_discount_{{ $model->id }}">Total Discount</label>
                                        <input type="number" step="0.01" min="0" class="form-control @error("ticket_rev_models.{$model->id}.total_after_discount") is-invalid @enderror" id="total_after_discount_{{ $model->id }}" name="ticket_rev_models[{{ $model->id }}][total_after_discount]"
                                            value="{{ old("ticket_rev_models.{$model->id}.total_after_discount", $model->total_after_discount) }}">
                                        @error("ticket_rev_models.{$model->id}.total_after_discount")
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                    <button type="button" class="btn btn-danger" onclick="this.closest('.ticket-model').remove()">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mb-3">
                <button type="button" id="add-model-btn" class="btn btn-primary">Add Ticket</button>
            </div>
        </div>


<h4>Products</h4>
<div id="ticket-products">
    @if($reservation->products->isNotEmpty())
        <div class="row">
            @foreach($reservation->products as $product)
                <div class="col-md-12 mb-4">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <label for="category_id_{{ $product->id }}">Category</label>
                            <select class="form-control @error('ticket_rev_products.'.$product->id.'.category_id') is-invalid @enderror" id="category_id_{{ $product->id }}" name="ticket_rev_products[{{ $product->id }}][category_id]">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('ticket_rev_products.'.$product->id.'.category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                            @error('ticket_rev_products.'.$product->id.'.category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="product_id_{{ $product->id }}">Product Type</label>
                            <select class="form-control @error('ticket_rev_products.'.$product->id.'.product_id') is-invalid @enderror" id="product_id_{{ $product->id }}" name="ticket_rev_products[{{ $product->id }}][product_id]">
                                <option value="">Select Product Type</option>
                                @foreach($products as $prod)
                                    <option value="{{ $prod->id }}" {{ old('ticket_rev_products.'.$product->id.'.product_id', $product->product_id) == $prod->id ? 'selected' : '' }}>{{ $prod->title }}</option>
                                @endforeach
                            </select>
                            @error('ticket_rev_products.'.$product->id.'.product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="qty{{ $product->id }}">Qty</label>
                            <input type="number" class="form-control @error('ticket_rev_products.'.$product->id.'.qty') is-invalid @enderror" id="qty{{ $product->id }}" name="ticket_rev_products[{{ $product->id }}][qty]" value="{{ old('ticket_rev_products.'.$product->id.'.qty', $product->qty) }}">
                            @error('ticket_rev_products.'.$product->id.'.qty')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <label for="price{{ $product->id }}">Price</label>
                            <input type="number" class="form-control @error('ticket_rev_products.'.$product->id.'.price') is-invalid @enderror" id="price{{ $product->id }}" name="ticket_rev_products[{{ $product->id }}][price]" value="{{ old('ticket_rev_products.'.$product->id.'.price', $product->price) }}">
                            @error('ticket_rev_products.'.$product->id.'.price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-2 mb-2">
                            <label for="total_price{{ $product->id }}">Total Price</label>
                            <input type="number" class="form-control @error('ticket_rev_products.'.$product->id.'.total_price') is-invalid @enderror" id="total_price{{ $product->id }}" name="ticket_rev_products[{{ $product->id }}][total_price]" value="{{ old('ticket_rev_products.'.$product->id.'.total_price', $product->total_price) }}" readonly>
                            @error('ticket_rev_products.'.$product->id.'.total_price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="button" class="btn btn-danger" onclick="this.closest('.row').remove()">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No products available.</p>
    @endif
</div>

<div class="mb-3">
    <button type="button" id="add-product-btn" class="btn btn-primary">Add Product</button>
</div>

        <h4>Payments</h4>

        @if($reservation->payments->isNotEmpty())
            <div class="row">
                @foreach($reservation->payments as $payment)
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <!-- Payment Amount Field -->

                            <div class="col-md-3 mb-3">
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
                            <div class="col-md-3 mb-3">
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

                            <div class="col-md-3 mb-3">
                                <label for="day_{{ $payment->id }}">Date</label>
                                <input type="date" class="form-control @error('payments.'.$payment->id.'.day') is-invalid @enderror"
                                       id="day_{{ $payment->id }}" name="payments[{{ $payment->id }}][day]"
                                       value="{{ old('payments.'.$payment->id.'.day', is_string($payment->day) ? \Carbon\Carbon::parse($payment->day)->format('Y-m-d') : $payment->day->format('Y-m-d')) }}" required>
                                @error('payments.'.$payment->id.'.day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="cashier_id">Employee</label>
                                <select class="form-control @error('cashier_id') is-invalid @enderror" id="cashier_id" name="cashier_id">
                                    <option value="">Select Employee</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}" {{ old('cashier_id', $payment->cashier_id) == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cashier_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No payments available.</p>
        @endif
        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('groups.index') }}" class="btn btn-secondary">Back</a>
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
    document.getElementById('add-product-btn').addEventListener('click', function() {
        const productCount = document.querySelectorAll('#reservation-products .row').length;
        const newProductHTML = `
            <div class="row" id="product_row_${productCount}">
                <div class="col-md-2 mb-2">
                    <label for="category_id_new_${productCount}">Category</label>
                    <select class="form-control" id="category_id_new_${productCount}" name="ticket_rev_products[new_${productCount}][category_id]">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="product_id_new_${productCount}">Product Type</label>
                    <select class="form-control" id="product_id_new_${productCount}" name="ticket_rev_products[new_${productCount}][product_id]" onchange="fetchProductPrice(${productCount})">
                        <option value="">Select Product Type</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" data-price="{{ $prod->price }}">{{ $prod->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 mb-3">
                    <label for="qty_new_${productCount}">Qty</label>
                    <input type="number" class="form-control" id="qty_new_${productCount}" name="ticket_rev_products[new_${productCount}][qty]" value="1" min="1" onchange="updateTotalPrice(${productCount})">
                </div>

                <div class="col-md-2 mb-2">
                    <label for="price_new_${productCount}">Price</label>
                    <input type="number" class="form-control" id="price_new_${productCount}" name="ticket_rev_products[new_${productCount}][price]" value="0" readonly>
                </div>

                <div class="col-md-2 mb-2">
                    <label for="total_price_new_${productCount}">Total Price</label>
                    <input type="number" class="form-control" id="total_price_new_${productCount}" name="ticket_rev_products[new_${productCount}][total_price]" value="0" readonly>
                </div>
                <div class="col-md-2">
                     <button type="button" class="btn btn-danger" onclick="removeProductRow(${productCount})">Delete</button>
                </div>
            </div>
        `;
        document.getElementById('ticket-products').insertAdjacentHTML('beforeend', newProductHTML);
    });

    function fetchProductPrice(index) {
        const productSelect = document.getElementById(`product_id_new_${index}`);
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const priceInput = document.getElementById(`price_new_${index}`);

        // Get the price from the selected option's data attribute
        const price = selectedOption ? selectedOption.getAttribute('data-price') : 0;
        priceInput.value = price || 0;

        // Update the total price
        updateTotalPrice(index);
    }

    function updateTotalPrice(index) {
        const qty = document.getElementById(`qty_new_${index}`).value;
        const price = document.getElementById(`price_new_${index}`).value;
        const totalPrice = document.getElementById(`total_price_new_${index}`);

        totalPrice.value = qty * price || 0;
    }

    function removeProductRow(index) {
        const row = document.getElementById(`product_row_${index}`);
        if (row) {
            row.remove();
        }
    }
</script>


@endsection
