<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ env('APP_NAME') }} {{ isset($page_title)?' - '.$page_title:'' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.png')}}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap V5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- TelePhone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />

    <!-- Style -->
    <link href="{{ asset('/assets/css/master-admin.css')}}" rel="stylesheet">

    {{-- Section Added for custom css --}}
    @yield('css')
</head>
<body>
    <div class="main_wrapper">
        <header class="main_header">
            <section class="menu_top">
                <article class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-5 col-5 align-self-center">
                            <div class="logo_box">
                                <img src="{{ asset('/assets/imgs/brand_logo.png')}}" class="img-fluid w-100 brnd_img" alt="Brand Name Veldoo" />
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-2 col-sm-2 col-2 align-self-center trigger_parent">
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">

                                {{-- Section Added for header left menu part --}}
                                @yield('header_menu_list')
                            </ul>
                        </div>
                        <div class="col-lg-5 col-md-7 col-sm-5 col-5 align-self-center">
                            <div class="right_content_menu">

                                {{-- Section Added for header right menu part --}}
                                @yield('header_search_export')
                                <div class="avatar_info_box">
                                    <img src="{{ Auth::user()->image?env('URL_PUBLIC').'/'.Auth::user()->image:asset('new-design-company/assets/images/user.png') }}" alt="User avatar" class="img-fluid w-100 avatar_img" />
                                    <div class="user_info">
                                        <h4 class="nameOfUser">{{ Auth::user()->name}}</h4>
                                        <p class="userInfo">Master Admin</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </header>
        <main class="body_content">
            <div class="inside_body">
                <div class="container-fluid p-0">
                    <div class="row m-0 w-100">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                            <div class="body_flow">
                                <div class="sidebarFlow">
                                    <i class="bi bi-chevron-right sidebarToggler"></i>
                                    <section class="sidebar">
                                        <i class="bi bi-x-lg sidebarToggler">&nbsp; <span>Close</span></i>
                                        <article class="all_sidebar_box">
                                            <ul class="nav sidebarLists w-100">
                                                @php
                                                $currentUri = request()->path();
                                                $uriWithoutSlashOrAsterisk = str_replace('/', '', $currentUri);
                                                @endphp
                                                <li class="nav-item w-100">
                                                    <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'master-dashboard') { echo "active";  }  ?>" href="/master-dashboard">
                                                        <img src="{{ asset('assets/imgs/dashboard.png')}}" class="img-fluid w-100 sidebarImgs" alt="dashboard" />
                                                        <span class="sidebarText">Dashboard</span>
                                                        <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                                    </a>
                                                </li>
                                                <li class="nav-item w-100">
                                                    <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'service-provider' || $uriWithoutSlashOrAsterisk == 'master-plan' || $uriWithoutSlashOrAsterisk == 'plan-detail' || $uriWithoutSlashOrAsterisk == 'billing') { echo "active";  }  ?>" href="/service-provider">
                                                        <img src="{{ asset('assets/imgs/users.png') }}" class="img-fluid w-100 sidebarImgs" alt="users" />
                                                        <span class="sidebarText">Service provider</span>
                                                        <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                                    </a>
                                                </li>

                                                <li class="nav-item w-100">
                                                    <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'master-setting') { echo "active";  }  ?> " href="{{ route('master_admin.setting') }}">
                                                        <img src="{{ asset('assets/imgs/setting.png')}}" class="img-fluid w-100 sidebarImgs" alt="Settings" />
                                                        <span class="sidebarText">Settings</span>
                                                        <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                                    </a>
                                                </li>
                                                <li class="nav-item w-100">
                                                    <a class="nav-link" href="{{ route('master_admin.logout') }}">
                                                        <img src="{{ asset('assets/imgs/logout.png')}}" class="img-fluid w-100 sidebarImgs" alt="logout" />
                                                        <span class="sidebarText">Logout</span>
                                                        <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </article>
                                    </section>
                                </div>
                                <div class="formTableContent">
                                    @yield('content')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap V5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JS -->
    <script src="{{ asset('assets/js/main.js')}}"></script>

    {{-- Section Added for footer script --}}
    @yield('footer_scripts')
</body>
</html>
