@extends('admin.layouts.master')

@section('content')

	<div class="formTableContent">
		<section class="addEditForm sectionsform">
			<article class="container-fluid">
				@include('admin.layouts.flash-message')
			
				{{ Form::open(array('url' => route('vehicle-type.store'),'class'=>'custom_form editForm','id'=>'vehicletypeCreate','enctype' => 'multipart/form-data')) }}
					<div class="row w-100 m-0 form_inside_row">
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<div class="row w-100 m-0">
								
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('car_type',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Car type']);
										echo Form::label('car_type', 'Enter car type',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										$seatingArr = array('1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10);
										echo Form::select('seating_capacity',$seatingArr, null, ['class'=>'form-select inputText','required'=>true, 'id' => 'capacity']);
										echo Form::label('seating_capacity', 'Configure seating capacity',['class'=>'control-label']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('alert_time',null,['class'=>'form-control inputText custNumFieldCls','required'=>true, 'placeholder' => 'Min. alert time']);
										echo Form::label('alert_time', 'Configure min. alert time',['class'=>'control-label']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<div class="inputForm position-relative">
											<?php
											echo Form::text('basic_fee',null,['class'=>'form-control inputText childlabelfield custFloatVal','required'=>true, 'placeholder' => 'Start fee']);
											?>
											<label class="absoultLabel">CHF</label>
										</div>
										<?php
										echo Form::label('basic_fee', 'Configure start fee',['class'=>'control-label']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<div class="inputForm position-relative">
											<?php
											echo Form::text('price_per_km',null,['class'=>'form-control inputText childlabelfield custFloatVal','required'=>true, 'placeholder' => 'Price per KM']);
											?>
											<label class="absoultLabel">CHF</label>
										</div>
										<?php
										echo Form::label('price_per_km', 'Configure price per km',['class'=>'control-label']);
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
									echo Form::file('car_image',['class'=>'form-control hiddenForm','required'=>true]);
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