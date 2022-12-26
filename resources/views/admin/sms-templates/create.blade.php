@extends('admin.layouts.master')
@section('content')
<style>
	.iti-flag{
		background-image:url("{{asset('assets/images/flags.png')}}") !important;
	}
	@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx){
		.iti-flag{
			background-image:url("{{asset('assets/images/flags@2x.png')}}") !important;
		}
	}
</style>
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
							<h4 class="m-b-0 text-white">{{ __('Add New Template') }}</h4>
						</div>
						<div class="card-body">
						  @if(Session::has('error'))
							  <div  class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								   <span aria-hidden="true">&times;</span>
								 </button>
							   </div>
							@endif 
							@if(Session::has('success'))
							  <div   class="alert {{ Session::get('alert-class', 'alert-success') }}">{!! session('success') !!}
								 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
								   <span aria-hidden="true">&times;</span>
								 </button>
							   </div>
				        @endif							
							{{ Form::open(array('url' => route('sms-template.store'),'class'=>'form-horizontal form-material','id'=>'userCreate','enctype' => 'multipart/form-data','autocomplete'=>"off",'role'=>"presentation")) }}
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
											<div class="form-group">
												<label for="title" class="control-label">Template Title</label>
												<input type="text" name="title" class="form-control" placeholder="" required>
												@error('title')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror  
											</div>
										</div>
										<div class="col-12">
											<h6 style="color: gray">Please put this tag <strong>#OTP#</strong>,<strong>#TIME#</strong>,<strong>#LINK#</strong>. where you want to add otp number</h6>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="title" class="control-label">SMS in English</label>
												<textarea name="english_content" class="form-control" required></textarea>
												@error('english_content')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror  
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="title" class="control-label">SMS in German</label>
												<textarea name="german_content" class="form-control" required></textarea>
												@error('german_content')
													<span class="invalid-feedback" role="alert">
														<strong>{{ $message }}</strong>
													</span>
												@enderror 
											</div>
										</div>
										<div class="col-md-12 text-center">
											<div class="form-actions">
												<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
												<a href="{{route('sms-template.index')}}" class="btn btn-inverse">Cancel</a>
											</div>
										</div>
									</div>
								</div>
							 {{ Form::close() }}
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

<style type="text/css">
	.invalid-feedback {
		display: block !important;
	}
</style> 


<script type="text/javascript">
	$(function(){
		$('#userCreate').hide();
		
		setTimeout(function(){
			$('[autocomplete=off]').val('');
			$('#userCreate').show();
			var myStr = $("#Regphones").val().replaceAll(/-/g, "").replaceAll(" ", "");
			$("#Regphones").removeAttr('placeholder');
			$("#Regphones").val(myStr);
		}, 500);
	});
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

	$('.flag-container').click(function(){
		var data = $('.selected-dial-code').html();
		$("#test1").val(data);
	});


	</script>
@stop