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
								<article class="container-fluid com_tabs">
									
									@include('admin.layouts.flash-message')
									
									{{ Form::open(array('url' => route('company.store'),'class'=>'','id'=>'','enctype' => 'multipart/form-data')) }}
									<div class="action_tabs">
										<a href="javascript:void(0);" class="action_tabs_btn company_profile active">Company Profile</a>
										<a href="javascript:void(0);" class="action_tabs_btn admin_profile">Admin Profile</a>
									</div>
									<div class="custom_form editForm company_edit" id="Editcompany">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-8 col-md-8 col-sm-12 col-12">
												<div class="row w-100 m-0">
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('name',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Name']);
															echo Form::label('name', 'Company Name',['class'=>'']);
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
															echo Form::text('phone',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => '1234']);
															echo Form::label('phone', 'Example: 123 456 7899',['class'=>'']);
															?>
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
													<div class="col-lg-6 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('street',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Enter Street']);
															echo Form::label('street', 'Street',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('zip',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Enter Post Code']);
															echo Form::label('zip', 'Enter Post Code',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('city',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Enter City']);
															echo Form::label('city', 'Enter City',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('state',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Enter State']);
															echo Form::label('state', 'Enter State',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('country',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Enter Country']);
															echo Form::label('country', 'Enter Country',['class'=>'']);
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
														<input type="file" name="company_image_tmp" class="form-control hiddenForm" />
													</div>
													
													<!--<div class="form-group">
														<input type="submit" value="Save" name="submit" class="form-control submit_btn"/>
													</div>-->
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-12 col-12">
												<div class="img_user_settled h-100">
													<div class="view_image_user">
														<img src="{{ asset('assets/images/veldoo/uploaded.png') }}" class="img-fluid w-100 img_user_face" />
														<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
														<input type="file" name="background_image" class="form-control hiddenForm" />
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="custom_form editForm admin_edit hiddenblock" id="EditAdmin">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-8 col-md-8 col-sm-12 col-12">
												<div class="row w-100 m-0">
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::text('admin_name',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Name']);
															echo Form::label('admin_name', 'Name',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-2 col-md-4 col-sm-4 col-4">
														<div class="form-group">
															<?php
															echo Form::text('admin_country_code',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => '91']);
															echo Form::label('admin_country_code', 'Example: 41',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-4 col-md-8 col-sm-8 col-8">
														<div class="form-group">
															<?php
															echo Form::text('admin_phone',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => '1234']);
															echo Form::label('admin_phone', 'Example: 123 456 7899',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::email('admin_email',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'user@email-address.com']);
															echo Form::label('admin_email', 'Example: Example: user@email-address.com',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-12">
														<div class="form-group password-fieldd-lt">
															<?php
															echo Form::password('password',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Address']);
															echo Form::label('password', 'Enter Password',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-12">
														<div class="form-group password-fieldd-lt">
															<?php
															echo Form::password('confirm_password',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Address']);
															echo Form::label('confirm_password', 'Re-enter Password',['class'=>'']);
															?>
														</div>
													</div>
													
												</div>
											</div>
											<div class="col-lg-4 col-md-4 col-sm-12 col-12">
												<div class="img_user_settled h-100">
													<div class="view_image_user">

														<img src="{{ asset('assets/images/veldoo/avatar-2.png') }}" class="img-fluid w-100 img_user_face diverSide" />
														<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
														<input type="file" name="image_tmp" class="form-control hiddenForm" />
													</div>
													
													<div class="form-group">
														<input type="submit" value="Save" name="submit" class="form-control submit_btn driver_side"/>
													</div>
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

@stop