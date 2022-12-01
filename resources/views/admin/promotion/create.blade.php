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
							
							{{ Form::open(array('url' => route('promotion.store'),'class'=>'form-horizontal form-material','id'=>'userCreate','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
											
											<div class="form-group">
												<?php
												echo Form::label('title', 'Title',['class'=>'control-label']);
												echo Form::text('title',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('description', 'Description',['class'=>'control-label']);
												echo Form::text('description',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
														<?php
														echo Form::label('image', 'Image',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('image',['class'=>'form-control','onchange'=>'readURL(this);','required'=>true]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
											<div class="form-group">
												<?php
												echo Form::label('type', 'Type',['class'=>'control-label','required'=>true]);
												?>
												<select name="type" class="form-control user_type">
												<option value="">Select Type</option>
												<option value="1">For All Users</option>
												<option value="2">Specific User</option>
												</select>
											</div>
											<div class="form-group user_list_show hide">
												<?php
												echo Form::label('users', 'Users',['class'=>'control-label']);
												?>
												<select name="user_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select User" id="user">
												@foreach($users as $user)
												<option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
												@endforeach
												</select>
												
											</div>
											<div class="form-group">
												<?php
												echo Form::label('start_date', 'Start Date',['class'=>'control-label']);
												echo Form::date('start_date',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('end_date', 'End Date',['class'=>'control-label']);
												echo Form::date('end_date',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<a href="{{ route('promotion.index') }}" class="btn btn-inverse">Cancel</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
<script src="{{ asset('assets/plugins/select2/dist/css/select2.css')}}"></script>  
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
	$(document).ready(function() { 
		$("#user").select2();
	});
	$('.user_type').on('change', function() {
		var value = this.value;
		if(value == 2)
		{
			$(".user_list_show").removeClass("hide");
		}
		else
		{
			$(".user_list_show").addClass("hide");
		}
  
});
	</script>
@stop