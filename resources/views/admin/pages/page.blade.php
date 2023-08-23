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
								<h4 class="m-b-0 text-white pull-left">{{ $action }}</h4>
							@endif
							@if(!empty($previewRoute))
							<a class="btn btn-primary btn-sm pull-right active" href="{{route( $previewRoute)}}" target="_blank">Preview</a>
							@endif
						</div>
						<div class="card-body">
							@include('admin.layouts.flash-message')
							
							{{ Form::model($record, array('url' => route( $route.'.store' ),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
							@method('PATCH')
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-8">
											<div class="form-group">
												<?php
												echo Form::label('title', 'Title',['class'=>'control-label']);
												echo Form::text('title',null,['class'=>'form-control','required'=>true]);
												echo Form::hidden('type',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('content', 'Description',['class'=>'control-label']);
												echo Form::textarea('content',null,['class'=>'form-control ckeditor','required'=>true,'style'=>'width:99.8%;']);
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
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
		
	</script>
@stop