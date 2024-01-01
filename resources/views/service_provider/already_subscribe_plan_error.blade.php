@extends('layouts.extra_pages', ['page_title' => 'Already Subscribe'])

@section('content')

<div class="main_wrapper">

    <div class="main_content">

        <section class="login_form_section">

            <article class="login_form_container container-fluid">

                <div class="row main_fst_row">

                    <div class="login_form_content">
                        <div class="login_form_box">
                            <div class="row m-0 w-00 sec_rows">

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 p-0">

                                    <div class="login_form">

                                        <div class="row w-100 m-0 main_form_rows">

                                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 align-self-center">

                                                <div class="form-row">

                                                    <div class="col-12 p-0 text-center">

                                                        <img src="{{ asset('service_provider_assets/imgs/brand_logo.png') }}" alt="Logo" class="img-fluid logo_img mb-2" />

                                                    </div>
                                                    <!-- /Col -->

                                                    <div class="col-12">
                                                        <div class="form_imgs">
                                                            <img src="{{ asset('service_provider_assets/imgs/sorry_img.png') }}" alt="sorry_img" class="img-fluid w-100 main_sorry_img d-flex" />
                                                            <p class="img_msg">
                                                                <strong>This link no longer works.</strong> You are already overpaid for the Plan. If you want to change the plan, please to login to the admin panel and change the Plan from there.
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">

                                                        <div class="form-group position-relative text-center">
                                                            <a href="{{ route('adminLogin') }}" class="btn submit_btn submitBtnAction w-100 " style="max-width: 400px !important;">
                                                                <span class="btn_text">Log in</span>
                                                            </a>
                                                        </div>

                                                    </div>
                                                    <!-- /Col -->

                                                </div>
                                                <!-- /Form Row -->
                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <!-- Col-->
                            </div>
                            <!-- Sec Rows -->
                        </div>
                        <!-- Login Form Box Cover -->

                    </div>
                    <!-- /Login Form Content -->

                </div>
                <!-- Div Row Main First Row-->
            </article>

        </section>
        <!-- /Login Form Section -->
    </div>
    <!-- Main Content -->
</div>
<!-- /Main Warpper -->

@endsection
