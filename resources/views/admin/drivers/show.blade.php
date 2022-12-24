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
				<div class="card card-outline-info" >
				
					<div class="card-header">
						@if(!empty($action))
							<h4 class="m-b-0 text-white">{{ $action }}</h4>
						
						@endif
					</div>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#personal_detail" aria-controls="home" role="tab" data-toggle="tab">Personal Detail</a> | </li>
					<li role="presentation" class="active"><a href="#vehicle_detail" aria-controls="home" role="tab" data-toggle="tab">Vehicle Detail</a> | </li>
					<!--<li role="presentation"><a href="#car_images" aria-controls="profile" role="tab" data-toggle="tab">Car Images</a></li>-->
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="card-body tab-pane active" id="personal_detail">
						@include('admin.layouts.flash-message')
						<div class="col-md-8">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><strong>{{trans('admin.Image')}}</strong></td>
										<td>
											<?php echo Html::image(((!empty($record->image)) ? (config('app.url_public').'/'.$record->image) : asset('no-images.png')), 'sidebar logo', ['id' => 'previewimage', 'width' => '50', 'height' => '50']); ?>
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Email')}}</strong></td>
										<td>{{ $record->email }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Name')}}</strong></td>
										<td>{{ $record->first_name.' '.$record->last_name }}</td>
									</tr>
									{{-- <tr>
										<td><strong>{{trans('admin.First Name')}}</strong></td>
										<td>{{ $record->first_name }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Last Name')}}</strong></td>
										<td>{{ $record->last_name }}</td>
									</tr> --}}
									{{-- <tr>
										<td><strong>{{ __('Country Code') }}</strong></td>
										<td>{{ $record->country_code }}</td>
									</tr> --}}
									<tr>
										<td><strong>{{trans('admin.Phone')}}</strong></td>
										<td>{{ $record->country_code.'-'.$record->phone }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.City')}}</strong></td>
										<td>{{ $record->city }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.State')}}</strong></td>
										<td>{{ $record->state }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Street')}}</strong></td>
										<td>{{ $record->street }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Zip')}}</strong></td>
										<td>{{ $record->zip }}</td>
									</tr>
									<!--<tr>
										<td><strong>{{trans('admin.Gender')}}</strong></td>
										<td>{{ ($record->gender==1 ? 'Male' : 'Female') }}</td>
									</tr>
									<!--<tr>
										<td><strong>{{trans('admin.DOB')}}</strong></td>
										<td>{{ ($record->dob) }}</td>
									</tr>--->
									<tr>
										{{-- <td><strong>{{trans('admin.Status')}}</strong></td>
										<td>{{ ($status[$record->status] ? $status[$record->status] : 'N/A' ) }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Created at')}}</strong></td>
										<td>{{ $record->created_at }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.IP Address')}}</strong></td>
										<td>{{(!empty($record->log->other) ? json_decode($record->log->other)[0]->ip_address : 'N/A')}}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Updated at')}}</strong></td>
										<td>{{ $record->updated_at }}</td>
									</tr> --}}
								</table>
								<div class="form-actions">
									<a href="{{ route('users.drivers') }}" class="btn btn-inverse">Cancel</a>
									@if(!empty($record) && $record->verify==0)
									<a href="javascript:;" class="btn btn-success approve" data-id="{{$record->id}}">Approve</a>
								@endif
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="card-body tab-pane" id="vehicle_detail">
						@include('admin.layouts.flash-message')
						<div class="col-md-8">
							<div class="table-responsive">
								<table class="table table-bordered">
							<tr>
							<td><strong>Year</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->year:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Model</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->model:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Color</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->color:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Insurance Company</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->insurance_company:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Certificate Number</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->certificate_number:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Policy Number</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->policy_number:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Issue Date</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->issue_date:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Expiry Date</strong></td>
							<td>{{$record->driverVehicle?$record->driverVehicle->expiry_date:'N/A'}}</td>
							</tr>
							<tr>
							<td><strong>Driving License</strong></td>
							<td>
							@if(!empty($record->driverVehicle))
							<img src="{{$record->driverVehicle->driving_license}}" width="50" />
						@else
							
							<img src="{{asset('no-images.png')}}" width="50" />
						@endif
							</td>
							</tr>
							<tr>
							<td><strong>Vehicle RC</strong></td>
							<td>
							<img src="{{$record->driverVehicle?$record->driverVehicle->vehicle_rc:asset('no-images.png')}}" width="50" />
							</td>
							</tr>
							<tr>
							<td><strong>Vehicle Image</strong></td>
							<td>
							<img src="{{$record->driverVehicle?$record->driverVehicle->vehicle_image:asset('no-images.png')}}" width="50" />
							</td>
							</tr>
							<tr>
							<td><strong>Vehicle Number Plate</strong></td>
							<td>
							<img src="{{$record->driverVehicle?$record->driverVehicle->vehicle_number_plate:asset('no-images.png')}}" width="50" />
							</td>
							</tr>
							
								</table>
								<div class="form-actions">
									<a href="{{ route('users.drivers') }}" class="btn btn-inverse">Cancel</a>
									@if(!empty($record) && $record->verify==0)
									<a href="javascript:;" class="btn btn-success approve" data-id="{{$record->id}}">Approve</a>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="card-body tab-pane" id="car_images">
						@include('admin.layouts.flash-message')
						<div class="col-md-8">
							<div class="table-responsive">
								<table class="table table-bordered">
								dfgdgdgfdbvcv
								</table>
								<div class="form-actions">
									
								</div>
							</div>
						</div>
					</div>
				
				</div>
				</div>
			</div>
		</div>
		<!-- ============================================================== -->
		<!-- End PAge Content -->
		<!-- ============================================================== -->
	</div>
@endsection
<!-- ============================================================== -->
	<!-- End Container fluid  -->
@section('footer_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>   
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>  
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<style>
.sweet-alert h2 {
	font-weight: 300;
}
</style>
<script type="text/javascript">
 $('body').on('click', '.approve', function(){
	    var id = $(this).attr('data-id'); 
		swal({
            title: "Are you sure you want to approve this Driver?",
            text: "You can not rollback the Driver status",
            type: "warning",
            timer: 3000,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, approve it!",
            cancelButtonText: "No, cancel !",
            closeOnConfirm: true,
            closeOnCancel: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
        }, function (isConfirm) {
            if (isConfirm) {
			  $.ajax({
					type: "GET",
					url: "{{url()->current()}}",
					data : {id:id,type:'approve'},
					success: function (response) {
						var obj = response;
						toastr.success(obj.message);
						setTimeout(function(){ 
							location.reload();
						}, 2000);
					},
					error: function (jqXHR, exception) {
						var response = jqXHR.responseText;
						var obj = JSON.parse(response);
						var message = obj.message;
						if(obj.error){
							$.each(obj.error,function(index, value){
								toastr.error(value);
							});
						} else { 
							toastr.error(message);
						}
					}
				});
            }
        });
	});
	
	
	</script>
@stop