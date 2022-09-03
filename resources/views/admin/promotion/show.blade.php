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
						<div class="col-md-8">
							<div class="table-responsive">
								<table class="table table-bordered">
									
									<tr>
										<td><strong>{{trans('admin.First Name')}}</strong></td>
										<td>{{ $record->user?$record->user->first_name:'' }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Last Name')}}</strong></td>
										<td>{{ $record->user?$record->user->last_name:'' }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Title')}}</strong></td>
										<td>{{ $record->title }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Message')}}</strong></td>
										<td>{{ $record->message }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Mileage')}}</strong></td>
										<td>{{ $record->mileage }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Start Date')}}</strong></td>
										<td>{{ $record->start_date }}</td>
									</tr>
									
									<tr>
										<td><strong>{{trans('admin.End Date')}}</strong></td>
										<td>{{ $record->end_date }}</td>
									</tr>
								</table>
								<div class="form-actions">
									<a href="{{ route('vouchers-offers.index') }}" class="btn btn-inverse">{{trans('admin.Back')}}</a>
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