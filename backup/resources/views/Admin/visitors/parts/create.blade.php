<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">New Visitor Type</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('visitors.store')}}">
        @csrf
        <div class="form-group">
            <label for="photo" class="form-control-label">Photo</label>
            <input type="file" required class="dropify" name="photo"
                   accept="image/png, image/gif, image/jpeg,image/jpg"/>
            <span class="form-text text-danger text-center">accept only png, gif, jpeg, jpg</span>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="title" class="form-control-label">Title</label>
                    <input type="text" required class="form-control" name="title">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="title" class="form-control-label">Event</label>
                    <select name="event_id" class="form-control">
                        <option value="0">Family</option>
                        @foreach($events as $event)
                            <option value="{{$event->id}}">{{$event->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="1_hours" class="form-control-label">1H price</label>
                    <input type="number" required class="form-control numbersOnly" name="1_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="2_hours" class="form-control-label">2H price</label>
                    <input type="number" required class="form-control numbersOnly" name="2_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="3_hours" class="form-control-label">3H price</label>
                    <input type="number" required class="form-control numbersOnly" name="3_hours">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="4_hours" class="form-control-label">4H price</label>
                    <input type="number" required class="form-control numbersOnly" name="4_hours">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="5_hours" class="form-control-label">5H price</label>
                    <input type="number" required class="form-control numbersOnly" name="5_hours">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="6_hours" class="form-control-label">6H price</label>
                    <input type="number" required class="form-control numbersOnly" name="6_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="7_hours" class="form-control-label">7H price</label>
                    <input type="number" required class="form-control numbersOnly" name="7_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="8_hours" class="form-control-label">8H price</label>
                    <input type="number" required class="form-control numbersOnly" name="8_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="9_hours" class="form-control-label">9H price</label>
                    <input type="number" required class="form-control numbersOnly" name="9_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="10_hours" class="form-control-label">10H price</label>
                    <input type="number" required class="form-control numbersOnly" name="10_hours">
                </div>
            </div>

            <div class="col-12">
                <p class="fw-bolder">
                    TopUp Prices
                </p>
                <br>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="top_1_hours" class="form-control-label">1H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_1_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="top_2_hours" class="form-control-label">2H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_2_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="top_3_hours" class="form-control-label">3H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_3_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="top_4_hours" class="form-control-label">4H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_4_hours">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="top_5_hours" class="form-control-label">5H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_5_hours">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="top_6_hours" class="form-control-label">6H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_6_hours">
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label for="top_7_hours" class="form-control-label">7H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_7_hours">
                </div>
            </div>


            <div class="col-6">
                <div class="form-group">
                    <label for="top_8_hours" class="form-control-label">8H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_8_hours">
                </div>
            </div>


            <div class="col-6">
                <div class="form-group">
                    <label for="top_9_hours" class="form-control-label">9H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_9_hours">
                </div>
            </div>


            <div class="col-6">
                <div class="form-group">
                    <label for="top_10_hours" class="form-control-label">10H price</label>
                    <input type="number"  class="form-control numbersOnly" name="top_10_hours">
                </div>
            </div>


        </div>




        {{--        @foreach($shifts as $shift)--}}
        {{--            <div class="form-group">--}}
        {{--                <label for="{{$shift->id}}" class="form-control-label">Price--}}
        {{--                    From {{date('h:i A', strtotime($shift->from))}} To {{date('h:i A', strtotime($shift->to))}}</label>--}}
        {{--                <input required type="number" min="1" class="form-control" name="price[]">--}}
        {{--                <input type="hidden" name="shifts_id[]" value="{{$shift->id}}">--}}
        {{--            </div>--}}
        {{--        @endforeach--}}

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="addButton">Create</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
