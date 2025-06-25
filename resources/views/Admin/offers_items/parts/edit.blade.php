<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Item</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data"
          action="{{route('items.update',$item->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$item->id}}">
        <div class="form-group">
            <label for="name" class="form-control-label">Photo</label>
            <input type="file" class="dropify" name="photo" data-default-file="{{asset($item->photo)}}" accept="image/png, image/gif, image/jpeg,image/jpg"/>
            <span class="form-text text-danger text-center">accept only png, gif, jpeg, jpg</span>
        </div>

        <div class="form-group">
            <label for="name" class="form-control-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$item->title}}">
        </div>

        <div class="form-group ">
            <label class="form-label mt-0">Offer</label>
            <select class="form-control" data-placeholder="Choose Offer" name="offer_id">
                @foreach($offers as $offer)
                    <option
                        value='{{ $offer->id }}' {{ ($item->offer_id == $offer->id) ? 'selected' : '' }}>{{ $offer->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="name" class="form-control-label">Description</label>
            <textarea type="text" class="form-control" rows="4" name="desc">{{$item->desc}}</textarea>
        </div>




        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" id="addButton">Update</button>
        </div>
    </form>
</div>

<script>
    $('.dropify').dropify()
</script>

