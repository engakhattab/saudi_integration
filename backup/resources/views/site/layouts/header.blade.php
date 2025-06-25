<!-- ================ spinner ================= -->
<!-- <div class="spinner"></div> -->
<!-- ================ spinner ================= -->
<!-- ================ Header ================= -->
<nav class="navbar mainNav  navbar-expand-lg navbar-light fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{route('/')}}"> <img class="logo" src="{{asset($setting->logo)}}" > </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto my-3 my-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('/')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('about_us')}}">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('activities')}}">Activities</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('groups')}}">Groups</a>
                </li>
{{--                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="{{route('terms')}}">Terms</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('contact_us')}}">contact us</a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('createCapacity')}}" class="default-btn"> <i class="fab fa-affiliatetheme me-2"></i> BOOK YOUR STAY--}}
{{--                        <span></span>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
</nav>

<!-- ================ /Header ================= -->
