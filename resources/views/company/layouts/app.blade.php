<!DOCTYPE html>
<html>
    <head>
        <title>{{ env('APP_NAME') }} {{ isset($page_title)?' - '.$page_title:'' }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <!-- Select Text CSS-->
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <!-- Swiper Slider -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
        <!-- Custom CSS -->
        <link href="{{ asset('new-design-company/assets/css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    </head>
    <body>
        <style>
            .alert-success {
                --bs-alert-color: #0f5132 !important;
                --bs-alert-bg: #fc4c02 !important;
                --bs-alert-border-color: #fc4c02 !important;
                color: white !important;
                max-width: 600px !important;
                margin-top: 30px !important;
                margin-bottom: 0px !important;
            }
            .active>.page-link, .page-link.active {
                z-index: 3;
                color: white !important;
                background-color: #fc4c02 !important;
                border-color: #fc4c02 !important;
            }
            #googleMap {
                background: #dfdfdf;
                max-height: 100%;
                border-radius: 10px;
                height: 100%;
                min-height: 250px;
            }
            .selected
            {
                background: white !important;
            }
            .infomation_update
            {
                margin-left: 10px;
                border-radius: 10px;
                padding: 5px;
                font-size: 14px;
                color: white;
            }
            .fc-event
            {
                cursor: pointer;
            }
        </style>
        @include('company.elements.header')
        <div class="main_content">
            <div class="dashbaord_bodycontent">
                @yield('content')
            </div>
        </div>
        <!-- Section View Booking -->
        <section class="add_booking_modal view_booking" id="view_booking">
            <article class="booking_container_box">
                <a href="#" class="back_btn_box mobile_view close_modal_action_view">
                    <img src="{{ asset('new-design-company/assets/images/back_icon.svg') }}" class="img-fluid back_btn" alt="Back arrow" />
                    <span class="btn_text ">Back</span>
                </a>
                <div class="header_top view_header">
                    <h4 class="sub_heading booking_details_with_status d-flex">Booking Details</h4>
                    <span class="close_modal desktop_view close_modal_action_view">&times;</span>
                </div>
                    <div class="map_frame">
                        <div id="googleMap" class="googleMapDesktop"></div>
                    </div>
                    <div class="pickup_Drop_box">
                        <div class="area_details">
                            <div class=" area_box pickUp_area veiw_pickup">
                                <img src="{{ asset('new-design-company/assets/images/pickuppoint.png') }}" class="img-fluid pickup_icon" alt="pick up icon"/>
                                <div class="location_box">
                                    <label class="form_label">Pickup Point</label>
                                    <p class="pickup_field mb-0 ride_user_start_location"></p>
                                </div>
                            </div>
                            <div class=" area_box dropUp_area ride_user_end_location_box">
                                <img src="{{ asset('new-design-company/assets/images/drop_point.png') }}" class="img-fluid pickup_icon" alt="Drop up icon"/>
                                <div class="location_box">
                                    <label class="form_label">Drop Point</label>
                                    <p class="pickup_field mb-0 ride_user_end_location"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="date_picker_box">
                        <div class="date_area_box d-flex justify-content-between">
                            <div class=" area_box pickUp_area">
                                <img src="{{ asset('new-design-company/assets/images/calendar-days.svg') }}" class="img-fluid svg pickup_icon" alt="pick up icon"/>
                                <div class="location_box">
                                    <label class="form_label">Pick a Date</label>
                                    <label class="pickupdate ride_new_date">08/02/2023</label>
                                </div>

                            </div>
                            <div class="divider_form_area vrt view_port">
                                <span class="divider_area vrt "></span>
                            </div>
                            <div class=" area_box dropUp_area timer_picker mb-3">
                                <img src="{{ asset('new-design-company/assets/images/clock.svg') }}" class="img-fluid svg pickup_icon" alt="Drop up icon"/>
                                <div class="location_box">
                                    <label class="form_label">Pick a Time</label>
                                    <label class="pickTimes ride_new_time">06:00 PM</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="driver_date_picker">
                        <div class="date_area_box d-flex justify-content-between">
                            <div class=" area_box pickUp_area">
                                <div class="location_box">
                                    <label class="form_label">Driver Details</label>
                                    <div class="viewuser_sidebar d-flex align-items-center ride_driver_details_div">
                                        <img src="{{ asset('new-design-company/assets/images/user.png') }}" alt="User avatar" class="img-fluid user_avatar ride_driver_details_div_image"/>
                                        <div class="name_occupation d-flex flex-column">
                                            <span class="user_name ride_driver_details_div_user_name"></span>
                                            <a href="javsscript:;" class="user_position side_mob_link ride_driver_details_div_driver_phone"></a>
                                        </div>
                                    </div>
                                    <p class="ride_driver_details_div_driver_na" style="display: none">N/A</p>
                                </div>
                            </div>
                            <div class="divider_form_area vrt view_port">
                                <span class="divider_area vrt "></span>
                            </div>
                            <div class=" area_box dropUp_area timer_picker">
                                <div class="location_box">
                                    <label class="form_label" style="text-align: right">Car Type</label>
                                    <div class="viewuser_sidebar d-flex align-items-center ride_car_div">
                                        <img src="{{ asset('new-design-company/assets/images/business.png') }}" alt="Selected Car" class="img-fluid car_selectImg ride_car_div_image"/>
                                        <div class="name_occupation d-flex flex-column">
                                            <span class="user_name ride_car_div_type"></span>
                                            <span class="user_name ride_car_div_number"></span>
                                        </div>
                                    </div>
                                    <p class="ride_car_div_na" style="display: none">N/A</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="passengers_box_details">
                        <div class="passenger_box_content row justify-content-between">
                            <div class="col-lg-7 col-md-7 col-sm-6 col-6 ps-0">
                                <div class="number_psnger d-flex">
                                    <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                                    <div class="location_box">
                                        <label class="form_label" style="margin-bottom:0px">No. Of Passengers</label>
                                        <label class="user_name text-dark no_of_passengers"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7 col-md-7 col-sm-6 col-6 pe-0" style="padding-left: 0px;margin-top: 10px;">
                                <div class="name_psnger d-flex">
                                    <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                                    <div class="location_box">
                                        <label class="form_label" style="margin-bottom:0px">Name of Passenger</label>
                                        <label class="user_name text-dark passenger_details"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_payment_box">
                        <div class="row w-100 m-0">
                            <div class="col-lg-7 col-md-7 col-sm-6 col-6 ps-0 method_box">
                                <div class="form_box">
                                    <label class="form_label down_form_label d-block">Payment Method</label>
                                    <label class="user_name">
                                        {{-- <img src="{{ asset('new-design-company/assets/images/card.svg') }}" class="img-fluid card_img me-2" alt="payment Image"> --}}
                                        <span class="ride_payment_type">Cash</span></label>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-6 col-6 pe-0 amount_box">
                                <div class="form_box">
                                    <label class="form_label down_form_label d-block">Amount</label>
                                    <label class="user_name"><span class="ride_car_price"></span></label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                                <div class="form_box add_note">
                                    <label class="form_label down_form_label d-block">Note</label>
                                    <label class="user_name ride_note_div"></label>
                                </div>
                            </div>
                        </div>
                    </div>
            </article>
        </section>
        <!-- /Section View Booking -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://dunggramer.github.io/disable-devtool/disable-devtool.min.js" defer></script>
        <!-- /Scripts -->
        <!-- Select text js -->
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <!-- Swiper Js -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
        <!-- Calendar -->
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.8/index.global.min.js'></script>
        <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/list@6.1.8/index.global.min.js'></script>
        <!-- Custom Js -->
        <script src="{{ asset('new-design-company/assets/js/main.js') }}" type="application/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
        <script>
            //Swiper Slider Car
            var swiper = new Swiper(".carSwiper", {
                slidesPerView: 3,
                spaceBetween: 30,
                breakpoints: {
                    190: {
                        slidesPerView:2.5,
                        spaceBetween: 10
                    },
                    480: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 40
                    }
                }
            });
            //Select Text Js
            var settings = {
                plugins: ['remove_button'],
                create: true,
                onItemAdd:function(){
                    this.setTextboxValue('');
                    this.refreshOptions();
                },
                render:{
                    option:function(data,escape){
                        return '<div class="d-flex"><span>' + escape(data.value) + '</span><span class="ms-auto text-muted">' + escape(data.date) + '</span></div>';
                    },
                    item:function(data,escape){
                        return '<div>' + escape(data.value) + '</div>';
                    }
                }
            };
            if ($('#tom-select-it').length > 0) {
                new TomSelect('#tom-select-it',settings);
            }
        </script>
        @yield('footer_scripts')
        @if (\Request::route()->getName()=='company.rides')
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn7nxEJGDtQo1wl8Mzg9178JAU2x6-Y0E&libraries=geometry,places&callback=Function.prototype"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
            <script>
                    var socket = io("{{env('SOCKET_URL')}}");
                    var map;
                    var MapPoints = [];
                    var booking = [];
                    var directionsDisplay;
                    var directionsService = new google.maps.DirectionsService();
                    var markers = [];
                    var selected_ride_id = "";
                    var booking = [];
                    map = new google.maps.Map(document.getElementById('googleMap'), {
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        scrollwheel: false,
                        center: { lat: 46.8182, lng: 8.2275 },//Setting Initial Position
                        zoom: 8
                    });
                    async function showRideModal(rideId,Dclass)
                    {
                        selected_ride_id = rideId;
                        route = "{{ route('company.ride_detail','~') }}";
                        route = route.replace('~',selected_ride_id);
                        await $.ajax({
                            url: route,
                            type: 'POST',
                            data: {
                            _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                booking = response.data;
                            },
                            error(response) {
                                swal.fire("{{ __('Error') }}", response.message, "error");
                            }
                        });
                        $('.'+Dclass).removeClass('selected');
                        $('.'+Dclass+'[data-id="'+rideId+'"]').addClass('selected');
                        $('.ride_user_start_location').html(booking.pickup_address);
                        $('.ride_user_end_location_box').hide();
                        if(booking.dest_address && booking.dest_address!=null)
                        {
                            $('.ride_user_end_location_box').show();
                            $('.ride_user_end_location').html(booking.dest_address);
                        }
                        $('.ride_new_date').html(booking.ride_date_new_modified);
                        $('.ride_new_time').html(booking.ride_time_new_modified);

                        $('.ride_driver_details_div').hide();
                        $('.ride_driver_details_div').removeClass('d-flex');
                        $('.ride_driver_details_div_driver_na').show();
                        if (booking.driver!=null)
                        {
                            $('.ride_driver_details_div').show();
                            $('.ride_driver_details_div').addClass('d-flex');
                            $('.ride_driver_details_div_user_na').hide();
                            if(booking.driver.image_with_url){
                                $('.ride_driver_details_div_image').attr('src',booking.user.image_with_url);
                            } else {
                                $('.ride_driver_details_div_image').attr('src',"{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}");
                            }
                            $('.ride_driver_details_div_driver_name').html(booking.driver.first_name+' '+booking.driver.last_name);
                            $('.ride_driver_details_div_driver_phone').html('+'+booking.driver.country_code+'-'+booking.driver.phone);
                        }

                        $('.ride_car_div').hide();
                        $('.ride_car_div').removeClass('d-flex');
                        $('.ride_car_div_na').show();
                        if (booking.vehicle!=null)
                        {
                            $('.ride_car_div').show();
                            $('.ride_car_div').addClass('d-flex');
                            $('.ride_car_div_na').hide();
                            if(booking.vehicle.image_with_url){
                                $('.ride_car_div_image').attr('src',booking.vehicle.image_with_url);
                            } else {
                                $('.ride_car_div_image').attr('src',"{{ asset('car-icon.png') }}");
                            }
                            $('.ride_car_div_type').html(booking.vehicle.model);
                            $('.ride_car_div_number').html(booking.vehicle.vehicle_number_plate);
                        }

                        $('.no_of_passengers').html(booking.passanger);
                        if (booking.user && booking.user.first_name)
                        {
                            $('.passenger_details').html(booking.user.first_name+' '+booking.user.last_name+"  (+"+booking.user.country_code+'-'+booking.user.phone+")");
                        }
                        $('.ride_payment_type').html(booking.payment_type);
                        $('.ride_car_price').html('CHF '+booking.ride_cost);
                        $('.ride_note_div').html(booking.note);

                        ride_status = ""
                        if(booking.status == -2)
                        {
                            ride_status = `<p class="infomation_update done bg-danger">Cancelled</p>`;
                        }
                        else if(booking.status == -1)
                        {
                            ride_status = `<p class="infomation_update done bg-danger">Rejected</p>`;
                        }
                        else if(booking.status == 1)
                        {
                            ride_status = `<p class="infomation_update done bg-info">Accepted</p>`;
                        }
                        else if(booking.status == 2)
                        {
                            ride_status = `<p class="infomation_update done bg-info">Started</p>`;
                        }
                        else if(booking.status == 4)
                        {
                            ride_status = `<p class="infomation_update done bg-info">Driver Reached</p>`;
                        }
                        else if(booking.status == 3)
                        {
                            ride_status = `<p class="infomation_update done">Completed</p>`;
                        }
                        else if(booking.status == -3)
                        {
                            ride_status = `<p class="infomation_update done bg-danger">Cancelled by you</p>`;
                        }
                        else if(booking.status == 0)
                        {
                            ride_status = `<p class="infomation_update done bg-warning">Pending</p>`;
                        }
                        else if(Date.parse(booking.ride_time) < Date.parse(Date()))
                        {
                            ride_status = `<p class="infomation_update done bg-warning">Upcoming</p>`;
                        }
                        $('.booking_details_with_status').html("Booking Details "+ride_status);

                        if (booking.dest_lat=="")
                        {
                            // alert('dest null');
                            // console.log(markers);

                            if (directionsDisplay != null) {
                                directionsDisplay.setMap(null);
                                directionsDisplay = null;
                            }
                            for (let i = 0; i < markers.length; i++) {
                                markers[i].setMap(null);
                            }
                            pt = new google.maps.LatLng(booking.pick_lat, booking.pick_lng);
                            map.setCenter(pt);
                            map.setZoom(13);
                            marker = new google.maps.Marker({
                                position: pt,
                                map: map
                            });
                            markers.push(marker);
                        }
                        else
                        {
                            if (directionsDisplay != null) {
                                directionsDisplay.setMap(null);
                                directionsDisplay = null;
                            }
                            // console.log(markers);
                            for (let i = 0; i < markers.length; i++) {
                                markers[i].setMap(null);
                            }
                            MapPoints = [{
                                Latitude: booking.pick_lat,
                                Longitude: booking.pick_lng,
                                AddressLocation: booking.pickup_address
                            }, {
                                Latitude: booking.dest_lat,
                                Longitude: booking.dest_lng,
                                AddressLocation: booking.dest_address
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
                                travelMode: google.maps.TravelMode.DRIVING,
                                optimizeWaypoints: true,
                                provideRouteAlternatives: true,
                                avoidFerries: true
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
                                    shortestRouteIndex = setShortestRoute(result);
                                    directionsDisplay.setRouteIndex(shortestRouteIndex);
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

                        $('.close_modal_action_view').addClass('show');
                        $('#view_booking').css({'margin-right':'0px','transition':'all 400ms linear'});
                    }
                    $(document).on('click','.rideDetails',function(){
                        showRideModal($(this).data('id'),'rideDetails');
                    });
                    function setShortestRoute(response)
                    {
                        shortestRouteArr = [];
                        $.each(response.routes, function( index, route ) {
                            shortestRouteArr.push(Math.ceil(parseFloat(route.legs[0].distance.value/1000)));
                        });
                        return shortestRouteArr.indexOf(Math.min(...shortestRouteArr));
                    }
                    socket.on('ride-update-response', function(response) {
                        if(response && response[0] && response[0].id){
                            if(selected_ride_id == response[0].id)
                            {
                                showRideModal(selected_ride_id,'rideDetails');
                            }
                        }
                    });
            </script>
        @endif
    </body>
</html>
