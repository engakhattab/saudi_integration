<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{asset('assets/sales')}}/img/favicon.png">
{{--<title> {{$setting->title}} </title>--}}
<!-- CSS Files -->
<link id="pagestyle" href="{{asset('assets/sales')}}/css/app.min.css" rel="stylesheet" />
<link href="{{asset('assets/sales')}}/css/font.awesome.css" rel="stylesheet" />
<link href="{{asset('assets/sales')}}/css/style.css" rel="stylesheet" />
<!-- data table -->
<link href="{{asset('assets/sales')}}/css/datatables.min.css" rel="stylesheet" />
<style>
.toast-container{
    margin-bottom: 50px;
}
.navbar-vertical .navbar-nav>.nav-item .nav-link.active {
    background-color: #eee;

}
.toDay {
    background-color: #eee7 !important;
    -webkit-box-shadow: 0px 10px 30px #00000030;
    box-shadow: 0px 10px 30px #00000030;
    /* -webkit-transform: scale(1.02); */
    transform: scale(1.02);
    z-index: 2;
    border: 1px solid gray !important;
}
.to_print{
    width: 100% !important;
    height: 100% !important;
}
</style>
@toastr_css
@yield('css')
