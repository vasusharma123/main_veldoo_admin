@extends('admin.layouts.master')

@section('content')

	<div class="formTableContent">
		<section class="addonTable sectionsform">
			@include('admin.layouts.flash-message')
			<article class="container-fluid">
				{{ Form::open(array('url' => route('push-notifications.store'),'class'=>'custom_form editForm','id'=>'store','enctype' => 'multipart/form-data')) }}
					<div class="row w-100 m-0 form_inside_row">
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<div class="row w-100 m-0">

								<div class="col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group">
										<?php
										$typeArray = array('0' => '--Select at least one--', '1' => 'All Users', '2' => 'All Drivers', '3' => 'All Drivers and Users');
										echo Form::select('receiver', $typeArray, null, ['class'=>'form-select inputText', 'required'=>true]);
										echo Form::label('receiver', 'Receiver',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('title',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Title']);
										echo Form::label('title', 'Title',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::textarea('description',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Description']);
										echo Form::label('description', 'Description',['class'=>'']);
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
									echo Form::file('image',['class'=>'form-control hiddenForm']);
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