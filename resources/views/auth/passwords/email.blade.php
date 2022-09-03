@include('admin.layouts.head')
@include('admin.layouts.header1')

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
	
	<section id="wrapper">
        <div class="login-register" style="background-image:url({{ URL::asset('resources') }}/assets/images/background/login-register.jpg);">
            <div class="login-box card">
                <div class="card-body">
				
					<div class="preloader">
						<svg class="circular" viewBox="25 25 50 50">
							<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
					</div>
					
					<div class="container">
						<div class="row justify-content-center">
								@if (session('status'))
									<div class="alert alert-success" role="alert">
										{{ session('status') }}
									</div>
								@endif
								{{ Form::open(array('url' => route('password.email'),'class'=>'form-horizontal','id'=>'')) }}
									@csrf
									<div class="form-group ">
										<div class="col-xs-12">
											<h3>Recover Password</h3>
											<p class="text-muted">Enter your Email and instructions will be sent to you! </p>
										</div>
									</div>
									<div class="form-group ">
										<div class="col-xs-12">
											<input name="email" class="form-control" type="text" required="" placeholder="Email"> </div>
									</div>
									<div class="form-group text-center m-t-20">
										<div class="col-xs-12">
											<button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
										</div>
									</div>
								{{ Form::close() }}
								
								<form method="POST" action="{{ route('password.email') }}" class="hide">
									@csrf

									<div class="form-group row">
										<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

										<div class="col-md-6">
											<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

											@error('email')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
										</div>
									</div>

									<div class="form-group row mb-0">
										<div class="col-md-6 offset-md-4">
											<button type="submit" class="btn btn-primary">
												{{ __('Send Password Reset Link') }}
											</button>
										</div>
									</div>
								</form>
						</div>
					</div>
				</div>
            </div>
        </div>
    </section>

@include('admin.layouts.footer1')