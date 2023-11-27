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
									
									<input name="page" type="hidden">
									
									<form class="custom_form editForm " id="EditDriver">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="row w-100 m-0">
													<div class="col-lg-10 col-md-10 col-sm-8 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="name" name="name" placeholder="Name" />
															<label for="name">Enter Payment Name</label>
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