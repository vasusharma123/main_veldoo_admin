@extends('company.layouts.app')
<style>
    .fc-h-event {
        background-color: #fc4c02 !important;
        border: 1px solid #fc4c02 !important;
    }
</style>
@section('header_button')
    <button type="button" class="btn addNewBtn_cs me-4">
        <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon " class="img-fluid add_booking_icon svg add_icon_svg" />
        <span class="text_button">Book a ride</span>
    </button>
@endsection
@section('content')
    <section class="add_booking_section">
        <article class="add_new_booking_box">
            <div class="action_btn text-end page_btn">
                <button type="button" class="btn add_new_booking_btn">
                    <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon" class="img-fluid add_booking_icon" />
                    <span class="text_button">Book a ride</span>
                </button>
            </div>
        </article>
    </section>
    <section class="table_all_content">
        <article class="table_container top_header_text">
            <h1 class="main_heading">History</h1>
            <nav aria-label="breadcrumb" class="pageBreadcrumb">
                <ol class="breadcrumb tab_lnks">
                    <li class="breadcrumb-item"><a class="tabs_links_btns" href="{{ route('company.rides','list') }}">List View</a></li>
                    <li class="breadcrumb-item"><a class="tabs_links_btns active" href="{{ route('company.rides','month') }}">Month View</a></li>
                    <li class="breadcrumb-item"><a class="tabs_links_btns" href="{{ route('company.rides','week') }}">Week View</a></li>
                </ol>
            </nav>
            <!-- /List View -->
            <div id="monthView" class="resume">
                <div id='calendar'></div>
            </div>
            <!-- /Month View -->
            {{--<div id="weekView" class="resume next-tabs">
                <div id='calendar2'></div>
            </div> --}}
            <!-- /week View -->
        </article>
    </section>
    <!-- Section Add New Booking -->
    <section class="add_booking_modal" id="add_new_bookings">
        <article class="booking_container_box">
            <a href="#" class="back_btn_box mobile_view close_modal_action">
                <img src="{{ asset('new-design-company/assets/images/back_icon.svg') }}" class="img-fluid back_btn" alt="Back arrow" />
                <span class="btn_text ">Back</span>
            </a>
            <div class="header_top">
                <h4 class="sub_heading">Book a Ride</h4>
                <span class="close_modal desktop_view close_modal_action">&times;</span>
            </div>
            <form class="addBooking_form">
                <div class="save_btn_box desktop_view">
                    <button type="submit" class="btn save_form_btn">Book Ride</button>
                </div>

                <div class="pickup_Drop_box">
                    <div class="area_details">
                        <div class=" area_box pickUp_area">
                            <img src="{{ asset('new-design-company/assets/images/pickuppoint.png') }}" class="img-fluid pickup_icon" alt="pick up icon"/>
                            <div class="location_box">
                                <label class="form_label">Pickup Point</label>
                                <input type="text" class="form_control borderless_form_field pickup_field" placeholder="Enter pickup point">
                            </div>
                            <span class="empty_field">&times;</span>
                        </div>
                        <div class="divider_form_area">
                            <span class="divider_area"></span>
                            <img src="{{ asset('new-design-company/assets/images/switch_area.svg') }}" alt="switch btn" class="img-fluid svg switch_area"/>
                        </div>
                        <div class=" area_box dropUp_area">
                            <img src="{{ asset('new-design-company/assets/images/drop_point.png') }}" class="img-fluid pickup_icon" alt="Drop up icon"/>
                            <div class="location_box">
                                <label class="form_label">Drop Point</label>
                                <input type="text" class="form_control borderless_form_field dropup_field" placeholder="Enter drop point">
                            </div>
                            <span class="empty_field">&times;</span>
                        </div>
                    </div>
                </div>

                <div class="date_picker_box">
                    <div class="date_area_box d-flex">
                        <div class=" area_box pickUp_area">
                            <img src="{{ asset('new-design-company/assets/images/calendar-days.svg') }}" class="img-fluid svg pickup_icon" alt="pick up icon"/>
                            <div class="location_box">
                                <label class="form_label">Pick a Date</label>
                                <input type="date" class="form_control borderless_form_field pickup_field" placeholder="Enter pickup point">
                            </div>

                        </div>
                        <div class="divider_form_area vrt">
                            <span class="divider_area vrt"></span>
                        </div>
                        <div class=" area_box dropUp_area timer_picker">
                            <img src="{{ asset('new-design-company/assets/images/clock.svg') }}" class="img-fluid svg pickup_icon" alt="Drop up icon"/>
                            <div class="location_box">
                                <label class="form_label">Pick a Time</label>
                                <input type="time" class="form_control borderless_form_field dropup_field" placeholder="Enter drop point">
                            </div>

                        </div>
                    </div>

                </div>

                <div class="cars_selection">
                    <div class="swiper carSwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="car_option position-relative">
                                    <input type="radio" class="car_checked" name="carDone"/>
                                    <img src="{{ asset('new-design-company/assets/images/small.png') }}" class="img-fluid car_img" alt="Small" />
                                    <label class="car_lable">Regular</label>
                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="car_option position-relative">
                                    <input type="radio" class="car_checked" name="carDone"/>
                                    <img src="{{ asset('new-design-company/assets/images/business.png') }}" class="img-fluid car_img" alt="Business" />
                                    <label class="car_lable">Business</label>

                                </div>
                            </div>

                            <div class="swiper-slide">
                                <div class="car_option position-relative">
                                    <input type="radio" class="car_checked" name="carDone"/>
                                    <img src="{{ asset('new-design-company/assets/images/large.png') }}" class="img-fluid car_img" alt="Minibus" />
                                    <label class="car_lable">Minibus</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="passengers_box_details">
                    <div class="passenger_box_content d-flex justify-content-between">
                        <div class="number_psnger d-flex">
                            <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                            <div class="location_box">
                                <label class="form_label">No. Of Passengers</label>
                                <input type="number" min="1" class="form_control borderless_form_field psnger_no" value="1">
                            </div>
                        </div>

                        <div class="name_psnger d-flex">
                            <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                            <div class="location_box">
                                <label class="form_label">Name of Passenger</label>
                                <input type="text" min="1" class="form_control borderless_form_field psnger_no" multiple id="tom-select-it" placeholder="Enter name" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form_payment_box">
                    <div class="row w-100 m-0">

                        <div class="col-lg-7 col-md-7 col-sm-6 col-12 ps-0 method_box">
                            <div class="form_box">
                                <label class="form_label down_form_label">Payment Method</label>
                                <select class="form-select down_form">
                                    <option selected>--Select--</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-6 col-12 pe-0 amount_box">
                            <div class="form_box">
                                <label class="form_label down_form_label ">Amount</label>
                                <div class="form-dollar position-relative">
                                    <input type="number" min="0" class="form-control down_form cost"/>
                                    <i class="bi bi-currency-dollar dollar_sign"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                            <div class="form_box add_note">
                                <label class="form_label down_form_label ">Add Note</label>
                                <textarea rows="3" cols="5" class="form-control down_form "></textarea>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="save_btn_box mobile_view">
                    <button type="submit" class="btn save_form_btn bottom_btn w-100">Book Ride</button>
                </div>

            </form>
        </article>
    </section>
    <!-- /Section Add New Booking -->
    <!-- Section View Booking -->
    <section class="add_booking_modal view_booking" id="view_booking">
        <article class="booking_container_box">
            <a href="#" class="back_btn_box mobile_view close_modal_action_view">
                <img src="{{ asset('new-design-company/assets/images/back_icon.svg') }}" class="img-fluid back_btn" alt="Back arrow" />
                <span class="btn_text ">Back</span>
            </a>
            <div class="header_top view_header">
                <h4 class="sub_heading">Booking Details</h4>
                <span class="close_modal desktop_view close_modal_action_view">&times;</span>
            </div>
            <form class="addBooking_form">
                <div class="map_frame">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7927.826256700516!2d3.367378340734855!3d6.532655273840193!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b8daf1c3e700d%3A0x75727c8869185d88!2sOnipanu%2C%20Somolu%20102216%2C%20Ikeja%2C%20Lagos%2C%20Nigeria!5e0!3m2!1sen!2sin!4v1685382393051!5m2!1sen!2sin" width="370" height="211" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
                <div class="pickup_Drop_box">
                    <div class="area_details">
                        <div class=" area_box pickUp_area veiw_pickup">
                            <img src="{{ asset('new-design-company/assets/images/pickuppoint.png') }}" class="img-fluid pickup_icon" alt="pick up icon"/>
                            <div class="location_box">
                                <label class="form_label">Pickup Point</label>
                                <p class="pickup_field mb-0">2972 Westheimer</p>
                            </div>
                        </div>
                        <div class=" area_box dropUp_area">
                            <img src="{{ asset('new-design-company/assets/images/drop_point.png') }}" class="img-fluid pickup_icon" alt="Drop up icon"/>
                            <div class="location_box">
                                <label class="form_label">Drop Point</label>
                                <p class="pickup_field mb-0">Rd. Santa Ana, Illinois 85486</p>
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
                                <label class="pickupdate">08/02/2023</label>
                            </div>

                        </div>
                        <div class="divider_form_area vrt view_port">
                            <span class="divider_area vrt "></span>
                        </div>
                        <div class=" area_box dropUp_area timer_picker mb-3">
                            <img src="{{ asset('new-design-company/assets/images/clock.svg') }}" class="img-fluid svg pickup_icon" alt="Drop up icon"/>
                            <div class="location_box">
                                <label class="form_label">Pick a Time</label>
                                <label class="pickTimes">06:00 PM</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="driver_date_picker">
                    <div class="date_area_box d-flex justify-content-between">
                        <div class=" area_box pickUp_area">
                            <div class="location_box">
                                <label class="form_label">Driver Details</label>
                                <div class="viewuser_sidebar d-flex align-items-center">
                                    <img src="{{ asset('new-design-company/assets/images/user.png') }}" alt="User avatar" class="img-fluid user_avatar"/>
                                    <div class="name_occupation d-flex flex-column">
                                        <span class="user_name">Raman Kumar</span>
                                        <a href="tel:+91 9563256484" class="user_position side_mob_link">+91 9563256484</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="divider_form_area vrt view_port">
                            <span class="divider_area vrt "></span>
                        </div>
                        <div class=" area_box dropUp_area timer_picker">
                            <div class="location_box">
                                <label class="form_label">Pick a Time</label>
                                <div class="viewuser_sidebar d-flex align-items-center">
                                    <img src="{{ asset('new-design-company/assets/images/business.png') }}" alt="Selected Car" class="img-fluid car_selectImg"/>
                                    <div class="name_occupation d-flex flex-column">
                                        <span class="user_name">Business</span>
                                    </div>
                                </div>
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
                                    <label class="form_label">No. Of Passengers</label>
                                    <label class="user_name">1</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-md-7 col-sm-6 col-6 pe-0">
                            <div class="name_psnger d-flex">
                                <img src="{{ asset('new-design-company/assets/images/person.svg') }}" class="img-fluid svg pickup_icon man_icons" alt="pick up icon"/>
                                <div class="location_box">
                                    <label class="form_label">Name of Passenger</label>
                                    <label class="user_name">Aman Verma</label>
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
                                <label class="user_name"><img src="{{ asset('new-design-company/assets/images/card.svg') }}" class="img-fluid card_img me-2" alt="payment Image"><span>Cash</span></label>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-6 col-6 pe-0 amount_box">
                            <div class="form_box">
                                <label class="form_label down_form_label d-block">Amount</label>
                                <label class="user_name"><img src="{{ asset('new-design-company/assets/images/card.svg') }}" class="img-fluid card_img me-2" alt="payment Image"><span>$ 35</span></label>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 px-0">
                            <div class="form_box add_note">
                                <label class="form_label down_form_label d-block">Add Note</label>
                                <label class="user_name">Be on time. Don’t want to get late.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </article>
    </section>
    <!-- /Section View Booking -->
