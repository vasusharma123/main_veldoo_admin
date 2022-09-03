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
							
							{{ Form::model($record, array('url' => route( $route.'.update', $record->id ),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								@csrf
								@method('PATCH')
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('Car Type', 'Car Type',['class'=>'control-label']);?>
											<select name="car_type" class="form-control">
													<option value="">Select Car Type</option>
													@foreach($car_types as $key => $car_type)
													 <option value="{{ $car_type->id }}" {{ ( $car_type->id == $record->category_id) ? 'selected' : '' }}> {{ $car_type->car_type }} </option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('year', 'Year',['class'=>'control-label']);
												echo Form::text('year',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('model', 'Model',['class'=>'control-label']);
												echo Form::text('model',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										
											<div class="form-group">
												<?php
												echo Form::label('color', 'Color',['class'=>'control-label']);
												echo Form::text('color',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('vehicle_image', 'Vehicle Image',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('vehicle_image',['class'=>'form-control','onchange'=>'readURL(this);','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
												@if(!empty($record->vehicle_image))
												<img src="{{$record->vehicle_image}}" height="50px" width="80px">
												<button type="button" class="btn btn-info btn-sm" onclick="removeImage({{$record->id}});">Remove Image</button>
												@else
												<img src="{{url('public/no-images.png')}}" height="50px" width="80px">	
												@endif
												</div>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('vehicle_number_plate', 'Vehicle Number Plate',['class'=>'control-label']);
												echo Form::text('vehicle_number_plate',null,['class'=>'form-control','required'=>true]);
												?>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
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
	
	function removeImage(id) {
		$.ajax({
		type: "GET",
		url: "{{url()->current()}}",
		data : {id:id,type:"remove_image"},
		success: function (data) {
			if(data.message=="success"){
				// toastr.options.timeOut = 1000;
				// toastr.success('Image deleted successfully');
				  toastr.success('', 'Image removed successfully', {
                timeOut: 1000,
                preventDuplicates: true,
                onHidden: function() {
                   location.reload();
                }
            });
			}
		}
	});
	}

	
	</script>
@stop