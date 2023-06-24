@extends('company.layouts.app')
@section('content')
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
                    {{-- <li class="breadcrumb-item"><a class="tabs_links_btns" href="#weekView">Design</a></li> --}}
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
                                                    <input type="tel" id="phone" name="phone" value="{{ @$company->phone }}" class="form-control main_field" placeholder="Enter Phone Number" aria-label="Phone Number">
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
                                                        <input type="file" class="photo form-control main_field position-relative" name="logo">
                                                        <img src="{{ @$company->logo?env('URL_PUBLIC').'/'.$company->logo:asset('new-design-company/assets/images/image-uploaded.png') }}" style="margin-top: 25px" class="img-fluid avtar_preview imgs_uploaded_view imgPreview" alt="Select Avatar" id="imgPreview"/>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="img_preview position-relative desktop_view" style="display: table-caption;width:90px">
                                                        <h6 class="smalltxt">Background</h6>
                                                        <input type="file" class="photo form-control main_field position-relative" name="background_image">
                                                        <img src="{{ @$company->background_image?env('URL_PUBLIC').'/'.$company->background_image:asset('new-design-company/assets/images/image-uploaded.png') }}" style="margin-top: 25px" class="img-fluid avtar_preview imgs_uploaded_view imgPreview" alt="Select Avatar" id="imgPreview"/>
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
                                                <input type="email" class="form-control main_field" placeholder="Email" aria-label="Email" name="email" value="{{ Auth::user()->email }}" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                <input type="hidden" name="country_code_admin" id="country_code_admin" name="country_code" value="{{ Auth::user()->country_code }}">
                                                <input type="tel" id="phone_admin" class="form-control main_field" placeholder="Enter Phone Number" aria-label="Phone Number" name="phone" value="{{ Auth::user()->phone }}" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                                <input type="password" class="form-control main_field" placeholder="Password" aria-label="Password" name="password" >
                                                <span class="error-span">Enter Password If you want to change</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-12">
                                        <div class="img_preview position-relative desktop_view">
                                            <input type="file" class="photo form-control main_field position-relative" name="image">
                                            <img src="{{ Auth::user()->image?env('URL_PUBLIC').'/'.Auth::user()->image:asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid avtar_preview imgPreview" alt="Select Avatar" />
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
        </article>
    </section>
@endsection
@section('footer_scripts')
    <script>
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
    </script>
@endsection
