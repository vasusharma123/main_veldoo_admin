@extends('admin.layouts.master')

@section('content')
<main class="body_content">
	<div class="inside_body">
		<div class="container-fluid p-0">
			<div class="row m-0 w-100">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
					<div class="body_flow">
						@include('admin.layouts.sidebar')
						<div class="formTableContent">
							<section class="addEditForm sectionsform">
								<article class="container-fluid">
									@include('admin.layouts.flash-message')
								
									{{ Form::open(array('url' => route('vehicle.store'),'class'=>'custom_form editForm','id'=>'vehicleCreate','enctype' => 'multipart/form-data')) }}
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-8 col-md-8 col-sm-12 col-12">
												<div class="row w-100 m-0">
													
													<div class="col-lg-4 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::select('car_type',$car_types, null, ['class'=>'form-select inputText','required'=>true, 'id' => 'capacity']);
															echo Form::label('car_type', 'Select car type',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('model',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Car Model']);
															echo Form::label('model', 'Enter car model',['class'=>'control-label']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('color',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Color']);
															echo Form::label('color', 'Enter car color',['class'=>'control-label']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('vehicle_number_plate',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Plate Number']);
															echo Form::label('vehicle_number_plate', 'Enter plate number',['class'=>'control-label']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('year',null,['class'=>'form-control inputText custNumFieldCls','required'=>true, 'placeholder' => 'Production Year']);
															echo Form::label('year', 'Enter production year',['class'=>'control-label']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<div class="inputForm position-relative">
																<?php
																echo Form::text('mileage',null,['class'=>'form-control inputText childlabelfield custFloatVal','required'=>false, 'placeholder' => 'Car Mileage']);
																?>
																<label class="absoultLabel">KM</label>
															</div>
															<?php
															echo Form::label('mileage', 'Enter car mileage',['class'=>'control-label']);
															?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-12 col-12">
												<div class="img_user_settled h-100">
													<div class="view_image_user">

														<img src="{{ asset('assets/images/veldoo/uploaded.png') }}" class="img-fluid w-100 img_user_face" />
														<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
														<?php
														echo Form::file('image',['class'=>'form-control hiddenForm','required'=>false]);
														?>
													</div>
													
													<div class="form-group">
														<input type="submit" value="Save" name="submit" class="form-control submit_btn carSide"/>
													</div>
												</div>
											</div>
										</div>
									{{ Form::close() }}
								</article>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection	
	
@section('footer_scripts')
<script>
$(document).ready(function(){
	
	setTimeout(function(){
		
		//var admin_phone = $('#phone').intlTelInput("setNumber", "+1");
	}, 1000);
});

//$("#admin_phone_country_code").val($("#admin_phone").intlTelInput("getSelectedCountryData").dialCode);
</script>
@stop