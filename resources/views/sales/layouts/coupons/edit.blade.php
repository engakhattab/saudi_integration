<form action="{{route('sales.coupons.update',$rev->id)}}" id="updateForm">
    @method('post')
    @csrf
    <input type="hidden" value="{{$rev->id}}" name="id">
    <div class="modal-body">
        <div class="row">
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-building me-1"></i> Corporation Name
                </label>
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Type here..."
                           name="client_name" value="{{$rev->client_name}}">
                </div>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-phone-alt me-1"></i> Phone Number </label>
                <div class="input-group">
                    <input class="form-control" type="number" placeholder="Phone" name="phone"
                           value="{{$rev->phone}}">
                </div>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-envelope me-1"></i> Email</label>
                <div class="input-group">
                    <input class="form-control" type="email" placeholder="Email" name="email"
                           value="{{$rev->email}}">
                </div>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-money-bill-wave me-1"></i> Paid Amount
                </label>
                <div class="input-group">
                    <input class="form-control" type="number" placeholder="Amount" name="paid_amount"
                           value="{{$rev->paid_amount}}">
                </div>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-users me-1"></i> Visitors Count </label>
                <div class="input-group">
                    <input class="form-control" type="number" min="1" placeholder="Count"
                           name="visitor_count" value="{{$rev->models->count()}}">
                </div>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-users me-1"></i> Hours Count </label>
                <div class="input-group">
                    <input class="form-control" type="number" min="1" max="24" placeholder="Count"
                           name="hours_count" value="{{$rev->hours_count}}">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-calendar-alt me-1"></i> Coupon Start Date
                </label>
                <div class="input-group">
                    <input class="form-control" type="date" name="coupon_start"
                           value="{{$rev->coupon_start}}">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-calendar-alt me-1"></i> Coupon End Date
                </label>
                <div class="input-group">
                    <input class="form-control" type="date" name="coupon_end"
                           value="{{$rev->coupon_end}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-flag me-1"></i> Governorate </label>
                <select class="form-control" name="gov_id" id="choices-governorate">
                    <option value="" disabled>Choose the Governorate</option>
                    @foreach($governorates as $governorate)
                        <option value="{{$governorate->id}}"
                            {{ $governorate->id == $rev->gov_id ? 'selected' : ''}}>
                            {{$governorate->title}}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-city me-1"></i> City </label>
                <select class="form-control" name="city_id" id="choices-city">
                    <option value="" disabled>Choose the Governorate</option>
                    @if($rev->city_id != null)
                        <option value="{{ $rev->city_id }}" selected>{{ $rev->cityYA->title }}</option>
                    @endif
                </select>
            </div>
            <div class="col-sm-4 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> Invoice Date </label>
                <div class="input-group">
                    <input class="form-control" type="date"
                           value="{{ $rev->day ?? \Carbon\Carbon::now()->format('Y-m-d') }}" name="day" id="day">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> Building No </label>
                <div class="input-group">
                    <input class="form-control" placeholder="Type Here..." value="{{ $rev->building }}"
                           name="building" id="building">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> Street Name </label>
                <div class="input-group">
                    <input class="form-control" placeholder="Type Here..." value="{{ $rev->street }}"
                           name="street" id="street">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> District Name </label>
                <div class="input-group">
                    <input class="form-control" placeholder="Type Here..." value="{{ $rev->district }}"
                           name="district" id="district">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> Address Details </label>
                <div class="input-group">
                    <input class="form-control" placeholder="Type Here..." value="{{ $rev->address }}"
                           name="address" id="address">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> VAT No </label>
                <div class="input-group">
                    <input type="number" class="form-control" placeholder="Type Here..."
                           value="{{ $rev->vat_num }}" name="vat_num"
                           id="vat_num">
                </div>
            </div>
            <div class="col-sm-6 p-2">
                <label class="form-label"> <i class="fas fa-road me-1"></i> Zip Code </label>
                <div class="input-group">
                    <input type="number" class="form-control" placeholder="Type Here..."
                           value="{{ $rev->zip }}" name="zip" id="zip">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 p-2">
                <label class="form-label"><i class="fas fa-feather-alt me-1"></i> Note</label>
                <textarea name="note" id="" class="form-control" rows="5"
                          placeholder="Add Note...">{{$rev->note}}</textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-dark ml-auto me-2" data-bs-dismiss="modal"> Close</button>
        <button type="submit" class="btn btn-success" id="updateButton"> Update</button>
    </div>
</form>

<script>
    $(document).ready(function () {

        $('select[name="gov_id"]').on('change', function () {
            var gov_id = $(this).val();
            if (gov_id) {
                $.ajax({
                    url: "{{ URL::to('cities') }}/" + gov_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="city_id"]').empty();
                        $.each(data, function (key, value) {
                            $('select[name="city_id"]').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>
