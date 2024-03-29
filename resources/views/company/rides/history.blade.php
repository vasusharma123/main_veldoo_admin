@extends('company.layouts.app')
@section('content')
<style>
    #googleMap {
        background: #dfdfdf;
        max-height: 100%;
        border-radius: 10px;
        height: 100%;
        min-height: 400px;
    }
</style>
    <form action="" method="post" class="add_details_form done">
        <div class="row">
            <div class="col-12">
                <h2 class="board_title">History</h2>
            </div>
            <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12 col-xs-12">
                <div class="search_list">
                <!-- Add Search here -->
                    <div class="list_search_output mt-0">
                        <ul class="list-group list-group-flush">
                            @foreach ($rides as $key=>$ride)
                                <li class="list-group-item rideDetails rideDetails_{{ $ride->id }}" data-key="{{ $key }}" data-id="{{ $ride->id }}">
                                    <a href="#">
                                        <img src="{{ asset('company/assets/imgs/sideBarIcon/clock.png') }}" class="img-fluid clock_img" alt="Clock Image">
                                        <span class="point_list position-relative">
                                            <input type="checkbox" name="selectedPoint" style="cursor: pointer" class="input_radio_selected">{{ date('D, d.m.Y',strtotime($ride->ride_time)) }}
                                        </span> {{ date('H:i',strtotime($ride->ride_time)) }}
                                    </a>
                                    {{-- <span class="action_button"> <i class="bi bi-trash3 dlt_list_btn"></i></span> --}}
                                </li>
                            @endforeach
                            @if (empty($rides[0]))
                                <li class="list-group-item">
                                    No rides found...
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- List Search End -->
                </div>
                <!-- Search List -->
                <div class="details_box" style="display: none">
                    <div class="boxHeader mb-3">
                        <h2 class="board_title mb-0">Booking Details</h2>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                            <div class="name active_username createdBy">
                                <div>Created By: Kapil</div>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-7 col-sm-8 col-12">
                            <div class="userBox">
                                <div class="avatarImg_user">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" alt="User Avatar" class="img-fluid active_user ride_user_image">
                                </div>
                                <div class="user_name">
                                    <div class="name active_username ride_user_name">Lilly Blossom</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-7 col-sm-4 col-5">
                            <div class="usercounting d-flex mt-2">
                                <img src="{{ asset('company/assets/imgs/sideBarIcon/userCount.png')}}" alt="userCount" class="img-fluid counting_user me-2">
                                <p class="ride_user_member form-control inside_input_field p-0 px-1" style="margin-bottom:0px;text-align:left">1-3</p>
                            </div>
                        </div>
                    </div>
                    <!-- Row For Name and Count User -->
                    <div class="form-group mt-3 position-relative">
                        <img src="{{ asset('company/assets/imgs/sideBarIcon/clock.png')}}" class="img-fluid clock_img setup_ab_clck" alt="Clock Image">
                        <input type="text" class="inside_input_field form-control date_value ride_user_date" value="10.01.2023  19:45">
                        {{-- <img src="assets/imgs/sideBarIcon/calendar.png" class="img-fluid setup_ab_cln" alt="Clock Image"> --}}
                    </div>
                    <!-- Row Name -->
                    <div class="form-group mt-2 position-relative ">
                        <ul class="list-group list-group-flush drive_info_list">
                            <li class="list-group-item running ride_user_start_location" >Schaffhausen</li>
                            <li class="list-group-item stop_process ride_user_end_location" >Zurich</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-6 col-6 align-self-center">
                            <div class="userBox mt-3">
                                <div class="avatarImg_user">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/bigcar.png')}}" alt="Car" class="img-fluid car_images">
                                </div>
                                <select class="form-control inside_input_field p-1 ride_car_type">
                                    <option value="Business">Business</option>
                                    <option value="Small">Small</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-6 col-6 ps-lg-0">
                            <div class="usercounting d-flex mt-3 position-relative">
                                <label class="label_input_cash ">CHF</label>
                                <input type="text" class="form-control inside_input_field p-1 ps-4 me-2 ride_car_price" style="padding-left: 30px !important" value="200.0">

                                <div class="payment_option d-flex align-items-center">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/cash.png')}}" alt="userCount" class="img-fluid cash_count me-2 "> <span class="ride_payment_type fw-normal name active_username">Cash</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Side Board -->
            <div class="col-xl-7 col-lg-6 col-md-5 col-sm-12 col-xs-12">
                <div class="map_views mb-4 booking_side desktop_view">
                    <div id="googleMap" class="googleMapDesktop"></div>
                </div>
                <div class="all_driver_info" style="display: none">
                    <div class="row m-0 w-100">
                        <div class="col-lg-6 col-md-12 col-xs-12">
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12">
                            <h2 class="board_title booking">Driver Details</h2>
                        </div>
                    </div>
                    <div class="row m-0 w-100">
                        <div class="col-lg-6 col-md-12 col-xs-12">

                            <div class="form-group">
                                <textarea class="form-control inside_input_field mb-2 ride_notes" required rows="2">Note</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12">
                            <div class="ride_status"></div>
                            <div class="userBox mt-3 ride_driver_details">
                                <div class="avatarImg_diver position-relative">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png')}}" alt="Driver" class="img-fluid DriverImage rounded-circle ride_driver_image">
                                    <span class="driver_status "></span>
                                </div>
                                <div class="user_name">
                                    <h4 class="name active_driverImage ride_driver_name">Karl</h4>
                                    <p class="number ride_driver_phone">+41 79 1111 111</p>
                                </div>
                            </div>
                            <div class="userBox mt-3 ride_car_details">
                                <div class="avatarImg_diver">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/car_small.png')}}" alt="car" class="img-fluid DriverImage ride_car_image">
                                </div>
                                <div class="user_name">
                                    <h4 class="name active_driverImage ride_car_name ">Mercedes V class</h4>
                                    <p class="number ride_car_number ">SH 50288</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Map Side-->
        </div>
    </form>
