@extends('layouts.service_provider_registration')

@section('css')
<style>
    .voltop {
        margin-top: -61px;
        margin-bottom: 00px;
        float: left;
        margin-left: -200px;
    }

    @media (max-width:1200px) {
        .actinbtnsoption {
            flex-wrap: wrap;
        }

        .actinbtnsoption button {
            margin-left: 0px !important;
            margin-right: 0px !important;
        }

    }

    @media (max-width:1024px) {
        .voltop {
            margin-top: -110px;
            margin-bottom: 50px;
            margin-left: 0px;
        }

    }

    @media (max-width:798px) {
        .voltop {
            margin-top: 20px;
            margin-bottom: 0px;
            text-align: center !important;
            width: 100% !important;
        }

        .voltop .form_bold_text {
            font-size: 30px;
            text-align: center !important;
            margin: auto;
        }

        .plansTb {
            margin-top: 160px;
        }

        .art_form.planArtform:before {
            top: 200px;
        }

        .planArtform .sm_text.shadow_text {
            text-align: center;
            font-size: 50px;
        }
    }

    @media (max-width: 492px) {

        .planArtform .form_bold_text {
            text-align: center;
            margin-right: 0px;
            margin-bottom: 0px;
            margin-top: 10px;
        }

        .planArtform .sm_text.shadow_text {
            text-align: center;
            font-size: 50px;
            line-height: 46px;
        }
    }

</style>

@endsection

