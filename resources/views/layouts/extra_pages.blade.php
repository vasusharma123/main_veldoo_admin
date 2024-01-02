<!DOCTYPE html>
<html>
<head>
    <title>{{ env('APP_NAME') }} {{ isset($page_title) ? ' - ' . $page_title : '' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap V5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('service_provider_assets/css/style2.css') }}" />
    @yield('css')
</head>

<body>

    @yield('content')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap V5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- /Scripts -->

    <!-- Custom Js -->
    <script src="{{ asset('service_provider_assets/js/main.js')}}" type="application/javascript"></script>
    @yield('script')
</body>

</html>
