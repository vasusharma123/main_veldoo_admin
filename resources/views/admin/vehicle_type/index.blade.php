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
					
						
						<div class="" id="allDataUpdate">
							<div class="">
	<table class="table table-bordered data-table table-responsive" width="100%">
		<thead class="thead-light">
			<tr>
			<th>ID</th>
			<th>
				
				Car Type
			</th>
			<th>
				
				Price Per KM
			</th>
			<th>
				
				Basic Fee
			</th>
			<th>
				
				Alert Time
			</th>
			<th>
				
				Seating Capacity
			</th>
			
			
			<th>
				
				Mark As Default
			</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody id="">
			
			
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
</style>

<script type="text/javascript">
/*$(function () {
	$(function(){
	   $(".dropdown-menu").on('click', 'a', function(){
		   $(this).parents('.dropdown').find('button').text($(this).text());
	   });
	});
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
        var table = $('.data-table').DataTable({
            processing: false,
            serverSide: true,
           "lengthChange": false,
            ajax: "{{ url('admin/vehicle-type') }}",
               'columnDefs': [{
         'targets': [0,1,2,3,4,5,6,7],
         'searchable':true,
         'orderable':true,
          'className': 'dt-body-center text-center new-class',
             
      } 
      ],
         //   'order': [1, 'desc'],
		  
            columns: [
                // {
                    // data: 'id',
                    // name: 'id'
                // },

                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
				{
                    data: 'car_type',
                    name: 'car_type',
                    orderable: true, searchable: true
                },
               {
                    data: 'price_per_km',
                    name: 'price_per_km'
                },
                {
                    data: 'basic_fee',
                    name: 'basic_fee'
                },
                {
                    data: 'seating_capacity',
                    name: 'seating_capacity'
                },
                 {
                    data: 'alert_time',
                    name: 'alert_time'
                },
                {
                    data: 'status',
                    name: 'status'
                },
				{
                    data: 'action',
                    name: 'action'
                },
            ]
        });
    });

	$(document).on('click', '.change_status', function(e) {
		e.preventDefault();
		if ($(this).data('status') == 0) {
			var textMessage = "You want to make it default!";
			var confirmButton = "Make it default";
		} else {
			var textMessage = "You want to remove it from default!";
			var confirmButton = "Remove from default";
		}
		Swal.fire({
			title: 'Are you sure?',
			text: textMessage,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: confirmButton
		}).then((result) => {
			if (result.value) {
				Swal.fire({
					title: 'Success',
					text: "Default has been Success.",
					icon: 'success',
					showCancelButton: false,
					showConfirmButton: false
				});
				var vtype_id = $(this).attr('data-id');
				var status = $(this).attr('data-status');
				$.ajax({
					type: "post",
					url: "{{ url('admin/vehicle-type/change_status') }}",
					data: {
						"_token": "{{ csrf_token() }}",
						"vtype_id": vtype_id,
						"status": status
					},
					success: function(data) {

						if (data) {
							location.reload(true);
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
				Swal.fire({
					title: 'Deleted',
					text: "Vehicle type has been deleted.",
					icon: 'success',
					showCancelButton: false,
					showConfirmButton: false
				});
				var type_id = $(this).attr('data-id');

				$.ajax({
					type: "post",
					url: "{{ url('admin/vehicle-type/delete') }}",
					data: {
						"_token": "{{ csrf_token() }}",
						"type_id": type_id
					},
					success: function(data) {

						if (data) {
							location.reload(true);
						}
					}
				});
			}
		});
	});
</script>
@stop