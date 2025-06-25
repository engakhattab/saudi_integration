<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Offer</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data"
          action="{{route('offers.update',$offer->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$offer->id}}">
        <div class="form-group">
            <label for="name" class="form-control-label">Offer Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$offer->title}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="updateButton">Update</button>
        </div>
    </form>
</div>

