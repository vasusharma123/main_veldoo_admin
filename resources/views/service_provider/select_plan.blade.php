@extends('layouts.service_provider_registration')

@section('css')
@endsection

@section('content')
            <section class="form_section p_form" >
                <div class="close_btn_icon d-block text-end">
                    <a href="#" class="close_btn_icon">
                   
                        <img src=" {{ asset('service_provider_assets/imgs/crosssvg.svg') }}" class="img-fluid svg cross_icon" alt="Close_btn">
                    </a>
                </div>
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
                                                                <span class="numberoflist">1 driver</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="#" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                Free
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4">Select</button>
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
                                                                <span class="numberoflist">5 drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="#" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                CHF 90 / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4">Select</button>
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
                                                                <span class="numberoflist">10 drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="#" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                CHF 180 / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4">Select</button>
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
                                                                <span class="numberoflist">1 driver</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item notused">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="#" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                Free
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4">Select</button>
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
                                                                <span class="numberoflist">5 drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item notused moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="#" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                CHF 90 / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4">Select</button>
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
                                                                <span class="numberoflist">10 drivers included</span>
                                                            </p>
                                                            <ul class="list-group checklistcars">
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Driver Statement</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Client / Company Management</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Export Ride details</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Information Notes to drivers</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                                </li>
                                                                
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Algorithms config</span>
                                                                </li>
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Online Company booking</span>
                                                                </li>
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Onine Guest booking</span>
                                                                </li>
                                                                <li class="list-group-item moreOptions">
                                                                    <img src="{{ asset('service_provider_assets/imgs/checkmarks.png')}}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                                    <span class="listcheckmarktext">Send SMS to clients</span>
                                                                </li>
                                                                <li class="list-group-item">
                                                                    
                                                                    <a href="#" class="listcheckmarktext showmore">More Details</a>
                                                                </li>
                                                            </ul>
                                                            <h4 class="permonthprice ">
                                                                CHF 180 / month
                                                            </h4>
                                                            <button class="btn submit_btn planBtnSelect mt-4">Select</button>
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
