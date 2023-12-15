<!DOCTYPE html>
<html>

<head>
    <title>{{ env('APP_NAME') }} {{ isset($page_title)?' - '.$page_title:'' }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.png')}}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap V5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- Style -->
    <link href="{{ asset('/assets/css/master-admin.css')}}" rel="stylesheet">
    <style>
       .dashbaord_bodycontent {
            padding: 50px 32px 50px 32px;
        }
    </style>
</head>

<body>
    @yield('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap V5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
    <!-- /Scripts -->
    <!-- Custom Js -->
    <script src="{{ asset('assets/js/main.js')}}"></script>
    <script>
        // Input empty
        $('.submit_btn').on('click', function() {

            $('.form-control').each(function() {
                var $input = $(this);

                if ($input.val() == '') {
                    var $parent = $input.closest('.has_validation');

                    $parent.addClass('invalid_field');
                } else {
                    var $parent = $input.closest('.has_validation');

                    $parent.removeClass('invalid_field');
                }

            });

        });
    </script>
