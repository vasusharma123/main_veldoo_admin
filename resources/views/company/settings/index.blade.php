@extends('company.layouts.app')
@section('content')
<style>
    /* input
    {
         color: black !important; 
        font-weight: 600 !important;
    } */
    input::placeholder
    {
        font-weight: 100 !important;
    }

    input[type="color"] {
    /* background-color: #fff; */
    width: 100px;
    height: 75px;
    cursor: pointer;
}

b {
	background-color: #fff;
	padding: 16px;
	font-family: sans-serif;
}

code {
	font-size: 1.2rem;
	background-color: lightslategray;
	color: #fff;
	border-radius: 3px;
	padding: 5px;
}
</style>
@section('header_button')
    <button type="button" class="btn addNewBtn_cs me-4">
        <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon " class="img-fluid add_booking_icon svg add_icon_svg" />
        <span class="text_button">Book a ride</span>
    </button>
@endsection
    <section class="add_booking_section">
        <article class="add_new_booking_box">
            <div class="action_btn text-end page_btn" style="margin-top: 100px">
                {{-- <button type="button" class="btn add_new_booking_btn">
                    <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon" class="img-fluid add_booking_icon" />
                    <span class="text_button">Settings</span>
                </button> --}}
            </div>
        </article>
    </section>
    <section class="table_all_content">
        <article class="table_container top_header_text">
            <h1 class="main_heading">Settings</h1>
            @include('company.company_flash_message')
            <nav aria-label="breadcrumb" class="pageBreadcrumb">
                <ol class="breadcrumb tab_lnks">
                   @can('isCompany')
                    <li class="breadcrumb-item"><a class="tabs_links_btns active" href="#listView">Company Information</a></li>
                    @endcan

                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ Auth::user()->user_type==5?'active':'' }}" href="#monthView">Admin Profile</a></li>
                    @can('isCompany')
                    <li class="breadcrumb-item"><a class="tabs_links_btns theme-design-tab" href="#weekView">Theme Design</a></li>
                    @endcan

                </ol>
            </nav>

            @can('isCompany')

                <div id="listView" class="resume">
                    <section class="form_add_managers">
                        <article class="form_inside">
                            <form class="add_managers inside_custom_form" method="POST" action="{{ route('company.updateCompanyInformation') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="container-fluid form_container">
                                    <div class="row m-0 w-100">
                                        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                            <div class="row w-100 m-0 gx-2">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="text" class="form-control main_field" value="{{ @$company->name }}" name="name" placeholder="Name" aria-label="Name">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="email" name="email" value="{{ @$company->email }}" class="form-control main_field" placeholder="Email" aria-label="Email">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="hidden" id="country_code" name="country_code" value="{{ @$company->country_code }}">
                                                    <input type="text" id="phone" name="phone" value="{{ @$company->phone }}" class="form-control main_field" placeholder="Enter Phone Number" aria-label="Phone Number">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="text" class="form-control main_field" name="city" value="{{ @$company->city }}" placeholder="City" aria-label="City">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="text" class="form-control main_field" placeholder="State" name="state" value="{{ @$company->state }}" aria-label="State">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="text" class="form-control main_field" name="street" value="{{ @$company->street }}" placeholder="Street" aria-label="Street name">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="text" class="form-control main_field" name="zip_code" value="{{ @$company->zip }}" placeholder="Zipcode" aria-label="Zipcode">
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                    <input type="text" class="form-control main_field" placeholder="Country" aria-label="Country" name="country" value="{{ @$company->country }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="img_preview position-relative desktop_view" style="display: table-caption;width:90px">
                                                        <h6 class="smalltxt">Logo</h6>
                                                        <input type="file" class="photo form-control main_field position-relative" id="cLogo" name="logo">

                                                        
                                                        <img src="{{ @$company->logo ?  env('URL_PUBLIC').'/'.$company->logo:asset('new-design-company/assets/images/image-uploaded.png') }}" style="margin-top: 25px" class="img-fluid avtar_preview imgs_uploaded_view imgPreview" alt="Select Avatar" id="cLogoImgPreview"/>
                                                   
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form_btn text-end mobile_margin" style="margin-top:10%">
                                                <button type="submit" class="btn save_form_btn">Update Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </article>
                    </section>
                </div>
            @endcan
            <!-- /List View -->

            <div id="monthView" class="resume next-tabs" style="display:{{ Auth::user()->user_type==5?'block':'none' }}">
                <section class="form_add_managers">
                    <article class="form_inside">
                        <form class="add_managers inside_custom_form" action="{{ route('company.updatePersonalInformation') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="container-fluid form_container">
                                <div class="row m-0 w-100">
                                    <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                        <div class="row w-100 m-0 gx-2">
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                <input type="text" class="form-control main_field" placeholder="Name" aria-label="First name"  name="name" value="{{ Auth::user()->name }}" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                <input type="email" class="form-control main_field" placeholder="Email" aria-label="Email" name="email" value="{{ Auth::user()->email }}" required readonly>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                <input type="hidden" name="country_code_admin" id="country_code_admin" name="country_code" value="{{ Auth::user()->country_code }}">
                                                <input type="tel" id="phone_admin" class="form-control main_field" placeholder="Enter Phone Number" aria-label="Phone Number" name="phone" value="{{ Auth::user()->phone }}">
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                <input type="password" class="form-control main_field" placeholder="Password" aria-label="Password" name="password" >
                                                <span class="error-span">Enter Password If you want to change</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                        <div class="img_preview position-relative desktop_view">
                                            <input type="file" class="photo form-control main_field position-relative" name="image" id="cImage">
                                            <img src="{{ Auth::user()->image?env('URL_PUBLIC').'/'.Auth::user()->image:asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid avtar_preview imgPreview" id="cImageImgPreview" alt="Select Avatar" />
                                        </div>
                                        <div class="form_btn text-end mobile_margin">
                                            <button type="submit" class="btn save_form_btn">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </article>
                </section>
            </div>

            <div id="weekView" class="resume next-tabs">
                <section class="form_add_managers">
                    <article class="form_inside">
                    <form class="add_managers inside_custom_form" method="POST" action="{{ route('company.updateCompanyThemeInformation') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="container-fluid form_container">
                                <div class="row m-0 w-100">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 mobile_view">
                                        <h6 class="smalltxt">Background</h6>
                                        <div class="form-check position-relative text-center p-0 mobile_avatar_top">
                                            <label class="form-check-label mb-3 setting_labels" for="" >
                                                Theme
                                            </label>
                                            <img src="assets/images/uploaded.png" alt="Logo" class="img-fluid big_upload upload_logo w-100">
                                            <input type="file" class="form-control main_field uploadLogos text-center p-0" placeholder="" value="16" >
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-md-9 col-sm-12 col-12">
                                        <h6 class="smalltxt">Header</h6>
                                        <div class="row w-100 m-0 gx-2">
                                            <div class="col-lg-1 col-md-1 col-sm-2 col-2 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0">
                                                    <label class="form-check-label mb-3 setting_labels" for="orange">
                                                        Color
                                                    </label>
                                                    <span class="colorType mx-auto" style=" background-color: {{ !empty($company->header_color) ? $company->header_color  : '#FC4C02' }} "></span>
                                                    <input type="color" class="form-control main_field colorSlt" name="header_color" value="{{ !empty($company->header_color) ? $company->header_color  : '#FC4C02' }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-3 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0 ">
                                                    <label class="form-check-label mb-3 setting_labels" for="orange">
                                                        Font
                                                    </label>
                                                    <select class="form-control main_field fontStyle text-center p-0" name="header_font_family" >
                                                  
                                                    <option value="">Select Font</option>
                                                    <option value="Times-new-roman" {{ $company->input_font_family == 'Oswald' ? "selected" : ''}} > Oswald</option>
                                                    <option value="Times-new-roman" {{ $company->header_font_family == 'Times-new-roman' ? "selected" : ''}} > Times New Roman</option>
                                                    <option value="Arial" {{ $company->header_font_family == 'Arial' ? "selected" : ''}}>Arial</option>
                                                    <option value="Algerian" {{ $company->header_font_family == 'Algerian' ? "selected" : ''}}>Algerian</option>
                                                    <option value="Berlin-sans-fb" {{ $company->header_font_family == 'Berlin-sans-fb' ? "selected" : ''}}>Berlin Sans FB</option>
                                                    <option value="Fantasy" {{ $company->header_font_family == 'Fantasy' ? "selected" : ''}}>Fantasy</option>
                                                    <option value="Cursive" {{ $company->header_font_family == 'Cursive' ? "selected" : ''}}>cursive</option>
                                                    <option value="Verdana" {{ $company->header_font_family == 'Verdana' ? "selected" : ''}}>Verdana</option>
                                                    <option value="Fearless" {{ $company->header_font_family == 'Fearless' ? "selected" : ''}}>Fearless</option>


                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-4 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0">
                                                    <label class="form-check-label mb-3 setting_labels" >
                                                        Font Color
                                                    </label>
                                                    <span class="colorType mx-auto" style=" background-color: {{ !empty($company->header_font_color) ? $company->header_font_color  : '#FFFFFF' }} "></span>
                                                    <input type="color" class="form-control main_field colorSlt" name="header_font_color" placeholder="Name" value="{{ !empty($company->header_font_color) ? $company->header_font_color  : '#FFFFFF' }}" >
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-3 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0">
                                                    <label class="form-check-label mb-3 setting_labels" for="" >
                                                        Font Size
                                                    </label>
                                                    <input type="number" min="16" max="22" class="form-control main_field fontStyle text-center p-0" name="header_font_size" placeholder="" value="{{ !empty($company->header_font_size) ? $company->header_font_size  : '16' }}" >
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-3 col_form_settings mb-2 ">
                                                <div class="form-check position-relative text-center p-0 logoBx_prev ">
                                                    <label class="form-check-label mb-3 setting_labels" for="" >
                                                        Logo
                                                    </label>
                                                    <img src="{{ @$company->logo?env('URL_PUBLIC').'/'.$company->logo:asset('new-design-company/assets/images/image-uploaded.png') }}" class="img-fluid upload_logo" alt="Select Avatar" id="cLogoImgPreview2"/>
                                                    <input type="file" class="form-control main_field uploadLogos text-center p-0" id="cLogo2" name="logo">
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="smalltxt">Input field</h6>
                                        <div class="row w-100 m-0 gx-2">
                                            <div class="col-lg-1 col-md-1 col-sm-2 col-2 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0">
                                                    <label class="form-check-label mb-3 setting_labels" for="orange">
                                                        Color
                                                    </label>
                                                    <span class="colorType mx-auto" style=" background-color: {{ !empty($company->input_color) ? $company->input_color  : '#F9F9F9' }} "></span>
                                                    <input type="color" class="form-control main_field colorSlt" name="input_color" value="{{ !empty($company->input_color) ? $company->input_color  : '#F9F9F9' }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-3 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0 ">
                                                    <label class="form-check-label mb-3 setting_labels" for="orange">
                                                        Font
                                                    </label>
                                                    <select class="form-control main_field fontStyle text-center p-0" name="input_font_family">

                                                    <option value="">Select Font</option>
                                                    <option value="Times-new-roman" {{ $company->input_font_family == 'Oswald' ? "selected" : ''}} > Oswald</option>
                                                    <option value="Times-new-roman" {{ $company->input_font_family == 'Times-new-roman' ? "selected" : ''}} > Times New Roman</option>
                                                    <option value="Arial" {{ $company->input_font_family == 'Arial' ? "selected" : ''}}>Arial</option>
                                                    <option value="Algerian" {{ $company->input_font_family == 'Algerian' ? "selected" : ''}}>Algerian</option>
                                                    <option value="Berlin-sans-fb" {{ $company->input_font_family == 'Berlin-sans-fb' ? "selected" : ''}}>Berlin Sans FB</option>
                                                    <option value="Fantasy" {{ $company->input_font_family == 'Fantasy' ? "selected" : ''}}>Fantasy</option>
                                                    <option value="Cursive" {{ $company->input_font_family == 'Cursive' ? "selected" : ''}}>cursive</option>
                                                    <option value="Verdana" {{ $company->input_font_family == 'Verdana' ? "selected" : ''}}>Verdana</option>
                                                    <option value="Fearless" {{ $company->input_font_family == 'Fearless' ? "selected" : ''}}>Fearless</option>

                                                   
                                                    

                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-4 col-4 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0">
                                                    <label class="form-check-label mb-3 setting_labels" >
                                                        Font Color
                                                    </label>
                                                    <span class="colorType mx-auto" style=" background-color: {{ !empty($company->input_font_color) ? $company->input_font_color  : '#666666' }} "></span>
                                                    <input type="color" class="form-control main_field colorSlt" placeholder="Name" name="input_font_color" value="{{ !empty($company->input_font_color) ? $company->input_font_color  : '#666666' }}" >
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-2 col-sm-3 col-3 col_form_settings mb-2">
                                                <div class="form-check position-relative text-center p-0">
                                                    <label class="form-check-label mb-3 setting_labels" for="" >
                                                        Font Size
                                                    </label>
                                                    <input type="number" min="16" max="22" class="form-control main_field fontStyle text-center p-0" name="input_font_size" placeholder="" value="{{ !empty($company->input_font_size) ? $company->input_font_size  : '16' }}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-12 img_preview position-relative desktop_view">
                                        
                                        <h6 class="smalltxt desktop_view">Background</h6>
                                        <div class="form-check position-relative text-center p-0 desktop_view">
                                            <label class="form-check-label mb-3 setting_labels" for="" >
                                                Theme
                                            </label>
                                            <img src="{{ @$company->background_image?env('URL_PUBLIC').'/'.$company->background_image:asset('new-design-company/assets/images/image-uploaded.png') }}" class="img-fluid big_upload upload_logo w-100" alt="Select Avatar" id="cBackgroundImageImgPreview"/>
                                            <input type="file" min="14" max="18" class="form-control main_field uploadLogos text-center p-0" id="cBackgroundImage" name="background_image">
                                        </div>

                                        <div class="form_btn text-end mobile_margin d-flex">
                                            <button type="button" companyid="{{ !empty($company->id) ? $company->id  : '' }}"  class=" btn save_theme_design_form_btn reset-theme-design">Reset Changes</button>
                                            <button type="submit" class="btn save_theme_design_form_btn">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </article>
                </section>
            </div>
            <!-- /week View -->
        </article>
    </section>
