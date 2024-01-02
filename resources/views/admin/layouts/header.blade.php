<!DOCTYPE html>
<html lang="en">

<head>
    <title>Veldoo - User List</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap V5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    <link href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}" id="theme" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/veldoo-style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/veldoo-dev-style.css') }}" />

    <!-- Editor -->
    <script src="https://cdn.ckeditor.com/4.19.1/standard/ckeditor.js"></script>

    @php
        if (!empty($configuration['background_image']) && file_exists('storage/' . $configuration['background_image'])) {
            $backgroundImage = env('URL_PUBLIC') . '/' . $configuration['background_image'];
        } else {
            $backgroundImage = asset('assets/imgs/bg_body.png');
        }

        if (!empty($configuration) && !empty($configuration->header_color)) {
            $primaryColor = $configuration->header_color;
        } else {
            $primaryColor = '#FC4C02';
        }

        if (!empty($configuration) && !empty($configuration->header_font_family)) {
            $header_font_family = $configuration->header_font_family;
        } else {
            $header_font_family = "'Oswald', sans-serif";
        }

        if (!empty($configuration) && !empty($configuration->header_font_color)) {
            $header_font_color = $configuration->header_font_color;
        } else {
            $header_font_color = '#ffffff';
        }

        if (!empty($configuration) && !empty($configuration->header_font_size)) {
            $header_font_size = $configuration->header_font_size;
        } else {
            $header_font_size = '16px';
        }

        if (!empty($configuration) && !empty($configuration->input_color)) {
            $input_color = $configuration->input_color;
        } else {
            $input_color = 'rgba(255, 255, 255, 0.5)';
        }

        if (!empty($configuration) && !empty($configuration->input_font_family)) {
            $input_font_family = $configuration->input_font_family;
        } else {
            $input_font_family = 'var(--bs-body-font-family)';
        }

        if (!empty($configuration) && !empty($configuration->input_font_color)) {
            $input_font_color = $configuration->input_font_color;
        } else {
            $input_font_color = '#212529';
        }

        if (!empty($configuration) && !empty($configuration->input_font_size)) {
            $input_font_size = $configuration->input_font_size;
        } else {
            $input_font_size = '1rem';
        }

        if (!empty($configuration) && !empty($configuration->ride_color)) {
            $ride_color = $configuration->ride_color;
        } else {
            $ride_color = '#356681';
        }
    @endphp

    <style>
        :root {
            --primary-color: {{ $primaryColor }};
            --primary-font-family: {{ $header_font_family }};
            --primary-font-color: {{ $header_font_color }};
            --primary-font-size: {{ $header_font_size }};
            --primary-input-color: {{ $input_color }};
            --primary-input-font-family: {{ $input_font_family }};
            --primary-input-font-color: {{ $input_font_color }};
            --primary-input-font-size: {{ $input_font_size }};
            --primary-ride-color: {{ $ride_color }}
        }

        body {
            background-image: url({{ $backgroundImage }});
        }
    </style>

    @yield('css')
</head>

<body>
    <div class="main_wrapper">
