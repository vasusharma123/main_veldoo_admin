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
				<div class="card" >
					<div class="card-body">
						@include('admin.layouts.flash-message')
						<div class="box" id="allDataUpdate">
							<div class="table-responsive">
                            <table class="table table-bordered data-table data-table" width="100%">
                                <thead class="thead-light">
                                    <tr>
                                    <th>ID</th>
                                    <th>
                                        Title
                                    </th>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Image
                                    </th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ $notification->id }}</td>
                                            <td>{{ $notification->title }}</td>
                                            <td>{{ $notification->description }}</td>
                                            <td>
                                                <img src="{{ asset('storage/push-notifications/3/notification-image.jpg') }}" alt="">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
table.dataTable td.dataTables_empty {
    text-align: center;
}
</style>
@stop