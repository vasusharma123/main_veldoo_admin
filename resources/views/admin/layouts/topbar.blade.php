<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
	<nav class="navbar top-navbar navbar-expand-md navbar-light">
		<!-- ============================================================== -->
		<!-- Logo -->
		<!-- ============================================================== -->
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ route('users.dashboard') }}">
				<!-- Logo icon -->
				<b>
					<!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
					<!-- Dark Logo icon -->
					@if(!empty($setting['admin_logo']) && file_exists('storage/'.$setting['admin_logo']))
						<img src="{{ env('URL_PUBLIC').'/'.$setting['admin_logo'] }}" alt="user" alt="homepage" class="dark-logo" width="40" height="40" /> 
					@else
						<img src="{{ asset('/assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
					@endif
				</b>
				<!--End Logo icon -->
				<!-- Logo text -->
				<span>
					<!-- dark Logo text -->
					@if(!empty($setting['admin_sidebar_logo']) && file_exists('public/storage/'.$setting['admin_sidebar_logo']))
						<img src="{{ config('app.url_public').'/'.$setting['admin_sidebar_logo'] }}" alt="user" alt="homepage" class="dark-logo" width="128" height="19" /> 
					@else
						<img src="{{ asset('/assets/images/logo-text.png')}}" alt="homepage" class="dark-logo" />
					@endif
				</span>
			</a>
		</div>
		<!-- ============================================================== -->
		<!-- End Logo -->
		<!-- ============================================================== -->
		<div class="navbar-collapse">
			<!-- ============================================================== -->
			<!-- toggle and nav items -->
			<!-- ============================================================== -->
			<ul class="navbar-nav mr-auto mt-md-0">
				<li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
				<li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
			</ul>
			<!-- ============================================================== -->
			<!-- User profile and search -->
			<!-- ============================================================== -->
			<ul class="navbar-nav my-lg-0">
				<!-- Profile -->
				<!-- ============================================================== -->
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						
						@if(!empty($currentUser['image']) && file_exists('storage/'.$currentUser['image']))
							<img src="{{ env('URL_PUBLIC').'/'.$currentUser['image'] }}" class="profile-pic" /> 
						@else
							<img src="{{ asset('/assets/images/users/1.jpg')}}" alt="user" class="profile-pic" />
						@endif
					</a>
					<div class="dropdown-menu dropdown-menu-right scale-up">
						<ul class="dropdown-user">
							<li>
								<div class="dw-user-box">
									<div class="u-img">
										
										@if(!empty($currentUser['image']) && file_exists('storage/app/public/'.$currentUser['image']))
											<img src="{{ config('app.url_public').'/'.$currentUser['image'] }}" alt="user" /> 
										@else
											<img src="{{ asset('/assets/images/users/1.jpg')}}" alt="user">
										@endif
									</div>
									<div class="u-text">
										<h4>{{$currentUser['first_name'].' '.$currentUser['last_name']}}</h4>
										<p class="text-muted">{{$currentUser['email']}}</p>
									</div>
								</div>
							</li>
							<li role="separator" class="divider"></li>
							<li><a href="{{ route('users.profile') }}"><i class="ti-user"></i> My Profile</a></li>
							<li><a href="{{ route('users.settings') }}"><i class="ti-settings"></i> Setting</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="{{url('admin/logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
						</ul>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->