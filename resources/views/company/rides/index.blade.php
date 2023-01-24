@extends('company.layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('datetime/css/bootstrap-datetimepicker.css') }}">
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
                                    <li class="list-group-item"><a href="#"><img
                                                src="{{ asset('company/assets/imgs/sideBarIcon/clock.png') }}"
                                                class="img-fluid clock_img" alt="Clock Image"> <span
                                                class="point_list position-relative"><input type="checkbox"
                                                    name="selectedPoint"
                                                    class="input_radio_selected">{{ date('D, d.M.Y H:i', strtotime($ride_value->ride_time)) }}</span></a>
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
                        <h2 class="board_title mb-0">Booking Details</h2>
                        <button class="btn save_btn save_booking" type="submit">Save</button>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 col-xs-12">
                            <div class="userBox">
                                <div class="avatarImg_user">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" alt="User Avatar"
                                        class="img-fluid active_user">
                                </div>
                                <select class="form-control" name="user_id">
                                   <option value="">-- Select User --</option>
                                   @foreach($users as $user)
                                   <option value="{{ $user->id }}">{{ $user->full_name }}{{ !empty($user->phone)?" (+".$user->country_code."-".$user->phone.")":""}}</option>
                                   @endforeach
                                </select>
                                {{-- <div class="user_name">
                                    <h4 class="name active_username">Lilly Blossom</h4>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-7 col-sm-12 col-xs-12">
                            <div class="usercounting d-flex mt-2">
                                <img src="{{ asset('company/assets/imgs/sideBarIcon/userCount.png') }}" alt="userCount"
                                    class="img-fluid counting_user me-2">
                                <select class="form-control inside_input_field p-0 px-1 text-center" id="numberOfPassenger"
                                    name="passanger">
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Row For Name and Count User -->
                    <div class="form-group mt-3 position-relative">
                        <img src="{{ asset('company/assets/imgs/sideBarIcon/clock.png') }}"
                            class="img-fluid clock_img setup_ab_clck" alt="Clock Image">
                        <input type="text" class="inside_input_field form-control date_value datetimepicker"
                            name="ride_time" value="{{ date('D d-m-Y H:i') }}">
                        <img src="{{ asset('company/assets/imgs/sideBarIcon/calendar.png') }}"
                            class="img-fluid setup_ab_cln" alt="Clock Image">
                    </div>
                    <!-- Row Name -->
                    <div class="form-group mt-2 position-relative">
                        <input type="text" class="inside_input_field form-control normal_font" name="pickup_address"
                            id="pickupPoint" value="" placeholder="{{ __('From') }}" required>
                        <input type="hidden" id="pickup_latitude" name="pick_lat">
                        <input type="hidden" id="pickup_longitude" name="pick_lng">
                    </div>
                    <!-- Row For Area -->
                    <div class="form-group mt-2 position-relative">
                        <input type="text" class="inside_input_field form-control normal_font" name="dest_address"
                            id="dropoffPoint" value="" placeholder="{{ __('To') }}">
                        <input type="hidden" id="dropoff_latitude" name="dest_lat">
                        <input type="hidden" id="dropoff_longitude" name="dest_lng">
                    </div>

                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 align-self-center">
                            <div class="userBox mt-3">
                                <div class="avatarImg_user">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/bigcar.png') }}" alt="Car"
                                        class="img-fluid car_images">
                                </div>
                                <select class="form-control inside_input_field p-1 text-center" id="carType"
                                    name="car_type">
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
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 ps-lg-0">
                            <div class="usercounting d-flex mt-3 position-relative">
                                <label class="label_input_cash">CHF</label>
                                <input type="text" name="ride_cost"
                                    class="form-control inside_input_field p-1 ps-4 text-center me-2 price_calculated_input"
                                    value="200.0">
                                <input type="hidden" name="distance" class="distance_calculated_input">
                                <input type="hidden" name="payment_type" value="Cash">
                                <div class="payment_option d-flex align-items-center">
                                    <img src="{{ asset('company/assets/imgs/sideBarIcon/cash.png') }}" alt="userCount"
                                        class="img-fluid cash_count me-2"> <span>Cash</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Side Board -->
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 col-xs-12">
                <div class="map_views mb-4 booking_side desktop_view">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d102152.55978232603!2d75.46373732010797!3d31.370071732694594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1673768174190!5m2!1sen!2sin"
                        width="100%" height="433" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="">
                    <div class="row m-0 w-100">
                        <div class="col-lg-6 col-md-12 col-xs-12 mt-4">
                            <div class="form-group">
                                <textarea class="form-control inside_input_field mb-2" placeholder="Note" name="note" rows="7"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12 all_driver_info d-none">
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

                <div class="map_views mb-4 booking_side mobile_view">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d102152.55978232603!2d75.46373732010797!3d31.370071732694594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1673768174190!5m2!1sen!2sin"
                        width="100%" height="433" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
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
    <script>
        var options = {
            strictBounds: true, // Only if you want to restrict, not bias
            // types: ["establishment"], // Whatever types you need
        };
        var pickup_input = document.getElementById('pickupPoint');
        var autocomplete_pickup = new google.maps.places.Autocomplete(pickup_input, options);
        google.maps.event.addListener(autocomplete_pickup, 'place_changed', function() {
            var place = autocomplete_pickup.getPlace();
            // document.getElementById('city2').value = place.name;
            document.getElementById('pickup_latitude').value = place.geometry.location.lat();
            document.getElementById('pickup_longitude').value = place.geometry.location.lng();
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


        $(".datetimepicker").datetimepicker({
            format: 'ddd DD-MM-YYYY HH:mm',
            minDate: "{{ date('Y-m-d') }}",
            sideBySide: true,
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
                var distance_calculated = 0;
            } else {
                srcLocation = new google.maps.LatLng(pickup_latitude, pickup_longitude);
                dstLocation = new google.maps.LatLng(dropoff_latitude, dropoff_longitude);
                var distance = google.maps.geometry.spherical.computeDistanceBetween(srcLocation, dstLocation);
                var distance_calculated = Math.round(distance / 1000);
            }


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
            $(".price_calculated_input").val(price_calculation);
            return true;
        }

        $("#booking_list_form").submit(function(e) {
            e.preventDefault();
            form_validate_res = calculate_route();
            if (form_validate_res) {
                $(document).find(".save_booking").attr('disabled', true);
                $.ajax({
                    url: "{{ route('company.ride_booking') }}",
                    type: 'post',
                    dataType: 'json',
                    data: $('form#booking_list_form').serialize(),
                    success: function(response) {
                        if (response.status) {
                            swal("{{ __('Success') }}", response.message, "success");
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        } else if (response.status == 0) {
                            swal("{{ __('Error') }}", response.message, "error");
                            $(document).find(".save_booking").removeAttr('disabled');
                        }
                    },
                    error(response) {
                        swal("{{ __('Error') }}", response.message, "error");
                        $(document).find(".save_booking").removeAttr('disabled');
                    }
                });
            }
        });
    </script>
@stop
