<!DOCTYPE html>
<html>

    <head>

        <title>Veldoo - Login</title>  
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap V5 CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- TelePhone -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    
        <!-- Style -->
		<link href="{{ asset('/assets/css/master-admin.css')}}" rel="stylesheet">
        <style>
            .iti__selected-flag {
                margin-left: 11px;
                border-right: 1px solid rgba(17, 29, 53, .3);
                height: 30px;
                margin-top: 13px;
            }
            .iti--allow-dropdown input, .iti--allow-dropdown input[type=tel]{
                margin-bottom: 24px !important;
                padding-left: 24px;
            }
            .invalid_field .iti--allow-dropdown input, .invalid_field .iti--allow-dropdown input[type=tel]{
                margin-bottom: 0px !important;
            }
            .dashbaord_bodycontent {
                padding: 50px 32px 50px 32px;
            }
        </style>
    </head>
