<!DOCTYPE html>
<html>
    <head>
        <title>Log In</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap V5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom Style -->
        <link href="{{ asset('company/assets/css/style.css')}}" rel="stylesheet">
        @yield('css')
    </head>
    <body>
        @yield('content')
        @yield('modals')
        <!-- All Content -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <!-- Bootstrap V5 JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Custom Script -->
        <script src="{{ asset('company/assets/js/main.js')}}"></script>
        @yield('script')
    </body>
</html>