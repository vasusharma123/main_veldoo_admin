@extends('layouts.service_provider_registration')

@section('css')
    <style>
        .voltop {
            margin-top: 40px;
            margin-bottom: 30px;
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
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 ps-0 align-self-center">
                            <div class="voltop">
                                <h3 class="form_bold_text">{{ $user_exist->name }}</h3>
                                <label class="label_form d-block mt-1">Test License, expiration date:
                                    {{ date('d.m.Y', strtotime($user_exist->setting->demo_expiry)) }}</label>
                            </div>
                            <div class="side_img_section text-center position-relative">
                                <p class="big_text shadow_text">Veldoo</p>
                                <img src="{{ asset('service_provider_assets/imgs/mobiles-2.png') }}" alt="side Phones"
                                    class="img-fluid w-100 side_mobile_image" />
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 ps-0">
                            <div class="top_form_heading text-center position-relative">
                                <p class="sm_text shadow_text mb-0 sm_white_space">
                                    {{ __('Define your car types and costs') }}</p>
                                <h3 class="form_bold_text">{{ __('Change the default settings for the ride costs') }}</h3>
                            </div>
                            @include('service_provider.includes.flash_alerts')
                            {{ Form::open(['url' => 'service-provider/register_step2_submit', 'class' => 'input_form position-relative mb-0', 'id' => 'registerform', 'method' => 'post']) }}
                            <input type="hidden" name="service_provider_token" value="{{ $token }}">
                            @foreach ($prices as $price_key => $price)
                                <div class="row w-100 m-0 gx-4 mb-3">
                                    <div
                                        class="col-lg-3 col-md-3 col-sm-6 col-12 col_form_settings mb-2 align-self-center text-center">
                                        <label class="bold_label label_form required_field">{{ $price->car_type }}</label>
                                    </div>
                                    <div
                                        class="col-lg-3 col-md-3 col-sm-6 col-12 col_form_settings mb-2 text-left align-self-end">
                                        <small
                                            class="sort_info normal_info">{{ __('Set your start price and price per KM for') }}
                                        </small>
                                        <br />
                                        <label class="md_label label_form">{{ $price->car_type }}</label>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-12 col_form_settings mb-2">
                                        <label class=" label_form required_field">{{ __('Start Fee') }}</label>
                                        <input type="hidden" name="price_id[]"
                                            value="{{ $price->id ?? old('price_id.' . $price_key) }}">
                                        <div class="input-group mb-3">
                                            <input type="number" class="input_text form-control" name="basic_fee[]"
                                                value="{{ $price->basic_fee ?? old('basic_fee.' . $price_key) }}"
                                                step=".01" placeholder="6.0" aria-label="6.0"
                                                aria-describedby="basic-addon1" required>
                                            <span class="input-group-text" id="basic-addon1">CHF</span>
                                        </div>
                                        @error('basic_fee.' . $price_key)
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-12 col_form_settings mb-2">
                                        <label class=" label_form required_field">{{ __('Price per KM') }}</label>
                                        <div class="input-group mb-3">
                                            <input type="number" class="input_text form-control" name="price_per_km[]"
                                                value="{{ $price->price_per_km ?? old('price_per_km.' . $price_key) }}"
                                                step=".01" placeholder="3.9" aria-label="3.9"
                                                aria-describedby="basic-addon2" required>
                                            <span class="input-group-text" id="basic-addon2">CHF</span>
                                        </div>
                                        @error('price_per_km.' . $price_key)
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                            <div class="row w-100 m-0 gx-4 sm_form_row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mt-3 mb-3 text-end">
                                    <a href="{{ route('service-provider.register_step1', ['token' => $token]) }}"
                                        class="btn submit_btn full_width_btn blue_btn">
                                        <span class="btn_text">{{ __('Previous') }}</span>
                                    </a>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mt-3 mb-3 text-end">
                                    <button type="submit" class="submit_btn full_width_btn black_btn_hover">
                                        <span class="btn_text">{{ __('Next') }}</span>
                                    </button>
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
