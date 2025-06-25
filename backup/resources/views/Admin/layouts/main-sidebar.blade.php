<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="#">
            <img src="" class="header-brand-img desktop-logo" alt="logo">
            <img src="" class="header-brand-img toggle-logo" alt="logo">
            <img src="" class="header-brand-img light-logo" alt="logo">
            <img src="" class="header-brand-img light-logo1" alt="logo">
        </a>
        <!-- LOGO -->
    </div>
    <ul class="side-menu">
        <li><h3>Elements</h3></li>
        <li class="slide">
            <a class="side-menu__item" href="{{route('adminHome')}}">
                <i class="icon icon-home side-menu__icon"></i>
                <span class="side-menu__label">Home</span>
            </a>
        </li>

        @if(admin()->user()->can('Master'))
            <li class="slide">
                <a class="side-menu__item" href="{{route('admins.index')}}">
                    <i class="fe fe-users side-menu__icon"></i>
                    <span class="side-menu__label">Admins</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('category.index')}}">
                    <i class="icon icon-menu side-menu__icon"></i>
                    <span class="side-menu__label">Categories</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('product.index')}}">
                    <i class="icon icon-handbag side-menu__icon"></i>
                    <span class="side-menu__label">Products</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('visitors.index')}}">
                    <i class="ti-face-smile side-menu__icon"></i>
                    <span class="side-menu__label">Visitors Models</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('timing.index')}}">
                    <i class="fe fe-watch side-menu__icon"></i>
                    <span class="side-menu__label">Working Times</span>
                </a>
            </li>



            {{--        <li class="slide">--}}
            {{--            <a class="side-menu__item" href="{{route('bracelet.index')}}">--}}
            {{--                <i class="fe fe-bold side-menu__icon"></i>--}}
            {{--                <span class="side-menu__label">Bracelets</span>--}}
            {{--            </a>--}}
            {{--        </li>--}}

            <li class="slide">
                <a class="side-menu__item" href="{{route('discount.index')}}">
                    <i class="fe fe-arrow-down-left side-menu__icon"></i>
                    <span class="side-menu__label">Discount Reasons</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('reference.index')}}">
                    <i class="fe fe-tag side-menu__icon"></i>
                    <span class="side-menu__label">References</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('coupons.index')}}">
                    <i class="fe fe-paperclip side-menu__icon"></i>
                    <span class="side-menu__label">Corporations</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('capacities.index')}}">
                    <i class="fe fe-calendar side-menu__icon"></i>
                    <span class="side-menu__label">Days Capacity</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('clients.index')}}">
                    <i class="fe fe-users side-menu__icon"></i>
                    <span class="side-menu__label">Clients</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fe fe-hash side-menu__icon"></i>
                    <span class="side-menu__label">Offers</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li><a href="{{route('offers.index')}}" class="slide-item">Show Offers</a></li>
                    <li><a href="{{route('items.index')}}" class="slide-item">Offers Items</a></li>
                </ul>
            </li>

        @endif

    @if(auth()->user()->can('Branch Admin') || admin()->user()->can('Master'))

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#">
                    <i class="fe fe-user-plus side-menu__icon"></i>
                    <span class="side-menu__label">Employees</span><i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li><a href="{{route('users.index')}}" class="slide-item" style="font-size: 14px">Employees List</a>
                    </li>
                    <li><a href="{{route('roles.index')}}" class="slide-item" style="font-size: 14px">Roles</a></li>
                </ul>
            </li>
            @endif


            @if(auth()->user()->can('CS') || admin()->user()->can('Master'))
                <li class="slide">
                    <a class="side-menu__item" href="{{route('contact_us.index')}}">
                        <i class="fe fe-mail side-menu__icon"></i>
                        <span class="side-menu__label">Contact Us
                    <span id="contact-span">

                    </span>
                </span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->can('Setting') || admin()->user()->can('Master'))
                <li class="slide">
                    <a class="side-menu__item" href="{{route('general_setting.index')}}">
                        <i class="fe fe-settings side-menu__icon"></i>
                        <span class="side-menu__label">Setting</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->can('Marketing') || admin()->user()->can('Master'))

                <li class="slide">
                    <a class="side-menu__item" href="{{route('sliders.index')}}">
                        <i class="fe fe-camera side-menu__icon"></i>
                        <span class="side-menu__label">Sliders</span>
                    </a>
                </li>
            <li class="slide">
                <a class="side-menu__item" href="{{route('pricesSlider.index')}}">
                    <i class="fe fe-camera side-menu__icon"></i>
                    <span class="side-menu__label">Prices & Opening hours</span>
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" href="{{route('obstacleCourses.index')}}">
                    <i class="fe fe-camera side-menu__icon"></i>
                    <span class="side-menu__label">Obstacle Courses</span>
                </a>
            </li>

            <li class="slide">
                    <a class="side-menu__item" href="{{route('about_us.index')}}">
                        <i class="fe fe-info side-menu__icon"></i>
                        <span class="side-menu__label">About Page</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{route('activity.index')}}">
                        <i class="fe fe-zap side-menu__icon"></i>
                        <span class="side-menu__label">Activities Page</span>
                    </a>
                </li>

            <li class="slide">
                <a class="side-menu__item" href="{{route('group.index')}}">
                    <i class="fe fe-git-commit side-menu__icon"></i>
                    <span class="side-menu__label">Group Page</span>
                </a>
            </li>
            @endif

        <li class="slide">
            <a class="side-menu__item" data-toggle="slide" href="#">
                <i class="fe fe-file-text side-menu__icon"></i>
                <span class="side-menu__label">Reports</span><i class="angle fa fa-angle-right"></i>
            </a>
            <ul class="slide-menu">
                <li><a href="{{route('sales.index')}}" class="slide-item">Family Sales</a></li>
                <li><a href="{{route('admin.sales.cancel')}}" class="slide-item">Cancel Sales</a></li>
                <li><a href="{{route('reservationSale')}}" class="slide-item">Group Sales</a></li>
                <li><a href="{{route('attendanceReport')}}" class="slide-item">Attendance Report</a></li>
                <li><a href="{{route('productSales')}}" class="slide-item">Product Sales</a></li>
                <li><a href="{{route('discountReport')}}" class="slide-item">Tickets Discount</a></li>
                <li><a href="{{route('reservationReport')}}" class="slide-item">Group Discount</a></li>
                <li><a href="{{route('totalCashierSales')}}" class="slide-item">Total Cashier Sales</a></li>
                <li><a href="{{route('totalProductsSales')}}" class="slide-item">Total Products Sales</a></li>
            </ul>
        </li>



    </ul>
</aside>
