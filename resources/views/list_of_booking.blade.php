@extends('layouts.web_booking')
@section('css')
    <style>
        .input_check_box {
            position: relative;
        }
        #flexCheckChecked {
            visibility: hidden;
        }
        .check_status {
            background: transparent;
            width: 18px;
            height: 18px;
            /* background: red; */
            position: absolute;
            left: -8%;
            top: 3px;
            border: 2px solid #000;
            border-radius: 2px;
        }
        #flexCheckChecked:checked ~ .check_status {
            background: url(../../images/checkbox.png);
            background-size: cover;
            border: none;
        }
        .btn {
            border-radius: 50px;
        }

        #sendButton {
            box-shadow: 0px 4px 10px rgb(0 0 0 / 30%);
        }

        .map-booking {
            background: url('https://images.unsplash.com/photo-1565429504749-436a49cd9f45?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80');
            width: 100%;
            height: 100%;
            background-position: center;
            background-size: cover;
            padding: 50px 20px;
            position: relative;
            display: flex;
            align-items: center;
            min-height: 100vh;
        }

        .map_section {
            height: 100%;
        }

        .booking_list_form label {
            font-family: 'Poppins', sans-serif;
        }

        /* label {
            font-size: 13px;
            font-style: italic !important;
            font-weight: 600;
        } */
        .input_field,
        .select_field {
            border-color: #ededed;
            box-shadow: none;
        }

        .input_field:focus,
        .select_field:focus {
            border-color: #000;
            box-shadow: none;
            outline: none;
        }

        .filter_booking_list {
            margin: 0px auto 0px;
            border-radius: 5px;
        }

        .custom_btn {
            width: 100%;
            background: #cc4452;
            height: 100%;
            padding: 13px !important;
            text-transform: capitalize;
            color: white;
            font-weight: 600;
            opacity: 1 !important;
            font-size: 16px !important;
        }

        .custom_btn:hover,
        .custom_btn:focus {
            background: #000;
            color: white;
            box-shadow: none;
        }

        .filter_result {
            margin: 20px auto;
            padding-bottom: 20px !important;
        }

        #captchaOperation {
            font-size: 30px;
            font-family: emoji;
            color: #cc4452;
        }

        .form-control {
            font-weight: 400;
            color: #000;
            font-size: 15px;
        }

        .value {
            /* color: black;
            font-size: 13px;
            font-weight: 600;
            padding: 15px 0px;
            border-radius: 5px; */
            white-space: nowrap;
        }

        .row.w-100.m-0.filter_booking_section_row .col-7 {
            padding: 0px;
        }

        .value_point {
            margin: 0 0 20px;
            background: white;
            text-align: center;
            padding: 9px;
            border-radius: 5px;
        }

        .iti.iti--allow-dropdown {
            width: 100%;
        }

        .title_form {
            padding: 15px;
            text-align: center;
            color: white;
            margin-bottom: 30px;
            font-size: 20px;
            border-radius: 5px;
            background-color: #9d9d9d;
        }

        .map-booking:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
        }

        .filter_booking_list,
        .filter_result {
            background: #f2f2f2ad;
            padding: 20px 20px 10px;
        }

        .form_container {
            position: relative;
            z-index: 1;
        }

        .modal-backdrop.fade.show {
            display: none;
        }

        #cancelBookingModal:before {
            content: '';
            background: #160607ab;
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
        }

        .back_btn.custom_btn {
            background: transparent;
            border: 1px solid #cc4452;
            color: #cc4452;
        }

        form .field_icons {
            display: flex;
            flex-flow: initial;
            align-items: self-end;
        }

        .modal_title_cs {
            font-weight: 700;
            font-size: 25px;
            line-height: 29px;
            color: #000;
            font-family: 'Heebo', sans-serif;
        }

        /* form .form-group label {
            font-size: 13px;
            font-style: italic !important;
            font-weight: 600;
            margin-right: 10px;
            min-width: 10px;
            white-space: nowrap;
        } */
        img.icon_img.car_walk.img-repsonsive {
            max-width: 31px;
            position: relative;
            right: 7px;
        }

        form .col-xs-12 {
            align-self: center;
        }

        .form-check-label a {
            white-space: break-spaces;
        }

        .icon_img.img-repsonsive {
            max-width: 13px;
        }

        #timeRide {
            overflow: hidden;
        }

        .icon_label.car_label {
            margin-bottom: 0px;
        }

        #googleMap {
            background: #dfdfdf;
            max-height: 100%;
            border-radius: 10px;
            height: 100%;
            min-height: 700px;
        }

        .row.w-100.m-0.filter_booking_section_row .col-5:first-child {
            padding-left: 0px;
        }

        .show_value {
            position: relative;
        }

        img.img-clock.w-100.img-responsive {
            position: absolute;
            left: 3px;
            top: 50%;
            max-width: 25px;
            transform: translateY(-50%);
        }

        #timerValue {
            padding-left: 30px;
            width: 100%;
        }

        .show_case .lst_col {
            padding: 0px;
        }

        .logo_img_top_1 {
            background: rgba(236, 236, 241, 0.75);
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
        }

        .logo_img_top_1 .img-responsive.imagelogo_brand {
            max-width: 120px;
        }

        .SelectedDateList {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            min-height: 230px;
            overflow: auto;
            max-height: 230px;
        }

        .SelectedDateList li {
            border-radius: 0px !important;
            border-top: none;
            border-left: none;
            border-right: none;
            position: relative;
        }

        .SelectedDateList li:hover {
            background-color: #dfdfdf;
        }

        .SelectedDateList .listDate {
            margin-left: 20px;
            font-weight: 500;
        }

        .listDate.font_bold{
            font-size: 17px;
            font-weight: 700;
        }

        .item_text {
            font-size: 18px;
            margin-bottom: 15px;
            color: #253239;
            font-weight: 400;
        }
        .runing_item {
            position: relative;
            list-style: none;
        }
        .runing_item:after {
            content: '';
            position: absolute;
            left: -28px;
            top: 7px;
            width: 12px;
            height: 12px;
            border-radius: 300px;
            background: #FC4C02;
            
            z-index: 1;
        }
        .runing_item.final:after {
            content: '';
            position: absolute;
            left: -28px;
            top: 7px;
            width: 12px;
            height: 12px;
            border-radius: 1px;
            background: #356681;
            z-index: 1;
        }
        ul.timeline_action:after {
            content: '';
            background: #071E2B;
            width: 1px;
            height: 34%;
            position: absolute;
            top: 22px;
            left: 17px;
            z-index: 0;
        }
        ul.timeline_action {
            position: relative;
        }
        .price_type span {
            font-weight: 700;
            margin-left: 10px;
            font-family: inherit;
        }
        .timming_print.message_box {
            background: rgba(249, 178, 51, 0.61);
            padding: 5px;
            border-radius: 5px;
            font-size: 14px;
        }
        .info-area {
            background: white !important;
        }

        .img-fluid.driver_avatar_img {
            max-width: 69px;
            max-height: 68px;
            width: 69px;
            height: 68px;
            border-radius: 300px;
            object-fit: cover;
        }
        .SelectedListBooking.form-radio {
            position: absolute;
            left: 0;
            width: 100%;
            height: 100%;
            top: 0;
            cursor: pointer;
            opacity: 0;
        }

        .SelectedListBooking.form-radio:checked~.listDate {
            color: #cc4452;
        }
        .map_area{
            background: rgba(242, 242, 242, 0.68);
            padding: 20px 20px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            height: 100%;
        }
        .map_area.half_area{
            height: 56%;
            min-height: 56%;
        }
        .map_area_price{
            background: rgba(242, 242, 242, 0.68);
            padding: 20px 20px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        .timming_print {
            font-size: 20px;
            color: #000;
        }
        .title_main {
            font-size: 20px;
            margin-bottom: 3px;
            font-weight: 700;
            color: #000;
        }
        .price {
            font-size: 25px;
            margin: 2px;
            color: #FC4C02;
        }
        .contact_name.ml-3 p {
            font-size: 17px;
        }
        .user_img {
            position: relative;
        }
        .img-fluid.driver_car {
            width: 84px;
            height: 80px;
            border-radius: 5px;
            object-fit: cover;
            object-position: center;
        }
        .driver_info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .Status_live.online {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #66D10F;
            border-radius: 200px;
            bottom: 10px;
            right: 2px;
        }
        .id_price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        @media (max-width: 300px) {

            .col-4,
            .col-5,
            .col-3,
            .col-7,
            .col-6,
            .col-2 {
                min-width: 100% !important;
            }
        }

        @media (max-width: 400px) {
            .filter_booking_section_row .col-4 {
                padding: 0px;
                width: 100%;
                margin-bottom: 10px;
            }

            .value_point.chf {
                width: 100%;
                margin-bottom: 10px !important;
                text-align: right;
            }

            .value_point,
            .value_point.km_m {
                width: 100% !important;
            }
        }

        @media (max-width: 400px) {
            .filter_booking_section_row .col-3 {
                padding: 0;
            }
        }

        @media (max-width: 500px) {
            .filter_booking_section_row .col-12 {
                padding: 0;
                margin-bottom: 11px;
            }

            .filter_booking_section_row .col-4 {
                padding: 0px;
                width: 100%;
                margin-bottom: 10px;
            }

            .value_point {
                width: 100% !important;
                text-align: right;
            }

            .value_point.chf {
                width: 100%;
                margin-bottom: 10px !important;
            }

            .row.row_fileterBooking .col-4:nth-child(2) {
                padding: 0;
            }

            /* .value {
                color: black;
                font-size: 15px;
                font-weight: 600;
            } */

            form .form-group label {
                min-width: 8px;
            }

            .title_form {
                font-size: 18px;
            }

            .map-booking {
                padding-left: 0px;
                padding-right: 0px;
                height: 100%;
            }

            form .form-group label {
                white-space: unset;
                text-align: revert;
                font-size: 12px;
            }

            .filter_booking_list {
                padding: 20px 10px 10px !important;
                margin-bottom: 40px;
            }

            .car_walk.img-repsonsive {
                max-width: 34px !important;
                margin-right: 17px !important;
                position: relative;
                left: 0px;
            }

            .icon_img.img-repsonsive {
                max-width: 14px;
            }
            
            .filter_booking_section_row .form-group label {
                min-width: 8px;
            }

            .filter_booking_section_row .col-5 {
                padding-right: 0px;
            }

            /* .value {
                color: black;
                font-size: 15px;
                font-weight: 600;
                white-space: nowrap;
                width: 100%;
                padding: 0px;
            } */
        }

        @media (min-width: 550px) and (max-width:992px) {
            .map-booking {
                height: 100%;
            }

            /* .value {
                color: black;
                font-size: 15px;
                font-weight: 600;
                white-space: nowrap;
                width: 100%;
                padding: 0px;
            } */
            .value_point {
                margin-bottom: 15px;
            }

            #googleMap {
                max-height: 100% !important;
            }

            .filter_booking_list {
                margin-bottom: 40px;
            }
        }

        @media (max-width: 767px) {
            #googleMap {
                height: 630px !important;
            }
            .small_height{
                height: 100%;
            }
        }

        @media (min-width:768px) {
            .frt_col {
                padding-left: 0px;
            }

            .mdl_col {
                padding: 0px;
            }
        }

        @media (min-width: 1200px) {
            .container-fluid.form_container {
                max-width: 1840px;
            }
        }
        .active-background
        {
            background: #e6e1e1 !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
            <div class="booking_personal_information">
                <div class="logo_img_top_1">
                    <img src="{{ asset('images/vel_logo.png') }}"
                        class="img-responsive imagelogo_brand" alt="img Logo">
                </div>
                <h2 class="title_form">{{ __('My Bookings') }}</h2>
                <div class="filter_booking_list otp_verification_div {{ $user?'d-none':'' }}">
                    <form id="verify_phone_form" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input class="form-control" name="country_code" type="hidden"
                                        id="country_code" value="41">
                                    <input type="tel" id="txtPhone"
                                        class="txtbox form-control input_field" name="phone"
                                        placeholder="{{ __('Enter Phone Number') }}" minlength="8" required />
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="submt" class="btn submit_btn custom_btn">{{ __('Confirm') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="filter_booking_list ride_list_div {{ !$user?'d-none':'' }}">
                    <div class="booking_list">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group" style="display: block;">
                                    <div class="timer_box">
                                        <div class="show_value">
                                            <ul class="list-group SelectedDateList">
                                                @if ($user)
                                                    @forelse ($rides as $key=>$ride)
                                                        <li class="list-group-item bookingList" style="cursor:pointer" data-id="{{ $ride->id }}">
                                                            <div class="row">
                                                                <div class="col-2 mr-0 pr-0" style="max-width: 35px;">
                                                                    <img src="https://cdn-icons-png.flaticon.com/512/4120/4120023.png" class="img-clock w-100 img-responsive" alt="img clock">
                                                                </div>
                                                                <div class="col-10 pl-0 ml-0">
                                                                    <span class="listDate" style="padding: 0px;margin:0px">{{ $ride->ride_time }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-2 mr-0 pr-0" style="max-width: 35px;position: absolute;margin-top: 15px;">
                                                                    <img src="{{ asset('images/icons8-vanpool-30.png')}}" class="img-clock w-100 img-responsive" alt="img clock">
                                                                </div>
                                                                <div class="col-10 pl-0" style="margin-left: 37px;line-height: 1;">
                                                                    <span class="" style="font-size:12px">{{ $ride->pickup_address }}</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <li class="list-group-item text-center">
                                                            No rides available
                                                        </li>
                                                    @endforelse
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 px-lg-5">
                                <div class="form-check">
                                    <div class="input_check_box">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                        <div class="check_status"></div>
                                    </div>
                                    <label class="form-check-label listDate font_bold ml-0 pb-3" for="flexCheckChecked">
                                        I have read and accepted the general terms and conditions
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="button" id="submit_request_cancel"
                                        class="btn submit_btn custom_btn">{{ __('CANCEL BOOKING') }}</button>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <button type="button"
                                        class="btn back_btn custom_btn edit_booking">{{ __('EDIT BOOKING') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <p class="msg_display"></p>
                        </div>
                    </div>

                    <!-- ============================================================== -->
                    <!-- Personal Information Form Content End -->
                    <!-- ============================================================== -->
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-xs-12 small_height">
            <div class="map_area half_area">
                <div class="map_section card">
                    <div class="p-3">
                        <div class="row">
                            <div class="col-6">
                                <h5 class="booking_user_name"></h5>
                            </div>
                            <div class="col-6 text-right">
                                <div class="bagde-red">
                                    <span class="badge badge-primary booking_created_at" style="background-color: #ef4f23"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive mt-4">
                                    <table class="table table-bordered">
                                    <tbody id="bookingDetailsTable">
                                        
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="map_area_price">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <p class="timming_print"><b>Date & Time:</b> Mo  26.12.22  12:00</p>
                        <ul class="timeline_action">
                            <li class="runing_item">
                                <p class="item_text"> Strickstrasse 55, Zürich 8008 : <b>10 min</b></p>
                            </li>
                            <li class="runing_item final">
                                <p class="item_text"> The Matterhorn</p>
                            </li>
                        </ul>
                        <p class="title_main">Payment Details </p>
                        <div class="id_price">
                            <p class="price"><b>CHF 60.00</b></p>
                            <div class="price_type">
                                <img src="{{ asset('images/cash.png') }}" class="img-responsive price_type_img">
                                <span>Cash</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <p class="timming_print d-none"><b>Ride Assigned To</b></p>
                        <p class="timming_print message_box"><b>Driver has arrived</b></p>
                        <div class="driver_info">
                            <div class="driver_personal d-flex align-items-center">
                                <div class="user_img">
                                    <img src="{{ asset('images/avatar.png') }}" class="img-fluid driver_avatar_img">
                                    <spna class="Status_live online"></span>
                                </div>
                                <div class="contact_name ml-3">
                                    <p class="timming_print text-uppercase mb-1"><b>paedro</b></p>
                                    <p class="timming_print text-uppercase mb-0"><b>9876554321</b></p>
                                </div>
                            </div>
                            <div class="car_infomation">
                                <img src="{{ asset('images/cars.png') }}" class="img-fluid driver_car">
                                <p class="timming_print text-uppercase mb-1"><b>SH50288</b></p>
                            </div>
                        </div>
                        <textarea class="form-control info-area" rows="2" cols="10" placeholder="Additional note" readonly>Lorem Ipsum is simply dummy text of the printing and typesetting industry. </textarea>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput-jquery.min.js"></script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn7nxEJGDtQo1wl8Mzg9178JAU2x6-Y0E&libraries=geometry,places&language={{ app()->getLocale() }}">
    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" integrity="sha512-Fq/wHuMI7AraoOK+juE5oYILKvSPe6GC5ZWZnvpOO/ZPdtyA29n+a5kVLP4XaLyDy9D1IBPYzdFycO33Ijd0Pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $(function() {
            var code = "+41";
            $('#txtPhone').intlTelInput({
                initialCountry: "ch",
            });
            $("#txtPhone").on("countrychange", function() {
                var countryCode = $('.iti__selected-flag').attr('title');
                var countryCode = countryCode.replace(/[^0-9]/g, '')
                $('#country_code').val(countryCode);
            });
        });

        $("#verify_phone_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('send_otp_for_my_bookings') }}",
                type: 'post',
                dataType: 'json',
                data: $('form#verify_phone_form').serialize(),
                success: function(response) {
                    if (response.status) {
                        $("#confirmOTPModal").modal('show');
                        timer(30,"confirmOTPModalTimer","confirmOTPModalResendOtp");
                    } else if (response.status == 0) {
                        swal("{{ __('Error') }}", response.message, "error");
                    }
                },
                error(response) {
                   swal("{{ __('Error') }}", response.message, "error");
                }
            });
        })

        $(document).on("click", ".verify_otp", function(e) {
            e.preventDefault();
            var otp_entered = $(document).find("#otp_entered").val();
            var post_data = $('form#verify_phone_form').serialize();
            post_data += '&otp='+otp_entered;
            $(document).find(".verify_otp").attr('disabled',true);
            $.ajax({
                url: "{{ route('verify_otp_and_ride_list')}}",
                type: 'post',
                dataType: 'json',
                data: post_data,
                success: function(response) {
                    if(response.status){
                        bookingsArray = response.data;
                        $(document).find('.otp_verification_div').addClass('d-none');
                        $(".SelectedDateList").html("");
                        if(response.data != ""){
                            $( response.data ).each(function( index, element ) {
                                div = `<li class="list-group-item bookingList" style="cursor:pointer" data-id="`+element.id+`">
                                            <div class="row">
                                                <div class="col-2 mr-0 pr-0" style="max-width: 35px;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/4120/4120023.png" class="img-clock w-100 img-responsive" alt="img clock">
                                                </div>
                                                <div class="col-10 pl-0 ml-0">
                                                    <span class="listDate" style="padding: 0px;margin:0px">`+element.ride_time+`</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-2 mr-0 pr-0" style="max-width: 35px;position: absolute;margin-top: 15px;">
                                                    <img src="{{ asset('images/icons8-vanpool-30.png')}}" class="img-clock w-100 img-responsive" alt="img clock">
                                                </div>
                                                <div class="col-10 pl-0" style="margin-left: 37px;line-height: 1;">
                                                    <span class="" style="font-size:12px">`+element.pickup_address+`</span>
                                                </div>
                                            </div>
                                        </li>`;
                                // $(".SelectedDateList").append(`<li class="list-group-item list-group-flush"><div><input type="radio" name="selectListed" class="SelectedListBooking form-radio" data-id="`+element.id+`" value="`+element.id+`"><img src="https://cdn-icons-png.flaticon.com/512/4120/4120023.png" style="top:33%" class="img-clock w-100 img-responsive" alt="img clock"><span class="listDate">`+element.ride_time+`</span></div><span class="listDate" style=" ">`+element.pickup_address+`</span><img src="{{ asset('images/icons8-vanpool-30.png') }}" class="img-clock w-100 img-responsive" alt="img clock" style=" top: 50px; left: 4px; "><div></div></li>`);
                                $(".SelectedDateList").append(div);
                            });
                        }
                        $(document).find('.ride_list_div').removeClass('d-none');
                        $("#confirmOTPModal").modal('hide');
                    } else if(response.status == 0){
                       swal("{{ __('Error') }}",response.message,"error");
                    }
                    $(document).find(".verify_otp").removeAttr('disabled');
                },
                error(response) {
                   swal("{{ __('Error') }}",response.message,"error");
                    $(document).find(".verify_otp").removeAttr('disabled');
                }
            });
        });

        $(document).on('click','.confirmOTPModalResendOtp',function(){
            $.ajax({
                url: "{{ route('send_otp_for_my_bookings')}}",
                type: 'post',
                dataType: 'json',
                data: $('form#verify_phone_form').serialize(),
                success: function(response) {
                    if(response.status){
                        $("#confirmOTPModal").modal('show');
                        timer(30,"confirmOTPModalTimer","confirmOTPModalResendOtp");
                    } else if(response.status == 0){
                        swal("{{ __('Error') }}",response.message,"error");
                        $(document).find(".verify_otp").removeAttr('disabled');
                    }
                },
                error(response) {
                    swal("{{ __('Error') }}",response.message,"error");
                    $(document).find(".verify_otp").removeAttr('disabled');
                }
            });
        });

        function timer(remaining,timerClass,confirmOTPModalResendOtpClass) {
            $('.'+confirmOTPModalResendOtpClass).hide();
            $('.'+timerClass).show();
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;
            
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            // console.log(timerClass);
            // console.log(s);
            $('.'+timerClass).html('{{ __("Resend OTP in") }} ' + s);
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
            $('.'+timerClass).hide();
        }

        @if ($user)
            bookingsArray = JSON.parse('<?php echo ($rides) ?>');
        @else
            bookingsArray = [];
        @endif

        function checkText(text) {
            return (text=="" || text==null? 'Not Available' : text);
        }
        var selectedBooking = "";
        $(document).on('click','.bookingList',function(){
            selectedBooking = $(this).data('id');
            $('.bookingList').removeClass('active-background');
            $(this).addClass('active-background');
            bookingsArray.forEach(element => {
                if (selectedBooking==element.id) 
                {
                    div = `<tr>
                            <td>
                                <strong>Driver Name</strong>
                            </td>
                            <td> `+checkText(element.driver_name)+` </td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Pickup Location</strong>
                            </td>
                            <td>`+checkText(element.pickup_address)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Dropoff Location</strong>
                            </td>
                            <td>`+checkText(element.dest_address)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Price</strong>
                            </td>
                            <td>`+checkText(element.ride_cost)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Distance</strong>
                            </td>
                            <td>`+checkText(element.distance)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Payment Type</strong>
                            </td>
                            <td> `+checkText(element.payment_type)+` </td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Ride Type</strong>
                            </td>
                            <td> `+checkText(element.ride_type)+` </td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Additional Note</strong>
                            </td>
                            <td>`+checkText(element.additional_notes)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Number of Passanger</strong>
                            </td>
                            <td>`+checkText(element.passanger)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Car Type</strong>
                            </td>
                            <td>`+checkText(element.car_type)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Ride Time</strong>
                            </td>
                            <td>`+checkText(element.ride_type)+`</td>
                            </tr>
                            <tr>
                            <td>
                                <strong>Status</strong>
                            </td>
                            <td> `+checkText(element.ride_status)+` </td>
                            </tr>
                            <tr>`;
                    $('.booking_user_name').html(element.user_name);
                    $('.booking_created_at').html(element.create_date);
                    $('#bookingDetailsTable').html(div);
                }
            });
        });
        $(document).on('click','#submit_request_cancel',function(){
            if(selectedBooking!=""){
                $("#cancelBookingModal").modal('show');
            } else {
               swal("{{ __('Error') }}","{{ __('Please select booking') }}","error");
            }
        });

        $(document).on('click','.cancel_booking_confirmed',function(e){
            e.preventDefault();
            if(selectedBooking!=""){
                $(document).find(".cancel_booking_confirmed").attr('disabled');
                $.ajax({
                    url: "{{ route('web.cancel_booking')}}",
                    type: 'post',
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'ride_id' : selectedBooking
                    },
                    success: function(response) {
                        if(response.status){
                            // $(".SelectedDateList").html("");
                            $(document).find(".bookingList[data-id='"+selectedBooking+"']").remove();
                            $("#cancelBookingModal").modal('hide');
                            swal("Success",response.message,"success");
                            $('#bookingDetailsTable').html('');
                            $('.booking_user_name').html('');
                            $('.booking_created_at').html('');
                        } else if(response.status == 0){
                           swal("{{ __('Error') }}",response.message,"error");
                        }
                        $(document).find(".cancelBookingModal").removeAttr('disabled');
                    },
                    error(response) {
                       swal("{{ __('Error') }}",response.message,"error");
                        $(document).find(".cancelBookingModal").removeAttr('disabled');
                    }
                });
            } else {
               swal("{{ __('Error') }}","{{ __('Please select booking') }}","error");
            }
        });

        $(document).on('click','.edit_booking',function(e){
            e.preventDefault();
            if(selectedBooking!=""){
                route = "{{ route('booking_edit_taxisteinemann','~') }}{{ isset($token)?'?token='.$token:'' }}";
                route = route.replace('~',selectedBooking);
                window.location.href= route;
            } else {
               swal("{{ __('Error') }}","{{ __('Please select booking') }}","error");
            }
        })
    </script>
@endsection