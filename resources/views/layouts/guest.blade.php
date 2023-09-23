
<!DOCTYPE html>
<html>
    <head>
        <title>{{ env('APP_NAME') }} {{ isset($page_title)?' - '.$page_title:'' }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- Select Text CSS-->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <!-- Swiper Slider -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
        <!-- Custom CSS -->

        <link href="{{ asset('new-design-company/assets/css/style2.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />

        <link href="{{ asset('/assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/clockpicker/dist/jquery-clockpicker.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">



        
    </head>
    <body>
    <?php $logoImage =  Auth::check() && !empty($companyInfo->background_image) ? config('app.url_public').'/'.$companyInfo->background_image :  '/images/bg_body.png' ?>

       
    <div class="main_content">
            @yield('content')
        </div>


       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="https://dunggramer.github.io/disable-devtool/disable-devtool.min.js" defer></script> -->
        <!-- /Scripts -->
        <!-- Select text js -->
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <!-- Swiper Js -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <!-- Calendar -->
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.8/index.global.min.js'></script>
        <!-- Custom Js -->
        <script src="{{ asset('new-design-company/assets/js/main.js') }}" type="application/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" integrity="sha512-Fq/wHuMI7AraoOK+juE5oYILKvSPe6GC5ZWZnvpOO/ZPdtyA29n+a5kVLP4XaLyDy9D1IBPYzdFycO33Ijd0Pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>


        
        <script src="{{ asset('/assets/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/clockpicker/dist/jquery-clockpicker.min.js"></script>
        @yield('footer_scripts')
       
       <script>
         $(document).keydown(function(event) { 
                if (event.keyCode == 27) { 
                    $(document).find('.modalClose').trigger('click');
                }
            });
        </script>
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
