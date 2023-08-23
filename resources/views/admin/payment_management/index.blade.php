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
						<div class="input-append col-md-3" style="float: right;">
							<input type="text" name="data[q]" class="search-query myInput form-control" id="demo-input-search2" placeholder="Type to search">
							<input name="orderBy" type="hidden">
							<input name="order" type="hidden">
							<input name="page" type="hidden">
						</div> 
						<div class="table-responsive box" id="allDataUpdate">
							@include('admin.payment_management.index_element')
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
$(function () {
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
</script>
@stop