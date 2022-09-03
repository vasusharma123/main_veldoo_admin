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
										<td><strong>{{trans('admin.Car Type')}}</strong></td>
										<td>{{ $record->carType?$record->carType->car_type:'' }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Year')}}</strong></td>
										<td>{{$record->year}}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Model')}}</strong></td>
										<td>{{$record->model}}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Color')}}</strong></td>
										<td>{{ $record->color}}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Vehicle Image')}}</strong></td>
										<td>
										@if(!empty($record->vehicle_image))
											<img src="{{$record->vehicle_image}}" height="50px" width="80px">
											@else
											<img src="{{url('public/no-images.png')}}" height="50px" width="80px">	
										@endif
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Vehicle Numner Plate')}}</strong></td>
										<td>
										<strong>{{($record->vehicle_number_plate)?strtoupper($record->vehicle_number_plate):''}}</strong>
										</td>
									</tr>
								@php if(!empty($carDriver)){ @endphp
								@php if(!empty($driverDetails)){ @endphp	
									<tr>
										<td colspan="2" class="text-center"><strong>This driver is using the car</strong></td>
									</tr>
									<tr>
										<td><strong>Name</strong></td>
										<td>
										<strong>{{ ucwords($driverDetails->first_name.' '.$driverDetails->last_name)}}</strong>
										</td>
									</tr>
									<tr>
										<td><strong>Phone</strong></td>
										<td>
										<strong>{{$driverDetails->phone}}</strong>
										</td>
									</tr>
								  @php } } @endphp	
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