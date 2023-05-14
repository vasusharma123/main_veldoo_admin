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
							<div>
								<div class="row">
									<div class="col-6">
										<?php
											echo Form::label('cphone', 'Phone',['class'=>'control-label']);
											echo Form::text('cphone',null,['class'=>'form-control','required'=>true,'id'=>'CRegphones']);
										?>
									</div>
									<div class="col-6"></div>
									<div class="col-6 text-center mt-2">
										<button class="btn btn-info checkDriverPhone">
											Check
										</button>
									</div>
								</div>
							</div>
							{{ Form::open(array('url' =>  route('users.store'),'class'=>'form-horizontal form-material','id'=>'userCreate','style'=>'display:none','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-12">
											<h3>Add New Driver</h3>
										</div>
										<div class="col-md-6">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('image_tmp', 'Profile Picture',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('image',['class'=>'form-control','onchange'=>'readURL(this);']);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
														 @error('image')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
													</div>
												</div>
												<div class="col-md-2">
													<img id="previewimage" src="#" alt="" />
												</div>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('first_name', 'First Name',['class'=>'control-label']);
												echo Form::text('first_name',null,['class'=>'form-control','required'=>true]);
												?>
												@error('first_name')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
											</div>
											<div class="form-group">
												<?php
												echo Form::label('last_name', 'Last Name',['class'=>'control-label']);
												echo Form::text('last_name',null,['class'=>'form-control','required'=>true]);
												?>
												@error('last_name')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
											</div>
											<div class="form-group">
												<?php
												echo Form::label('email', 'Email',['class'=>'control-label']);
												echo Form::text('email',null,['class'=>'form-control']);
												?>
												@error('email')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
											</div>	
											<!-- <div class="form-group">
												<?php
												//echo Form::label('country_code', 'Country code',['class'=>'control-label']);
												//echo Form::text('country_code',null,['class'=>'form-control','required'=>true,'placeholder'=>'91']);
												?>
											</div> -->
											<div class="" style="margin-bottom: 20px">
												<?php
													echo Form::label('phone', 'Phone',['class'=>'control-label']);
													echo Form::text('phone',null,['class'=>'form-control','required'=>true,'id'=>'Regphones']);
												?>
												<input type="hidden" value="1" id="test1" name="country_code" />
												@error('phone')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror  
											</div>
											<div class="form-group">
												<?php
													echo Form::label('password', 'Password',['class'=>'control-label']);
													echo Form::password('password',['class'=>'form-control','required'=>true]);
												?>
												@error('password')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror  
											</div>
											<div class="form-group">
												<?php
												echo Form::label('status', 'Status',['class'=>'control-label']);
												echo Form::select('status', array('1' => 'Active', '0' => 'In-active'),null,['class'=>'form-control custom-select','required'=>true]);
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<a href="{{ url('admin/drivers') }}" class="btn btn-inverse">Cancel</a>
								</div>
							 {{ Form::close() }}
							<div class="row driverInfoFatchByPhone" style="display: none">
								<div class="col-12">
									<h2>Driver Info</h2>
								</div>
								<div class="col-12">
									<div class="table-responsive">
										<table class="table table-bordered">
											<tbody>
												<tr>
													<td><strong>Email</strong></td>
													<td class="demail"></td>
												</tr>
												<tr>
													<td><strong>Name</strong></td>
													<td class="dname"></td>
												</tr>
												<tr>
													<td><strong>Phone</strong></td>
													<td class="dphone"></td>
												</tr>
												<tr>
													<td><strong>City</strong></td>
													<td class="dcity"></td>
												</tr>
												<tr>
													<td><strong>State</strong></td>
													<td class="dstate"></td>
												</tr>
												<tr>
													<td><strong>Street</strong></td>
													<td class="dstreet"></td>
												</tr>
												<tr>
													<td><strong>Zip</strong></td>
													<td class="dzip"></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-12 text-center">
										<div>
											<a href="" class="btn btn-info driverInfoFatchByPhoneAdd">
												Add
											</a>
											<button class="btn btn-success driverInfoFatchByPhoneCancel">
												Cancel
											</button>
										</div>
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
		<!-- ============================================================== -->
		<!-- End Container fluid  -->
@endsection

@section('footer_scripts')
<style type="text/css">
	.invalid-feedback {
		display: block !important;
	}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>   
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>  
<script type="text/javascript">
	$(document).ready(function () {
		$('#userCreate').validate();
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

	// $('.flag-container').click(function(){
	// 	var data = $('.selected-dial-code').html();
	// 	$("#test1").val(data);
	// });
	// $('#CRegphones').intlTelInput("setNumber", "+1");
	var input = $('#Regphones').intlTelInput("setNumber", "+1");
	input.on("countrychange", function() {
		$("#test1").val($("#Regphones").intlTelInput("getSelectedCountryData").dialCode);
	});
	$(document).ready(function(){
		$("#Regphones").removeAttr('placeholder');
		setTimeout(function(){  
			var myStr = $("#Regphones").val().replace(/-/g, "");
			$("#Regphones").removeAttr('placeholder');
			$("#Regphones").val(myStr);
			}, 1000);

	});
	$(document).on('click','.checkDriverPhone',function(){
		if ($('#CRegphones').val()=="") 
		{
			alert("Phone is required");
			return false;		
		}
		$.ajax({
			url: "{{ route('checkDriverByPhone') }}",
			type: "POST",
			data: {_token:"{{ csrf_token() }}",country_code:$("#CRegphones").intlTelInput("getSelectedCountryData").dialCode,phone:$('#CRegphones').val()},
			success: function(data){
				if (data.status==0) 
				{
					$('#Regphones').intlTelInput("setNumber", "+"+$("#CRegphones").intlTelInput("getSelectedCountryData").dialCode+$('#CRegphones').val());
					$('#userCreate').show();
					$('.driverInfoFatchByPhone').hide();
					alert(data.message);
				}
				if (data.status==1) 
				{
					// console.log(data.driver);
					$('.demail').html(data.driver.email);
					$('.dname').html(data.driver.first_name+' '+data.driver.last_name);
					$('.dphone').html(data.driver.country_code+'-'+data.driver.phone);
					$('.dcity').html(data.driver.city);
					$('.dstate').html(data.driver.state);
					$('.dstreet').html(data.driver.street);
					$('.dzip').html(data.driver.zip);
					url = "{{ route('addDriverServiceProvider','~') }}";
					url = url.replace('~',data.driver.id);
					$('.driverInfoFatchByPhoneAdd').attr('href',url);
					$('#userCreate').hide();
					$('.driverInfoFatchByPhone').show();
				}
				if (data.status==2) 
				{
					$('#userCreate').hide();
					$('.driverInfoFatchByPhone').hide();
					alert(data.message);
				}
			}
		});
	});
	$(document).on('click','.driverInfoFatchByPhoneCancel',function(){
		$('.driverInfoFatchByPhone').hide();
	});
</script>
@stop