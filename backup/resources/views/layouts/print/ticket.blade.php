<!DOCTYPE html>
<html lang="en" dir="rtl">
<title>{{$setting->title}} | #{{$ticket->ticket_num}}</title>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="pagestyle" href="{{asset('assets/sales')}}/css/app.min.css" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="{{asset('assets/sales')}}/img/favicon.png">
    <link href="{{asset('assets/sales')}}/css/style.css" rel="stylesheet"/>
    <style>
        body {
            direction: ltr;
            margin: 0;
            padding: 0;
        }

        @page {
            /*size: A4;*/
            margin: 0;
        }
        @font-face {
            font-family: 'Almarai-Regular';
            font-style: normal;
            font-weight: 400;
            src: url({{url('assets/sales/webfonts/Almarai-Regular.ttf')}}) format('ttf');
            unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        *{
            font-family: 'Almarai-Regular';
        }
    </style>
</head>

<body onload="window.print()">


<div class="multisteps-form container">
    <div class="row">
        <div class=" col-lg-3 p-1 m-auto ">
            <div class=" bill">
                <h4 class="font-weight-bolder ps-2">Bill</h4>
                <div style="text-align: center">
                    <img src="{{asset($setting->logo)}}" style="max-height: 170px;max-width: 170px" alt="logo">
                    <p>{{$setting->title}}</p>
                </div>
                <div class="info">
                    <h6 class="billTitle"> ticket <span dir="rtl"> {{$ticket->ticket_num}}#</span></h6>
                    <ul>
                        @if($ticket->add_by)
                            <li><label style="font-weight: bold;"> Cashier Name : </label> <strong> {{auth()->user()->name}} </strong></li>
                        @endif
                            <li><label style="font-weight: bold;"> Shop Name : </label> <strong>Kids station company</strong></li>
                            <li><label style="font-weight: bold;"> شركه محطه الاطفال : </label> <strong>اسم المحل</strong></li>
                            <li><label style="font-weight: bold;"> الرقم الضريبي : </label> <strong>311416936900003</strong></li>
                            <li><label style="font-weight: bold;"> 311416936900003 : </label> <strong>Vat Reg No</strong></li>
                        <li><label style="font-weight: bold;"> Customer phone : </label> <strong >{{$ticket->client_id}}</strong></li>
                        <li><label style="font-weight: bold;"> Customer Name : </label> <strong >{{$ticket->client->name}}</strong></li>
                        <li><label style="font-weight: bold;"> Visit Date : </label>
                            <strong> {{date('d  / m / Y',strtotime($ticket->visit_date))}} </strong></li>
                        <li><label style="font-weight: bold;"> Reservation Duration : </label> <strong> {{$ticket->hours_count}} h </strong></li>
                       <li><label style="font-weight: bold;"> Print Time : </label> <strong> {{$date}} </strong></li>
                        <li><label style="font-weight: bold;"> Access time : </label> <strong style="font-weight: bold;"> {{$ticket->created_at->format('h:i A')}} </strong></li>
                        <li><label style="font-weight: bold;"> Exit time : </label> <strong style="font-weight: bold;"> {{$ticket->created_at->addHours($ticket->hours_count)->format('h:i A')}} </strong></li>
                         <li><label style="font-weight: bold;"> Payment Method : </label> <strong >{{$ticket->payment_method}}</strong></li>
                    </ul>
                </div>

                @if(count($models))
                    <div class="info">
                        <h6 class="billTitle"> visitors</h6>
                        <div class="items">
                            <div class="itemsHead row">
                                <span class="col"> name </span>
                                <span class="col">type</span>
                                @if($ticket->status == 'in')
                                    <span class="col"> bracelet </span>
                                @endif
                                <span class="col"> price </span>
                            </div>
                            @foreach($models as $model)
                                <div class="item row">
                                    <span class="col"> {{($model->name) ?? '---'}} </span>
                                    <span class="col">{{$model->type->title}}</span>
                                    @if($ticket->status == 'in')
                                        <span style="font-weight: bold" class="col">{{$model->bracelet_number}}  </span>
                                    @endif
                                    <span class="col"> {{$model->price}} SAR </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(count($ticket->products))

                    <div class="info">
                        <h6 class="billTitle"> products</h6>
                        <div class="items">
                            <div class="itemsHead row">
                                <span class="col">type</span>
                                <span class="col"> Quantity </span>
                                <span class="col"> price </span>
                            </div>
                            @foreach($ticket->products as $product)
                                <div class="item row">
                                    <span class="col">{{$product->product->title}}</span>
                                    <span class="col"> {{$product->qty}} </span>
                                    <span class="col"> {{$product->total_price}} SAR </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="info">
                    <h6 class="billTitle"> Totals </h6>
                    <ul>

                        @if(isset($titles) && isset($vat) && isset($sum))
                            <li><label> Products : </label> <strong>   {{$sum}} SAR</strong></li>
                            @foreach($titles as $key=>$title)
                                <li><label style="font-weight: bold;"> {{$title}} : </label> <strong>   {{$vat[$key]}} SAR</strong></li>
                            @endforeach

                        @endif
                        @if(count($models))
                            <li><label style="font-weight: bold;"> Visitors Count : </label> <strong>   {{count($models)}}</strong></li>
                        @endif
                        <li><label style="font-weight: bold;"> Ticket Price : </label> <strong>   {{$ticket->ticket_price}} SAR</strong></li>
                        @if($ticket->ent_tax != 0)
                            <li><label style="font-weight: bold;"> Ent.Tax : </label> <strong>   {{$ticket->ent_tax}} SAR</strong></li>
                        @endif
                        @if($ticket->vat != 0)
                            <li><label style="font-weight: bold;"> VAT : </label> <strong>   {{$ticket->vat}} SAR</strong></li>
                        @endif

                        @if($ticket->discount_value != 0)
                            <li><label style="font-weight: bold;"> Discount : </label> <strong> {{$ticket->discount_value}} {{($ticket->discount_type == 'per') ? '%' : 'SAR'}}</strong></li>
                        @endif

                        <li><label style="font-weight: bold;"> total price : </label> <strong>   {{$ticket->grand_total}} SAR</strong></li>


                        @if($ticket->total_top_up_price)
                            <li><label style="font-weight: bold;"> Top Up : {{$ticket->total_top_up_hours}} H</label> <strong> {{$ticket->total_top_up_price}} SAR</strong></li>
                        @endif
                        <li><label style="font-weight: bold;"> paid : </label> <strong>  {{$ticket->paid_amount}} SAR</strong></li>
                        <li><label style="font-weight: bold;"> Remaining : </label> <strong>  {{$ticket->rem_amount}} SAR</strong></li>
                    </ul>
                    @php

                        $base64 = Prgayman\Zatca\Facades\Zatca::sellerName('شركه محطه الاطفال')
                         ->vatRegistrationNumber("311416936900003")
                         ->timestamp($ticket->visit_date)
                         ->totalWithVat($ticket->total_price)
                         ->vatTotal($ticket->vat)
                         ->toBase64();


                    @endphp
                    <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG( $base64, 'QRCODE') . '" alt="barcode"   />';?>

                </div>


                {{--                <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($ticket->ticket_num, $generatorPNG::TYPE_CODE_128)) }}"--}}
                {{--                     class="barcode">--}}
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function () {
        window.close();
    }, 1000);
</script>
</body>

</html>
