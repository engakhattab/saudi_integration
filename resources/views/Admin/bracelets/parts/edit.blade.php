<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Bracelet</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data"
          action="{{route('bracelet.update',$bracelet->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$bracelet->id}}">
        <div class="invalid-feedback block mb-2">* title of bracelet should be in this form "A00"</div>
        <div class="form-group">
            <label for="name" class="form-control-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$bracelet->title}}">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="updateButton">Update</button>
        </div>
    </form>
</div>

