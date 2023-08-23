@extends('layouts.guest')
@section('content')

<style>
       .iti__selected-flag {
    margin-left: 11px;
    border-right: 1px solid rgba(17, 29, 53, .3);
    height: 30px;
    margin-top: 13px;
}
.iti--allow-dropdown input, .iti--allow-dropdown input[type=tel]{
    margin-bottom: 24px !important;
    padding-left: 24px;
}
.invalid_field .iti--allow-dropdown input, .invalid_field .iti--allow-dropdown input[type=tel]{
    margin-bottom: 0px !important;
}
</style>

<section class="login_form_section">

<article class="login_form_container container-fluid">

    <div class="row">

        <div class="login_form_content col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

            <div class="login_form_box_cover">

                <form class="login_form" action="{{ url('do-login-guest')}}" method="post" autocomplete="off">
                        @csrf
                        @include('company.company_flash_message')

                    <div class="form-row">

                        <div class="col-12 p-0">

                            <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="Logo" class="img-fluid logo_img"/>
                          
                            <!-- @if(\Request::get('token'))
                            <a href="{{ route('booking_taxisteinemann',['token' => \Request::get('token')]) }}" class="link_hyper">Back</a>
                            @else 
                            <a href="{{ route('booking_taxisteinemann',['token' => \Request::get('token')]) }}" class="link_hyper">Back</a>
                            @endif -->

                            <div class="form_title text-center">
                                <h4 class="sub_title">Log in</h4>
                                <p class="tagline">Please login to continue</p>
                                <hr class="divider_form" />
                            </div>
                            <!-- /Form Title -->

                        </div>
                        <!-- /Col -->

                        <div class="col-12">
                            
                            <div class="form-group position-relative has_validation">
                                <label class="form-lable">Mobile Number</label>
                                <div class="field position-relative">
                                <input type="hidden" value="+1" class="country_code" id="country_code" name="country_code" />
                                    <input type="tel" id="phone" name="phone" class="form-control loginField" placeholder="Enter Number" aria-label="Phone Number">
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
                                <label class="form-lable">Password</label>
                                <div class="field position-relative">
                                    <input type="password" name="password" class="form-control loginField" placeholder="Enter Password"/>
                                    <img src="{{ asset('new-design-company/assets/images/password_lock.png') }}" class="img-fluid loginFieldIcon" alt="Password Lock"/>
                                        <img src="{{ asset('new-design-company/assets/images/see_password.png') }}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock"/>
                                </div>

                                @error('password')
                                    <p class="erro d-none mb-0">{{ $message }}</p>
                                @enderror 
                               

                                <!-- <p class="erro d-none mb-0">Invalid email or password. Try again or click Forgot password to reset it.</p> -->

                            </div>

                            <div class="form-group position-relative">
                                <div class="option_fields">
                                    <div class="form-check d-flex w-100 align-items-center">
                                        <input class="form-check-input form_checkbox" type="checkbox" value="" id="remember_me">
                                        <label class="form-check-label form-lable w-100" for="remember_me">
                                            Remember Me 
                                            <a href="javascript:void(0)" class="link_hyper">Forgot Password?</a>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group position-relative">
                                <button type="submit" class="btn submit_btn">
                                    <span class="btn_text">Sign In</span>
                                </button>
                            </div>

                            <div class="col-12 p-0">


                            <div class="form_title text-center">
                                <!-- <a href="{{route('guest.register')}}" class="tagline sign-up-account">Don't have an account? Sign up</a> -->
                                <a href="javascript:void(0)" class="user_name cs_link sd d-block tagline sign-up-account" data-bs-toggle="modal" data-bs-target="#otpModal">Don't have an account? Sign up</a>
                                <hr class="divider_form" />
                            </div>
                            <!-- /Form Title -->

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



<div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true" >
<button type="button" class="btn-close modalClose" data-bs-dismiss="modal" aria-label="Close">&times;</button>
     
