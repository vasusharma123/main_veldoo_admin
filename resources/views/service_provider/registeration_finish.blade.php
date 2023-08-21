<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration - Veldoo 2000 Driver App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('service_provider_assets/bootstrap-5.2.3-dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9421a306f6.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css">
    <link href="{{ asset('service_provider_assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/setting/admin-favicon.png') }}">
</head>
<body>
    <div class="content-wrapper">
        <section class="form_section p_form">
            <div class="art_form" id="diver_app_register">
                <article class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="top_form_heading text-end position-relative">
                                <p class="sm_text shadow_text mb-0 sm_white_space">{{__('Download from App Store or Play Store')}}</p>
                                <h3 class="form_bold_text pe-5 mb-5">{{__('Install Veldoo App')}}</h3>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0 align-self-start">
                            <div class="side_img_section text-center position-relative">
                                <p class="big_text shadow_text" style="line-height: 1;">Veldoo</p>
                                <img src="{{ asset('service_provider_assets/imgs/mobiles-2.png')}}" alt="side Phones" class="img-fluid w-100 side_mobile_image" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0">

                            <form class="input_form position-relative mb-0">
                                <div class="row w-100 m-0 gx-4 ">
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 col_form_settings mb-2 offset-2">
                                        <label class="md_label label_form d-block ">{{__('Download and Install App from Google Play Store or from App Store.')}}</label>
                                        <label class="mt-4 label_form d-block ">{{__('For Downloading and Installing follow There Easy Steps:')}}</label>
                                        <label class="label_form d-block ">{{__('Step 1: Open Google Play Store or App Store.')}}</label>
                                        <label class="label_form d-block ">{{__('Step 2: Search For your App.')}}</label>
                                        <label class="label_form d-block ">{{__('Step 3: Click Install Button.')}}</label>
                                        <label class="label_form d-block ">{{__('Step 4: Login with your created name.')}}</label>
                                        <label class="label_form d-block mt-4">{{__('Or click the icon below')}}</label>
                                        <div class="row w-100 m-0 gx-1 mt-5">
                                            <div class="col-lg-5 col-md-5 col-sm-6 col-6">
                                                <a href="https://play.google.com/store/apps/details?id=com.dev.veldoouser" class="img-link-download">
                                                    <img src="{{ asset('service_provider_assets/imgs/Googleplay.png')}}" class="img-fluid store_app_img" alt="play store">
                                                </a>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-6 col-6">
                                                <a href="https://apps.apple.com/in/app/id1597936025" class="img-link-download">
                                                    <img src="{{ asset('service_provider_assets/imgs/Istore.png')}}" class="img-fluid store_app_img" alt="Apple store">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </article>
            </div>

        </section>
    </div>
    <script src="{{ asset('service_provider_assets/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('service_provider_assets/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('service_provider_assets/js/main.js') }}"></script>
</body>
</html>
