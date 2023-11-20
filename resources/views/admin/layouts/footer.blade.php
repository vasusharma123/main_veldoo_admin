		</div>
		<!-- TelePhone -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
		<!-- JQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
		<!-- Bootstrap V5 JS -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
		<!-- JS -->
		<script src="{{ asset('assets/js/main.js') }}"></script>
		
		<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
		
		<script type="text/javascript">
		$('body').on('keypress', '.custFloatVal', function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});
		
		$('body').on('keydown', '.custNumFieldCls', function(e){
			if(!((e.keyCode > 95 && e.keyCode < 106) || (e.keyCode > 47 && e.keyCode < 58) || e.keyCode == 8)) {
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
					url : url
				}).done(function (data) {
					$("#loading").fadeOut("slow");
					$('#allDataUpdate').html(data);
					var page = getParameterByName('page',url);
					$('input[name="page"]').val(page);
					//console.log(page);
					//$('.custom-userData-sort[orderBy="'+orderby+'"] > i').removeClass('fa-sort fa-sort-desc fa-sort-asc').addClass('fa-sort-'+order);
					//$('.custom-userData-sort[orderby="'+orderby+'"]').attr('order', (order=='asc' ? 'desc' : 'asc'));
				}).fail(function () {
					$("#loading").fadeOut("slow");
					swal("Server Timeout!", "Please try again", "warning");
				});
			}
		});
		</script>
		
		@yield ('footer_scripts')
	</body>
</html>