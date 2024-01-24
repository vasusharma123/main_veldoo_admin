@extends('admin.layouts.master')

@section('css')
    <!-- TelePhone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    <style>
        .fc-h-event {
            background-color: var(--primary-ride-color);
            border: var(--primary-ride-color);
        }
    </style>
@endsection

@section('header_menu_list')
    <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
    <ul class="nav top_tab_menu target">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('rides.list') }}">Ride List</a>
        </li>
    </ul>
@endsection


@section('header_search_export')

@endsection

@section('content')

    <div class="formTableContent distance_side position-relative">
        @include('admin.layouts.flash-message')
        <div class="tabs_all">
            <ul class="nav nav-tabs" id="listTabsView" role="tablist">
                @include('admin.rides.includes.topbar_tabs_links')
            </ul>

            <div class="tab-content" id="listTabsViewContent">
                <div class="tab-pane fade show active" id="weekViseOptions" role="tabpanel" aria-labelledby="weekVise">
                    <div class="weekly_calneder">
                        <div id='calendar1'></div>

                    </div>
                </div>
            </div>
        </div>

        @include('admin.rides.includes.modal')

    </div>
    <!-- Form Table -->

@endsection

@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
    <!-- Calendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        $('#time').timepicker({
            'timeFormat': 'H:i'
        });

        if ($('#calendar1').length > 0) {
            var calendarEl = document.getElementById('calendar1');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                events: [
                    @foreach ($rides as $ride)
                        {
                            ride_id: "{{ $ride->id }}",
                            // title: '{{ @$ride->user->first_name . ' ' . @$ride->user->last_name }} {{ @$ride->vehicle->vehicle_number_plate ? ' - ' . @$ride->vehicle->vehicle_number_plate : '' }} ({{ date('H:i', strtotime($ride->ride_time)) }})',
                            title: '{{ @$ride->user->first_name ? @$ride->user->first_name . ' ' . @$ride->user->last_name : @$ride->pickup_address }} ({{ date('H:i', strtotime($ride->ride_time)) }})',
                            start: "{{ date('Y-m-d', strtotime($ride->ride_time)) }}T{{ date('H:i:s', strtotime($ride->ride_time)) }}",
                            end: "{{ date('Y-m-d', strtotime($ride->ride_time)) }}T{{ date('H:i:s', strtotime($ride->ride_time)) }}"
                        },
                    @endforeach
                ],
            });
            var year = parseInt("{{ $year }}");
            var month = parseInt("{{ $month }}"); // August (0-indexed, so 7 represents August)
            var day = parseInt("{{ $day }}");
            calendar.gotoDate(new Date(year, month, day));
            calendar.render();

            $('button.fc-prev-button, button.fc-next-button, button.fc-today-button').click(function() {
                setTimeout(() => {
                    var currentDate = calendar.view.currentStart;
                    var year = currentDate.getFullYear();
                    var month = (currentDate.getMonth() + 1).toLocaleString('en-US', {
                        minimumIntegerDigits: 2,
                        useGrouping: false
                    });
                    var day = (currentDate.getDate()).toLocaleString('en-US', {
                        minimumIntegerDigits: 2,
                        useGrouping: false
                    });
                    window.location.href = "{{ route('rides.week') }}?w=" + year + "-" + month + "-" + day;
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
@stop
