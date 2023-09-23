@extends('frontend.layouts.master')
@section('content')

		<!-- Container fluid  -->
		<!-- ============================================================== -->
		<div class="container-fluid">
			<!-- ============================================================== -->
			<!-- Start Page Content -->
			<!-- ============================================================== -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							@if(!empty($record['title']))
								<h4 class="card-title" id="1">{{ $record['title'] }}</h4>
							@endif
							@if(!empty($record['content']))
								{!! $record['content'] !!}
							@endif
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- End PAge Content -->
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- End Container fluid  -->
@endsection

@section('footer_scripts')

@stop