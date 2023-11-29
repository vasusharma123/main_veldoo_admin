<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration - Veldoo App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('service_provider_assets/bootstrap-5.2.3-dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9421a306f6.js" crossorigin="anonymous"></script>
    <link href="{{ asset('service_provider_assets/css/style.css')}}" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/setting/admin-favicon.png')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    @yield('css')
</head>
<body>
    <div class="content-wrapper">
        @yield('content')
    </div>
    <script src="{{ asset('service_provider_assets/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('service_provider_assets/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/9421a306f6.js" crossorigin="anonymous"></script>
    <script src="{{ asset('service_provider_assets/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('script')
</body>
</html>
