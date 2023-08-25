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
							
							{{ Form::open(array('url' => route('vouchers-offers.store'),'class'=>'form-horizontal form-material','id'=>'userCreate','enctype' => 'multipart/form-data')) }}
								<div class="form-body">
									<div class="row p-t-5">
										<div class="col-md-6">
											
											<div class="form-group">
												<?php
												echo Form::label('user_name', 'Username',['class'=>'control-label']);
												?>
												<select name="user" class="form-control">
												<option value="">Select User</option>
												@foreach($users as $user)
												<option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name?$user->last_name:''}}</option>
												@endforeach
												</select>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('title', 'Title',['class'=>'control-label']);
												echo Form::text('title',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('message', 'Message',['class'=>'control-label']);
												echo Form::text('message',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('mileage', 'Mileage',['class'=>'control-label']);
												echo Form::number('mileage',null,['class'=>'form-control','required'=>true,'min'=>1]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('start_date', 'Start Date',['class'=>'control-label']);
												echo Form::date('start_date',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
											<div class="form-group">
												<?php
												echo Form::label('end_date', 'End Date',['class'=>'control-label']);
												echo Form::date('end_date',null,['class'=>'form-control','required'=>true]);
												?>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
									<a href="{{ route('vouchers-offers.index') }}" class="btn btn-inverse">Cancel</a>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.js"></script>
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