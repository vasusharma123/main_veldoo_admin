<header class="header_top_sidebar">
    <div class="dashboard_navbar">
        <section class="top_menu">
           <article class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="notify_menus">
                        
                        @if (Auth::check() && !empty($companyInfo->logo) )
                        <img src="{{ config('app.url_public').'/'.$companyInfo->logo  }}" alt="brand logo" class="img-fluid logo_mobile_top me-5"/>
                        @elseif (!empty($configuration) && !empty($configuration->logo))
                        <img src="{{ env('URL_PUBLIC').'/'.$configuration['logo'] }}" alt="brand logo" class="img-fluid logo_mobile_top me-5"/>
                        @else
                        <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="brand logo" class="img-fluid logo_mobile_top me-5"/>
                        @endif
                        
                            <div class="menus cs_menus ms-auto me-2">
                                <nav class="navbar navbar-expand-lg newTop_menu">
                                    <ul class="navbar-nav align-items-center newTop_menu_ul">
                                        <!-- <li class="nav-item">
                                            <a class="nav-link active dotnot img_clone_menu" aria-current="page" href="{{ route('company.rides','month') }}">
                                                <img src="{{ asset('new-design-company/assets/images/home_img.png') }}" class="img-fuild image_home" alt="home-icon"/>
                                            </a>
                                        </li> -->
                                        
                                        <li class="nav-item dotnot">
                                            <a class="nav-link dotnot {{ request()->segment(count(request()->segments()) - 1) == 'rides' ? 'active' : '' }}" href="{{ route('company.rides','month') }}">My Booking</a>
                                        </li>
                                        
                                        @if (Auth::check() && Auth::user()->user_type == 4)


                                        <li class="nav-item">
                                            <a class="nav-link {{request()->segment(count(request()->segments())) == 'managers' ? 'active' : '' }}" href="{{ route('managers.index') }}">Managers</a>
                                        </li>

                                        @endif
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->segment(count(request()->segments())) == 'company-users' ? 'active' : '' }}" href="{{ route('company-users.index') }}">Users</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{request()->segment(count(request()->segments())) == 'settings' ? 'active' : '' }}" href="{{ route('company.settings') }}">Settings</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('company_logout') }}">Logout</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            @yield('header_button')
                            <div class="viewUser_content d-flex align-items-center">
                               @if (Auth::check())
                                <img src="{{ Auth::user()->image ? env('URL_PUBLIC').'/'.Auth::user()->image:asset('new-design-company/assets/images/user.png') }}" alt="User avatar" class="img-fluid user_avatar"/>
                                <div class="name_occupation d-flex flex-column top_header_nav desktop_view">
                                    <span class="user_name">{{ Auth::user()->name }}</span>
                                    <!-- <span class="user_position">{{ Auth::user()->user_type==5?'Manager':'Admin' }}</span> -->
                                </div>
                                @endif

                            </div>
                            {{-- <button type="button" class="btn addNewBtn_cs me-4">
                                <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon " class="img-fluid add_booking_icon svg add_icon_svg" />
                                <span class="text_button">Add Manager</span>
                            </button>
                            <button type="button" class="btn addNewBtn_cs me-4">
                                <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon " class="img-fluid add_booking_icon svg add_icon_svg" />
                                <span class="text_button">Add User</span>
                            </button>
                            <button type="button" class="btn addNewBtn_cs me-4">
                                <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon " class="img-fluid add_booking_icon svg add_icon_svg" />
                                <span class="text_button">Settings</span>
                            </button>
                            <div class="viewUser_content d-flex align-items-center">
                                <img src="{{ asset('new-design-company/assets/images/user.png') }}" alt="User avatar" class="img-fluid user_avatar"/>
                                <div class="name_occupation d-flex flex-column top_header_nav desktop_view">
                                    <span class="user_name">Jameson</span>
                                    <span class="user_position">Admin</span>
                                </div>
                            </div> --}}
                            <a href="#" class="btn menu_toggle_btn mobile_view">
                                <span class="line_menu"></span>
                                <span class="line_menu"></span>
                                <span class="line_menu"></span>
                            </a> 
                        </div>
                    </div>
                </div>
           </article>
        </section>
    </div>
</header>
