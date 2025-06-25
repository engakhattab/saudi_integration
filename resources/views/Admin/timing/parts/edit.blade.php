<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Reference</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data"
          action="{{route('timing.update',$shift->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$shift->id}}">
        <div class="form-group">
            <label for="from" class="form-control-label">Start From</label>
            <input type="time" class="form-control" name="from" id="from" value="{{$shift->from}}">
        </div>

        <div class="form-group">
            <label for="to" class="form-control-label">Ends At</label>
            <input type="time" class="form-control" name="to" id="to" value="{{$shift->to}}">
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="updateButton">Update</button>
        </div>
    </form>
</div>

