<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Day Capacity</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data"
          action="{{route('capacities.update',$day->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$day->id}}">
        <div class="form-group">
            <label for="name" class="form-control-label">Date</label>
            <input type="text" disabled class="form-control" name="day" id="day" value="{{$day->day}}">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">Capacity</label>
            <input type="text" name="count" class="form-control" value="{{$day->count}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
        </div>
        <div class="form-group">
            Status
            <div class="material-switch pull-left mt-4">
                <input id="someSwitchOptionSuccess" name="status"
                       type="checkbox" {{ ($day->status == '1') ? 'checked' : '' }}/>
                <label for="someSwitchOptionSuccess" class="label-success"></label>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="addButton">Update</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>

