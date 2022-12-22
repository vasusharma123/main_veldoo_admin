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
						<div class=" box" id="allDataUpdate">
							@if (isset($_GET) && isset($_GET['add']) && $_GET['add']=="true")
								<div class="text-right mb-2">
									<a href="{{ route('sms-template.create') }}" class="btn btn-info">
										<em class="fa fa-plus"></em> Add
									</a>
								</div>
							@endif
							<div class="table-responsive">
								<table class="table table-bordered data-table">
									<thead class="thead-light">
										<tr>
											<th>ID</th>
											<th>Template Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($templates as $template)
											<tr>
												<td>{{ $template->id }}</td>
												<td>{{ $template->title }}</td>
												<td>
													<a href="{{ route('sms-template.edit',$template) }}" class="btn btn-info">
														<em class="fa fa-pencil"></em>
													</a>
												</td>
											</tr>
										@empty
											
										@endforelse
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
<script type="text/javascript">
$(function () {
	$(function(){
	   $(".dropdown-menu").on('click', 'a', function(){
		   $(this).parents('.dropdown').find('button').text($(this).text());
	   });
	});
});	
</script>
@stop