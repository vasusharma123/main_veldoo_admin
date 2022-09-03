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
							
							{{ Form::model($record, array('url' =>route('vehicle-type.update',$record->id),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								@csrf
								@method('PATCH')
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
										
										<!--<div class="form-group">
												<?php
												//echo Form::label('cart_type', 'Car Type',['class'=>'control-label']);
												?>
												<select name="car_type" class="form-control" required="required">
													@foreach($car_types as $key => $car_type)
													 <option value="{{ $car_type->name }}" {{ ( $car_type->name == $record->car_type) ? 'selected' : '' }}> {{ $car_type->name }} </option>
													@endforeach
												</select>
											</div>-->
												<div class="form-group">
												<?php
												echo Form::label('car_type', 'Car Type',['class'=>'control-label']);
												echo Form::text('car_type',$record->car_type,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('price_per_km', 'Price Per KM',['class'=>'control-label']);
												echo Form::number('price_per_km',$record->price_per_km,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('basic_fee', 'Basic Fee',['class'=>'control-label']);
												echo Form::number('basic_fee',$record->basic_fee,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<!--<div class="form-group">
												<?php
												//echo Form::label('price_per_min_mile', 'Price Per Min/Mile',['class'=>'control-label']);
											//	echo Form::number('price_per_min_mile',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											
											<div class="form-group">
												<?php
											//	echo Form::label('commission', 'Commission',['class'=>'control-label']);
											//	echo Form::number('commission',null,['class'=>'form-control','required'=>true]);
												?>
											</div>--->
											
											<!--<div class="form-group">
												<?php
												//echo Form::label('ride_cancel_time_limit', 'Ride Cancel Time Limit(In Minutes)',['class'=>'control-label']);
												//echo Form::number('ride_cancel_time_limit',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												//echo Form::label('ride_cancel_price', 'Ride Cancel Price',['class'=>'control-label']);
												//echo Form::number('ride_cancel_price',null,['class'=>'form-control','required'=>true]);
												?>
											</div>--->
											<div class="form-group">
												<?php
												echo Form::label('seating_capacity', 'Seating Capacity',['class'=>'control-label']);
												echo Form::number('seating_capacity',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('alert_time', 'Min. Alert Time',['class'=>'control-label']);
												echo Form::number('alert_time',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<!--<div class="form-group">
												<?php
												/* echo Form::label('pick_time_from', 'Pick Time From',['class'=>'control-label']);
												echo Form::time('pick_time_from',null,['class'=>'form-control','required'=>true,'id'=>'pick_time']); */
												?>
											</div>
											<div class="form-group">
												<?php
											/* 	echo Form::label('pick_time_to', 'Pick Time To',['class'=>'control-label']);
												echo Form::time('pick_time_to',null,['class'=>'form-control','required'=>true,'id'=>'pick_time']); */
												?>
											</div>
											<div class="form-group">
												<?php
												//echo Form::label('night_charges', 'Night Charges',['class'=>'control-label']);
												?>
												<div class="switch">
													<label>
														<input type="checkbox" name="night_charges" class="night_charges" value="1" data-id="{{ $record->id }}" {{ $record->night_charges === 1 ? "checked" : "" }}><span class="lever"></span>
													</label>
												</div>
											</div>-->
											<div class="row">
												<div class="col-md-10">
													<div class="form-group">
														<?php
														echo Form::label('car_image', 'Car Image',['class'=>'control-label']);
														?>
														<div class="fileinput fileinput-new input-group" data-provides="fileinput">
															<div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> 
															<span class="input-group-addon btn btn-default btn-file" > 
																<span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
															<input type="hidden">
															<?php
															echo Form::file('car_image',['class'=>'form-control','onchange'=>'readURL(this);','required'=>false]);
															?>
															</span>
															<a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a> 
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<?php 
														echo Html::image(config('app.url_public').'/'.($record->car_image ? $record->car_image : '/no-images.png'),'car image',['id'=>'previewimage','width'=>'50','height'=>'50']);
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<a href="{{ url('/admin/vehicle-type') }}" class="btn btn-inverse">Cancel</a>
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

	/*$('body').on('click', '.night_charges', function(){
		var night_charges = $(this).val();
		var id = $(this).attr('data-id');
		
		var text = $('.myInput').val();
		var orderby = $('input[name="orderBy"]').val();
		var order = $('input[name="order"]').val();
		$("#loading").fadeIn("slow");
		ajaxCall(id, text, orderby, order, page, status);
	});
	
		function ajaxCall(id=0,night_charges='',type='') {
		var page = (!page ? 1 : page);
		$.ajax({
			type: "GET",
			url: "{{url()->current()}}",
			data : {id:id,text:text,orderby:orderby,order:order,status:status,page:page,type:type},
			success: function (data) {
				$("#loading").fadeOut("slow");
				$('#allDataUpdate').html(data);
				
				$('.custom-userData-sort[orderBy="'+orderby+'"] > i').removeClass('fa-sort fa-sort-desc fa-sort-asc').addClass('fa-sort-'+order);
				$('.custom-userData-sort[orderby="'+orderby+'"]').attr('order', (order=='asc' ? 'desc' : 'asc'));
			}
			});
		}*/
		
		console.log($(".night_charges").val());
		if($(".night_charges").is(":checked")){
			m11="yes";
			}
			else{
			m11="no";
			}
	</script>
@stop