<!-- ================================ Side Nav ============== -->
<aside id="sidenav-main"
       class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-white">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
           aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="/">
            <img src="{{asset($setting->logo)}}" class="navbar-brand-img h-100" alt="main_logo">
        <!-- <span class="ms-1 font-weight-bold">{{$setting->title}}</span> -->
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto h-auto h-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- nav-item  -->
            <li class="nav-item">
                <a href="{{route('sales')}}" class="nav-link" id="mainHome">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="nav-link-text ms-1">Home</span>
                </a>
            </li>

{{--            <li class="nav-item">--}}
{{--                <a href="{{route('forceupdate')}}" class="nav-link" id="mainHome">--}}
{{--                    <div--}}
{{--                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">--}}
{{--                        <i class="fas fa-home"></i>--}}
{{--                    </div>--}}
{{--                    <span class="nav-link-text ms-1">Sync database</span>--}}
{{--                </a>--}}
{{--            </li>--}}
            @can('Family Sale')
            <!-- nav-item  -->
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#familySale" class="nav-link " id="main-family"
                       aria-controls="familySale" role="button"
                       aria-expanded="false">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <i class="fas fa-users-crown"></i>
                        </div>
                        <span class="nav-link-text ms-1">Family Sale</span>
                    </a>
                    <div class="collapse  " id="familySale">
                        <ul class="nav ms-4 ps-3">
                            @can('Add Client')
                                <li class="nav-item createClient">
                                    <a class="nav-link createClient" href="{{route('client.create')}}">
                                        <span class="sidenav-mini-icon"> A </span>
                                        <span class="sidenav-normal"> Add Client </span>
                                    </a>
                                </li>
                            @endcan

                            @can('Edit Ticket')
                                <li class="nav-item tickets">
                                    <a class="nav-link tickets" href="{{route('ticket.search')}}">
                                        <span class="sidenav-mini-icon"> T </span>
                                        <span class="sidenav-normal"> Edit Tickets </span>
                                    </a>
                                </li>
                            @endcan

                            @can('Family Access')
                                <li class="nav-item familyAccess">
                                    <a class="nav-link familyAccess" href="{{route('familyAccess.index')}}">
                                        <span class="sidenav-mini-icon"> F </span>
                                        <span class="sidenav-normal"> Family Access </span>
                                    </a>
                                </li>
                            @endcan

{{--                                @can('Family Rate')--}}
                                    <li class="nav-item familyClients">
                                        <a class="nav-link familyClients" href="{{route('familyClient.index')}}">
                                            <span class="sidenav-mini-icon"> C </span>
                                            <span class="sidenav-normal"> Family Clients </span>
                                        </a>
                                    </li>
{{--                                @endcan--}}
                        </ul>
                    </div>
                </li>
                <!-- nav-item  -->
            @endcan

            @can('Group Sale')
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#groupSale" class="nav-link " id="main-group"
                   aria-controls="groupSale" role="button"
                   aria-expanded="false">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <i class="fad fa-bus-school"></i>
                    </div>
                    <span class="nav-link-text ms-1">Group Sale</span>
                </a>
                <div class="collapse" id="groupSale">
                    <ul class="nav ms-4 ps-3">
                        @can('Reservation')
                            <li class="nav-item createReservation">
                                <a class="nav-link createReservation" href="{{route('reservations.index')}}">
                                    <span class="sidenav-mini-icon"> R </span>
                                    <span class="sidenav-normal"> Reservations </span>
                                </a>
                            </li>
                        @endcan

                        @can('Capacity')
                            <li class="nav-item capacity">
                                <a class="nav-link capacity" href="{{route('capacity.index')}}?month={{date('Y-m')}}">
                                    <span class="sidenav-mini-icon"> C </span>
                                    <span class="sidenav-normal"> Capacity </span>
                                </a>
                            </li>
                        @endcan

                        @can('Group Access')
                            <li class="nav-item groupAccess">
                                <a class="nav-link groupAccess" href="{{route('groupAccess.index')}}">
                                    <span class="sidenav-mini-icon"> G </span>
                                    <span class="sidenav-normal"> Group Access </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
            @endcan

            @can('Corporations')
            <!-- nav-item  -->
                <li class="nav-item">
                    <a href="{{route('sales.coupons')}}" class="nav-link" id="coupon">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <i class="fas fa-ticket-alt"></i>
                        </div>
                        <span class="nav-link-text ms-1">Corporations</span>
                    </a>
                </li>
                <!-- nav-item  -->
            @endcan

            <li class="nav-item">
                <a href="{{ route('sales.query') }}" class="nav-link" id="main-query">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                        <i class="fas fa-search-dollar"></i>
                    </div>
                    <span class="nav-link-text ms-1">Query</span>
                </a>
            </li>

            @can('Exit')
                <li class="nav-item">
                    <a href="{{route('exit.index')}}" class="nav-link" id="main-exit">
                        <div
                            class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center d-flex align-items-center justify-content-center  me-2">
                            <i class="fad fa-door-open"></i>
                        </div>
                        <span class="nav-link-text ms-1">Exit</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</aside>
<!-- ================================ end Side Nav ================== -->
