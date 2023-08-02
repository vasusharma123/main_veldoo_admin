@extends('company.layouts.app')
@section('content')
<style>
    .user_info
    {
        display: none;
    }
    input
    {
        color: black !important;
        font-weight: 600 !important;
    }
    input::placeholder
    {
        font-weight: 100 !important;
    }
</style>
<section class="add_booking_section">
    <article class="add_new_booking_box">
        <div class="action_btn text-end page_btn">
            <button type="button" class="btn add_new_booking_btn slider_table">
                <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon" class="img-fluid add_booking_icon" />
                <span class="text_button">Add User</span>
            </button>
        </div>
    </article>
</section>
<section class="name_section_box">
    <article class="container_box pt-0">
        <h1 class="main_heading d-flex"><span>Users</span></h1>
        @include('company.company_flash_message')
    </article>
</section>
<section class="">
    <article class="form_inside">
        <div class="form_add_managers">
            <form class="add_managers inside_custom_form " action="{{ route('company-users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="container-fluid form_container">
                    <div class="row m-0 w-100">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                            <div class="row w-100 m-0 gx-2">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings user_info mb-2">
                                    <input type="hidden" class="form-control inside_input_field mb-2" name="user_status" value="0">
                                    <input type="text" class="form-control main_field" name="first_name" placeholder="First Name" aria-label="First Name" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings user_info mb-2">
                                    <input type="text" class="form-control main_field" name="last_name" placeholder="Last Name" aria-label="Last Name" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings user_info mb-2">
                                    <input type="email" class="form-control main_field" name="email" placeholder="Email" aria-label="Email" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2 d-flex">
                                    <input type="hidden" value="+1" class="country_code" id="country_code" name="country_code" />
                                    <input type="tel" id="phone" class="form-control main_field" placeholder="Enter Number" name="phone" aria-label="Phone Number">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2 check_user_info">
                                    <div class="form_btn  mobile_margin ml-2">
                                        <button type="button" class="btn save_form_btn check_user_info_btn">Check</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 ">
                            <div class="form_btn text-end mobile_margin user_info">
                                <button type="submit" class="btn save_form_btn">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="edit_box inside_custom_form" style="display: none">
            <div class="container-fluid form_container">
                <div class="row m-0 w-100">
                    <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                        <div class="row w-100 m-0 gx-2">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                <input type="text" class="form-control main_field" name="first_name" form="updateForm" placeholder="First Name" aria-label="First Name" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                <input type="text" class="form-control main_field" name="last_name" form="updateForm" placeholder="Last Name" aria-label="Last Name" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                <input type="email" class="form-control main_field" form="updateForm" name="email" placeholder="Email" aria-label="Email" required>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">

                                <input type="hidden" value="+1" class="country_code" form="updateForm" id="country_code_edit" name="country_code" />
                                <input type="tel" id="phone_edit" class="form-control main_field" form="updateForm" placeholder="Enter Number" name="phone" aria-label="Phone Number">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-12 col-12 ">
                        <div class="form_btn text-end mobile_margin">
                            <button type="submit" form="updateForm" class="btn save_form_btn">Update Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>
<section class="table_all_content mt-3 ms-0">
    <article class="table_container">
        <div class="table-responsive">
            <table class="table table-stripes custom_table_view manager_lists ">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th class="">Email Address</th>
                        <th class="">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key=>$user)
                        <tr>
                            <td>{{ $user->first_name.' '.$user->last_name }}</td>
                            <td>+{{ $user->country_code }} {{ $user->phone }}</td>
                            <td class="">{{ $user->email }}</td>
                            <td class="">
                                <div class="">
                                    <button class="btn-info btn btn-sm text-white mr-2 editButton" data-user="{{ json_encode($user) }}">
                                        <em class="fa fa-pencil"></em>
                                    </button>
                                    <button class="btn-danger btn btn-sm text-white deleteButton" data-id="{{ $user->id }}">
                                        <em class="fa fa-trash"></em>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links('pagination.new_design') }}
    </article>
    <form  action="{{ route('company-users.destroy','~') }}" id="deleteForm" method="POST">
        @method('delete')
        @csrf
    </form>
    <form action="{{ route('company-users.update','~') }}" id="updateForm" method="POST" enctype="multipart/form-data">
        @method('put')
        @csrf
    </form>
