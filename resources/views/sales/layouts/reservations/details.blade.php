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
        @if($rev->ent_tax != 0)
            <th>Ent.Tax</th>
        @endif
        @if($rev->vat != 0)
            <th>VAT</th>
        @endif
        <th>Total After Taxes</th>
        <th>Discount</th>
        <th>Paid Amount</th>
        <th>Remaining Amount</th>
    </tr>
    <tr>
        <td>{{$rev->ticket_price}} SAR</td>
        @if($rev->ent_tax != 0)
            <td>{{$rev->ent_tax}} SAR</td>
        @endif
        @if($rev->vat != 0)
            <td>{{$rev->vat}} SAR</td>
        @endif
        <td>{{$rev->grand_total}} SAR</td>
        <td>{{$rev->discount_value}} {{($rev->discount_type == 'per') ? '%' : 'SAR'}}</td>
        <td>{{$rev->paid_amount}} SAR</td>
        <td>{{$rev->rem_amount}} SAR</td>
    </tr>
</table>
<div class="modal-footer">
    <button type="button" class="btn" data-bs-dismiss="modal" aria-label="Close">
        Close
    </button>
</div>

