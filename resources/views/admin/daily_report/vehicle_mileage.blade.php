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
									{{ Form::open(array('url' => route('daily-report.vehicle_mileage_export'),'class'=>'custom_form editForm','id'=>'userCreate','enctype' => 'multipart/form-data')) }}
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="row w-100 m-0">
													
													<div class="col-lg-5 col-md-6 col-sm-6 col-12">
														<div class="form-group">
															<?php
															echo Form::label('start_date', 'Start Date',['class'=>'']);
															echo Form::date('start_date',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'Start Date']);
															?>
														</div>
													</div>
													
													<div class="col-lg-5 col-md-6 col-sm-6 col-12">
														<div class="form-group">
															<?php
															echo Form::label('end_date', 'End Date',['class'=>'']);
															echo Form::date('end_date',null,['class'=>'form-control inputText','required'=>true, 'placeholder' => 'End Date']);
															?>
														</div>
													</div>
													<div class="col-lg-2 col-md-12 col-sm-12 col-12 align-self-end">
														<div class="form-group">
															<button class="btn submit_btn searchbtn exportbtn w-100" type="submit">Export </button>
														</div>
													</div>
												   
												</div>
											</div>
										</div>
									</form>
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