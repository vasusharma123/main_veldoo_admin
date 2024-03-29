@extends('layouts.service_provider_registration')

@section('css')
    <style>
        .voltop {
            margin-top: -81px;
            margin-bottom: 40px;
            float: left;
        }

        @media (max-width:1024px) {
            .voltop {
                margin-top: -110px;
                margin-bottom: 50px;
            }
        }

        @media (max-width:798px) {
            .voltop {
                margin-top: 0px;
                margin-bottom: 0px;
                text-align: center;
            }

            .voltop .form_bold_text {
                font-size: 30px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="form_section p_form">
            <div class="art_form" id="diver_app_register">
                <article class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="top_form_heading text-end position-relative">
                                <p class="sm_text shadow_text mb-0 sm_white_space">Download from App Store or Play Store</p>
                                <div class="thankyoubox mt-1 justify-content-start" style="min-height:100%;">
                                    <h3 class="thnxtext">Setup finished!</h3>
                                    <p class="thnxsubpara">To change the setup please follow the instruction in the mail</p>
                                </div>
                            </div>

                            <div class="voltop">
                                <h3 class="form_bold_text">{{ $user_exist->name }}</h3>
                                <label class="label_form d-block mt-1">Test License, expiration date:
                                    {{ date('d.m.Y', strtotime($user_exist->setting->demo_expiry)) }}</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0 align-self-start">
                            <div class="side_img_section text-center position-relative">
                                <p class="big_text shadow_text" style="line-height: 1;">Veldoo</p>
                                <img src="{{ asset('service_provider_assets/imgs/mobiles-2.png') }}" alt="side Phones"
                                    class="img-fluid w-100 side_mobile_image" />
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0">
                            @include('service_provider.includes.flash_alerts')
                            <form class="input_form position-relative mb-0">
                                <div class="row w-100 m-0 gx-4 ">
                                    <div class="col-lg-10 col-md-10 col-sm-12 col-12 col_form_settings mb-2 offset-2">
                                        <label
                                            class="md_label label_form d-block ">{{ __('Download and Install App from Google Play Store or from App Store.') }}</label>
                                        <label
                                            class="mt-4 label_form d-block ">{{ __('For Downloading and Installing follow There Easy Steps:') }}</label>
                                        <label
                                            class="label_form d-block ">{{ __('Step 1: Open Google Play Store or App Store.') }}</label>
                                        <label class="label_form d-block ">{{ __('Step 2: Search For your App.') }}</label>
                                        <label class="label_form d-block ">{{ __('Step 3: Click Install Button.') }}</label>
                                        <label
                                            class="label_form d-block ">{{ __('Step 4: Login with your created name.') }}</label>
                                        <label class="label_form d-block mt-4">{{ __('Or click the icon below') }}</label>
                                        <div class="row w-100 m-0 gx-1 mt-5">
                                            <div class="col-lg-5 col-md-5 col-sm-6 col-6">
                                                <a href="https://play.google.com/store/apps/details?id=com.veldoo.driver"
                                                    class="img-link-download">
                                                    <img src="{{ asset('service_provider_assets/imgs/Googleplay.png') }}"
                                                        class="img-fluid store_app_img" alt="play store">
                                                </a>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-6 col-6">
                                                <a href="https://apps.apple.com/in/app/id1645847445"
                                                    class="img-link-download">
                                                    <img src="{{ asset('service_provider_assets/imgs/Istore.png') }}"
                                                        class="img-fluid store_app_img" alt="Apple store">
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
@endsection

@section('script')
@endsection
