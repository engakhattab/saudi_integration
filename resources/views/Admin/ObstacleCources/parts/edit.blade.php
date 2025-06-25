<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit OBSTACLE COURSES</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('obstacleCourses.update',$cource->id)}}" >
        @csrf
        @method('put')
        <div class="form-group">
            <label for="name" class="form-control-label">Photo</label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_user_photo($cource->image)}}" accept="image/png, image/gif, image/jpeg,image/jpg"/>
            <span class="form-text text-danger text-center">accept only png, gif, jpeg, jpg</span>
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{$cource->name}}" id="name">
        </div>
        <div class="form-group">
            <label for="email" class="form-control-label">Title</label>
            <input type="text" class="form-control" name="title" id="email" value="{{$cource->title}}">
        </div>
        <div class="form-group">
            <label for="password" class="form-control-label">Text</label>
            <textarea  class="form-control" name="text" >{{$cource->text}}</textarea>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="addButton">Update</button>
        </div>
    </form>
</div>


<script>
    $('.dropify').dropify()
</script>
