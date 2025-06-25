<!-- ================================ NavBar ================== -->
<nav id="navbarBlur"
     class="navbar navbar-main navbar-expand-lg position-sticky mt-2 top-1 p-2 px-3 mx-4 bg-white shadow-blur  border-radius-xl z-index-sticky"
     data-scroll="true"> <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-2">
            <li class="breadcrumb-item text-sm">
                <a class="opacity-3 text-dark" href="{{route('sales')}}">
                    <i class="fas fa-house-day"></i>
                </a>
            </li>
            @yield('links')
        </ol>
    </nav>
    <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none ">
        <a href="#!" class="nav-link text-body p-0">
            <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
            </div>
        </a>
    </div>
    <div class="collapse navbar-collapse  me-md-0 me-sm-4" id="navbar">
        <ul class="ms-md-auto navbar-nav  justify-content-end">
            @if(auth()->check())
                <li class="nav-item d-flex align-items-center">
                    <span class="d-inline p-3">Cashier : {{auth()->user()->name}}</span>
                    <a href="{{route('logout')}}" class="nav-link text-body font-weight-bold px-0">
                        <span class="d-inline">Log out</span>
                        <i class="fa fa-user ms-2"></i>
                    </a>
                </li>
            @else
                <li class="nav-item d-flex align-items-center">
                    <a href="{{route('login')}}" class="nav-link text-body font-weight-bold px-0">
                        <span class="d-inline">Log In</span>
                        <i class="fa fa-user ms-2"></i>
                    </a>
                </li>
            @endif

            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="#!" class="nav-link text-body p-0" id="iconNavbarSidenav">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </a>
            </li>
        </ul>
    </div> </nav>
<!-- ================================ end NavBar ================== -->
