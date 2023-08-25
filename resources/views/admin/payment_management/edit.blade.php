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
							
							{{ Form::model($record, array('url' =>'admin/driver/update/'.$record->id,'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								@csrf
								@method('PATCH')
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
															echo Form::file('image_tmp',['class'=>'form-control','onchange'=>'readURL(this);','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<?php 
														echo Html::image(((!empty($record->image)) ? (config('app.url_public').'/'.$record->image) : asset('no-images.png')),'sidebar logo',['id'=>'previewimage','width'=>'50','height'=>'50']);
													?>
												</div>
											</div>
											<!--<div class="form-group">
												<?php
												//echo Form::label('user_name', 'Username',['class'=>'control-label']);
												//echo Form::text('user_name',null,['class'=>'form-control','required'=>true]);
												?>
											</div>---->
											<div class="form-group">
												<?php
												echo Form::label('first_name', 'First Name',['class'=>'control-label']);
												echo Form::text('first_name',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('last_name', 'Last Name',['class'=>'control-label']);
												echo Form::text('last_name',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<!--<div class="form-group">
												<?php
												//echo Form::label('dob', 'DOB',['class'=>'control-label']);
												//echo Form::date('dob',null,['class'=>'form-control','required'=>true]);
												?>
											</div>-->
											<!--<div class="form-group">
												<?php
												//echo Form::radio('gender',1, null,  array('id'=>'male'));
												//echo Form::label('male', 'Male',['class'=>'']);
												
												//echo Form::radio('gender',2, null,  array('id'=>'female'));
												//echo Form::label('female', 'Female',['class'=>'']);
												?>
											</div>-->
											<div class="form-group">
												<?php
												echo Form::label('email', 'Email',['class'=>'control-label']);
												echo Form::text('email',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<!--<div class="form-group">
												<?php
												//echo Form::label('my_free_subscription_days', 'Free Subscription Days',['class'=>'control-label']);
												//echo Form::number('my_free_subscription_days',null,['class'=>'form-control','required'=>false, 'min'=>'-1']);
												?>
												<small>Enter number of days or -1 for lifetime</small>
											</div>-->
											<!--<div class="form-group">
												<?php
												//echo Form::label('my_free_subscription_start_date', 'Free Subscription Start',['class'=>'control-label']);
												//echo Form::text('my_free_subscription_start_date',null,['class'=>'form-control date','required'=>false]);
												?>
											</div>-->
											<div class="form-group">
												<?php
												echo Form::checkbox('reset_password',1, null,  array('id'=>'reset_password'));
												echo Form::label('reset_password', 'Reset Password',['class'=>'reset_password']);
												?>
											</div>
											<div class="form-group change-password hide">
												<?php
												echo Form::label('password', 'Password',['class'=>'control-label']);
												echo Form::password('password',['class'=>'form-control','required'=>false]);
												?>
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
									<a href="{{ route('users.drivers') }}" class="btn btn-inverse">Cancel</a>
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
		$('#store').validate();
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