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
                                <tr class="rideDetails" data-id="{{ $ride->id }}" style="cursor: pointer">
                                    <td class="btn_view_booking dateTimeList{{ $ride->id }}">
                                        {{ date('D, d.m.Y',strtotime($ride->ride_time)) }} {{ date('H:i',strtotime($ride->ride_time)) }}
                                    </td>
                                    <td style="max-width:200px" class="pickupPointList{{ $ride->id }}">{{ $ride->pickup_address }}</td>
                                    <td class="sm_hide carList{{ $ride->id }}">{{ @$ride->vehicle->vehicle_number_plate }}</td>
                                    <td class="sm_hide customerList{{ $ride->id }}">{{ @$ride->user->first_name.' '.@$ride->user->last_name }}</td>
                                    <td class="sm_hide statusList{{ $ride->id }}">
                                        @if($ride->status == -2)
                                            <span class="status_box text-white bg-danger">Cancelled</span>
                                        @elseif($ride->status == -1)
                                            <span class="status_box text-white bg-danger">Rejected</span>
                                        @elseif($ride->status == 1)
                                            <span class="status_box text-white bg-info">Accepted</span>
                                        @elseif($ride->status == 2)
                                            <span class="status_box text-white bg-info">Started</span>
                                        @elseif($ride->status == 4)
                                            <span class="status_box text-white bg-info">Driver Reached</span>
                                        @elseif($ride->status == 3)
                                            <span class="status_box text-white bg-success">Completed</span>
                                        @elseif($ride->status == -3)
                                            <span class="status_box text-white bg-danger">Cancelled by you</span>
                                        @elseif($ride->status == 0)
                                            <span class="status_box text-white bg-warning">Pending</span>
                                        @elseif(Date.parse($ride->ride_time) < Date.parse(Date()))
                                            <span class="status_box text-white bg-warning">Upcoming</span>
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
@stop
