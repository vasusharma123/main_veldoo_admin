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
							
							{{ Form::open(array('url' =>'admin/payment-setting-store','class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-4">
										<div class="col-md-8">
											<!--<div class="form-group">
												<?php
												echo Form::label('paypal_email',trans('admin.Paypal Email'),['class'=>'control-label']);
												?>
												<input type="text" name="paypal_email" class="form-control" required value="">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('admin_commission', trans('admin.Admin Commission(%)'),['class'=>'control-label']);
												?>
												<input type="number" name="admin_commission" class="form-control" required value="">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('base_delivery_price', trans('admin.Base Delivery Price'),['class'=>'control-label']);
												?>
												<input type="number" name="base_delivery_price" class="form-control" required value="">
											</div>	
											<div class="form-group">
												<?php
												echo Form::label('base_delivery_distance', trans('admin.Base Delivery Distance'),['class'=>'control-label']);
												?>
												<input type="number" name="base_delivery_distance" class="form-control" required value="">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('tax', trans('admin.Tax(%)'),['class'=>'control-label']);
												?>
												<input type="number" name="tax" class="form-control" required value="">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('credit_card_fee', trans('admin.Credit Card Fee(%)'),['class'=>'control-label']);
												?>
												<input type="number" name="credit_card_fee" class="form-control" required value="">
											</div>	
											<div class="form-group">
												<?php
												echo Form::label('stripe_mode', trans('admin.Stripe Mode'),['class'=>'control-label']);
												?>
												<input type="text" name="stripe_mode" class="form-control" required value="">
											</div>	-->
											<div class="form-group">
												<?php
												echo Form::label('stripe_test_secret_key', trans('admin.Stripe Test Secret Key'),['class'=>'control-label']);
												?>
												<input type="text" name="stripe_test_secret_key" class="form-control" required value="{{$stripe_test_secret_key}}">
											</div>
											<div class="form-group">
												<?php
												echo Form::label('stripe_test_publish_key', trans('admin.Stripe Test Publish Key'),['class'=>'control-label']);
												?>
												<input type="text" name="stripe_test_publish_key" class="form-control" required value="{{$stripe_test_publish_key}}">
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

	</script>
@stop