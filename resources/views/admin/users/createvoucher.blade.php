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
							<section class="addEditForm sectionsform">
								@include('admin.layouts.flash-message')
								<article class="container-fluid">
									<form class="custom_form editForm " id="EditCarType">
										<div class="row w-100 m-0 form_inside_row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-12">
												<div class="row w-100 m-0">

													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="milesPercentage" name="milesPercentage" placeholder="Mile Per Ride(%)" />
															<label for="milesPercentage">Mile Per Ride(In percentage)</label>
														</div>
													</div>
													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="milesCurrency" name="milesCurrency" placeholder="Mile to Currency" />
															<label for="milesCurrency">Mile to Currency</label>
														</div>
													</div>
													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="text" class="form-control inputText" id="milesInvitation" name="milesInvitation" placeholder="Mile on Invitation" />
															<label for="milesInvitation">Mile on Invitation</label>
														</div>
													</div>
													<div class="col-lg-3 col-md-6 col-sm-12 col-12">
														<div class="form-group">
															<input type="submit" value="Save" name="submit" class="form-control submit_btn mt-2 w-100"/>
														</div>
													</div>
												</div>
											</div>
				 
										</div>
									</form>
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
		var orderby = $('input[name="orderBy"]').val().toString();
		var order = $('input[name="order"]').val().toString();
		$("#loading").fadeIn("slow");
		$('.input-append input[name="page"]').val(1);
		ajaxCall('', text, orderby, order, '');
	};
	
	$('body').on('click', '.delete_user', function(){
        var id = $(this).attr('data-id');
		//var text = $('.myInput').val();
		var text = '';
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
			$("#loading").fadeOut("slow");
			$('#allDataUpdate').html(data);
			
			//$('.custom-userData-sort[orderBy="'+orderby+'"] > i').removeClass('fa-sort fa-sort-desc fa-sort-asc').addClass('fa-sort-'+order);
			//$('.custom-userData-sort[orderby="'+orderby+'"]').attr('order', (order=='asc' ? 'desc' : 'asc'));
		}
	});
}
</script>
@stop