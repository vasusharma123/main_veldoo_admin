
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <!-- Bootstrap V5 JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
        <!-- /Scripts -->
        <!-- Custom Js -->
        <script src="assets/js/master-admin.js" type="application/javascript"></script>
        <script>

          

            // Input empty
            $('.submit_btn').on('click',function(){

                $('.form-control').each(function() {
                    var $input = $(this);

                if ($input.val() == '') {
                        var $parent = $input.closest('.has_validation');
                    
                    $parent.addClass('invalid_field');
                }
                else{
                    var $parent = $input.closest('.has_validation');
                    
                    $parent.removeClass('invalid_field');
                }

                });

            });

            // Handle row click event
            function navigateTo(url){
                window.location.href = url;
            }


        </script>

    </body>

</html>