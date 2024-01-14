@extends('admin.layouts.master')

@section('header_search_export')
<div class="search">
  <form class="search_form">
    <div class="form-group searchinput position-relative trigger_parent">
      <input
        type="text"
        name="data[q]"
        class="form-control input_search target myInput"
        placeholder="Search"
      />
      <i class="bi bi-search search_icons"></i>
    </div>
  </form>
</div>
<div class="export_box">
  <a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
</div>
@endsection

@section('content')

	<div class="formTableContent">
		<section class="addonTable sectionsform pt-2">
			@include('admin.layouts.flash-message')
			<article class="container-fluid">
				
				<!--<form class="custom_form editForm" id="SearchForm">
					<div class="row w-100 m-0 form_inside_row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12">
							<div class="row w-100 m-0">
								<div class="col-lg-3 col-md-4 col-sm-8 col-6 ms-auto">
									<div class="form-group">
										<input type="search" class="form-control inputText my-2" id="keywords" name="keywords" placeholder="Search..." />
									</div>
								</div>
								
							</div>
						</div>
					</div>-->
				</form>
				
				<input name="page" type="hidden">
				
				<div id="allDataUpdate">
					@include("admin.payment_method.index_element")
				</div>
			</article>
		</section>
	</div>
					
@endsection	
	
@section('footer_scripts')
<script type="text/javascript">
$(function () {
	
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 500;  //time in ms, 5 second for example
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
	
	$('body').on('click', '.delete_method', function(){
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
                //$("#loading").fadeIn("slow");
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
<script type="text/javascript">
	$('body').on('keypress', '.custFloatVal', function(event) {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});

	$('body').on('keydown', '.custNumFieldCls', function(e) {
		if (!((e.keyCode > 95 && e.keyCode < 106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
			return false;
		}
	});

	function getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, '\\$&');
		var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, ' '));
	}

	$(function() {

		$('body').on('click', '.pagination a', function(e) {
			e.preventDefault();
			$("#loading").fadeIn("slow");
			var url = $(this).attr('href');
			paginate(url);
			// window.history.pushState("", "", url);
		});

		function paginate(url) {
			//var orderby = $('input[name="orderBy"]').val();
			//var order = $('input[name="order"]').val();
			$.ajax({
				url: url
			}).done(function(data) {
				$("#loading").fadeOut("slow");
				$('#allDataUpdate').html(data);
				var page = getParameterByName('page', url);
				$('input[name="page"]').val(page);
				//console.log(page);
				//$('.custom-userData-sort[orderBy="'+orderby+'"] > i').removeClass('fa-sort fa-sort-desc fa-sort-asc').addClass('fa-sort-'+order);
				//$('.custom-userData-sort[orderby="'+orderby+'"]').attr('order', (order=='asc' ? 'desc' : 'asc'));
			}).fail(function() {
				$("#loading").fadeOut("slow");
				swal("Server Timeout!", "Please try again", "warning");
			});
		}
	});
</script>
@stop