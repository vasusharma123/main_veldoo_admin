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
										<td><strong>{{trans('admin.Image')}}</strong></td>
										<td>
											@if(!empty($record->image))
											<img src="{{url('storage/app/public/'.$record->image)}}" height="50px" width="80px">
											@else
											<img src="{{ asset('no-images.png') }}" height="50px" width="80px">	
										@endif
										</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Email')}}</strong></td>
										<td>{{ $record->email }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('Company name')}}</strong></td>
										<td>{{ $record->name }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('Country code')}}</strong></td>
										<td>{{ $record->country_code }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('Phone')}}</strong></td>
										<td>{{ $record->phone }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('Country')}}</strong></td>
										<td>{{ $record->country }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('State')}}</strong></td>
										<td>{{ $record->state }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('City')}}</strong></td>
										<td>{{ $record->city }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('Zip')}}</strong></td>
										<td>{{ $record->zip }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('Address')}}</strong></td>
										<td>{{ $record->address }}</td>
									</tr>
								
									
									<tr>
										<td><strong>{{trans('admin.Created at')}}</strong></td>
										<td>{{ $record->created_at }}</td>
									</tr>
									<tr>
										<td><strong>{{trans('admin.Updated at')}}</strong></td>
										<td>{{ $record->updated_at }}</td>
									</tr>
								</table>
								<div class="form-actions">
									<a href="{{route( $route.'.index')}}" class="btn btn-inverse">{{trans('admin.Back')}}</a>
								@if(!empty($record) && $record->verify==0)
									<a href="javascript:;" class="btn btn-success approve" data-id="{{$record->id}}">Approve</a>
								@endif
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