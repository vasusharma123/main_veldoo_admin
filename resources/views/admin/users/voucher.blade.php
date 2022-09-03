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
							
							{{ Form::model($record, array('url' => route( 'users.vouchersUpdate'),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
							@method('PATCH')
								<div class="form-body">							
									<div class="row">
										
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('mile_per_ride', 'Mile Per Ride(In percentage)',['class'=>'control-label']);
												echo Form::text('mile_per_ride',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
										
									</div>
									
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('mile_to_currency', 'Mile to Currency',['class'=>'control-label']);
												echo Form::text('mile_to_currency',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('mile_on_invitation', 'Mile on Invitation',['class'=>'control-label']);
												echo Form::text('mile_on_invitation',null,['class'=>'form-control','required'=>true]);
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
		<style>
		span.subtitle {
    font-size: 12px;
}
		</style>
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