@section('content')
@php
$checkmarksImage = asset('service_provider_assets/imgs/checkmarks.png');
$unCheckmarksImage = asset('service_provider_assets/imgs/uncheckmarks.png');
@endphp
<section class="form_section p_form">
    <div class="art_form planArtform">
        <article class="container-fluid position-relative">
            <div class="row">

                <div class="col-lg-10 col-md-12 col-sm-12 col-12 ps-0 offset-lg-2">
                    <div class="top_form_heading text-center position-relative">
                        <p class="sm_text shadow_text mb-0">Payment process</p>
                        <h3 class="form_bold_text">Set your payment process</h3>
                    </div>
                    <div class="voltop text-start">
                        <h3 class="form_bold_text text-start">{{ $user_exist->name }}</h3>
                        <label class="label_form d-block mt-1">Test License, expiration date: {{ date('d.m.Y', strtotime($user_exist->setting->demo_expiry)) }}</label>    
                    </div>
                    <div class="plansTb">

                        <div class="tab-content" id="planTabsButtonsContent">
                            <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                <!--- Monthly Plan --->
                                <form class="input_form m-0" method="post" action="/subscribedPlan">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="plan_id" value="{{ $plan_detail->id }}">
                                    <div class="row m-0 w-100">

                                        <div class="col-lg-4 col-md-5 col-sm-12 col-12 ms-auto">
                                            <section class="planSections">
                                                <div class="leftcontent">
                                                    <h2 class="titleCards">
                                                        {{ucfirst($plan_detail->plan_name)}} Plan
                                                    </h2>
                                                    <p class="numberUsers">
                                                        <img src="{{ asset('service_provider_assets/imgs/users-black.png')}}" alt="user icon" class="img-fluid w-100 usernumbericon">
                                                        <span class="numberoflist">{{ $plan_detail->number_of_driver }} driver</span>
                                                    </p>
                                                    <ul class="list-group checklistcars  ">

                                                        <li class="list-group-item {{ $plan_detail->organise_rides_and_bookings == 0 ? 'notused':'' }}">
                                                            <img src="{{ $plan_detail->organise_rides_and_bookings == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Organize Rides and Bookings</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->book_rides_with_app == 0  ? 'notused' : '' }} ">
                                                            <img src="{{ $plan_detail->book_rides_with_app == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Book Rides with UserApp & DriverApp</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->driver_statement == 0  ? 'notused' : '' }}">
                                                            <img src="{{ $plan_detail->driver_statement == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Driver Statement</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->client_company_management == 0  ? 'notused' : '' }}">
                                                            <img src="{{ $plan_detail->client_company_management == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Client / Company Management</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->export_ride_deails == 0  ? 'notused' : '' }}">
                                                            <img src="{{ $plan_detail->export_ride_deails == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Export Ride details</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->assign_rides_to_driver == 0  ? 'notused' : '' }}">
                                                            <img src="{{ $plan_detail->assign_rides_to_driver == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Assign Rides to drivers</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->info_notes_to_drivers == 0  ? 'notused' : '' }}">
                                                            <img src="{{ $plan_detail->info_notes_to_drivers == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Information Notes to drivers</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->promotion_notes_to_client == 0  ? 'notused' : '' }}">
                                                            <img src="{{ $plan_detail->promotion_notes_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Promotion Notes to clients</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->algorithm_config == 0  ? 'notused' : '' }} moreOptions">
                                                            <img src="{{ $plan_detail->algorithm_config == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Algorithms config</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->online_company_booking == 0  ? 'notused' : '' }} moreOptions">
                                                            <img src="{{ $plan_detail->online_company_booking == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Online Company booking</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->online_guest_booking == 0  ? 'notused' : '' }} moreOptions">
                                                            <img src="{{ $plan_detail->online_guest_booking == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Onine Guest booking</span>
                                                        </li>
                                                        <li class="list-group-item {{ $plan_detail->send_sms_to_client == 0  ? 'notused' : '' }} moreOptions">
                                                            <img src="{{ $plan_detail->send_sms_to_client == 0 ? $unCheckmarksImage:$checkmarksImage }}" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs">
                                                            <span class="listcheckmarktext">Send SMS to clients</span>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <a href="JavaScript:void(0);" class="listcheckmarktext showmore">More Details</a>
                                                        </li>
                                                    </ul>

                                                    <h4 class="permonthprice ">
                                                        {{ ($plan_detail->charges == 0)?'Free' : ($plan_detail->currency_type.' '.$plan_detail->charges . '/ month')}}
                                                    </h4>
                                                    {{-- <button class="btn submit_btn planBtnSelect mt-4">Select</button> --}}
                                                </div>
                                            </section>
                                        </div>
                                      
                                        @if($plan_detail->charges != 0)
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                            <section class="planSections totalplantextbox">
                                                <div class="leftcontent">
                                                    <div class="row w-100 m-0 gx-4">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col_form_settings mb-2 p-0">
                                                            <label class="required_field label_form">Card number</label>
                                                            <div class="imgField position-relative">

                                                                <input type="text" pattern="[0-9]" class="form-control input_text textcardfield" placeholder="0000 0000 0000 0000" required />
                                                                <img src="{{ asset('service_provider_assets/imgs/cards.png')}}" class="cardsimgs img-fluid" alt="cards">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2  ps-lg-0 ps-md-0 ">
                                                            <label class="required_field label_form">Expiration date </label>
                                                            <input type="month" class="form-control input_text" required />
                                                        </div>
                                                        <div class="col-lg-8 col-md-8 col-sm-12 col-12 col_form_settings mb-2 ps-lg-0 ps-md-0 ">
                                                            <label class="required_field label_form">Country</label>
                                                            <input type="text" class="form-control input_text" placeholder="Country" required />
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 col_form_settings mb-2  pe-lg-0 pe-md-0 p-sm-0">
                                                            <label class="required_field label_form">Security Code</label>
                                                            <input type="text" class="form-control input_text" placeholder="CVV" required />
                                                        </div>
                                                    </div>
                                                    <div class="row m-0 w-100 subtotal_text">
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
                                                            <h4 class="permonthprice text-center mb-0 ">
                                                                Total
                                                            </h4>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12 p-0">
                                                            <h4 class="permonthprice text-end mb-0">
                                                                CHF 90 / month
                                                            </h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                        
                                            
                                        <div class="action_plan_btn text-end d-flex flex-wrap justify-content-end">
                                            
                                                <a href="{{ route('selectPlan', $token) }}" class="btn submit_btn planBtnSelect subsCribeBtn mt-0 mb-2 mx-2 me-0" style="background: #356681;">Switch Plan</a>
                                            
                                                <button class="btn submit_btn planBtnSelect subsCribeBtn mt-0 mb-2 mx-2 me-0" type="submit" style="float: unset;">Subscribe now</button>
                                                
                                            </div>
                                            <p class="notpara d-block my-2 text-end"><strong>NOTE:</strong><a href="#"> Need help? Contact our Help Center.</a></p>
                                        </div>
                                        @endif
                                        @if($plan_detail->charges == 0)
                                        <div class="action_plan_btn text-end d-flex flex-wrap justify-content-end">
                                            
                                            <a href="{{ route('selectPlan', $token) }}" class="btn submit_btn planBtnSelect subsCribeBtn mt-0 mb-2 mx-2 me-0" style="background: #356681;">Switch Plan</a>
                                         
                                            <button class="btn submit_btn planBtnSelect subsCribeBtn mt-0 mb-2 mx-2 me-0" type="submit" style="float: unset;">Subscribe now</button>
                                            
                                        </div>
                                        <p class="notpara d-block my-2 text-end"><strong>NOTE:</strong><a href="#"> Need help? Contact our Help Center.</a></p>
                                    </div>
                                    @endif
                                </form>
                                <!--- /Monthly Plan --->
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
@if(Session::has('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ Session::get('error') }}"
    })

</script>
@endif
@endsection
