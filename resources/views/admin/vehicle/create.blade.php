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
							
							{{ Form::open(array('url' => route('vehicle.store'),'class'=>'form-horizontal form-material','id'=>'vehicleCreate','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('car type', 'Car Type',['class'=>'control-label']);
												?>
												<select name="car_type" class="form-control" required>
													@foreach($car_types as $car_type)
													<option value="{{$car_type->id}}">{{$car_type->car_type}}</option>
													@endforeach
												</select>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('year', 'Year',['class'=>'control-label']);
												echo Form::text('year',null,['class'=>'form-control','required'=>true]);
												?>
												@error('year')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
											</div>
											<div class="form-group">
												<?php
												echo Form::label('model', 'Model',['class'=>'control-label']);
												echo Form::text('model',null,['class'=>'form-control','required'=>true]);
												?>
												@error('model')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
											</div>
											<div class="form-group">
												<?php
												echo Form::label('color', 'Color',['class'=>'control-label']);
												echo Form::text('color',null,['class'=>'form-control','required'=>true]);
												?>
												@error('color')
															<span class="invalid-feedback" role="alert">
																<strong>{{ $message }}</strong>
															</span>
														@enderror  
											</div>
												<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('image', 'Vehicle Image',['class'=>'control-label']);
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
												echo Form::label('vehicle_number_plate', 'Vehicle Number Plate',['class'=>'control-label']);
												echo Form::text('vehicle_number_plate',null,['class'=>'form-control','required'=>true]);
												?>
												@error('vehicle_number_plate')
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
									<a href="{{route('vehicle.index')}}" class="btn btn-inverse">Cancel</a>
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
	$(document).ready(function () {
		$('#vehicleCreate').validate();
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