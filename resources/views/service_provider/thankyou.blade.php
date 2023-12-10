@extends('layouts.service_provider_registration')

@section('css')
@endsection

@section('content')
<section class="form_section p_form" >
                <div class="art_form planArtform freeplansTbas">
                    <article class="container-fluid position-relative">
                        <div class="row">
                            
                            <div class="col-lg-10 col-md-10 col-sm-12 col-12 ps-0 offset-md-2 offset-lg-2">
                                <div class="top_form_heading text-center position-relative">
                                    <p class="sm_text shadow_text mb-0">Payment process</p>
                                    <h3 class="form_bold_text">Set your payment process</h3>
                                </div>

                                <div class="plansTb ">
                                   
                                    <div class="tab-content" id="planTabsButtonsContent">
                                        <div class="tab-pane fade show active" id="monthly" role="tabpanel" aria-labelledby="monthly-tab">
                                            <!--- Monthly Plan --->
                                            <div class="row m-0 w-100">
                                                <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                                                    
                                                </div>
                                                
                                                <div class="col-lg-9 col-md-9 col-sm-12 col-12 pe-lg-0">
                                                    <div class="thankyoubox">
                                                        <h3 class="thnxtext">Thanks for using Veldoo!</h3>
                                                        <p class="thnxsubpara">Start using APP with your created account. Follow instruction in your email. </p>
                                                    </div>
                                                    <div class="loginoptionbox">
                                                        <p class="notpara mb-0"><strong>NOTE:</strong><a href="#"> Need help? Contact our Help Center.</a></p>
                                                        <a href="/admin"><button class="btn submit_btn planBtnSelect subsCribeBtn mt-0">Log in</button></a>
                                                    </div>
                                                    
                                                </div>

                                                
                                              

                                            </div>
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