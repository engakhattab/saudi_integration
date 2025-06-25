<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Add New</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('about_us.store')}}">
        @csrf
        <div class="form-group">
            <label for="video" class="form-control-label">File</label>
            <input type="file" class="dropify" name="video" accept="image/png, image/gif, image/jpeg,image/jpg ,video/mp4,video/x-m4v,video/*"/>
            <span class="form-text text-danger text-center">Accept video or image</span>
        </div>

        <div class="form-group">
            <label for="title" class="form-control-label">Main Title</label>
            <input type="text" class="form-control" name="title">
        </div>

        <div class="form-group">
            <label for="sub_title" class="form-control-label">Sub Title</label>
            <input type="text" class="form-control" name="sub_title">
        </div>

        <div class="form-group">
            <label for="desc" class="form-control-label">Description</label>
            <textarea type="text" rows="4" class="form-control" name="desc"></textarea>
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
