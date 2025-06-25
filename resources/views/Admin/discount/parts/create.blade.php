<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Add Discount Reason</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="addForm" class="addForm" method="POST" enctype="multipart/form-data" action="{{route('discount.store')}}">
        @csrf
        <div class="form-group">
            <label for="name" class="form-control-label">Description</label>
            <input type="text" class="form-control" name="desc" id="desc">
            <input type="date" class="form-control mt-3" name="start" id="start">
            <input type="date" class="form-control mt-3" name="end" id="end">

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="addButton">Create</button>
        </div>
    </form>
</div>

