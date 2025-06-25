<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Slider</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('sliders.update',$slider->id)}}" >
    @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$slider->id}}">
        <div class="form-group">
            <label for="photo" class="form-control-label">Photo</label>
            <input type="file" class="dropify" name="photo" accept="image/png, image/gif, image/jpeg,image/jpg" data-default-file="{{get_user_photo($slider->photo)}}"/>
            <span class="form-text text-danger text-center">accept only png, gif, jpeg, jpg</span>
        </div>

        <div class="form-group">
            <label for="title" class="form-control-label">Main Title</label>
            <input type="text" class="form-control" name="title" value="{{$slider->title}}">
        </div>

        <div class="form-group">
            <label for="sub_title" class="form-control-label">Sub Title</label>
            <input type="text" class="form-control" name="sub_title" value="{{$slider->sub_title}}">
        </div>

        <div class="form-group">
            <label for="button_text" class="form-control-label">Button Text</label>
            <input type="text" class="form-control" name="button_text" value="{{$slider->button_text}}">
        </div>

        <div class="form-group">
            <label for="button_link" class="form-control-label">Button Link</label>
            <input type="text" class="form-control" name="button_link" value="{{$slider->button_link}}">
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
