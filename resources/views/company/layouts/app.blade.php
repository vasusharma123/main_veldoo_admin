<!DOCTYPE html>
<html>
    <head>
        <title>{{ env('APP_NAME') }} {{ isset($page_title)?' - '.$page_title:'' }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap V5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap V5 ICON -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <!-- Custom Style -->
        <link href="{{ asset('company/assets/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" integrity="sha512-gxWow8Mo6q6pLa1XH/CcH8JyiSDEtiwJV78E+D+QP0EVasFs8wKXq16G8CLD4CJ2SnonHr4Lm/yY2fSI2+cbmw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <style>
            .iti
            {
                display: block !important;
                margin-bottom: 7px !important;
            }
        </style>
        @yield('css')
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
                                            <h4 class="name">{{ Auth::user()->first_name.' '.Auth::user()->name.' '.Auth::user()->last_name }}</h4>
                                            <p class="occupation">Super Admin</p>
                                        </div>
                                    </div>
                                    <!-- UserBox -->
                                    <button class="btn btn_toggle_nav"><i class="bi bi-list"></i></button>
                                </div>
                                <!-- User Information-->

                                <div class="sideBar_menu">
                                    <ul class="list-group list-group-flush background-transparent">
                                        <li class="list-group-item" data-image="redcar"><a href="booking.html"><img src="{{ asset('company/assets/imgs/sideBarIcon/redcar.png') }}" class="img-fluid sideBar_icon_img me-3" alt="Booking"><span class="title_menu">Booking</span></a></li>
                                        <li class="list-group-item" data-image="history"><a href="history.html"><img src="{{ asset('company/assets/imgs/sideBarIcon/history.png') }}" class="img-fluid sideBar_icon_img me-3" alt="History"><span class="title_menu">History</span></a></li>
                                        @can('isCompany')	
                                            <li class="list-group-item Managers" data-image="accounts">
                                                <a href="{{ route('managers.index') }}"><img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" class="img-fluid sideBar_icon_img me-3" alt="Managers"><span class="title_menu">{{ __('Managers') }}</span></a>
                                            </li>
                                        @endcan
                                        <li class="list-group-item Users" data-image="accounts">
                                            <a href="{{ route('company-users.index') }}">
                                                <img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" class="img-fluid sideBar_icon_img me-3" alt="User"><span class="title_menu">User</span>
                                            </a>
                                        </li>
                                        <li class="list-group-item Users" data-image="Settings">
                                            <a href="{{ route('company.settings') }}">
                                                <img src="{{ asset('company/assets/imgs/sideBarIcon/setting.png') }}" class="img-fluid sideBar_icon_img me-3" alt="Settings"><span class="title_menu">Settings</span>
                                            </a>
                                        </li>
                                        <li class="list-group-item" data-image="logout">
                                            <a href="{{ route('logout') }}?company=true">
                                                <img src="{{ asset('company/assets/imgs/sideBarIcon/logout.png') }}" class="img-fluid sideBar_icon_img me-3" alt="Help"><span class="title_menu">Logout</span>
                                            </a>
                                        </li>
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
        @yield('modals')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!-- Bootstrap V5 JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom Script -->
        <script src="{{ asset('company/assets/js/main.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js" integrity="sha512-+gShyB8GWoOiXNwOlBaYXdLTiZt10Iy6xjACGadpqMs20aJOoh+PJt3bwUVA6Cefe7yF7vblX6QwyXZiVwTWGg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput-jquery.min.js" integrity="sha512-9WaaZVHSw7oRWH7igzXvUExj6lHGuw6GzMKW7Ix7E+ELt/V14dxz0Pfwfe6eZlWOF5R6yhrSSezaVR7dys6vMg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
        <script>
            $(function(){
                @if (isset($page_title))
                    $('.{{ $page_title }}').addClass('active');
                @endif
            });
            jQuery("#Regphones").intlTelInput({
                    initialCountry:"us",
                    separateDialCode: true,
                    utilsScript: "{{url('assets/js/utils.js')}}",
                    customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                        return "";
                    },
            });  

            var input = $('#Regphones').intlTelInput("setNumber", "+1");
            input.on("countrychange", function() {
                $(".country_code").val($("#Regphones").intlTelInput("getSelectedCountryData").dialCode);
            });

            jQuery("#RegAlterenatePhones").intlTelInput({
                    initialCountry:"us",
                    separateDialCode: true,
                    utilsScript: "{{url('assets/js/utils.js')}}",
                    customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                        return "";
                    },
            });  
            
            var input_1 = $('#RegAlterenatePhones').intlTelInput("setNumber", "+1");
            input_1.on("countrychange", function() {
                $(".second_country_code").val($("#RegAlterenatePhones").intlTelInput("getSelectedCountryData").dialCode);
            });

            jQuery("#Regphones_edit").intlTelInput({
                    initialCountry:"us",
                    separateDialCode: true,
                    utilsScript: "{{url('assets/js/utils.js')}}",
                    autoFormat: false,
                    customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                        return "";
                    },
            });  
            
            var input_edit = $('#Regphones_edit').intlTelInput("setNumber", "+1");
            input_edit.on("countrychange", function() {
                $(".country_code_edit").val($("#Regphones_edit").intlTelInput("getSelectedCountryData").dialCode);
            });

            filters = {
                searchText: ''
            }
            function renderBySearch(recipes, filters,type) {
                // console.log(recipes);
                if(type=="users")
                {
                    var results = $.grep(recipes, function (object) {
                        return object.phone.toLowerCase().includes(filters.searchText.toLowerCase()) || object.email.toLowerCase().includes(filters.searchText.toLowerCase()) || object.first_name.toLowerCase().includes(filters.searchText.toLowerCase()) || object.last_name.toLowerCase().includes(filters.searchText.toLowerCase());
                    });
                }
                if(type=="managers")
                {
                    var results = $.grep(recipes, function (object) {
                        return object.name.toLowerCase().includes(filters.searchText.toLowerCase()) || object.phone.toLowerCase().includes(filters.searchText.toLowerCase()) || object.email.toLowerCase().includes(filters.searchText.toLowerCase());
                    });
                }
                return results;
            }
        </script>
        @yield('footer_scripts')
    </body>
</html>