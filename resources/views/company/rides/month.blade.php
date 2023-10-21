@extends('company.layouts.app')
<style>
    

    .fc-h-event {
        background-color: {{ !empty($companyInfo['header_color']) ?  $companyInfo['header_color'] : '#fc4c02 !important'}};
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
            <div class="row m-0 w-100 fileterrow">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <nav aria-label="breadcrumb" class="pageBreadcrumb">
                        <ol class="breadcrumb tab_lnks mb-0">
                            <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'month' ? 'active' : '' }}" href="{{ route('company.rides','month') }}">Month View</a></li>
                            <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'list' ? 'active' : '' }}" href="{{ route('company.rides','list') }}">List View</a></li>
                            <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'week' ? 'active' : '' }}" href="{{ route('company.rides','week') }}">Week View</a></li>

                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="custom_form d-flex">
                        <div class="form-group">
                            <select class="form-select selectusers">
                                <option value="">--Search User--</option>
                                <option value="rahul">Rahul</option>
                                <option value="manish">Manish</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-select selectusers">
                                <option value="">--Select Status--</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="complete">Complete</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                  
                </div>
            </div>
           
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
            var calendarEl = document.getElementById('calendar');
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
            $(document).on('click', 'button.fc-prev-button, button.fc-next-button', function () {

                setTimeout(() => {
                    var currentDate = calendar.view.currentStart;
                    var year = currentDate.getFullYear();
                    var month =  (currentDate.getMonth() + 1).toLocaleString('en-US', {
                                minimumIntegerDigits: 2,
                                useGrouping: false
                            });

                    // alert('Year is ' + year + ' Month is ' + month);
                    window.location.href = "{{ route('company.rides','month') }}?m="+year+"-"+month+"-01";
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
        }

           
                </script>
@endsection
