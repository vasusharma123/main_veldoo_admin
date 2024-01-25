@extends('admin.layouts.master')

@section('content')

	<div class="formTableContent">
		<section class="addonTable sectionsform">
			@include('admin.layouts.flash-message')
			<article class="container-fluid">
				
				<input name="page" type="hidden">
				
				{{ Form::open(array('url' => route('payment-method.store'),'class'=>'custom_form editForm','id'=>'paymentManagementCreate','enctype' => 'multipart/form-data')) }}
					<div class="row w-100 m-0 form_inside_row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="row w-100 m-0">
								<div class="col-lg-10 col-md-10 col-sm-8 col-12">
									<div class="form-group">
										<?php
										echo Form::text('name',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Name']);
										echo Form::label('name', 'Enter Payment Name',['class'=>'']);
										?>
									</div>
								</div>
								<div class="col-lg-2 col-md-2 col-sm-12 col-12">
									<div class="img_user_settled h-100">
										
										<div class="form-group">
											<input type="submit" value="Add" name="submit" class="form-control submit_btn mt-1"/>
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