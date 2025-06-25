<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Discount Reason</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data"
          action="{{route('discount.update',$discount->id)}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="form-control-label">Description</label>
            <input type="text" class="form-control" name="desc" id="desc" value="{{$discount->desc}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="updateButton">Update</button>
        </div>
    </form>
</div>

