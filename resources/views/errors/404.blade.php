@extends('layouts.extra_pages', ['page_title' => '404'])

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
                                            <div class="col-lg-5 col-md-5 col-sm-12 col-12 align-self-center">
                                                <div class="form_imgs">
                                                    <img src="{{ asset('service_provider_assets/imgs/404error.png')}}" alt="sorry_img" class="img-fluid w-100 main_sorry_img" />
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 offset-md-1 offset-lg-1 align-self-center">

                                                <div class="form-row">

                                                    <div class="col-12 p-0">

                                                        <div class="form_title text-start border-left-side">
                                                            <h4 class="sub_title notfoundTitle">404</h4>
                                                            <p class="tagline bigTitles">{{ $exception->getMessage() ? $exception->getMessage() :  "Page Not found" }}</p>
                                                            <p class="subtextBlue">Start from <a href="{{ route('homepage') }}" target="_blank">home page</a></p>
                                                        </div>
                                                        <!-- /Form Title -->

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
