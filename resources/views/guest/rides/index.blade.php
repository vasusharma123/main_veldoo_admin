@extends('guest.layouts.app')
<style>

.table_box { overflow: auto; height: 600px; }
.table_box thead th { position: sticky; top: 0; z-index: 1; }

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
    <section class="table_all_content">
        <article class="table_container top_header_text">
            <h1 class="main_heading">My Booking</h1>
            <form method="GET" class="form-inline" name="filter_form">
                <div class="row m-0 w-100 fileterrow">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <nav aria-label="breadcrumb" class="pageBreadcrumb">
                            <ol class="breadcrumb tab_lnks mb-0">
                                @if(\Request::get('token'))
                                <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'month' ? 'active' : '' }}" href="{{ route('guest.rides',['month','token' => \Request::get('token')]) }}">Month View</a></li>
                                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'list' ? 'active' : '' }}" href="{{ route('guest.rides',['list','token' => \Request::get('token')]) }}">List View</a></li>
                                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'week' ? 'active' : '' }}" href="{{ route('guest.rides',['week','token' => \Request::get('token')]) }}">Week View</a></li>
                                @else 
                                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'month' ? 'active' : '' }}" href="{{ route('guest.rides','month') }}">Month View</a></li>
                                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'list' ? 'active' : '' }}" href="{{ route('guest.rides','list') }}">List View</a></li>
                                    <li class="breadcrumb-item"><a class="tabs_links_btns {{ \Request::segment(3) == 'week' ? 'active' : '' }}" href="{{ route('guest.rides','week') }}">Week View</a></li>
                                @endif

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
                       <input type="hidden" name="token" id="__filterToken"/>
                        <input type="submit" class="btn btn-default submit-button-filter-form"/>
                    </div>
                </div>
            </form>
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

                            @if(!empty($rides))
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
                                    <td class="sm_hide customerList{{ $ride->id }}">{{ @$ride->user->first_name .' '. @$ride->user->last_name }}</td>
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
                            @endif

                        </tbody>
                    </table>
                </div>
                @if(!empty($rides))
                {{ $rides->links('pagination.new_design') }}
                @endif
            </div>
        </article>
    </section>
@stop
@section('footer_scripts')
<script>

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
    $(document).ready(function() {

        var token = getUrlParameter('token');
        $("#__filterToken").val(token ? token : '');

        $('#__allUsersFilterId,#__allStatusFilterId').on('change', function() {
            var $form = $(this).closest('form');
            $form.find('input[type=submit]').click();
        });
    });
</script>
@endsection