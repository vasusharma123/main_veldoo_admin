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
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 ps-0 align-self-center">
                            <div class="side_img_section text-center position-relative">
                                <p class="big_text shadow_text">Veldoo</p>
                                <img src="{{ asset('service_provider_assets/imgs/mobiles-2.png') }}" alt="side Phones" class="img-fluid w-100 side_mobile_image" />
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12 ps-0">
                            <div class="top_form_heading text-center position-relative">
                                <p class="sm_text shadow_text mb-0 sm_white_space">{{ __('Define your car pool')}}</p>
                                <h3 class="form_bold_text">{{ __('Add your car details')}}</h3>
                            </div>
                            {{ Form::open(['url' => 'service-provider/register_step3_submit', 'class' => 'input_form
                            position-relative mb-0', 'method' => 'post']) }}
                            <input type="hidden" name="service_provider_token" value="{{ $token }}">
                            @php
                            $loopCount = 0;
                            @endphp
                            @foreach ($prices as $price_key => $price)
                            @foreach ($price->cars as $vehicle_key => $vehicle)
                            <div class="row w-100 m-0 gx-4 @php if($price_key !=0 && $vehicle_key == 0){ echo 'mt-5';} elseif ($vehicle_key !=0 ) { echo 'mt-2';} @endphp">
                                @if($vehicle_key == 0)
                                <div class="col-12">
                                    <h2 class="subtitle less_left_space">{{ $price->car_type }}</h2>
                                </div>
                                @endif
                                <div class="col-lg-2 col-md-2 col-sm-6 col-12 offset-1 col_form_settings mb-2 align-self-end text-center">
                                    <label class="bold_label label_form">{{ __('Car') }}
                                        {{ $vehicle_key + 1 }}</label>

                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-12 col_form_settings mb-2 text-left align-self-end">
                                    <small class="sort_info normal_info">{{ __('Configure your car model and plate
                                            number') }}</small>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-12 col_form_settings mb-2">
                                    <label class=" label_form">{{ __('Car Model') }}</label>
                                    <input type="hidden" name="vehicle_id[]" value="{{ $vehicle->id??old('vehicle_id.'.$loopCount) }}">
                                    <input type="text" name="model[]" class="form-control input_text" value="{{ $vehicle->model??old('model.'.$loopCount) }}" placeholder="TOYOTA PRIUS +" required />
                                    @error('model.'.$loopCount)
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-6 col-12 col_form_settings mb-2">
                                    <label class=" label_form">{{ __('Plate Number') }}</label>
                                    <input type="text" name="vehicle_number_plate[]" class="form-control input_text" value="{{ $vehicle->vehicle_number_plate??old('vehicle_number_plate.'.$loopCount) }}" placeholder="ZH 123456" required />
                                    @error('vehicle_number_plate.'.$loopCount)
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            @php
                            $loopCount++;
                            @endphp
                            @endforeach
                            @endforeach
                            <div class="row w-100 m-0 gx-4 mt-4">
                                <div class="col-lg-3 col-md-3 col-sm-12 col-12">

                                </div>
                                <div class="col-lg-9 col-md-9col-sm-12 col-12 col_form_settings mb-2 text-left align-self-end">
                                    <small class="sort_info normal_info"><b class="md_label">{{ __('NOTE')}}:</b> {{ __('With test
                                            version you are limited to add 3 cars max. In the full version there is no limit to
                                            cars. additional to that you can create your own car types as needed.')}}</small>

                                </div>
                            </div>
                            <div class="row w-100 m-0 gx-4 sm_form_row" style="margin-top: 15vh !important;">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mt-3 mb-3 text-end">
                                    <a class="btn submit_btn full_width_btn blue_btn" href="{{ route('service-provider.register_step2', ['token' => $token]) }}">
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
    <script src="{{ asset('service_provider_assets/js/jquery-3.6.4.min.js') }}"></script>
    <script src="{{ asset('service_provider_assets/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('service_provider_assets/js/main.js') }}"></script>
</body>

</html>
