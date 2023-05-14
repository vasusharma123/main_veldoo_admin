		<!-- ============================================================== -->
		<!-- All Jquery -->
		<!-- ============================================================== -->
		<script src="{{ asset('/assets/plugins/jquery/jquery.min.js')}}"></script>
		<!-- Bootstrap tether Core JavaScript -->
		<script src="{{ asset('/assets/plugins/bootstrap/js/popper.min.js')}}"></script>
		<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
		<!-- slimscrollbar scrollbar JavaScript -->
		<script src="{{ asset('/assets/js/jquery.slimscroll.js')}}"></script>
		<!--Wave Effects -->
		<script src="{{ asset('/assets/js/waves.js')}}"></script>
		<!--BOOTSTRAP DATEPICKER -->
		<script src="{{ asset('/assets/plugins/moment/moment.js')}}"></script>
		<script src="{{ asset('/assets/plugins/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
		<!--Menu sidebar -->
		<script src="{{ asset('/assets/js/sidebarmenu.js')}}"></script>
		<!--ION RANGE SLIDER -->
		<script src="{{ asset('/assets/plugins/ion-rangeslider/js/ion-rangeSlider/ion.rangeSlider.min.js')}}"></script>
		<!--stickey kit -->
		<script src="{{ asset('/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
		<script src="{{ asset('/assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
		<!--Custom JavaScript -->
		<script src="{{ asset('/assets/js/custom.min.js')}}"></script>
		<!-- This page plugins -->
		<!-- ============================================================== -->
		<script src="{{ asset('/assets/js/jasny-bootstrap.js')}}"></script>
		<script src="{{ asset('/assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
		<script src="{{ asset('/assets/plugins/sweetalert/jquery.sweet-alert.custom.js')}}"></script>
		<!-- ============================================================== -->
		<!-- SELECT 2 -->
		<script src="{{ asset('/assets/plugins/select2/dist/js/select2.min.js')}}"></script>
		<!-- Style Switcher -->
		<!-- ============================================================== -->
		<script src="{{ asset('/assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
		<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.js"></script>
		<script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
		<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

        @if (Auth::check())
 		<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
		
		@else
		  
		@endif

{{Html::script('//cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js
')}} 
{{Html::script('//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js')}} 
{{Html::script('//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js')}}
{{Html::script('//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js')}} 
{{Html::script('//cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js')}} 
{{Html::script('//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js')}} 

{{Html::style('//cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css')}}
{{Html::script('//code.jquery.com/ui/1.13.2/jquery-ui.js')}}
{{Html::script('//cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js')}}
{{Html::style('//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css')}} 
{{Html::style('assets/css/intlTelInput.css')}} 
{{Html::script('assets/js/intlTelInput.js')}} 

		<script type="text/javascript">
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
			$('.date').bootstrapMaterialDatePicker({ date: true,time: false, format: 'YYYY-MM-DD' });
			$('body').on('click', '.pagination:not(.laravel_pagination) a', function(e) {
				e.preventDefault();
				$("#loading").fadeIn("slow");
				var url = $(this).attr('href');  
				paginate(url);
				// window.history.pushState("", "", url);
			});
			function paginate(url) {
				var orderby = $('input[name="orderBy"]').val();
				var order = $('input[name="order"]').val();
				$.ajax({
					url : url
				}).done(function (data) {
					$("#loading").fadeOut("slow");
					$('#allDataUpdate').html(data);
					var page = getParameterByName('page',url);
					$('.input-append input[name="page"]').val(page);
					console.log(page);
					$('.custom-userData-sort[orderBy="'+orderby+'"] > i').removeClass('fa-sort fa-sort-desc fa-sort-asc').addClass('fa-sort-'+order);
					$('.custom-userData-sort[orderby="'+orderby+'"]').attr('order', (order=='asc' ? 'desc' : 'asc'));
				}).fail(function () {
					$("#loading").fadeOut("slow");
					swal("Server Timeout!", "Please try again", "warning");
				});
			}
				
			if ($(".textarea").length > 0) {
				tinymce.init({
					selector: "textarea.textarea",
					theme: "modern",
					
					
					height: 300,
					resize:false,
					plugins: [
						"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
						"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
						"save table contextmenu directionality emoticons template paste textcolor"
					],
					menubar: false,
					toolbar: " bold italic | alignleft aligncenter alignright alignjustify | bullist numlist",

				});
				
				
			}
		});
		
$(document).ready(function(){
  $(".nav-tabs a").click(function(){
    $(this).tab('show');
  });
});

 CKEDITOR.replace( 'ckeditor',
         {
          customConfig : 'config.js',
          toolbar : 'simple'
          })

jQuery("#Regphones").intlTelInput({
		initialCountry:"us",
		separateDialCode: true,
		utilsScript: "{{url('assets/js/utils.js')}}",
		customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
			return "";
		},
});  
jQuery("#CRegphones").intlTelInput({
		initialCountry:"us",
		separateDialCode: true,
		utilsScript: "{{url('assets/js/utils.js')}}",
		customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
			return "";
		},
});  
jQuery("#admin_phone").intlTelInput({
		initialCountry:"us",
		separateDialCode: true,
		utilsScript: "{{url('assets/js/utils.js')}}",
		customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
			return "";
		},
});  
jQuery("#RegAlterenatePhones").intlTelInput({
		initialCountry:"us",
		separateDialCode: true,
		utilsScript: "{{url('assets/js/utils.js')}}",
		customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
			return "";
		},
});  
</script>
		 @yield ('footer_scripts')
	</body>
</html>