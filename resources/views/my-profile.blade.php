@extends('admin.layouts.master')
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
								<h4 class="m-b-0 text-white">{{ $action }}</h4>
							@endif
						</div>
						<div class="card-body">
							@include('admin.layouts.flash-message')
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Name</label>
                                                <input type="text" name="name" value="{{ Auth::user()->name }}" placeholder="Enter name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-0">
                                                <label for="">Profile Picture</label>
                                                <input type="file" name="profile" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6 mb-2">
                                            <img width="100px" height="100px" src="{{ config('app.url_public').'/'.Auth::user()->image }}" class="profile-pic rounded" /> 
                                            {{-- <img src="{{ asset('user-profile/'.Auth::user()->image) }}"> --}}
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Email</label>
                                                <input type="email" name="email" value="{{ Auth::user()->email }}" placeholder="Enter email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Password</label>
                                                <input type="password" name="password" placeholder="Enter password" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-right">
                                            <button class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
		$('#store').validate();
	});
	$(document).ready(function () {
		$('#changePassword').validate();
	});
	function readURL(input,section){
		 if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#'+section+'-section #previewimage').attr('src', e.target.result);
				$('#'+section+'-section #previewimage').attr('height','50px');
				$('#'+section+'-section #previewimage').attr('width','50px');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	</script>
@stop