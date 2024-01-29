@extends('layouts.extra_pages', ['page_title' => $page_title])

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
@endsection

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

                                        <form class="login_form"
                                            action="{{ route('service-provider.forgot_password_submit') }}" method="post"
                                            autocomplete="off">
                                            @csrf
                                            <div class="row w-100 m-0 main_form_rows">
                                                <div class="col-lg-5 col-md-5 col-sm-12 col-12 align-self-center">
                                                    <div class="form_imgs">
                                                        <img src="{{ asset('service_provider_assets/imgs/forgot.png') }}"
                                                            alt="sorry_img" class="img-fluid w-100 main_sorry_img" />
                                                        <p class="img_msg">
                                                            <strong>Forgot your password!</strong>
                                                        </p>
                                                        <p class="img_msg">
                                                            Please enter your email address to reset password.
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 offset-md-1 offset-lg-1">

                                                    <div class="form-row">

                                                        <div class="col-12 p-0">

                                                            <img src="{{ asset('service_provider_assets/imgs/brand_logo.png') }}"
                                                                alt="Logo" class="img-fluid logo_img" />

                                                            <div class="form_title text-center">
                                                                <h4 class="sub_title">Reset password</h4>
                                                                <p class="tagline">Please enter your e-mail address</p>
                                                                <hr class="divider_form" />
                                                            </div>
                                                            <!-- /Form Title -->

                                                        </div>
                                                        <!-- /Col -->

                                                        <div class="col-12">

                                                            <div class="form-group position-relative has_validation">
                                                                <label class="form-lable">Email</label>
                                                                <div class="field position-relative">
                                                                    <input type="email" name="email"
                                                                        class="form-control loginField"
                                                                        placeholder="Enter username or email" value="{{ old('email') }}" required />
                                                                    <img src="{{ asset('service_provider_assets/imgs/envelope.png') }}"
                                                                        class="img-fluid loginFieldIcon"
                                                                        alt="Email envelope" />
                                                                </div>
                                                            </div>

                                                            <div class="form-group position-relative">
                                                                <button type="submit"
                                                                    class="btn submit_btn submitBtnAction w-100 ">
                                                                    <span class="btn_text">Reset password</span>
                                                                </button>
                                                            </div>

                                                        </div>
                                                        <!-- /Col -->

                                                    </div>
                                                    <!-- /Form Row -->
                                                </div>

                                            </div>

                                        </form>

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
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).on('submit', '#registerform', function() {
            $(".submit_btn").attr('disabled', true);
        })

        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                text: "{{ Session::get('success') }}",
                confirmButtonText: 'Back',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('homepage') }}";
                }
            })
        @endif
        @if (Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ Session::get('error') }}"
            })
        @endif
    </script>
@endsection
