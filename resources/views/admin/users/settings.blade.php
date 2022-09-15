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
							
							{{ Form::model($record, array('url' => route( 'users.settingsUpdate'),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
							@method('PATCH')
								<div class="form-body">							
									<div class="row">
										
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('site_name', 'Site Name',['class'=>'control-label']);
												echo Form::text('site_name',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
										
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('copyright', 'Copyright',['class'=>'control-label']);
												echo Form::text('copyright',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('admin_primary_color', 'Primary Color',['class'=>'control-label']);
												echo Form::color('admin_primary_color',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6" id="image1-section">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('admin_logo_tmp', 'My Logo',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('admin_logo_tmp',['class'=>'form-control','onchange'=>'readURL(this,"image1");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<?php 
														echo Html::image(config('app.url_public').(!empty($record->admin_logo) ? '/'.$record->admin_logo : '/no-images.png'),'Background Image',['id'=>'previewimage','width'=>'50','height'=>'50']);
													?>	
												</div>
											</div>
										</div>
										<div class="col-md-6" id="image2-section">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('admin_favicon_tmp', 'Favicon',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('admin_favicon_tmp',['class'=>'form-control','onchange'=>'readURL(this,"image2");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
												<?php 
													echo Html::image(config('app.url_public').(!empty($record->admin_favicon) ? '/'.$record->admin_favicon : '/no-images.png'),'Background Image',['id'=>'previewimage','width'=>'50','height'=>'50']);
													?>	
												</div>
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-6" id="image3-section">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('admin_background_tmp', 'Background Image',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('admin_background_tmp',['class'=>'form-control','onchange'=>'readURL(this,"image3");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<?php 
														echo Html::image(config('app.url_public').(!empty($record->admin_background) ? '/'.$record->admin_background : '/no-images.png'),'Background Image',['id'=>'previewimage','width'=>'50','height'=>'50']);
													?>	
												</div>
											</div>
										</div>
										<div class="col-md-6" id="image5-section">
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('image', 'Sidebar Logo',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('admin_sidebar_logo_tmp',['class'=>'form-control','onchange'=>'readURL(this,"image5");','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<?php 
														echo Html::image(config('app.url_public').(!empty($record->admin_sidebar_logo) ? '/'.$record->admin_sidebar_logo : '/no-images.png'),'sidebar logo',['id'=>'previewimage','width'=>'50','height'=>'50']);
													?>	
												</div>
											</div>
										</div>
										
									</div>
							
									<div class="row">
										
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('currency_symbol', trans('admin.Currency Symbol'),['class'=>'control-label']);
												echo Form::text('currency_symbol',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('currency_name', trans('admin.Currency Name'),['class'=>'control-label']);
												echo Form::text('currency_name',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
									</div>	
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('driver_requests', 'Driver Requests',['class'=>'control-label']);
												echo Form::number('driver_requests',null,['class'=>'form-control','required'=>true,'min'=>1]);
												?>
											<span class="subtitle">(we will send request to X drivers)</span>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('waiting_time', 'Waiting Time',['class'=>'control-label']);
												echo Form::number('waiting_time',null,['class'=>'form-control','required'=>true,'min'=>1]);
												?>
											<span class="subtitle">Driver will have time to accept Request(In seconds)</span>
											</div>
										</div>
									</div>
										<div class="row">

										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('radius', 'Radius',['class'=>'control-label']);
												echo Form::number('radius',null,['class'=>'form-control','required'=>true,'min'=>1]);
												?>
												<span class="subtitle">Driver will search in this radius(In Miles)</span>
												
												
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('join_radius', 'Radius for Join rides',['class'=>'control-label']);
												echo Form::number('join_radius',null,['class'=>'form-control','required'=>true,'min'=>1]);
												?>
												<span class="subtitle">User will see join rides in this radius(In Miles)</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('notification', 'Notification',['class'=>'control-label']);
												?>
												<div class="switch">
												<label>
													<input type="checkbox" name="notification" class="change_status" value="1" {{ $record->notification == 1 ? "checked" : "" }}><span class="lever"></span>
												</label>
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
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- End PAge Content -->
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- End Container fluid  -->
		<style>
		span.subtitle {
    font-size: 12px;
}
		</style>
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