<!DOCTYPE html>
<html>
    <head>
        <title>Account</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap V5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap V5 ICON -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- Custom Style -->
        <link href="{{ asset('company/assets/css/style.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="all_content">
           
            <main class="body_content ">
                <div class="row m-0 w-100">
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 p-0">
                        <aside class="sidebar">
                            <div class="sideBar_userinfo">
                                <img src="{{ asset('company/assets/imgs/logo.png') }}" alt="Brand Logo" class="img-fluid sidebar_brand_img">
                                <div class="user_information">
                                    <img src="{{ asset('company/assets/imgs/logo.png') }}" alt="Brand Logo" class="img-fluid mobileImg">
                                    <div class="userBox">
                                        <div class="avatarImg">
                                            <img src="{{ asset('company/assets/imgs/avatar_user.png') }}" alt="User Avatar" class="img-fluid user_img">
                                        </div>
                                        <div class="user_name">
                                            <h4 class="name">Rylle Kincaid</h4>
                                            <p class="occupation">Super Admin</p>
                                        </div>
                                    </div>
                                    <!-- UserBox -->
                                    <button class="btn btn_toggle_nav"><i class="bi bi-list"></i></button>
                                </div>
                                <!-- User Information-->

                                <div class="sideBar_menu">
                                    <ul class="list-group list-group-flush background-transparent">
                                        <li class="list-group-item"><a href="booking.html"><img src="{{ asset('company/assets/imgs/sideBarIcon/redcar.png') }}" class="img-fluid sideBar_icon_img me-3" alt="Booking"><span class="title_menu">Booking</span></a></li>
                                        <li class="list-group-item"><a href="history.html"><img src="{{ asset('company/assets/imgs/sideBarIcon/history.png') }}" class="img-fluid sideBar_icon_img me-3" alt="History"><span class="title_menu">History</span></a></li>
                                        @can('isCompany')	
                                            <li class="list-group-item"><a href="{{ route('managers.index') }}"><img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" class="img-fluid sideBar_icon_img me-3" alt="Managers"><span class="title_menu">{{ __('Managers') }}</span></a></li>
                                        @endcan
                                        <li class="list-group-item"><a href="user.html"><img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" class="img-fluid sideBar_icon_img me-3" alt="User"><span class="title_menu">User</span></a></li>
                                        <li class="list-group-item"><a href="help.html"><img src="{{ asset('company/assets/imgs/sideBarIcon/help.png') }}" class="img-fluid sideBar_icon_img me-3" alt="Help"><span class="title_menu">Help</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <!-- Sidebar End -->
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 p-0">
                        <div class="login_user_page right_content inside_dashboard_user">
                            <div class="container-fluid all_details_boxes">
                              @yield('content')
                            </div>
                        </div>
                    </div>
                    <!-- Content End -->

                </div>
            </main>
            <!-- Body Content -->
        </div>
        <!-- All Content -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!-- Bootstrap V5 JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom Script -->
        <script src="{{ asset('assets/js/main.js') }}"></script>

    </body>
</html>