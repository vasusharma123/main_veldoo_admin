@extends('admin.layouts.master')

@section('content')

	<div class="formTableContent">
		<section class="addEditForm sectionsform">
			<article class="container-fluid">
				{{ Form::open(array('url' => route('users.store'),'class'=>'custom_form editForm','id'=>'userCreate','enctype' => 'multipart/form-data')) }}
					<div class="row w-100 m-0 form_inside_row">
						<div class="col-lg-8 col-md-8 col-sm-12 col-12">
							<div class="row w-100 m-0">
								<div class="col-lg-6 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('first_name',$record->first_name,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Name']);
										echo Form::label('first_name', 'Enter First Name',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('last_name',$record->last_name,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Name']);
										echo Form::label('last_name', 'Enter Last Name',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-2 col-md-4 col-sm-4 col-4">
									<div class="form-group">
										<?php
										echo Form::text('country_code',$record->country_code,['class'=>'form-control inputText','required'=>true, 'placeholder' => '91']);
										echo Form::label('country_code', 'Example: 41',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-8 col-sm-8 col-8">
									<div class="form-group">
										<?php
										echo Form::text('phone',$record->phone,['class'=>'form-control inputText','required'=>true, 'placeholder' => '1234']);
										echo Form::label('phone', 'Example: 123 456 7899',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::email('email',$record->email,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'user@email-address.com']);
										echo Form::label('email', 'Example: Example: user@email-address.com',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('addresses',$record->addresses,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Address']);
										echo Form::label('addresses', 'Enter user address',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('zip',$record->zip,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Pin']);
										echo Form::label('zip', 'Enter postal code',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('city',$record->city,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'City']);
										echo Form::label('city', 'Enter user city',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-4 col-md-12 col-sm-12 col-12">
									<div class="form-group">
										<?php
										echo Form::text('country',$record->country,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Country']);
										echo Form::label('country', 'Enter user country',['class'=>'']);
										?>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-12">
							<div class="img_user_settled h-100">
								<div class="view_image_user">
									<?php
									$imgUrl = config('app.url_public').'/'.$record->image;
									
									//if(file_exists($imgUrl)){
										?>
										<img src="<?php echo $imgUrl; ?>" class="img-fluid w-100 img_user_face" />
										<?php
									//}
									?>
								</div>
								
								<!--<div class="form-group">
									<input type="submit" value="Save" name="submit" class="form-control submit_btn"/>
								</div>-->
							</div>
						</div>
					</div>
				{{ Form::close() }}
			</article>
		</section>
	</div>
					
@endsection	
	
@section('footer_scripts')

@stop