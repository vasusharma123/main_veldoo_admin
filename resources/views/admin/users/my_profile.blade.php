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
							
							{{ Form::model($record, array('url' => route( 'users.profileUpdate', $record->id ),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
							@method('PATCH')
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('name', 'Name',['class'=>'control-label']);
												echo Form::text('name',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('email', 'Email',['class'=>'control-label']);
												echo Form::text('email',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-6" id="image4-section">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('image', 'Profile Image',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('image',['class'=>'form-control','onchange'=>'readURL(this,"image4");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<?php 
														echo Html::image(config('app.url_public').($record->image ? '/'.$record->image : '/no-images.png'),'Background Image',['id'=>'previewimage','width'=>'50','height'=>'50']);
													?>	
												</div>
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
				
					<div class="card card-outline-info">
						<div class="card-header">
							<h4 class="m-b-0 text-white">Change Password</h4>
						</div>
						<div class="card-body">							
							{{ Form::model($record, array('url' => route( 'users.changePassword', $record->id ),'class'=>'form-horizontal form-material','id'=>'changePassword','enctype' => 'multipart/form-data')) }}
							@method('PATCH')
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('oldpassword', 'Old Password',['class'=>'control-label']);
												echo Form::password('oldpassword',['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('password', 'Password',['class'=>'control-label']);
												echo Form::password('password',['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('confirm_password', 'Confirm Password',['class'=>'control-label']);
												echo Form::password('confirm_password',['class'=>'form-control','required'=>true]);
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
	$(document).ready(function () {
		$('#changePassword').validate();
	});
	function readURL(input,section){
		 if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#'+section+'-section #previewimage').attr('src', e.target.result);
				$('#'+section+'-section #previewimage').attr('height','50px');
				$('#'+section+'-section #previewimage').attr('width','50px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	</script>
@stop