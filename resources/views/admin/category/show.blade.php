@extends('admin.layouts.master')

@section('content')
	<!-- Container fluid  -->
	<!-- ============================================================== -->
	<div class="container-fluid">
		<!-- ============================================================== -->
		<!-- Start Page Content -->
		<!-- ============================================================== -->
		<div class="row">
			<div class="col-lg-12">
				<div class="card card-outline-info" >
				
					<div class="card-header">
						@if(!empty($action))
							<h4 class="m-b-0 text-white">{{ $action }}</h4>
						@endif
					</div>
					<div class="card-body">
						@include('admin.layouts.flash-message')
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><strong>Name</strong></td>
										<td>{{ $record->name }}</td>
									</tr>
									<tr>
										<td><strong>Status</strong></td>
										<td>{{ ($status[$record->status] ? $status[$record->status] : 'N/A' ) }}</td>
									</tr>
									<tr>
										<td><strong>Created at</strong></td>
										<td>{{ $record->created_at }}</td>
									</tr>
									<tr>
										<td><strong>Updated at</strong></td>
										<td>{{ $record->updated_at }}</td>
									</tr>
								</table>
								<div class="form-actions">
									<a href="{{route( $route.'.index')}}" class="btn btn-inverse">Back</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
	</div>
@endsection	
	<!-- ============================================================== -->
	<!-- End Container fluid  -->
@section('footer_scripts')

@stop