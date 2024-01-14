@extends('admin.layouts.master')

@section('content')

	<div class="formTableContent">
		<section class="addonTable sectionsform pt-2">
			@include('admin.layouts.flash-message')
			<article class="container-fluid">
				
				{{ Form::open(array('url' => route('sms-template.store'),'class'=>'custom_form editForm','id'=>'createTemplate','enctype' => 'multipart/form-data','autocomplete'=>"off",'role'=>"presentation")) }}
				
					<div class="row w-100 m-0 form_inside_row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="row w-100 m-0">
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('title',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Template Title']);
										echo Form::label('title', 'SMS Title',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<label for="name" style="font-size: 14px; font-weight: 600;">Please put this tag #OTP#. where you want to add otp number</label>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<?php
										echo Form::textarea('english_content',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'SMS in English']);
										echo Form::label('english_content', 'SMS in English',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<?php
										echo Form::textarea('german_content',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'SMS in German']);
										echo Form::label('german_content', 'SMS in German',['class'=>'']);
										?>
									</div>
								</div>
								
								<div class="col-lg-12 col-md-12 col-sm-12 col-12 pe-0">
									<div class="img_user_settled h-100">
										
										<div class="form-group">
											<input type="submit" value="Save" name="submit" class="form-control submit_btn mt-1"/>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
				{{ Form::close() }}
			</article>
		</section>
	</div>
					
@endsection	