@extends('layouts.service_provider_registration')

@section('css')
@endsection

@section('content')
@php
    $checkmarksImage = asset('service_provider_assets/imgs/checkmarks.png');
    $unCheckmarksImage = asset('service_provider_assets/imgs/unCheckmarks.png');
@endphp
<section class="form_section p_form">
    <div class="art_form planArtform">
        <article class="container-fluid position-relative">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-12 col-12 ps-0 offset-md-2 offset-lg-2">
                    <div class="top_form_heading text-center position-relative">
                        <p class="sm_text shadow_text mb-0">Choose your plan</p>
                        <h3 class="form_bold_text">Set your default plan</h3>
                    </div>

                    <div class="plansTb">
                        <ul class="nav nav-tabs" id="planTabsButtons" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="monthly-tab" data-bs-toggle="tab" data-bs-target="#monthly" type="button" role="tab" aria-controls="monthly" aria-selected="true">Monthly</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#yearly" type="button" role="tab" aria-controls="yearly" aria-selected="false">Yearly</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="planTabsButtonsContent">
                            <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <!--- Monthly Plan --->
                                <div class="row m-0 w-100">
                                    @foreach($monthyPlan as $month_key => $month_value)
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                        <section class="planSections">
                                            <div class="leftcontent">
                                                <h2 class="titleCards">
                                                    {{$month_value->plan_name}} Plan
                                                </h2>
                                                <p class="numberUsers">
                                                    <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                    <span class="numberoflist">{{ $month_value->number_of_driver }} driver</span>
                                                </p>
                                                <ul class="list-group checklistcars  ">

                                                    <li class="list-group-item {{ $month_value->organise_rides_and_bookings == 0 ? 'notused':'' }}">
                                                        <img src="{{ $month_value->organise_rides_and_bookings == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->book_rides_with_app == 0  ? 'notused' : '' }} ">
                                                        <img src="{{ $month_value->book_rides_with_app == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->driver_statement == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->driver_statement == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Driver Statement</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->client_company_management == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->client_company_management == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Client / Company Management</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->export_ride_deails == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->export_ride_deails == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Export Ride details</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->assign_rides_to_driver == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->assign_rides_to_driver == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->info_notes_to_drivers == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->info_notes_to_drivers == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Information Notes to drivers</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->promotion_notes_to_client == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->promotion_notes_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->algorithm_config == 0  ? 'notused' : '' }} moreOptions">
                                                        <img src="{{ $month_value->algorithm_config == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Algorithms config</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->online_company_booking == 0  ? 'notused' : '' }} moreOptions">
                                                        <img src="{{ $month_value->online_company_booking == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Online Company booking</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->online_guest_booking == 0  ? 'notused' : '' }} moreOptions">
                                                        <img src="{{ $month_value->online_guest_booking == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Onine Guest booking</span>
                                                    </li>
                                                    <li class="list-group-item {{ $month_value->send_sms_to_client == 0  ? 'notused' : '' }} moreOptions">
                                                        <img src="{{ $month_value->send_sms_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Send SMS to clients</span>
                                                    </li>
                                                    <li class="list-group-item">

                                                        <a href="JavaScript:void(0);" class="listcheckmarktext showmore">More Details</a>
                                                    </li>
                                                </ul>
                                                <h4 class="permonthprice ">
                                                    {{ ($month_value->charges == 0)?$month_value->plan_name : ($month_value->currency_type.' '.$month_value->charges . '/ month')}}
                                                </h4>
                                                @if($month_value->charges == 0)
                                                <a href="/service-provider/subscribe-plan/{{ $token }}/{{$month_value->id}}"> <button class="btn submit_btn planBtnSelect mt-4">Select</button></a>
                                                @else
                                                <button class="btn submit_btn planBtnSelect mt-4" style="background:#FC4C02;color: #fff;" disabled>Select</button>
                                                @endif
                                            </div>
                                        </section>
                                    </div>
                                    @endforeach

                                </div>
                                <!--- /Monthly Plan --->
                            </div>
                            <div class="tab-pane fade" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                                <!--- Yearly Plan --->
                                <div class="row m-0 w-100">
                                    @foreach($yearlyPlan as $year_key => $year_value)
                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12 {{ $year_key == 0?'ms-auto':''}}">
                                        <section class="planSections">
                                            <div class="leftcontent">
                                                <h2 class="titleCards">
                                                    {{$year_value->plan_name}} Plan
                                                </h2>
                                                <p class="numberUsers">
                                                    <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                    <span class="numberoflist">{{ $year_value->number_of_driver }} drivers included</span>
                                                </p>
                                                <ul class="list-group checklistcars">
                                                    <li class="list-group-item {{ $year_value->organise_rides_and_bookings == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->organise_rides_and_bookings == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->book_rides_with_app == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->book_rides_with_app == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->driver_statement == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->driver_statement == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Driver Statement</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->client_company_management == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->client_company_management == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Client / Company Management</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->export_ride_deails == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->export_ride_deails == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Export Ride details</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->assign_rides_to_driver == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->assign_rides_to_driver == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->info_notes_to_drivers == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->info_notes_to_drivers == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Information Notes to drivers</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->promotion_notes_to_client == 0  ? 'notused' : '' }}">
                                                        <img src="{{ $month_value->promotion_notes_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->algorithm_config == 0  ? 'notused' : '' }}  moreOptions">
                                                        <img src="{{ $month_value->algorithm_config == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Algorithms config</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->online_company_booking == 0  ? 'notused' : '' }} moreOptions">
                                                        <img src="{{ $month_value->online_company_booking == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Online Company booking</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->send_sms_to_client == 0  ? 'notused' : '' }} moreOptions">
                                                        <img src="{{ $month_value->send_sms_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Onine Guest booking</span>
                                                    </li>
                                                    <li class="list-group-item {{ $year_value->send_sms_to_client == 0  ? 'notused' : '' }} moreOptions">
                                                        <img src="{{ $month_value->send_sms_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                        <span class="listcheckmarktext">Send SMS to clients</span>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <a href="JavaScript:void(0)" class="listcheckmarktext showmore">More Details</a>
                                                    </li>
                                                </ul>
                                                <h4 class="permonthprice">
                                                    {{ $year_value->currency_type }} {{ $year_value->charges }} / year
                                                </h4>
                                                <button class="btn submit_btn planBtnSelect mt-4" style="background:#FC4C02;color: #fff;" disabled>Select</button>
                                            </div>
                                        </section>
                                    </div>
                                    @endforeach

                                </div>
                                <!--- /Yearly Plan --->
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </article>
    </div>

</section>
@endsection

@section('script')
@endsection