@endsection
@section('footer_scripts')
    <script>



    $(document).ready(function() {
        $('.colorSlt').change(function() {
            $(this).closest(".form-check").find('.colorType').css('background-color', $(this).val());
        });
    });


    $('#phone, #phone_edit').keyup(function () { 
        this.value = this.value.replace(/[^0-9+\.]/g,'');
    });
    
    $("#phone, #phone_edit").on("blur", function(e){

        var conuntrycode = $('#country_code').val();
        var mobNum = $(this).val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(mobNum)) {
            return true;
            // if(mobNum.length==10){
            //     return true;  
            // } else {
            //     $(this).val('')
            //     return false;
            // }
        }
        else if(mobNum.startsWith("+")){
            var temp = mobNum.substring(conuntrycode.length + 1 , mobNum.length);
            mobile = temp;
            $(this).val(mobile)
            return true; 
        } else {
            $(this).val('')
            return false;
        }

    });
        
        if ($('#phone').length > 0)
        {
            var input = document.querySelector("#phone");
            var iti = window.intlTelInput(input, {
                initialCountry: "auto",
                geoIpLookup: function (success, failure) {
                    $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "us";
                        success(countryCode);
                    });
                },
                initialCountry:"us",
                separateDialCode: true,
                utilsScript: "{{url('assets/js/utils.js')}}",
                autoFormat: false,
                nationalMode: true,
                customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                    return "";
                },
            });
            iti.promise.then(function() {
                input.addEventListener("countrychange", function() {
                    var selectedCountryData = iti.getSelectedCountryData();
                    $('#country_code').val(selectedCountryData.dialCode);
                });
            });
        }

        var inputAdmin = document.querySelector('#phone_admin');
        var itiAdmin = window.intlTelInput(inputAdmin, {
            initialCountry: "auto",
            geoIpLookup: function (success, failure) {
                $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "us";
                    success(countryCode);
                });
            },
            initialCountry:"us",
            nationalMode: true,
            separateDialCode: true,
            utilsScript: "{{url('assets/js/utils.js')}}",
            autoFormat: false,
            customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
                return "";
            },
        });
        itiAdmin.promise.then(function() {
            inputAdmin.addEventListener("countrychange", function() {
                var selectedCountryData = itiAdmin.getSelectedCountryData();
                $('#country_code_admin').val(selectedCountryData.dialCode);
            });
        });

        $(document).ready(function(){
            var code = "{{@$company->country_code}}";
            var phone = "{{@$company->phone}}";
            setTimeout(() => {
                iti.setNumber("+"+code + phone);
                $("#phone").val(phone);

            }, 500);

        });

        $(document).ready(function(){

            var code = "{{ Auth::user() && Auth::user()->country_code ? Auth::user()->country_code : '' }}";
            var phone = "{{ Auth::user() && Auth::user()->phone ? Auth::user()->phone : '' }}";
            setTimeout(() => {
                itiAdmin.setNumber("+"+code + phone);
                $("#phone_admin").val(phone);
            }, 500);

        });

        $(document).on('click','.reset-theme-design',function () {
            var companyId = $(this).data('companyid');
            Swal.fire({
                title: "{{ __('Please Confirm') }}",
                text: "{{ __('Reset theme design ?') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('Confirm') }}"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('company.updateCompanyThemeInformation') }}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'company_id': companyId,
                            'reset_theme_design':'reset_theme_design'

                        },
                        success: function(response) {
                            Swal.fire("Success", 'Theme design reset successfully', "success");
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        },
                        error(response) {
                            swal.fire("{{ __('Error') }}", '', "error");
                        }
                    });
                }
            });
        });


        $(document).ready(function () {
            var currentURL = (document.URL);
            var part = currentURL.split("#")[1];
            setTimeout(function() {
                if(part == 'weekView'){
                    $(".theme-design-tab").trigger("click");
                }
            }, 1000);
        });
        


    </script>
@endsection
