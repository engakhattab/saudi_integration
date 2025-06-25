<!DOCTYPE html>
<html lang="en">
@php
    if ($ticket->grand_total == 0){
        $ticket->grand_total = $ticket->paid_amount;
    }
    if ($ticket->ticket_price == 0){
        $ticket->ticket_price = $ticket->paid_amount - (($ticket->paid_amount * (15 /100)) / 1.15);
    }
    if ($ticket->vat == 0) {
        $ticket->vat = number_format((($ticket->paid_amount * (15 /100)) / 1.15),2);
    }


    $base64 = Prgayman\Zatca\Facades\Zatca::sellerName('شركه محطه الاطفال')
    ->vatRegistrationNumber("311416936900003")
    ->timestamp($ticket->visit_date ?? $ticket->day)
    ->totalWithVat($ticket->paid_amount)
    ->vatTotal($ticket->vat)
    ->toBase64();
@endphp
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('invoice/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('invoice/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('invoice/css/style.css') }}">

</head>
<body onload="window.print()">
<div class="container-fluid">
    <!-- header -->
    <div class="header p-1">
        <img class="logo" src="{{asset($setting->logo)}}">
    </div>
    <!-- content -->
    <h3 class="text-center mt-1 mb-3">Tax Invoice — فاتورة ضريبية</h3>
    <div class="row">
        <div class="col-8">
            <div class="scroll">
                <table class="table">
                    <tbody>
                    <tr>
                        <td>Invoice Number</td>
                        <td class="text-center">{{$ticket->ticket_num}}#</td>
                        <td class="text-end">رقم الفاتورة</td>
                    </tr>
                    <tr>
                        <td>Invoice Date:</td>
                        <td class="text-center">{{ $ticket->visit_date ?? $ticket->day }}</td>
                        <td class="text-end">تاريخ إصدار الفاتورة</td>
                    </tr>
                    <tr>
                        <td>Due Date:</td>
                        <td class="text-center">{{ $ticket->visit_date ?? $ticket->day }}</td>
                        <td class="text-end">تاريخ الاستحقاق</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-4">
            <div class="d-flex justify-content-end mb-1">
                <img class="qrcode" src="data:image/png;base64,{{ DNS2D::getBarcodePNG( $base64, 'QRCODE') }}"
                     alt="barcode">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-6" style="padding-left: 0; padding-right:0;">
            <div class="scroll">
                <table class="table">
                    <tbody>
                    <tr class="blue-color">
                        <td class="border-blue">Customer:</td>
                        <td class="border-blue"></td>
                        <td class="text-end border-blue">العميل</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td class="text-center">{{$ticket->client->name ?? $ticket->client_name}}</td>
                        <td class="text-end">اسم</td>
                    </tr>
                    <tr>
                        <td>Building No:</td>
                        <td class="text-center">{{$ticket->client->building ?? $ticket->building}}</td>
                        <td class="text-end">رقم المبنى</td>
                    </tr>
                    <tr>
                        <td>Street Name:</td>
                        <td class="text-center">{{$ticket->client->street ?? $ticket->street}}</td>
                        <td class="text-end">اسم الشارع</td>
                    </tr>
                    <tr>
                        <td>District:</td>
                        <td class="text-center">{{$ticket->client->district ?? $ticket->district}}</td>
                        <td class="text-end">الحى</td>
                    </tr>
                    <tr>
                        <td>City:</td>
                        <td class="text-center">{{$ticket->client->cityYA->title ?? $ticket->cityYA->title}}</td>
                        <td class="text-end">المدينة</td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td class="text-center">المملكة العربية السعودية</td>
                        <td class="text-end">البلد</td>
                    </tr>
                    <tr>
                        <td>postal code:</td>
                        <td class="text-center">{{ $ticket->client->zip ?? $ticket->zip }}</td>
                        <td class="text-end">الرمز البريدى</td>
                    </tr>
                    <tr>
                        <td>Additional No:</td>
                        <td class="text-center">{{ $ticket->client->address ?? $ticket->address }}</td>
                        <td class="text-end">الرقم الاضافى للعنوان</td>
                    </tr>
                    <tr>
                        <td>VAT Number:</td>
                        <td class="text-center">{{ $ticket->client->vat_num ?? $ticket->vat_num }}</td>
                        <td class="text-end">رقم تسجيل ضريبة القيمة المضافة</td>
                    </tr>
                    <tr>
                        <td>Other Seller ID:</td>
                        <td class="text-center"></td>
                        <td class="text-end">معرف أخر</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6 col-6">
            <div class="scroll">
                <table class="table">
                    <tbody>
                    <tr class="blue-color">
                        <td class="border-blue">Seller:</td>
                        <td class="border-blue"></td>
                        <td class="text-end border-blue">المورد</td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td class="text-center">شركه محطه الاطفال</td>
                        <td class="text-end">اسم</td>
                    </tr>
                    <tr>
                        <td>Building No:</td>
                        <td class="text-center"></td>
                        <td class="text-end">رقم المبنى</td>
                    </tr>
                    <tr>
                        <td>Street Name:</td>
                        <td class="text-center">طريق الملك عبدالله</td>
                        <td class="text-end">اسم الشارع</td>
                    </tr>
                    <tr>
                        <td>District:</td>
                        <td class="text-center">حي الورود</td>
                        <td class="text-end">الحى</td>
                    </tr>
                    <tr>
                        <td>City:</td>
                        <td class="text-center">الرياض</td>
                        <td class="text-end">المدينة</td>
                    </tr>
                    <tr>
                        <td>Country:</td>
                        <td class="text-center">المملكة العربية السعودية</td>
                        <td class="text-end">البلد</td>
                    </tr>
                    <tr>
                        <td>postal code:</td>
                        <td class="text-center">12253</td>
                        <td class="text-end">الرمز البريدى</td>
                    </tr>
                    <tr>
                        <td>Additional No:</td>
                        <td class="text-center"></td>
                        <td class="text-end">الرقم الاضافى للعنوان</td>
                    </tr>
                    <tr>
                        <td>VAT Number:</td>
                        <td class="text-center">311416936900003</td>
                        <td class="text-end">رقم تسجيل ضريبة القيمة المضافة</td>
                    </tr>
                    <tr>
                        <td>Other Seller ID:</td>
                        <td class="text-center"></td>
                        <td class="text-end">معرف أخر</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="scroll">
                <table class="table">
                    <thead>
                    <tr class="blue-color">
                        <th scope="col" class="border-color text-center">#</th>
                        <th scope="col" class="border-color text-center">وصف الصنف Item Description</th>
                        <th scope="col" class="border-color text-center">الكمية Qty</th>
                        <th scope="col" class="border-color text-center">سعر الوحدة Unit Price</th>
                        <th scope="col" class="border-color text-center">المبلغ الخاضع للضريبة Taxable Amount</th>
                        <th scope="col" class="border-color text-center">نسبة الضريبة Tax Rate</th>
                        <th scope="col" class="border-color text-center">مبلغ الضريبة Tax Amount</th>
                        <th scope="col" class="border-color text-center">المجموع شامل الضر يبة Total Amount With VAT
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{$model->type->title ?? 'coupons'}}</td>
                            <td>{{ $model->ticket_count }}</td>
                            <td>{{$model->price == 0 ? number_format($ticket->paid_amount / $model->ticket_count,2) : number_format($model->price,2) }}
                                SAR
                            </td>
                            @if($model->price == 0)
                                <td>{{ number_format(($ticket->paid_amount / $model->ticket_count) - (($ticket->paid_amount / $model->ticket_count * (15 / 100))/1.15),2) }}
                                    SAR
                                </td>
                                <td>VAT 15%</td>
                                <td>{{ number_format((($ticket->paid_amount / $model->ticket_count) * (15 / 100)/1.15),2) }}
                                    SAR
                                </td>
                                <td>{{ number_format($ticket->paid_amount / $model->ticket_count,2) }} SAR</td>
                            @else
                                <td>{{$model->price - (($model->price * (15 / 100))/1.15) }} SAR</td>
                                <td>VAT 15%</td>
                                <td>{{(($model->price * (15 / 100))/1.15)}} SAR</td>
                                <td>{{$model->price}} SAR</td>
                            @endif
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            @php
                if ($ticket->grand_total == 0){
                   $ticket->grand_total = $ticket->paid_amount;
               }
               if ($ticket->ticket_price == 0){
                   $ticket->ticket_price = $ticket->paid_amount - (($ticket->paid_amount * (15 /100)) / 1.15);
               }
               if ($ticket->vat == 0) {
                   $ticket->vat = number_format((($ticket->paid_amount * (15 /100)) / 1.15),2);
               }
            @endphp
            <table class="table">
                <tbody>
                <tr>
                    <td>Total (Excluding VAT) - الاجمالى غير شامل ضريبة القيمةالمضافة</td>
                    <td class="text-center">{{number_format($ticket->ticket_price,2)}} SAR</td>
                </tr>
                @if(isset($titles) && isset($vat) && isset($sum))
                    <tr>
                        <td>product Total - الاجمالى سعر المنتجات</td>
                        <td class="text-center"> {{$sum}} SAR</td>
                    </tr>
                    <tr>
                        <td>product Total - الاجمالى ضريبة المنتجات</td>
                        @foreach($titles as $key=>$title)
                            <td class="text-center"> {{$vat[$key]}} SAR</td>
                        @endforeach
                    </tr>
                @endif
                <tr>
                    <td>Discount — اجمالى الخصومات</td>
                    <td class="text-center">{{$ticket->discount_value}} {{($ticket->discount_type == 'per') ? '%' : 'SAR'}}</td>
                </tr>
                <tr>
                    <td>Total Taxable Amount — اجمالى المبلغ الخاضع للضريبة</td>
                    <td class="text-center">{{number_format($ticket->grand_total,2)}} SAR</td>
                </tr>
                <tr>
                    <td>Total VAT - اجمالى ضريبة القيمة المضافة</td>
                    <td class="text-center">{{$ticket->vat}}</td>
                </tr>
                <tr>
                    <td>Top Up - اجمالى عدد الساعات الاضافية</td>
                    <td class="text-center">{{$ticket->total_top_up_hours}} H</td>
                </tr>
                <tr>
                    <td>Top Up - اجمالى سعر الساعات الاضافية</td>
                    <td class="text-center">{{number_format($ticket->total_top_up_price,2)}} SAR</td>
                </tr>
                <tr class="blue-color">
                    <td class="border-color">Total Due Amount - اجمالى المبلغ المستحق</td>
                    <td class="text-center border-color">{{number_format($ticket->paid_amount,2)}} SAR</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{--    <!-- footer -->--}}
    {{--    <div class="text-center fw-normal footer pt-5 pb-5">--}}
    {{--        <button onclick="myfunction()">print</button>--}}
    {{--    </div>--}}
</div>


<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/all.min.js"></script>
{{--<script>--}}
{{--    function myfunction() {--}}
{{--        window.print();--}}
{{--    }--}}
{{--</script>--}}

<script>
    setTimeout(function () {
        window.close();
    }, 2000);
</script>
</body>
</html>
