<div class="modal-header">
    <h5 class="modal-title" id="example-Modal3">Edit Product</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <form id="updateForm" class="updateForm" method="POST" enctype="multipart/form-data" action="{{route('product.update',$product->id)}}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$product->id}}">
        <div class="form-group">
            <label for="name" class="form-control-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{$product->title}}">
        </div>
        <div class="form-group ">
            <label class="form-label mt-0">Category</label>
            <select class="form-control" data-placeholder="Choose Category" name="category_id">
                @foreach($categories as $category)
                    <option
                        value='{{ $category->id }}' {{ ($product->category_id == $category->id) ? 'selected' : '' }}>{{ $category->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label for="name" class="form-control-label">Price</label>
                    <input type="text" name="price" class="form-control" value="{{$product->price}}"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label for="name" class="form-control-label">Vat(%)</label>
                    <input type="number" min="0" max="100" value="{{$product->vat}}"
                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                           onKeyUp="if(this.value>100){this.value='100';}else if(this.value<=0){this.value='0';}"
                           class="form-control" name="vat" id="vat">
                </div>
            </div>
        </div>

        <div class="form-group">
            Status
            <div class="material-switch pull-left mt-4">
                <input id="someSwitchOptionSuccess" name="status"
                       type="checkbox" {{ ($product->status == '1') ? 'checked' : '' }}/>
                <label for="someSwitchOptionSuccess" class="label-success"></label>
            </div>
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

