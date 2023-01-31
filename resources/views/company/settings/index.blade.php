@extends('company.layouts.app')
@section('content')
		<!-- Container fluid  -->
		<!-- ============================================================== -->
		<div class="container-fluid">
			<!-- ============================================================== -->
			<!-- Start Page Content -->
			<!-- ============================================================== -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card card-outline-info">
						<div class="card-header">
							@if(!empty($action))
								<h4 class="m-b-0">{{ $action }}</h4>
							@endif
						</div>
						<div class="card-body">
							@include('admin.layouts.flash-message')
							<ul class="nav nav-tabs" id="myTab" role="tablist">
								<li class="nav-item" role="presentation">
								  <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="home" type="button" role="tab" aria-controls="home" aria-selected="true">Company Information</button>
								</li>
								<li class="nav-item" role="presentation">
								  <button class="nav-link text-dark" id="profile-tab" data-toggle="tab" data-target="profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Admin Profile</button>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<div class="p-3">
										<form method="POST" action="{{ route('company.updateCompanyInformation') }}" enctype="multipart/form-data">
											@csrf
											<div class="row">
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Logo</label>
														<input type="file" name="logo" class="form-control">
														@if (@$company->logo)
															<img src="{{ env('URL_PUBLIC').'/'.$company->logo }}" width="200px" height="150px" alt="" srcset="">
														@endif
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Background Image</label>
														<input type="file" name="background_image" class="form-control">
														@if (@$company->background_image)
															<img src="{{ env('URL_PUBLIC').'/'.$company->background_image }}" width="200px" height="150px" alt="" srcset="">
														@endif
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Name</label>
														<input type="text" name="name" value="{{ @$company->name }}" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Email</label>
														<input type="email" name="email" value="{{ @$company->email }}" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Phone</label>
														<input type="text" name="phone" value="{{ @$company->phone }}" id="RegAlterenatePhones" class="form-control" required>
														<input type="hidden" name="country_code" value="{{ @$company->country_code }}" class="second_country_code">
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">City</label>
														<input type="text" name="city" value="{{ @$company->city }}" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">State</label>
														<input type="text" name="state" value="{{ @$company->state }}" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Street</label>
														<input type="text" name="street" value="{{ @$company->street }}" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Zip Code</label>
														<input type="text" name="zip_code" value="{{ @$company->zip }}" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Country</label>
														<input type="text" name="country" value="{{ @$company->country }}" class="form-control" required>
													</div>
												</div>
												<div class="col-12 text-center">
													<button class="save_btn btn">Update</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
									<div class="p-3">
										<form action="{{ route('company.updatePersonalInformation') }}" method="POST" enctype="multipart/form-data">
											@csrf
											<div class="row">
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Profile Picture</label>
														<input type="file" name="image" class="form-control">
														@if (Auth::user()->image)
															<img src="{{ env('URL_PUBLIC').'/'.Auth::user()->image }}" width="200px" height="150px" alt="" srcset="">
														@endif
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Name</label>
														<input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Email</label>
														<input type="email" name="email" value="{{ Auth::user()->email }}"  class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Phone</label>
														<input type="text" name="phone" value="{{ Auth::user()->phone }}" id="Regphones" class="form-control" required>
														<input type="hidden" name="country_code" value="{{ Auth::user()->country_code }}" class="country_code">
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Password</label>
														<input type="text" name="password" class="form-control">
														<span class="text-gray" style="font-size: 12px">Enter Password If you want to change</span>
													</div>
												</div>
												<div class="col-12 text-center">
													<button class="save_btn btn">Update</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- End PAge Content -->
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- End Container fluid  -->
@endsection

@section('footer_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>   
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>  
<script type="text/javascript">
	$(document).ready(function () {
		$('#userCreate').validate();
	});
	function readURL(input){
		 if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#previewimage').attr('src', e.target.result);
				$('#previewimage').attr('height','50px');
				$('#previewimage').attr('width','50px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$(document).on('click','.nav-link',function(){
		$('.nav-link').removeClass('active');
		$(this).addClass('active');
		$('.tab-pane').removeClass('show active');
		$('#'+$(this).data('target')).addClass('show active')
	});
	@if (@$company->phone)
		input_edit = $('#RegAlterenatePhones').intlTelInput("setNumber","+{{ $company->country_code.$company->phone }}");
		input_edit.on("countrychange", function() {
			$(".second_country_code").val($("#RegAlterenatePhones").intlTelInput("getSelectedCountryData").dialCode);
		});
	@endif
	@if (Auth::user()->name)
		input_edit = $('#Regphones').intlTelInput("setNumber","+{{ Auth::user()->country_code.Auth::user()->phone }}");
		input_edit.on("countrychange", function() {
			$(".country_code").val($("#Regphones").intlTelInput("getSelectedCountryData").dialCode);
		});
	@endif
	</script>
@stop