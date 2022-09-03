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
										<td><strong>User Name</strong></td>
										<td>{{$record->user?$record->user->first_name:'Not Available'}} {{$record->user?$record->user->last_name:''}}</td>
									</tr>
									<tr>
										<td><strong>Driver Name</strong></td>
										<td>{{$record->driver?$record->driver->first_name:'Not Available'}} {{$record->driver?$record->driver->last_name:''}}</td>
									</tr>
									<tr>
										<td><strong>Pickup Location</strong></td>
										<td>{{$record->pickup_address?$record->pickup_address:'Not Available'}}</td>
									</tr>
									<tr>
										<td><strong>Dropoff Location</strong></td>
										<td>{{$record->dest_address?$record->dest_address:'Not Available'}}</td>
									</tr>
									<tr>
										<td><strong>Price</strong></td>
										<td>{{$record->ride_cost?$record->ride_cost:'Not Available'}}</td>
									</tr>
										<tr>
										<td><strong>Distance</strong></td>
										<td>{{$record->distance?$record->distance:'Not Available'}}</td>
									</tr>
									<tr>
										<td><strong>Payment Type</strong></td>
										<td>{{$record->payment_type?$record->payment_type:"Not Availabl"}}
										</td>
									</tr>
									<tr>
										<td><strong>Ride Type</strong></td>
										<td>
										@if($record->ride_type==1)
											Ride Schedule
										@elseif($record->ride_type==2)
											Ride Now
										@elseif($record->ride_type==3)
											Instant Ride
										@elseif($record->ride_type==4)
											Ride Sharing
										@endif
										</td>
									</tr>
									<tr>
										<td><strong>Number of Passenger</strong></td>
										<td>{{$record->passanger?$record->passanger:'Not Available'}}</td>
									</tr>
									<tr>
										<td><strong>Car Type</strong></td>
										<td>{{$record->car_type?$record->car_type:'Not Available'}}</td>
									</tr>
									<tr>
										<td><strong>Ride Time</strong></td>
										<td>{{$record->ride_time?$record->ride_time:'Not Available'}}</td>
									</tr>
									<tr>
										<td><strong>Alert Time</strong></td>
										<td>{{$record->alert_time?$record->alert_time:'Not Available'}}</td>
									</tr>
									<tr>
										<td><strong>Note</strong></td>
										<td>{{$record->additional_notes?$record->additional_notes:''}}</td>
									</tr>
									<tr>
										<td><strong>Status</strong></td>
										<td>
										@if($record->status==-2)
										Cancelled
										@elseif($record->status==3)
										Completed
										@elseif($record->status==0)
										Pending
										@elseif($record->ride_time > date('Y-m-d H:i:s'))
											Upcoming
										@endif
									</td>
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
									<a href="{{url('admin/past-bookings')}}" class="btn btn-inverse">Back</a>
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