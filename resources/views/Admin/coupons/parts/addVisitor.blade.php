<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Add Visitor</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data"
          action="{{route('couponsVisitor.store')}}">
        @csrf
        <input type="hidden" name="rev_id" value="{{$id}}">
        <div class="form-group">
            <label for="name" class="form-control-label">Name</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>

        <div class="form-group ">
            <label class="form-label mt-0">Visitor Type</label>
            <select class="form-control" data-placeholder="Choose Visitor Type" name="visitor_type_id">
                <option disabled selected>Choose Visitor Type</option>
            @foreach($types as $type)
                    <option value="{{$type->id}}">{{$type->title}}</option>
                @endforeach
            </select>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="addButton">Create</button>
        </div>
    </form>
</div>

