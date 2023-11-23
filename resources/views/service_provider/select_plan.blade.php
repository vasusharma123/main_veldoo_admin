@extends('layouts.service_provider_registration')

@section('css')
@endsection

@section('content')

            <section class="form_section p_form" >
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
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                    <section class="planSections">
                                                        <div class="leftcontent">
                                                            <h2 class="titleCards">
                                                                Free Plan
                                                            </h2>
                                                            <p class="numberUsers">
                                                                <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                                <span class="numberoflist">{{ $data[0]['number_of_driver'] }} driver</span>
                                                            </p>
                                                            <ul class="list-group checklistcars  ">
                                                 
                                                                <li class="list-group-item <?php if($data[0]['organise_rides_and_bookings'] == 0 ) { echo "notused";  }?>">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['book_rides_with_app'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['driver_statement'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['client_company_management'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['export_ride_deails'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['assign_rides_to_driver'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['info_notes_to_drivers'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['promotion_notes_to_client'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['algorithm_config'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['online_company_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['online_guest_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[0]['send_sms_to_client'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="JavaScript:void(0)" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                Free
                                                            </h4>
                                                            <a href="/service-provider/subscribe-plan/{{ $token }}/{{$data[0]['id']}}"> <button class="btn submit_btn planBtnSelect mt-4">Select</button></a>
                                                        </div>
                                                    </section>
                                                </div>
                                                
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                    <section class="planSections">
                                                        <div class="leftcontent">
                                                            <h2 class="titleCards">
                                                               Sliver Plan
                                                            </h2>
                                                            <p class="numberUsers">
                                                                <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                                <span class="numberoflist">{{ $data[2]['number_of_driver'] }} drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item {{ $data[2]['organise_rides_and_bookings'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['book_rides_with_app'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['driver_statement'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['client_company_management'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['export_ride_deails'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['assign_rides_to_driver'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['info_notes_to_drivers'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['promotion_notes_to_client'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['algorithm_config'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['online_company_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['online_guest_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[2]['send_sms_to_client'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="JavaScript:void(0)" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                            {{ $data[3]['currency_type'] }} {{ $data[2]['charges'] }} / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect  mt-4" style="background:#FC4C02;color: #fff;" disabled>Select</button>
                                                        </div>
                                                    </section>
                                                </div>

                                                
                                                
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                    <section class="planSections">
                                                        <div class="leftcontent">
                                                            <h2 class="titleCards">
                                                               Gold Plan
                                                            </h2>
                                                            <p class="numberUsers">
                                                                <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                                <span class="numberoflist">{{ $data[4]['number_of_driver'] }} drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item {{ $data[4]['organise_rides_and_bookings'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['book_rides_with_app'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['driver_statement'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['client_company_management'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['export_ride_deails'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['assign_rides_to_driver'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['info_notes_to_drivers'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['promotion_notes_to_client'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                
                                                                <li class="list-group-item {{ $data[4]['algorithm_config'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['online_company_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['online_guest_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[4]['send_sms_to_client'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="JavaScript:void(0)" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                            {{ $data[5]['currency_type'] }} {{ $data[4]['charges'] }} / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4" style="background:#FC4C02;color: #fff; " disabled>Select</button>
                                                        </div>
                                                    </section>
                                                </div>

                                            </div>
                                            <!--- /Monthly Plan --->
                                        </div>
                                        <div class="tab-pane fade" id="yearly" role="tabpanel" aria-labelledby="yearly-tab">
                                            <!--- Yearly Plan --->
                                            <div class="row m-0 w-100">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                    <section class="planSections">
                                                        <div class="leftcontent">
                                                            <h2 class="titleCards">
                                                                Free Plan
                                                            </h2>
                                                            <p class="numberUsers">
                                                                <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                                <span class="numberoflist">{{ $data[1]['number_of_driver'] }} driver</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item {{ $data[1]['organise_rides_and_bookings'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['book_rides_with_app'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['driver_statement'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['client_company_management'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['export_ride_deails'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['assign_rides_to_driver'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['info_notes_to_drivers'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['promotion_notes_to_client'] == 0  ? 'notused' : '' }} ">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['algorithm_config'] == 0  ? 'notused' : '' }}  moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['online_company_booking'] == 0  ? 'notused' : '' }}  moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['online_guest_booking'] == 0  ? 'notused' : '' }}  moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[1]['send_sms_to_client'] == 0  ? 'notused' : '' }}  moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="JavaScript:void(0)" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                Free
                                                            </h4>
                                                           <a href="/service-provider/subscribe-plan/{{ $token }}/{{$data[1]['id']}}"> <button class="btn submit_btn planBtnSelect mt-4">Select</button></a>
                                                        </div>
                                                    </section>
                                                </div>
                                                
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                    <section class="planSections">
                                                        <div class="leftcontent">
                                                            <h2 class="titleCards">
                                                               Sliver Plan
                                                            </h2>
                                                            <p class="numberUsers">
                                                                <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                                <span class="numberoflist">{{ $data[3]['number_of_driver'] }} drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item {{ $data[3]['organise_rides_and_bookings'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['book_rides_with_app'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['driver_statement'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['client_company_management'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['export_ride_deails'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['assign_rides_to_driver'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['info_notes_to_drivers'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['promotion_notes_to_client'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['algorithm_config'] == 0  ? 'notused' : '' }}  moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['online_company_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['send_sms_to_client'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[3]['send_sms_to_client'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="JavaScript:void(0)" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                            {{ $data[3]['currency_type'] }} {{ $data[2]['charges'] }} / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4" style="background:#FC4C02;color: #fff;" disabled>Select</button>
                                                        </div>
                                                    </section>
                                                </div>

                                                
                                                
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                    <section class="planSections">
                                                        <div class="leftcontent">
                                                            <h2 class="titleCards">
                                                               Gold Plan
                                                            </h2>
                                                            <p class="numberUsers">
                                                                <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                                <span class="numberoflist">{{ $data[5]['number_of_driver'] }} drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item {{ $data[5]['organise_rides_and_bookings'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['book_rides_with_app'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['driver_statement'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['client_company_management'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['export_ride_deails'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['assign_rides_to_driver'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['info_notes_to_drivers'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['promotion_notes_to_client'] == 0  ? 'notused' : '' }}">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                
                                                                <li class="list-group-item {{ $data[5]['algorithm_config'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['online_company_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['online_guest_booking'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item {{ $data[5]['send_sms_to_client'] == 0  ? 'notused' : '' }} moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="JavaScript:void(0)" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                            {{ $data[5]['currency_type'] }} {{ $data[4]['charges'] }} / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4" style="background:#FC4C02;color: #fff;" disabled>Select</button>
                                                        </div>
                                                    </section>
                                                </div>

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
