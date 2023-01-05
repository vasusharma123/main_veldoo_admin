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
							
							{{ Form::open(array('url' => route('push-notifications.store'),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-4">
										<div class="col-md-8">
											<div class="form-group">
												<?php
													echo Form::label('Receiver', 'Receiver',['class'=>'control-label']);
												?>
												<select name="receiver" id="receiver" class="form-control" required>
													<option value="">---Select at least one---</option>
													<option value="1">All Users</option>
													<option value="2">All Drivers</option>
													<option value="3">All Drivers and Users</option>
												</select>
											</div>
											<div class="form-group">
												<?php
													echo Form::label('Title', 'Title',['class'=>'control-label']);
												?>
												<input type="text" name="title" class="form-control" required	>
											</div>
											<div class="form-group">
												<?php
													echo Form::label('Description', 'Description',['class'=>'control-label']);
												?>
												<textarea name="description" rows="5" class="form-control" required></textarea>
											</div>
											<div class="form-group">
												<?php
													echo Form::label('Image', 'Image',['class'=>'control-label']);
												?>
												<input type="file" name="image" class="form-control">
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