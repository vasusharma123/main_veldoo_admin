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
							<section class="addonTable sectionsform pt-2">
								@include('admin.layouts.flash-message')
								<article class="container-fluid">
									
									<form class="custom_form editForm " id="EditDriver">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="row w-100 m-0">
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="name" name="name" placeholder="Template Title" />
															<label for="name">SMS Title</label>
														</div>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<label for="name" style="font-size: 14px; font-weight: 600;">Please put this tag #OTP#. where you want to add otp number</label>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-12">
														<div class="form-group">
															<textarea type="text" class="form-control inputText" id="ENG" name="ENG" placeholder="SMS in English"></textarea>
															<label for="ENG">SMS in English</label>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-6 col-12">
														<div class="form-group">
															<textarea type="text" class="form-control inputText" id="GRM" name="GRM" placeholder="SMS in German"></textarea>
															<label for="GRM">SMS in German</label>
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