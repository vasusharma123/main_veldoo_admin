@include('admin.layouts.head')
@include('admin.layouts.header1')
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
	<div class="container h-100">
		<div class="mx-auto row justify-content-center">
			<div class="col-md-6 mt-5">
				<div class="card card-outline-success">
						<div class="card-header">
							<h4 class="m-b-0 text-white">Message</h4>
						</div>
						<div class="card-body">
							@include('admin.layouts.flash-message')
							{{ csrf_field() }}
						</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ============================================================== -->
<!-- End Wrapper -->
@include('admin.layouts.footer1')