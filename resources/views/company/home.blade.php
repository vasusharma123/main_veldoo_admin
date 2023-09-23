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
							
							{{ Form::open(array('url' => url('admin/ride-create'),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-4">
										<div class="col-md-8">
										<div class="form-group">
												<?php
												echo Form::label('ride_type', 'User Type',['class'=>'control-label']);
											?>
												<select name="ride_type" id="ride_type" class="form-control">
												<option value="1">Ride Schedule</option>
												<option value="2">Ride Now</option>
												<option value="3">Instant Ride</option>
												<option value="4">Ride Sharing</option>
												</select>
											</div>
											
											<div class="form-group">
												<?php
												echo Form::label('driver', 'Driver',['class'=>'control-label']);
												?>
												<select name="driver" class="form-control">
												<option value="">Select Driver</option>
												@foreach($drivers as $driver)
												<option value="{{$driver->id}}">{{$driver->first_name}} {{$driver->last_name}}</option>
												@endforeach
												</select>
											</div>
											
											<div class="form-group">
												<?php
												echo Form::label('customer', 'Customer',['class'=>'control-label']);
												?>
												<select name="customer" class="form-control">
												<option value="">Select Customer</option>
												@foreach($customers as $customer)
												<option value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</option>
												@endforeach
												</select>
											</div>
											
											<div class="form-group">
												<?php
												echo Form::label('company', 'Company',['class'=>'control-label']);
												?>
												<select name="company" class="form-control">
												<option value="">Select Company</option>
												@foreach($companies as $company)
												<option value="{{$company->id}}">{{$company->first_name}} {{$company->last_name}}</option>
												@endforeach
												</select>
											</div>
											
											<div class="form-group">
												<?php
												echo Form::label('message', 'Pickup Address',['class'=>'control-label']);
												echo Form::text('pickup_address',null,['class'=>'form-control','required'=>true,'id'=>'pickup_address']);
												?>
											</div>
										
											<div class="form-group">
												<?php
												echo Form::label('message', 'Destination Address',['class'=>'control-label']);
												echo Form::text('dest_address',null,['class'=>'form-control','required'=>true,'id'=>'dest_address']);
												?>
											</div>
											
											<div class="form-group">
												<?php
												echo Form::label('schedule_time', 'Schedule Time',['class'=>'control-label']);
												echo Form::text('schedule_time',null,['class'=>'form-control','required'=>true,'id'=>'schedule_time']);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('additional_notes', 'Additional Note',['class'=>'control-label']);
												echo Form::text('additional_notes',null,['class'=>'form-control ckeditor','required'=>true,'style'=>'width:99.8%;']);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('payment_by', 'Payment Type',['class'=>'control-label']);
												?>
												<select name="payment_by" class="form-control">
												<option value="">Select Payment By</option>
												<option value="1">Customer</option>
												<option value="2">Company</option>
												</select>
											</div>
											
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
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
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script> 

<script>
    $(function () {
        $('#schedule_time').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD HH:mm'
        });
    });
</script>
</script>

<script type="text/javascript">
	$(document).ready(function () {
		$('#store').validate();
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
	/*
	$("#user").select2({
  templateResult: formatState
});
function formatState (state) {
  $.ajax({  
 url:"{{url('admin/get_users')}}",
type: 'GET',  
  success: function(data) {  
    $.each(data,function(key,value){
		          $("#user").append('<option value="'+value.id+'">'+value.first_name+'</option>');
		        });             
  }  
});  
};*/
function initialize() {
  var input = document.getElementById('dest_address');
  new google.maps.places.Autocomplete(input);
}

google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
  var input = document.getElementById('pickup_address');
  new google.maps.places.Autocomplete(input);
}

google.maps.event.addDomListener(window, 'load', initialize);

	</script>
@stop