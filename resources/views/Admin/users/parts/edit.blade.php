<link href="{{asset('assets/admin')}}/plugins/select2/select2.min.css" rel="stylesheet"/>
<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit User</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" method="POST" enctype="multipart/form-data" action="{{route('users.update',$user->id)}}" >
    @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name" class="form-control-label">Photo</label>
            <input type="file" id="testDrop" class="dropify" name="photo" data-default-file="{{get_user_photo($user->photo)}}"/>
        </div>
        <input type="hidden" name="id" value="{{$user->id}}"/>
        <div class="form-group">
            <label for="name" class="form-control-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{$user->name}}">
        </div>
        <div class="form-group">
            <label for="email" class="form-control-label">User Name</label>
            <input type="text" class="form-control" name="user_name" id="user_name" value="{{$user->user_name}}">
        </div>
        <div class="form-group">
            <label for="password" class="form-control-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="********">
            <br>
            <span class="alert alert-info">Password must contain one of those [a-z],[A-Z],[0-9],[@$!%*#?&]</span>
        </div>
        <div class="form-group">
            <label class="form-label">Assign Roles</label>
            <select name="roles[]" class="form-control select2" data-placeholder="Choose Roles" multiple>
                @foreach($roles as $role)
                    <option value="{{$role->id}}" {{in_array($role->id, $rolePermissions) ? 'selected' : ''}}>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            Status
            <div class="material-switch pull-left mt-4">
                <input name="status" value="0" hidden>
                <input id="someSwitchOptionSuccess" name="status" value="1"
                       type="checkbox" {{ ($user->status == '1') ? 'checked' : '' }}/>
                <label for="someSwitchOptionSuccess" class="label-success"></label>
            </div>
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
<script src="{{asset('assets/admin')}}/js/select2.js"></script>
<script src="{{asset('assets/admin')}}/plugins/select2/select2.full.min.js"></script>
