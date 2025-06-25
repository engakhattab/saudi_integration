<link href="{{asset('assets/admin')}}/plugins/select2/select2.min.css" rel="stylesheet"/>
<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Add Image</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('pricesSlider.store')}}">
        @csrf
        <div class="form-group">
            <label for="name" class="form-control-label">Image</label>
            <input type="file" class="dropify" name="image" data-default-file="{{asset('assets/uploads/avatar.gif')}}"/>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="addButton">Create</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>
<script src="{{asset('assets/admin')}}/plugins/select2/select2.full.min.js"></script>
