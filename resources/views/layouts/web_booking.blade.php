<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __(env('APP_NAME')) }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
    <link href="{{ URL::asset('resources') }}/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" integrity="sha512-3M00D/rn8n+2ZVXBO9Hib0GKNpkm8MSUU/e2VNthDyBYxKWG+BftNYYcuEjXlyrSO637tidzMBXfE7sQm0INUg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('css')
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
                            <option value="de" {{ app()->getLocale()=="de"?'selected':'' }}>German</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="form_wrapper">
                @yield('content')
            </div>
        </article>
    </section>
    @yield('script')
    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmOTPModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmOTPModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <form class="otp_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmOTPModalTitle">Enter OTP :</h5>
                        <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group my-4">
                                    {{-- <label for="otp_entered">Please enter the OTP number
                                        you received on your applied mobile number
                                        :</label> --}}
                                    <input type="text" class="form-control input_field"
                                        name="otp_entered" id="otp_entered"
                                        placeholder="Please enter OTP" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn custom_btn verify_otp">Confirm Booking</button>
                    </div>
                </div>
            </form>
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
                                <img src="{{ asset('public/images/cross.png') }}"
                                    class="img-responsive imagelogo_brand" alt="img Logo">
                            </div>
                            <div class="form-group mt-4 mb-0 text-center">
                                <h3 class="modal_title_cs">Cancel Booking</h3>
                                <p class="modal_desc_cs">Are you sure you want to cancel this booking?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn custom_btn mb-4 cancel_booking_confirmed">Yes, cancel it</button>
                    <button type="button" class="btn back_btn custom_btn close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">Close</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>