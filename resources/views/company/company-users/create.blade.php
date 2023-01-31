@extends('admin.layouts.master')
@section('content')
<style>
	.iti-flag{
		background-image:url("{{asset('assets/images/flags.png')}}") !important;
	}
	@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx){
		.iti-flag{
			background-image:url("{{asset('assets/images/flags@2x.png')}}") !important;
		}
	}
</style>

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
							@include('company.company_flash_message')
							{{ Form::open(array('url' => route('company-users.store'),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
							@csrf
							<div class="form-body">
								<div class="row p-t-5">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-10">
												<div class="form-group">
													<?php
													echo Form::label('image_tmp', 'Profile Picture', ['class' => 'control-label']);
													?>
													<div class="fileinput fileinput-new input-group" data-provides="fileinput">
														<div class="form-control" data-trigger="fileinput"> 
															<i class="glyphicon glyphicon-file fileinput-exists"></i>
															<span class="fileinput-filename"></span>
														</div>
														<span class="input-group-addon btn btn-default btn-file">
															<span class="fileinput-new">Select file</span> <span
																class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('image_tmp', ['class' => 'form-control', 'onchange' => 'readURL(this);', 'required' => false]);
															?>
														</span>
														<a href="#"
															class="input-group-addon btn btn-default fileinput-exists"
															data-dismiss="fileinput">Remove</a>
													</div>
												</div>
											</div>
											<div class="col-md-2">
												<?php
												echo Html::image((asset('no-images.png')), 'sidebar logo', ['id' => 'previewimage', 'width' => '50', 'height' => '50']);
												?>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('first_name', 'First Name', ['class' => 'control-label']);
											echo Form::text('first_name', null, ['class' => 'form-control', 'required' => true]);
											?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('last_name', 'Last Name', ['class' => 'control-label']);
											echo Form::text('last_name', null, ['class' => 'form-control', 'required' => true]);
											?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="country_code_div" style="margin-bottom: 20px">
											<?php
											echo Form::label('phone', 'Phone', ['class' => 'control-label']);
											?>
											<input class="form-control " id="Regphones" required=""
												value="" name="phone"
												type="text" >
											<input type="hidden" value="+1" class="country_code"
												name="country_code" />
										</div>
									</div>
									<div class="col-md-6">
										<div class="country_code_div" style="margin-bottom: 20px">
											<?php
											echo Form::label('phone', 'Alternate Phone No.', ['class' => 'control-label']);
											?>
											<input class="form-control " id="RegAlterenatePhones" name="second_phone_number" type="text" placeholder="">
											<input type="hidden" value="+1" class="second_country_code" name="second_country_code" />
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('email', 'Email', ['class' => 'control-label']);
											echo Form::text('email', null, ['class' => 'form-control', 'required' => true]);
											?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('country', 'Country', ['class' => 'control-label']);
											echo Form::text('country', null, ['class' => 'form-control', 'required' => false]);
											?>
											@error('country')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('state', 'State', ['class' => 'control-label']);
											echo Form::text('state', null, ['class' => 'form-control']);
											?>
											@error('state')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('city', 'City', ['class' => 'control-label']);
											echo Form::text('city', null, ['class' => 'form-control', 'required' => false]);
											?>
											@error('city')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('street', 'Street', ['class' => 'control-label']);
											echo Form::text('street', null, ['class' => 'form-control']);
											?>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('zip', 'Zip Code', ['class' => 'control-label']);
											echo Form::text('zip', null, ['class' => 'form-control', 'required' => false]);
											?>
											@error('zip')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('Password', 'Password', ['class' => 'control-label']);
											echo Form::text('password', null, ['class' => 'form-control', 'required' => false]);
											?>
											@error('password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<?php
											echo Form::label('status', 'Status', ['class' => 'control-label']);
											echo Form::select('status', ['1' => 'Active', '0' => 'In-active'], null, ['class' => 'form-control custom-select', 'required' => true]);
											?>
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
    $(function(){
		setTimeout(function(){
			var myStr = $("#Regphones").val().replaceAll(/-/g, "").replaceAll(" ", "");
			$("#Regphones").removeAttr('placeholder');
			$("#Regphones").val(myStr);

			var myStr1 = $("#RegAlterenatePhones").val().replaceAll(/-/g, "").replaceAll(" ", "");
			$("#RegAlterenatePhones").removeAttr('placeholder');
			$("#RegAlterenatePhones").val(myStr1);

		}, 500);
	});
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#previewimage').attr('src', e.target.result);
				$('#previewimage').attr('height', '50px');
				$('#previewimage').attr('width', '50px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$(document).ready(function() {
		var input = $('#Regphones').intlTelInput("setNumber", "+1");
		input.on("countrychange", function() {
			$(".country_code").val($("#Regphones").intlTelInput("getSelectedCountryData").dialCode);
		});

		var input = $('#RegAlterenatePhones').intlTelInput("setNumber", "+1");
		input.on("countrychange", function() {
			$(".second_country_code").val($("#RegAlterenatePhones").intlTelInput("getSelectedCountryData").dialCode);
		});
	});
</script>
@stop