<div class="modal-dialog modal-lg modal-dialog-centered">
    
    <div class="modal-content p-0 border-0 bg-transparent">
       
       
      <div class="modal-body p-0 border-0 bg-transparent">
        
      <section class="login_form_section">

        <article class="login_form_container container-fluid">

            <div class="row">

                <div class="login_form_content col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                    <div class="login_form_box_cover">

                        <form class="login_form to-continue-login-form" id="toContinueLoginForm" action="" method="post" autocomplete="off">
                        @csrf
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="{{ env('RECAPTCHA_KEY') }}">

                            <div class="form-row">

                                <div class="col-12 p-0">

                                <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="Logo" class="img-fluid logo_img"/>

                                    <div class="form_title text-center">
                                        <h4 class="sub_title">Not Logged in</h4>
                                        <p class="tagline">To continue enter mobile number</p>
                                        <!-- <p class="tagline">To continue enter mobile number, or <a href="{{route('guest.register')}}" class="hyperinline">Register</a></p> -->
                                        <hr class="divider_form" />
                                    </div>
                                    <!-- /Form Title -->

                                </div>
                                <!-- /Col -->

                                <div class="col-12">
                                    
                                    <div class="form-group position-relative has_validation">
                                        <label class="form-lable">Mobile Number</label>
                                        <div class="field position-relative">
                                        <input type="hidden" value="+1" class="country_code" id="countryCodeId" name="country_code" />
                                        <input type="text" name="phone" id="phoneNumber" class="form-control loginField otpnumberenter" placeholder="Enter Number" aria-label="Phone Number">
                                        </div>
                                        <!-- @error('phone')
                                            <p class="erro d-none mb-0">{{ $message }}</p>
                                        @enderror  -->
                                        <p class="erro d-none mb-0 error-message-phone"></p>

                                    </div>
                                
                                    
                                    <div class="form-group position-relative has_validation text-center otpcode_box">
                                        <label class="form-lable boldlable">OTP code</label>
                                        <div class="field position-relative otp-box d-flex">
                                        <input type="text" id="digit-1" name="digit-1" class="form-control loginField otpfil px-2 text-center"  placeholder="_"/>
                                        <input type="text" id="digit-2" name="digit-2" class="form-control loginField otpfil px-2 text-center"  placeholder="_"/>
                                        <input type="text" id="digit-3" name="digit-3" class="form-control loginField otpfil px-2 text-center"  placeholder="_"/>
                                        <input type="text" id="digit-4" name="digit-4" class="form-control loginField otpfil px-2 text-center"  placeholder="_"/>
                                        </div>
                                        <!-- <p class="erro d-none mb-0">Invalid OTP code. <a href="#" class="hyperinline">Resend OTP</a> 90 sec.</p> -->
                                        <p class="erro d-none mb-0"><a href="javascript:void(0);" class="hyperinline confirmOTPModalTimer confirmOTPModalResendOtp">Resend OTP</a></p>

                                    </div>

                                

                                    <!-- <div class="form-group position-relative">
                                        <button type="button" class="btn submit_btn otpsubmit">
                                            <span class="btn_text">Continue</span>
                                        </button>
                                    </div> -->
                                    <div class="form-group position-relative">
                                        <button type="submit" class="btn submit_btn otpsubmit custom_btn verify_otp">
                                            <span class="btn_text">Continue</span>
                                        </button>
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
        <!-- /Login Form Section -->
      </div>
     
    </div>
  </div>
