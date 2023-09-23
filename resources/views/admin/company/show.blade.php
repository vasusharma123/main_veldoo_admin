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
					<div class="card-body">
						@include('admin.layouts.flash-message')
						<div class="col-md-8">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td colspan="2">
											<h3>Company Information</h3>
										</td>
									</tr>
									<tr>
										<td><strong>Logo</strong></td>
										<td>
											@if(!empty($record->logo))
												<img src="{{url('storage/'.$record->logo)}}" height="50px" width="80px">
											@else
												<img src="{{ asset('no-images.png') }}" height="50px" width="80px">	
											@endif
										</td>
									</tr>
									<tr>
										<td><strong>Background Image</strong></td>
										<td>
											@if(!empty($record->background_image))
												<img src="{{url('storage/'.$record->background_image)}}" height="50px" width="80px">
											@else
												<img src="{{ asset('no-images.png') }}" height="50px" width="80px">	
											@endif
										</td>
									</tr>
									<tr>
										<td><strong>Company Name</strong></td>
										<td>{{ $record->name }}</td>
									</tr>
									<tr>
										<td><strong>Email</strong></td>
										<td>{{ $record->email }}</td>
									</tr>
									<tr>
										<td><strong>Phone</strong></td>
										<td>{{ $record->phone?$record->country_code:'' }} {{ $record->phone }}</td>
									</tr>
									<tr>
										<td><strong>State</strong></td>
										<td>{{ $record->state }}</td>
									</tr>
									<tr>
										<td><strong>City</strong></td>
										<td>{{ $record->city }}</td>
									</tr>
									<tr>
										<td><strong>Street</strong></td>
										<td>{{ $record->street }}</td>
									</tr>
									<tr>
										<td><strong>Zip Code</strong></td>
										<td>{{ $record->zip }}</td>
									</tr>
									<tr>
										<td><strong>Country</strong></td>
										<td>{{ $record->country }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Created at')}}</strong></td>
										<td>{{ $record->created_at }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Updated at')}}</strong></td>
										<td>{{ $record->updated_at }}</td>
									</tr>
									<tr>
										<td colspan="2">
											<h3>Admin Profile</h3>
										</td>
									</tr>
									<tr>
										<td><strong>Profile Picture</strong></td>
										<td>
											@if(!empty(@$record->user->image))
												<img src="{{url('storage/'.$record->user->image)}}" height="50px" width="80px">
											@else
												<img src="{{ asset('no-images.png') }}" height="50px" width="80px">	
											@endif
										</td>
									</tr>
									<tr>
										<td><strong>Email</strong></td>
										<td>{{ @$record->user->email }}</td>
									</tr>
									<tr>
										<td><strong>Name</strong></td>
										<td>{{ @$record->user->name }}</td>
									</tr>
									<tr>
										<td><strong>Phone</strong></td>
										<td>{{ @$record->user->phone?@$record->user->country_code:'' }} {{ @$record->user->phone }}</td>
									</tr>
								</table>
								<div class="form-actions">
									<a href="{{route( $route.'.index')}}" class="btn btn-inverse">{{trans('admin.Back')}}</a>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script type="text/javascript">
 $('body').on('click', '.approve', function(){
	    var id = $(this).attr('data-id'); 
		swal({
            title: "Are you sure you want to approve this Company?",
            text: "You can not rollback the Company status",
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