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
					<img src="{{ asset('/assets/images/logo-icon.png')}}" alt="homepage" />
				@endif
				@if(!empty($setting['admin_sidebar_logo']) && file_exists('storage/'.$setting['admin_sidebar_logo']))
					<br><img src="{{ config('app.url_public').'/'.$setting['admin_sidebar_logo'] }}" width="128" height="19" class="hide" alt="Home">
				@else
					<br><img src="{{ asset('/assets/images/logo-text.png')}}" class="hide" alt="Home">
				@endif
			</a>
            <div class="login-box card" style=" height:400px;overflow-y: scroll;">
                <div class="card-body">
					@include('admin.layouts.flash-message')
					
					{{ Form::open(array('url' => 'doLogin','class'=>'form-horizontal form-material','id'=>'loginform')) }}
                        <h3 class="box-title m-b-20">Sign In</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="email" type="text" required="" placeholder="Email"> </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" type="password" required="" placeholder="Password"> </div>
                        </div>
                         <div class="form-group">
                            {{-- <div class="col-xs-12">
                                <select name="user_type" class="form-control">
                                    <option value="">Select Role</option>
                                    <option value="3">Super Admin</option>
                                     <option value="4">Company</option>
                                </select>
                            </div> --}}
                        <div class="form-group row">
                            <div class="col-md-12 font-14">
                                <div class="checkbox checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> Remember me </label>
                                </div> <a href="{{ route('password.request') }}" class="text-dark pull-right"><!-- <i class="fa fa-lock m-r-5"></i> --> Forgot Password?</a> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <a href="{{url('register')}}" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Register AS Company</a>
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
	$('#loginform').validate({
            rules: {
                email:{
					required: true,
                    email: true
					},
                password: "required",
                user_type: "required",
               
            }
            
        });
	});
</script>