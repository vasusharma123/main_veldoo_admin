<script type="text/javascript"
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=geometry,places&callback=Function.prototype">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<script>
    var socket = io("{{ env('SOCKET_URL') }}");
    var map;
    var MapPoints = [];
    var booking = [];
    var directionsDisplay;
    var directionsService = new google.maps.DirectionsService();
    var markers = [];
    var selected_ride_id = "";
    var booking = [];
    // map = new google.maps.Map(document.getElementById('googleMap'), {
    //     mapTypeId: google.maps.MapTypeId.ROADMAP,
    //     scrollwheel: false,
    //     center: {
    //         lat: 46.8182,
    //         lng: 8.2275
    //     }, //Setting Initial Position
    //     zoom: 8
    // });
    newBookingMap = new google.maps.Map(document.getElementById('googleMapNewBooking'), {
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        center: {
            lat: 46.8182,
            lng: 8.2275
        }, //Setting Initial Position
        zoom: 8
    });

    function showPosition(position) {
        if (position != false) {
            var lat = cur_lat = position.coords.latitude;
            var lng = cur_lng = position.coords.longitude;
            pt = new google.maps.LatLng(lat, lng);
            newBookingMap.setCenter(pt);
            newBookingMap.setZoom(8);
            $('#pickup_latitude').val(lat);
            $('#pickup_longitude').val(lng);
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                'latLng': pt
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#pickupPoint').val(results[0][
                        'formatted_address'
                    ]); //alert(results[0]['formatted_address']);
                    new google.maps.Marker({
                        position: pt,
                        newBookingMap,
                        title: results[0]['formatted_address'],
                    });
                };
            });

            var center = {
                lat: cur_lat,
                lng: cur_lng
            };
            var defaultBounds = {
                north: center.lat + 0.1,
                south: center.lat - 0.1,
                east: center.lng + 0.1,
                west: center.lng - 0.1,
            };
            var options = {
                bounds: defaultBounds,
                // fields: ["address_components"], // Or whatever fields you need
                //strictBounds: true, // Only if you want to restrict, not bias
                // types: ["establishment"], // Whatever types you need
                //  radius: 5000
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
        }

        newBookingMapPoints = [{
            Latitude: pickup_latitude,
            Longitude: pickup_longitude,
            AddressLocation: pickup_address
        }, {
            Latitude: dropoff_latitude,
            Longitude: dropoff_longitude,
            AddressLocation: dropoff_address
        }];
        initializeMapReport(newBookingMapPoints);
        return true;
    }

    var newBookingDirectionsDisplay;
    var newBookingDirectionsService = new google.maps.DirectionsService();
    var newBookingInfowindow;

    function initializeMapReport(newBookingMapPoints) {
        // console.log(newBookingMapPoints);
        if (jQuery('#googleMapNewBooking').length > 0) {
            var locations = newBookingMapPoints;
            newBookingDirectionsService = new google.maps.DirectionsService;
            newBookingDirectionsDisplay = new google.maps.DirectionsRenderer;
            newBookingMap = new google.maps.Map(document.getElementById('googleMapNewBooking'), {
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                scrollwheel: false,
                center: {
                    lat: 46.8182,
                    lng: 8.2275
                }, //Setting Initial Position
                zoom: 8
            });

            var newBookingInfowindow = new google.maps.InfoWindow();
            var bounds = new google.maps.LatLngBounds();
            newBookingDirectionsDisplay = new google.maps.DirectionsRenderer({
                map: window.newBookingMap,
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
                    map: newBookingMap
                });
                bounds.extend(marker.position);

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        newBookingInfowindow.setContent(locations[i]['AddressLocation']);
                        newBookingInfowindow.open(newBookingMap, marker);
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
                newBookingMarkers.push(marker);
            }
            // call directions service
            if (locations.length) {
                // console.log(request);
                newBookingDirectionsService.route(request, function(result, status) {
                    if (status == google.maps.DirectionsStatus.OK) {

                        newBookingDirectionsDisplay.setDirections(result);
                        shortestRouteIndex = setShortestRoute(result);
                        newBookingDirectionsDisplay.setRouteIndex(shortestRouteIndex);
                        distance = result.routes[shortestRouteIndex].legs[0].distance.value / 1000;
                        distance = Math.ceil(distance);
                        $('#distance_calculated_input').val(distance);
                        var ride_route = result.routes[shortestRouteIndex].overview_polyline;
                        $('#ride_route').val(ride_route);
                        calculate_amount();
                    }
                });
                newBookingMap.fitBounds(bounds);
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
                    newBookingMap.setZoom(12);
                }, 500);
            }

        }
    }

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, mapError);
        } else {
            swal.fire("{{ __('Error') }}", "{{ __('Geolocation is not supported by this browser.') }}", "error");
        }
    }

    function mapError(err) {
        console.log(err);
        if (err.code == 1) {
            if (err.message == "User denied Geolocation") {
                swal.fire("{{ __('Error') }}", "{{ __('Please enable location permission in your browser') }}",
                    "error");
            }
        }
        showPosition(false);
    }

    function autocomplete_initialize() {
        getLocation();
        initializeMapReport(newBookingMapPoints);
    }

    google.maps.event.addDomListener(window, 'load', autocomplete_initialize);


    $('#pickUpDateRide').datepicker({
        multidate: true,
        format: "yyyy-mm-dd",
        startDate: "today"

    });

    $(document).on("click", ".save_booking", function(e) {
                // $(document).on("submit", "#booking_list_form", function(e) {
                    e.preventDefault();
                    if ($('#pickup_latitude').val()=="")
                    {
                        swal.fire("{{ __('Error') }}", "Pickup Point is required", "error");
                        return false;
                    }
                    if ($('input[name="ride_date"]').val()=="")
                    {
                        swal.fire("{{ __('Error') }}", "Please select pick up", "error");
                        return false;
                    }
                    if ($('input[name="ride_time"]').val()=="")
                    {
                        swal.fire("{{ __('Error') }}", "Please select pick time", "error");
                        return false;
                    }
                    // if ($('#users').val()=="")
                    // {
                    //     swal.fire("{{ __('Error') }}", "Please select a Passenger", "error");
                    //     return false;
                    // }
                    // alert($('#users').val());
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

                                            
                                            socket.emit('master-driver-update-web', {"data":response.data});

                                            swal.fire("{{ __('Success') }}", response.message,"success");
                                            // setTimeout(function() {
                                            //     window.location.reload();
                                            // }, 1000);

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
</script>
