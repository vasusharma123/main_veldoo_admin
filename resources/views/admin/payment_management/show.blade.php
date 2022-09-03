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
									<!--<tr>
										<td><strong>{{trans('admin.User Name')}}</strong></td>
										<td>{{ $record->user_name }}</td>
									</tr>--->
									<tr>
										<td><strong>{{trans('admin.Email')}}</strong></td>
										<td>{{ $record->email }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.First Name')}}</strong></td>
										<td>{{ $record->first_name }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Last Name')}}</strong></td>
										<td>{{ $record->last_name }}</td>
									</tr>
									<!--<tr>
										<td><strong>{{trans('admin.Gender')}}</strong></td>
										<td>{{ ($record->gender==1 ? 'Male' : 'Female') }}</td>
									</tr>
									<!--<tr>
										<td><strong>{{trans('admin.DOB')}}</strong></td>
										<td>{{ ($record->dob) }}</td>
									</tr>--->
									<tr>
										<td><strong>{{trans('admin.Primary Location')}}</strong></td>
										<td>
											<?php echo ($record->lat && $record->lng ? '<a target="_blank" href="https://maps.google.com/?q='.$record->lat.','.$record->lng.'">'.$record->location : 'N/A'); ?>
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Secondary Location')}}</strong></td>
										<td>
											<?php echo ($record->lat_2 && $record->lng_2 ? '<a target="_blank" href="https://maps.google.com/?q='.$record->lat_2.','.$record->lng_2.'">'.$record->location_2 : 'N/A'); ?>
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Status')}}</strong></td>
										<td>{{ ($status[$record->status] ? $status[$record->status] : 'N/A' ) }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Created at')}}</strong></td>
										<td>{{ $record->created_at }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.IP Address')}}</strong></td>
										<td>{{(!empty($record->log->other) ? json_decode($record->log->other)[0]->ip_address : 'N/A')}}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Updated at')}}</strong></td>
										<td>{{ $record->updated_at }}</td>
									</tr>
								</table>
								<div class="form-actions">
									<a href="{{route( $route.'.index')}}" class="btn btn-inverse">{{trans('admin.Back')}}</a>
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