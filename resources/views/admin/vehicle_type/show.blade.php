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
										<td><strong>{{trans('admin.Car Image')}}</strong></td>
										<td>
											<a href="{{url('storage/'.$record->car_image)}}" target="_blank"><img src="{{url('storage/'.$record->car_image)}}" width="100px" height=80px"></a>
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Car Type')}}</strong></td>
										<td>
											{{$record->car_type}}
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Price Per KM')}}</strong></td>
										<td>{{ $record->price_per_km }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Basic Fee')}}</strong></td>
										<td>{{ $record->basic_fee }}</td>
									</tr>
									
									<tr>
										<td><strong>{{trans('admin.Seating Capacity')}}</strong></td>
										<td>{{ $record->seating_capacity }}</td>
									</tr>
									
									
								</table>
								<div class="form-actions">
									<a href="{{url('admin/vehicle-type')}}" class="btn btn-inverse">{{trans('admin.Back')}}</a>
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