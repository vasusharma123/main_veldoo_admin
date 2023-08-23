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
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table table-bordered">
									<tr>
										<td><strong>Driver Name</strong></td>
										<td>{{ $record->driver->first_name }} {{ $record->driver->last_name }}</td>
									</tr>
									<tr>
										<td><strong>Rider Name</strong></td>
										<td>{{ $record->user->first_name }} {{ $record->user->last_name }}</td>
									</tr>
									<tr>
										<td><strong>Pickup Address</strong></td>
										<td>{{ $record->pickup_address }}</td>
									</tr>
									<tr>
										<td><strong>Destination Address</strong></td>
										<td>{{ $record->dest_address }}</td>
									</tr>
									<tr>
										<td><strong>Price</strong></td>
										<td>{{ $record->price }}</td>
									</tr>
									<tr>
										<td><strong>Payment Type</strong></td>
										<td>{{ $record->payment_type }}</td>
									</tr>
									
									<tr>
										<td><strong>Created at</strong></td>
										<td>{{ $record->created_at }}</td>
									</tr>
									<tr>
										<td><strong>Updated at</strong></td>
										<td>{{ $record->updated_at }}</td>
									</tr>
								</table>
								<div class="form-actions">
									<a href="{{route( $route.'.index')}}" class="btn btn-inverse">Back</a>
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
<style>
.table-responsive{
	overflow-x: scroll;
}
thead tr{
	white-space: nowrap;
}
</style>
<script>
	$('body').on('click', '.filter_apply', function(){
	var optionSelected = $("option:selected", this);
    var day =this.value;
		var url = "{{url()->current()}}";
		ajax_Call('','filter',day);
	});
	
	function ajax_Call(id=0,type='',day='') {
		var day= $('#ride_days').val();
	var page = (!page ? 1 : page);
	$.ajax({
		type: "GET",
		url: "{{url()->current()}}",
		data : {id:id,type:type,day:day},
		success: function (data) {
			$("#loading").fadeOut("slow");
			$('#allDataUpdate').html(data);
		}
	});
}
</script>
@stop