@endsection
@section('footer_scripts')
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
        if ($(window).width() < 767)
        {
            $('.googleMapDesktop').remove();
        }
        else
        {
            $('.googleMapMobile').remove();
        }
        bookingsArray = JSON.parse(`<?php echo ($rides) ?>`);

        map = new google.maps.Map(document.getElementById('googleMap'), {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            center: { lat: 46.8182, lng: 8.2275 },//Setting Initial Position
            zoom: 8
        });

        $(document).on('click','.rideDetails',async function(){
            // booking = bookingsArray[$(this).data('key')];
            selected_ride_id = $(this).data('id');
            // console.log(selected_ride_id);
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
            // console.log(booking);


            $('.rideDetails').removeClass('selected');
            $(this).addClass('selected');
            $('.ride_user_image').hide();
            if (booking.user)
            {
                $('.ride_user_image').show();
                if(booking.user.image_with_url){
                    $('.ride_user_image').attr('src',booking.user.image_with_url);
                } else {
                    $('.ride_user_image').attr('src',"{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}");
                }
            }
            $('.ride_user_name').html('');
            if (booking.user && booking.user.first_name)
            {
                $('.ride_user_name').html(booking.user.first_name+' '+booking.user.last_name);
            }
            $('.ride_user_start_location').html(booking.pickup_address);
            $('.ride_user_end_location').hide();
            if(booking.dest_address && booking.dest_address!=null)
            {
                $('.ride_user_end_location').show();
                $('.ride_user_end_location').html(booking.dest_address);
            }
            $('.ride_user_member').html(booking.passanger);
            $('.ride_car_type').html('<option></option>');
            if(booking.car_type)
            {
                $('.ride_car_type').html('<option>'+booking.car_type+'</option>');
            }
            ride_cost = booking.ride_cost;
            if(booking.ride_cost==null)
            {
                ride_cost = "";
            }
            if(booking.ride_cost=="")
            {
                ride_cost = "";
            }
            $('.ride_notes').hide();
            if(booking.note!=null)
            {
                $('.ride_notes').show();
                $('.ride_notes').html(booking.note);
            }
            $('.ride_driver_details').hide();
            if (booking.driver!=null)
            {
                if (booking.driver.image_with_url)
                {
                    $('.ride_driver_image').attr('src',booking.driver.image_with_url);
                } else {
                    $('.ride_driver_image').attr('src',"{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}");
                }
                $('.ride_driver_name').html(booking.driver.first_name+' '+booking.driver.last_name);
                $('.ride_driver_phone').html(`+${booking.driver.country_code} ${booking.driver.phone}`);
                $('.ride_driver_details').show();
            }

            $('.ride_car_image').hide();
            $('.ride_car_details').hide();
            if (booking.vehicle!=null)
            {
                if (booking.vehicle.image_with_url)
                {
                    $('.ride_car_image').attr('src',booking.vehicle.image_with_url);
                    $('.ride_car_image').show();
                }
                $('.ride_car_number').html(booking.vehicle.vehicle_number_plate);
                $('.ride_car_name').html(booking.vehicle.model);
                $('.ride_car_details').show();
            }

            $('.ride_payment_type').html(booking.payment_type);
            $('.ride_car_price').val(ride_cost);
            $('.ride_user_date').val(booking.ride_time_modified);

            // map

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
            // end map
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

            $('.createdBy').hide();
            if(booking.creator)
            {
                creator_type = "";
                if (booking.creator.user_type=="4") {
                    creator_type = " (Admin)";
                }
                else if(booking.creator.user_type=="5")
                {
                    creator_type = " (Manager)";
                }
                $('.createdBy').html("<div>Created By: "+booking.creator.name+creator_type+"</div>");
                $('.createdBy').show();
            }

            $('.ride_status').html(ride_status);
            $('.all_driver_info').show();
            $('.details_box').show();
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
                if(selected_ride_id == response[0].id){
                    // driver_detail_update(selected_ride_id);
                    $('.rideDetails_'+selected_ride_id).click();
                }
            }
        });
        // console.log(bookingsArray);
        // driver_detail_update(2386);
        // function driver_detail_update(id)
        // {
        //     route = "{{ route('company.ride_detail','~') }}";
        //     route = route.replace('~',id);
        //     $.ajax({
        //         url: route,
        //         type: 'POST',
        //         data: {
        //            _token: "{{ csrf_token() }}"
        //         },
        //         success: function(response) {
        //             for (let i = 0; i < bookingsArray.length; i++) {
        //                 if (bookingsArray[i].id=id)
        //                 {
        //                     bookingsArray[i] = response.data;
        //                 }
        //             }
        //         },
        //         error(response) {
        //             swal.fire("{{ __('Error') }}", response.message, "error");
        //         }
        //     });

        //     $('.rideDetails_'+id).click();
        // }
    </script>
@endsection
