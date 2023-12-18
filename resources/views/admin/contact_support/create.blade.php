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
							<section class="addonTable sectionsform">
								@include('admin.layouts.flash-message')
								<article class="container-fluid">
									{{ Form::open(array('url' => route( $route.'.store'),'class'=>'custom_form editForm','id'=>'sendEmail','enctype' => 'multipart/form-data')) }}
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="row w-100 m-0">
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															$typeArray = array('0' => '--Select at least one--', '1' => 'Users', '2' => 'Drivers', '3' => 'Companies');
															echo Form::select('user', $typeArray,null,['class'=>'form-select inputText','required'=>true]);
															echo Form::label('user', 'Users',['class'=>'']);
															?>
														</div>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<?php
															echo Form::textarea('message',null,['class'=>'form-control inputText ckeditor','required'=>true, 'placeholder' => 'Message']);
															echo Form::label('message', 'Message',['class'=>'']);
															?>
														</div>
													</div>
													
													<div class="col-lg-12 col-md-12 col-sm-4 col-4 pe-0">
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
					</div>
					
				</div>
			</div>
		</div>
	</div>
</main>
@endsection