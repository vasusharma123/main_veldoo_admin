@extends('layouts.guest')
@section('content')
<style>

.dashbaord_bodycontent {
    padding: 50px 32px 50px 32px;
}
</style>
<section class="login_form_section">

                <article class="login_form_container container-fluid">

                    <div class="row">

                        <div class="login_form_content col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="login_form_box_cover">

                                <form class="login_form" action="{{ url('do-register-guest')}}" method="post" autocomplete="off">
                                @csrf

                                    <div class="form-row">

                                        <div class="col-12 p-0">


                                            <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="Logo" class="img-fluid logo_img"/>


                                            <div class="form_title text-center">
                                                <h4 class="sub_title">Register</h4>
                                                <p class="tagline">Register to create an account</p>
                                                <hr class="divider_form" />
                                            </div>
                                            <!-- /Form Title -->

                                        </div>
                                        <!-- /Col -->

                                        <div class="col-12">

                                        
                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Name</label>
                                                <div class="field position-relative">
                                                    <input type="text" name="first_name" class="form-control loginField" value="{{ old('first_name') }}" placeholder="Enter your name" />
                                                    <img src="{{ asset('new-design-company/assets/images/user2.png') }}" class="img-fluid loginFieldIcon" alt="Email envelope"/>
                                                </div>
                                                @error('first_name')
                                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Surname</label>
                                                <div class="field position-relative">
                                                    <input type="text" name="last_name" class="form-control loginField" value="{{ old('last_name') }}" placeholder="Enter your surname" />
                                                    <img src="{{ asset('new-design-company/assets/images/user2.png') }}" class="img-fluid loginFieldIcon" alt="Email envelope"/>

                                                </div>
                                                @error('last_name')
                                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                                @enderror 
                                            </div>

                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Mobile Number</label>
                                                <div class="field position-relative">
                                                <input type="hidden" value="+1" class="country_code" value="{{ old('country_code') }}" id="country_code" name="country_code" />
                                                    <input type="text" id="phone" name="phone" value="{{ old('phone') ? old('phone') : \Request::get('phone') }}" class="form-control loginField" placeholder="Enter Number" aria-label="Phone Number" readonly>
                                                    <!-- <input type="email" name="username" class="form-control loginField" placeholder="Enter username or email" required/> -->
                                                    <!-- <img src="assets/images/envelope.png" class="img-fluid loginFieldIcon" alt="Email envelope"/> -->
                                                </div>
                                                @error('phone')
                                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                                @enderror 
                                                @error('country_code')
                                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Email</label>
                                                <div class="field position-relative">
                                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control loginField" placeholder="Enter your email" />
                                                    <img src="{{ asset('new-design-company/assets/images/envelope.png') }}" class="img-fluid loginFieldIcon" alt="Email envelope"/>
                                                </div>
                                                @error('email')
                                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                                @enderror
                                            </div>
                                           
                                            
                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Password</label>
                                                <div class="field position-relative">
                                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control loginField" placeholder="Enter Password" />
                                                    <img src="{{ asset('new-design-company/assets/images/password_lock.png') }}" class="img-fluid loginFieldIcon" alt="Password Lock"/>
                                        <img src="{{ asset('new-design-company/assets/images/see_password.png') }}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock"/>
                                                </div>
                                                @error('password')
                                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Confirm Password</label>
                                                <div class="field position-relative">
                                                    <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" class="form-control loginField" placeholder="Re-enter your password" />
                                                   
                                                    <img src="{{ asset('new-design-company/assets/images/password_lock.png') }}" class="img-fluid loginFieldIcon" alt="Password Lock"/>
                                                    <img src="{{ asset('new-design-company/assets/images/see_password.png') }}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock"/>
                                                </div>
                                                @error('confirm_password')
                                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                                @enderror                                            </div>

                                            <div class="form-group position-relative">
                                                <div class="option_fields">
                                                    <div class="form-check d-flex w-100 align-items-center">
                                                        <input class="form-check-input form_checkbox" type="checkbox" value="" id="remember_me">
                                                        <label class="form-check-label form-lable w-100" for="remember_me">
                                                            Agree with terms and conditions.
                                                            <a href="{{route('guest.login')}}" class="link_hyper">Already have an account?</a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group position-relative">
                                                <div class="row w-100 m-0">
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <button type="button" class="btn submit_btn">
                                                            <!-- <span class="btn_text">Back</span> -->
                                                            <a href="{{route('booking_taxisteinemann')}}" class="btn_text">Back</a>
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <button type="submit" class="btn submit_btn voilet_bg">
                                                            <span class="btn_text">Register</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                        <!-- /Col -->

                                    </div>
                                    <!-- /Form Row -->

                                </form>

                            </div>
                            <!-- /Login Form Box Cover -->

                        </div>
                        <!-- /Login Form Content -->

                    </div>

                </article>

            </section>
@endsection

@section('footer_scripts')
<script>
    $('#phone, #phone_edit').keyup(function () { 
        this.value = this.value.replace(/[^0-9+\.]/g,'');
    });
    
    $("#phone, #phone_edit").on("blur", function(e){

        var conuntrycode = $('#country_code').val();
        var mobNum = $(this).val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(mobNum)) {
            if(mobNum.length==10){
                return true;  
            } else {
                $(this).val('')
                return false;
            }
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

    $( document ).ready(function() {
        var code = "{{Request::get('code')}}";
        var phone = "{{Request::get('phone')}}";
        iti.setNumber("+"+code);
        $("#phone").val(phone);
    });





</script>
@endsection

