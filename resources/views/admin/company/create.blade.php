@extends('admin.layouts.master')
@section('content')
<style>
	.iti-flag{
		background-image:url("{{asset('public/assets/images/flags.png')}}") !important;
	}
	@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx){
		.iti-flag{
			background-image:url("{{asset('public/assets/images/flags@2x.png')}}") !important;
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
						  @if(Session::has('error'))
							  <div  class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								   <span aria-hidden="true">&times;</span>
								 </button>
							   </div>
							@endif 
							@if(Session::has('success'))
							  <div   class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! session('success') !!}
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								   <span aria-hidden="true">&times;</span>
								 </button>
							   </div>
				        @endif							
							{{ Form::open(array('url' => route('company.store'),'class'=>'form-horizontal form-material','id'=>'userCreate','enctype' => 'multipart/form-data','autocomplete'=>"off",'role'=>"presentation")) }}
								<div class="form-body">
									<div class="row p-t-5">
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
															echo Form::file('image',['class'=>'form-control','onchange'=>'readURL(this);','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
														@error('image_tmp')
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
												echo Form::label('user_name', 'Company Name',['class'=>'control-label']);
												echo Form::text('user_name',null,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>

												@error('user_name')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror 
											</div>
											
											
											<div class="form-group">
												<?php
												echo Form::label('email', 'Email',['class'=>'control-label']);
												echo Form::email('email',null,['class'=>'form-control','required'=>false,'autocomplete'=>'off']);
												?>
												@error('email')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror 
											</div>
											<div class="" style="margin-bottom:20px">
												<?php
												echo Form::label('phone', 'Phone',['class'=>'control-label']);
												echo Form::text('phone',null,['class'=>'form-control','required'=>false,'id'=>'Regphones','autocomplete'=>'off']);
												?>
												<input type="hidden" value="+1" id="test1" name="country_code" />
												@error('phone')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror 
											</div>
											<div class="form-group">
												<?php
												echo Form::label('password', 'Password',['class'=>'control-label']);
												echo Form::password('password',['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('password')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror 
											</div>
											
											<div class="form-group">
												<?php
												echo Form::label('state', 'State',['class'=>'control-label']);
												echo Form::text('state',null,['class'=>'form-control','autocomplete'=>'off']);
												?>
												@error('state')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror 
											</div>
											<div class="form-group">
												<?php
												echo Form::label('city', 'City',['class'=>'control-label']);
												echo Form::text('city',null,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('city')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror 
											</div>
											<div class="form-group">
												<?php
												echo Form::label('street', 'Street',['class'=>'control-label']);
												echo Form::text('street',null,['class'=>'form-control','autocomplete'=>'off']);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('zip', 'Zip Code',['class'=>'control-label']);
												echo Form::text('zip',null,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('zip')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror 
											</div>
											<div class="form-group">
												<?php
												echo Form::label('country', 'Country',['class'=>'control-label']);
												echo Form::text('country',null,['class'=>'form-control','required'=>true,'autocomplete'=>'off']);
												?>
												@error('country')
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
												@error('status')
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
									<a href="{{route('company.index')}}" class="btn btn-inverse">Cancel</a>
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

<style type="text/css">
	.invalid-feedback {
		display: block !important;
	}
</style> 


<script type="text/javascript">
	$(function(){
		$('#userCreate').hide();
		
		setTimeout(function(){
			$('[autocomplete=off]').val('');
			$('#userCreate').show();
			var myStr = $("#Regphones").val().replaceAll(/-/g, "").replaceAll(" ", "");
			$("#Regphones").removeAttr('placeholder');
			$("#Regphones").val(myStr);
		}, 500);
	});
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

	$('.flag-container').click(function(){
		var data = $('.selected-dial-code').html();
		$("#test1").val(data);
	});


	</script>
@stop