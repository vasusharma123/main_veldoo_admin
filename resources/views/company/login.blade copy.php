@extends('layouts.company')
@section('css')
<style>
    .login_user_page {
        align-items: center;
    }
</style>
@endsection
@section('content')
<div class="all_content">

    <main       class="body_content login_user_page">
        <div class="container">
            <section class="sign_in_form_section">
                <article class="form_top_logo">
                    <img src="{{ asset('company/assets/imgs/logo.png')}}" alt="Brand Logo" class="img-fluid brand_img">
                </article>
                <form method="post" action="{{ url('doLogin')}}" class="login_form">
                    @csrf
                    @include('company.company_flash_message')
                    <h3 class="form_title">Sign In</h3>
                    <div class="form_inputs_fields">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control input_fields" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control input_fields" placeholder="Password" required>
                        </div>
                        <div class="row mb-5">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-check mb-3">
                                    <input class="form-check-input input_fields_checkbox" id="check_remeber" type="checkbox" name="remember">
                                    <label class="form-check-label" for="check_remeber">
                                        Remember me
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="form-link">
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                            </div>
                            </div>
                        </div>
                        <div class="form_action_btns">
                            <button type="submit" class="btn custom_btn">Log In</button>
                            {{-- <a href="#" class="btn custom_red_btn">Business Log In</a>
                            <a href="sign_up.html" class="btn custom_red_btn">Register Company</a> --}}
                        </div>
                    </div>
                    <!-- Form Input Fields -->
                </form>
            </section>
        </div>
        <!-- Container -->
    </main>
    <!-- Body Content -->

</div>
@endsection
