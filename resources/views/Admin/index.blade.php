@extends('Admin/layouts/master')
@section('title')
    {{$setting->title}} | Dashboard
@endsection
@section('page_name')
    Home
@endsection
@section('content')
{{--    //ahmed--}}


@if($total_sales_today > 1000)
    <div class="row">
        <div class="col-md-12">
            <div class="card  banner">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-lg-2 text-center">
                            <img src="https://laravel.spruko.com/yoha/Sidemenu-Icon-Dark-rtl/assets/images/pngs/profit.png" alt="img" class="w-95">
                        </div>
                        <div class="col-xl-9 col-lg-10 pl-lg-0">
                            <div class="row">
                                <div class="col-xl-7 col-lg-6">
                                    <div class="text-right text-white mt-xl-4">
                                        <h3 class="font-weight-semibold">Congratulations {{loggedAdmin('name')}}</h3>
                                        <h4 class="font-weight-normal">Today's Sales Extends 1000 SAR !</h4>
                                        <p class="mb-lg-0 text-white-50">
                                            today's sales of tickets and reservations extends more than 1000 SAR
                                        </p>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-6 text-lg-center mt-xl-4">
                                    <h5 class="font-weight-semibold mb-1 text-white">Sales Profit Today</h5>
                                    <h2 class="display-2 mb-3 number-font text-white">{{$total_sales_today}}</h2>
                                    <div class="btn-list mb-xl-0">
{{--                                        <a href="#" class="btn btn-dark mb-xl-0">Check Details</a>--}}
                                        <a href="#" class="btn btn-white mb-xl-0" id="skip">Ok, Thanks</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
    <!-- ROW-1 End-->

    <!-- ROW-1 -->
    <div class="row">
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col">
                            <p class="mb-1">Product Sold Today</p>
                            <h3 class="mb-0 number-font">{{$product_sold}} SAR</h3>
                        </div>
                        <div class="col-auto mb-0">
                            <div class="dash-icon text-orange">
                                <i class="bx bxs-shopping-bags"></i>
                            </div>
                        </div>
                    </div>
{{--                    <span class="fs-12 text-muted"> <strong>2.6%</strong><i class="mdi mdi-arrow-up"></i> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>--}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col">
                            <p class="mb-1">Ticket Sales Today</p>
                            <h3 class="mb-0 number-font">{{$tickets_sales_profit}} SAR</h3>
                        </div>
                        <div class="col-auto mb-0">
                            <div class="dash-icon text-secondary">
                                <i class="bx bxs-badge-dollar"></i>
                            </div>
                        </div>
                    </div>
{{--                    <span class="fs-12 text-muted"> <strong>0.15%</strong><i class="mdi mdi-arrow-down"></i> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>--}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col">
                            <p class="mb-1">Reservation Sales Today</p>
                            <h3 class="mb-0 number-font">{{$rev_sales_profit}} SAR</h3>
                        </div>
                        <div class="col-auto mb-0">
                            <div class="dash-icon text-secondary1">
                                <i class="bx bxs-badge-dollar"></i>
                            </div>
                        </div>
                    </div>
{{--                    <span class="fs-12 text-muted"> <strong>0.06%</strong><i class="mdi mdi-arrow-down"></i> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>--}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col">
                            <p class="mb-1">Total Clients</p>
                            <h3 class="mb-0 number-font">{{$all_clients}}</h3>
                        </div>
                        <div class="col-auto mb-0">
                            <div class="dash-icon text-warning">
                                <i class="bx bxs-user"></i>
                            </div>
                        </div>
                    </div>
{{--                    <span class="fs-12 text-muted"> <strong>1.05%</strong><i class="mdi mdi-arrow-up"></i> <span class="text-muted fs-12 ml-0 mt-1">than last week</span></span>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-1 END -->


    <!-- Row-3 -->
{{--    <div class="row">--}}
{{--        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">--}}
{{--            <div class="card overflow-hidden">--}}
{{--                <div class="card-body pb-0">--}}
{{--                    <div class="">--}}
{{--                        <div class="d-flex">--}}
{{--                            <div class="">--}}
{{--                                <p class="mb-1">Monthly Sales</p>--}}
{{--                                <h2 class="mb-1  number-font">42,567</h2>--}}
{{--                                <p class="text-muted  mb-0"><span class="text-muted fs-13 ml-2">(+43%)</span> than Last week</p>--}}
{{--                            </div>--}}
{{--                            <div class="mr-auto">--}}
{{--                                <i class="bx bxs-dollar-circle fs-40 text-secondary"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="chart-wrapper">--}}
{{--                    <canvas id="widgetChart1" class=""></canvas>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-8 col-md-12 col-sm-12 col-xl-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h3 class="card-title">Top Selling Products</h3>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="table card-table border table-vcenter text-nowrap align-items-center">--}}
{{--                            <thead class="">--}}
{{--                            <tr>--}}
{{--                                <th>Product Name</th>--}}
{{--                                <th>Category</th>--}}
{{--                                <th>Price</th>--}}
{{--                                <th>Status</th>--}}
{{--                                <th>Action</th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <img src="https://laravel.spruko.com/yoha/Sidemenu-Icon-Dark-rtl/assets/images/pngs/1.png" alt="img" class="h-7 w-7">--}}
{{--                                    <p class="d-inline-block align-middle mb-0 mr-1">--}}
{{--                                        <a href="" class="d-inline-block align-middle mb-0 product-name text-dark font-weight-semibold">Arm Chair</a>--}}
{{--                                        <br>--}}
{{--                                        <span class="text-muted fs-13">Office Chair</span>--}}
{{--                                    </p>--}}
{{--                                </td>--}}
{{--                                <td>Home Accessories</td>--}}
{{--                                <td class="font-weight-semibold fs-15">$59.00</td>--}}
{{--                                <td><span class="badge badge-danger-light badge-md">Sold</span></td>--}}
{{--                                <td>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <img src="https://laravel.spruko.com/yoha/Sidemenu-Icon-Dark-rtl/assets/images/pngs/2.png" alt="img" class="h-7 w-7">--}}
{{--                                    <p class="d-inline-block align-middle mb-0 mr-1">--}}
{{--                                        <a href="" class="d-inline-block align-middle mb-0 product-name text-dark font-weight-semibold">Arm Chair</a>--}}
{{--                                        <br>--}}
{{--                                        <span class="text-muted fs-13">T-Shirt</span>--}}
{{--                                    </p>--}}
{{--                                </td>--}}
{{--                                <td>Mens Wear</td>--}}
{{--                                <td class="font-weight-semibold fs-15">$45.00</td>--}}
{{--                                <td><span class="badge badge-danger-light badge-md">Sold</span></td>--}}
{{--                                <td>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <img src="https://laravel.spruko.com/yoha/Sidemenu-Icon-Dark-rtl/assets/images/pngs/3.png" alt="img" class="h-7 w-7">--}}
{{--                                    <p class="d-inline-block align-middle mb-0 mr-1">--}}
{{--                                        <a href="" class="d-inline-block align-middle mb-0 product-name text-dark font-weight-semibold">Arm Chair</a>--}}
{{--                                        <br>--}}
{{--                                        <span class="text-muted fs-13">Watch</span>--}}
{{--                                    </p>--}}
{{--                                </td>--}}
{{--                                <td>Men Accessories</td>--}}
{{--                                <td class="font-weight-semibold fs-15">$123.00</td>--}}
{{--                                <td><span class="badge badge-danger-light badge-md">Sold</span></td>--}}
{{--                                <td>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>--}}
{{--                                    <img src="https://laravel.spruko.com/yoha/Sidemenu-Icon-Dark-rtl/assets/images/pngs/4.png" alt="img" class="h-7 w-7">--}}
{{--                                    <p class="d-inline-block align-middle mb-0 mr-1">--}}
{{--                                        <a href="" class="d-inline-block align-middle mb-0 product-name text-dark font-weight-semibold">Arm Chair</a>--}}
{{--                                        <br>--}}
{{--                                        <span class="text-muted fs-13">Hand Bag</span>--}}
{{--                                    </p>--}}
{{--                                </td>--}}
{{--                                <td>Women Accessories</td>--}}
{{--                                <td class="font-weight-semibold fs-15">$98.00</td>--}}
{{--                                <td><span class="badge badge-danger-light badge-md">Sold</span></td>--}}
{{--                                <td>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>--}}
{{--                                    <a class="btn btn-default btn-sm mb-2 mb-xl-0" data-toggle="tooltip" data-original-title="Save to Wishlist"><i class="fa fa-heart-o"></i></a>--}}
{{--                                </td>--}}
{{--                            </tr>--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
    <!-- Row-3 End -->



    <!-- ROW-5 -->
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New Customers</h3>
                </div>
                <div class="customer-scroll">
                    @foreach($new_customers as $customer)
                    <div class="list-group-item d-flex  align-items-center border-top-0 border-left-0">
                        <div class="">
                            <div class="font-weight-semibold">{{$customer->name}}</div>
                            <small class="text-muted"><a href="tel:{{$customer->phone}}"> {{$customer->phone}} </a>
                            </small>
                        </div>
                        <div class="mr-auto">
{{--                            <a href="#" class="btn btn-sm btn-default">View</a>--}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div><!-- COL END -->
        <div class="col-lg-8 col-md-12 col-sm-12 col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Sold Products</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table card-table border table-vcenter text-nowrap align-items-center">
                            <thead class="">
                            <tr>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($latest_products as $product)
                            <tr>
                                <td>
                                    <p class="d-inline-block align-middle mb-0 mr-1">
                                        <a href="" class="d-inline-block align-middle mb-0 product-name text-dark font-weight-semibold">{{$product->product->title}}</a>
                                    </p>
                                </td>
                                <td>{{($product->category->title) ?? ''}}</td>
                                <td><span class="badge badge-{{($product->product->status == '0') ? 'danger' : 'success'}} fs-13">{{($product->product->status == '0') ? 'non-active' : 'active'}}</span></td>
                                <td class="font-weight-semibold fs-15">{{$product->qty}}</td>
                                <td class="font-weight-semibold fs-15">{{$product->total_price}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ROW-5 END -->


@endsection
@section('js')
    <script src="{{asset('assets/admin')}}/plugins/chart/Chart.bundle.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/chart/utils.js"></script>

    <!-- INTERNAL PIETY CHART JS -->
    <script src="{{asset('assets/admin')}}/plugins/peitychart/jquery.peity.min.js"></script>
    <script src="{{asset('assets/admin')}}/plugins/peitychart/peitychart.init.js"></script>
    <!-- INTERNAL APEXCHART JS -->
    <script src="{{asset('assets/admin')}}/js/apexcharts.js"></script>
    <script src="{{asset('assets/admin')}}/js/index1.js"></script>
@endsection
