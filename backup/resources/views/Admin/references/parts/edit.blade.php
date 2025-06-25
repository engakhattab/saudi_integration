<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Reference</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data"
          action="{{route('reference.update',$Reference->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$Reference->id}}">
        <div class="form-group">
            <label for="name" class="form-control-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$Reference->title}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="updateButton">Update</button>
        </div>
    </form>
</div>

