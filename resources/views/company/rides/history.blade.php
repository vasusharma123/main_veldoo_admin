@extends('company.layouts.app')
@section('content')
    <form action="" method="post" class="add_details_form done">
        <div class="row">
            <div class="col-12">
                <h2 class="board_title">History</h2>
            </div>
            <div class="col-xl-5 col-lg-6 col-md-7 col-sm-12 col-xs-12">
                <div class="search_list">
                <!-- Add Search here -->
                    <div class="list_search_output mt-0" style="height: 311px">
                        <ul class="list-group list-group-flush">
                            @foreach ($rides as $key=>$ride)
                                <li class="list-group-item rideDetails" data-key="{{ $key }}">
                                    <a href="#">
                                        <img src="assets/imgs/sideBarIcon/clock.png" class="img-fluid clock_img" alt="Clock Image">
                                        <span class="point_list position-relative">
                                            <input type="checkbox" name="selectedPoint" style="cursor: pointer" class="input_radio_selected">{{ $ride->user?$ride->user->full_name:'N/A' }}, {{ date('d.m.Y',strtotime($ride->created_at)) }}
                                        </span> {{ date('H:i',strtotime($ride->created_at)) }}
                                    </a> 
                                    {{-- <span class="action_button"> <i class="bi bi-trash3 dlt_list_btn"></i></span> --}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- List Search End -->
                </div>
                <!-- Search List -->
                <div class="details_box" style="display: none">
                    <div class="boxHeader">
                        <h2 class="board_title mb-0">Booking Details</h2>
                    </div>
                    <div class="row">
                        <div class="col-xl-8 col-lg-8 col-md-7 col-sm-8 col-12">
                            <div class="userBox">
                                <div class="avatarImg_user">
                                    <img src="assets/imgs/sideBarIcon/lilly.png" alt="User Avatar" class="img-fluid active_user ride_user_image">
                                </div>
                                <div class="user_name">
                                    <h4 class="name active_username ride_user_name">Lilly Blossom</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-7 col-sm-4 col-5">
                            <div class="usercounting d-flex mt-2">
                                <img src="assets/imgs/sideBarIcon/userCount.png" alt="userCount" class="img-fluid counting_user me-2">
                                <p class="ride_user_member form-control inside_input_field p-0 px-1" style="margin-bottom:0px;text-align:left">1-3</p>
                            </div>
                        </div>
                    </div>
                    <!-- Row For Name and Count User -->
                    <div class="form-group mt-3 position-relative">
                        <img src="assets/imgs/sideBarIcon/clock.png" class="img-fluid clock_img setup_ab_clck" alt="Clock Image">
                        <input type="text" class="inside_input_field form-control date_value ride_user_date" value="10.01.2023  19:45">
                        {{-- <img src="assets/imgs/sideBarIcon/calendar.png" class="img-fluid setup_ab_cln" alt="Clock Image"> --}}
                    </div>
                    <!-- Row Name -->
                    <div class="form-group mt-2 position-relative ">
                        <ul class="list-group list-group-flush drive_info_list">
                            <li class="list-group-item running ride_user_start_location">Schaffhausen</li>
                            <li class="list-group-item stop_process ride_user_end_location">Zurich</li>
                        </ul>
                    </div>
                    
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-6 col-6 align-self-center">
                            <div class="userBox mt-3">
                                <div class="avatarImg_user">
                                    <img src="assets/imgs/sideBarIcon/bigcar.png" alt="Car" class="img-fluid car_images">
                                </div>
                                <select class="form-control inside_input_field p-1 ride_car_type">
                                    <option value="Business">Business</option>
                                    <option value="Small">Small</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-6 col-6 ps-lg-0">
                            <div class="usercounting d-flex mt-3 position-relative">
                                <label class="label_input_cash">CHF</label>
                                <input type="text" class="form-control inside_input_field p-1 ps-4 me-2 ride_car_price" style="padding-left: 30px !important" value="200.0">
                                
                                <div class="payment_option d-flex align-items-center">
                                    <img src="assets/imgs/sideBarIcon/cash.png" alt="userCount" class="img-fluid cash_count me-2"> <span class="ride_payment_type">Cash</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Left Side Board -->
            <div class="col-xl-7 col-lg-6 col-md-5 col-sm-12 col-xs-12">
                <div class="map_views mb-4 booking_side desktop_view">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d102152.55978232603!2d75.46373732010797!3d31.370071732694594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1673768174190!5m2!1sen!2sin" width="100%" height="433" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                                <textarea class="form-control inside_input_field mb-2 ride_notes" required  rows="2">Note</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-xs-12">
                            <p class="infomation_update done">Booking</p>
                            <div class="userBox mt-3 ride_driver_details">
                                <div class="avatarImg_diver position-relative">
                                    <img src="assets/imgs/sideBarIcon/driver.png" alt="Driver" class="img-fluid DriverImage rounded-circle ride_driver_image">
                                    <span class="driver_status"></span>
                                </div>
                                <div class="user_name">
                                    <h4 class="name active_driverImage ride_driver_name">Karl</h4>
                                    <p class="number ride_driver_phone">+41 79 1111 111</p>
                                </div>
                            </div>
                            <div class="userBox mt-3 ride_car_details">
                                <div class="avatarImg_diver">
                                    <img src="assets/imgs/sideBarIcon/car_small.png" alt="car" class="img-fluid DriverImage ride_car_image">
                                </div>
                                <div class="user_name">
                                    <h4 class="name active_driverImage ride_car_name">Mercedes V class</h4>
                                    <p class="number ride_car_number">SH 50288</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="map_views mb-4 booking_side mobile_view">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d102152.55978232603!2d75.46373732010797!3d31.370071732694594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1673768174190!5m2!1sen!2sin" width="100%" height="433" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <!-- Right Map Side-->
        </div>
    </form>
@endsection
@section('footer_scripts')
    <script>
        bookingsArray = JSON.parse('<?php echo ($rides) ?>');
        $(document).on('click','.rideDetails',function(){
            booking = bookingsArray[$(this).data('key')];
            $('.rideDetails').removeClass('selected');
            $(this).addClass('selected');
            console.log(bookingsArray);
            $('.ride_user_image').hide();
            if (booking.user && booking.user.image_with_url) 
            {
                $('.ride_user_image').show();
                $('.ride_user_image').attr('src',booking.user.image_with_url);
            }
            $('.ride_user_name').html('N/A');
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
            $('.ride_car_type').html('<option>N/A</option>');
            if(booking.car_type)
            {
                $('.ride_car_type').html('<option>'+booking.car_type+'</option>');
            }
            ride_cost = booking.ride_cost;
            if(booking.ride_cost==null)
            {
                ride_cost = "N/A";
            }
            if(booking.ride_cost=="")
            {
                ride_cost = "N/A";
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
                $('.ride_driver_image').hide();
                if (booking.driver.image_with_url) 
                {
                    $('.ride_driver_image').show();
                    $('.ride_driver_image').attr('src',booking.driver.image_with_url);
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
            $('.ride_user_date').val(booking.created_at);
            $('.all_driver_info').show();
            $('.details_box').show();
        });
    </script>
@endsection