@endsection
@section('footer_scripts')
    <script>
        if ($('#calendar').length > 0)
        {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                events:
                [
                    @foreach ($rides as $ride)
                        {
                            title: '{{ @$ride->user->first_name.' '.@$ride->user->last_name }} {{ @$ride->vehicle->vehicle_number_plate?' - '.@$ride->vehicle->vehicle_number_plate:'' }} ({{ date('H:i',strtotime($ride->ride_time)) }})',
                            start: "{{ date('Y-m-d',strtotime($ride->ride_time)) }}",
                            end: "{{ date('Y-m-d',strtotime($ride->ride_time)) }}"
                        },
                    @endforeach
                ],
                initialDate: "{{ $date }}",
                themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    start: 'prev,today,next title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: '' // will normally be on the right. if RTL, will be on the left
                }
            });
            calendar.render();
            $(document).on('click', 'button.fc-prev-button, button.fc-next-button', function () {
                var currentDate = calendar.view.currentStart;
                var year = currentDate.getFullYear();
                var month =  (currentDate.getMonth() + 1).toLocaleString('en-US', {
                            minimumIntegerDigits: 2,
                            useGrouping: false
                        });

                // alert('Year is ' + year + ' Month is ' + month);
                window.location.href = "{{ route('company.rides','month') }}?m="+year+"-"+month+"-01";
            });
        }
    </script>
@endsection
