@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css">
@endsection

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
								
									{{ Form::model($record, array('url' => route( 'drivers.update', $record->id ),'class'=>'form-horizontal form-material custom_form editForm','id'=>'store','enctype' => 'multipart/form-data')) }}
									@method('PATCH')
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
															echo Form::text('last_name',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Surname']);
															echo Form::label('last_name', 'Enter Last Name',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<input class="form-control" name="country_code_iso" type="hidden" id="iso2" value="{{ $record->country_code_iso ?? 'ch' }}">
													        <input class="form-control" name="country_code" type="hidden" id="country_code" value="{{ $record->country_code ?? 41 }}">
													        <input type="tel" class="form-control inputText" id="phone" name="phone" placeholder="1234" value="{{ $record->phone }}" required/>
													        <label for="phone">Example: +41 123 456 7899</label>
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
														<div class="form-group p-3">
															<div class="switch_btn">
																<label class="switch mb-0">
																	<input type="checkbox" name="is_active" class="form-control blocked_active" value="1" data-id="{{ $record->id }}" {{ $record->is_active == 1 ? "checked" : "" }}>
																	<span class="slider round"></span>
																</label>
																<label class="form-check-label" for="flexSwitchCheckDefault">Active?</label>
															</div>
														</div>
													</div>
												</div>
												<div class="row w-100 m-0">
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group password-fieldd-lt">
															<?php
															echo Form::password('password',null,['class'=>'form-control inputText','required'=>false, 'placeholder' => 'Address']);
															echo Form::label('password', 'Enter driver password',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group password-fieldd-lt">
															<?php
															echo Form::password('confirm_password',null,['class'=>'form-control inputText','required'=>false, 'placeholder' => 'Address']);
															echo Form::label('confirm_password', 'Re-enter driver password',['class'=>'']);
															?>
														</div>
													</div>
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-12 col-12">
												<div class="img_user_settled h-100">
													<div class="view_image_user">
														@if (!empty($record->image) && file_exists('storage/'.$record->image))
														<img src="{{ env('URL_PUBLIC').'/'.$record->image }}" class="img-fluid w-100 img_user_face" />
														@else	
														<img src="{{ asset('assets/images/veldoo/avatar-2.png') }}" class="img-fluid w-100 img_user_face" />
														@endif
														<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
														<input type="file" name="fileUser" class="form-control hiddenForm" />
														<?php
														echo Form::file('image_tmp',['class'=>'form-control hiddenForm','required'=>false]);
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
<script>
var input = document.querySelector("#phone");
        var instance = window.intlTelInput(input, ({
            initialCountry: "{{ $record->country_code_iso ?? 'ch' }}",
            separateDialCode: true,
        }));
        input.addEventListener("countrychange", function() {
            $("#iso2").val(instance.getSelectedCountryData().iso2);
            $("#country_code").val(instance.getSelectedCountryData().dialCode);
        });
</script>
@stop