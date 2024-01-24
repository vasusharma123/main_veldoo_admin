<!-- VIEW MODAL START -->
<section class="main_modal viewPoint">
    <article class="innersideModal">
        <div class="modalContents">
            <div class="modal_header">
                <div class="headerInput d-flex align-items-center">
                    <h4 class="modalName mb-0">Booking Details</h4>
                    <button class="closedModalBtn"><img src="{{ asset('assets/images/veldoo/closedmodal.png') }}"
                            alt="modal closed" class="cloedbtnaction"></button>
                </div>
            </div>
            <div class="modal_map_option">
                <iframe src="https://www.google.com/maps/@31.3208477,75.5858882,15z?entry=ttu"
                    class="mapviewDirection"></iframe>
            </div>
            <div class="pickup_dropoff_box">
                <ul class="loctionInformationUL">
                    <li class="pickuplocationLI">
                        <div class="box_loc_content">
                            <div class="img_LCicon">
                                <img src="{{ asset('assets/images/veldoo/dotpickup.png') }}"
                                    class="img-fluid sameIconImg mainDotpoint" alt="DotPoint" />
                            </div>
                            <div class="pickName">
                                <label class="pickLable">Pickup Point</label>
                                <p class="pickupLoc mb-0">2972 Westheimer </p>
                            </div>
                        </div>
                    </li>
                    <li class="divider_line_btwn">
                        <div class="dashedVrtLne"></div>
                    </li>
                    <li class="pickuplocationLI dropOfflist">
                        <div class="box_loc_content">
                            <div class="img_LCicon">
                                <img src="{{ asset('assets/images/veldoo/droploction.png') }}"
                                    class="img-fluid sameIconImg mainDotpoint" alt="DotPoint" />
                            </div>
                            <div class="pickName">
                                <label class="pickLable">Drop Point</label>
                                <p class="pickupLoc mb-0">Rd. Santa Ana, Illinois 85486</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!--Drop pick location end -->

            <div class="dateWithTimes">
                <div class="allcolumns">

                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/calendertime.png') }}"
                                class="img-fluid smallIconBlack calendar" alt="Calender" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">Pick a Date</label>
                            <p class="valuecontents mb-0">21/10/2023</p>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/clockTime.png') }}"
                                class="img-fluid smallIconBlack clock" alt="clock" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">Pick a Time</label>
                            <p class="valuecontents mb-0">06:00 PM</p>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/clockTime.png') }}"
                                class="img-fluid smallIconBlack clock" alt="clock" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">Alert</label>
                            <p class="valuecontents mb-0">00:10</p>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Date Time End -->

            <div class="dirverwithRider">
                <div class="allcolumns">

                    <div class="iconViewItem">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Driver Details</label>
                            <div class="imgBox_info">
                                <div class="imgBox_img">
                                    <img src="{{ asset('assets/images/veldoo/user2.png') }}"
                                        class="img-fluid imgBoxImges Imgusers" alt="users" />
                                </div>
                                <div class="imgBox_text">
                                    <p class="valuecontents mb-0">21/10/2023</p>
                                    <p class="subvalueText mb-0"><a href="#">+91 9563256484</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Ride Type</label>
                            <div class="imgBox_info">
                                <div class="imgBox_img">
                                    <img src="{{ asset('assets/images/veldoo/carselect.png') }}"
                                        class="img-fluid imgBoxImges Imgusers" alt="users" />
                                </div>
                                <div class="imgBox_text">
                                    <p class="valuecontents mb-0">21/10/2023</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Box Icon end -->




                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Driver With RIder ENd-->

            <div class="personDetails">
                <div class="allcolumns">

                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/perons.png') }}"
                                class="img-fluid smallIconBlack perosn" alt="User" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">No.</label>
                            <p class="valuecontents mb-0">1</p>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">

                        <div class="iconmaincontents">
                            <label class="labeltops">Passenger</label>
                            <p class="valuecontents mb-0">Aman Verma</p>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Company</label>
                            <div class="imgBox_info">
                                <div class="imgBox_img">
                                    <img src="{{ asset('assets/images/veldoo/sbb.png') }}"
                                        class="img-fluid imgBoxImges compLogo" alt="users" />
                                </div>
                                <div class="imgBox_text companyName">
                                    <p class="valuecontents mb-0">SBB Cargo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Person Details End-->


            <div class="payAmountDetails">
                <div class="allcolumns">

                    <div class="iconViewItem ">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Payment Method</label>
                            <div class="imgBox_info">
                                <div class="imgBox_img">
                                    <img src="{{ asset('assets/images/veldoo/cards.png') }}"
                                        class="img-fluid imgBoxImges cardlogo" alt="card" />
                                </div>
                                <div class="imgBox_text companyName">
                                    <p class="valuecontents mb-0">Cash</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                    <div class="iconViewItem AmountBlock">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Amount</label>
                            <div class="imgBox_info">
                                <div class="imgBox_img">
                                    <img src="{{ asset('assets/images/veldoo/cards.png') }}"
                                        class="img-fluid imgBoxImges cardlogo" alt="card" />
                                </div>
                                <div class="imgBox_text companyName">
                                    <p class="valuecontents mb-0">CHF 35</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Person Details End-->


            <div class="NotesSite">
                <div class="allcolumns">

                    <div class="iconViewItem">

                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Note</label>
                            <p class="valuecontents">Be on time. Don’t want to get late.</p>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- NotesSite End-->



        </div>
    </article>
