
<!DOCTYPE html>
<html lang="en" dir="rtl">
<title>{{$setting->title}}</title>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link id="pagestyle" href="{{asset('assets/sales')}}/css/app.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{asset('assets/sales')}}/img/favicon.png">
    <link href="{{asset('assets/sales')}}/css/style.css" rel="stylesheet" />

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

        /*@media print {*/
        /*    .page {*/
        /*        margin: 0;*/
        /*        border: initial;*/
        /*        border-radius: initial;*/
        /*        width: initial;*/
        /*        min-height: initial;*/
        /*        box-shadow: initial;*/
        /*        background: initial;*/
        /*        page-break-after: always;*/
        /*    }*/
        /*}*/

    </style>
</head>

<body onload="window.print()">




<div class="multisteps-form container">
    <div class="row">
        <div class=" col-lg-3 p-1 m-auto ">
            <div class=" bill">
                <h4 class="font-weight-bolder ps-2">Bill</h4>
                <div class="info">
                    <h6 class="billTitle"> ticket <span> #WSF54898</span> </h6>
                    <ul>
                        <li> <label> Visit Date : </label> <strong> 18 / 10 / 2021 </strong> </li>
                        <li> <label> Reservation Duration : </label> <strong> 2 h </strong> </li>
                        <li> <label> Shift : </label> <strong> 10am : 12pm </strong> </li>
                    </ul>
                </div>
                <div class="info">
                    <h6 class="billTitle"> visitors</h6>
                    <div class="items">
                        <div class="itemsHead row">
                            <span class="col">type</span>
                            <span class="col"> Quantity </span>
                            <span class="col"> price </span>
                        </div>
                        <div class="item row">
                            <span class="col">Adult</span>
                            <span class="col"> x5 </span>
                            <span class="col"> 500 EGP </span>
                        </div>
                        <div class="item row">
                            <span class="col">kid</span>
                            <span class="col"> x10 </span>
                            <span class="col"> 1000 EGP </span>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <h6 class="billTitle"> products</h6>
                    <div class="items">
                        <div class="itemsHead row">
                            <span class="col">type</span>
                            <span class="col"> Quantity </span>
                            <span class="col"> price </span>
                        </div>
                        <div class="item row">
                            <span class="col">toy </span>
                            <span class="col"> x5 </span>
                            <span class="col"> 500 EGP </span>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <h6 class="billTitle"> Totals </h6>
                    <ul>
                        <li> <label> total price : </label> <strong> 1500 EGP </strong> </li>
                        <li> <label> Discount : </label> <strong> 50 EGP </strong> </li>
                        <li> <label> Revenue : </label> <strong> 1450 EGP </strong> </li>
                        <li> <label> paid : </label> <strong> 1600 EGP </strong> </li>
                        <li> <label> Change : </label> <strong> 150 EGP </strong> </li>
                    </ul>
                </div>
                <img src="img/barcode.jpg" class="barcode">
            </div>
        </div>
    </div>
</div>
</body>

</html>
