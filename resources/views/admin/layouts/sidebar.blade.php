<div class="sidebarFlow">
	<i class="bi bi-chevron-right sidebarToggler"></i>
	<section class="sidebar">
		<i class="bi bi-x-lg sidebarToggler">&nbsp; <span>Close</span></i>
		<article class="all_sidebar_box">
			<ul class="nav sidebarLists w-100">
				<?php
				$uri = Route::currentRouteName();
				?>
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
				<li class="nav-item w-100">
					<a class="nav-link {{ (($uri=='vehicle-type.index' || $uri=='vehicle-type.create' || $uri=='vehicle-type.edit' || $uri=='vehicle.create' || $uri=='vehicle.index' || $uri=='vehicle.edit') ? 'active' : '') }}" href="{{ route('vehicle-type.index') }}">
						<img src="{{ asset('assets/images/veldoo/car.png') }}" class="img-fluid w-100 sidebarImgs" alt="Car"/> 
						<span class="sidebarText">Car</span>
						<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
					</a>
				</li>
				<li class="nav-item w-100">
					<a class="nav-link {{ (($uri=='rides.index' || $uri=='rides.show') ? 'active' : '') }}" href="{{ route('rides.index') }}">
						<img src="{{ asset('assets/images/veldoo/riders.png') }}" class="img-fluid w-100 sidebarImgs" alt="Riders"/> 
						<span class="sidebarText">Rides</span>
						<i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
					</a>
				</li>
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