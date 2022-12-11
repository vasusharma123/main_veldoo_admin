@extends('layouts.web_booking_taxi_2000')
@section('css')
    <style>
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
                <div class="filter_booking_list otp_verification_div">
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

                <div class="filter_booking_list ride_list_div d-none">
                    <div class="booking_list">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group" style="display: block;">
                                    <div class="timer_box">
                                        <div class="show_value">
                                            <ul class="list-group SelectedDateList">
                                                
                                            </ul>
                                        </div>
                                    </div>
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

        <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-xs-12">
            <div class="map_section">
                <div id="googleMap" style="width:100%;"></div>
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
                                                <div class="col-2 mr-0 pr-0" style="max-width: 35px;">
                                                    <img src="{{ asset('images/icons8-vanpool-30.png')}}" class="img-clock w-100 img-responsive" alt="img clock">
                                                </div>
                                                <div class="col-10 pl-0 ml-0" style="line-height:1;">
                                                    <span class="" style="font-size:12px">`+element.pickup_address+`</span>
                                                </div>
                                            </div>
                                        </li>`;
                                // $(".SelectedDateList").append(`<li class="list-group-item list-group-flush"><div><input type="radio" name="selectListed" class="SelectedListBooking form-radio" data-id="`+element.id+`" value="`+element.id+`"><img src="https://cdn-icons-png.flaticon.com/512/4120/4120023.png" style="top:33%" class="img-clock w-100 img-responsive" alt="img clock"><span class="listDate">`+element.ride_time+`</span></div><span class="listDate" style=" ">`+element.pickup_address+`</span><img src="{{ asset('images/icons8-vanpool-30.png') }}" class="img-clock w-100 img-responsive" alt="img clock" style=" top: 50px; left: 4px; "><div></div></li>`);
                                $(".SelectedDateList").append(div);
                            });
                        }
                        $(document).find('.ride_list_div').removeClass('d-none');
                    } else if(response.status == 0){
                       swal("{{ __('Error') }}",response.message,"error");
                    }
                    $("#confirmOTPModal").modal('hide');
                    $(document).find(".verify_otp").removeAttr('disabled');
                },
                error(response) {
                   swal("{{ __('Error') }}",response.message,"error");
                    $(document).find(".verify_otp").removeAttr('disabled');
                }
            });
        })

        var selectedBooking = "";
        $(document).on('click','.bookingList',function(){
            selectedBooking = $(this).data('id');
            $('.bookingList').removeClass('active-background');
            $(this).addClass('active-background');
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
                            $(".SelectedDateList").html("");
                            $(document).find(".bookingList[data-id='"+selectedBooking+"']").remove();
                            $("#cancelBookingModal").modal('hide');
                            swal("Success",response.message,"success");
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
                route = "{{ route('booking_edit_taxi2000','~') }}";
                route = route.replace('~',selectedBooking);
                window.location.href= route;
            } else {
               swal("{{ __('Error') }}","{{ __('Please select booking') }}","error");
            }
        })
    </script>
@endsection