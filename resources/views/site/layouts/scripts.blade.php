<script src="{{asset('assets/site')}}/js/jquery.min.js"></script>
<script src="{{asset('assets/site')}}/js/popper.min.js"></script>
<script src="{{asset('assets/site')}}/js/jquery.appear.js"></script>
<script src="{{asset('assets/site')}}/js/odometer.min.js"></script>
<script src="{{asset('assets/site')}}/js/bootstrap.min.js"></script>
<script src="{{asset('assets/site')}}/js/swiper-bundle.min.js"></script>
{{--<script src="{{asset('assets/site')}}/js/fancybox.js"></script>--}}
<script src="{{asset('assets/site')}}/js/atropos.min.js"></script>
<script src="{{asset('assets/site')}}/js/fancybox.umd.js"></script>
<script src="{{asset('assets/site')}}/js/WOW.js"></script>
<script src="{{asset('assets/site')}}/js/Custom.js?{{time()}} "></script>
<script>
    // goBack
    function goBack() {
        window.history.back();
    }
</script>
<script>
    $('ul > li a[href$="' + window.location.pathname + '"]').addClass('active');
    if(window.location.pathname === '/')
        $('ul li:first a').addClass('active');
</script>
<script type="text/javascript" src="{{asset('assets/sales')}}/js/toastr.js"></script>
@toastr_render
