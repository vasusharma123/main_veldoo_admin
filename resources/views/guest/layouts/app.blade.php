
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

        <link href="{{ asset('/assets/plugins/select2/dist/css/select2.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/clockpicker/dist/jquery-clockpicker.min.css">
        <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
        <!-- <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"> -->

        
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


        
    </head>
    <body>
    <?php $logoImage =  Auth::check() && !empty($companyInfo->background_image) ? config('app.url_public').'/'.$companyInfo->background_image :  '/images/bg_body.png' ?>

        <style>

          
            :root {
                --primary-color: #FC4C02 !important;
            }
            .pending-ride-class-row{
                background-color: var(--primary-color) !important;
            }
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
                max-height: 250px;
                border-radius: 10px;
                height: 100%;
                min-height: 250px;
            }
            #googleMapNewBooking {
                background: #dfdfdf;
                max-height: 250px;
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
                width:80px;
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
            .parsley-errors-list
            {
                color: red;
                padding: 0px;
                list-style: none;
            }
            .clockpicker-popover
            {
                position: absolute !important;
                top: 60% !important;
                /* left: 50% !important; */
                transform: translate(-50%, -50%) !important;
            }
            .clockpicker-popover > .arrow
            {
                display: none !important;
            }

            body{
                background-image: url(<?php echo $logoImage ?>);
                background-size: cover;
                background-position: center;
                width: 100%;
                min-height: 100vh;
                height: auto;
            }


            

        </style>
        @include('guest.elements.header')
        <div class="main_content">
            <div class="dashbaord_bodycontent">
                @yield('content')
            </div>
        </div>


        @if (\Request::route()->getName()=='guest.login' || \Request::route()->getName()=='guest.rides' || \Request::route()->getName()=='booking_taxisteinemann' )
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
                                        <div class="location_box" style="width: 100%">
                                            <label class="form_label">Pickup Point</label>
                                            <p class="pickup_field mb-0 ride_user_start_location"></p>
                                        </div>
                                    </div>
                                    <div class=" area_box dropUp_area ride_user_end_location_box">
                                        <img src="{{ asset('new-design-company/assets/images/drop_point.png') }}" class="img-fluid pickup_icon" alt="Drop up icon"/>
                                        <div class="location_box" style="width: 100%">
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
                                            <label class="form_label">Pickup Date</label>
                                            <label class="pickupdate ride_new_date view_value_form">08/02/2023</label>
                                        </div>

                                    </div>
                                    <div class="divider_form_area vrt view_port">
                                        <span class="divider_area vrt"></span>
                                    </div>
                                    <div class=" area_box dropUp_area timer_picker">
                                        <img src="{{ asset('new-design-company/assets/images/clock.svg') }}" class="img-fluid svg pickup_icon" alt="Drop up icon"/>
                                        <div class="location_box">
                                            <label class="form_label">Pickup Time</label>
                                            <label class="pickTimes ride_new_time view_value_form">06:00 PM</label>
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
                                                    <span class="user_name ride_driver_details_div_driver_name"></span>
                                                    <a href="javsscript:;" class="user_position side_mob_link ride_driver_details_div_driver_phone"></a>
                                                </div>
                                            </div>
                                            <p class="ride_driver_details_div_driver_na" style="display: none;">N/A</p>
                                        </div>
                                    </div>
                                    <div class="divider_form_area vrt view_port">
                                        <span class="divider_area vrt "></span>
                                    </div>
                                    <div class=" area_box dropUp_area timer_picker">
                                        <div class="location_box">
                                            <label class="form_label">Car Type</label>
                                            <div class="viewuser_sidebar d-flex align-items-center ride_car_div">
                                                <img src="{{ asset('new-design-company/assets/images/business.png') }}" alt="Selected Car" class="img-fluid car_selectImg ride_car_div_image"/>
                                                <div class="name_occupation d-flex flex-column">
                                                    <span class="user_name ride_car_div_type"></span>
                                                    <span class="user_name ride_car_div_number"></span>
                                                </div>
                                            </div>
                                            <p class="ride_car_div_na" style="display:none">N/A</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="passengers_box_details">
                                <div class="passenger_box_content row">
                                    <div class="col-lg-5 col-md-5 col-sm-6 col-12 ps-0">
                                        <div class="number_psnger d-flex">
                                            <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                                            <div class="location_box">
                                                <label class="form_label" style="margin-bottom:0px">No. Of Passengers</label>
                                                <label class="text-dark no_of_passengers view_value_form"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-6 col-12 pe-0" style="padding-left: 0px;">
                                        <div class="name_psnger d-flex">
                                            <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                                            <div class="location_box">
                                                <label class="form_label" style="margin-bottom:0px">Name of Passenger</label>
                                                <label class="text-dark passenger_details view_value_form"></label>
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
                                            <label class="text-dark">
                                                {{-- <img src="{{ asset('new-design-company/assets/images/card.svg') }}" class="img-fluid card_img me-2" alt="payment Image"> --}}
                                                <span class="ride_payment_type view_value_form">Cash</span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-6 col-6 pe-0 amount_box">
                                        <div class="form_box">
                                            <label class="form_label down_form_label d-block">Amount</label>
                                            <label class="text-dark view_value_form"><span class="ride_car_price"></span></label>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                                        <div class="form_box add_note">
                                            <label class="form_label down_form_label d-block">Note</label>
                                            <label class="text-dark ride_note_div view_value_form"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </article>
                </section>
            <!-- /Section View Booking -->
            <!-- Section Add New Booking -->
                <section class="add_booking_modal" id="add_new_bookings">
                    <article class="booking_container_box">
                        <a href="#" class="back_btn_box mobile_view close_modal_action">
                            <img src="{{ asset('new-design-company/assets/images/back_icon.svg') }}" class="img-fluid back_btn" alt="Back arrow" />
                            <span class="btn_text ">Back</span>
                        </a>
                        <div class="header_top">
                            <h4 class="sub_heading bookRideTitle">Book a Ride</h4>
                            <span class="close_modal desktop_view close_modal_action">&times;</span>
                        </div>
                        <form method="post" class="add_details_form" id="booking_list_form">
                            @csrf
                            <div class="save_btn_box desktop_view">
                                <button class="btn save_btn btn save_form_btn bookRideSBtn save_booking" type="button">{{ __('Book')}}</button>
                                <button class="btn save_btn edit_booking save_form_btn" type="button" style="display:none">{{ __('Update')}}</button>
                                <!-- <button class="btn save_btn cancel_ride" type="button" style="display:none;background: #fc4c02;color: white;">{{ __('Cancel')}}</button> -->
                            </div>
                            <div class="pickup_Drop_box">
                                <div class="area_details">
                                    <div class=" area_box pickUp_area">
                                        <img src="{{ asset('new-design-company/assets/images/pickuppoint.png') }}" class="img-fluid pickup_icon" alt="pick up icon"/>
                                        <div class="location_box" style="width: 100%">
                                            <label class="form_label">Pickup Point</label>
                                            <input type="text" class="form_control borderless_form_field pickup_field" name="pickup_address" id="pickupPoint" placeholder="Enter pickup point" required autocomplete="off">
                                            <input type="hidden" id="pickup_latitude" name="pick_lat" value="">
                                            <input type="hidden" id="pickup_longitude" name="pick_lng" value="">
                                            <input type="hidden" name="ride_id" id="ride_id">
                                            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->check() ? auth()->user()->id : '' }}">
                                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="{{ env('RECAPTCHA_KEY') }}">

                                        </div>
                                        <span class="empty_field pickupPointCloseBtn">&times;</span>
                                    </div>
                                    <div class="divider_form_area">
                                        <span class="divider_area"></span>
                                        <img src="{{ asset('new-design-company/assets/images/switch_area.svg') }}" alt="switch btn" class="img-fluid svg switch_area swapLocations"/>
                                    </div>
                                    <div class=" area_box dropUp_area">
                                        <img src="{{ asset('new-design-company/assets/images/drop_point.png') }}" class="img-fluid pickup_icon" alt="Drop up icon"/>
                                        <div class="location_box" style="width: 100%">
                                            <label class="form_label">Drop Point</label>
                                            <input type="text" class="form_control borderless_form_field dropup_field" name="dest_address" id="dropoffPoint" autocomplete="off" placeholder="Enter drop point">
                                            <input type="hidden" id="dropoff_latitude" name="dest_lat" value="">
                                            <input type="hidden" id="dropoff_longitude" name="dest_lng" value="">
                                        </div>
                                        <span class="empty_field dropoffPointCloseBtn">&times;</span>
                                    </div>
                                </div>
                            </div>
                            <div class="date_picker_box">
                                <div class="date_area_box d-flex">
                                    <div class=" area_box pickUp_area">
                                        <img src="{{ asset('new-design-company/assets/images/calendar-days.svg') }}" class="img-fluid svg pickup_icon" alt="pick up icon"/>
                                        <div class="location_box">
                                            <label class="form_label">Pickup Date</label>
                                            <input type="text" value="<?php echo date("Y-m-d") ?>"  id="pickUpDateRide" class="form_control form_control borderless_form_field dropup_field pick-up-date-ride" style="border: 1px solid;border-radius: 5px;padding: 1px;padding-left: 10px;" name="ride_date">
                                            <input type="text" value="<?php echo date("Y-m-d") ?>"  id="pickUpDateRideEdit" class="form_control form_control borderless_form_field dropup_field pick-up-date-ride-edit" style="border: 1px solid;border-radius: 5px;padding: 1px;padding-left: 10px;" name="ride_date">

                                            <!-- <input type="date" class="form_control form_control borderless_form_field dropup_field" style="border: 1px solid;border-radius: 5px;padding: 1px;padding-left: 10px;" name="ride_date"> -->

                                            
                                        </div>
                                    </div>
                                    <div class="divider_form_area vrt">
                                        <span class="divider_area vrt"></span>
                                    </div>
                                    <div class=" area_box dropUp_area timer_picker">
                                        <img src="{{ asset('new-design-company/assets/images/clock.svg') }}" class="img-fluid svg pickup_icon" alt="Drop up icon"/>
                                        <div class="location_box">
                                            <label class="form_label">Pickup Time</label>
                                            
                                            <!-- <input type="time" class="form_control borderless_form_field dropup_field without_ampm" placeholder="Please select time" style="border: 1px solid;border-radius: 5px;padding: 1px;padding-left: 10px;"  required name="ride_time"> -->
                                            

                                            <input type="text" id="time" value="<?php echo date("H:i") ?>" class="form_control form-control borderless_form_field dropup_field" placeholder="Please select time" style="border: 1px solid;border-radius: 5px;padding: 1px;padding-left: 10px;"  required name="ride_time">

                                        </div>
                                    </div>
                                </div>
                             </div>
                            <div class="cars_selection">
                                <div class="swiper carSwiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($vehicle_types as $key=>$vehicle_type)
                                        
                                            <div class="swiper-slide">
                                                <div class="car_option position-relative">
                                                    <input type="radio" class="car_checked" value="{{ $vehicle_type->id }}"  data-basic_fee="{{ $vehicle_type->basic_fee }}" data-price_per_km="{{ $vehicle_type->price_per_km }}" data-seating_capacity="{{ $vehicle_type->seating_capacity }}" data-text="{{ $vehicle_type->car_type }}" name="car_type" {{ $key==0?'checked':'' }} required />
                                                    <img src="{{ $vehicle_type->image_with_url }}" class="img-fluid car_img" alt="Small" />
                                                    <label class="car_lable">{{ $vehicle_type->car_type }}</label>
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="passengers_box_details">
                                <div class="passenger_box_content row">
                                    <div class="col-lg-5 col-md-5 col-sm-6 col-12 ps-0">
                                        <div class="number_psnger d-flex">
                                            <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                                            <div class="location_box">
                                                <label class="form_label">No. Of Passengers</label>
                                                <input type="number" min="1" class="form_control borderless_form_field psnger_no" required id="numberOfPassenger" name="passanger" value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-6 col-6 ps-0">
                                        <div class="name_psnger d-flex">
                                            <img src="{{ asset('new-design-company/assets/images/phones.svg') }}" class="img-fluid svg svgnon pickup_icon man_icons" alt="pick up icon"/>
                                            <div class="location_box">
                                                <label class="form_label">Mobile Number</label>

                                                <div class="col_form_settings mb-2">
                                                    <input type="hidden" value="+1" class="country_code" id="country_code" name="country_code" />
                                                    <input type="text" id="phone" class="form-control main_field" placeholder="Enter Number" name="phone" aria-label="Phone Number">
                                                </div>

                                                <!-- <select name="user_id" class="form_control borderless_form_field psnger_no" id="users">
                                                    <option value="">--Select User--</option>
                                                </select> -->


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form_payment_box">
                                <div class="row w-100 m-0">
                                    <div class="col-lg-5 col-md-5 col-sm-6 col-12 pe-0 amount_box">
                                        <div class="form_box">
                                            <label class="form_label down_form_label ">Amount (CHF)</label>
                                            <div class="form-dollar position-relative">
                                                <input type="text" min="0" class="form-control down_form price_calculated_input" name="ride_cost" value="0" readonly placeholder="CHF"/>
                                                <input type="hidden" name="distance" class="distance_calculated_input" id="distance_calculated_input">
                                                <input type="hidden" name="payment_type" value="Cash" id="payment_type">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                                        <div class="form_box add_note">
                                            <label class="form_label down_form_label ">Add Note</label>
                                            <textarea rows="3" cols="5" name="note" id="note" class="form-control down_form "></textarea>
                                        </div>
                                    </div>
                                    <div class="map_frame" style="margin-top: 50px;padding:0px">
                                        <div id="googleMapNewBooking" class="googleMapDesktop"></div>
                                    </div>
                                    <div class="">
                                        <div class="row w-100 m-0">
                                            <div class="col-lg-12 col-md-12 col-sm-12 pe-0 amount_box">
                                                <label for="checkid">
                                                    <input id="checkid" type="checkbox" name="status" value="3" /> Mark the ride as completed
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="save_btn_box mobile_view">
                                <button type="button" class="btn save_form_btn bottom_btn w-100 save_booking">Book Ride</button>
                            </div>
                        </form>
                    </article>
                </section>
            <!-- /Section Add New Booking -->
        @endif
        <!-- ClockPicker Modal -->
        <div class="modal fade" id="clockModal" tabindex="-1" role="dialog" aria-labelledby="clockModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="clockModalLabel">Select Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <div class="clockpicker">
                    <input type="text" class="form-control" id="timeInputM" placeholder="Select time">
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTime">Save</button>
                </div>
            </div>
            </div>
        </div>

        <!-- <div class="modal fade otp_modal_dialog" id="confirmOTPModal" tabindex="-1" role="dialog" aria-labelledby="otpModal_listTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width: 400px" role="document">
                <div class="modal-content border-0 p-4">
                    <div class="modal-header border-0 pb-0">
                        <img src="{{ asset('images/verify.png')}}" class="modal_header_img img-fluid">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="otp_main_title mb-4">{{ __('Enter your verification code')}}</h4>
                        <p class="sub_desc_otp">{{ __('Fill in the 4-digits verification code which we have shared on your registered phone number.')}}</p>
                        
                        <h6 class="otp_sub_title">{{ __('OTP')}}</h6>
                        <form class="otp_form" id="otp_form">
                            @csrf
                            <div class="row mb-4 digit-group" data-group-name="digits">

                                    <input type="hidden" id="otpPhone" name="phone">
                                    <input type="hidden" id="otpCountryCode" name="country_code">
                                    <input type="hidden" id="otp_pickup_latitude" name="pick_lat" >
                                    <input type="hidden" id="otp_pickup_longitude" name="pick_lng">
                                    <input type="hidden" id="otp_dropoff_latitude" name="dest_lat">
                                    <input type="hidden" id="otp_dropoff_longitude" name="dest_lng">
                                    <input type="hidden" id="otp_pickupPoint" name="pickup_address">
                                    <input type="hidden" id="otp_dropoffPoint" name="dest_address">
                                    <input type="hidden" id="otp_time" name="ride_time">
                                    <input type="hidden" id="otp_pickUpDateRide" name="ride_date">
                                    <input type="hidden" id="otp_distance_calculated_input" name="distance">
                                    <input type="hidden" id="otp_payment_type" name="payment_type">
                                    <input type="hidden" id="otp_numberOfPassenger" name="passanger">
                                    <input type="hidden" id="otp_car_type" name="car_type">
                                    <input type="hidden" id="otp_ride_cost" name="ride_cost">
                                    <input type="hidden" id="otp_note" name="note">
                                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="{{ env('RECAPTCHA_KEY') }}">


                                    <div class="form-group position-relative has_validation text-center otpcode_box">
                                        <label class="form-lable boldlable">OTP code</label>
                                        <div class="field position-relative otp-box d-flex">
                                            <input type="text" name="password" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                            <input type="text" name="password" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                            <input type="text" name="password" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                            <input type="text" name="password" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                            <input type="text" name="password" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                        </div>
                                        <p class="erro d-none mb-0">Invalid OTP code. <a href="#" class="hyperinline">Resend OTP</a> 90 sec.</p>
                                    </div>

                                

                                    <div class="form-group position-relative">
                                        <button type="button" class="btn submit_btn otpsubmit">
                                            <span class="btn_text">Continue</span>
                                        </button>
                                    </div>

                                <div class="col-3">
                                    <input type="number" class="form-control input_otp" id="digit-1" name="digit-1" data-next="digit-2" min="0" max="9" required>
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control input_otp"  id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" min="0" max="9" required>
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control input_otp" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" min="0" max="9" required>
                                </div>
                                <div class="col-3">
                                    <input type="number" class="form-control input_otp" id="digit-4" name="digit-4" data-previous="digit-3" min="0" max="9" required>
                                </div>

                            </div>
                            <button type="submit" class="btn custom_btn verify_otp mt-2">{{ __('Confirm Booking') }}</button>
                        </form>
                    </div>
                    <div class="modal-footer border-0 d-block p-2">
                        <p class="confirmOTPModalTimer">{{ __('Resend OTP in') }} 30</p>
                        <p class="otp_not_rec" style="display: none;">{{__("Didn't receive any code?")}} <a class="btn confirmOTPModalResendOtp" href="javascript:void(0);">{{ __('Resend OTP') }}</a></p>
                    </div>
                </div>
            </div>
        </div> -->


       



        <div class="modal fade otp_modal_dialog" id="confirmOTPModal" tabindex="-1" role="dialog" aria-labelledby="otpModal_listTitle" aria-hidden="true">
           <button type="button" class="btn-close modalClose" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content p-0 border-0 bg-transparent">
                    <div class="modal-body p-0 border-0 bg-transparent">
                        <section class="login_form_section">

                            <article class="login_form_container container-fluid">

                                <div class="row">

                                    <div class="login_form_content col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                                        <div class="login_form_box_cover">

                                        <form class="login_form otp_form" id="otp_form" action="" method="post" autocomplete="off">

                                        @csrf

                                        <input type="hidden" id="otpPhone" name="phone">
                                        <input type="hidden" id="otpCountryCode" name="country_code">
                                        <input type="hidden" id="otp_pickup_latitude" name="pick_lat" >
                                        <input type="hidden" id="otp_pickup_longitude" name="pick_lng">
                                        <input type="hidden" id="otp_dropoff_latitude" name="dest_lat">
                                        <input type="hidden" id="otp_dropoff_longitude" name="dest_lng">
                                        <input type="hidden" id="otp_pickupPoint" name="pickup_address">
                                        <input type="hidden" id="otp_dropoffPoint" name="dest_address">
                                        <input type="hidden" id="otp_time" name="ride_time">
                                        <input type="hidden" id="otp_pickUpDateRide" name="ride_date">
                                        <input type="hidden" id="otp_distance_calculated_input" name="distance">
                                        <input type="hidden" id="otp_payment_type" name="payment_type">
                                        <input type="hidden" id="otp_numberOfPassenger" name="passanger">
                                        <input type="hidden" id="otp_car_type" name="car_type">
                                        <input type="hidden" id="otp_ride_cost" name="ride_cost">
                                        <input type="hidden" id="otp_note" name="note">
                                        <input type="hidden" id="otp_status" name="status">

                                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="{{ env('RECAPTCHA_KEY') }}">

                                            
                                        <div class="form-row">
                                            <div class="col-12 p-0">
                                            <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="Logo" class="img-fluid logo_img"/>
                                                <div class="form_title text-center">
                                                <h4 class="otp_main_title mb-4">{{ __('Enter your verification code')}}</h4>
                                                <p class="sub_desc_otp">{{ __('Fill in the 4-digits verification code which we have shared on your registered phone number.')}}</p>
                                                    <hr class="divider_form" />
                                                </div>
                                                
                                                <!-- /Form Title -->

                                            </div>
                                            <!-- /Col -->

                                            <div class="col-12">
                                                
                                                <!-- <div class="form-group position-relative has_validation">
                                                    <label class="form-lable">Mobile Number</label>
                                                    <div class="field position-relative">
                                                    <input type="tel" id="phone" class="form-control loginField otpnumberenter" placeholder="Enter Number" aria-label="Phone Number" required>
                                                    </div>
                                                    <p class="erro d-none mb-0">Please enter valid mobile number...</p>
                                                </div> -->
                                            
                                                
                                                <div class="form-group position-relative has_validation text-center otpcode_box invalid_field">
                                                    <label class="form-lable boldlable">OTP code</label>
                                                    <div class="field position-relative otp-box d-flex">
                                                        <input type="text" id="digit-1" maxlength="1" name="digit-1" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                                        <input type="text" id="digit-2" maxlength="1" name="digit-2" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                                        <input type="text" id="digit-3" maxlength="1" name="digit-3" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                                        <input type="text" id="digit-4" maxlength="1" name="digit-4" class="form-control loginField otpfil px-2 text-center"  placeholder="_" required/>
                                                    </div>
                                                    <!-- <p class="erro d-none mb-0">Invalid OTP code. <a href="#" class="hyperinline confirmOTPModalTimer">Resend OTP</a> 30 sec.</p> -->
                                                    <p class="erro d-none mb-0"><a href="javascript:void(0);" class="hyperinline confirmOTPModalTimer confirmOTPModalResendOtp">Resend OTP</a></p>

                                                </div>
                                                <div class="form-group position-relative">
                                                    <button type="submit" class="btn submit_btn otpsubmit custom_btn verify_otp">
                                                        <span class="btn_text">Continue</span>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /Col -->
                                        </div>
                                             <!-- /Form Row -->
                                        </form>
                                    </div>
                                        <!-- /Login Form Box Cover -->
                                </div>
                                    <!-- /Login Form Content -->
                            </div>
                         </article>
                    </section>
                    <!-- /Login Form Section -->
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- <script src="https://dunggramer.github.io/disable-devtool/disable-devtool.min.js" defer></script> -->
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


        <script src="{{ asset('new-design-company/assets/js/main.js') }}" type="application/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js" integrity="sha512-Fq/wHuMI7AraoOK+juE5oYILKvSPe6GC5ZWZnvpOO/ZPdtyA29n+a5kVLP4XaLyDy9D1IBPYzdFycO33Ijd0Pg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->

        <script src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>

        <!-- <script src="https://cdn.jsdelivr.net/gh/dubrox/Multiple-Dates-Picker-for-jQuery-UI@master/jquery-ui.multidatespicker.js"></script> -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>



        <script>

        

            var deletedRideId;

            $('#phone, #phone_edit, .otpfil').keyup(function () { 
                this.value = this.value.replace(/[^0-9+\.]/g,'');
            });
    
            $("#phone, #phone_edit").on("blur", function(e){

                var conuntrycode = $('#country_code').val();
                var mobNum = $(this).val();
                $('#otpPhone').val(mobNum);
                var filter = /^\d*(?:\.\d{1,2})?$/;
                if (filter.test(mobNum)) {
                    return true;
                    // if(mobNum.length==10){
                    //     return true;  
                    // } else {
                    //     $(this).val('')
                    //     return false;
                    // }
                }
                else if(mobNum.startsWith("+")){
                    var temp = mobNum.substring(conuntrycode.length + 1 , mobNum.length);
                    mobile = temp;
                    $(this).val(mobile)
                    return true; 
                } else {
                    $(this).val('')
                    return false;
                }

            });


    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
        initialCountry:"us",
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
        autoFormat: false,
        nationalMode: true,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "";
        },
    });

    iti.promise.then(function() {
        input.addEventListener("countrychange", function() {

            var selectedCountryData = iti.getSelectedCountryData();
            $('#country_code').val(selectedCountryData.dialCode);
            $('#otpCountryCode').val(selectedCountryData.dialCode);

            console.log(selectedCountryData);

        });
    });


    $(function(){
      
      $('input[id$="time"]').inputmask(
        "hh:mm", {
        placeholder: "HH:MM", 
        insertMode: false, 
        showMaskOnHover: false,
      }
      );
      
      
    });
  </script>
        <script>

            $('#pickUpDateRideEdit').datepicker({
                format: "yyyy-mm-dd",
                startDate: "today"
            });


            $('#pickUpDateRide').datepicker({
                multidate: true,
                format: "yyyy-mm-dd",
                startDate: "today"

            });

        </script>
       

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
        <script src="{{ asset('/assets/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/clockpicker/dist/jquery-clockpicker.min.js"></script>
        @yield('footer_scripts')
        @if ( \Request::route()->getName()=='guest.rides' || \Request::route()->getName()=='booking_taxisteinemann' || \Request::route()->getName()=='guest.login' )

            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCn7nxEJGDtQo1wl8Mzg9178JAU2x6-Y0E&libraries=geometry,places&callback=Function.prototype"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js"></script>
            <script>




                $("#users").select2();
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
                newBookingMap = new google.maps.Map(document.getElementById('googleMapNewBooking'), {
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: false,
                    center: { lat: 46.8182, lng: 8.2275 },//Setting Initial Position
                    zoom: 8
                });
                async function showRideModal(rideId,Dclass)
                {
                    selected_ride_id = rideId;
                    route = "{{ route('guest.ride_detail','~') }}";
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

                    $('.dateTimeList'+selected_ride_id).html(booking.ride_time_modified);
                    $('.pickupPointList'+selected_ride_id).html(booking.pickup_address);

                    $('.'+Dclass).removeClass('selected');
                    $('.'+Dclass+'[data-id="'+rideId+'"]').addClass('selected');
                    // console.log(booking);
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
                        // console.log(booking.driver);
                        $('.ride_driver_details_div').show();
                        $('.ride_driver_details_div').addClass('d-flex');
                        $('.ride_driver_details_div_user_na').hide();
                        if(booking.driver.image_with_url){
                            $('.ride_driver_details_div_image').attr('src',booking.driver.image_with_url);
                        } else {
                            $('.ride_driver_details_div_image').attr('src',"{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}");
                        }
                        $('.ride_driver_details_div_driver_name').html(booking.driver.first_name+' '+booking.driver.last_name);

                        
                        if(booking.driver.country_code) {
                            $('.ride_driver_details_div_driver_phone').html('+'+booking.driver.country_code+'-'+booking.driver.phone);
                            $('.ride_driver_details_div_driver_na').text('');
                        } else {
                            $('.ride_driver_details_div_driver_na').text('N/A');
                        }

                    }
                    $('.ride_car_div').hide();
                    $('.ride_car_div').removeClass('d-flex');
                    $('.ride_car_div_na').show();
                    $('.ride_car_div_na').text(booking.car_type);
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
                        $('.carList'+selected_ride_id).html(booking.vehicle.vehicle_number_plate);
                    }

                    $('.no_of_passengers').html(booking.passanger);
                    if (booking.user && booking.user.first_name)
                    {
                        $('.customerList'+selected_ride_id).html(booking.user.first_name+' '+booking.user.last_name);
                        $('.passenger_details').html(booking.user.first_name+' '+booking.user.last_name+"  (+"+booking.user.country_code+'-'+booking.user.phone+")");
                    }
                    $('.ride_payment_type').html(booking.payment_type);
                    $('.ride_car_price').html('CHF '+booking.ride_cost);
                    $('.ride_note_div').html(booking.note);

                    ride_status = ""
                    if(booking.status == -2)
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-danger">Cancelled</span> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button> <button style="margin-left: 15px;height: 28px;" class="btn btn-danger text-white btn-sm delete_record" data-id="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-trash" aria-hidden="true"></i></button> </span>`;
                    }
                    else if(booking.status == -1)
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-danger">Rejected</span> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button> </span>`;
                    }
                    else if(booking.status == 1)
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-info">Accepted</span> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button> </span>`;
                    }
                    else if(booking.status == 2)
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-info">Started</span> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button> </span>`;
                    }
                    else if(booking.status == 4)
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-info">Driver Reached</span> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button> </span>`;
                    }
                    else if(booking.status == 3)
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-success">Completed</span> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button> </span>`;
                    }
                    else if(booking.status == -3)
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-danger">Cancelled</span> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button> <button style="margin-left: 15px;height: 28px;" class="btn btn-danger text-white btn-sm delete_record" data-id="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-trash" aria-hidden="true"></i></button> </span>`;
                    }
                    else if(booking.status == -4)
                    {
                        ride_status = `<span class="d-flex btnactions mutibtns dropdown"><span class="infomation_update status_box done bg-warning">Pending</span> <span class="mutibtndropdown"><button style="margin-left: 15px;height: 28px;" class="btn btn-warning text-white btn-sm cancel_ride" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-close" aria-hidden="true"></i></button> <button style="margin-left: 15px;height: 28px;" class="btn btn-danger text-white btn-sm delete_record" data-id="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-trash" aria-hidden="true"></i></button> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button></span></span>`;
                    }
                    else if(booking.status == 0)
                    {
                        ride_status = `<p class="infomation_update done bg-warning">Upcoming</p> <button style="margin-left: 15px;height: 28px;" class="btn btn-info text-white btn-sm editRideBtn" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-pencil" aria-hidden="true"></i></button> <button style="margin-left: 15px;height: 28px;" class="btn btn-warning text-white btn-sm cancel_ride" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-close" aria-hidden="true"></i></button> <button style="margin-left: 15px;height: 28px;" class="btn btn-danger text-white btn-sm delete_record" data-id="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-trash" aria-hidden="true"></i></button> <button style="margin-left: 15px;height: 28px;" class="btn btn-primary text-white btn-sm clone_record" data-rideid="`+booking.id+`" data-parentid="`+booking.parent_ride_id+`"><i class="fa fa-clone" aria-hidden="true"></i></button>`;
                    }
                    else if(Date.parse(booking.ride_time) < Date.parse(Date()))
                    {
                        ride_status = `<span class="d-flex btnactions"><span class="infomation_update status_box done bg-warning">Upcoming</span></span>`;
                    }
                   //  $('.statusList'+selected_ride_id).html(ride_status); if we need to show all button on ride row 
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
                    $('#add_new_bookings').css({'margin-right':'-660px','transition':'all 400ms linear'});
                    $('.close_modal_action_view').addClass('show');
                    $('#view_booking').css({'margin-right':'0px','transition':'all 400ms linear'});
                }

                
                $(document).on('click','.rideDetails',function()
                {
                    showRideModal($(this).data('id'),'rideDetails');
                });

                $(document).on('click','.clone_record',function () {
                    var ride_id = $(this).data('rideid');
                    selected_ride_id = ride_id;
                    $(document).find(".cancel_ride").hide();
                    $(document).find(".edit_booking").hide();
                    $(document).find(".save_booking").show();

                    $.ajax({
                        url: "{{ route('guest.rides.edit') }}",
                        type: 'get',
                        data: {
                            ride_id: ride_id
                        },
                        success: function(response) {
                             console.log(response);
                            if (response.status) {
                                $("#ride_id").val(ride_id);
                                $('.bookRideTitle').html('Clone Booking');
                                $("#pickupPoint").val(response.data.ride_detail.pickup_address);
                                $("#pickup_latitude").val(response.data.ride_detail.pick_lat);
                                $("#pickup_longitude").val(response.data.ride_detail.pick_lng);
                                $("#dropoffPoint").val(response.data.ride_detail.dest_address);
                                $("#dropoff_latitude").val(response.data.ride_detail.dest_lat);
                                $("#dropoff_longitude").val(response.data.ride_detail.dest_lng);
                                $("input[name='ride_date']").val(response.data.ride_detail.ride_date_new_modified_n);
                                $("input[name='ride_time']").val(response.data.ride_detail.ride_time_new_modified_n);
                                $("input[name='car_type'][data-text='"+ response.data.ride_detail.car_type +"']").attr('checked', 'checked').change();
                                $("#numberOfPassenger").val(response.data.ride_detail.passanger).change();

                                $("#pickUpDateRideEdit").show();
                                $("#pickUpDateRide").hide();
                                $("#pickUpDateRideEdit").attr("disabled",false);
                                $("#pickUpDateRide").attr("disabled",true);

                                if(response.data.ride_detail.user_id == 0){
                                    $("#users").val("").change();
                                } else {
                                    $("#users").val(response.data.ride_detail.user_id).change();
                                }
                                $(".price_calculated_input").val(response.data.ride_detail.ride_cost);
                                $("#distance_calculated_input").val(response.data.ride_detail.distance);
                                $("#payment_type").val(response.data.ride_detail.payment_type);
                                $("#note").val(response.data.ride_detail.note);

                                $("#otpPhone").val(response.data.ride_detail.user_phone);
                                $("#otpCountryCode").val(response.data.ride_detail.user_country_code);

                                iti.setNumber("+"+response.data.ride_detail.user_country_code + response.data.ride_detail.user_phone);
                                $("#phone").val(response.data.ride_detail.user_phone);

                               // console.log(response.data.ride_detail.user_country_code + response.data.ride_detail.user_phone);


                               // $('#country_code').val(response.data.ride_detail.user_country_code).change();

                                if (response.data.ride_detail.pick_lat) {
                                    newBookingMapPoints = [{
                                        Latitude: response.data.ride_detail.pick_lat,
                                        Longitude: response.data.ride_detail.pick_lng,
                                        AddressLocation: response.data.ride_detail
                                            .pickup_address
                                    }];
                                    if (response.data.ride_detail.dest_lat) {
                                        newBookingMapPoints.push({
                                            Latitude: response.data.ride_detail.dest_lat,
                                            Longitude: response.data.ride_detail.dest_lng,
                                            AddressLocation: response.data.ride_detail
                                                .dest_address
                                        });
                                    }
                                    initializeMapReport(newBookingMapPoints);
                                }
                                // driver_detail_update(ride_id);
                                // $("#users").attr("disabled",true);
                                // $("#ride_time").attr("readonly",true);
                                // $("#pickupPoint").attr("disabled",true);
                                // $("#dropoffPoint").attr("disabled",true);
                                // $(".pickupPointCloseBtn").attr("disabled",true);
                                // $(".dropoffPointCloseBtn").attr("disabled",true);
                               // $("input[name='car_type']").attr("disabled",true);
                               // $("#numberOfPassenger").attr("disabled",true);
                               // $("#note").attr("readonly",true);

                                if(response.data.ride_detail.status == 0){
                                    // $("#users").removeAttr("disabled");
                                    // $("#ride_time").removeAttr("readonly");
                                    // $("#pickupPoint").removeAttr("disabled");
                                    // $("#dropoffPoint").removeAttr("disabled");
                                    // $(".pickupPointCloseBtn").removeAttr("disabled");
                                    // $(".dropoffPointCloseBtn").removeAttr("disabled");
                                   // $("input[name='car_type']").removeAttr("disabled");
                                  //  $("#numberOfPassenger").removeAttr("disabled");
                                  //  $("#note").removeAttr("readonly");
                                    $(document).find(".cancel_ride").hide();
                                    $(document).find(".edit_booking").hide();
                                } else if(response.data.ride_detail.status == 1 || response.data.ride_detail.status == 2 || response.data.ride_detail.status == 4){
                                    $(document).find(".edit_booking").hide();
                                    $(document).find(".cancel_ride").hide();
                                    // $("#users").attr("disabled",true);
                                    // $("#ride_time").attr("readonly",true);
                                    // $("#pickupPoint").attr("disabled",true);
                                    // $("#dropoffPoint").attr("disabled",true);
                                    // $(".pickupPointCloseBtn").attr("disabled",true);
                                    // $(".dropoffPointCloseBtn").attr("disabled",true);
                                   // $("input[name='car_type']").attr("disabled",true);
                                   // $("#numberOfPassenger").attr("disabled",true);
                                  //  $("#note").attr("readonly",true);
                                }
                                $('#view_booking').css({'margin-right':'-660px','transition':'all 400ms linear'});
                                $('.close_modal_action').addClass('show');
                                $('#add_new_bookings').css({'margin-right':'0px','transition':'all 400ms linear'});
                            } else if (response.status == 0) {
                                swal.fire("{{ __('Error') }}", response.message, "error");
                            }
                        },
                        error(response) {
                            swal.fire("{{ __('Error') }}", response.message, "error");
                        }
                    });
                });



                function setShortestRoute(response)
                {
                    shortestRouteArr = [];
                    $.each(response.routes, function( index, route ) {
                        shortestRouteArr.push(Math.ceil(parseFloat(route.legs[0].distance.value/1000)));
                    });
                    return shortestRouteArr.indexOf(Math.min(...shortestRouteArr));
                }

                

                $(document).on('click','.addNewBtn_cs ',function(){
                    newBookingMapPoints = [];
                    newBookingMarkers = [];
                    cur_lat = "";
                    cur_lng = "";
                    document.getElementById("booking_list_form").reset();
                    autocomplete_initialize();
                    $(document).find(".save_booking").show();
                    $(document).find(".cancel_ride").hide();
                    $(document).find(".edit_booking").hide();
                    $('.bookRideTitle').html('Book a Ride');

                    //$(".pick-up-date-ride").attr("id","pickUpDateRide");
                    $("#pickUpDateRideEdit").hide();
                    $("#pickUpDateRide").show();
                    $("#pickUpDateRideEdit").attr("disabled",true);
                    $("#pickUpDateRide").attr("disabled",false);


                    $("#users").attr("disabled",false);
                    $("#ride_time").attr("readonly",false);
                    $("#pickupPoint").attr("disabled",false);
                    $("#dropoffPoint").attr("disabled",false);
                    $(".pickupPointCloseBtn").attr("disabled",false);
                    $(".dropoffPointCloseBtn").attr("disabled",false);
                    $("input[name='car_type']").attr("disabled",false);
                    $("#numberOfPassenger").attr("disabled",false);
                    $("#note").attr("readonly",false);

                    $("input[name='car_type']:first").attr('checked', 'checked').change();
                    $('#view_booking').css({'margin-right':'-660px','transition':'all 400ms linear'});
                    $('.close_modal_action').addClass('show');
                    $('#add_new_bookings').css({'margin-right':'0px','transition':'all 400ms linear'});

                    var cCode = "{{ auth()->check() ? auth()->user()->country_code : '' }}";
                    var uPhone = "{{ auth()->check() ? auth()->user()->phone : '' }}";

                    

                    if(cCode && uPhone) {
                        $("#otpPhone").val(uPhone);
                        $("#otpCountryCode").val(cCode);
                        iti.setNumber("+"+cCode + uPhone);
                        $("#phone").val(uPhone);

                    }


                });

                //new booking code
                var onLoadVar = 0;
                var cur_lat = "";
                var cur_lng = "";
                var newBookingMap;
                var newBookingMapPoints = [];
                var newBookingMarkers = [];

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
                                'formatted_address']); //alert(results[0]['formatted_address']);
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
                    var seating_capacity = $('input[name="car_type"]:checked').data('seating_capacity');
                    // $('#numberOfPassenger').find('option').remove();
                    $('#numberOfPassenger').attr('max', seating_capacity);
                    // for (var i = 1; i <= seating_capacity; i++) {
                    //     $('#numberOfPassenger').append("<option value='" + i + "'>" + i + "</option>");
                    // }
                }
                $('#numberOfPassenger').on('input', function() {
                    var maxValue = parseInt($('input[name="car_type"]:checked').data('seating_capacity'));
                    var enteredValue = parseInt($(this).val());
                    if (enteredValue > maxValue) {
                        $(this).val(maxValue);
                    }
                });
                measure_seating_capacity();
                $(document).on('change', 'input[name="car_type"]', function() {
                    measure_seating_capacity();
                });

                function calculate_amount() {
                    var distance_calculated = $("#distance_calculated_input").val();
                    if ($('input[name="car_type"]:checked').val() == '') {
                        swal.fire("{{ __('Error') }}", "{{ __('Please select Car type') }}", "error");
                        return false;
                    }
                    var carType = $('input[name="car_type"]:checked').val();
                    var vehicle_basic_fee = $('input[name="car_type"]:checked').data('basic_fee');
                    var vehicle_price_per_km = $('input[name="car_type"]:checked').data('price_per_km');
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
                                    distance = result.routes[shortestRouteIndex].legs[0].distance.value/1000;
                                    distance = Math.ceil(distance);
                                    $('#distance_calculated_input').val(distance);
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

                $(document).on('change', 'input[name="car_type"]', function() {
                    calculate_amount();
                })

                function autocomplete_initialize() {
                    getLocation();
                    initializeMapReport(newBookingMapPoints);
                }

                google.maps.event.addDomListener(window, 'load', autocomplete_initialize);

                // $(document).on("submit", "#booking_list_form", function(e) {
                    $(document).on("click", ".save_booking", function(e) {


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
                    if ($('#phone').val()=="")
                    {
                        swal.fire("{{ __('Error') }}", "Please enter a mobile number", "error");
                        return false;
                    }

                    $('#otp_pickup_latitude').val($('input[name="pick_lat"]').val());
                    $('#otp_pickup_longitude').val($('input[name="pick_lng"]').val());
                    $('#otp_dropoff_latitude').val($('input[name="dest_lat"]').val());  
                    $('#otp_dropoff_longitude').val($('input[name="dest_lng"]').val());  
                    $('#otp_pickupPoint').val($('input[name="pickup_address"]').val());  
                    $('#otp_dropoffPoint').val($('input[name="dest_address"]').val());  
                    $('#otp_time').val($('input[name="ride_time"]').val());  
                    $('#otp_pickUpDateRide').val($('input[name="ride_date"]').val());  
                    $('#otp_distance_calculated_input').val($('input[name="distance"]').val());  
                    $('#otp_payment_type').val($('#payment_type').val()); 
                    $('#otp_numberOfPassenger').val($('input[name="passanger"]').val());  
                    $('#otp_car_type').val($('input[name="car_type"]:checked').val());  
                    $('#otp_ride_cost').val($('input[name="ride_cost"]').val());  
                    $('#otp_note').val($('textarea[name="note"]').val()); 
                    $('#otp_status').val($('input[name="status"]').val());

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

                                var isLogin = "{{ auth()->check() }}";

                                if(isLogin){
                                    $(document).find(".save_booking").attr('disabled', true);
                                }

                                var booking_url = "{{ auth()->check() ? route('guest.ride_booking') : route('send_otp_before_ride_booking') }}";
                                var authCheck = "{{ auth()->check() }}";

                                $.ajax({
                                    url: "{{ route('guest.user_exist') }}",
                                    type: 'post',
                                    dataType: 'json',
                                    data: $('form#booking_list_form').serialize(),
                                    success: function(response) {
                                        $.ajax({
                                            url: response.route,
                                            type: 'post',
                                            dataType: 'json',
                                            data: $('form#booking_list_form').serialize(),
                                            success: function(response) {

                                                if(response.booking_status == 'direct' && response.user_data) {
                                                    if (response.status) {    
                                                        swal.fire("{{ __('Success') }}", response.message,"success");
                                                        setTimeout(function() {
                                                            var currentURL = (document.URL);
                                                            var part = currentURL.split("/")[1];
                                                            route = part+'?token='+response.user_data.random_token;
                                                            window.location.href = route;
                                                            var isRandomToken = "{{ Auth::check() ? Auth::user()->random_token : '' }}";
                                                            socket.emit('master-driver-update-web', {"data":response.data});
                                                        }, 1000);
                                                       // socket.emit('master-driver-update-web', {"data":response.data});
                                                    } else if (response.status == 0) {
                                                        swal.fire("{{ __('Error') }}", response.message,
                                                            "error");
                                                        $(document).find(".save_booking").removeAttr('disabled');
                                                    }
                                                } else if(response.booking_status == 'direct' && !response.user_data) {
                                                    if (response.status) {          
                                                        socket.emit('master-driver-update-web', {"data":response.data});
                                                        swal.fire("{{ __('Success') }}", response.message,"success");
                                                        
                                                    } else if (response.status == 0) {
                                                        swal.fire("{{ __('Error') }}", response.message,
                                                            "error");
                                                        $(document).find(".save_booking").removeAttr('disabled');
                                                    }
                                                } else {
                                                    if(response.status){
                                                        $("#confirmOTPModal").modal('show');
                                                        timer(30,"confirmOTPModalTimer","otp_not_rec");
                                                    } else if(response.status == 0){
                                                        new swal("{{ __('Error') }}",response.message,"error");
                                                        $(document).find(".verify_otp").removeAttr('disabled');
                                                    }
                                                }
                                            },
                                            error(response) {
                                                swal.fire("{{ __('Error') }}", response.message, "error");
                                                $(document).find(".save_booking").removeAttr('disabled');
                                            }
                                        });
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

                socket.on('master-driver-response-2', async (response) => {

                    console.log(response);

                    var token = "{{ Request::get('token') }}";

                    var isLoginUserId = "{{ Auth::check() ? Auth::user()->id : '' }}";

                    if(response && response.data && response.data.user && response.data.user.random_token == token ){

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                    }else if(response && response.data  && response.data.creator_id == isLoginUserId ){

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    
                    } else if(response && deletedRideId && response.data && response.data.is_ride_deleted && response.ride_id == deletedRideId){

                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);

                    }
                    // else if (response && response.data  && response.data.delete_for_all) {
                    //     setTimeout(function() {
                    //         window.location.reload();
                    //     }, 1000);
                    // }
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

                $(document).on('click','.swapLocations',function(){
                    var dropoffPoint = $('#dropoffPoint').val();
                    var dropoff_latitude = $('#dropoff_latitude').val();
                    var dropoff_longitude = $('#dropoff_longitude').val();

                    $('#dropoffPoint').val($('#pickupPoint').val());
                    $('#dropoff_latitude').val($('#pickup_latitude').val());
                    $('#dropoff_longitude').val($('#pickup_longitude').val());

                    $('#pickupPoint').val(dropoffPoint);
                    $('#pickup_latitude').val(dropoff_latitude);
                    $('#pickup_longitude').val(dropoff_longitude);

                    if ($('#pickup_longitude').val()=="")
                    {
                        $(".distance_calculated_input").val(0);
                        initializeMapReport([]);
                    }
                    else
                    {
                        initializeMapReport([{
                            Latitude: $('#pickup_latitude').val(),
                            Longitude: $('#pickup_longitude').val(),
                            AddressLocation: $('#pickupPoint').val()
                        }]);
                    }
                    calculate_amount();
                });

                //edit ride
                $(document).on('click','.editRideBtn',function () {
                    var ride_id = $(this).data('rideid');
                    var parent_id = $(this).data('parentid');
                    selected_ride_id = ride_id;
                    $(document).find(".save_booking").hide();
                    $(document).find(".cancel_ride").show();
                    $(document).find(".edit_booking").show();
                    $(document).find(".edit_booking").attr('data-parentid', parent_id);
                    $.ajax({
                        url: "{{ route('guest.rides.edit') }}",
                        type: 'get',
                        data: {
                            ride_id: ride_id
                        },
                        success: function(response) {
                             console.log(response);
                            if (response.status) {
                                $("#ride_id").val(ride_id);
                                $('.bookRideTitle').html('Edit Ride');
                                $("#pickupPoint").val(response.data.ride_detail.pickup_address);
                                $("#pickup_latitude").val(response.data.ride_detail.pick_lat);
                                $("#pickup_longitude").val(response.data.ride_detail.pick_lng);
                                $("#dropoffPoint").val(response.data.ride_detail.dest_address);
                                $("#dropoff_latitude").val(response.data.ride_detail.dest_lat);
                                $("#dropoff_longitude").val(response.data.ride_detail.dest_lng);
                                $("input[name='ride_date']").val(response.data.ride_detail.ride_date_new_modified_n);
                                $("input[name='ride_time']").val(response.data.ride_detail.ride_time_new_modified_n);
                                $("input[name='car_type'][data-text='"+ response.data.ride_detail.car_type +"']").attr('checked', 'checked').change();

                                $("#pickUpDateRideEdit").show();
                                $("#pickUpDateRide").hide();
                                $("#pickUpDateRideEdit").attr("disabled",false);
                                $("#pickUpDateRide").attr("disabled",true);

                                $("#numberOfPassenger").val(response.data.ride_detail.passanger).change();
                                if(response.data.ride_detail.user_id == 0){
                                    $("#users").val("").change();
                                } else {
                                    $("#users").val(response.data.ride_detail.user_id).change();
                                }
                                $(".price_calculated_input").val(response.data.ride_detail.ride_cost);
                                $("#distance_calculated_input").val(response.data.ride_detail.distance);
                                $("#payment_type").val(response.data.ride_detail.payment_type);
                                $("#note").val(response.data.ride_detail.note);

                                $("#otpPhone").val(response.data.ride_detail.user_phone);
                                $("#otpCountryCode").val(response.data.ride_detail.user_country_code);

                                iti.setNumber("+"+response.data.ride_detail.user_country_code);
                                $("#phone").val(response.data.ride_detail.user_phone);


                                if (response.data.ride_detail.pick_lat) {
                                    newBookingMapPoints = [{
                                        Latitude: response.data.ride_detail.pick_lat,
                                        Longitude: response.data.ride_detail.pick_lng,
                                        AddressLocation: response.data.ride_detail
                                            .pickup_address
                                    }];
                                    if (response.data.ride_detail.dest_lat) {
                                        newBookingMapPoints.push({
                                            Latitude: response.data.ride_detail.dest_lat,
                                            Longitude: response.data.ride_detail.dest_lng,
                                            AddressLocation: response.data.ride_detail
                                                .dest_address
                                        });
                                    }
                                    initializeMapReport(newBookingMapPoints);
                                }
                                // driver_detail_update(ride_id);
                                
                                $("#users").attr("disabled",true);
                                $("#ride_time").attr("readonly",true);
                                $("#pickupPoint").attr("disabled",true);
                                $("#dropoffPoint").attr("disabled",true);
                                $(".pickupPointCloseBtn").attr("disabled",true);
                                $(".dropoffPointCloseBtn").attr("disabled",true);
                                $("input[name='car_type']").attr("disabled",true);
                                $("#numberOfPassenger").attr("disabled",true);
                                $("#note").attr("readonly",true);

                                if(response.data.ride_detail.status == 0){
                                    $("#users").removeAttr("disabled");
                                    $("#ride_time").removeAttr("readonly");
                                    $("#pickupPoint").removeAttr("disabled");
                                    $("#dropoffPoint").removeAttr("disabled");
                                    $(".pickupPointCloseBtn").removeAttr("disabled");
                                    $(".dropoffPointCloseBtn").removeAttr("disabled");
                                    $("input[name='car_type']").removeAttr("disabled");
                                    $("#numberOfPassenger").removeAttr("disabled");
                                    $("#note").removeAttr("readonly");
                                    $(document).find(".cancel_ride").hide();
                                    $(document).find(".edit_booking").show();
                                } else if(response.data.ride_detail.status == 1 || response.data.ride_detail.status == 2 || response.data.ride_detail.status == 4){
                                    $(document).find(".edit_booking").hide();
                                   // $(document).find(".cancel_ride").show();
                                    $("#users").attr("disabled",true);
                                    $("#ride_time").attr("readonly",true);
                                    $("#pickupPoint").attr("disabled",true);
                                    $("#dropoffPoint").attr("disabled",true);
                                    $(".pickupPointCloseBtn").attr("disabled",true);
                                    $(".dropoffPointCloseBtn").attr("disabled",true);
                                    $("input[name='car_type']").attr("disabled",true);
                                    $("#numberOfPassenger").attr("disabled",true);
                                    $("#note").attr("readonly",true);
                                }
                                $('#view_booking').css({'margin-right':'-660px','transition':'all 400ms linear'});
                                $('.close_modal_action').addClass('show');
                                $('#add_new_bookings').css({'margin-right':'0px','transition':'all 400ms linear'});
                            } else if (response.status == 0) {
                                swal.fire("{{ __('Error') }}", response.message, "error");
                            }
                        },
                        error(response) {
                            swal.fire("{{ __('Error') }}", response.message, "error");
                        }
                    });
                });

                $(document).on("click", ".edit_booking", function(e) {
                    var parent_id = $(this).data('parentid');
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
                            confirmButtonText: "{{ __('Update Ride') }}",
                            input: parent_id > 0 ? 'checkbox' : '',
                            inputName: 'change_for_all',
                            inputValue: 0,
                            inputPlaceholder: parent_id > 0 ? 'Update all related rides' : 'There are no related rides',
                        }).then((result) => {
                            if (result.value === 0 || result.value) {
                                $(document).find(".edit_booking").attr('disabled', true);
                                var token = '{{csrf_token()}}';
                                var change_for_all = result.value === 1 ? 1 : 0;

                                $.ajax({
                                    url: "{{ route('guest.ride_booking_update') }}",
                                    type: 'post',
                                    headers: {'X-CSRF-TOKEN': token},
                                    dataType: 'json',
                                    data: $('form#booking_list_form').serialize()+ '&change_for_all=' + change_for_all,
                                    success: function(response) {
                                        if (response.status) {

                                            console.log(response.data)

                                            socket.emit('master-driver-update-web', {"data":response.data});

                                            swal.fire("{{ __('Success') }}", response.message,
                                                "success");
                                            // setTimeout(function() {
                                            //     window.location.reload();
                                            // }, 1000);

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

                //cancel ride
                $(document).on('click', '.cancel_ride', function(e) {
                    e.preventDefault();
                    var parent_id = $(this).data('parentid');
                    delete_cancel_ride(selected_ride_id, parent_id);
                });

                function delete_cancel_ride(ride_id, parent_id){

                    Swal.fire({
                        title: "{{ __('Please Confirm') }}",
                        text: "{{ __('Cancel the ride ?') }}",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: "{{ __('Confirm') }}",
                        input: parent_id > 0 ? 'checkbox' : '',
                        inputName: 'delete_for_all',
                        inputValue: 0,
                        inputPlaceholder: parent_id > 0 ? 'Cancel all related rides' : 'There are no related rides',

                    }).then((result) => {
                        if (result.value === 0 || result.value) {
                            $.ajax({
                                url: "{{ route('guest.cancel_booking') }}",
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'ride_id': ride_id,
                                    'delete_for_all' : result.value === 1 ? 1 : 0,
                                },
                                success: function(response) {
                                    if (response.status) {
                                        $(document).find("li.list-group-item[data-ride_id='" + ride_id + "']").remove();
                                       
                                        socket.emit('master-driver-update-web', {"data":response.data});

                                        Swal.fire("Success", response.message, "success");
                                        // setTimeout(function() {
                                        //     window.location.reload();
                                        // }, 1000);
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

                $(document).on('click', '.delete_record', function() {
                    var parent_id = $(this).attr('data-parentid');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Delete the ride ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirm',
                        input: parent_id > 0 ? 'checkbox' : '',
                        inputName: 'delete_for_all',
                        inputValue: 0,
                        inputPlaceholder: parent_id > 0 ? 'Delete all related rides' : 'There are no related rides',

                    }).then((result) => {
                        if (result.value === 0 || result.value) {
                            var ride_id = $(this).attr('data-id');

                            $.ajax({
                                url: "{{ route('guest.delete_booking') }}",
                                type: 'post',
                                dataType: 'json',
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'ride_id': ride_id,
                                    'delete_for_all' : result.value === 1 ? 1 : 0,

                                },
                                success: function(response) {
                                    if (response.status) {
                                        deletedRideId = ride_id;
                                        $(document).find("li.list-group-item[data-ride_id='" + ride_id + "']").remove();
                                       
                                        socket.emit('master-driver-update-web', {"data":response.data, "ride_id":ride_id});

                                        Swal.fire("Success", response.message, "success");
                                        // setTimeout(function() {
                                        //     window.location.reload();
                                        // }, 1000);
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
                });

                // $(document).on('keypress','#phone',function(e) {

                //     var keyCode = e.which ? e.which : e.keyCode;
                //     var isValid = (keyCode >= 48 && keyCode <= 57) || keyCode === 8 || keyCode === 9;

                //     if (!isValid) {
                //         e.preventDefault();
                //     }
                // });

                // $(document).on('keypress','#phone_edit',function(e) {
                //     var keyCode = e.which ? e.which : e.keyCode;
                //     var isValid = (keyCode >= 48 && keyCode <= 57) || keyCode === 8 || keyCode === 9;

                //     if (!isValid) {
                //         e.preventDefault();
                //     }
                // });

            </script>
        @endif
        <script>
            $(document).on('change','#cLogo',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#cLogoImgPreview').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('change','#cBackgroundImage',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#cBackgroundImageImgPreview').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('change','#cImage',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#cImageImgPreview').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('change','#mPhoto',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#mPhotoImgPreview').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('change','#photo3',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#photo3imgPreview').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('change','#photo1',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#photo1imgPreview1').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('change','#photo2',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#photo2imgPreview2').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('click','#timeInput',function(){
                $('#timeInput').clockpicker({
                    autoclose: true,
                    placement: 'bottom',
                    align: 'right'
                });
            });


             // var timerOn = true;
        function timer(remaining,timerClass,confirmOTPModalResendOtpClass) {
           // $('.'+confirmOTPModalResendOtpClass).hide();
            $('.'+timerClass).show();
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;
            
            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            // console.log(timerClass);
            // console.log(s);
            if(s > 0) {
                $('.'+timerClass).html('{{ __("Resend OTP in") }} ' + s);
            } else {
                $('.'+timerClass).html('{{ __("Resend OTP") }} ');
            }

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
           // $('.'+timerClass).hide();
        }

        $(document).on('click','.confirmOTPModalResendOtp',function(){
            $.ajax({
                url: "{{ route('send_otp_before_ride_booking')}}",
                type: 'post',
                dataType: 'json',
                data: $('form#otp_form').serialize(),
                success: function(response) {
                    if(response.status){
                        $("#confirmOTPModal").modal('show');
                        timer(30,"confirmOTPModalTimer","otp_not_rec");
                    } else if(response.status == 0){
                        new swal("{{ __('Error') }}",response.message,"error");
                        $(document).find(".verify_otp").removeAttr('disabled');
                    }
                },
                error(response) {
                    new swal("{{ __('Error') }}",response.message,"error");
                    $(document).find(".verify_otp").removeAttr('disabled');
                }
            });
        });

        $(document).on("submit", "#otp_form", function(e) {
            e.preventDefault();
            var otp_entered = $("#digit-1").val()+$("#digit-2").val()+$("#digit-3").val()+$("#digit-4").val();
            if (otp_entered > 1) {
                $('.otpcode_box').addClass('invalid_field');
            }
            else{
                $('.otpcode_box').removeClass('invalid_field');
            }
            var post_data = $('form#otp_form').serialize();
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
                    console.log(response);
                    if(response.status){
                        new swal("{{ __('Success') }}",response.message,"success");
                        setTimeout(function() {
                            var currentURL = (document.URL); // returns http://myplace.com/abcd
                            var part = currentURL.split("/")[1];
                            route = part+'?token='+response.user_data.random_token;
                            //  route = "{{ route('list_of_booking_taxisteinemann','~') }}";
                           // route = route.replace('~',response.user_data.random_token);
                            window.location.href = route;//"{{ route('booking_taxisteinemann')}}";
                        }, 2000);
                    } else if(response.status == 0){
                        new swal("{{ __('Error') }}",response.message,"error");
                        $(document).find(".verify_otp").removeAttr('disabled');
                        $(document).find(".bookRideSBtn").removeAttr('disabled');
                    }
                },
                error(response) {
                    new swal("{{ __('Error') }}",response.message,"error");
                    $(document).find(".verify_otp").removeAttr('disabled');
                    $(document).find(".bookRideSBtn").removeAttr('disabled');
                }
            });
        })


        $(document).ready(function () {
        $(".otp_form *:input[type!=hidden]:first").focus();
        let otp_fields = $(".otp_form .otpfil"),
            otp_value_field = $(".otp_form .otp-value");
        otp_fields
        .on("input", function (e) {
            $(this).val(
                $(this)
                    .val()
                    .replace(/[^0-9]/g, "")
            );
            let opt_value = "";
            otp_fields.each(function () {
                let field_value = $(this).val();
                if (field_value != "") opt_value += field_value;
            });
            otp_value_field.val(opt_value);
        })
        .on("keyup", function (e) {
            let key = e.keyCode || e.charCode;
            if (key == 8 || key == 46 || key == 37 || key == 40) {
                // Backspace or Delete or Left Arrow or Down Arrow
                $(this).prev().focus();
            } else if (key == 38 || key == 39 || $(this).val() != "") {
                // Right Arrow or Top Arrow or Value not empty
                $(this).next().focus();
            }
        })
        .on("paste", function (e) {
            let paste_data = e.originalEvent.clipboardData.getData("text");
            let paste_data_splitted = paste_data.split("");
            $.each(paste_data_splitted, function (index, value) {
                otp_fields.eq(index).val(value);
            });
        });

    });

           

            $(document).keyup(function(e) {
                if (e.key === "Escape") { // escape key maps to keycode `27`
                    $(document).find('#view_booking').css({'margin-right':'-660px','transition':'all 400ms linear'});
                    $(document).find('#add_new_bookings').css({'margin-right':'-660px','transition':'all 400ms linear'});
                }
            });

           

        </script>
    </body>
</html>
