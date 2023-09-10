@extends('layouts.service_provider_registration')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css">
@endsection

@section('content')
<section class="form_section p_form">
    <div class="art_form" id="diver_app_register">
        <article class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0 align-self-center">
                    <div class="side_img_section text-center position-relative">
                        <p class="big_text shadow_text">Veldoo</p>
                        <img src="{{ asset('service_provider_assets/imgs/mobiles-2.png') }}" alt="side Phones" class="img-fluid w-100 side_mobile_image" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0">
                    <div class="top_form_heading text-center position-relative">
                        <p class="sm_text shadow_text mb-0 sm_white_space">{{__("Welcome to Veldoo APP")}}</p>
                        <h3 class="form_bold_text">{{__("Please add your Driver details to login to the Driver APP")}}</h3>
                    </div>
                    @include('service_provider.includes.flash_alerts')
                    {{ Form::open(array('url' => 'service-provider/register_step1_submit','class'=>'input_form position-relative','id'=>'registerform','method'=>"post")) }}
                    <input type="hidden" name="service_provider_token" value="{{ $token }}">
                    <div class="row w-100 m-0 gx-4">
                        <div class="col-12">
                            <h2 class="subtitle required_field">{{__("Driver 1")}}</h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Name")}}</label>
                            <input type="hidden" name="driver_id[]" value="{{ (!empty($drivers[0]))?($drivers[0]->id):old('driver_id.0') }}">
                            <input type="text" class="form-control input_text" placeholder="{{__('Enter driver name')}}" name="first_name[]" value="{{ (!empty($drivers[0]))?($drivers[0]->first_name):old('first_name.0') }}" required />
                            @error('first_name.0')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter driver first name')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Surname")}}</label>
                            <input type="text" class="form-control input_text" placeholder="Enter driver surname" name="last_name[]" value="{{ (!empty($drivers[0]))?($drivers[0]->last_name):old('last_name.0') }}" required />
                            @error('last_name.0')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter driver surname')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Mobile Number")}}</label>
                            <input class="form-control" name="iso2[]" type="hidden" id="iso2_0" value="{{ old('iso2.0')??'ch' }}">
                            <input class="form-control" name="country_code[]" type="hidden" id="country_code_0" value="{{ (!empty($drivers[0]))?($drivers[0]->country_code):(old('country_code.0')??41) }}">
                            <input type="text" name="phone[]" id="phone_0" class="form-control input_text" value="{{ (!empty($drivers[0]))?($drivers[0]->phone):old('phone.0') }}" required />
                            @error('phone.0')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Example:')}} +43 xxxxxx1234</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-0"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Password")}}</label>
                            <div class="field position-relative">
                                <input type="password" name="password[]" class="form-control input_text" placeholder="Enter your password" required />
                                <img src="{{ asset('service_provider_assets/imgs/eye-outline.png')}}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock">
                            </div>
                            @error('password.0')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__("Please enter password")}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Confirm Password")}}</label>
                            <div class="field position-relative">
                                <input type="password" name="password_confirmation[]" class="form-control input_text" placeholder="Re-enter your password" required />
                                <img src="{{ asset('service_provider_assets/imgs/eye-outline.png')}}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock">
                            </div>
                            @error('password_confirmation.0')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__("Please enter password")}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row w-100 m-0 gx-4">
                        <div class="col-12">
                            <h2 class="subtitle required_field">{{__("Driver 2")}}</h2>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Name")}}</label>
                            <input type="hidden" name="driver_id[]" value="{{ (!empty($drivers[1]))?($drivers[1]->id):old('driver_id.1') }}">
                            <input type="text" class="form-control input_text" name="first_name[]" value="{{ (!empty($drivers[1]))?($drivers[1]->first_name):old('first_name.1') }}" placeholder="Enter Enter driver name" required />
                            @error('first_name.1')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter driver first name')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Surname")}}</label>
                            <input type="text" class="form-control input_text" name="last_name[]" value="{{ (!empty($drivers[1]))?($drivers[1]->last_name):old('last_name.1') }}" placeholder="Enter driver surname" required />
                            @error('last_name.1')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter driver surname')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Mobile Number")}}</label>
                            <input class="form-control" name="iso2[]" type="hidden" id="iso2_1" value="{{ old('iso2.1')??'ch' }}">
                            <input class="form-control" name="country_code[]" type="hidden" id="country_code_1" value="{{ (!empty($drivers[1]))?($drivers[1]->country_code):(old('country_code.1')??41) }}">
                            <input type="text" name="phone[]" id="phone_1" class="form-control input_text" value="{{ (!empty($drivers[1]))?($drivers[1]->phone):old('phone.1') }}" required />
                            @error('phone.1')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Example:')}} +43 xxxxxx1234</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-0"></div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Password")}}</label>
                            <div class="field position-relative">
                                <input type="password" name="password[]" class="form-control input_text" placeholder="Enter your password" required />
                                <img src="{{ asset('service_provider_assets/imgs/eye-outline.png')}}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock">
                            </div>
                            @error('password.1')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__("Please enter password")}}</small>
                            @enderror

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__("Confirm Password")}}</label>
                            <div class="field position-relative">
                                <input type="password" name="password_confirmation[]" class="form-control input_text" placeholder="Re-enter your password" name="password_confirmation[]" required />
                                <img src="{{ asset('service_provider_assets/imgs/eye-outline.png')}}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock">
                            </div>
                            @error('password_confirmation.1')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__("Please enter password")}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="row w-100 m-0 gx-4">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mt-3 mb-3 text-end">

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mt-3 mb-3 text-end">
                            <button type="submit" class="submit_btn full_width_btn black_btn_hover">
                                <span class="btn_text">{{__("Next")}}</span>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
<script>
    var input_0 = document.querySelector("#phone_0");
    var instance_0 = window.intlTelInput(input_0, ({
        initialCountry: "{{ old('iso2.0')??'ch' }}"
        , separateDialCode: true
    , }));
    input_0.addEventListener("countrychange", function() {
        $("#iso2_0").val(instance_0.getSelectedCountryData().iso2);
        $("#country_code_0").val(instance_0.getSelectedCountryData().dialCode);
    });

    var input_1 = document.querySelector("#phone_1");
    var instance_1 = window.intlTelInput(input_1, ({
        initialCountry: "{{ old('iso2.1')??'ch' }}"
        , separateDialCode: true
    , }));
    input_1.addEventListener("countrychange", function() {
        $("#iso2_1").val(instance_1.getSelectedCountryData().iso2);
        $("#country_code_1").val(instance_1.getSelectedCountryData().dialCode);
    });

</script>
@endsection
