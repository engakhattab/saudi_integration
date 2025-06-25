<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="#">
            <img src="" class="header-brand-img desktop-logo" alt="logo">
            <img src="" class="header-brand-img toggle-logo" alt="logo">
            <img src="" class="header-brand-img light-logo" alt="logo">
            <img src="" class="header-brand-img light-logo1" alt="logo">
        </a>
    </div>

    @if(auth()->user()->can('Master'))
        <ul class="side-menu">
            <li><h3>Elements</h3></li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('adminHome') }}" aria-label="Home">
                    <i class="icon icon-home side-menu__icon"></i>
                    <span class="side-menu__label">Home</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admins.index') }}" aria-label="Admins">
                    <i class="fe fe-users side-menu__icon"></i>
                    <span class="side-menu__label">Admins</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('category.index') }}" aria-label="Categories">
                    <i class="icon icon-menu side-menu__icon"></i>
                    <span class="side-menu__label">Categories</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('product.index') }}" aria-label="Products">
                    <i class="icon icon-handbag side-menu__icon"></i>
                    <span class="side-menu__label">Products</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('visitors.index') }}" aria-label="Visitors Models">
                    <i class="ti-face-smile side-menu__icon"></i>
                    <span class="side-menu__label">Visitors Models</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('timing.index') }}" aria-label="Working Times">
                    <i class="fe fe-watch side-menu__icon"></i>
                    <span class="side-menu__label">Working Times</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('discount.index') }}" aria-label="Discount Reasons">
                    <i class="fe fe-arrow-down-left side-menu__icon"></i>
                    <span class="side-menu__label">Discount Reasons</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('reference.index') }}" aria-label="References">
                    <i class="fe fe-tag side-menu__icon"></i>
                    <span class="side-menu__label">References</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('coupons.index') }}" aria-label="Corporations">
                    <i class="fe fe-paperclip side-menu__icon"></i>
                    <span class="side-menu__label">Corporations</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('capacities.index') }}" aria-label="Days Capacity">
                    <i class="fe fe-calendar side-menu__icon"></i>
                    <span class="side-menu__label">Days Capacity</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('clients.index') }}" aria-label="Clients">
                    <i class="fe fe-users side-menu__icon"></i>
                    <span class="side-menu__label">Clients</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#" aria-label="Offers">
                    <i class="fe fe-hash side-menu__icon"></i>
                    <span class="side-menu__label">Offers</span>
                    <i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li><a href="{{ route('offers.index') }}" class="slide-item">Show Offers</a></li>
                    <li><a href="{{ route('items.index') }}" class="slide-item">Offers Items</a></li>
                </ul>
            </li>
            @endif
            @if(auth()->user()->can('CS'))
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#" aria-label="Employees">
                        <i class="fe fe-user-plus side-menu__icon"></i>
                        <span class="side-menu__label">Employees</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('users.index') }}" class="slide-item">Employees List</a></li>
                    </ul>
                </li>
            @endif

            @if(auth()->user()->can('Master'))
                <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="#" aria-label="Employees">
                        <i class="fe fe-user-plus side-menu__icon"></i>
                        <span class="side-menu__label">Employees</span>
                        <i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('users.index') }}" class="slide-item">Employees List</a></li>
                        <li><a href="{{ route('roles.index') }}" class="slide-item">Roles</a></li>
                    </ul>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('contact_us.index') }}" aria-label="Contact Us">
                        <i class="fe fe-mail side-menu__icon"></i>
                        <span class="side-menu__label">Contact Us</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('general_setting.index') }}" aria-label="Settings">
                        <i class="fe fe-settings side-menu__icon"></i>
                        <span class="side-menu__label">Settings</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('sliders.index') }}" aria-label="Sliders">
                        <i class="fe fe-camera side-menu__icon"></i>
                        <span class="side-menu__label">Sliders</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('pricesSlider.index') }}" aria-label="Prices & Opening Hours">
                        <i class="fe fe-camera side-menu__icon"></i>
                        <span class="side-menu__label">Prices & Opening Hours</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('obstacleCourses.index') }}" aria-label="Obstacle Courses">
                        <i class="fe fe-camera side-menu__icon"></i>
                        <span class="side-menu__label">Obstacle Courses</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('about_us.index') }}" aria-label="About Page">
                        <i class="fe fe-info side-menu__icon"></i>
                        <span class="side-menu__label">About Page</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('activity.index') }}" aria-label="Activities Page">
                        <i class="fe fe-zap side-menu__icon"></i>
                        <span class="side-menu__label">Activities Page</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('group.index') }}" aria-label="Group Page">
                        <i class="fe fe-git-commit side-menu__icon"></i>
                        <span class="side-menu__label">Group Page</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('tickets.index') }}" aria-label="Tickets">
                        <i class="fas fa-ticket-alt side-menu__icon"></i>
                        <span class="side-menu__label">Tickets</span>
                    </a>
                </li>

                <li class="slide">
                    <a class="side-menu__item" href="{{ route('groups.index') }}" aria-label="Groups">
                        <i class="fas fa-birthday-cake side-menu__icon"></i>
                        <span class="side-menu__label">Groups</span>
                    </a>
                </li>
            @endif
            @if(auth()->user()->can('Master') || auth()->user()->can('Branch Admin'))
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="#" aria-label="Reports">
                    <i class="fe fe-file-text side-menu__icon"></i>
                    <span class="side-menu__label">Reports</span>
                    <i class="angle fa fa-angle-right"></i>
                </a>
                <ul class="slide-menu">
                    <li><a href="{{ route('sales.index') }}" class="slide-item">Family Sales</a></li>
                    <!--<li><a href="{{ route('admin.sales.cancel') }}" class="slide-item">Cancel Sales</a></li>-->
                    <li><a href="{{ route('reservationSale') }}" class="slide-item">Group Sales</a></li>
                    <!--<li><a href="{{ route('GroupCancel') }}" class="slide-item">Cancel Group</a></li>-->
                    <li><a href="{{ route('attendanceReport') }}" class="slide-item">Attendance Report</a></li>
                    <li><a href="{{ route('productSales') }}" class="slide-item">Product Sales</a></li>
                    <li><a href="{{ route('discountReport') }}" class="slide-item">Tickets Discount</a></li>
                    <li><a href="{{ route('reservationReport') }}" class="slide-item">Group Discount</a></li>
                    <li><a href="{{ route('totalCashierSales') }}" class="slide-item">Total Cashier Sales</a></li>
                    <li><a href="{{ route('totalTodaySales') }}" class="slide-item">Total Today Sales</a></li>
                    <li><a href="{{ route('totalProductsSales') }}" class="slide-item">Total Products Sales</a></li>
                    <li><a href="{{ route('repeatedVisitors') }}" class="slide-item">Repeated Visitors</a></li>
                    <li><a href="{{ route('duration.clients') }}" class="slide-item">Duration Clients Spent</a></li>


                </ul>
            </li>
        </ul>
        @endif
</aside>
