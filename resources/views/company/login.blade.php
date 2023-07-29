@extends('layouts.company')
@section('content')
<section class="login_form_section">
    <article class="login_form_container container-fluid">
        <div class="row">
            <div class="login_form_content col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="login_form_box_cover">
                    <form class="login_form" action="{{ url('doLogin')}}" method="post" autocomplete="off">
                        @csrf
                        @include('company.company_flash_message')
                        <div class="form-row">
                            <div class="col-12 p-0">
                                <img src="{{ asset('new-design-company/assets/images/brand_logo.png') }}" alt="Logo" class="img-fluid logo_img"/>
                                <div class="form_title text-center">
                                    <h4 class="sub_title">Sign In</h4>
                                    <p class="tagline">Please login to continue</p>
                                    <hr class="divider_form" />
                                </div>
                                <!-- /Form Title -->
                            </div>
                            <!-- /Col -->
                            <div class="col-12">
                                <div class="form-group position-relative">
                                    <label class="form-lable">Email</label>
                                    <div class="field position-relative">
                                        <input type="email" name="email" class="form-control loginField" placeholder="Enter email" required/>
                                        <img src="{{ asset('new-design-company/assets/images/envelope.png') }}" class="img-fluid loginFieldIcon" alt="Email envelope"/>
                                    </div>
                                </div>
                                <div class="form-group position-relative">
                                    <label class="form-lable">Password</label>
                                    <div class="field position-relative">
                                        <input type="password" name="password" class="form-control loginField" placeholder="Enter Password" required/>
                                        <img src="{{ asset('new-design-company/assets/images/password_lock.png') }}" class="img-fluid loginFieldIcon" alt="Password Lock"/>
                                        <img src="{{ asset('new-design-company/assets/images/see_password.png') }}" class="img-fluid loginFieldIcon password_icon" alt="Password Lock"/>
                                    </div>
                                </div>
                                <div class="form-group position-relative">
                                    <div class="option_fields">
                                        <div class="form-check d-flex w-100 align-items-center">
                                            <input class="form-check-input form_checkbox" type="checkbox" name="remember" id="remember_me">
                                            <label class="form-check-label form-lable w-100" for="remember_me">
                                                Remember Me
                                                {{-- <a href="#" class="link_hyper">Forgot Password?</a> --}}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative">
                                    <button type="submit" class="btn submit_btn">
                                        <span class="btn_text">Sign In</span>
                                    </button>
                                </div>
                            </div>
                            <!-- /Col -->
                        </div>
                        <!-- /Form Row -->
                    </form>
                </div>
                <!-- /Login Form Box Cover -->
            </div>
            <!-- /Login Form Content -->
        </div>
    </article>
</section>
@endsection
