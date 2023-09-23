<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- Custom CSS -->
        <link href="{{ asset('new-design-company/assets/css/style.css') }}" rel="stylesheet">
    </head>
    <body>
    <?php $logoImage =  Auth::check() && !empty($companyInfo->background_image) ? config('app.url_public').'/'.$companyInfo->background_image :  '/images/bg_body.png' ?>

        <div class="main_content">
            @yield('content')
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        {{-- <script src="https://dunggramer.github.io/disable-devtool/disable-devtool.min.js" defer></script> --}}
        <!-- Custom Js -->
        <script src="{{ asset('new-design-company/assets/js/main.js') }}" type="application/javascript"></script>
        @yield('script')
    </body>
    <style>
            body{
                background-image: url(<?php echo $logoImage ?>);
                background-size: cover;
                background-position: center;
                width: 100%;
                min-height: 100vh;
                height: auto;
            }

        </style>
</html>

