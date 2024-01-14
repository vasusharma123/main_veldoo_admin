@extends('admin.layouts.master')

@section('css')
    <!-- TelePhone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
@endsection

@section('header_menu_list')
<button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
<ul class="nav top_tab_menu target">
    <li class="nav-item">
        <a class="nav-link" href="{{ route('rides.index') }}">Ride List</a>
    </li>
</ul>
@endsection


@section('header_search_export')
<form class="right_content_menu" action="{{ route('rides.export') }}">
    <div class="editBtnDate d-flex">
        <i class="bi bi-calendar calendarIo iconExportLink"></i>
        <div class="inputbxs d-flex">
            <input class="form-control dateinput startdate" placeholder="Start Date" name="start_date" class="textbox-n"
                type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="Stdate" value="{{$start_date}}"/>
            <input type="date" class="form-control dateinput endDate" placeholder="End Date" name="end_date"
                class="textbox-n" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="Endate" value="{{$end_date}}"/>
        </div>
    </div>
    <div class="search">
        <div class="search_form">
            <div class="form-group searchinput position-relative trigger_parent">
                <input type="text" name="search" class="form-control input_search target myInput"
                    placeholder="Search" id="search_filter" value="{{ $search }}"/>
                <i class="bi bi-search search_icons"></i>
            </div>
        </div>
    </div>
    <div class="bookBtnBox">
        <button type="button" class="openbook bookBtn p-0"><i class="bi bi-plus-circle-fill topplusicon"></i> <span>Book Ride</span></button>
    </div>
    <div class="export_box">
        <button type="submit" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
    </div>
</form>
@endsection

