<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Add Group</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('group.update',$group->id)}}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="form-control-label">Photo</label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_file($group->image)}}" accept="image/*"/>
            <label class="form-text text-danger text-center">accept only images</label>
        <div class="form-group">
            <label for="name" class="form-control-label">Group Title</label>
            <input type="text" value="{{$group->title}}" class="form-control" name="title" id="title">
        </div>
        <div class="form-group">
            <label for="name" class="form-control-label">Group Text</label>
            <textarea class="form-control" name="text">{{$group->text}}</textarea>
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
