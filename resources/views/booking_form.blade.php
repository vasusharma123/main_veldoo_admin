@extends('layouts.web_booking')
@section('css')
    <style>
        .btn {
            border-radius: 50px;
        }
        #sendButton {
            box-shadow: 0px 4px 10px rgb(0 0 0 / 30%);
        }
        .map-booking {
            background: url("{{asset('images/steinemann_bg.png')}}");
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
            padding: 13px;
            text-transform: capitalize;
            color: white;
            font-weight: 600;
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
        .filter_booking_list , .filter_result{
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
        #confirmOTPModal:before {
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
            left: 18px;
            top: 35%;
            max-width: 25px;
            transform: translateY(-50%);
        }
        #timerValue {
            width: 44px;
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
            border: 0px;
        }
        .show_case .lst_col{
            padding: 0px ;
        }

        .logo_img_top_1 {
            background: rgba(236, 236, 241, 0.75);
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
        }
        .logo_img_top_1 .img-responsive.imagelogo_brand {
            max-width: 240px;
        }

        @media (max-width: 300px){
            .col-4,.col-5,.col-3, .col-7, .col-6, .col-2{
                min-width: 100% !important;
            }
        }
        @media (max-width: 400px){
            .filter_booking_section_row .col-4{
                padding: 0px;
                width: 100%;
                margin-bottom: 10px;
            }
            .value_point.chf {
                width: 100%;
                margin-bottom: 10px !important;
                text-align: right;
            }
            .value_point, .value_point.km_m{
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
            .filter_booking_section_row .col-4{
                padding: 0px;
                width: 100%;
                margin-bottom: 10px;
            }
            .value_point{
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
            .filter_booking_list{
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
        @media (min-width: 550px) and (max-width:992px){
            .map-booking{
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
            .value_point{
                margin-bottom: 15px;
            }
            #googleMap{
                max-height: 100% !important;
            }
            .filter_booking_list{
                margin-bottom: 40px;
            }
        }
        @media (max-width: 767px){
            #googleMap {
                height: 630px !important;
            }
        }
        @media (min-width:768px){
            .frt_col{
                padding-left: 0px;
            }
            .mdl_col{
                padding: 0px;
            }
        }
        @media (min-width: 1200px){
            .container-fluid.form_container {
                max-width: 1840px;
            }
        }
        .sselect {
            -webkit-appearance: none;
            appearance: none;
            padding-left : 10px !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
            <div class="booking_personal_information">
                <div class="logo_img_top_1">
                    <a href="{{ route('booking_taxisteinemann') }}">
                        <img src="{{asset('images/steinemann_logo.png')}}" class="img-responsive imagelogo_brand" alt="img Logo">
                    </a>
                </div>
                <h2 class="title_form">{{ __('Booking Details') }}</h2>
                <div class="filter_booking_list">
                    <form class="personal_info_form" id="personal_info_form" method="post">
                        @csrf
                        <?php
                            $first_name_validation = __('First name is required.');
                            $last_name_validation = __('Last name is required.');
                            $phone_validation = __('Phone number is required.');
                        ?>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <input type="text" class="form-control input_field" data-parsley-required-message="{{ $first_name_validation }}" name="first_name" placeholder="{{ __('First Name') }}"  />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="form-group">
                                    <input type="text" class="form-control input_field" name="last_name"
                                        placeholder="{{ __('Last Name') }}" />
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group mb-0 pb-0">
                                    <input class="form-control" name="country_code" type="hidden"
                                        id="country_code" value="41">
                                    <input type="tel" id="txtPhone"
                                        class="txtbox form-control input_field" data-parsley-minlength-message="{{ __('This value is too short. It should have 8 characters or more.') }}" name="phone" data-parsley-errors-container=".phoneError" placeholder="{{ __('Enter Phone Number') }}" minlength="8" data-parsley-required-message="{{ $phone_validation }}" />
                                </div>
                                <div class="phoneError mb-3"></div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group" style="display: block;">
                                    <div class="timer_box">
                                        <div class="" style="width: 100%;display: flex;">
                                            <input type="text" value="{{date('D d-m-Y H:i')}}" name="ride_time" class="datetimepicker form-control" style="width: 70%;border-bottom-right-radius: 0px !important;border-top-right-radius: 0px !important;border: 0px;border-radius: 4px;padding-left:35px">
                                            {{-- <input type="datetime-local" id="timerValue" class="txtbox form-control input_field" name="ride_time" value="{{date('Y-m-d H:i')}}"> --}}
                                            <img src="https://cdn-icons-png.flaticon.com/512/4120/4120023.png" class="img-clock w-100 img-responsive" alt="img clock">
                                        </div>
                                        {{-- <div class="" style="width: 100%">
                                            <input type="text" name="" style="width: 70%">
                                            <input type="datetime-local" id="timerValue" class="txtbox form-control input_field" name="ride_time" value="{{date('Y-m-d H:i')}}" required />
                                            <img src="https://cdn-icons-png.flaticon.com/512/4120/4120023.png" class="img-clock w-100 img-responsive" alt="img clock">
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row w-100 m-0 filter_booking_section_row">
                            <div class="col-lg-5 col-md-5 col-sm-4 col-6 frt_col">
                                <div class="form-group field_icons">
                                    <i class="fas fa-taxi fa-2x mr-1"></i>
                                    <select class="form-control select_field sselect" id="carType" name="car_type">
                                        <option value="{{ $vehicle_type->car_type }}"
                                            data-basic_fee="{{ $vehicle_type->basic_fee }}"
                                            data-price_per_km="{{ $vehicle_type->price_per_km }}">
                                            {{ __($vehicle_type->car_type) }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-3 mdl_col">
                                <div class="form-group field_icons">
                                    <i class="fas fa-male fa-2x ml-2 mr-1"></i>
                                    <select class="form-control select_field sselect" id="numberOfPassenger" name="passanger">
                                        <option value="{{ $input['numberOfPassenger'] }}">{{ $input['numberOfPassenger'] }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-3 align-self-center lst_col">
                                
                            </div>
                        </div>
                        <div class="row show_case">
                            <div class="col text-center">
                                <div class="form-group">
                                    <p class="form-control chf" style="font-size: 12px"><span class="value">CHF {{ $input['price_calculated'] }}</span></p>
                                    <input type="hidden" name="ride_cost" class="price_calculated_input"
                                    value="{{ $input['price_calculated'] }}">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-3 text-center">
                                <div class="form-group">
                                    <p class="form-control km_m" style="font-size: 12px"><span class="value">KM {{ $input['distance_calculated'] }}</span></p>
                                    <input type="hidden" name="distance"
                                        class="distance_calculated_input"
                                        value="{{ $input['distance_calculated'] }}">
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                                <div class="form-group">
                                    <select class="form-control select_field " style="font-size: 12px" id="paymentMethod" name="payment_type" required>
                                        {{-- <option value="">{{ __('Payment Method') }}</option> --}}
                                        <option value="Cash" selected>{{ __('Cash') }}</option>
                                        <option value="Card">{{ __('Card') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <textarea rows="3" cols="5" class="form-control input_field" name="note" id="additionalNotes" placeholder="{{ __('Enter notes...') }}"></textarea>
                                </div>
                            </div>
                            <!-- 
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="captcha" id="captchaOperation"><?php //echo(rand(100,1000)); ?></label>
                                    <input type="text" class="form-control input_field" name="captcha" id="captcha" placeholder="Enter captcha code.." required/>
                                </div>
                            </div> -->

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" name="terms_conditions" type="checkbox"> <a href="#" class="text-secondary">{{ __('I have read and accepted the general terms and conditions') }}</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <input type="hidden" name="pickup_address" value="{{ $input['pickup_address'] }}">
                                    <input type="hidden" name="pick_lat" value="{{ $input['pickup_latitude'] }}">
                                    <input type="hidden" name="pick_lng" value="{{ $input['pickup_longitude'] }}">
                                    <input type="hidden" name="dest_address" value="{{ $input['dropoff_address'] }}">
                                    <input type="hidden" name="dest_lat" value="{{ $input['dropoff_latitude'] }}">
                                    <input type="hidden" name="dest_lng" value="{{ $input['dropoff_longitude'] }}">
                                    <button type="submit" id="submit_request" class="btn submit_btn custom_btn">{{ __('BOOK') }}</button>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <a href="{{route('booking_taxisteinemann')}}" class="btn back_btn custom_btn" >{{ __('Go Back') }}</a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <p class="msg_display"></p>
                            </div>
                        </div>
                    </form>

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
    <script src="https://momentjs.com/downloads/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" integrity="sha512-Fq/wHuMI7AraoOK+juE5oYILKvSPe6GC5ZWZnvpOO/ZPdtyA29n+a5kVLP4XaLyDy9D1IBPYzdFycO33Ijd0Pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            $(document).on('change','#timerValue',function(){
                datetime = $(this).val();
                $('#timerValueShowInput').val(moment(datetime).format('ddd')+' '+moment(datetime).format('DD-MM-YYYY HH:mm'));
            });
            $(document).on('click','#timerValueShowInput',function(){
                // alert('hlo');
                $('#timerValue').trigger('click');
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

        var directionsService;
        var directionsDisplay;
        var MapPoints = [];
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();

        function initializeMapReport(MapPoints) {
            if (jQuery('#googleMap').length > 0) {
                var locations = MapPoints;
                directionsService = new google.maps.DirectionsService;
                directionsDisplay = new google.maps.DirectionsRenderer;
                window.map = new google.maps.Map(document.getElementById('googleMap'), {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false,
                });

                var infowindow = new google.maps.InfoWindow();
                var bounds = new google.maps.LatLngBounds();
                directionsDisplay = new google.maps.DirectionsRenderer({
                    map: window.map,
                    suppressMarkers: true
                });
                var request = {
                    travelMode: google.maps.TravelMode.DRIVING
                };
                for (i = 0; i < locations.length; i++) {
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
                }
                // call directions service
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
        }
        MapPoints = [{
            Latitude: "{{ $input['pickup_latitude'] }}",
            Longitude: "{{ $input['pickup_longitude'] }}",
            AddressLocation: "{{ $input['pickup_address'] }}"
        }, {
            Latitude: "{{ $input['dropoff_latitude'] }}",
            Longitude: "{{ $input['dropoff_longitude'] }}",
            AddressLocation: "{{ $input['dropoff_address'] }}"
        }];
        initializeMapReport(MapPoints);

        $("#personal_info_form").submit(function(e) {
            e.preventDefault();
            // var form = $(this);
            // form.parsley().validate();
            form_validate_res = form_validate();
            if (form_validate_res){
                // alert('valid');
                $.ajax({
                    url: "{{ route('send_otp_before_ride_booking')}}",
                    type: 'post',
                    dataType: 'json',
                    data: $('form#personal_info_form').serialize(),
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
            }
        })

        function form_validate() 
        {
            if ($.trim($('input[name="first_name"]').val())=="") 
            {
                swal("{{ __('Error') }}","{{ __('First name is required.') }}","error");
                return false;
            }
            if ($.trim($('input[name="phone"]').val())=="") 
            {
                swal("{{ __('Error') }}","{{ __('Phone number is required.') }}","error");
                return false;
            }
            if ($('input[name="terms_conditions"]').prop('checked') != true) 
            {
                swal("{{ __('Error') }}","{{ __('Terms and conditions checkbox is required.') }}","error");
                return false;
            }
            return true;
        }

        // var timerOn = true;
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

        $(document).on('click','.confirmOTPModalResendOtp',function(){
            $.ajax({
                url: "{{ route('send_otp_before_ride_booking')}}",
                type: 'post',
                dataType: 'json',
                data: $('form#personal_info_form').serialize(),
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




        $(document).on("click", ".verify_otp", function(e) {
            e.preventDefault();
            var otp_entered = $(document).find("#otp_entered").val();
            var post_data = $('form#personal_info_form').serialize();
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
                url: "{{ route('verify_otp_and_ride_booking')}}",
                type: 'post',
                dataType: 'json',
                data: post_data,
                success: function(response) {
                    if(response.status){
                        swal("{{ __('Success') }}",response.message,"success");
                            setTimeout(function() {
                                window.location.href = "{{ route('booking_taxisteinemann')}}";
                            }, 2000);
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
        })
    </script>
@endsection