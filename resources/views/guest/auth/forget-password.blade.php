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

                                <form class="login_form" action="{{ route('change.forget.password', \Request::get('slugRecord')->slug)}}" method="post" autocomplete="off">
                                @csrf
                                <input type="hidden" name="auth_token" value="{{ \Request::get('token') }}" />
                                    <div class="form-row">

                                        <div class="col-12 p-0">


                                            <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="Logo" class="img-fluid logo_img"/>


                                            <div class="form_title text-center">
                                                <h4 class="sub_title">Reset Password</h4>
                                                <!-- <p class="tagline">Register to create an account</p> -->
                                                <hr class="divider_form" />
                                            </div>
                                            <!-- /Form Title -->

                                        </div>
                                        <!-- /Col -->

                                        <div class="col-12">
                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">New Password</label>
                                                <div class="field position-relative">
                                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control loginField" placeholder="Enter New Password " />
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
                                                <div class="row w-100 m-0">
                                                <div class="col-lg-6 col-sm-6 col-12">
                                                        <button type="button" class="btn submit_btn">
                                                            <!-- <span class="btn_text">Back</span> -->
                                                            <a href="{{route('guest.rides', \Request::get('slugRecord')->slug)}}" class="btn_text back-btn-text">Back</a>
                                                        </button>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-6 col-12">
                                                        <button type="submit" class="btn submit_btn voilet_bg">
                                                            <span class="btn_text">Update</span>
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

