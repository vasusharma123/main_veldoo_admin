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
								  <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Company Information</button>
								</li>
								<li class="nav-item" role="presentation">
								  <button class="nav-link text-dark" id="profile-tab" data-toggle="tab" data-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Admin Profile</button>
								</li>
							</ul>
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<div class="p-3">
										<form action="">
											<div class="row">
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Photo</label>
														<input type="file" name="" class="form-control">
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Name</label>
														<input type="text" name="" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Email</label>
														<input type="text" name="" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Phone</label>
														<input type="text" name="" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">State</label>
														<input type="text" name="" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Street</label>
														<input type="text" name="" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Zip Code</label>
														<input type="text" name="" class="form-control" required>
													</div>
												</div>
												<div class="col-4 mb-3">
													<div class="form-group">
														<label for="">Country</label>
														<input type="text" name="" class="form-control" required>
													</div>
												</div>
												<div class="col-12 text-center">
													<button class="save_btn btn">Update</button>
												</div>
											</div>
										</form>
									</div>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
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
	</script>
@stop