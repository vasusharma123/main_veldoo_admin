@extends('admin.layouts.master')

@section('content')
<main class="body_content">
	<div class="inside_body">
		<div class="container-fluid p-0">
			<div class="row m-0 w-100">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
					<div class="body_flow">
						@include('admin.layouts.sidebar')
						<div class="formTableContent">
							<section class="addonTable sectionsform pt-2">
								@include('admin.layouts.flash-message')
								<article class="container-fluid">
									
									<input name="page" type="hidden">
									
									<form class="custom_form editForm" id="SearchForm">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="row w-100 m-0">
													
													<div class="col-lg-3 col-md-4 col-sm-12 col-12">
														<div class="form-group">
															<label for="startDate">Start Date</label>
															<input type="date" class="form-control inputText" id="startDate" name="startDate" placeholder="start Date" value="DD-MM-SS" />
														   
														</div>
													</div>
													
													<div class="col-lg-3 col-md-4 col-sm-12 col-12">
														<div class="form-group">
															<label for="endDate">End Date</label>
															<input type="date" class="form-control inputText" id="endDate" name="endDate" placeholder="End Date" value="DD-MM-SS" />
														   
														</div>
													</div>
													<div class="col-lg-3 col-md-4 col-sm-12 col-12">
														<div class="form-group">
															<label for="keywords">Search Keyword</label>
															<input type="search" class="form-control inputText" id="keywords" name="keywords" placeholder="Search..." />
														   
														</div>
													</div>
													<div class="col-lg-2 col-md-4 col-sm-4 col-6 align-self-end">
														<div class="form-group">
															<input type="submit" value="Filter" name="search" class="form-control submit_btn searchbtn"/>
														</div>
													</div>
													<div class="col-lg-1 col-md-2 col-sm-2 col-4 align-self-end">
														<div class="form-group">
															<button class="btn submit_btn searchbtn exportbtn" type="button"><i class="bi bi-download"></i></button>
														</div>
													</div>
												   
												</div>
											</div>
										</div>
									</form>
									
									<div id="allDataUpdate">
										@include("admin.rides.index_element")
									</div>
								</article>
							</section>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</main>
@endsection	
	
@section('footer_scripts')
<script type="text/javascript">
$(function () {
	
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
		//var orderby = $('input[name="orderBy"]').val().toString();
		var orderby = '';
		//var order = $('input[name="order"]').val().toString();
		var order = '';
		//$("#loading").fadeIn("slow");
		$('input[name="page"]').val(1);
		ajaxCall('', text, orderby, order, '');
	};
	
	$('body').on('click', '.delete_user', function(){
        var id = $(this).attr('data-id');
		var text = $('.myInput').val();
		//var orderby = $('input[name="orderBy"]').val();
		var orderby = '';
		//var order = $('input[name="order"]').val();
		var order = '';
		var page = $('input[name="page"]').val();
		var status = 0;
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
				ajaxCall(id, text, orderby, order, page, status,'delete');
            } else {
                swal();
            }
        });
    });
	
	$('body').on('click', '.change_status', function(){
		//var orderby = $('input[name="orderBy"]').val();
		var orderby = '';
		//var order = $('input[name="order"]').val();
		var order = '';
		var page = $('input[name="page"]').val();
		var status = $(this).val();
		var id = $(this).attr('data-id');
		
		//var text = $('.myInput').val();
		var text = '';
		
		$("#loading").fadeIn("slow");
		ajaxCall(id, text, orderby, order, page, status, 'status');
	});
});
function ajaxCall(id=0, text='', orderby, order, page=1 , status='',type='') {
	var page = (!page ? 1 : page);
	$.ajax({
		type: "GET",
		url: "{{url()->current()}}",
		data : {id:id,text:text,orderby:orderby,order:order,status:status,page:page,type:type},
		success: function (data) {
			//$("#loading").fadeOut("slow");
			$('#allDataUpdate').html(data);
			
			//$('.custom-userData-sort[orderBy="'+orderby+'"] > i').removeClass('fa-sort fa-sort-desc fa-sort-asc').addClass('fa-sort-'+order);
			//$('.custom-userData-sort[orderby="'+orderby+'"]').attr('order', (order=='asc' ? 'desc' : 'asc'));
		}
	});
}
</script>
@stop