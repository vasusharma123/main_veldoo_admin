@extends('admin.layouts.master')

@section('content')
<style>
	.c-pagination {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
    }
    .filter-min
    {
        width: 150px !important;
    }
</style>
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
						<form action="" autocomplete="off">
                            <div class="d-flex">
                                {{-- <div class="form-group mr-2">
                                    <label for="">Start Date</label>
                                    <input type="text" id="min" value="{{ $start_date }}" class="filter-min" name="start_date">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="">End Date</label>
                                    <input type="text" id="max" value="{{ $end_date }}" class="filter-max" name="end_date">
                                </div> --}}
                                <div class="form-group mr-2">
                                    <label for="">Enter Keyword</label>
                                    <input type="text" class="filter-min" name="search" id="searchInput" placeholder="Search keyword" value="{{ isset($_GET) && isset($_GET['search'])?$_GET['search']:'' }}">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm">
                                        Search
                                    </button>
                                    @if (isset($_GET) && !empty($_GET))
                                        <a class="btn btn-success btn-sm" href="{{ route('company.index') }}">
                                            Clear
                                        </a>
                                    @endif
                                    {{-- <a class="btn btn-primary btn-sm exportBtn" href="javascript:;">
                                        Export
                                    </a> --}}
                                </div>
                            </div>
                        </form>
						<div class=" box" id="allDeataUpdate">
							<div class="table-responsive">
								<table class="table table-bordered data-dtable " width="100%">
									<thead class="thead-light">
										<tr>
										<th>ID</th>
										<th>
											Owner Name
										</th>
										<th>
											Owner Email
										</th>
										<th>
											Name
										</th>
										<th>
											Email
										</th>
										<th>
											Phone
										</th>
										<th>
											State
										</th>
										<th>
											City
										</th>
										<th>
											Country
										</th>
										<th>
											Status
										</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody>
										@foreach ($companies as $company)
											<tr>
												<td>{{ $company->id }}</td>
												<td>{{ @$company->user->name }}</td>
												<td>{{ @$company->user->email }}</td>
												<td>{{ $company->name }}</td>
												<td>{{ $company->email }}</td>
												<td>{{ $company->phone?($company->country_code.' '.$company->phone):'' }}</td>
												<td>{{ $company->state }}</td>
												<td>{{ $company->city }}</td>
												<td>{{ $company->country }}</td>
												<td>
													@if ($company->user)
														<div class="switch">
															<label>
																<input type="checkbox" class="change_status change_status{{@$company->user->id }}" data-status="{{ @$company->user->status }}" data-id="{{@$company->user->id }}" {{ (@$company->user->status === 1)?'checked':'' }}><span class="lever" data-id="{{ @$company->user->id }}" ></span>
															</label>
														</div>
													@endif
												</td>
												<td>
													<div class="btn-group dropright">
														<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action
														</button>
														<div class="dropdown-menu">	
															<a class="dropdown-item" href="{{ route('company.show',$company->id) }}"> {{  trans("admin.View") }}</a>
															<a class="dropdown-item" href="{{  route('company.edit',$company->id) }}"> {{ trans("admin.Edit") }}</a>
															<a class="dropdown-item delete_record" href="javascript:;" data-id="{{ $company->id }}"> {{  trans("admin.Delete") }}</a>
														</div>
													</div>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
								<div>
                                    {{ $companies->appends($_GET)->links('vendor.pagination.bootstrap-4-c') }}
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
	/*
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 1000;  //time in ms, 5 second for example
	var $input = $('.myInput');

	//on keyup, start the countdown
	$input.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	//on keydown, clear the countdown
	$input.on('keydown', function () {
		clearTimeout(typingTimer);
	});

	function doneTyping() {
		var text = $('.myInput').val();
		var orderby = $('input[name="orderBy"]').val().toString();
		var order = $('input[name="order"]').val().toString();
		$("#loading").fadeIn("slow");
		$('.input-append input[name="page"]').val(1);
		ajaxCall('', text, orderby, order, '');
	};
	
	$('body').on('click', '.custom-userData-sort', function(){
		
		var attrorderby = $(this).attr('orderby');
		var attrorder = $(this).attr('order');
		$('input[name="orderBy"]').val(attrorderby);
		$('input[name="order"]').val(attrorder);
		
		var text = $('.myInput').val();
		var orderby = $('input[name="orderBy"]').val().toString();
		var order = $('input[name="order"]').val().toString();
		var page = $('input[name="page"]').val();
		$("#loading").fadeIn("slow");
		ajaxCall('', text, orderby, order, page , '');
	});

	$('body').on('click', '.change_status', function(){
		var orderby = $('input[name="orderBy"]').val();
		var order = $('input[name="order"]').val();
		var page = $('input[name="page"]').val();
		var status = $(this).val();
		var id = $(this).attr('data-id');
		
		var text = $('.myInput').val();
		var orderby = $('input[name="orderBy"]').val();
		var order = $('input[name="order"]').val();
		$("#loading").fadeIn("slow");
		ajaxCall(id, text, orderby, order, page, status);
	});
	
	$('body').on('click', '.delete_record', function(){
        var id = $(this).attr('data-id');
		var text = $('.myInput').val();
		var orderby = $('input[name="orderBy"]').val();
		var order = $('input[name="order"]').val();
		var page = $('input[name="page"]').val();
        swal({
            title: "Are you sure?",
            text: "You want to delete this Record !",
            type: "warning",
            timer: 3000,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel !",
            closeOnConfirm: true,
            closeOnCancel: true,
            closeOnConfirm: true,
            showLoaderOnConfirm: true,
        }, function (isConfirm) {
            if (isConfirm) {
                $("#loading").fadeIn("slow");
				ajaxCall(id, text, orderby, order, page, '','delete');
            } else {
                swal();
            }
        });
    });
});
function ajaxCall(id=0, text='', orderby, order, page=1 , status='',type='') {
	var page = (!page ? 1 : page);
	$.ajax({
		type: "GET",
		url: "{{url()->current()}}",
		data : {id:id,text:text,orderby:orderby,order:order,status:status,page:page,type:type},
		success: function (data) {
			$("#loading").fadeOut("slow");
			$('#allDataUpdate').html(data);
			
			$('.custom-userData-sort[orderBy="'+orderby+'"] > i').removeClass('fa-sort fa-sort-desc fa-sort-asc').addClass('fa-sort-'+order);
			$('.custom-userData-sort[orderby="'+orderby+'"]').attr('order', (order=='asc' ? 'desc' : 'asc'));
		}
	});
}
*/
$(function() {
    //     var table = $('.data-table').DataTable({
    //         processing: false,
    //         serverSide: true,
    //        ajax: "{{ url('admin/company') }}",
    //            'columnDefs': [{
    //     //  'targets': [0,1,2,3,4,5,6],
    //      'searchable':true,
    //      'orderable':true,
    //       'className': 'dt-body-center text-center new-class',
             
    //   } 
    //   ],
       
    //      //   'order': [1, 'desc'],
		  
    //         columns: [
    //             // {
    //                 // data: 'id',
    //                 // name: 'id'
    //             // },

    //             {data: 'id', name: 'id', orderable: true, searchable: true},
	// 			{
    //                 data: 'name',
    //                 name: 'name',
    //                 orderable: true, searchable: true
    //             },
               
    //             {
    //                 data: 'email',
    //                 name: 'email'
    //             },
    //             {
    //             	data:'country_code_phone',
    //             	name:'country_code_phone'
    //             },
    //             // {
    //             //     data: 'phone',
    //             //     name: 'phone'
    //             // },
	// 			{
    //                 data: 'state',
    //                 name: 'state'
    //             },
	// 			{
    //                 data: 'city',
    //                 name: 'city'
    //             },
    //             {
    //                 data: 'country',
    //                 name: 'country'
    //             },
                
    //              {
    //                 data: 'status',
    //                 name: 'status'
    //             },
	// 			{
    //                 data: 'action',
    //                 name: 'action'
    //             },
                
    //         ],
    //         dom: 'Bfrtip',
    //     buttons: [
    //         'excel', 'pageLength'
    //     ],  
    //     });
});

	$(document).on('click', '.change_status', function(e) {
		e.preventDefault();
		isChecked = $(this).is(":checked");
		Swal.fire({
			title: 'Are you sure?',
			text: "You want to change its status!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, change it'
		}).then((result) => {
			if (result.value) {
				var user_id = $(this).attr('data-id');
				// var status = $(this).attr('data-status');
				$.ajax({
					type: "post",
					url: "{{ url('admin/company/change_status') }}",
					data: {
						"_token": "{{ csrf_token() }}",
						"user_id": user_id,
						"status": isChecked
					},
					success: function(data) {
						if (!data) {
							// Swal.fire({
							// 	title: 'Success',
							// 	text: "The status has been changed.",
							// 	icon: 'success',
							// 	showConfirmButton: false
							// });
							// setTimeout(function() {
							// 	location.reload(true);
							// }, 2000);
							Swal.fire({
								title: 'Error',
								text: "Something went wrong please try again.",
								icon: 'error',
								showConfirmButton: false
							});
						}
						else
						{
							// checkedStatus = (isChecked?false:true);
							$('.change_status'+user_id).prop("checked",isChecked);
						}
					}
				});
			}
		});
	});

	$(document).on('click', '.delete_record', function() {
		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				var company_id = $(this).attr('data-id');

				$.ajax({
					type: "post",
					url: "{{ url('admin/company/delete') }}",
					data: {
						"_token": "{{ csrf_token() }}",
						"company_id": company_id
					},
					success: function(data) {
						if (data.status=="1") {
							Swal.fire({
								title: 'Deleted',
								text: "Company has been deleted.",
								icon: 'success',
								showCancelButton: false,
								showConfirmButton: false
							});
							setTimeout(function() {
								location.reload(true);
							}, 2000);
						}
					}
				});
			}
		});
	});


</script>
@stop