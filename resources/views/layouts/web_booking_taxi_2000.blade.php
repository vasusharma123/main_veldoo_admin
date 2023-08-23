<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __(env('APP_NAME')) }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
    <link href="{{ URL::asset('assets/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('datetime/css/bootstrap-datetimepicker.css') }}">
    @if(!empty($setting['admin_favicon']) && file_exists($setting['admin_favicon']))
		<link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset($setting['admin_favicon']) }}">
	@else
		<link rel="icon" type="image/png" sizes="16x16" href="//veldoo.com/storage/setting/admin-favicon.png">
	@endif
    @yield('css')
    <style>
        .parsley-errors-list
        {
            list-style: none;
            padding: 0px;
            margin: 0px;
            font-size: 13px;
            color: red;
            padding-left: 5px;
        }

        
        .form-control.input_otp {
            border: none;
            border-bottom: 1px solid #9B9B9B;
            border-radius: 0;
            text-align: center;
        }
        .form-control.input_otp:focus{
            box-shadow: none;
            border-color: #000;
        }
        .sub_desc_otp {
            margin-bottom: 30px;
            color: #000;
            font-size: 16px;
            font-weight: 400;
        }
        .otp_not_rec {
            font-size: 16px;
            color: #253239;
        }
        .otp_not_rec a {
            color: #cc4452;
        }
        .otp_modal_dialog:before{
            content: '';
            background: rgba(255,255,255 , 71%);
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(2px);
        }
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        }

        /* Firefox */
        input[type=number] {
        -moz-appearance: textfield;
        }
        .grecaptcha-badge
        {
            z-index: 999999;
        }
    </style>
</head>
<body>
    <section class="map-booking">
        <article class="container-fluid form_container">
            <div class="text-right">
                <form action="{{ route('changeLocale') }}" id="changeLocaleForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <select name="locale" onchange="$('#changeLocaleForm').submit()" id="change_locale">
                            <option value="en" {{ app()->getLocale()=="en"?'selected':'' }}>English</option>
                            <option value="de" {{ app()->getLocale()=="de"?'selected':'' }}>Deutsch</option>
                        </select>
                    </div>
                    <?php
                        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
                        if (strpos($url,'taxisteinemann') !== false) {
                            ?>
                                <input type="hidden" name="route" value="booking_taxisteinemann">
                            <?php
                        } else {
                            ?>
                                <input type="hidden" name="route" value="booking_taxi2000">
                            <?php
                        }
                    ?>
                </form>
            </div>
            <div class="form_wrapper">
                @yield('content')
            </div>
        </article>
    </section>
    @yield('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('datetime/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        if ($('.datetimepicker').length > 0) 
        {
            $(".datetimepicker").datetimepicker({
                format: 'ddd DD-MM-YYYY HH:mm',
                minDate: "{{ date('Y-m-d') }}",
                sideBySide: true,
            });
        }
    </script>
    <!-- Confirm Modal -->
    {{-- <div class="modal fade" id="confirmOTPModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmOTPModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <form class="otp_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmOTPModalTitle">{{ __('Enter OTP') }} :</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group my-4">
                                    <input type="text" class="form-control input_field"
                                        name="otp_entered" id="otp_entered"
                                        placeholder="{{ __('Please enter OTP') }}" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="justify-content:center">
                        <button type="button" class="btn custom_btn verify_otp">{{ __('Confirm Booking') }}</button>
                        <p class="confirmOTPModalTimer">{{ __("Resend OTP in") }} 30</p>
                        <a class="btn confirmOTPModalResendOtp" href="javascript:;" style="text-decoration: underline; display: none;">{{ __('Resend OTP') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="modal fade otp_modal_dialog" id="confirmOTPModal" tabindex="-1" role="dialog" aria-labelledby="otpModal_listTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width: 400px" role="document">
            <div class="modal-content border-0 p-4">
                <div class="modal-header border-0 pb-0">
                    <img src="{{ asset('images/verify.png')}}" class="modal_header_img img-fluid">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 class="otp_main_title mb-4">{{ __('Enter your verification code')}}</h4>
                    <p class="sub_desc_otp">{{ __('Fill in the 4-digits verification code which we have shared on your registered phone number.')}}</p>
                    
                    <h6 class="otp_sub_title">{{ __('OTP')}}</h6>
                    <form class="otp_form" id="otp_form">
                        <div class="row mb-4 digit-group" data-group-name="digits">
                            <div class="col-3">
                                <input type="number" class="form-control input_otp" id="digit-1" name="digit-1" data-next="digit-2" min="0" max="9" required>
                            </div>
                            <div class="col-3">
                                <input type="number" class="form-control input_otp"  id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" min="0" max="9" required>
                            </div>
                            <div class="col-3">
                                <input type="number" class="form-control input_otp" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" min="0" max="9" required>
                            </div>
                            <div class="col-3">
                                <input type="number" class="form-control input_otp" id="digit-4" name="digit-4" data-previous="digit-3" min="0" max="9" required>
                            </div>
                        </div>
                        <button type="submit" class="btn custom_btn verify_otp mt-2">{{ __('Confirm Booking') }}</button>
                    </form>
                </div>
                <div class="modal-footer border-0 d-block p-2">
                    <p class="confirmOTPModalTimer">{{ __('Resend OTP in') }} 30</p>
                    <p class="otp_not_rec" style="display: none;">{{__("Didn't receive any code?")}} <a class="btn confirmOTPModalResendOtp" href="javascript:void(0);">{{ __('Resend OTP') }}</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- cancel Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1" role="dialog"
        aria-labelledby="cancelBookingTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered w-100" role="document">
            <div class="modal-content p-4">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="cross_icons_img text-center">
                                <img src="{{ asset('images/cross.png') }}"
                                    class="img-responsive imagelogo_brand" alt="img Logo">
                            </div>
                            <div class="form-group mt-4 mb-0 text-center">
                                <h3 class="modal_title_cs">{{ __('Cancel Booking') }}</h3>
                                <p class="modal_desc_cs">{{ __('Are you sure you want to cancel this booking?') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn custom_btn mb-4 cancel_booking_confirmed">{{ __('Yes, cancel it') }}</button>
                    <button type="button" class="btn back_btn custom_btn close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">{{ __('Close') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).on('submit','.otp_form',function(e){
            e.preventDefault();
            var form = $(this);
            form.parsley().validate();
            if (form.parsley().isValid()){
                // alert('hlo');
                $('.verify_otp').trigger('click');
            }
        });

        $(document).find('.input_otp').each(function() {
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent().parent());

                if (e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));

                    if (prev.length) {
                        $(prev).select();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (
                        e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));

                    if (next.length) {
                        $(next).select();
                    } else {
                        if (parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>