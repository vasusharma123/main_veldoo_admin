<header class="main_header">
	<section class="menu_top">
		<article class="container-fluid">
			<div class="row">
				<div class="col-lg-2 col-md-3 col-sm-5 col-5 align-self-center">
					<div class="logo_box">
						<img src="{{ asset('assets/images/veldoo/brand_logo.png') }}" class="img-fluid w-100 brnd_img" alt="Brnad Name Veldoo" />
					</div>
				</div>
				<?php
				$uri = Route::currentRouteName();
				?>
				<div class="col-lg-5 col-md-2 col-sm-2 col-2 align-self-center trigger_parent">
				@if($uri=='users.voucher' || $uri=='voucher.create')
					<button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
					<ul class="nav top_tab_menu target">
						<li class="nav-item">
							<a class="nav-link {{ ($uri=='users.voucher' ? 'active' : '') }}" href="{{ route('users.voucher') }}">List</a>
						</li>
						<li class="nav-item">
							<a class="nav-link {{ ($uri=='voucher.create' ? 'active' : '') }}" href="{{ route('voucher.create') }}">Add</a>
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
							<a class="nav-link {{ ($uri=='contact-support.create' ? 'active' : '') }}" href="{{ route('contact-support.create') }}">Add</a>
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
				</div>
				<div class="col-lg-5 col-md-7 col-sm-5 col-5 align-self-center">
					<div class="right_content_menu">
						<div class="search">
							<form class="search_form">
								<div class="form-group searchinput position-relative trigger_parent">
									<input type="text" name="data[q]" class="form-control input_search target myInput" placeholder="Search"/>
									<i class="bi bi-search search_icons"></i>
								</div>
							</form>
						</div>
						<div class="export_box">
							<a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
						</div>
						<div class="avatar_info_box">
							<img src="{{ asset('assets/images/veldoo/avatar-2.png') }}" class="img-fluid w-100 avatar_img" alt="user image" />
							<div class="user_info">
								<h4 class="nameOfUser">Jameson</h4>
								<p class="userInfo">Admin</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</article>
	</section>
</header>