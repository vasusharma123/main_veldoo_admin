@extends('layouts.service_provider_registration')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css">
@endsection

@section('content')
<section class="form_section p_form">
    <div class="art_form" id="diver_app_register">
        <article class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0">
                    <div class="side_img_section text-center position-relative">
                        <p class="big_text shadow_text">Veldoo</p>
                        <img src="{{ asset('service_provider_assets/imgs/mobiles-2.png') }}" alt="side Phones" class="img-fluid w-100 side_mobile_image" />
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 ps-0">
                    <div class="top_form_heading text-center position-relative">
                        <p class="sm_text shadow_text mb-0">{{__('REGISTRATION')}}</p>
                        <h3 class="form_bold_text">Veldoo 2000 {{__('Driver App')}}</h3>
                    </div>
                    @include('service_provider.includes.flash_alerts')
                    {{ Form::open(array('url' => 'doRegister','class'=>'input_form','id'=>'registerform','method'=>"post")) }}
                    {{-- <form action="driverlogin.html" method="post" class="input_form"> --}}
                    <div class="row w-100 m-0 gx-4">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('First Name')}}</label>
                            <input type="text" name="first_name" class="form-control input_text" value="{{ old('first_name') }}" required />
                            @error('first_name')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter your first name')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('Last Name')}}</label>
                            <input type="text" name="last_name" class="form-control input_text" value="{{ old('last_name') }}" required />
                            @error('last_name')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter your last name')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('Company')}}</label>
                            <input type="text" name="site_name" class="form-control input_text" value="{{ old('site_name') }}" required />
                            @error('site_name')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter your company name')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('Address')}}</label>
                            <input type="text" name="addresses" class="form-control input_text" value="{{ old('addresses') }}" required />
                            @error('addresses')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter the address of the company')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('Postal Code')}}</label>
                            <input type="number" name="zip" class="form-control input_text" value="{{ old('zip') }}" required />
                            @error('zip')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter your zip code')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('City')}}</label>
                            <input type="text" name="city" class="form-control input_text" value="{{ old('city') }}" required />
                            @error('city')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter your city')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('Country')}}</label>
                            <input type="text" name="country" class="form-control input_text" value="{{ old('country') }}" required />
                            @error('country')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Please enter your country')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('Phone Number')}}</label>
                            <input class="form-control" name="iso2" type="hidden" id="iso2" value="{{ old('iso2')??'ch' }}">
                            <input class="form-control" name="country_code" type="hidden" id="country_code" value="{{ old('country_code')??41 }}">
                            <input type="text" name="phone" class="form-control input_text" id="country_code_box" value="{{ old('phone') }}" required />
                            @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Example:')}} +43 xxxxxx1234</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                            <label class="required_field label_form">{{__('E-mail Address')}}</label>
                            <input type="email" name="email" class="form-control input_text" value="{{ old('email') }}" required />
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                            @else
                            <small class="sort_info">{{__('Example: your@email-address.com')}}</small>
                            @enderror
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col_form_settings mt-3 mb-3 text-end">
                            <button class="submit_btn">
                                <i class="fa-solid fa-arrow-pointer pointer_arrow"></i>
                                <span class="btn_text">{{__('Join Now')}}</span>
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </article>
    </div>

</section>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
<script>
    // Vanilla Javascript
    var input = document.querySelector("#country_code_box");
    var instance = window.intlTelInput(input, ({
        initialCountry: "{{ old('iso2')??'ch' }}"
        , separateDialCode: true
    , }));
    input.addEventListener("countrychange", function() {
        $("#iso2").val(instance.getSelectedCountryData().iso2);
        $("#country_code").val(instance.getSelectedCountryData().dialCode);
    });

</script>
@endsection