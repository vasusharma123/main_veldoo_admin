@extends('company.layouts.app')
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
                    <li class="breadcrumb-item"><a class="tabs_links_btns active" href="{{ route('company.rides','list') }}">List View</a></li>
                    <li class="breadcrumb-item"><a class="tabs_links_btns" href="{{ route('company.rides','month') }}">Month View</a></li>
                    <li class="breadcrumb-item"><a class="tabs_links_btns" href="{{ route('company.rides','week') }}">Week View</a></li>
                </ol>
            </nav>
            <div id="listView" class="resume list_names">
                {{-- <div class="cln_header d-flex align-items-center">
                    <div class="action_next_prev d-flex align-items-center">
                        <button class="sm_btn prevSm"><i class="bi bi-chevron-left"></i></button>
                        <span class="schd_time">Today</span>
                        <button class="sm_btn nextSm"><i class="bi bi-chevron-right"></i></button>
                    </div>
                    <h3 class="sub_heading ms-3">May-Jun 2023</h3>
                </div> --}}
                <div class="table_box">
                    <table class="table table-responsive table-stripes custom_table_view">
                        <thead>
                            <tr>
                                <th>DateTime</th>
                                <th>Pickup Point</th>
                                <th class="sm_hide">Car</th>
                                <th class="sm_hide">Customer</th>
                                <th class="sm_hide"><span class="status_title">Status</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rides as $ride)
                                <tr>
                                    <td class="btn_view_booking rideDetails" data-id="{{ $ride->id }}" style="cursor: pointer">
                                        {{ date('D, d.m.Y',strtotime($ride->ride_time)) }} {{ date('H:i',strtotime($ride->ride_time)) }}
                                    </td>
                                    <td style="max-width:200px">{{ $ride->pickup_address }}</td>
                                    <td class="sm_hide">{{ @$ride->vehicle->vehicle_number_plate }}</td>
                                    <td class="sm_hide">{{ @$ride->user->first_name.' '.@$ride->user->last_name }}</td>
                                    <td class="sm_hide">
                                        @if($ride->status == -2)
                                            <span class="status_box bg-danger">Cancelled</span>
                                        @elseif($ride->status == -1)
                                            <span class="status_box bg-danger">Rejected</span>
                                        @elseif($ride->status == 1)
                                            <span class="status_box bg-info">Accepted</span>
                                        @elseif($ride->status == 2)
                                            <span class="status_box bg-info">Started</span>
                                        @elseif($ride->status == 4)
                                            <span class="status_box bg-info">Driver Reached</span>
                                        @elseif($ride->status == 3)
                                            <span class="status_box bg-success">Completed</span>
                                        @elseif($ride->status == -3)
                                            <span class="status_box bg-danger">Cancelled by you</span>
                                        @elseif($ride->status == 0)
                                            <span class="status_box bg-warning">Pending</span>
                                        @elseif(Date.parse($ride->ride_time) < Date.parse(Date()))
                                            <span class="status_box bg-warning">Upcoming</span>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $rides->links('pagination.new_design') }}
            </div>
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
@stop
