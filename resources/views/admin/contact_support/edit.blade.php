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
						@if(!empty($action))
							<div class="card-header">
								<h4 class="m-b-0 text-white">{{ $action }}</h4>
							</div>
						@endif
						<div class="card-body">
							@include('admin.layouts.flash-message')
							
							{{ Form::model($record, array('url' => route( $route.'.update', $record->id ),'class'=>'form-horizontal form-material','id'=>'store','enctype' => 'multipart/form-data')) }}
							@method('PATCH')
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
											<div class="form-group">
												<?php
												echo Form::label('name', 'Name',['class'=>'control-label']);
												echo Form::text('name',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('status', 'Status',['class'=>'control-label']);
												echo Form::select('status', array('1' => 'Active', '0' => 'In-active'),null,['class'=>'form-control custom-select','required'=>true]);
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<a href="{{route( $route.'.index')}}" class="btn btn-inverse">Cancel</a>
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
</script>
@stop