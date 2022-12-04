@extends('layouts.web_booking')
@section('css')
    <style>
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


        .booking_list_form label {
            font-family: 'Poppins', sans-serif;
        }

        label {
            font-size: 13px;
            font-style: italic !important;
            font-weight: 600;
        }

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

        .show_case .lst_col {
            padding: 0px;
        }

        /* .value {
            color: black;
            font-size: 20px;
            font-weight: 600;
            padding: 15px;
            border-radius: 5px;
        } */

        .btn {
            border-radius: 200px !important;
        }

        .value_point {
            margin: 0;
            background: white;
            text-align: center;
            padding: 9px 5px 9px 0px;
            border-radius: 5px;
        }

        .filter_booking_section_row .col-3 {
            padding-left: 0;
        }

        .filter_booking_section_row .col-4 {
            padding-right: 0px;
        }

        .filter_result {
            border-radius: 5px;
        }

        .iti.iti--allow-dropdown {
            width: 100%;
        }

        .title_form {
            background: black;
            padding: 15px;
            text-align: center;
            color: white;
            margin-bottom: 30px;
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
            max-width: 41px;
            margin-right: 17px;
            position: relative;
            left: -7px
        }

        form .col-xs-12 {
            align-self: center;
        }

        .form-check-label a {
            white-space: break-spaces;
        }

        .icon_img.img-repsonsive {
            max-width: 20px;
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

        #numberOfPassenger {
            padding: 0px;
        }

        .filter_booking_section_row .col-5 {
            padding-right: 0px;
            padding-left: 0px;
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

        @media (max-width: 300px) {

            .col-4,
            .col-5,
            .col-3,
            .col-7,
            .col-6 {
                min-width: 100% !important;
            }

            .row.row_fileterBooking .col-4:nth-child(2) {
                padding: 12px;
            }
        }

        @media (max-width: 400px) {
            .filter_booking_section_row .custom_btn {
                font-size: 9px;
                padding: 9px !important;
                font-weight: 700;
            }
        }

        @media (max-width: 500px) {
            .value_point {
                margin-bottom: 0px;
                font-size: 15px;
            }

            #numberOfPassenger {
                padding: 0px;
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

            .value_point {
                margin-bottom: 0px;
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
                padding-left: 0px;
            }

            /* .value {
                color: black;
                font-size: 14px;
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
                font-size: 14px;
                font-weight: 600;
                white-space: nowrap;
                width: 100%;
                padding: 0px;
            } */

            .value_point {
                margin-bottom: 0px;
            }

            #googleMap {
                max-height: 100% !important;
            }
        }

        @media (min-width: 1200px) {
            .container-fluid.form_container {
                max-width: 1800px;
            }
        }

        @media (min-width: 1020px) {
            /* .value {
                color: black;
                font-size: 13px;
                font-weight: 600;
                padding: 0 3px 0px 0px;
                border-radius: 5px;
            } */
        }

        @media (min-width: 768px) {
            .form_wrapper {
                min-height: 70vh;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 col-12">
            <div class="logo_img_top_1">
                <img src="{{ asset('public/images/vel_logo.png') }}" class="img-responsive imagelogo_brand"
                    alt="img Logo">
            </div>
            <div class="filter_booking_list">
                <form class="booking_list_form">
                    <div class="row w-100 m-0">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                            <div class="form-group">
                                <input type="text" class="form-control input_field" name="pickupPoint"
                                    id="pickupPoint" placeholder="{{ __('From') }}" required>
                                <input type="hidden" id="pickup_latitude" name="pickup_latitude">
                                <input type="hidden" id="pickup_longitude" name="pickup_longitude">
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-0">
                            <div class="form-group">
                                <input type="text" class="form-control input_field" name="dropoffPoint"
                                    id="dropoffPoint" placeholder="{{ __('To') }}" required>
                                <input type="hidden" id="dropoff_latitude" name="dropoff_latitude">
                                <input type="hidden" id="dropoff_longitude" name="dropoff_longitude">
                            </div>
                        </div>
                    </div>
                    <div class="row w-100 m-0 filter_booking_section_row">
                        <div class="col-lg-4 col-md-4 col-sm-5 col-5">
                            <div class="form-group field_icons">
                                <i class="fas fa-taxi fa-2x mr-1"></i>
                                <select class="form-control select_field p-0" id="carType" name="carType">
                                    @if (!empty($vehicle_types))
                                        @foreach ($vehicle_types as $vehicle_type)
                                            <option value="{{ $vehicle_type->id }}"
                                                data-basic_fee="{{ $vehicle_type->basic_fee }}"
                                                data-price_per_km="{{ $vehicle_type->price_per_km }}"
                                                data-seating_capacity="{{ $vehicle_type->seating_capacity }}">
                                                {{ __($vehicle_type->car_type) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                            <div class="form-group field_icons">
                                <i class="fas fa-male fa-2x ml-2 mr-1"></i>
                                <select class="form-control select_field" id="numberOfPassenger"
                                    name="numberOfPassenger">
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-4 col-4 align-self-end">
                            <div class="form-group">
                                <button type="button" class="btn submit_btn custom_btn calculate_route"
                                    style="padding: 7px;">{{ __('CALCULATE') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- ============================================================== -->
                <!-- Booking list Form Content End -->
                <!-- ============================================================== -->

            </div>
            <div class="filter_result ">
                <form id="booking_list_form" method="POST" action="{{ route('booking_form') }}">
                    @csrf
                    <div class="row row_fileterBooking show_case">

                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-center">
                            <div class="form-group">
                                <p class="form-control pr-0 pl-0" style="font-size: 13px"><span class="price_calculated">CHF ---</span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 text-center lst_col">
                            <div class="form-group">
                                <p class="form-control pr-0 pl-0" style="font-size: 13px"><span class="distance_calculated">KM ---</span></p>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-8 col-8">
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-4 col-4 align-self-center pr-0 ">
                            <div class="form-group">
                                <input type="hidden" id="booking_pickup_address" name="pickup_address">
                                <input type="hidden" id="booking_pickup_latitude" name="pickup_latitude">
                                <input type="hidden" id="booking_pickup_longitude"
                                    name="pickup_longitude">
                                <input type="hidden" id="booking_dropoff_address"
                                    name="dropoff_address">
                                <input type="hidden" id="booking_dropoff_latitude"
                                    name="dropoff_latitude">
                                <input type="hidden" id="booking_dropoff_longitude"
                                    name="dropoff_longitude">
                                <input type="hidden" name="distance_calculated"
                                    class="distance_calculated_input">
                                <input type="hidden" name="price_calculated"
                                    class="price_calculated_input">
                                <input type="hidden" id="booking_carType" name="carType">
                                <input type="hidden" id="booking_numberOfPassenger"
                                    name="numberOfPassenger">
                                <button type="button" class="btn custom_btn book_online_now"
                                    style="padding: 7px;">{{ __('NEXT') }}</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- ============================================================== -->
            <!-- Filter list Result Content End -->
            <!-- ============================================================== -->

            <div class="filter_result ">
                <div class="row row_fileterBooking show_case">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <a href="{{ route('list_of_booking') }}" class="btn btn-outline-danger btn-block">{{ __('MANAGE BOOKINGS') }}</a>
                        </div>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn7nxEJGDtQo1wl8Mzg9178JAU2x6-Y0E&libraries=geometry,places&language={{ app()->getLocale() }}">
    </script>
    <script src="{{ URL::asset('resources') }}/assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script>

        var directionsService;
        var directionsDisplay;
        var MapPoints = [];
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var onLoadVar = 0;
        var cur_lat = "";
        var cur_lng = "";

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition,mapError);
            } else {
                alert("{{ __('Geolocation is not supported by this browser.') }}");
            }
        }

        function mapError(err) {
            console.log(err);
            if (err.code==1) {
                if (err.message=="User denied Geolocation") 
                {
                    alert("{{ __('Please enable location permission in your browser') }}");
                }
            }
        }

        function showPosition(position) {
            var lat = cur_lat = position.coords.latitude;
            var lng = cur_lng = position.coords.longitude;
            pt = new google.maps.LatLng(lat, lng);
            map.setCenter(pt);
            map.setZoom(13);
            $('#pickup_latitude').val(lat);
            $('#pickup_longitude').val(lng);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': pt}, function(results, status) {
                if(status == google.maps.GeocoderStatus.OK) {
                    $('#pickupPoint').val(results[0]['formatted_address']);//alert(results[0]['formatted_address']);
                    new google.maps.Marker({
                        position: pt,
                        map,
                        title: results[0]['formatted_address'],
                    });
                };
            });

            var center = { lat: cur_lat, lng: cur_lng };
            var defaultBounds = {
                                        north: center.lat + 5,
                                        south: center.lat - 5,
                                        east: center.lng + 5,
                                        west: center.lng - 5,
                                    };
            var options = {
                                        bounds: defaultBounds,
                                        // fields: ["address_components"], // Or whatever fields you need
                                        strictBounds: true, // Only if you want to restrict, not bias
                                        types: ["establishment"], // Whatever types you need
                                    };
            var input = document.getElementById('pickupPoint');
            var autocomplete_pickup = new google.maps.places.Autocomplete(input,options);
            // autocomplete_pickup.setComponentRestrictions({
            //     country: ["ch", "de"],
            // });
            // Create a bounding box with sides ~10km away from the center point
            google.maps.event.addListener(autocomplete_pickup, 'place_changed', function() {
                var place = autocomplete_pickup.getPlace();
                // document.getElementById('city2').value = place.name;
                document.getElementById('pickup_latitude').value = place.geometry.location.lat();
                document.getElementById('pickup_longitude').value = place.geometry.location.lng();
            });

            var dropoff_input = document.getElementById('dropoffPoint');
            var autocomplete_dropoff = new google.maps.places.Autocomplete(dropoff_input,options);
            // autocomplete_dropoff.setComponentRestrictions({
            //     country: ["ch", "de"],
            // });
            google.maps.event.addListener(autocomplete_dropoff, 'place_changed', function() {
                var place = autocomplete_dropoff.getPlace();
                // document.getElementById('city2').value = place.name;
                document.getElementById('dropoff_latitude').value = place.geometry.location.lat();
                document.getElementById('dropoff_longitude').value = place.geometry.location.lng();
            });
        }

        function autocomplete_initialize() {
            initializeMapReport(MapPoints);
            //             map = new google.maps.Map(document.getElementById('googleMap'), {
            //     center: new google.maps.LatLng(48.1293954,12.556663),//Setting Initial Position
            //     zoom: 10
            //   });
        }

        google.maps.event.addDomListener(window, 'load', autocomplete_initialize);

        $(document).on('click', '.calculate_route', function(e) {
            e.preventDefault();
            calculate_route();
        });

        function calculate_route() {
            var pickup_latitude = $("#pickup_latitude").val();
            var pickup_longitude = $("#pickup_longitude").val();
            var pickup_address = $("#pickupPoint").val();
            if (pickup_latitude == '' || pickup_longitude == '') {
                swal("{{ __('Error') }}", "{{ __('Please select Pick up address') }}", "error");
                return false;
            }
            var dropoff_latitude = $("#dropoff_latitude").val();
            var dropoff_longitude = $("#dropoff_longitude").val();
            var dropoff_address = $("#dropoffPoint").val();
            if (dropoff_latitude == '' || dropoff_longitude == '') {
                dropoff_latitude = pickup_latitude;
                dropoff_longitude = pickup_longitude;
                dropoff_address = pickup_address;
                //     swal("Error", "Please select Drop off address", "error");
                //     return false;
            }

            // var distanceService = new google.maps.DistanceMatrixService();
            // distanceService.getDistanceMatrix({
            //         origins: [pickup_latitude, pickup_longitude],
            //         destinations: [dropoff_latitude, dropoff_longitude],
            //         travelMode: google.maps.TravelMode.WALKING,
            //         unitSystem: google.maps.UnitSystem.METRIC,
            //         durationInTraffic: true,
            //         avoidHighways: false,
            //         avoidTolls: false
            //     },
            //     function(response, status) {
            //         if (status !== google.maps.DistanceMatrixStatus.OK) {
            //             console.log('Error:', status);
            //         } else {
            //             console.log(response);
            //             $(".distance_calculated").text(response.rows[0].elements[0].distance.text).show();
            //             // $("#duration").text(response.rows[0].elements[0].duration.text).show();
            //         }
            //     });

            srcLocation = new google.maps.LatLng(pickup_latitude, pickup_longitude);
            dstLocation = new google.maps.LatLng(dropoff_latitude, dropoff_longitude);
            var distance = google.maps.geometry.spherical.computeDistanceBetween(srcLocation, dstLocation);
            var distance_calculated = Math.round(distance / 1000);
            $(".distance_calculated").text(distance_calculated + " KM");
            $(".distance_calculated_input").val(distance_calculated);
            if ($("#carType").val() == '') {
                swal("{{ __('Error') }}", "{{ __('Please select Car type') }}", "error");
                return false;
            }
            var carType = $('#carType').val();
            var vehicle_basic_fee = $('#carType > option:selected').data('basic_fee');
            var vehicle_price_per_km = $('#carType > option:selected').data('price_per_km');
            if (distance_calculated == 0) {
                var price_calculation = 0;
            } else {
                var price_calculation = Math.round((vehicle_basic_fee + (distance_calculated * vehicle_price_per_km)) *
                    100) / 100;
            }
            $(".price_calculated").text(price_calculation +
                " CHF");
            $(".price_calculated_input").val(price_calculation);
            MapPoints = [{
                Latitude: pickup_latitude,
                Longitude: pickup_longitude,
                AddressLocation: pickup_address
            }, {
                Latitude: dropoff_latitude,
                Longitude: dropoff_longitude,
                AddressLocation: dropoff_address
            }];
            initializeMapReport(MapPoints);
            $("#booking_pickup_address").val(pickup_address);
            $("#booking_pickup_latitude").val(pickup_latitude);
            $("#booking_pickup_longitude").val(pickup_longitude);
            $("#booking_dropoff_address").val(dropoff_address);
            $("#booking_dropoff_latitude").val(dropoff_latitude);
            $("#booking_dropoff_longitude").val(dropoff_longitude);
            $("#booking_carType").val(carType);
            $("#booking_numberOfPassenger").val($('#numberOfPassenger').val());
            return true;
        }

        function initializeMapReport(MapPoints) {
            if (jQuery('#googleMap').length > 0) {
                var locations = MapPoints;
                directionsService = new google.maps.DirectionsService;
                directionsDisplay = new google.maps.DirectionsRenderer;
                map = new google.maps.Map(document.getElementById('googleMap'), {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false,
                    center: {
                        lat: 46.8182,
                        lng: 8.2275
                    }, //Setting Initial Position
                    zoom: 8
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
                if (locations.length) {
                    directionsService.route(request, function(result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {
                            directionsDisplay.setDirections(result);
                        }
                    });
                    map.fitBounds(bounds);
                }
                if (onLoadVar==0) {
                    getLocation()
                    onLoadVar = 1;   
                    // alert(onLoadVar);
                }
                else
                {
                    map.setZoom(8);
                }
            }
        }

        $(document).on('click', '.book_online_now', function(e) {
            e.preventDefault();
            if (calculate_route()) {
                $("#booking_list_form").submit();
            }
        });

        function measure_seating_capacity() {
            var seating_capacity = $('#carType > option:selected').data('seating_capacity');
            $('#numberOfPassenger').find('option').remove();
            for (var i = 1; i <= seating_capacity; i++) {
                $('#numberOfPassenger').append("<option value='" + i + "'>" + i + "</option>");
            }
        }
        measure_seating_capacity();
        $(document).on('change', '#carType', function() {
            measure_seating_capacity();
        })
    </script>
@endsection