@section('content')

    <div class="formTableContent distance_side position-relative">
        @include('admin.layouts.flash-message')
        <div class="tabs_all">
            <ul class="nav nav-tabs" id="listTabsView" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="listVise" data-bs-toggle="tab" data-bs-target="#listViewOptions"
                        type="button" role="tab" aria-controls="listViewOptions" aria-selected="true">List
                        View</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="monthVise" data-bs-toggle="tab" data-bs-target="#monthViseOptions"
                        type="button" role="tab" aria-controls="monthViseOptions" aria-selected="false">Month
                        View</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="weekVise" data-bs-toggle="tab" data-bs-target="#weekViseOptions"
                        type="button" role="tab" aria-controls="weekViseOptions" aria-selected="false">Week
                        View</button>
                </li>
            </ul>

            <div class="tab-content" id="listTabsViewContent">
                <div class="tab-pane fade show active" id="listViewOptions" role="tabpanel" aria-labelledby="listVise">
                    <section class="addonTable sectionsformM0 pt-2 pb-2">
                        <article class="container-fluid">
                            {{-- <div class="table-responsive marginTbl"> --}}

                            <table class="table table-borderless table-fixed customTable text-wrap">
                                <thead>
                                    <tr class="notcenter">
                                        <th>Date</th>
                                        <th>Driver</th>
                                        <th>Company</th>
                                        <th>Guest</th>
                                        <th>Pick Up</th>
                                        <th>Distance</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rides as $ride_key => $ride)
                                        <tr>
                                            <td>{{ date('d.m.Y', strtotime($ride->ride_time)) }}</td>
                                            <td><a href="#"
                                                    class="openviewscreen">{{ !empty($ride->driver) ? $ride->driver->full_name : '' }}</a>
                                            </td>
                                            <td>{{ !empty($ride->company) ? $ride->company->name : '' }}</td>
                                            <td>{{ !empty($ride->user) ? $ride->user->full_name : '' }}</td>
                                            <td>{{ $ride->pickup_address }}</td>
                                            <td>{{ $ride->distance }}</td>
                                            <td>{{ $ride->ride_cost }}</td>
                                            <td>
                                                @if($ride->status == -2 || $ride->status == -3)
                                                <span class="badge rounded-pill bg-danger">Cancelled</span>
                                                @elseif($ride->status == -1)
                                                <span class="badge rounded-pill bg-danger">Rejected</span>
                                                @elseif($ride->status == 1)
                                                <span class="badge rounded-pill bg-info text-dark">Accepted</span>
                                                @elseif($ride->status == 2)
                                                <span class="badge rounded-pill bg-info text-dark">Started</span>
                                                @elseif($ride->status == 4)
                                                <span class="badge rounded-pill bg-info text-dark">Driver Reached</span>
                                                @elseif($ride->status == 3)
                                                <span class="badge rounded-pill bg-success">Completed</span>
                                                @elseif($ride->status == 0)
                                                <span class="badge rounded-pill bg-warning text-dark">Upcoming</span>
                                                @elseif($ride->status == -4)
                                                <span class="badge rounded-pill pending-ride-class-row">Pending</span>
                                                @elseif(strtotime($ride->ride_time) < strtotime('now'))
                                                <span class="badge rounded-pill bg-warning text-dark">Upcoming</span>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $rides->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
                            {{-- </div> --}}
                        </article>
                    </section>
                </div>
                <!-- List View Closed -->

                <div class="tab-pane fade" id="monthViseOptions" role="tabpanel" aria-labelledby="monthVise">
                    <div class="monthly_calneder">
                        <div id='calendar'></div>

                    </div>
                </div>
                <div class="tab-pane fade" id="weekViseOptions" role="tabpanel" aria-labelledby="weekVise">
                    <div class="weekly_calneder">
                        <div id='calendar1'></div>

                    </div>
                </div>
            </div>
        </div>

        <!-- VIEW MODAL START -->
        <section class="main_modal viewPoint">
            <article class="innersideModal">
                <div class="modalContents">
                    <div class="modal_header">
                        <div class="headerInput d-flex align-items-center">
                            <h4 class="modalName mb-0">Booking Details</h4>
                            <button class="closedModalBtn"><img src="assets/imgs/closedmodal.png" alt="modal closed"
                                    class="cloedbtnaction"></button>
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
                                        <img src="assets/imgs/dotpickup.png" class="img-fluid sameIconImg mainDotpoint"
                                            alt="DotPoint" />
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
                                        <img src="assets/imgs/droploction.png" class="img-fluid sameIconImg mainDotpoint"
                                            alt="DotPoint" />
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
                                    <img src="assets/imgs/calendertime.png" class="img-fluid smallIconBlack calendar"
                                        alt="Calender" />
                                </div>
                                <div class="iconmaincontents">
                                    <label class="labeltops">Pick a Date</label>
                                    <p class="valuecontents mb-0">21/10/2023</p>
                                </div>
                            </div>
                            <!-- Box Icon end -->


                            <div class="iconViewItem">
                                <div class="img_ICM">
                                    <img src="assets/imgs/clockTime.png" class="img-fluid smallIconBlack clock"
                                        alt="clock" />
                                </div>
                                <div class="iconmaincontents">
                                    <label class="labeltops">Pick a Time</label>
                                    <p class="valuecontents mb-0">06:00 PM</p>
                                </div>
                            </div>
                            <!-- Box Icon end -->


                            <div class="iconViewItem">
                                <div class="img_ICM">
                                    <img src="assets/imgs/clockTime.png" class="img-fluid smallIconBlack clock"
                                        alt="clock" />
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
                                            <img src="assets/imgs/user2.png" class="img-fluid imgBoxImges Imgusers"
                                                alt="users" />
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
                                            <img src="assets/imgs/carselect.png" class="img-fluid imgBoxImges Imgusers"
                                                alt="users" />
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
                                    <img src="assets/imgs/perons.png" class="img-fluid smallIconBlack perosn"
                                        alt="User" />
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
                                            <img src="assets/imgs/sbb.png" class="img-fluid imgBoxImges compLogo"
                                                alt="users" />
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
                                            <img src="assets/imgs/cards.png" class="img-fluid imgBoxImges cardlogo"
                                                alt="card" />
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
                                            <img src="assets/imgs/cards.png" class="img-fluid imgBoxImges cardlogo"
                                                alt="card" />
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


        <!-- EDIT MODAL START -->
        <section class="main_modal EditPoint">
            <article class="innersideModal">
                <div class="modalContents">
                    <div class="modal_header">
                        <div class="headerInput d-flex align-items-center">
                            <h4 class="modalName mb-0">Book a Ride</h4>
                            <button class="closedModalBtn" type="submit"><img src="assets/imgs/closedmodal.png"
                                    alt="modal closed" class="cloedbtnaction"></button>
                        </div>
                    </div>
                    <div class="rideBookBtn mt-4 mb-4 text-end">
                        <button class="bookBtn">Book Ride</button>
                    </div>
                    <div class="pickup_dropoff_box">
                        <ul class="loctionInformationUL">
                            <li class="pickuplocationLI">
                                <div class="box_loc_content">
                                    <div class="img_LCicon">
                                        <img src="assets/imgs/dotpickup.png" class="img-fluid sameIconImg mainDotpoint"
                                            alt="DotPoint" />
                                    </div>
                                    <div class="pickName w-100">
                                        <label class="pickLable">Pickup Point</label>
                                        <input type="search"
                                            class="form-control pickupfield pickupLoc mb-0 p-0 border-0 w-100 inputField"
                                            value="2972 Westheimer ">
                                    </div>
                                </div>
                            </li>
                            <li class="divider_line_btwn position-relative">
                                <div class="dashedVrtLne"></div>
                                <div class="revers_line">
                                    <span class="separationline"></span>
                                    <img src="assets/imgs/reverseimages.png" class="img-fluid reverseLine"
                                        alt="reverse" />
                                </div>
                            </li>
                            <li class="pickuplocationLI dropOfflist">
                                <div class="box_loc_content">
                                    <div class="img_LCicon">
                                        <img src="assets/imgs/droploction.png" class="img-fluid sameIconImg mainDotpoint"
                                            alt="DotPoint" />
                                    </div>
                                    <div class="pickName w-100">
                                        <label class="pickLable">Drop Point</label>
                                        <input type="search"
                                            class="form-control dropfield pickupLoc mb-0 p-0 border-0 w-100 inputField"
                                            value="Rd. Santa Ana, Illinois 85486">

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
                                    <img src="assets/imgs/calendertime.png" class="img-fluid smallIconBlack calendar"
                                        alt="Calender" />
                                </div>
                                <div class="iconmaincontents">
                                    <label class="labeltops">Pick a Date</label>

                                    <input type="date"
                                        class="form-control smfields valuecontents mb-0 p-0 border-0 inputField"
                                        value="">
                                </div>
                            </div>
                            <!-- Box Icon end -->


                            <div class="iconViewItem">
                                <div class="img_ICM">
                                    <img src="assets/imgs/clockTime.png" class="img-fluid smallIconBlack clock"
                                        alt="clock" />
                                </div>
                                <div class="iconmaincontents">
                                    <label class="labeltops">Pick a Time</label>
                                    <input type="time"
                                        class="form-control mdFields valuecontents mb-0 p-0 border-0 inputField"
                                        value="">
                                </div>
                            </div>
                            <!-- Box Icon end -->


                            <div class="iconViewItem">
                                <div class="img_ICM">
                                    <img src="assets/imgs/clockTime.png" class="img-fluid smallIconBlack clock"
                                        alt="clock" />
                                </div>
                                <div class="iconmaincontents">
                                    <label class="labeltops">Alert</label>
                                    <input type="text" id="time"
                                        class="form-control smFields valuecontents mb-0 p-0 border-0 inputField"
                                        value="00:00">
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
                                    <div class="imgBox_Car text-center">
                                        <div class="imgBox_img position-relative carimgBoxes">
                                            <img src="assets/imgs/regularcar.png" class="img-fluid carimage"
                                                alt="Regular Car" />
                                            <input type="radio" name="carSelection" id="rgCar"
                                                class="hiddenFields">
                                        </div>
                                        <div class="imgBox_text m-0">
                                            <p class="valuecontents mb-0 mt-2">Regular</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Box Icon end -->

                            <div class="iconViewItem">
                                <div class="iconmaincontents ms-0">
                                    <div class="imgBox_Car text-center">
                                        <div class="imgBox_img position-relative carimgBoxes">
                                            <img src="assets/imgs/mediumcar.png" class="img-fluid carimage"
                                                alt="Medium Car" />
                                            <input type="radio" name="carSelection" id="rgCar"
                                                class="hiddenFields">
                                        </div>
                                        <div class="imgBox_text m-0">
                                            <p class="valuecontents mb-0 mt-2">Medium</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Box Icon end -->


                            <div class="iconViewItem">
                                <div class="iconmaincontents ms-0">
                                    <div class="imgBox_Car text-center">
                                        <div class="imgBox_img position-relative carimgBoxes">
                                            <img src="assets/imgs/bigcar.png" class="img-fluid carimage"
                                                alt="Mini Bus " />
                                            <input type="radio" name="carSelection" id="rgCar"
                                                class="hiddenFields">
                                        </div>
                                        <div class="imgBox_text m-0">
                                            <p class="valuecontents mb-0 mt-2">Minibus</p>
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
                                    <img src="assets/imgs/perons.png" class="img-fluid smallIconBlack perosn"
                                        alt="User" />
                                </div>
                                <div class="iconmaincontents">
                                    <label class="labeltops">No.</label>
                                    <input type="number"
                                        class="form-control smFieldsnumber valuecontents mb-0 p-0 border-0 inputField"
                                        min="1" value="1">
                                </div>
                            </div>
                            <!-- Box Icon end -->


                            <div class="iconViewItem">

                                <div class="iconmaincontents">
                                    <label class="labeltops">Passenger</label>
                                    <select class="form-control mdFields valuecontents mb-0 p-0 border-0 inputField">
                                        <option value="">-select passenger-</option>
                                        <option value="aman">Aman Verma</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Box Icon end -->


                            <div class="iconViewItem">
                                <div class="iconmaincontents ms-0">
                                    <label class="labeltops">Company</label>
                                    <select class="form-control mdFields valuecontents mb-0 p-0 border-0 inputField">
                                        <option value="">-select Company-</option>
                                        <option value="aman">SBB Cargo</option>
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
                                    <select class="form-select valuecontents mb-0">
                                        <option value=""></option>
                                        <option value="aman">SBB Cargo</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Box Icon end -->



                            <!-- Box Icon end -->


                            <div class="iconViewItem">
                                <div class="iconmaincontents ms-0 ">
                                    <label class="labeltops">Amount</label>
                                    <div class="chfFiled">
                                        <input type="text" class="form-control valuecontents mdFields chftext"
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
                                    <textarea class="form-control valuecontents textnotest" cols="20" rows="5"></textarea>
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
        <!-- /EDIT MODAL START -->

    </div>
    <!-- Form Table -->

@endsection

@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
    <script>
        $('#monthVise').on('click', function() {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'dayGridMonth',
                events: '/api/demo-feeds/events.json',
                editable: true,
                selectable: true
            });

            calendar.render();
        });
        $('#weekVise').on('click', function() {

            var calendarEl = document.getElementById('calendar1');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                events: '/api/demo-feeds/events.json'
            });

            calendar.render();
        });
        $('#time').timepicker({
            'timeFormat': 'H:i'
        });

        function applyFilter(){
            var start_date = $("#Stdate").val();
            var end_date = $("#Endate").val();
            var search = $("#search_filter").val();
            window.location.href = "{{ route('rides.index','list') }}?start_date="+start_date+"&end_date="+end_date+"&search="+search;
        }

        $(document).on("change","#Stdate,#Endate", function(){
            applyFilter();
        })

        $("#search_filter").keypress(function(e) {
            if(e.which == 13) {
                e.preventDefault();
                applyFilter();
            }
        });

    </script>
@stop