</div>

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






    $('#phoneNumber').keyup(function () { 
        this.value = this.value.replace(/[^0-9+\.]/g,'');
    });
    
    $("#phoneNumber").on("blur", function(e){

        var conuntrycode = $('#countryCodeId').val();
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


    var input = document.querySelector("#phoneNumber");
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
            $('#countryCodeId').val(selectedCountryData.dialCode);
        });
    });


    $('.submit_btn').on('click',function(){
        $('.form-control').each(function() {
            var $input = $(this);
            if ($input.val() == '') {
                var $parent = $input.closest('.has_validation');
                $parent.addClass('invalid_field');
            } else {
                $(".otpcode_box").css("display", "block");
                var $parent = $input.closest('.has_validation');
                $parent.removeClass('invalid_field');
            }
        });
    });


    function timer(remaining,timerClass,confirmOTPModalResendOtpClass) {
           // $('.'+confirmOTPModalResendOtpClass).hide();
            $('.'+timerClass).show();
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;
            
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            // console.log(timerClass);
            // console.log(s);
            if(s > 0) {
                $('.'+timerClass).html('{{ __("Resend OTP in") }} ' + s);
            } else {
                $('.'+timerClass).html('{{ __("Resend OTP") }} ');
            }

            // document.getElementById(id).innerHTML = 
            remaining -= 1;
            
            if(remaining >= 0) {
                setTimeout(function() {
                    timer(remaining,timerClass,confirmOTPModalResendOtpClass);
                }, 1000);
                return;
            }

            
            // Do timeout stuff here
            // alert('Timeout for otp');
            $('.'+confirmOTPModalResendOtpClass).show();
           // $('.'+timerClass).hide();
        }


    $(document).on('click','.confirmOTPModalResendOtp',function(){
        $.ajax({
            url: "{{ route('send_otp_before_ride_booking')}}",
            type: 'post',
            dataType: 'json',
            data: $('form#toContinueLoginForm').serialize(),
            success: function(response) {
                if(response.status){
                    $("#confirmOTPModal").modal('show');
                    timer(30,"confirmOTPModalTimer","otp_not_rec");
                } else if(response.status == 0){
                    new swal("{{ __('Error') }}",response.message,"error");
                    $(document).find(".verify_otp").removeAttr('disabled');
                }
            },
            error(response) {
                new swal("{{ __('Error') }}",response.message,"error");
                $(document).find(".verify_otp").removeAttr('disabled');
            }
        });
    });


    $(document).on('keyup', '#digit-1,#digit-2,#digit-3,#digit-4', function(ev){
        var phoneNumber = $('#phoneNumber').val();
        var otp_entered = $("#digit-1").val()+$("#digit-2").val()+$("#digit-3").val()+$("#digit-4").val();
        if(phoneNumber > 1 && otp_entered.toString().length >= 4) {
            $(document).find(".verify_otp").removeAttr('disabled');
        } else {
            $(document).find(".verify_otp").attr('disabled',true);
        }
    });



    $(document).on("submit", "#toContinueLoginForm", function(e) {
        e.preventDefault();
        var phoneNumber = $('#phoneNumber').val();
        var otp_entered = $("#digit-1").val()+$("#digit-2").val()+$("#digit-3").val()+$("#digit-4").val();
        if(phoneNumber > 1) {
            $('.otpcode_box').removeClass('invalid_field');
            $(".otpcode_box").css("display", "block");
            $('.error-message-phone').text('');

        } else {
            $('.otpcode_box').addClass('invalid_field');
            $(".otpcode_box").css("display", "none");
            $('.error-message-phone').text('Mobile number is required');
            return false;
        }

        if(phoneNumber > 1 && otp_entered.toString().length >= 4) {
            var url = "{{ route('verify_otp_before_register')}}";
        } else {
            var url = "{{ route('send_otp_before_register')}}"
        }

        var post_data = $('form#toContinueLoginForm').serialize();
        post_data += '&otp='+otp_entered;
        $(document).find(".verify_otp").attr('disabled',true);
        <?php
            $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            if (strpos($url,'taxisteinemann') !== false) {
                ?>
                    post_data += '&url_type=taxisteinemann';
                <?php
            } else {
                ?>
                    post_data += '&url_type=taxi2000';
                <?php
            }
        ?>
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: post_data,
            success: function(response) {
                console.log(response);
                if(response.status == 1) {
                    timer(30,"confirmOTPModalTimer","otp_not_rec");
                    new swal("{{ __('Success') }}",response.message,"success");
                } else if(response.status == 2) {

                   // var currentURL = (document.URL); // returns http://myplace.com/abcd
                   // var part = currentURL.split("/")[1];

                    var origin  = window.location.origin;
                    var route = origin+'/guest-register?code='+response.code+'&phone='+response.phone;
                    window.location.href = route;

                    new swal("{{ __('Success') }}",response.message,"success");

                } else if(response.status == 0){
                    new swal("{{ __('Error') }}",response.message,"error");
                    $(document).find(".verify_otp").removeAttr('disabled');
                }
            },
            error(response) {
                new swal("{{ __('Error') }}",response.message,"error");
                $(document).find(".verify_otp").removeAttr('disabled');
            }
        });
    })

</script>
@endsection

