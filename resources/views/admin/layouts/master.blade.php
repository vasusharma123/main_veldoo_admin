<!DOCTYPE html>
<html lang="en">
<?php ///dd($uri); ?>
<head>
    <title>Veldoo - Service Provider</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap V5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />


    <!-- Timer css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/timepicker@1.14.1/jquery.timepicker.min.css">
    <!-- Style -->
    <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" id="theme" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/veldoo-style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/veldoo-dev-style.css') }}" />

    @php
        if (!empty($configuration['background_image']) && file_exists('storage/' . $configuration['background_image'])) {
            $backgroundImage = env('URL_PUBLIC') . '/' . $configuration['background_image'];
        } else {
            $backgroundImage = asset('assets/imgs/bg_body.png');
        }

        if (!empty($configuration) && !empty($configuration->header_color)) {
            $primaryColor = $configuration->header_color;
        } else {
            $primaryColor = '#FC4C02';
        }

        if (!empty($configuration) && !empty($configuration->header_font_family)) {
            $header_font_family = $configuration->header_font_family;
        } else {
            $header_font_family = "'Oswald', sans-serif";
        }

        if (!empty($configuration) && !empty($configuration->header_font_color)) {
            $header_font_color = $configuration->header_font_color;
        } else {
            $header_font_color = '#ffffff';
        }

        if (!empty($configuration) && !empty($configuration->header_font_size)) {
            $header_font_size = $configuration->header_font_size;
        } else {
            $header_font_size = '16px';
        }

        if (!empty($configuration) && !empty($configuration->input_color)) {
            $input_color = $configuration->input_color;
        } else {
            $input_color = 'rgba(255, 255, 255, 0.5)';
        }

        if (!empty($configuration) && !empty($configuration->input_font_family)) {
            $input_font_family = $configuration->input_font_family;
        } else {
            $input_font_family = 'var(--bs-body-font-family)';
        }

        if (!empty($configuration) && !empty($configuration->input_font_color)) {
            $input_font_color = $configuration->input_font_color;
        } else {
            $input_font_color = '#212529';
        }

        if (!empty($configuration) && !empty($configuration->input_font_size)) {
            $input_font_size = $configuration->input_font_size;
        } else {
            $input_font_size = '1rem';
        }

        if (!empty($configuration) && !empty($configuration->ride_color)) {
            $ride_color = $configuration->ride_color;
        } else {
            $ride_color = '#356681';
        }
    @endphp

    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --primary-font-family: {{ $header_font_family }};
            --primary-font-color: {{ $header_font_color }};
            --primary-font-size: {{ $header_font_size }};
            --primary-input-color: {{ $input_color }};
            --primary-input-font-family: {{ $input_font_family }};
            --primary-input-font-color: {{ $input_font_color }};
            --primary-input-font-size: {{ $input_font_size }};
            --primary-ride-color: {{ $ride_color }}
        }

        body {
            background-image: url({{ $backgroundImage }});
        }
		.pending-ride-class-row{
			background-color: var(--primary-color) !important;
		}
    </style>

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
                                {{-- @if(Auth::user()->setting && !empty(Auth::user()->setting->logo) && file_exists('storage/'.Auth::user()->setting->logo))
                                <img src="{{ env('URL_PUBLIC').'/'.Auth::user()->setting->logo }}" class="img-fluid w-100 brnd_img" alt="Brand Name Veldoo" />
                                @else --}}
                                <img src="{{ asset('assets/images/veldoo/brand_logo.png') }}" class="img-fluid w-100 brnd_img" alt="Brand Name Veldoo" />
                                {{-- @endif --}}
                            </div>
                        </div>
                        <?php
                        $uri = Route::currentRouteName();
                        ?>
						@if($uri == 'rides.list' || $uri == 'rides.month' || $uri == 'rides.week')
						<div class="col-lg-3 col-md-2 col-sm-2 col-2 align-self-center trigger_parent">
							@else
							<div class="col-lg-6 col-md-2 col-sm-2 col-2 align-self-center trigger_parent">
								@endif
                        @if($uri=='users.voucher' || $uri=='voucher.create')
                            <!--<button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='users.voucher' ? 'active' : '') }}" href="{{ route('users.voucher') }}">List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='voucher.create' ? 'active' : '') }}" href="{{ route('voucher.create') }}">Add</a>
                                </li>
                            </ul>-->
                        @endif
                        @if($uri=='users.settings' || $uri=='settings.my_design')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='users.settings' ? 'active' : '') }}" href="{{ route('users.settings') }}">General</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('payment-method.index') }}">Payment Method</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('sms-template.index') }}">SMS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('push-notifications.index') }}">Notification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('promotion.index') }}">Promotion</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='settings.my_design' ? 'active' : '') }}" href="{{ route('settings.my_design') }}">My Design</a>
                                </li>
                            </ul>
                        @endif
                        
                        @if($uri=='vehicle-type.index' || $uri=='vehicle-type.create' || $uri=='vehicle-type.edit' || $uri=='vehicle.index' || $uri=='vehicle.create' || $uri=='vehicle.edit')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='vehicle-type.index' ? 'active' : '') }}" href="{{ route('vehicle-type.index') }}">Car Type</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='vehicle-type.create' ? 'active' : '') }}" href="{{ route('vehicle-type.create') }}">Add Car Type</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='vehicle.index' ? 'active' : '') }}" href="{{ route('vehicle.index') }}">Car Pool</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='vehicle.create' ? 'active' : '') }}" href="{{ route('vehicle.create') }}">Add Car Pool</a>
                                </li>
                            </ul>
                        @endif
                        @if($uri=='drivers.index' || $uri=='drivers.create' || $uri=='drivers.regular' || $uri=='drivers.master' || $uri=='drivers.edit')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='drivers.index' ? 'active' : '') }}" href="{{ route('drivers.index') }}">List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='drivers.regular' ? 'active' : '') }}" href="{{ route('drivers.regular') }}">Regular</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='drivers.master' ? 'active' : '') }}" href="{{ route('drivers.master') }}">Master</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='drivers.create' ? 'active' : '') }}" href="{{ route('drivers.create') }}">Add</a>
                                </li>
                            </ul>
                        @endif

                        @if($uri=='service-provider-manager.index' )
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='service-provider-manager.index' ? 'active' : '') }}" href="{{ route('service-provider-manager.index') }}">Manager</a>
                                </li>
                            </ul>
                        @endif

                        @if($uri=='company.index' || $uri=='company.create' || $uri=='company.edit')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='company.index' ? 'active' : '') }}" href="{{ route('company.index') }}">List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='company.create' ? 'active' : '') }}" href="{{ route('company.create') }}">Add</a>
                                </li>
                            </ul>
                        @endif
                        @if($uri=='payment-method.index' || $uri=='payment-method.create' || $uri=='payment-method.edit')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='payment-method.index' ? 'active' : '') }}" href="{{ route('payment-method.index') }}">List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='payment-method.create' ? 'active' : '') }}" href="{{ route('payment-method.create') }}">Add</a>
                                </li>
                            </ul>
                        @endif
                        @if($uri=='sms-template.index' || $uri=='sms-template.create' || $uri=='sms-template.edit')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='sms-template.index' ? 'active' : '') }}" href="{{ route('sms-template.index') }}">List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='sms-template.create' ? 'active' : '') }}" href="{{ route('sms-template.create') }}">Add</a>
                                </li>
                            </ul>
                        @endif
                        @if($uri=='contact-support.index' || $uri=='contact-support.create')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='contact-support.index' ? 'active' : '') }}" href="{{ route('contact-support.index') }}">List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='contact-support.create' ? 'active' : '') }}" href="{{ route('contact-support.create') }}">Send</a>
                                </li>
                            </ul>
                        @endif
                        @if($uri=='push-notifications.index' || $uri=='push-notifications.create')
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='push-notifications.index' ? 'active' : '') }}" href="{{ route('push-notifications.index') }}">List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ ($uri=='push-notifications.create' ? 'active' : '') }}" href="{{ route('push-notifications.create') }}">Send Request</a>
                                </li>
                            </ul>
                        @endif

						@yield('header_menu_list')
                        
						</div>
						@if($uri == 'rides.list' || $uri == 'rides.month' || $uri == 'rides.week')
						<div class="col-lg-7 col-md-7 col-sm-5 col-5 align-self-center">
						    @else
						    <div class="col-lg-4 col-md-7 col-sm-5 col-5 align-self-center">
						        @endif

                            <div class="right_content_menu">
								
								@yield('header_search_export')

                                <div class="avatar_info_box">
                                    <img src="{{ Auth::user()->image?env('URL_PUBLIC').'/'.Auth::user()->image:asset('assets/images/veldoo/avatar-2.png') }}" class="img-fluid w-100 avatar_img" alt="user image" />
                                    <div class="user_info">
                                        <h4 class="nameOfUser">{{ Auth::user()->name}} </h4>
                                        <p class="userInfo">Admin</p>
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
												<li class="nav-item w-100">
													<a class="nav-link {{ ($uri=='users.dashboard' ? 'active' : '') }}" href="{{ route('users.dashboard') }}">
														<img src="{{ asset('assets/images/veldoo/dashboard.png') }}" class="img-fluid w-100 sidebarImgs" alt="dashboard"/> 
														<span class="sidebarText">Dashboard</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='users.index' ||  $uri=='users.show') ? 'active' : '') }}" href="{{ route('users.index') }}">
														<img src="{{ asset('assets/images/veldoo/users.png') }}" class="img-fluid w-100 sidebarImgs" alt="users"/> 
														<span class="sidebarText">User</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='drivers.index' || $uri=='drivers.create' || $uri=='drivers.edit' || $uri=='drivers.regular' || $uri=='drivers.master') ? 'active' : '') }}" href="{{ route('drivers.index') }}">
														<img src="{{ asset('assets/images/veldoo/users.png') }}" class="img-fluid w-100 sidebarImgs" alt="Driver"/> 
														<span class="sidebarText">Driver</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='company.index' || $uri=='company.create' || $uri=='company.edit') ? 'active' : '') }}" href="{{ route('company.index') }}">
														<img src="{{ asset('assets/images/veldoo/bagplus.png') }}" class="img-fluid w-100 sidebarImgs" alt="Company"/> 
														<span class="sidebarText">Company</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>

                                                <?php 
				
                                                    if(Auth::user()->user_type == 3){ ?>
                                                    <li class="nav-item w-100">
                                                        <a class="nav-link {{ ($uri =='service-provider-manager.index' ? 'active' : '') }}"  href="{{ route('service-provider-manager.index') }}">
                                                            <img src="{{ asset('assets/imgs/users.png') }}" class="img-fluid w-100 sidebarImgs" alt="Manager"/> 
                                                            <span class="sidebarText">Manager</span>
                                                            <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                                        </a>
                                                    </li>
                                                    <?php } ?>

												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='vehicle-type.index' || $uri=='vehicle-type.create' || $uri=='vehicle-type.edit' || $uri=='vehicle.create' || $uri=='vehicle.index' || $uri=='vehicle.edit') ? 'active' : '') }}" href="{{ route('vehicle-type.index') }}">
														<img src="{{ asset('assets/images/veldoo/car.png') }}" class="img-fluid w-100 sidebarImgs" alt="Car"/> 
														<span class="sidebarText">Car</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri == 'rides.list' || $uri == 'rides.month' || $uri == 'rides.week') ? 'active' : '') }}" href="{{ route('rides.list') }}">
														<img src="{{ asset('assets/images/veldoo/riders.png') }}" class="img-fluid w-100 sidebarImgs" alt="Riders"/> 
														<span class="sidebarText">Rides</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
                                                <?php if(Auth::user()->user_type == 3){ ?>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='users.settings' || $uri=='settings.my_design')? 'active' : '') }}" href="{{ route('users.settings') }}">
														<img src="{{ asset('assets/images/veldoo/setting.png') }}" class="img-fluid w-100 sidebarImgs" alt="Settings"/> 
														<span class="sidebarText">Settings</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='users.voucher' || $uri=='voucher.create') ? 'active' : '') }}" href="{{ route('voucher.create') }}">
														<img src="{{ asset('assets/images/veldoo/voucher.png') }}" class="img-fluid w-100 sidebarImgs" alt="Voucher"/> 
														<span class="sidebarText">Vouchers</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
                                                <?php } ?>
												<!--<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='payment-method.index' || $uri=='payment-method.create' || $uri=='payment-method.edit') ? 'active' : '') }}" href="{{ route('payment-method.index') }}">
														<img src="{{ asset('assets/images/veldoo/payment.png') }}" class="img-fluid w-100 sidebarImgs" alt="Payment"/>
														<span class="sidebarText">Payment method</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='sms-template.index' || $uri=='sms-template.create' || $uri=='sms-template.edit') ? 'active' : '') }}" href="{{ route('sms-template.index') }}">
														<img src="{{ asset('assets/images/veldoo/sms.png') }}" class="img-fluid w-100 sidebarImgs" alt="SMS"/> 
														<span class="sidebarText">SMS</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>-->
												<li class="nav-item w-100">
													<a class="nav-link {{ ($uri=='daily-report.vehicle_mileage' ? 'active' : '') }}" href="{{ route('daily-report.vehicle_mileage') }}">
														<img src="{{ asset('assets/images/veldoo/report.png') }}" class="img-fluid w-100 sidebarImgs" alt="Reports"/> 
														<span class="sidebarText">Reports and insight</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='contact-support.index' || $uri=='contact-support.create') ? 'active' : '') }}" href="{{ route('contact-support.index') }}">
														<img src="{{ asset('assets/images/veldoo/contact.png') }}" class="img-fluid w-100 sidebarImgs" alt="contact"/> 
														<span class="sidebarText">Contact Support</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
												<!--<li class="nav-item w-100">
													<a class="nav-link {{ (($uri=='push-notifications.index' || $uri=='push-notifications.create') ? 'active' : '') }}" href="{{ route('push-notifications.index') }}">
														<img src="{{ asset('assets/images/veldoo/push.png') }}" class="img-fluid w-100 sidebarImgs" alt="Push"/> 
														<span class="sidebarText">Push Notification</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>-->
												<li class="nav-item w-100">
													<a class="nav-link" href="{{ route('sp_logout') }}">
														<img src="{{ asset('assets/images/veldoo/log-out.png') }}" class="img-fluid w-100 sidebarImgs" alt="Logout"/> 
														<span class="sidebarText">Logout</span>
														<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
													</a>
												</li>
											</ul>
										</article>
									</section>
								</div>

                                @yield('content')
                                <!-- Form Table -->
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

    <!-- Timer JS -->
    <script src="https://cdn.jsdelivr.net/npm/timepicker@1.14.1/jquery.timepicker.min.js"></script>
    
    <script defer src='https://static.cloudflareinsights.com/beacon.min.js'></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    @if($uri =='service-provider-manager.index')
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
     @else
     <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    @endif
    @yield('footer_scripts')
</body>

</html>
