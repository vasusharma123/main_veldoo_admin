@extends('guest.layouts.app')
@section('css')
<style>
    .fc-h-event {
        background-color: #fc4c02 !important;
        border: 1px solid #fc4c02 !important;
    }
</style>
@endsection
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
            <h1 class="main_heading">My Booking</h1>
            <form method="GET" class="form-inline" name="filter_form">
                <div class="row m-0 w-100 fileterrow">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <nav aria-label="breadcrumb" class="pageBreadcrumb">
                            <ol class="breadcrumb tab_lnks mb-0">
                                <li class="breadcrumb-item"><a class="tabs_links_btns active" href="{{ route('guest.rides',[\Request::get('slugRecord')->slug, 'month','token' => \Request::get('token'),'status' => \Request::get('status')]) }}">Month View</a></li>
                                <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'list' ? 'active' : '' }}" href="{{ route('guest.rides',[\Request::get('slugRecord')->slug, 'list', 'token' => \Request::get('token'),'status' => \Request::get('status')]) }}">List View</a></li>
                                <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'week' ? 'active' : '' }}" href="{{ route('guest.rides',[\Request::get('slugRecord')->slug, 'week', 'token' => \Request::get('token'),'status' => \Request::get('status')]) }}">Week View</a></li>
                            </ol>
                        </nav>
                    </div>
                    @php    
                        $getStatus = isset(request()->status) && request()->status != '' ? request()->get('status') : '';
                    @endphp
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="custom_form d-flex">
                            <div class="form-group">
                                <select class="form-select selectusers" id="__allStatusFilterId" name="status">
                                    <option value="">--All--</option>
                                    <option value="0" {{ $getStatus == '0' ? 'selected' : ''}}>Upcoming</option>
                                    <option value="-4" {{ $getStatus == '-4' ? 'selected' : ''}}>Pending</option>
                                    <option value="-2" {{ $getStatus == '-2' ? 'selected' : ''}}>Cancelled</option>
                                    <option value="4" {{ $getStatus == '4' ? 'selected' : ''}}>Driver Reached</option>
                                    <option value="3" {{ $getStatus == '3' ? 'selected' : ''}}>Completed</option>
                                    <option value="2" {{ $getStatus == '2' ? 'selected' : ''}}>Started</option>
                                    <option value="1" {{ $getStatus == '1' ? 'selected' : ''}}>Accepted</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form_btn text-end mobile_margin d-flex">
                       <input type="hidden" name="m" id="__filterMonthDate"/>
                       <input type="hidden" name="token" id="__filterToken"/>
                        <input type="submit" class="btn btn-default submit-button-filter-form"/>
                    </div>
                </div>
            </form>
            
            <!-- /List View -->
            <div id="monthView" class="resume">
                <div id='calendar'></div>
            </div>
        </article>
    </section>
@endsection
@section('footer_scripts')
    <script>
        if ($('#calendar').length > 0)
        {   

            var getUrlParameter = function getUrlParameter(sParam) {
                var sPageURL = window.location.search.substring(1),
                    sURLVariables = sPageURL.split('&'),
                    sParameterName,
                    i;

                for (i = 0; i < sURLVariables.length; i++) {
                    sParameterName = sURLVariables[i].split('=');

                    if (sParameterName[0] === sParam) {
                        return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                    }
                }
                return false;
            };


           
            
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                events:
                [

                    @if(!empty($rides))
                    @foreach ($rides as $ride)
                        {
                            ride_id: "{{ $ride->id }}",
                           // title: '{{ @$ride->user->first_name.' '.@$ride->user->last_name }} {{ @$ride->vehicle->vehicle_number_plate?' - '.@$ride->vehicle->vehicle_number_plate:'' }} ({{ date('H:i',strtotime($ride->ride_time)) }})',
                            title: '{{ @$ride->user->first_name ? @$ride->user->first_name.' '.@$ride->user->last_name : @$ride->pickup_address }} ({{ date('H:i',strtotime($ride->ride_time)) }})',
                            start: "{{ date('Y-m-d',strtotime($ride->ride_time)) }}",
                            end: "{{ date('Y-m-d',strtotime($ride->ride_time)) }}"
                        },
                    @endforeach
                    @endif

                ],
                initialDate: "{{ $date }}",
                themeSystem: 'bootstrap5',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    start: 'prev,today,next title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: '' // will normally be on the right. if RTL, will be on the left
                },
                eventClick: function(info)
                {
                    showRideModal(info.event.extendedProps.ride_id,'rideDetails');
                }
            });
            calendar.render();

            $('button.fc-prev-button, button.fc-next-button, button.fc-today-button').click(function() {

                let searchParams = new URLSearchParams(window.location.search);
                let token = searchParams.get('token');
                var status = getUrlParameter('status');
                var user_id = getUrlParameter('user_id');
                var fUser = user_id ? user_id : '';
                var fStatus = status ? status : '';

                setTimeout(() => {
                    var currentDate = calendar.view.currentStart;
                    var year = currentDate.getFullYear();

                    var month =  (currentDate.getMonth() + 1).toLocaleString('en-US', {
                                minimumIntegerDigits: 2,
                                useGrouping: false
                            });
                    
                    window.location.href = "{{ route('guest.rides',[\Request::get('slugRecord')->slug, 'month']) }}?token="+token+"&m="+year+"-"+month+"-01&status="+fStatus;
                    


                }, 100);
            });

            $(document).keyup(function(e) {
                if (e.keyCode == '37') {
                    // left arrow
                    $(document).find("button.fc-prev-button").trigger('click');
                } else if (e.keyCode == '39') {
                    // right arrow
                    $(document).find("button.fc-next-button").trigger('click');
                }
            });


            $(document).ready(function() {

                var month = getUrlParameter('m');
                var token = getUrlParameter('token');

                $("#__filterMonthDate").val(month ? month : '');
                $("#__filterToken").val(token ? token : '');

                $('#__allUsersFilterId,#__allStatusFilterId').on('change', function() {
                    var $form = $(this).closest('form');
                    $form.find('input[type=submit]').click();
                });
            });
        }
    </script>
@endsection
