@extends('layouts.service_provider_registration')

@section('css')
@endsection

@section('content')
    <div class="main_wrapper">

        <div class="main_content">

            <section class="login_form_section">

                <article class="login_form_container container-fluid">

                    <div class="row">

                        <div class="login_form_content col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                            <div class="login_form_box_cover">

                                <form class="login_form" action="{{ route('spLogin') }}" method="post" autocomplete="off">
                                    @csrf
                                    <div class="form-row">

                                        <div class="col-12 p-0">

                                            <img src="{{ asset('service_provider_assets/imgs/brand_logo.png') }}"
                                                alt="Logo" class="img-fluid logo_img" />

                                            <div class="form_title text-center">
                                                <h4 class="sub_title">Log in</h4>
                                                <p class="tagline">Please login to continue</p>
                                                <hr class="divider_form" />
                                            </div>
                                            <!-- /Form Title -->

                                        </div>
                                        <!-- /Col -->

                                        <div class="col-12">

                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Username / Email</label>
                                                <div class="field position-relative">
                                                    <!-- <input type="tel" id="phone" class="form-control loginField" placeholder="Enter Number" aria-label="Phone Number" required> -->
                                                    <input type="email" name="email" class="form-control loginField"
                                                        placeholder="Enter username or email"
                                                        value="{{ old('email') }}"required />
                                                    <img src="{{ asset('service_provider_assets/imgs/envelope.png') }}"
                                                        class="img-fluid loginFieldIcon" alt="Email envelope" />
                                                </div>
                                                @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <!-- <p class="erro d-none mb-0">Please enter valid email address...</p> -->
                                            </div>


                                            <div class="form-group position-relative has_validation">
                                                <label class="form-lable">Password</label>
                                                <div class="field position-relative">
                                                    <input type="password" name="password" class="form-control loginField"
                                                        placeholder="Enter Password" id="passwordField" required />
                                                    <img src="{{ asset('service_provider_assets/imgs/password_lock.png') }}"
                                                        class="img-fluid loginFieldIcon" alt="Password Lock" />
                                                    <img src="{{ asset('service_provider_assets/imgs/see_password.png') }}"
                                                        class="img-fluid loginFieldIcon password_icon"
                                                        alt="Password Lock" onclick="showHidePassword()"/>
                                                </div>
                                                @error('password')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                                <p class="erro d-none mb-0">Invalid email or password. Try again or click
                                                    Forgot password to reset it.</p>
                                            </div>

                                            <div class="form-group position-relative">
                                                <div class="option_fields">
                                                    <div class="form-check d-flex w-100 align-items-center">
                                                        <input class="form-check-input form_checkbox" type="checkbox" name="remember"
                                                            value="1" id="remember_me">
                                                        <label class="form-check-label form-lable w-100" for="remember_me">
                                                            Remember Me
                                                            <a href="#" class="link_hyper">Forgot Password?</a>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group position-relative">
                                                <button type="submit" class="btn submit_btn submitBtnAction w-100 ">
                                                    <span class="btn_text">Log in</span>
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
            <!-- /Login Form Section -->

        </div>
        <!-- /Main Content -->

    </div>
@endsection

@section('script')
    <script>
        @if (Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error') }}"
            })
        @endif

        function showHidePassword() {
            var x = document.getElementById("passwordField");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endsection
