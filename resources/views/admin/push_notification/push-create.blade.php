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
									<form class="custom_form editForm " id="EditCarType">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-8 col-md-8 col-sm-12 col-12">
												<div class="row w-100 m-0">

													<div class="col-lg-6 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<select class="form-select inputText" id="Receiver" name="Receiver">
																<option value="">-- Select at least one --</option>
																<option value="all_users">All Users</option>
																<option value="all_drivers">All Drivers</option>
																<option value="all_companies">All Companies</option>
																
															</select>
															<label for="city">Receiver</label>
														</div>
													</div>
													<div class="col-lg-6 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="enterName" name="enterName" placeholder="Title" />
															<label for="enterName">Enter Title</label>
														</div>
													</div>
													<div class="col-lg-12 col-md-12 col-sm-12 col-12">
														<div class="form-group">
															<textarea type="text" class="form-control inputText" id="Description" name="Description" ></textarea>
															<label for="Description">Description</label>
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
													</div>
													
													<div class="form-group">
														<input type="submit" value="Save" name="submit" class="form-control submit_btn carSide"/>
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