<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>

    <meta charset="utf-8">
    <title>{{$setting->title}} | {{$model->coupon_num}}</title>
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
                <div class="info">
                    <h6 class="billTitle"> Ticket <span dir="rtl"> {{$model->coupon_num}}#</span></h6>
                    <ul>
                        <li><label> Reservation Duration : </label> <strong> {{$rev->hours_count}} h </strong></li>
                        <li><label> Print Time : </label> <strong> {{$date}} </strong></li>
                    </ul>
                </div>

                @if($model->name != null)
                <div class="info">
                    <h6 class="billTitle"> Visitor Info </h6>
                    <ul>
                        <li><label> Name  : </label> <strong>  {{$model->name}} </strong></li>
                    </ul>
                </div>
                @endif

                <div class="info">
                    <h6 class="billTitle"> Corporation Info </h6>
                    <ul>
                        <li><label> Name  : </label> <strong>  {{$rev->client_name}} </strong></li>
                        <li><label> Phone : </label> <strong>  {{$rev->phone}} </strong></li>
                        <li><label> Email : </label> <strong>  {{$rev->email}} </strong></li>
                    </ul>
                </div>
                <img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($model->coupon_num, $generatorPNG::TYPE_CODE_128)) }}"
                     class="barcode">
            </div>
        </div>
    </div>
</div>
</body>

</html>
