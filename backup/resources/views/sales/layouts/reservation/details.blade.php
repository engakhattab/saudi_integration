<style>
    .myTable, .myTable th,.myTable td {
        border:1px solid grey;
    }
</style>
<table class="myTable" style="width:100%">
    <tr style="background-color: #a6c64c;color: white">
        <th>Visitors</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>
    @foreach($models as $model)
        <tr>
            <td>{{$model[0]->type->title}}</td>
            <td>{{$model->count()}}</td>
            <td>{{$model->sum('price')}}</td>
        </tr>
    @endforeach
</table>
<br>
@if(count($products))
    <table class="myTable" style="width:100%">
        <tr style="background-color: #a6c64c;color: white">
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        @foreach($products as $product)
            <tr>
                <td>{{$product->product->title}}</td>
                <td>{{$product->qty}}</td>
                <td>{{$product->price}}</td>
            </tr>
        @endforeach
    </table>
@endif
<br>
<table class="myTable" style="width:100%">
    <tr style="background-color: #a6c64c;color: white">
        <th>Ticket Price</th>
        @if($reservation->ent_tax != 0)
            <th>Ent.Tax</th>
        @endif
        @if($reservation->vat != 0)
            <th>VAT</th>
        @endif
        <th>Total After Taxes</th>
        <th>Discount</th>
        <th>Paid Amount</th>
        <th>Remaining Amount</th>
    </tr>
    <tr>
        <td>{{$reservation->ticket_price}} SAR</td>
        @if($reservation->ent_tax != 0)
            <td>{{$reservation->ent_tax}} SAR</td>
        @endif
        @if($reservation->vat != 0)
            <td>{{$reservation->vat}} SAR</td>
        @endif
        <td>{{$reservation->grand_total}} SAR </td>
        <td>{{$reservation->discount_value}} {{($reservation->discount_type == 'per') ? '%' : 'SAR'}}</td>
        <td>{{$reservation->paid_amount}} SAR</td>
        <td>{{$reservation->rem_amount}} SAR</td>
    </tr>
</table>
<div class="modal-footer">
    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close" id="closeBtn">
        Close
    </button>
</div>

<script>
    $('#closeBtn').on('click',function (){
        $('#detailsModal').modal('hide');
    });
    $('#closeIcon').on('click',function (){
        $('#detailsModal').modal('hide');
    });
</script>


