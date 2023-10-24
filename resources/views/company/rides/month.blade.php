@extends('company.layouts.app')
<style>
    .fc-h-event {
        background-color: {{ !empty($companyInfo['ride_color']) ?  $companyInfo['ride_color']  : '#356681 !important'}};
        border: {{ !empty($companyInfo['ride_color']) ? '1px solid ' .$companyInfo['ride_color'] . '!important'  : '#356681 !important'}};
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
            <h1 class="main_heading">My Booking</h1>
            <form method="GET" class="form-inline" name="filter_form">
                <div class="row m-0 w-100 fileterrow">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <nav aria-label="breadcrumb" class="pageBreadcrumb">
                            <ol class="breadcrumb tab_lnks mb-0">
                            <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'month' ? 'active' : '' }}" href="{{ route('company.rides',['month','status' => \Request::get('status'),'user_id' => \Request::get('user_id')]) }}">Month View</a></li>
                                <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'list' ? 'active' : '' }}" href="{{ route('company.rides',['list','status' => \Request::get('status'),'user_id' => \Request::get('user_id')]) }}">List View</a></li>
                                <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'week' ? 'active' : '' }}" href="{{ route('company.rides',['week','status' => \Request::get('status'),'user_id' => \Request::get('user_id')]) }}">Week View</a></li>
                            </ol>
                        </nav>
                    </div>
                    @php    
                        $userId = !empty(request()->get('user_id')) ? request()->get('user_id') : '';
                        $getStatus = isset(request()->status) && request()->status != '' ? request()->get('status') : '';
                    @endphp
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="custom_form d-flex">
                            <div class="form-group">
                                <select class="form-select selectusers" id="__allUsersFilterId" name="user_id">
                                    <option value="">--All Users--</option>
                                    @foreach ($users as $user)
                                        {{ $sel = $user->id == $userId ? 'selected' : ''}}
                                        <option value="{{ $user->id }}" {{$sel}}>
                                            {{ $user->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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

            var status = getUrlParameter('status');
            var user_id = getUrlParameter('user_id');
            var fUser = user_id ? user_id : '';
            var fStatus = status ? status : '';

            
            var calendar = new FullCalendar.Calendar(calendarEl, {
                events:
                [
                    @foreach ($rides as $ride)
                        {
                            ride_id: "{{ $ride->id }}",
                           // title: '{{ @$ride->user->first_name.' '.@$ride->user->last_name }} {{ @$ride->vehicle->vehicle_number_plate?' - '.@$ride->vehicle->vehicle_number_plate:'' }} ({{ date('H:i',strtotime($ride->ride_time)) }})',
                            title: '{{ @$ride->user->first_name ? @$ride->user->first_name.' '.@$ride->user->last_name : @$ride->pickup_address }} ({{ date('H:i',strtotime($ride->ride_time)) }})',
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
                },
                eventClick: function(info)
                {
                    showRideModal(info.event.extendedProps.ride_id,'rideDetails');
                }
            });
            calendar.render();

            $(document).on('click', 'button.fc-prev-button, button.fc-next-button, button.fc-today-button', function () {
                setTimeout(() => {
                    var currentDate = calendar.view.currentStart;
                    var year = currentDate.getFullYear();
                    var month =  (currentDate.getMonth() + 1).toLocaleString('en-US', {
                                minimumIntegerDigits: 2,
                                useGrouping: false
                            });

                     //alert('Year is ' + year + ' Month is ' + month);
                    //window.location.href = "{{ route('company.rides','month') }}?m="+year+"-"+month+"-01";
                    window.location.href = "{{ route('company.rides','month') }}?m="+year+"-"+month+"-01&status="+fStatus+"&user_id="+fUser;
                   // window.location.href = "{{ route('company.rides','week') }}?w="+year+"-"+month+"-"+day;

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
                $("#__filterMonthDate").val(month ? month : '');

                $('#__allUsersFilterId,#__allStatusFilterId').on('change', function() {
                    var $form = $(this).closest('form');
                    $form.find('input[type=submit]').click();
                });
            });
        }

           
    </script>
@endsection
