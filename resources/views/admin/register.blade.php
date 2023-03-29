	@include('admin.layouts.head')
	@include('admin.layouts.header1')
 <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
		@if(!empty($setting['admin_background']) && file_exists('storage/'.$setting['admin_background']))
			<div class="login-register" style="background-image:url({{ config('app.url_public').'/'.$setting['admin_background'] }});">
		@else
			<div class="login-register" style="background-image:url({{ asset('assets/images/background/login-register.jpg')}});">
		@endif
			<a href="javascript:void(0)" class="text-center db">
				@if(!empty($setting['admin_logo']) && file_exists('storage/'.$setting['admin_logo']))
					<img src="{{ config('app.url_public').'/'.$setting['admin_logo'] }}" alt="user" alt="homepage" class="dark-logo" style="max-width: 150px;" /> 
				@else
					<img src="{{ asset('assets/images/logo-icon.png')}}" alt="homepage" />
				@endif
				@if(!empty($setting['admin_sidebar_logo']) && file_exists('storage/'.$setting['admin_sidebar_logo']))
					<br><img src="{{ config('app.url_public').'/'.$setting['admin_sidebar_logo'] }}" width="128" height="19" class="hide" alt="Home">
				@else
					<br><img src="{{ asset('assets/images/logo-text.png') }}" class="hide" alt="Home">
				@endif
			</a>
            <div class="login-box card" style=" height:400px;overflow-y: scroll;">
                <div class="card-body">
					@include('admin.layouts.flash-message')
					
					{{ Form::open(array('url' => 'doRegister','class'=>'form-horizontal form-material','id'=>'registerform')) }}
                        <h3 class="box-title m-b-20">Sign Up</h3>
						<div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="first_name" type="text" placeholder="First Name">
							</div>
                        </div>
						<div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="last_name" type="text" placeholder="Last Name">
							</div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" type="text" placeholder="Email"> </div>
                        </div>
						<input class="form-control" type="hidden" placeholder="Country Code" id="country_code_box"> 
						<input class="form-control" name="country_code" type="hidden" placeholder="Country Code" id="country_code"> 
						<div class="form-group">
							<div class="col-xs-12">
							<input class="form-control" name="phone" type="text" placeholder="Phone Number" id="phone"> 
							</div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="site_name" type="text" placeholder="Site Name">
							</div>
                        </div>
						{{-- <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" type="password" placeholder="Password" id="password"> </div>
                        </div>
						<div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="confirm_password" type="password" placeholder="Confirm Password"> </div>
                        </div> --}}
                       
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Register</button>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <a href="{{ route('adminLogin') }}" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="button">Login</a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
	@include('admin.layouts.footer1')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>   
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>   
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/css/intlTelInput.min.css" />
<script type="text/javascript">
    $(document).ready(function () {
        $('#registerform').validate({
            rules: {
                first_name: "required",
                last_name: "required",
                email:{
                    required: true,
                    email: true
                },
                phone: "required",
                country_code: "required",
                site_name: "required",
            }
        });

        $(document).on('submit','#registerform',function(e){
            // e.preventDefault();
            var countryCode = $('.iti__selected-flag').attr('title');
            var countryCode = countryCode.replace(/[^0-9]/g,'');
            $('#country_code').val(countryCode);
        });
    });
</script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/js/intlTelInput.min.js"></script>
 <script>
    // Vanilla Javascript
    var input = document.querySelector("#country_code_box");
    window.intlTelInput(input,({
      // options here
    }));

    // $(document).ready(function() {
    //     $('.iti__flag-container').click(function() { 
    //         var countryCode = $('.iti__selected-flag').attr('title');
    //         var countryCode = countryCode.replace(/[^0-9]/g,'')
    //         $('#country_code').val("");
    //         $('#country_code').val(countryCode);
            
    //         $('#phone').val($('#phone').val());
    //     });
    // });
  </script>