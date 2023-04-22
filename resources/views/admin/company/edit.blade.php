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
							@include('admin.layouts.flash-message')
							
							{{ Form::model($record, array('url' => route( $route.'.update', $record->id ),'class'=>'form-horizontal form-material','id'=>'update','enctype' => 'multipart/form-data')) }}
								@csrf
								@method('PATCH')
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-12">
											<h2>Company Information</h2>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('company', 'Logo',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
																echo Form::file('company_logo',['class'=>'form-control','onchange'=>'readURL(this,"previewLogo");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
														@error('company_logo')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
													</div>
												</div>
												<div class="col-md-2">
													@if(!empty($record->logo))
														<img id="previewLogo" src="{{url('storage/'.$record->logo)}}" alt="" height="50px" width="80px" />
													@else
														<img id="previewLogo" src="#" alt="" height="50px" width="80px" />
													@endif
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('background_image', 'Background Image',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('company_background_image',['class'=>'form-control','onchange'=>'readURL(this,"previewbackground_image");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
														@error('company_background_image')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
													</div>
												</div>
												<div class="col-md-2">
													@if(!empty($record->background_image))
														<img id="previewbackground_image" src="{{url('storage/'.$record->background_image)}}" alt="" height="50px" width="80px" />
													@else
														<img id="previewbackground_image" src="#" alt="" height="50px" width="80px" />
													@endif
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('company_name', 'Company Name',['class'=>'control-label']);
													echo Form::text('company_name',$record->name,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('company_name')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('company_email', 'Email',['class'=>'control-label']);
													echo Form::email('company_email',$record->email,['class'=>'form-control','required'=>false,'autocomplete'=>'off']);
												?>
												@error('company_email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="" style="margin-bottom:20px">
												<?php
													echo Form::label('company_phone', 'Phone',['class'=>'control-label']);
													echo Form::text('company_phone',$record->phone,['class'=>'form-control','required'=>true,'id'=>'Regphones','autocomplete'=>'off']);
												?>
												<input type="hidden" value="{{ $record->country_code }}" id="test1" name="company_country_code" />
												@error('company_phone')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('company_state', 'State',['class'=>'control-label']);
													echo Form::text('company_state',$record->state,['class'=>'form-control','autocomplete'=>'off']);
												?>
												@error('company_state')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('company_city', 'City',['class'=>'control-label']);
													echo Form::text('company_city',$record->city,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('company_city')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('company_street', 'Street',['class'=>'control-label']);
													echo Form::text('company_street',$record->street,['class'=>'form-control','autocomplete'=>'off']);
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('company_zip', 'Zip Code',['class'=>'control-label']);
													echo Form::text('company_zip',$record->zip,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('company_zip')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('company_country', 'Country',['class'=>'control-label']);
													echo Form::text('company_country',$record->country,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('company_country')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('status', 'Status',['class'=>'control-label']);
													echo Form::select('status', array('1' => 'Active', '0' => 'In-active'),@$record->user->status,['class'=>'form-control custom-select','required'=>true]);
												?>
												@error('status')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-12">
											<h2>Admin Profile</h2>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
															echo Form::label('admin_profile_picture', 'Profile Picture',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('admin_profile_picture',['class'=>'form-control','onchange'=>'readURL(this,"previewimage");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
														@error('admin_profile_picture')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
													</div>
												</div>
												<div class="col-md-2">
													@if(!empty(@$record->user->image))
														<img id="previewimage" src="{{url('storage/'.@$record->user->image)}}" alt="" height="50px" width="80px" />
													@else
														<img id="previewimage" src="#" alt="" height="50px" width="80px" />
													@endif
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('admin_email', 'Email',['class'=>'control-label']);
													echo Form::email('admin_email',@$record->user->email,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('admin_email')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::label('admin_name','Name',['class'=>'control-label']);
													echo Form::text('admin_name',@$record->user->name,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('admin_name')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="" style="margin-bottom:20px">
												<?php
													echo Form::label('admin_phone', 'Phone',['class'=>'control-label']);
													echo Form::text('admin_phone',@$record->user->phone,['class'=>'form-control','required'=>false,'id'=>'admin_phone','autocomplete'=>'off','required'=>true]);
												?>
												<input type="hidden" value="{{ @$record->user->country_code }}" id="admin_phone_country_code" name="admin_country_code" />
												@error('admin_phone')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
													echo Form::checkbox('reset_password', 1, null, ['id' => 'reset_password']);
													echo Form::label('reset_password', 'Reset Password', ['class' => 'reset_password']);
												?>
											</div>
											<div class="form-group change-password" style="display: none">
												<?php
													echo Form::label('admin_password', 'Password',['class'=>'control-label']);
													echo Form::password('admin_password',['class'=>'form-control','required'=>false,'autocomplete'=>'off']);
												?>
												@error('admin_password')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<a href="{{route( $route.'.index')}}" class="btn btn-inverse">Cancel</a>
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
		$('#update').validate();
		$('body').on('change', '#reset_password', function () {
			if($(this).prop("checked") == true){
				$('.change-password').show();
				$('.change-password input').attr('required','required');
			} else {
				$('.change-password').hide();
				$('.change-password input').removeAttr('required');
			}
		});
	});
	function readURL(input,imgtag){
		 if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#'+imgtag).attr('src', e.target.result);
				$('#'+imgtag).attr('height','50px');
				$('#'+imgtag).attr('width','50px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	// $('.flag-container').click(function(){
	// 	var data = $('.selected-dial-code').html();
	// 	$("#test1").val(data);
	// });

$(document).ready(function(){
    setTimeout(function(){  
		var myStr = $("#Regphones").val().replace(/-/g, "");
		$("#Regphones").val(myStr);
	}, 1000);
    setTimeout(function(){  
		var myStr = $("#admin_phone").val().replace(/-/g, "");
		$("#admin_phone").val(myStr);
	}, 1000);
});
var input = $('#Regphones').intlTelInput("setNumber", "{{ $record->country_code.$record->phone }}");
input.on("countrychange", function() {
	$("#test1").val($("#Regphones").intlTelInput("getSelectedCountryData").dialCode);
});

var admin_phone = $('#admin_phone').intlTelInput("setNumber", "{{ @$record->user->country_code.@$record->user->phone }}");
admin_phone.on("countrychange", function() {
	$("#admin_phone_country_code").val($("#admin_phone").intlTelInput("getSelectedCountryData").dialCode);
});
</script>
@stop