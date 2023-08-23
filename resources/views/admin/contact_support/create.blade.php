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
							
							{{ Form::open(array('url' => route( $route.'.store'),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-4">
										<div class="col-md-8">
										<div class="form-group">
												<?php
												echo Form::label('user', 'Users',['class'=>'control-label']);
											//	echo Form::text('name',null,['class'=>'form-control','required'=>true]);
												?>
												<select name="user" id="user" class="form-control">
												<option value="">---Select at least one---</option>
												<option value="1">Users</option>
												<option value="2">Drivers</option>
												<option value="4">Companies</option>
												</select>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('message', 'Message',['class'=>'control-label']);
												echo Form::textarea('message',null,['class'=>'form-control ckeditor','required'=>true,'style'=>'width:99.8%;']);
												?>
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
	$(document).ready(function () {
		$('#store').validate();
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
	/*
	$("#user").select2({
  templateResult: formatState
});
function formatState (state) {
  $.ajax({  
 url:"{{url('admin/get_users')}}",
type: 'GET',  
  success: function(data) {  
    $.each(data,function(key,value){
		          $("#user").append('<option value="'+value.id+'">'+value.first_name+'</option>');
		        });             
  }  
});  
};*/
	</script>
@stop