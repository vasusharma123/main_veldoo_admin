@extends('layouts.web_booking_taxi_2000')
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
            background: url("{{asset('images/taxi2000_bg.png')}}");
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
            background: #78D648;
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
            color: #ffffff;
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
            color: white;
            margin-bottom: 30px;
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
            border: 1px solid #78D648;
            color: #ffffff;
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
            font-size: 14px;
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
            color: #78D648;
        }

        .map_area{
            background: rgba(242, 242, 242, 0.68);
            padding: 20px 20px 20px;
            border-radius: 5px;
            margin-bottom: 30px;
            /* height: 100%; */
        }
        /* .map_area.half_area{
            height: 56%;
            min-height: 56%;
        } */
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
            object-fit: contain;
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

        .home_icon {
            color: #78D648;
        }

        .home_icon:hover {
            color: #78D648;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
            <div class="booking_personal_information">
                <div class="logo_img_top_1">
                    <a href="https://www.taxischaffhausen.ch">
                        <img src="{{ asset('images/taxi2000_logo.png') }}"
                        class="img-responsive imagelogo_brand" alt="img Logo">
                        <span class="float-right pt-1 home_icon"><i class="fa-2x fas fa-home "></i></button></span>
                    </a>
                </div>
                <div class="title_form">
                    <div class="text-center">
                      <h4 class="d-inline">{{ __('My Bookings') }}</h4>
                      <a href="javascript::void(0);" onClick="window.location.reload()" class="float-right text-white pt-1"><i class="fas fa-redo-alt"></i></button></a>
                    </div>
                </div>
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
                                                            {{ __('No rides available')}}
                                                        </li>
                                                    @endforelse
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="button" id="submit_request_cancel"
                                        class="btn submit_btn custom_btn">{{ __('CANCEL') }}</button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <button type="button"
                                        class="btn back_btn custom_btn edit_booking">{{ __('EDIT') }}</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <a href="{{ route('booking_taxi2000') }}"
                                        class="btn back_btn custom_btn">{{ __('NEW BOOKING') }}</a>
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

                <div class="p-4">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-6">
                                <a href="https://play.google.com/store/apps/details?id=com.dev.veldoouser" ><img src="{{ asset('images/glp-button.png')}}" class="w-100"></a>
                            </div>
                            <div class="col-6">
                                <a href="https://apps.apple.com/in/app/id1597936025" ><img src="{{ asset('images/aps-button.png')}}" class="w-100"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-xs-12 small_height">
            <div class="map_area half_area">
                <div class="map_section">
                    <div class="">
                        <div class="row">
                            <div class="col-12">
                                <div class="">
                                    <div id="googleMap" style="width:100%;min-height:290px;height:290px;max-height:290px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="map_area_price" style="display: none">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <p class="timming_print"><b>Date & Time:</b><span class="booking_created_at"></span></p>
                        <ul class="timeline_action">
                            <li class="runing_item">
                                <p class="item_text pick_loc"></p>
                            </li>
                            <li class="runing_item final dest_loc_par">
                                <p class="item_text dest_loc"></p>
                            </li>
                        </ul>
                        <p class="title_main">Payment Details </p>
                        <div class="id_price">
                            <p class="price ride_price"><b>CHF 60.00</b></p>
                            <div class="price_type">
                                <img src="{{ asset('images/cash.png') }}" class="img-responsive price_type_img">
                                <span class="ride_payment_type">Cash</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <p class="timming_print d-none"><b>Ride Assigned To</b></p>
                        <p class="timming_print message_box"><b class="latest_status">Pending</b></p>
                        <div class="driver_info">
                            <div class="driver_personal d-flex align-items-center">
                                <div class="user_img">
                                    <img src="{{ asset('images/avatar.png') }}" class="img-fluid driver_avatar_img driver_image">
                                    <span class="Status_live online"></span>
                                </div>
                                <div class="contact_name ml-3">
                                    <p class="timming_print text-uppercase mb-1"><b class="driver_name">paedro</b></p>
                                    <p class="timming_print text-uppercase mb-0"><a href="tel:" style="color: black" class="driver_phone">9876554321</a></p>
                                </div>
                            </div>
                            <div class="car_infomation">
                                <img src="{{ asset('images/cars.png') }}" class="img-fluid driver_car car_image">
                                <p class="timming_print text-uppercase mb-1"><b class="car_number">SH50288</b></p>
                            </div>
                        </div>
                        <textarea class="form-control info-area ride_notes" rows="2" cols="10" placeholder="Additional note" readonly></textarea>
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
        var map;
        var MapPoints = [];
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var markers = [];
        $(function() {
            map = new google.maps.Map(document.getElementById('googleMap'), {
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false,
                center: { lat: 46.8182, lng: 8.2275 },//Setting Initial Position
                zoom: 8
            });

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
                        timer(30,"confirmOTPModalTimer","otp_not_rec");
                    } else if (response.status == 0) {
                        swal("{{ __('Error') }}", response.message, "error");
                    }
                },
                error(response) {
                   swal("{{ __('Error') }}", response.message, "error");
                }
            });
        })

        $(document).on("submit", "#otp_form", function(e) {
            e.preventDefault();
            var otp_entered = $("#digit-1").val()+$("#digit-2").val()+$("#digit-3").val()+$("#digit-4").val();
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
                        timer(30,"confirmOTPModalTimer","otp_not_rec");
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
                    if (element.dest_lat=="") 
                    {
                        for (let i = 0; i < markers.length; i++) {
                            markers[i].setMap(null);
                        }
                        if (directionsDisplay != null) {
                            directionsDisplay.setMap(null);
                            directionsDisplay = null;
                        }
                        pt = new google.maps.LatLng(element.pick_lat, element.pick_lng);
                        map.setCenter(pt);
                        map.setZoom(13);
                        marker = new google.maps.Marker({
                            position: pt,
                            map: map
                        });   
                    }
                    else
                    {
                        if (directionsDisplay != null) {
                            directionsDisplay.setMap(null);
                            directionsDisplay = null;
                        }
                        for (let i = 0; i < markers.length; i++) {
                            markers[i].setMap(null);
                        }
                        MapPoints = [{
                            Latitude: element.pick_lat,
                            Longitude: element.pick_lng,
                            AddressLocation: element.pickup_address
                        }, {
                            Latitude: element.dest_lat,
                            Longitude: element.dest_lng,
                            AddressLocation: element.dest_address
                        }];
                        directionsService = new google.maps.DirectionsService;
                        directionsDisplay = new google.maps.DirectionsRenderer({
                            map: map,
                            suppressMarkers: true
                        });
                        var locations = MapPoints;
                        var bounds = new google.maps.LatLngBounds();
                        var infowindow = new google.maps.InfoWindow();
                        var request = {
                            travelMode: google.maps.TravelMode.DRIVING
                        };
                        for (i = 0; i < locations.length; i++) 
                        {
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i].Latitude.toString(), locations[i].Longitude
                                    .toString()),
                                //position: new google.maps.LatLng(locations[i].address.lat, locations[i].address.lng),
                                map: map
                            });
                            bounds.extend(marker.position);

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    infowindow.setContent(locations[i]['AddressLocation']);
                                    infowindow.open(map, marker);
                                }
                            })(marker, i));
                            // create request from locations array, 1st marker is origin
                            if (i == 0) request.origin = marker.getPosition();
                            // last marker is destination
                            else if (i == locations.length - 1) request.destination = marker.getPosition();
                            else {
                                // any other markers are waypoints
                                if (!request.waypoints) request.waypoints = [];
                                request.waypoints.push({
                                    location: marker.getPosition(),
                                    stopover: true
                                });
                            }
                            markers.push(marker);
                        }
                        directionsService.route(request, function(result, status) {
                            if (status == google.maps.DirectionsStatus.OK) {
                                directionsDisplay.setDirections(result);
                            }
                        });
                        map.fitBounds(bounds);
                        setInterval(() => {
                            if ((map.getZoom() != 17) && (MapPoints[0].Latitude==MapPoints[1].Latitude))
                            {
                                // alert('shlo');
                                // console.log(MapPoints);
                                map.setZoom(17);
                            }
                        }, 1000);
                    }
																	
                    $('.booking_created_at').html(element.create_date);
                    $('.pick_loc').html(element.pickup_address);
                    $('.dest_loc_par').hide();
                    if(element.dest_address && element.dest_address!=null)
                    {
                        $('.dest_loc_par').show();
                        $('.dest_loc').html(element.dest_address);
                    }
                    $('.ride_notes').hide();
                    if(element.note!=null)
                    {
                        $('.ride_notes').show();
                        $('.ride_notes').html(element.note);
                    }
                    ride_cost = element.ride_cost;
                    if(element.ride_cost==null)
                    {
                        ride_cost = "N/A";
                    }
                    if(element.ride_cost=="")
                    {
                        ride_cost = "N/A";
                    }
                    $('.ride_price').html("CHF "+ride_cost);
                    $('.ride_payment_type').html(element.payment_type);
                    ride_status_latest = element.ride_status_latest;
                    $('.driver_info').hide();
                    if (element.driver!=null) 
                    {
                        $('.driver_image').attr('src',element.driver.image_with_url);
                        $('.driver_name').html(element.driver.first_name+' '+element.driver.last_name);
                        $('.driver_phone').html(`+${element.driver.country_code} ${element.driver.phone}`);
                        $('.driver_phone').attr('href',"tel:"+element.driver.country_code+element.driver.phone);
                        $('.driver_info').show();

                        if (element.status=="1") 
                        {
                            var distanceService = new google.maps.DistanceMatrixService();
                            var origin = new google.maps.LatLng(element.driver.current_lat,element.driver.current_lng);
                            var destination = new google.maps.LatLng(element.pick_lat,element.pick_lng);
                            distanceService.getDistanceMatrix({
                                    origins: [origin],
                                    destinations: [destination],
                                    travelMode: google.maps.TravelMode.DRIVING,
                                    unitSystem: google.maps.UnitSystem.METRIC,
                                    durationInTraffic: true,
                                    avoidHighways: false,
                                    avoidTolls: false
                                },
                                function(response, status) {
                                    if (status !== google.maps.DistanceMatrixStatus.OK) {
                                        console.log('Error:', status);
                                    } else {
                                        ride_status_latest = ride_status_latest.replace('#time#',response.rows[0].elements[0].duration.text);
                                        $('.latest_status').html(ride_status_latest);
                                    }
                                });    
                        } else if (element.status=="2") 
                        {
                            var distanceService = new google.maps.DistanceMatrixService();
                            var origin = new google.maps.LatLng(element.pick_lat,element.pick_lng);
                            var destination = new google.maps.LatLng(element.dest_lat,element.dest_lng);
                            distanceService.getDistanceMatrix({
                                    origins: [origin],
                                    destinations: [destination],
                                    travelMode: google.maps.TravelMode.DRIVING,
                                    unitSystem: google.maps.UnitSystem.METRIC,
                                    durationInTraffic: true,
                                    avoidHighways: false,
                                    avoidTolls: false
                                },
                                function(response, status) {
                                    if (status !== google.maps.DistanceMatrixStatus.OK) {
                                        console.log('Error:', status);
                                    } else {
                                        ride_status_latest = ride_status_latest.replace('#time#',response.rows[0].elements[0].duration.text);
                                        $('.latest_status').html(ride_status_latest);
                                    }
                                });    
                        } else {
                            $('.latest_status').html(ride_status_latest);
                        }
                    } else {
                        $('.latest_status').html(ride_status_latest);
                    }

                    $('.car_image').hide();
                    $('.car_number').hide();
                    if (element.vehicle!=null) 
                    {
                        $('.car_image').attr('src',element.vehicle.image_with_url);
                        $('.car_image').show();
                        $('.car_number').html(element.vehicle.vehicle_number_plate);
                        $('.car_number').show();
                    }
                    $('.map_area_price').show();
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
                            // $('#bookingDetailsTable').html('');
                            $('.map_area_price').hide();
                            if (directionsDisplay != null) {
                                directionsDisplay.setMap(null);
                                directionsDisplay = null;
                            }
                            for (let i = 0; i < markers.length; i++) {
                                markers[i].setMap(null);
                            }
                            pt = new google.maps.LatLng(46.8182, 8.2275);
                            map.setCenter(pt);
                            map.setZoom(8);
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
                redirect = true;
                bookingsArray.forEach(element => {
                    if (selectedBooking==element.id) 
                    { 
                        if (element.status!=-4 && element.status!=0) 
                        {
                            swal("{{ __('Error') }}","{{ __('You cannot edit this booking') }}","error");
                            redirect = false;
                        }
                    }
                });
                route = "{{ route('booking_edit_taxi2000','~') }}{{ isset($token)?'?token='.$token:'' }}";
                route = route.replace('~',selectedBooking);
                if (redirect) {
                    window.location.href= route;
                }
            } else {
               swal("{{ __('Error') }}","{{ __('Please select booking') }}","error");
            }
        })
    </script>
@endsection