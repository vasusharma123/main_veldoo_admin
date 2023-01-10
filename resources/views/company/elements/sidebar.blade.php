<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">
		<!-- User profile -->
		<div class="user-profile">
			<!-- User profile image -->
			<div class="profile-img"> 
					@if(file_exists('storage/'.$currentUser['image']))
						<img src="{{ config('app.url_public').'/'.$currentUser['image'] }}" alt="user" /> 
					@else
						<img src="{{ asset('assets/images/users/profile.png')}}" alt="user" class="" />
					@endif
					 <!-- this is blinking heartbit-->
					<div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
			</div>
			<!-- User profile text-->
			<div class="profile-text"> 
					<h5>{{ $currentUser['name'] }}</h5>
			</div>
		</div>
		<!-- End User profile text-->
		<!-- Sidebar navigation-->
		<nav class="sidebar-nav">
			<ul id="sidebarnav">
				<li class="nav-devider"></li>
				{{-- <li class="nav-small-cap">{{ trans("api.Admin") }}</li> --}}
				<li> 
					<a class="waves-effect waves-dark" href="{{ route('users.dashboard') }}" aria-expanded="false">
						<i class="mdi mdi-gauge"></i><span class="hide-menu">{{ trans("admin.Dashboard") }}</span>
					</a>
				</li>
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ __("Managers") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('managers.create') }}">{{ __("Add") }}</a></li>
						<li><a href="{{ route('managers.index') }}">{{ __("Listing") }}</a></li>
					</ul>
				</li>
				<li> 
					<a class="waves-effect waves-dark" href="{{ route('company.rides') }}" aria-expanded="false">
						<i class="mdi mdi-car-connected"></i>
						<span class="hide-menu">{{ __('Rides') }}</span>
					</a>
				</li>
				<li> 
					<a class="waves-effect waves-dark" href="{{ route('company.settings') }}" aria-expanded="false">
						<i class="mdi mdi-settings"></i>
						<span class="hide-menu">{{ __('Settings') }}</span>
					</a>
				</li>
			</ul>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->