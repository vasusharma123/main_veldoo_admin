<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
	<nav class="navbar top-navbar navbar-expand-md navbar-light">
		<!-- ============================================================== -->
		<!-- Logo -->
		<!-- ============================================================== -->
		<div class="navbar-header">
			<a class="navbar-brand" href="{{ url('') }}">
				<!-- Logo icon -->
				<b>
					<!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
					<!-- Dark Logo icon -->
					@if(!empty($currentUser['admin_logo']) && file_exists($currentUser['admin_logo']))
						<img src="{{ URL::asset($currentUser['admin_logo']) }}" alt="user" alt="homepage" class="dark-logo" width="40" height="40" /> 
					@else
						<img src="{{ URL::asset('resources') }}/assets/images/logo-icon.png" alt="homepage" class="dark-logo" />
					@endif
				</b>
				<!--End Logo icon -->
			</a>
		</div>
	</nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->