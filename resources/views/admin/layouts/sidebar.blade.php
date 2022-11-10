<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
	<!-- Sidebar scroll-->
	<div class="scroll-sidebar">
		<!-- User profile -->
		<div class="user-profile">
			<!-- User profile image -->
			<div class="profile-img"> 
					@if(file_exists('storage/app/public/'.$currentUser['image']))
						<img src="{{ config('app.url_public').'/'.$currentUser['image'] }}" alt="user" /> 
					@else
						<img src="{{ URL::asset('resources') }}/assets/images/users/profile.png" alt="user" class="" />
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
				<li class="nav-small-cap">{{ trans("api.Admin") }}</li>
				<li> 
					<a class="waves-effect waves-dark" href="{{ route('users.dashboard') }}" aria-expanded="false">
						<i class="mdi mdi-gauge"></i><span class="hide-menu">{{ trans("admin.Dashboard") }}</span>
					</a>
				</li>
				 @if(Auth::user()->hasRole(['Administrator']))
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.User Account Management") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('users.index') }}">{{ trans("admin.List") }}</a></li>
					</ul>
				</li>
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Driver Account Management") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('admin/driver/create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('users.drivers') }}">{{ trans("admin.List") }}</a></li>
					</ul>
				</li>
				
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Company Account Management") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('company.create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('company.index') }}">{{ trans("admin.List") }}</a></li>
					</ul>
				</li>
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Vehicle Type Management")}}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('vehicle-type.create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('vehicle-type.index') }}">{{ trans("admin.List") }}</a></li>
				
					</ul>
				</li>
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Vehicle Management") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('vehicle.create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('vehicle.index') }}">{{ trans("admin.List") }}</a></li>
				
					</ul>
				</li>
				<li> 
					<a class="waves-effect waves-dark" href="{{url('admin/rides')}}" aria-expanded="false">
						<i class="mdi mdi-car-connected"></i>
						<span class="hide-menu">{{ trans("Rides") }}</span>
					</a>
					
				</li>
				<!--<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Category") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('category.create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('category.index') }}">{{ trans("admin.List") }}</a></li>
				
					</ul>
				</li>-->
			<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Payment Method") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('payment-method.create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('payment-method.index') }}">{{ trans("admin.List") }}</a></li>
					</ul>
				</li>
				<li> 
					<a class="waves-effect waves-dark" href="{{url('admin/users/settings')}}" aria-expanded="false">
						<i class="mdi mdi-settings"></i>
						<span class="hide-menu">{{ trans("admin.Settings") }}</span>
					</a>
					
				</li>
				
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Manage Bookings") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('bookings.index') }}">{{ trans("admin.Trip Management") }}</a></li>
						<li><a href="{{ url('admin/scheduled-rides') }}">{{ trans("admin.Manage Scheduled Ride") }}</a></li>
					</ul>
				</li>

				
				
			
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Reports And Insights") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						{{-- <li><a href="{{ route('daily-report.index') }}">{{ trans("admin.Daily Report") }}</a></li>
						<li><a href="{{ route('daily-report.vehicles') }}">Vehicle Reports</a></li> --}}
						<li><a href="{{ route('daily-report.vehicle_mileage') }}">Vehicles Mileage Report</a></li>
					</ul>
				</li>
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Contact Support") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{route('contact-support.create')}}">{{ trans("admin.Send Email") }}</a></li>
					</ul>
				</li>
				<!--<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Complaint Management") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('admin/complaints') }}">{{ trans("admin.Complaint List") }}</a></li>
					</ul>
				</li>-->
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Push Notifications") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{route('notifications.create')}}">{{ trans("admin.Send Notification") }}</a></li>
						<li><a href="{{url('admin/promotional-offer')}}">{{ trans("admin.Send Promotional Offer") }}</a></li>
					</ul>
				</li>
			
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Manage Content") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('page.about') }}">{{ trans("admin.About Us") }}</a></li>
						<li><a href="{{ route('page.policy') }}">{{ trans("admin.Privacy Policy") }}</a></li>
						<li><a href="{{ route('page.terms') }}">{{ trans("admin.Terms & Conditions") }}</a></li>
					</ul>
				</li>
				
				
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="{{url('admin/users/vouchers')}}" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Voucher") }}</span>
					</a>
					
				</li>
				
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Promotions") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('promotion.create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('promotion.index') }}">{{ trans("admin.List") }}</a></li>
						
					</ul>
				</li>

				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript::void(0);" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">Expenses</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('expenses.type_list') }}">Types</a></li>
						<li><a href="{{ route('expenses.list') }}">List</a></li>
						<li><a href="{{ route('daily-report.expenses') }}">Expenses Report</a></li>
					</ul>
				</li>
				
				@endif
				@if(Auth::user()->hasRole(['Company']))
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="{{ url('admin/task-management') }}" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Task Management") }}</span>
					</a>
				</li>
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.User Account Management") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ route('users.create') }}">{{ trans("admin.Add") }}</a></li>
						<li><a href="{{ route('users.index') }}">{{ trans("admin.List") }}</a></li>
					</ul>
				</li>
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Booking History") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('admin/current-bookings') }}">{{ trans("admin.Current Trips") }}</a></li>
						<li><a href="{{ url('admin/past-bookings') }}">{{ trans("admin.Past Trips") }}</a></li>
						<li><a href="{{ url('admin/upcoming-bookings') }}">{{ trans("admin.Upcoming Trips") }}</a></li>
					</ul>
				</li>
				<!---<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Book Ride") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('admin/book-ride') }}">{{ trans("admin.create Ride") }}</a></li>
					</ul>
				</li>---->
				
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Push Notifications") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('admin/notifications') }}">{{ trans("admin.Notifications") }}</a></li>
					</ul>
				</li>
				
				<li> 
					<a class="has-arrow waves-effect waves-dark" href="javascript:;" aria-expanded="false">
						<i class="mdi mdi-arrange-send-backward"></i>
						<span class="hide-menu">{{ trans("admin.Admin Contact") }}</span>
					</a>
					<ul aria-expanded="false" class="collapse">
						<li><a href="{{ url('admin/admin-contact') }}">{{ trans("admin.Contact") }}</a></li>
					</ul>
				</li>
				@endif
			</ul>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->