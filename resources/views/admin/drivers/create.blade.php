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
								
									{{ Form::open(array('url' => route('drivers.store'),'class'=>'custom_form editForm','id'=>'userCreate','enctype' => 'multipart/form-data')) }}
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-8 col-md-8 col-sm-12 col-12">
												<div class="row w-100 m-0">
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('first_name',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Name']);
															echo Form::label('first_name', 'Enter First Name',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('last_name',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Name']);
															echo Form::label('last_name', 'Enter Last Name',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-2 col-md-4 col-sm-4 col-4">
														<div class="form-group">
															<?php
															echo Form::text('country_code',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => '91']);
															echo Form::label('country_code', 'Example: 41',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-8 col-sm-8 col-8">
														<div class="form-group">
															<?php
															echo Form::text('phone',null,['class'=>'form-control inputText','required'=>true, 'id'=>'phone', 'placeholder' => '1234']);
															echo Form::label('phone', 'Example: 123 456 7899',['class'=>'']);
															?>
															<input type="hidden" value="+1" id="admin_phone_country_code" name="admin_country_code" />
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::email('email',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'user@email-address.com']);
															echo Form::label('email', 'Example: Example: user@email-address.com',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group password-fieldd-lt">
															<?php
															echo Form::password('password',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Address']);
															echo Form::label('password', 'Enter driver password',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group password-fieldd-lt">
															<?php
															echo Form::password('confirm_password',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Address']);
															echo Form::label('confirm_password', 'Re-enter driver password',['class'=>'']);
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
														<input type="file" name="fileUser" class="form-control hiddenForm" />
														<?php
														echo Form::file('image_tmp',['class'=>'form-control hiddenForm','required'=>true]);
														?>
													</div>
													
													<div class="form-group">
														<input type="submit" value="Save" name="submit" class="form-control submit_btn"/>
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