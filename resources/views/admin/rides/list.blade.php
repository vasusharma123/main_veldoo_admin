@extends('admin.layouts.master')

@section('css')
    <!-- TelePhone -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" rel="stylesheet"/>
<style>
    #googleMapNewBooking {
                background: #dfdfdf;
                max-height: 250px;
                border-radius: 10px;
                height: 100%;
                min-height: 250px;
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
                @include('admin.rides.includes.topbar_tabs_links')
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
            </div>
        </div>

        @include('admin.rides.includes.modal')

    </div>
    <!-- Form Table -->

@endsection

@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js"></script>
    @include('admin.rides.includes.scripts')
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
            window.location.href = "{{ route('rides.list') }}?start_date="+start_date+"&end_date="+end_date+"&search="+search;
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