</section>
@endsection
@section('footer_scripts')
<script>

    $('#phone, #phone_edit').keyup(function () { 
        this.value = this.value.replace(/[^0-9+\.]/g,'');
    });

    $("#phone, #phone_edit").on("blur", function(e){

    var conuntrycode = $('#country_code').val();
    var mobNum = $(this).val();
    var filter = /^\d*(?:\.\d{1,2})?$/;
    if (filter.test(mobNum)) {
        if(mobNum.length==10){
            return true;  
        } else {
            $(this).val('')
            return false;
        }
    }
    else if(mobNum.startsWith("+")){
        var temp = mobNum.substring(conuntrycode.length + 1 , mobNum.length);
        mobile = temp;
        $(this).val(mobile)
        return true; 
    } else {
        $(this).val('')
        return false;
    }

    });
     $(document).on('click','.check_user_info_btn',function(){
        country_code = $('#country_code').val();
        phone = $('#phone').val();
        if (phone=="" || country_code=="")
        {
            alert('Please enter the phone number');
            return false;
        }

        $.ajax({
            url: "{{ route('checkUserInfoBtn') }}",
            type: "POST",
            data: {_token:"{{ csrf_token() }}",country_code:country_code,phone:phone},
            success: function(data){
                if (data.status==1)
                {
                    alert('User already exists.');
                    $('.check_user_info').hide();
                    $('.user_info').find('input[name="first_name"]').val(data.user.first_name);
                    $('.user_info').find('input[name="last_name"]').val(data.user.last_name);
                    $('.user_info').find('input[name="email"]').val(data.user.email);
                    $('.user_info').find('input[name="user_status"]').val(1);
                    $('.user_info').show();
                }
                if (data.status==2)
                {
                    // alert('User not found. please fill additional information');
                    $('.user_info').find('input[name="user_status"]').val(0);
                    $('.check_user_info').hide();
                    $('.user_info').show();
                }
                if (data.status==0)
                {
                    alert('Something went wrong! please try again.');
                }
            }
        });
    });
    $(document).on('click','.deleteButton',function(){
        action = $('#deleteForm').attr('action');
        action = action.replace('~',$(this).data('id'));

        Swal.fire({
            title: "Delete User",
            text: "Are you sure you want to delete?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $('#deleteForm').attr('action',action);
                $('#deleteForm').submit();     // submitting the form when user press yes
            }
        });
    });
    $(document).ready(function(){
        $("a").tooltip();
    });
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
        initialCountry:"us",
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
        autoFormat: false,
        nationalMode: true,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "";
        },
    });
    iti.promise.then(function() {
        input.addEventListener("countrychange", function() {
            var selectedCountryData = iti.getSelectedCountryData();
            $('#country_code').val(selectedCountryData.dialCode);
        });
    });

    var inputEdit = document.querySelector("#phone_edit");
    var itiEdit = window.intlTelInput(inputEdit, {
        initialCountry: "auto",
        geoIpLookup: function (success, failure) {
            $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "us";
                success(countryCode);
            });
        },
        initialCountry:"us",
        nationalMode: true,
        separateDialCode: true,
        utilsScript: "{{url('assets/js/utils.js')}}",
        autoFormat: false,
        customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
            return "";
        },
    });
    itiEdit.promise.then(function() {
        inputEdit.addEventListener("countrychange", function() {
            var selectedCountryData = itiEdit.getSelectedCountryData();
            $('#country_code_edit').val(selectedCountryData.dialCode);
        });
    });
    $(document).on('click','.editButton',function(){

        user = $(this).data('user');
        action = $('#updateForm').attr('action');
        action = action.replace('~',user.id);
        $('#updateForm').attr('action',action);
        if ($('.edit_box').find("#imgPreview2").length > 0)
        {
            $('.edit_box').find("#imgPreview2").attr('src',"{{ asset('storage') }}/"+user.image);
        }
        if ($('.edit_box').find("#imgPreview1").length > 0)
        {
            $('.edit_box').find("#imgPreview1").attr('src',"{{ asset('storage') }}/"+user.image);
        }

        $('.edit_box').find("input[name='first_name']").val(user.first_name);
        $('.edit_box').find("input[name='last_name']").val(user.last_name);
        $('.edit_box').find("input[name='phone']").val(user.phone);
        $('.edit_box').find("input[name='country_code']").val(user.country_code);
        $('.edit_box').find("input[name='email']").val(user.email);
        $('.edit_box').show();
        $('.form_add_managers').hide();

        itiEdit.setNumber("+"+user.country_code+user.phone);
    });
    // $(document).on('change','#photo',function(){
    //     const file = this.files[0];
    //     console.log(file);
    //     if (file){
    //     let reader = new FileReader();
    //     reader.onload = function(event){
    //         console.log(event.target.result);
    //         $('#imgPreview').attr('src', event.target.result);
    //     }
    //     reader.readAsDataURL(file);
    //     }
    // });
</script>
@endsection
