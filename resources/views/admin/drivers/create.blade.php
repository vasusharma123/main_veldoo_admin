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
							
							{{ Form::open(array('url' =>  route('users.store'),'class'=>'form-horizontal form-material','id'=>'userCreate','enctype' => 'multipart/form-data')) }}
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

	$('.flag-container').click(function(){
		var data = $('.selected-dial-code').html();
		$("#test1").val(data);
	});
     
$(document).ready(function(){
	 $("#Regphones").removeAttr('placeholder');
    setTimeout(function(){  
           var myStr = $("#Regphones").val().replace(/-/g, "");
           $("#Regphones").removeAttr('placeholder');
           $("#Regphones").val(myStr);
           }, 1000);

});
	</script>
@stop