</section>
<!-- /VIEW MODAL START -->


<!-- ADD MODAL START -->
<section class="main_modal EditPoint">
    <article class="innersideModal">
        <form method="post" class="add_details_form" id="booking_list_form">
            @csrf
        <div class="modalContents">
            <div class="modal_header">
                <div class="headerInput d-flex align-items-center">
                    <h4 class="modalName mb-0">Book a Ride</h4>
                    <button class="closedModalBtn" type="button"><img
                            src="{{ asset('assets/images/veldoo/closedmodal.png') }}" alt="modal closed"
                            class="cloedbtnaction"></button>
                </div>
            </div>
            <div class="rideBookBtn mt-4 mb-4 text-end">
                <button type="button" class="bookBtn save_booking">Book Ride</button>
            </div>
            <div class="pickup_dropoff_box">
                <ul class="loctionInformationUL">
                    <li class="pickuplocationLI">
                        <div class="box_loc_content">
                            <div class="img_LCicon">
                                <img src="{{ asset('assets/images/veldoo/dotpickup.png') }}"
                                    class="img-fluid sameIconImg mainDotpoint" alt="DotPoint" />
                            </div>
                            <div class="pickName w-100">
                                <label class="pickLable">Pickup Point</label>
                                <input type="search"
                                    class="form-control pickupfield pickupLoc mb-0 p-0 border-0 w-100 inputField"
                                    name="pickup_address" id="pickupPoint" placeholder="Enter pickup point" required
                                    autocomplete="off">
                                <input type="hidden" id="pickup_latitude" name="pick_lat" value="">
                                <input type="hidden" id="pickup_longitude" name="pick_lng" value="">
                            </div>
                        </div>
                    </li>
                    <li class="divider_line_btwn position-relative">
                        <div class="dashedVrtLne"></div>
                        <div class="revers_line">
                            <span class="separationline"></span>
                            <img src="{{ asset('assets/images/veldoo/reverseimages.png') }}"
                                class="img-fluid reverseLine" alt="reverse" />
                        </div>
                    </li>
                    <li class="pickuplocationLI dropOfflist">
                        <div class="box_loc_content">
                            <div class="img_LCicon">
                                <img src="{{ asset('assets/images/veldoo/droploction.png') }}"
                                    class="img-fluid sameIconImg mainDotpoint" alt="DotPoint" />
                            </div>
                            <div class="pickName w-100">
                                <label class="pickLable">Drop Point</label>
                                <input type="search"
                                    class="form-control dropfield pickupLoc mb-0 p-0 border-0 w-100 inputField"
                                    name="dest_address" id="dropoffPoint" autocomplete="off"
                                    placeholder="Enter drop point">
                                <input type="hidden" id="dropoff_latitude" name="dest_lat" value="">
                                <input type="hidden" id="dropoff_longitude" name="dest_lng" value="">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <!--Drop pick location end -->

            <div class="dateWithTimes">
                <div class="allcolumns">

                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/calendertime.png') }}"
                                class="img-fluid smallIconBlack calendar" alt="Calender" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">Pick a Date</label>

                            <input type="text"
                                class="form-control smfields valuecontents mb-0 p-0 border-0 inputField"
                                value="<?php echo date("Y-m-d") ?>" id="pickUpDateRide" name="ride_date" required>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/clockTime.png') }}"
                                class="img-fluid smallIconBlack clock" alt="clock" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">Pick a Time</label>
                            <input type="time"
                                class="form-control mdFields valuecontents mb-0 p-0 border-0 inputField"
                                value="<?php echo date("H:i") ?>" name="ride_time" required>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/clockTime.png') }}"
                                class="img-fluid smallIconBlack clock" alt="clock" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">Alert</label>
                            <input type="text" id="time"
                                class="form-control smFields valuecontents mb-0 p-0 border-0 inputField"
                                value="00:00" name="alert">
                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Date Time End -->

            <div class="dirverwithRider">
                <div class="allcolumns">
                    @foreach ($vehicle_types as $key => $vehicle_type)
                        <div class="iconViewItem">
                            <div class="iconmaincontents ms-0">
                                <div class="imgBox_Car text-center">
                                    <div class="imgBox_img position-relative carimgBoxes">
                                        @if (!empty($vehicle_type->car_type) && file_exists($vehicle_type->image_with_url))
                                            <img src="{{ $vehicle_type->image_with_url }}" class="img-fluid carimage"
                                                alt="Vehicle" />
                                        @else
                                            <img src="{{ asset('assets/images/veldoo/regularcar.png') }}"
                                                class="img-fluid carimage" alt="Vehicle" />
                                        @endif

                                        <input type="radio" name="car_type" id="rgCar" class="hiddenFields"
                                            value="{{ $vehicle_type->car_type }}"
                                            data-basic_fee="{{ $vehicle_type->basic_fee }}"
                                            data-price_per_km="{{ $vehicle_type->price_per_km }}"
                                            data-seating_capacity="{{ $vehicle_type->seating_capacity }}"
                                            data-text="{{ $vehicle_type->car_type }}"
                                            {{ $key == 0 ? 'checked' : '' }} required>
                                    </div>
                                    <div class="imgBox_text m-0">
                                        <p class="valuecontents mb-0 mt-2">{{ $vehicle_type->car_type }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Driver With RIder ENd-->

            <div class="personDetails">
                <div class="allcolumns">

                    <div class="iconViewItem">
                        <div class="img_ICM">
                            <img src="{{ asset('assets/images/veldoo/perons.png') }}"
                                class="img-fluid smallIconBlack perosn" alt="User" />
                        </div>
                        <div class="iconmaincontents">
                            <label class="labeltops">No.</label>
                            <input type="number" name="passanger"
                                class="form-control smFieldsnumber valuecontents mb-0 p-0 border-0 inputField"
                                min="1" value="1">
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">

                        <div class="iconmaincontents">
                            <label class="labeltops">Passenger</label>
                            <select name="user_id" class="form-control mdFields valuecontents mb-0 p-0 border-0 inputField">
                                <option value="">-select passenger-</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->full_name }}{{ !empty($user->phone) ? ' (+' . $user->country_code . '-' . $user->phone . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Box Icon end -->


                    <div class="iconViewItem">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Company</label>
                            <select name="company_id" class="form-control mdFields valuecontents mb-0 p-0 border-0 inputField">
                                <option value="">-select Company-</option>
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Person Details End-->

            <div class="payAmountDetails">
                <div class="allcolumns">

                    <div class="iconViewItem ">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Payment Method</label>
                            <select name="payment_type" class="form-select valuecontents mb-0">
                                {{-- <option value=""></option> --}}
                                @foreach ($payment_types as $payment_type)
                                    <option value="{{ $payment_type->name }}">{{ $payment_type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                    <div class="iconViewItem">
                        <div class="iconmaincontents ms-0 ">
                            <label class="labeltops">Amount</label>
                            <div class="chfFiled">
                                <input type="text" name="ride_cost" class="form-control valuecontents mdFields chftext"
                                    placeholder="">
                            </div>

                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- Person Details End-->

            <div class="NotesSite">
                <div class="allcolumns">
                    <div class="iconViewItem w-100 d-block">
                        <div class="iconmaincontents ms-0">
                            <label class="labeltops">Note</label>
                            <textarea name="note" class="form-control valuecontents textnotest" cols="20" rows="5"></textarea>
                        </div>
                    </div>
                    <!-- Box Icon end -->

                </div>
                <!-- Icon Box Flex end -->
            </div>
            <!-- NotesSite End-->

            <div class="map_frame" style="margin-top: 50px;padding:0px">
                <div id="googleMapNewBooking" class="googleMapDesktop"></div>
            </div>
            <input type="hidden" name="route" class="ride_route" id="ride_route">

        </div>
        </form>
    </article>
</section>
<!-- /ADD MODAL START -->
