@extends('master_admin.layouts.after_login')

@section('header_menu_list')
@include('master_admin.includes.service_provider_detail_header_menu_list')
@endsection

@section('content')
@php
$checkmarksImage = asset('service_provider_assets/imgs/checkmarks.png');
$unCheckmarksImage = asset('service_provider_assets/imgs/uncheckmarks.png');
@endphp
<section class="addonTable planSections">
    <article class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12 ">
                <section class="sectionsform">
                    <div class="leftcontent">
                        <h2 class="titleCards">
                            {{ucfirst($latest_plan->plan->plan_name)}} license
                        </h2>
                        <p class="numberUsers">
                            <img src="{{ asset('assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon" />
                            <span class="numberoflist">{{ $latest_plan->plan->number_of_driver }} Cars</span>
                        </p>
                        <ul class="list-group checklistcars">
                            <li class="list-group-item {{ $latest_plan->plan->organise_rides_and_bookings == 0 ? 'notused':'' }}">
                                <img src="{{ $latest_plan->plan->organise_rides_and_bookings == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Organize Rides and Bookings</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->book_rides_with_app == 0  ? 'notused' : '' }} ">
                                <img src="{{ $latest_plan->plan->book_rides_with_app == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->driver_statement == 0  ? 'notused' : '' }}">
                                <img src="{{ $latest_plan->plan->driver_statement == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Driver Statement</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->client_company_management == 0  ? 'notused' : '' }}">
                                <img src="{{ $latest_plan->plan->client_company_management == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Client / Company Management</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->export_ride_deails == 0  ? 'notused' : '' }}">
                                <img src="{{ $latest_plan->plan->export_ride_deails == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Export Ride details</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->assign_rides_to_driver == 0  ? 'notused' : '' }}">
                                <img src="{{ $latest_plan->plan->assign_rides_to_driver == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Assign Rides to drivers</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->info_notes_to_drivers == 0  ? 'notused' : '' }}">
                                <img src="{{ $latest_plan->plan->info_notes_to_drivers == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Information Notes to drivers</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->promotion_notes_to_client == 0  ? 'notused' : '' }}">
                                <img src="{{ $latest_plan->plan->promotion_notes_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Promotion Notes to clients</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->algorithm_config == 0  ? 'notused' : '' }} moreOptions">
                                <img src="{{ $latest_plan->plan->algorithm_config == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Algorithms config</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->online_company_booking == 0  ? 'notused' : '' }} moreOptions">
                                <img src="{{ $latest_plan->plan->online_company_booking == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Online Company booking</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->online_guest_booking == 0  ? 'notused' : '' }} moreOptions">
                                <img src="{{ $latest_plan->plan->online_guest_booking == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Onine Guest booking</span>
                            </li>
                            <li class="list-group-item {{ $latest_plan->plan->send_sms_to_client == 0  ? 'notused' : '' }} moreOptions">
                                <img src="{{ $latest_plan->plan->send_sms_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                <span class="listcheckmarktext">Send SMS to clients</span>
                            </li>
                        </ul>
                        <h4 class="permonthprice">
                            {{ ($latest_plan->plan->charges == 0)?'Free' : ($latest_plan->plan->currency_type.' '.$latest_plan->plan->charges . '/ '. ($latest_plan->plan->plan_type == 'Monthly'?'Month':'Year'))}}
                        </h4>
                    </div>
                </section>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 ">
                <section class="sectionsform">
                    <div class="leftcontent">
                        <h2 class="sidePaidTitle">
                            {{ ($latest_plan->plan->charges == 0)?'Free' :'Paid'}} license
                        </h2>
                        <ul class="list-group paidList">
                            <li class="list-group-item">
                                <span class="LeftItmes">{{ $latest_plan->plan->plan_name}} licenses ({{ $latest_plan->plan->number_of_driver}})</span>
                                <span class="RightItmes">{{ ($latest_plan->plan->charges == 0)?'Free' : ($latest_plan->plan->currency_type.' '.$latest_plan->plan->charges )}}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="LeftItmes highbold">EXPIRATION DATE</span>
                                <span class="RightItmes highbold">{{ date('d.m.Y',strtotime($latest_plan->expire_at))}}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="LeftItmes highbold">Set new expiration date</span>
                                <input type="date" class="form-control RightItmes timerclock" required/>
                            </li>
                        </ul>

                    </div>
                </section>
                <input type="submit" class="form-control submit_btn planbuttons" value="Save" />
            </div>
        </div>
    </article>
</section>

@endsection
