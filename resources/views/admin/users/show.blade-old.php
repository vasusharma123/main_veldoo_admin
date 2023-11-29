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
										<td>{{ $record->first_name }} {{ $record->last_name }}</td>
									</tr>--->
									<tr>
										<td><strong>{{trans('admin.Image')}}</strong></td>
										<td>
											<?php echo Html::image(((!empty($record->image)) ? (config('app.url_public').'/'.$record->image) : asset('no-images.png')), 'sidebar logo', ['id' => 'previewimage', 'width' => '50', 'height' => '50']); ?>
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Email')}}</strong></td>
										<td>{{ $record->email }}</td>
									{{-- </tr>
									<tr>
										<td><strong>{{trans('admin.First Name')}}</strong></td>
										<td>{{ $record->first_name }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Last Name')}}</strong></td>
										<td>{{ $record->last_name }}</td>
									</tr> --}}
									<tr>
										<td><strong>{{trans('admin.Name')}}</strong></td>
										<td>{{ $record->first_name.' '.$record->last_name }}</td>
									</tr>
									{{-- <tr>
										<td><strong>{{trans('admin.Phone')}}</strong></td>
										<td>{{ $record->phone }}</td>
									</tr> --}}
									<tr>
										<td><strong>{{trans('admin.Phone')}}</strong></td>
										<td>{{ $record->country_code.'-'.$record->phone }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Alternate Phone No')}}</strong></td>
										<td>{{ $record->second_country_code.'-'.$record->second_phone_number }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.City')}}</strong></td>
										<td>{{ $record->city }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.State')}}</strong></td>
										<td>{{ $record->state }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Street')}}</strong></td>
										<td>{{ $record->street }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Zip')}}</strong></td>
										<td>{{ $record->zip }}</td>
									</tr>
									<!--<tr>
										<td><strong>{{trans('admin.Gender')}}</strong></td>
										<td>{{ ($record->gender==1 ? 'Male' : 'Female') }}</td>
									</tr>-->
									<!--<tr>
										<td><strong>{{trans('admin.DOB')}}</strong></td>
										<td>{{ ($record->dob) }}</td>
									</tr>-->
									{{-- <tr>
										<td><strong>{{trans('admin.Status')}}</strong></td>
										<td>{{ ($status[$record->status] ? $status[$record->status] : 'N/A' ) }}</td>
									</tr> --}}
									{{-- <tr>
										<td><strong>{{trans('admin.Created at')}}</strong></td>
										<td>{{ $record->created_at }}</td>
									</tr> --}}
									{{-- <tr>
										<td><strong>{{trans('admin.IP Address')}}</strong></td>
										<td>{{(!empty($record->log->other) ? json_decode($record->log->other)[0]->ip_address : 'N/A')}}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Updated at')}}</strong></td>
										<td>{{ $record->updated_at }}</td>
									</tr> --}}
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