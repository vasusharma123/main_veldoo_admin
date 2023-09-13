<header class="header_top_sidebar">
    <div class="dashboard_navbar">
        <section class="top_menu">
           <article class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="notify_menus">
                        <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="brand logo" class="img-fluid logo_mobile_top me-5"/>
                        
                            <div class="menus cs_menus me-auto">
                                <nav class="navbar navbar-expand-lg newTop_menu">
                                    <ul class="navbar-nav align-items-center newTop_menu_ul">
                                        <li class="nav-item">
                                            <a class="nav-link active dotnot img_clone_menu" aria-current="page" href="{{ route('company.rides') }}">
                                                <img src="{{ asset('new-design-company/assets/images/home_img.png') }}" class="img-fuild image_home" alt="home-icon"/>
                                            </a>
                                        </li>

                                        @if(\Request::get('token'))
                                            <li class="nav-item"><a class="nav-link dotnot" href="{{ route('guest.rides',['month','token' => \Request::get('token')]) }}">My Booking</a></li>
                                        @else 
                                            <li class="nav-item"><a class="nav-link dotnot" href="{{ route('guest.rides','month') }}">My Booking</a></li>

                                        @endif


                                       
                                       

                                        @if (Auth::check())

                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('logout') }}?customer=true">Logout</a>
                                        </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                            @yield('header_button')
                            <div class="viewUser_content d-flex align-items-center">
                               @if (Auth::check())
                                <img src="{{ Auth::user()->image?env('URL_PUBLIC').'/'.Auth::user()->image:asset('new-design-company/assets/images/user.png') }}" alt="User avatar" class="img-fluid user_avatar"/>
                                <div class="name_occupation d-flex flex-column top_header_nav desktop_view">
                                    <span class="user_name">{{ Auth::user()->name }}</span>
                                    <!-- <span class="user_position">{{ Auth::user()->first_name ? Auth::user()->first_name : Auth::user()->last_name }}</span> -->
                                </div>

                                @else 


                                <div class="name_occupation d-flex flex-column top_header_nav desktop_view">
                                    <a class="nav-link user_name" href="{{route('guest.login')}}">Login</a>

                                </div>


                                <!-- <div class="viewUser_content d-flex align-items-center">
                                <div class="name_occupation d-flex flex-column top_header_nav desktop_view">
                                    <a href="index.php" class="user_name cs_link ">Login</a>
                                </div>
                                </div> -->
                                @endif


                            </div>
                            
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
