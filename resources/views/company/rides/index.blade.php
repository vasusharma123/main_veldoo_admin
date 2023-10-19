@extends('company.layouts.app')

<style>

.table_box { overflow: auto; height: 600px; }
.table_box thead th { position: sticky; top: 0; z-index: 1; }

/* Just common table stuff. Really. */
table  { border-collapse: collapse; width: 100%; }
/* th, td { padding: 8px 16px; } */
th     { background:#eee; }

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

    <!-- <section class="">
        <article class="form_inside">
            <div class="form_add_managers">
                <form class="add_managers inside_custom_form " action="{{ route('company-users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid form_container">
                        <div class="row m-0 w-100">
                            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                                <div class="row w-100 m-0 gx-2">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings user_info mb-2">
                                        <input type="hidden" class="form-control inside_input_field mb-2" name="user_status" value="0">
                                        <input type="text" class="form-control main_field" name="first_name" placeholder="First Name" aria-label="First Name" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings user_info mb-2">
                                        <input type="text" class="form-control main_field" name="last_name" placeholder="Last Name" aria-label="Last Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 col-12 ">
                                <div class="form_btn text-end mobile_margin user_info">
                                    <button type="submit" class="btn save_form_btn">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </article>
    </section> -->
    <section class="table_all_content">
        <article class="table_container top_header_text">
            <h1 class="main_heading">History</h1>
            <nav aria-label="breadcrumb" class="pageBreadcrumb">
                <ol class="breadcrumb tab_lnks">
                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'month' ? 'active' : '' }}" href="{{ route('company.rides','month') }}">Month View</a></li>
                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'list' ? 'active' : '' }}" href="{{ route('company.rides','list') }}">List View</a></li>
                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'week' ? 'active' : '' }}" href="{{ route('company.rides','week') }}">Week View</a></li>
                </ol>
                <form method="GET" class="form-inline">
                    <div class="col-lg-2 col-md-2 col-sm-3 col-3 col_form_settings mb-2">
                        <div class="form-check position-relative text-center p-0 ">
                            @php    
                                $userId = !empty(request()->get('user_id')) ? request()->get('user_id') : '';
                                $getStatus = isset(request()->status) && request()->status != '' ? request()->get('status') : '';

                            @endphp
                            <select class="form-control main_field fontStyle text-center p-0" name="user_id" >
                                <option value="">All User</option>
                                @foreach ($users as $user)
                                    {{ $sel = $user->id == $userId ? 'selected' : ''}}
                                    <option value="{{ $user->id }}" {{$sel}}>
                                        {{ $user->full_name }}{{ !empty($user->phone) ? ' (+' . $user->country_code . '-' . $user->phone . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            <select class="form-control main_field fontStyle text-center p-0" name="status">
                                <option value="">All</option>
                                <option value="0" {{ $getStatus == '0' ? 'selected' : ''}}>Upcoming</option>
                                <option value="-4" {{ $getStatus == '-4' ? 'selected' : ''}}>Pending</option>
                                <option value="-2" {{ $getStatus == '-2' ? 'selected' : ''}}>Cancelled</option>
                                <option value="4" {{ $getStatus == '4' ? 'selected' : ''}}>Driver Reached</option>
                                <option value="3" {{ $getStatus == '3' ? 'selected' : ''}}>Completed</option>
                                <option value="2" {{ $getStatus == '2' ? 'selected' : ''}}>Started</option>
                                <option value="1" {{ $getStatus == '1' ? 'selected' : ''}}>Accepted</option>
                            </select>
                        </div>
                        <div class="form_btn text-end mobile_margin d-flex">
                            <button type="button" class="btn btn-default reset-filter-form-data">Reset</button>
                            <button type="submit" class="btn btn-default">Search</button>
                        </div>
                    </div>
                </form>
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
                                <th class="sm_hide text-center"><span class="status_title">Status</span></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($rides as $ride)

                               @php
                                if($ride->ride_time > date("Y-m-d")){
                                    $upcomingAndPastBooking = 'upcoming-and-past-booking';
                                }
                                else if($ride->ride_time < date("Y-m-d")) {
                                    $upcomingAndPastBooking = 'upcoming-and-past-booking';
                                }
                                else {
                                    $upcomingAndPastBooking = '';
                                }
                                @endphp
                                
                                <tr class="rideDetails {{$upcomingAndPastBooking}}" data-id="{{ $ride->id }}" style="cursor: pointer">
                                    <td class="btn_view_booking dateTimeList{{ $ride->id }}">
                                        {{ date('D, d.m.Y',strtotime($ride->ride_time)) }} {{ date('H:i',strtotime($ride->ride_time)) }}
                                    </td>
                                    <td style="max-width:200px; text-overflow:ellipsis; overflow:hidden;" class="pickupPointList{{ $ride->id }}">{{ $ride->pickup_address }}</td>
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
                                            <span class="status_box text-white bg-danger">Cancelled</span>
                                        @elseif($ride->status == 0)
                                        <span class="status_box text-white bg-warning">Upcoming</span>
                                        @elseif($ride->status == -4)
                                            <span class="status_box text-white pending-ride-class-row">Pending</span>
                                        @elseif(strtotime($ride->ride_time) < strtotime('now'))
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
