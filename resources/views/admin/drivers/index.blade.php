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
							<div class="">
	<table class="table table-bordered data-table table-responsive data-table" width="100%">
		<thead class="thead-light">
			<tr>
			<th>ID</th>
			<th>
				
				First Name
			</th>
			<th>
				
				Last Name
			</th>
			<th>
				
				Email
			</th>
			<th>Country Code</th>
			<th>
				
				Phone
			</th>
			<th>
				
				Master Driver
			</th>
			<th>
				
				Status
			</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
			
			
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

	$('body').on('click', '.change_is_master', function(){
		var orderby = $('input[name="orderBy"]').val();
		var order = $('input[name="order"]').val();
		var page = $('input[name="page"]').val();
		var is_master = $(this).val();
		var id = $(this).attr('data-id');
		
		var text = $('.myInput').val();
		var orderby = $('input[name="orderBy"]').val();
		var order = $('input[name="order"]').val();
		$("#loading").fadeIn("slow");
		ajaxCall(id, text, orderby, order, page, is_master);
	});
	
	function ajaxCall(id=0, text='', orderby, order, page=1 , is_master='',type='') {
		var page = (!page ? 1 : page);
		$.ajax({
			type: "GET",
			url: "{{url()->current()}}",
			data : {id:id,text:text,orderby:orderby,order:order,is_master:is_master,page:page,type:type},
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
           ajax: "{{ url('admin/drivers') }}",
               'columnDefs': [{
         'targets': [0,1,2,3,4,5,6,7,8],
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
                    data: 'first_name',
                    name: 'first_name',
                    orderable: true, searchable: true
                },
               {
                    data: 'last_name',
                    name: 'last_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                	data:'country_code',
                	name:'country_code'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'master_driver',
                    name: 'master_driver'
                },
                 {
                    data: 'status',
                    name: 'status'
                },
				{
                    data: 'action',
                    name: 'action'
                },
                
            ],
            dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],  
        });
    });

$(document).on('click','.change_status',function(e){
	    e.preventDefault();
	    Swal.fire({
	        title: 'Are you sure?',
	        text: "Are you sure it's change status ?",
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes, its!'
	    }).then((result) => {
	        if (result.value) {
	            Swal.fire({
					title: 'Success',
					text: "Status has been changed Success.",
					icon: 'success',
					showCancelButton: false,
				    showConfirmButton: false}	                
	            );
	            var user_id = $(this).attr('data-id');
	            var status = $(this).attr('data-status');
    		    $.ajax({
    		        type: "post",
    		        url: "{{ url('admin/company/change_status') }}",
    		        data: {
    		            "_token": "{{ csrf_token() }}","user_id":user_id,"status":status
    		        },
    		        success: function(data){
    		           
    		            if(data){
    		                location.reload(true);
    		            }
    		        }
    		    });
	        }
        });
	});
$(document).on('click','.master_status',function(e){
	    e.preventDefault();
	    Swal.fire({
	        title: 'Are you sure?',
	        text: "Are you sure it's change status ?",
	        icon: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes!'
	    }).then((result) => {
	        if (result.value) {
	            Swal.fire({
					title: 'Success',
					text: "Status has been changed Success.",
					icon: 'success',
					showCancelButton: false,
				    showConfirmButton: false}	                
	            );
	            var user_id = $(this).attr('data-id');
	            var status = $(this).attr('data-status');
    		    $.ajax({
    		        type: "post",
    		        url: "{{ url('admin/driver/driver_master_status') }}",
    		        data: {
    		            "_token": "{{ csrf_token() }}","user_id":user_id,"status":status
    		        },
    		        success: function(data){
    		           
    		            if(data){
    		                location.reload(true);
    		            }
    		        }
    		    });
	        }
        });
	});

$(document).on('click','.delete_record',function(){
	   
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
					text: "Company has been deleted.",
					icon: 'success',
					showCancelButton: false,
				    showConfirmButton: false}	                
	            );
	            var user_id = $(this).attr('data-id');
               
    		    $.ajax({
    		        type: "post",
    		        url: "{{ url('admin/company/delete') }}",
    		        data: {
    		            "_token": "{{ csrf_token() }}","user_id":user_id
    		        },
    		        success: function(data){
    		           
    		            if(data){
    		                location.reload(true);
    		            }
    		        }
    		    });
	        }
        });
	});


</script>
@stop