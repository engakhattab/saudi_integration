<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Add Time</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('timing.store')}}">
        @csrf
        <div class="form-group">
            <label for="from" class="form-control-label">Start From</label>
            <input type="time" required class="form-control" name="from" id="from">
        </div>

        <div class="form-group">
            <label for="to" class="form-control-label">Ends At</label>
            <input type="time" required class="form-control" name="to" id="to">
        </div>

        <div class="row">
        @foreach($visitors as $visitor)
            <div class="col-6">
                <div class="form-group">
                    <label for="{{$visitor->id}}" class="form-control-label">{{$visitor->title}} price at this
                        time</label>
                    <input type="hidden" name="visitor_type_id[]" value="{{$visitor->id}}">
                    <input required type="number" min="1" class="form-control" name="visitor_type_price[]" id="{{$visitor->id}}">
                </div>
            </div>
        @endforeach
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="addButton">Create</button>
        </div>
    </form>
</div>

