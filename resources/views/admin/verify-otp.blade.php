	@include('admin.layouts.head')
	@include('admin.layouts.header1')
 <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper">
		@if(!empty($setting['admin_background']) && file_exists('storage/'.$setting['admin_background']))
			<div class="login-register" style="background-image:url({{ config('app.url_public').'/'.$setting['admin_background'] }});">
		@else
			<div class="login-register" style="background-image:url({{ URL::asset('assets/images/background/login-register.jpg') }});">
		@endif
			<a href="javascript:void(0)" class="text-center db">
				@if(!empty($setting['admin_logo']) && file_exists('storage/'.$setting['admin_logo']))
					<img src="{{ config('app.url_public').'/'.$setting['admin_logo'] }}" alt="user" alt="homepage" class="dark-logo" style="max-width: 150px;" /> 
				@else
					<img src="{{ URL::asset('assets/images/logo-icon.png') }}" alt="homepage" />
				@endif
				@if(!empty($setting['admin_sidebar_logo']) && file_exists('storage/'.$setting['admin_sidebar_logo']))
					<br><img src="{{ config('app.url_public').'/'.$setting['admin_sidebar_logo'] }}" width="128" height="19" class="hide" alt="Home">
				@else
					<br><img src="{{ URL::asset('assets/images/logo-text.png') }}" class="hide" alt="Home">
				@endif
			</a>
            <div class="login-box card">
                <div class="card-body">
					@include('admin.layouts.flash-message')
					
					{{ Form::open(array('url' => 'otp-verification','class'=>'form-horizontal form-material','id'=>'verificationform')) }}
                        <h3 class="box-title m-b-20">Verify Otp</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="otp" type="text" placeholder="Enter Otp"> </div>
                        </div>
                        <input type="hidden" name="phone" value="{{$phone}}">
                        <input type="hidden" name="country_code" value="{{$code}}">

                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Register</button>
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
    <script type="text/javascript">
    $(document).ready(function () {
        $('#registerform').validate();
    });
</script>