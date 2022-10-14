<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="row page-titles">
	<div class="col-md-12 align-self-center">
		<h3 class="text-themecolor">
		@if(!empty($title))
			{{ $title }}
		@endif
		</h3>
	</div>
	{{-- <div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			@if(!empty($title))
				<li class="breadcrumb-item"><a href="javascript:void(0)">{{ $title }}</a></li>
			@endif
			@if(!empty($action))
				<li class="breadcrumb-item active">{{ $action }}</li>
			@endif
		</ol>
	</div> --}}
</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->