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
					<div class="card card-outline-info">
						<div class="card-header">
							@if(!empty($action))
								<h4 class="m-b-0 text-white">{{ $action }}</h4>
							@endif
						</div>
						<div class="card-body">
							@include('admin.layouts.flash-message')
							
							{{ Form::open(array('url' => route('admin-control.store'),'class'=>'form-horizontal form-material','id'=>'adminControlCreate','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
										
											<div class="form-group">
												<?php
												echo Form::label('driver_cancel_time', 'Driver Cancel Time',['class'=>'control-label']);
											?>
												<input type="number" name="driver_cancel_time" id="driver_cancel_time" class="form-control" value="{{$record->driver_cancel_time?$record->driver_cancel_time:''}}">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('max_rides_cancelled', 'Max Ride Cancelled',['class'=>'control-label']);
											?>
												<input type="number" name="max_rides_cancelled" id="max_rides_cancelled" class="form-control" value="{{$record?$record->max_rides_cancelled:''}}">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('emergency_contact', 'Emergency Contact',['class'=>'control-label']);
											?>
												<input type="text" name="emergency_contact" id="emergency_contact" class="form-control" value="{{$record?$record->emergency_contact:''}}">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('minimum_price_per_km', 'Minimum Price Per Kilometer',['class'=>'control-label']);
											?>
												<input type="number" name="minimum_price_per_km" id="minimum_price_per_km" class="form-control" value="{{$record?$record->minimum_price_per_km:''}}">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('rush_hours_price', 'Rush Hours Price',['class'=>'control-label']);
											?>
												<input type="number" name="rush_hours_price" id="rush_hours_price" class="form-control" value="{{$record?$record->rush_hours_price:''}}">
											</div>
											
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
								</div>
							 {{ Form::close() }}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>   
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>  
<script type="text/javascript">
	$(document).ready(function () {
		$('#paymentManagementCreate').validate();
	});
	function readURL(input){
		 if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#previewimage').attr('src', e.target.result);
				$('#previewimage').attr('height','50px');
				$('#previewimage').attr('width','50px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	</script>
@stop