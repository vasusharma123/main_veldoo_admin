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
							@if(!empty($action))
								<h4 class="m-b-0 text-white">{{ $action }}</h4>
							@endif
						</div>
						<div class="card-body">
							@include('admin.layouts.flash-message')
							{{ Form::open(array('url' => route('managers.store'),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-4">
										<div class="col-md-8">
											<div class="form-group">
												<label for="" class="control-label">Name</label>
                                                <input type="text" name="name" class="form-control" required>
											</div>
											<div class="form-group">
												<label for="" class="control-label">Email</label>
                                                <input type="email" name="email" class="form-control" required>
											</div>
											<div class="" style="margin-bottom:20px">
                                                <label for="" class="control-label">Phone</label>
                                                <input type="text" name="phone" id="Regphones" class="form-control">
												<input type="hidden" value="+1" id="test1" name="country_code" />
											</div>
                                            <div class="form-group">
												<label for="" class="control-label">Password</label>
                                                <input type="password" name="password" class="form-control" required>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
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
<script type="text/javascript">
	$('.flag-container').click(function(){
		var data = $('.selected-dial-code').html();
		$("#test1").val(data);
    });
    $(function(){
		setTimeout(function(){
			$('[autocomplete=off]').val('');
			$('#userCreate').show();
			var myStr = $("#Regphones").val().replaceAll(/-/g, "").replaceAll(" ", "");
			$("#Regphones").removeAttr('placeholder');
			$("#Regphones").val(myStr);
		}, 500);
	});
</script>
@stop