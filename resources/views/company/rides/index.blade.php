@extends('company.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datetime/css/bootstrap-datetimepicker.css') }}">
    <link href="{{ asset('/assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet">
    <style>
        #googleMap {
            background: #dfdfdf;
            max-height: 100%;
            border-radius: 10px;
            height: 100%;
            min-height: 400px;
        }
        .form-control:disabled {
            background-color: white;
        }
    </style>
@endsection
@section('content')
    <form action="booking_done.html" method="post" class="add_details_form" id="booking_list_form">
        @csrf
        <div class="row">
            <div class="col-12">
                <h2 class="board_title">Upcoming Bookings</h2>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 col-xs-12">
                <div class="search_list">
                    <!-- Add Search here -->
                    <div class="list_search_output mt-0">
                        <ul class="list-group list-group-flush">
                            @if (!empty($rides))
                                @foreach ($rides as $ride_value)
                                    <li class="list-group-item" data-ride_id="{{ $ride_value->id }}">
                                        <img src="{{ asset('company/assets/imgs/sideBarIcon/clock.png') }}"
                                            class="img-fluid clock_img" alt="Clock Image">
                                        <span class="point_list position-relative">
                                            <input type="checkbox" name="selectedPoint" class="input_radio_selected"
                                                value="{{ $ride_value->id }}">
                                            {{ date('D, d.M.Y H:i', strtotime($ride_value->ride_time)) }}
                                        </span>
                                        <span class="action_button"> <i class="bi bi-trash3 dlt_list_btn"></i></span>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <!-- List Search End -->
                </div>
                <!-- Search List -->
                <div class="details_box">
                    <div class="boxHeader">
                        <h2 class="board_title mb-0">{{ __('Booking Details')}}</h2>
                        <button class="btn save_btn save_booking" type="submit">{{ __('Book')}}</button>
                        <button class="btn save_btn edit_booking" type="submit" style="display:none">{{ __('Update')}}</button>
                        <button class="btn save_btn cancel_ride" type="button" style="display:none">{{ __('Cancel')}}</button>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                        </div>

                        <div class="col-xs-12">
                            <div class="userBox">
                                <div class="avatarImg_user">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" alt="User Avatar" class="img-fluid active_user">
                                </div>
                                <select class="form-control inside_input_field" name="user_id" id="users">
                                    <option value="">-- Select User --</option>
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->full_name }}{{ !empty($user->phone) ? ' (+' . $user->country_code . '-' . $user->phone . ')' : '' }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="ride_id" id="ride_id">
                                {{-- <div class="user_name">
                                    <h4 class="name active_username">Lilly Blossom</h4>
                                </div> --}}
                            </div>
                        </div>

                    </div>

                    <!-- Row For Name and Count User -->
                    <div class="form-group mt-3 mb-3 position-relative">
                        <img src="{{ asset('company/assets/imgs/sideBarIcon/clock.png') }}"
                            class="img-fluid clock_img setup_ab_clck" alt="Clock Image">
                        <input type="text" class="inside_input_field form-control date_value datetimepicker"
                            name="ride_time" value="{{ date('D d-m-Y H:i') }}" id="ride_time">
                        <img src="{{ asset('company/assets/imgs/sideBarIcon/calendar.png') }}"
                            class="img-fluid setup_ab_cln" alt="Clock Image">
                    </div>
                    <!-- Row Name -->
                    <div class="input-group mb-3">
                            <input type="text" class="inside_input_field form-control normal_font" name="pickup_address"
                                id="pickupPoint" value="" placeholder="{{ __('From') }}" required>
                            <input type="hidden" id="pickup_latitude" name="pick_lat">
                            <input type="hidden" id="pickup_longitude" name="pick_lng">
                            <span class="input-group-text">
                            <button type="button" class="btn-close pickupPointCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                            </span>
                    </div>
                    <!-- Row For Area -->
                    <div class="input-group mb-3">
                        <input type="text" class="inside_input_field form-control normal_font" name="dest_address"
                            id="dropoffPoint" value="" placeholder="{{ __('To') }}">
                        <input type="hidden" id="dropoff_latitude" name="dest_lat">
                        <input type="hidden" id="dropoff_longitude" name="dest_lng">
                        <span class="input-group-text">
                            <button type="button" class="btn-close dropoffPointCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                            </span>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-xs-12 align-self-center">
                            <div class="userBox mt-3">
                                <div class="avatarImg_user">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/bigcar.png') }}" alt="Car"
                                        class="img-fluid car_images me-2">
                                </div>
                                <select class="form-control inside_input_field p-1 text-center" id="carType"
                                    name="car_type">
                                    @if (!empty($vehicle_types))
                                        @foreach ($vehicle_types as $vehicle_type)
                                            <option value="{{ $vehicle_type->id }}"
                                                data-basic_fee="{{ $vehicle_type->basic_fee }}"
                                                data-price_per_km="{{ $vehicle_type->price_per_km }}"
                                                data-seating_capacity="{{ $vehicle_type->seating_capacity }}"
                                                data-text="{{ $vehicle_type->car_type }}">
                                                {{ __($vehicle_type->car_type) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12  align-self-center">
                            <div class="usercounting d-flex mt-3">
                                <img src="{{ asset('company/assets/imgs/sideBarIcon/userCount.png') }}" alt="userCount" class="img-fluid counting_user me-2">
                                <select class="form-control inside_input_field p-1 text-center" id="numberOfPassenger" name="passanger">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xs-12 align-self-center">
                            <div class="usercounting d-flex mt-3">
                                <div class="avatarImg_user">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/cash.png') }}" alt="userCount" class="img-fluid cash_count me-2">
                                </div>
                                <div class="position-relative w-100">
                                    <label class="label_input_cash">CHF</label>
                                    <input type="text" name="ride_cost" class="form-control inside_input_field p-1 ps-4 text-center me-2 price_calculated_input" value="0" readonly>
                                    <input type="hidden" name="distance" class="distance_calculated_input" id="distance_calculated_input">
                                    <input type="hidden" name="payment_type" value="Cash" id="payment_type">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-xs-12  align-self-center">
                            <div class="usercounting d-flex mt-3">
                                <div class="payment_option d-flex align-items-center">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/cash.png') }}" alt="userCount"
                                        class="img-fluid cash_count me-2"> 
                                        <span >Cash</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Side Board -->
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 col-xs-12">
                <div class="map_views mb-4 booking_side desktop_view">
                    <div id="googleMap" style="width:100%;" height="433"></div>
                </div>
                <div class="">
                    <div class="row m-0 w-100">
                        <div class="col-lg-6 col-md-12 col-xs-12 mt-4">
                            <div class="form-group">
                                <textarea class="form-control inside_input_field mb-2" placeholder="Note" name="note" rows="7"
                                    id="note"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12 all_driver_info" style="display: none">
                            <h2 class="board_title booking">Driver Details</h2>
                            <p class="infomation_update done">Booking</p>
                            <div class="userBox mt-3">
                                <div class="avatarImg_diver position-relative">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/driver.png') }}" alt="Driver"
                                        class="img-fluid DriverImage rounded-circle">
                                    <span class="driver_status online"></span>
                                </div>
                                <div class="user_name">
                                    <h4 class="name active_driverImage">Karl</h4>
                                    <p class="number">+41 79 1111 111</p>
                                </div>
                            </div>
                            <div class="userBox mt-3">
                                <div class="avatarImg_diver">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/car_small.png') }}"
                                        alt="car" class="img-fluid DriverImage ">
                                </div>
                                <div class="user_name">
                                    <h4 class="name active_driverImage">Mercedes V class</h4>
                                    <p class="number">SH 50288</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="map_views mb-4 booking_side mobile_view">
                    <div id="googleMap" style="width:100%;" height="433"></div>
                </div> --}}
            </div>
            <!-- Right Map Side-->
        </div>
    </form>
@endsection
<!-- ============================================================== -->
<!-- End Container fluid  -->
@section('footer_scripts')
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn7nxEJGDtQo1wl8Mzg9178JAU2x6-Y0E&libraries=geometry,places&language=en">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <script src="{{ asset('datetime/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>

    <script>
        var socket = io("{{env('SOCKET_URL')}}");

        var directionsService;
        var directionsDisplay;
        var MapPoints = [];
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var onLoadVar = 0;
        var cur_lat = "";
        var cur_lng = "";
        var markers = [];
        var selected_ride_id = "";

        function showPosition(position) {
            if (position != false) {
                var lat = cur_lat = position.coords.latitude;
                var lng = cur_lng = position.coords.longitude;
                pt = new google.maps.LatLng(lat, lng);
                map.setCenter(pt);
                map.setZoom(8);
                $('#pickup_latitude').val(lat);
                $('#pickup_longitude').val(lng);
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({
                    'latLng': pt
                }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        $('#pickupPoint').val(results[0][
                        'formatted_address']); //alert(results[0]['formatted_address']);
                        new google.maps.Marker({
                            position: pt,
                            map,
                            title: results[0]['formatted_address'],
                        });
                    };
                });

                var center = {
                    lat: cur_lat,
                    lng: cur_lng
                };
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
                    // types: ["establishment"], // Whatever types you need
                };
            } else {
                var options = {
                    strictBounds: true, // Only if you want to restrict, not bias
                    // types: ["establishment"], // Whatever types you need
                };
            }
            var pickup_input = document.getElementById('pickupPoint');
            var autocomplete_pickup = new google.maps.places.Autocomplete(pickup_input, options);
            google.maps.event.addListener(autocomplete_pickup, 'place_changed', function() {
                var place = autocomplete_pickup.getPlace();
                // document.getElementById('city2').value = place.name;
                document.getElementById('pickup_latitude').value = place.geometry.location.lat();
                document.getElementById('pickup_longitude').value = place.geometry.location.lng();
                calculate_route();
            });

            var dropoff_input = document.getElementById('dropoffPoint');
            var autocomplete_dropoff = new google.maps.places.Autocomplete(dropoff_input, options);
            // autocomplete_dropoff.setComponentRestrictions({
            // country: ["ch", "de"],
            // });
            google.maps.event.addListener(autocomplete_dropoff, 'place_changed', function() {
                var place = autocomplete_dropoff.getPlace();
                // document.getElementById('city2').value = place.name;
                document.getElementById('dropoff_latitude').value = place.geometry.location.lat();
                document.getElementById('dropoff_longitude').value = place.geometry.location.lng();
                calculate_route();
            });
        }

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


        $(".datetimepicker").datetimepicker({
            format: 'ddd DD-MM-YYYY HH:mm',
            minDate: "{{ date('Y-m-d') }}",
            sideBySide: true,
        });

        function calculate_amount() {
            var distance_calculated = $("#distance_calculated_input").val();
            if ($("#carType").val() == '') {
                swal.fire("{{ __('Error') }}", "{{ __('Please select Car type') }}", "error");
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
            $(".price_calculated_input").val(price_calculation);
        }

        function calculate_route() {
            var pickup_latitude = $("#pickup_latitude").val();
            var pickup_longitude = $("#pickup_longitude").val();
            var pickup_address = $("#pickupPoint").val();
            if (pickup_latitude == '' || pickup_longitude == '') {
                swal.fire("{{ __('Error') }}", "{{ __('Please select Pick up address') }}", "error");
                return false;
            }
            var dropoff_latitude = $("#dropoff_latitude").val();
            var dropoff_longitude = $("#dropoff_longitude").val();
            var dropoff_address = $("#dropoffPoint").val();
            if (dropoff_latitude == '' || dropoff_longitude == '') {
                dropoff_latitude = pickup_latitude;
                dropoff_longitude = pickup_longitude;
                dropoff_address = pickup_address;
                // var distance_calculated = 0;
            } else {
                srcLocation = new google.maps.LatLng(pickup_latitude, pickup_longitude);
                dstLocation = new google.maps.LatLng(dropoff_latitude, dropoff_longitude);
                // var distance = google.maps.geometry.spherical.computeDistanceBetween(srcLocation, dstLocation);
                // var distance_calculated = Math.round(distance / 1000);
            }
            // $(".distance_calculated_input").val(distance_calculated);

            MapPoints = [{
                Latitude: pickup_latitude,
                Longitude: pickup_longitude,
                AddressLocation: pickup_address
            }, {
                Latitude: dropoff_latitude,
                Longitude: dropoff_longitude,
                AddressLocation: dropoff_address
            }];
            // console.log(MapPoints);
            initializeMapReport(MapPoints);
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
                    travelMode: google.maps.TravelMode.DRIVING,
                    optimizeWaypoints: true,
                    provideRouteAlternatives: true,
                    avoidFerries: true,
                    // avoidHighways: true,
                    // avoidTolls: true,
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
                    markers.push(marker);
                }
                // call directions service
                if (locations.length) {
                    directionsService.route(request, function(result, status) {
                        if (status == google.maps.DirectionsStatus.OK) {

                            directionsDisplay.setDirections(result);
                            shortestRouteIndex = setShortestRoute(result);
                            directionsDisplay.setRouteIndex(shortestRouteIndex);
                            distance = result.routes[shortestRouteIndex].legs[0].distance.value/1000;
                            distance = Math.ceil(distance);
                            $('#distance_calculated_input').val(distance);
                            calculate_amount();
                        }
                    });
                    map.fitBounds(bounds);
                }
                // if (onLoadVar==0) {
                //     getLocation()
                //     onLoadVar = 1;   
                //     // alert(onLoadVar);
                // }
                // else
                // {
                //     map.setZoom(8);
                // }
                if ($("#dropoff_latitude").val() == "") {
                    setTimeout(() => {
                        map.setZoom(12);
                    }, 500);
                }

            }
        }

        function setShortestRoute(response) 
        {
            // console.log(response);
            shortestRouteArr = [];
            $.each(response.routes, function( index, route ) {
                shortestRouteArr.push(Math.ceil(parseFloat(route.legs[0].distance.value/1000)));
            });
            return shortestRouteArr.indexOf(Math.min(...shortestRouteArr));
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition,mapError);
            } else {
                swal.fire("{{ __('Error') }}", "{{ __('Geolocation is not supported by this browser.') }}", "error");
            }
        }

        function mapError(err) {
            console.log(err);
            if (err.code==1) {
                if (err.message=="User denied Geolocation") 
                {
                    swal.fire("{{ __('Error') }}", "{{ __('Please enable location permission in your browser') }}", "error");
                }
            }
            showPosition(false);
        }

        $(document).on('change', '#carType', function() {
            calculate_amount();
        })

        function autocomplete_initialize() {
            getLocation();
            initializeMapReport(MapPoints);
        }

        google.maps.event.addDomListener(window, 'load', autocomplete_initialize);

        $(document).on("click", ".save_booking", function(e) {
            e.preventDefault();
            form_validate_res = calculate_route();
            if (form_validate_res) {
                Swal.fire({
                    title: "{{ __('Please Confirm') }}",
                    text: "{{ __('You want to book a ride!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Book Ride') }}"
                }).then((result) => {
                    if (result.value) {
                        $(document).find(".save_booking").attr('disabled', true);
                        $.ajax({
                            url: "{{ route('company.ride_booking') }}",
                            type: 'post',
                            dataType: 'json',
                            data: $('form#booking_list_form').serialize(),
                            success: function(response) {
                                if (response.status) {
                                    swal.fire("{{ __('Success') }}", response.message,
                                        "success");
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                } else if (response.status == 0) {
                                    swal.fire("{{ __('Error') }}", response.message,
                                        "error");
                                    $(document).find(".save_booking").removeAttr('disabled');
                                }
                            },
                            error(response) {
                                swal.fire("{{ __('Error') }}", response.message, "error");
                                $(document).find(".save_booking").removeAttr('disabled');
                            }
                        });
                    }
                });
            }
        });

        $(window).on("load", function() {
            $("#users").select2();
            $(document).on('click', '.input_radio_selected', function() {
                var ride_id = $(this).val();
                selected_ride_id = ride_id;
                document.getElementById("booking_list_form").reset();
                measure_seating_capacity();
                $(document).find(".save_booking").hide();
                $.ajax({
                    url: "{{ route('company.rides.edit') }}",
                    type: 'get',
                    data: {
                        ride_id: ride_id
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#ride_id").val(ride_id);
                            if(response.data.ride_detail.user_id == 0){
                                $("#users").val("").change();
                            } else {
                                $("#users").val(response.data.ride_detail.user_id).change();
                            }
                            $("#pickupPoint").val(response.data.ride_detail.pickup_address);
                            $("#pickup_latitude").val(response.data.ride_detail.pick_lat);
                            $("#pickup_longitude").val(response.data.ride_detail.pick_lng);
                            $("#dropoffPoint").val(response.data.ride_detail.dest_address);
                            $("#dropoff_latitude").val(response.data.ride_detail.dest_lat);
                            $("#dropoff_longitude").val(response.data.ride_detail.dest_lng);
                            $("#carType option[data-text=" + response.data.ride_detail
                                .car_type + "]").attr('selected', 'selected').change();
                            $("#numberOfPassenger").val(response.data.ride_detail.passanger)
                                .change();
                            $(".price_calculated_input").val(response.data.ride_detail
                                .ride_cost);
                            $("#distance_calculated_input").val(response.data.ride_detail
                                .distance);
                            $("#payment_type").val(response.data.ride_detail.payment_type);
                            $("#note").val(response.data.ride_detail.note);
                            $("#ride_time").val(response.data.ride_detail.ride_time);
                            if (response.data.ride_detail.pick_lat) {
                                MapPoints = [{
                                    Latitude: response.data.ride_detail.pick_lat,
                                    Longitude: response.data.ride_detail.pick_lng,
                                    AddressLocation: response.data.ride_detail
                                        .pickup_address
                                }];
                                if (response.data.ride_detail.dest_lat) {
                                    MapPoints.push({
                                        Latitude: response.data.ride_detail.dest_lat,
                                        Longitude: response.data.ride_detail.dest_lng,
                                        AddressLocation: response.data.ride_detail
                                            .dest_address
                                    });
                                }
                                initializeMapReport(MapPoints);
                            }
                            driver_detail_update(ride_id);
                            if(response.data.ride_detail.status == 0){
                                $("#users").removeAttr("disabled");
                                $("#ride_time").removeAttr("readonly");
                                $("#pickupPoint").removeAttr("disabled");
                                $("#dropoffPoint").removeAttr("disabled");
                                $(".pickupPointCloseBtn").removeAttr("disabled");
                                $(".dropoffPointCloseBtn").removeAttr("disabled");
                                $("#carType").removeAttr("disabled");
                                $("#numberOfPassenger").removeAttr("disabled");
                                $("#note").removeAttr("readonly");
                                $(document).find(".cancel_ride").hide();
                                $(document).find(".edit_booking").show();
                            } else if(response.data.ride_detail.status == 1 || response.data.ride_detail.status == 2 || response.data.ride_detail.status == 4){
                                $(document).find(".edit_booking").hide();
                                $(document).find(".cancel_ride").show();
                                $("#users").attr("disabled",true);
                                $("#ride_time").attr("readonly",true);
                                $("#pickupPoint").attr("disabled",true);
                                $("#dropoffPoint").attr("disabled",true);
                                $(".pickupPointCloseBtn").attr("disabled",true);
                                $(".dropoffPointCloseBtn").attr("disabled",true);
                                $("#carType").attr("disabled",true);
                                $("#numberOfPassenger").attr("disabled",true);
                                $("#note").attr("readonly",true);
                            }
                        } else if (response.status == 0) {
                            swal.fire("{{ __('Error') }}", response.message, "error");
                        }
                    },
                    error(response) {
                        swal.fire("{{ __('Error') }}", response.message, "error");
                    }
                });
            });
        });

        function driver_detail_update(ride_id){
            $.ajax({
                    url: "{{ route('company.rides.driver_detail') }}",
                    type: 'get',
                    data: {
                        ride_id: ride_id
                    },
                    success: function(response) {
                        if (response.status) {
                            if(response.data.driver_detail){
                                $(document).find(".all_driver_info").html(response.data.driver_detail)
                                $(document).find(".all_driver_info").show();
                            } else {
                                $(document).find(".all_driver_info").hide();
                            }
                        } else if (response.status == 0) {
                            swal.fire("{{ __('Error') }}", response.message, "error");
                        }
                    },
                    error(response) {
                        swal.fire("{{ __('Error') }}", response.message, "error");
                    }
                });
        }

        socket.on('ride-update-response', function(response) {
            if(response && response[0] && response[0].id){
                if(selected_ride_id == response[0].id){
                    $(".input_radio_selected[value='"+selected_ride_id+"']").trigger("click");
                    // driver_detail_update(selected_ride_id);
                }
            }
        });

        $(document).on("click", ".edit_booking", function(e) {
            e.preventDefault();
            form_validate_res = calculate_route();
            if (form_validate_res) {
                Swal.fire({
                    title: "{{ __('Please Confirm') }}",
                    text: "{{ __('You want to update this ride!') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('Update Ride') }}"
                }).then((result) => {
                    if (result.value) {
                        $(document).find(".edit_booking").attr('disabled', true);
                        $.ajax({
                            url: "{{ route('company.ride_booking_update') }}",
                            type: 'post',
                            dataType: 'json',
                            data: $('form#booking_list_form').serialize(),
                            success: function(response) {
                                if (response.status) {
                                    swal.fire("{{ __('Success') }}", response.message,
                                        "success");
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                } else if (response.status == 0) {
                                    swal.fire("{{ __('Error') }}", response.message,
                                        "error");
                                    $(document).find(".edit_booking").removeAttr('disabled');
                                }
                            },
                            error(response) {
                                swal.fire("{{ __('Error') }}", response.message, "error");
                                $(document).find(".edit_booking").removeAttr('disabled');
                            }
                        });
                    }
                });
            }
        });

        function delete_cancel_ride(ride_id){
            Swal.fire({
                title: "{{ __('Please Confirm') }}",
                text: "{{ __('You want to delete this ride!') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('Yes, delete it') }}"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('company.cancel_booking') }}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'ride_id': ride_id
                        },
                        success: function(response) {
                            if (response.status) {
                                $(document).find("li.list-group-item[data-ride_id='" + ride_id + "']").remove();
                                Swal.fire("Success", response.message, "success");
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            } else if (response.status == 0) {
                                Swal.fire("{{ __('Error') }}", response.message, "error");
                            }
                        },
                        error(response) {
                            Swal.fire("{{ __('Error') }}", response.message, "error");
                        }
                    });
                }
            });
        }

        $(document).on('click', '.dlt_list_btn', function(e) {
            e.preventDefault();
            var ride_id = $(this).parents('li.list-group-item').data('ride_id');
            delete_cancel_ride(ride_id);
        });

        $(document).on('click', '.cancel_ride', function(e) {
            e.preventDefault();
            delete_cancel_ride(selected_ride_id);
        });
        

        $(document).on('click','.pickupPointCloseBtn',function(){
            $('#pickupPoint').val('');
            $('#pickup_latitude').val('');
            $('#pickup_longitude').val('');
            $(".distance_calculated_input").val(0);
            initializeMapReport([]);
            calculate_amount();
        });

       $(document).on('click','.dropoffPointCloseBtn',function(){
            $('#dropoffPoint').val('');
            $('#dropoff_latitude').val('');
            $('#dropoff_longitude').val('');
            $(".distance_calculated_input").val(0);
            calculate_amount();
            if($('#pickup_latitude').val()!="")
            {
                initializeMapReport([{
                    Latitude: $('#pickup_latitude').val(),
                    Longitude: $('#pickup_longitude').val(),
                    AddressLocation: $('#pickupPoint').val()
                }]);
            } else {
                initializeMapReport([]);
            }
       });
    </script>
@stop
