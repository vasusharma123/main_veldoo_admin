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
								@include('admin.layouts.flash-message')
								<article class="container-fluid">
									<form class="custom_form editForm" id="EditUser">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
												<div class="row w-100 m-0">
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="name" name="name" placeholder="Name" />
															<label for="name">Site Name</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="copyright" name="copyright" placeholder="Copyright" />
															<label for="copyright">Copyright</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="currency" name="currency" placeholder="Currency" />
															<label for="currency">Currency Symbol</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="currencyname" name="currencyname" placeholder="Currency Name" />
															<label for="currencyname">Currency Name</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="driverRequest" name="driverRequest" placeholder="Driver Request" />
															<label for="driverRequest">(We will send request to X drivers)</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="WaitingTime" name="WaitingTime" placeholder="Waiting Time" />
															<label for="WaitingTime">Driver will have time to accept Request(In seconds)</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="Radius" name="Radius" placeholder="Radius" />
															<label for="Radius">Driver will search in this radius(In Miles)</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="RadiusJoin" name="RadiusJoin" placeholder="Radius for Join rides" />
															<label for="RadiusJoin">User will see join rides in this radius(In Miles)</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="Idle" name="Idle" placeholder="Driver Idle Time(In minutes)" />
															<label for="Idle">After ___ minutes of staying idle, the driver receives a notification alert.</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="RideDistance" name="RideDistance" placeholder="Current ride distance addition (In miles)" />
															<label for="RideDistance">While searching for driver, if ride have no destination location than add ___ miles.</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="RideDistance" name="RideDistance" placeholder="Waiting ride distance addition (In miles)" />
															<label for="RideDistance">While searching for driver, if ride have no destination location of waiting ride than add ___ miles</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="RideDistance" name="RideDistance" placeholder="Delete only phone number users (In days)" />
															<label for="RideDistance">When creating a user from driver app by inputting only the phone number, will delete in ___ days</label>
														</div>
													</div>
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="RideDistance" name="RideDistance" placeholder="Delete only last name users (In days)" />
															<label for="RideDistance">When creating a user from driver app by inputting only the last name, will delete in ___ days</label>
														</div>
													</div>
													
													<div class="col-lg-4 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="RideDistance" name="RideDistance" placeholder="Driver count to Display" />
															<label for="RideDistance">Driver count to Display</label>
														</div>
													</div>
													
													<div class="col-lg-2 col-md-6 col-sm-6 col-6">
														<div class="form-group">
															<input type="color" style="height: 46px;" class="form-control inputText" id="RideDistance" name="RideDistance" placeholder="Driver count to Display" />
															<label for="RideDistance">Primary Color</label>
														</div>
													</div>
													<div class="col-lg-2 col-md-6 col-sm-6 col-6">
														<div class="form-group">
															<label class="mb-0" for="RideDistance"><b>Notification</b></label>
															<div class="switch_btn">
																<label class="switch">
																	<input type="checkbox">
																	<span class="slider round"></span>
																</label>
															</div>
															
														</div>
													</div>
													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="img_user_settled settings_images h-100 mx-0 my-3 text-center">
															<div class="view_image_user m-auto">
																<img src="{{ asset('assets/images/veldoo/uploaded.png') }}" class="img-fluid w-100 img_user_face" />
																<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
																<input type="file" name="bgImage" class="form-control hiddenForm " />
															</div>
															<label for="bgImage">Background Image</label>
														</div>
													</div>
													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="img_user_settled settings_images h-100 mx-0 my-3 text-center">
															<div class="view_image_user m-auto">
																<img src="{{ asset('assets/images/veldoo/uploaded.png') }}" class="img-fluid w-100 img_user_face" />
																<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
																<input type="file" name="logoImg" class="form-control hiddenForm " />
															</div>
															<label for="logoImg">Logo Image</label>
														</div>
													</div>
													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="img_user_settled settings_images h-100 mx-0 my-3 text-center">
															<div class="view_image_user m-auto">
																<img src="{{ asset('assets/images/veldoo/uploaded.png') }}" class="img-fluid w-100 img_user_face" />
																<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
																<input type="file" name="FavImag" class="form-control hiddenForm " />
															</div>
															<label for="FavImag">Favicon Image</label>
														</div>
													</div>
													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="img_user_settled settings_images h-100 mx-0 my-3 text-center">
															<div class="view_image_user m-auto">
																<img src="{{ asset('assets/images/veldoo/uploaded.png') }}" class="img-fluid w-100 img_user_face" />
																<img src="{{ asset('assets/images/veldoo/uploaded_icon.png') }}" class="img-fluid w-100 img_user_icon" />
																<input type="file" name="SidebarImage" class="form-control hiddenForm " />
															</div>
															<label for="SidebarImage">Sidebar Logo</label>
														</div>
													</div>
													
													
												</div>
											</div>
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="form-group">
													<input type="submit" value="Save" name="submit" class="form-control submit_btn mt-2" />
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