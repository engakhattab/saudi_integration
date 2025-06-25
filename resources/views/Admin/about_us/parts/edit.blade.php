<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Data</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('about_us.update',$aboutUs->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$aboutUs->id}}">
        <div class="form-group">
            <label for="video" class="form-control-label">File</label>
            <input type="file" class="dropify" name="video" accept="image/png, image/gif, image/jpeg,image/jpg ,video/mp4,video/x-m4v,video/*" data-default-file="{{asset($aboutUs->video)}}"/>
            <span class="form-text text-danger text-center">Accept video or image</span>
        </div>

        <div class="form-group">
            <label for="title" class="form-control-label">Main Title</label>
            <input type="text" class="form-control" name="title" value="{{$aboutUs->title}}">
        </div>

        <div class="form-group">
            <label for="sub_title" class="form-control-label">Sub Title</label>
            <input type="text" class="form-control" name="sub_title" value="{{$aboutUs->sub_title}}">
        </div>

        <div class="form-group">
            <label for="desc" class="form-control-label">Description</label>
            <textarea type="text" class="form-control" rows="4" name="desc">{{$aboutUs->desc}}</textarea>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="updateButton">Update</button>
        </div>
    </form>
</div>
<script>
    $('.dropify').dropify()
</script>
