@extends('admin.layouts.master')
@section('content')
<style>
	.iti-flag{
		background-image:url("{{asset('assets/images/flags.png')}}") !important;
	}
	@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx){
		.iti-flag{
			background-image:url("{{asset('assets/images/flags@2x.png')}}") !important;
		}
	}
</style>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        @if (!empty($action))
                            <h4 class="m-b-0 text-white">{{ $action }}</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.flash-message')

                        {{ Form::model($record, ['url' => route($route . '.update', $record->id), 'class' => 'form-horizontal form-material', 'id' => 'store', 'enctype' => 'multipart/form-data']) }}
                        @csrf
                        @method('PATCH')
                        <div class="form-body">
                            <div class="row p-t-5">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <?php
                                                echo Form::label('image_tmp', 'Profile Picture', ['class' => 'control-label']);
                                                ?>
                                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                    <div class="form-control" data-trigger="fileinput"> <i
                                                            class="glyphicon glyphicon-file fileinput-exists"></i> <span
                                                            class="fileinput-filename"></span></div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Select file</span> <span
                                                            class="fileinput-exists">Change</span>
                                                        <input type="hidden">
                                                        <?php
                                                        echo Form::file('image_tmp', ['class' => 'form-control', 'onchange' => 'readURL(this);', 'required' => false]);
                                                        ?>
                                                    </span>
                                                    <a href="#"
                                                        class="input-group-addon btn btn-default fileinput-exists"
                                                        data-dismiss="fileinput">Remove</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <?php
                                            echo Html::image(config('app.url_public') . '/' . ($record->image ? $record->image : '/no-images.png'), 'sidebar logo', ['id' => 'previewimage', 'width' => '50', 'height' => '50']);
                                            ?>
                                        </div>
                                    </div>
                                    <!----<div class="form-group">
                    <?php
                    //	echo Form::label('user_name', 'Username',['class'=>'control-label']);
                    //echo Form::text('user_name',null,['class'=>'form-control','required'=>true]);
                    ?>
                   </div>--->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('first_name', 'First Name', ['class' => 'control-label']);
                                        echo Form::text('first_name', null, ['class' => 'form-control', 'required' => true]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('last_name', 'Last Name', ['class' => 'control-label']);
                                        echo Form::text('last_name', null, ['class' => 'form-control', 'required' => true]);
                                        ?>
                                    </div>
                                </div>
                                <!---<div class="form-group">
                    <?php
                    //echo Form::label('dob', 'DOB',['class'=>'control-label']);
                    //echo Form::date('dob',null,['class'=>'form-control','required'=>true]);
                    ?>
                   </div>--->
                                <!--<div class="form-group">
                    <?php
                    //echo Form::radio('gender',1, null,  array('id'=>'male'));
                    //echo Form::label('male', 'Male',['class'=>'']);
                    
                    //echo Form::radio('gender',2, null,  array('id'=>'female'));
                    //	echo Form::label('female', 'Female',['class'=>'']);
                    ?>
                   </div>-->
                                <div class="col-md-6">
                                    <div class="country_code_div" style="margin-bottom: 20px">
                                        <?php
                                        echo Form::label('phone', 'Phone', ['class' => 'control-label']);
                                        ?>
                                        <input class="form-control " id="Regphones" required=""
                                            value="{{ '+' . $record->country_code . ' ' . $record->phone }}" name="phone"
                                            type="text" placeholder="9201550123">
                                        <input type="hidden" value="{{ '+' . $record->country_code }}" class="country_code"
                                            name="country_code" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="country_code_div" style="margin-bottom: 20px">
                                        <?php
                                        echo Form::label('phone', 'Alternate Phone No.', ['class' => 'control-label']);
                                        ?>
                                        <input class="form-control " id="RegAlterenatePhones" required=""
                                            value="{{ (!empty($record->second_phone_number))?'+' . $record->second_country_code . ' ' . $record->second_phone_number:'' }}"
                                            name="second_phone_number" type="text" placeholder="9876543210">
                                        <input type="hidden" value="{{ (!empty($record->second_country_code))?'+' . $record->second_country_code:'' }}"
                                            class="country_code" name="second_country_code" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('email', 'Email', ['class' => 'control-label']);
                                        echo Form::text('email', null, ['class' => 'form-control', 'required' => true]);
                                        ?>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                    <?php
                    //echo Form::label('my_free_subscription_days', 'Free Subscription Days',['class'=>'control-label']);
                    //echo Form::number('my_free_subscription_days',null,['class'=>'form-control','required'=>false, 'min'=>'-1']);
                    ?>
                    <small>Enter number of days or -1 for lifetime</small>
                   </div>-->
                                <!--<div class="form-group">
                    <?php
                    //echo Form::label('my_free_subscription_start_date', 'Free Subscription Start',['class'=>'control-label']);
                    //echo Form::text('my_free_subscription_start_date',null,['class'=>'form-control date','required'=>false]);
                    ?>
                   </div>-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('country', 'Country', ['class' => 'control-label']);
                                        echo Form::text('country', null, ['class' => 'form-control', 'required' => true]);
                                        ?>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('state', 'State', ['class' => 'control-label']);
                                        echo Form::text('state', null, ['class' => 'form-control']);
                                        ?>
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('city', 'City', ['class' => 'control-label']);
                                        echo Form::text('city', null, ['class' => 'form-control', 'required' => true]);
                                        ?>
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('street', 'Street', ['class' => 'control-label']);
                                        echo Form::text('street', null, ['class' => 'form-control']);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('zip', 'Zip Code', ['class' => 'control-label']);
                                        echo Form::text('zip', null, ['class' => 'form-control', 'required' => true]);
                                        ?>
                                        @error('zip')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::label('status', 'Status', ['class' => 'control-label']);
                                        echo Form::select('status', ['1' => 'Active', '0' => 'In-active'], null, ['class' => 'form-control custom-select', 'required' => true]);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php
                                        echo Form::checkbox('reset_password', 1, null, ['id' => 'reset_password']);
                                        echo Form::label('reset_password', 'Reset Password', ['class' => 'reset_password']);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group change-password hide">
                                        <?php
                                        echo Form::label('password', 'Password', ['class' => 'control-label']);
                                        echo Form::password('password', ['class' => 'form-control', 'required' => false]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Save</button>
                            <a href="{{ route($route . '.index') }}" class="btn btn-inverse">Cancel</a>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
@endsection

@section('footer_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#store').validate();
            $('body').on('change', '#reset_password', function() {
                if ($(this).prop("checked") == true) {
                    $('.change-password').show();
                    $('.change-password input').attr('required', 'required');
                } else {
                    $('.change-password').hide();
                    $('.change-password input').removeAttr('required');
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewimage').attr('src', e.target.result);
                    $('#previewimage').attr('height', '50px');
                    $('#previewimage').attr('width', '50px');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(document).ready(function() {
            jQuery("#RegAlterenatePhones").intlTelInput({
                initialCountry: "us",
                separateDialCode: true,
                utilsScript: "{{ url('public/assets/js/utils.js') }}"

            });
            // $('.flag-container').click(function() {
            //     var data = $('.selected-dial-code').html();
            //     $("#test1").val(data);
            // });
			$('.flag-container').click(function() {
                var data = $(this).find('.selected-dial-code').html();
				$(this).parents('.country_code_div').find('.country_code').val(data);
            });
            setTimeout(function() {
                var myStr = $("#Regphones").val().replace(/-/g, "");
                $("#Regphones").val(myStr);
            }, 1000);
            setTimeout(function() {
                var myStr = $("#RegAlterenatePhones").val().replace(/-/g, "");
                $("#RegAlterenatePhones").val(myStr);
            }, 1000);
        });
    </script>
@stop
