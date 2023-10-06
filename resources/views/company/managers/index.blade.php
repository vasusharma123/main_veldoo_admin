@extends('company.layouts.app')
@section('content')
<style>
    input
    {
        /* color: black !important; */
        font-weight: 600 !important;
    }
    input::placeholder
    {
        font-weight: 100 !important;
    }
    input[type="file"] {
        opacity: 0;
        z-index: 1;
    }
</style>
<section class="add_booking_section">
    <article class="add_new_booking_box">
        <div class="action_btn text-end page_btn">
            <button type="button" class="btn add_new_booking_btn slider_table">
                <img src="{{ asset('new-design-company/assets/images/add_booking.svg') }}" alt="add icon" class="img-fluid add_booking_icon" />
                <span class="text_button">Add Manager</span>
            </button>
        </div>
    </article>
</section>
<section class="name_section_box">
    <article class="container_box pt-0">
        <h1 class="main_heading d-flex"><span>Managers</span></h1>
        @include('company.company_flash_message')
    </article>
</section>
<section class="">
    <article class="form_inside">
        <div class="form_add_managers">
            <form class="add_managers inside_custom_form " action="{{ route('managers.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                @csrf
                <div class="container-fluid form_container">
                    <div class="row m-0 w-100">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                            <div class="row w-100 m-0 gx-2">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mobile_view">
                                    <div class="img_preview position-relative mobile_avatar">
                                        <input type="file"  id="mPhoto" class="form-control main_field position-relative" name="image">
                                        <img src="{{ asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid avtar_preview" alt="Select Avatar" id="mPhotoImgPreview"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="text" class="form-control main_field" name="name" placeholder="Name" aria-label="Name" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="email" class="form-control main_field" name="email" placeholder="Email" aria-label="Email" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="hidden" value="+1" class="country_code" id="country_code" name="country_code" />
                                    <input type="tel" id="phone" class="form-control main_field" placeholder="Enter Number" name="phone" aria-label="Phone Number">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="password" class="form-control main_field" placeholder="Password" name="password" aria-label="Password" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 ">
                            <div class="img_preview position-relative desktop_view">
                                <input type="file" id="photo3" class="form-control main_field position-relative" name="image">
                                <img src="{{ asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid avtar_preview" alt="Select Avatar" id="photo3imgPreview"/>
                            </div>
                            <div class="form_btn text-end mobile_margin">
                                <button type="submit" class="btn save_form_btn">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <form action="{{ route('managers.update','~') }}" id="updateForm" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
            @method('put')
            @csrf
            <div class="edit_box inside_custom_form" style="display: none">
                <div class="container-fluid form_container">
                    <div class="row m-0 w-100">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                            <div class="row w-100 m-0 gx-2">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mobile_view">
                                    <div class="img_preview position-relative mobile_avatar">
                                        <input type="file" id="photo1" class="form-control main_field position-relative" name="image" form="updateForm">
                                        <img src="{{ asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid avtar_preview" alt="Select Avatar" id="photo1imgPreview1"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="text" class="form-control main_field" form="updateForm" name="name" placeholder="Name" aria-label="Name" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="email" class="form-control main_field" form="updateForm" name="email" placeholder="Email" aria-label="Email" required>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="hidden" value="+1" class="country_code" form="updateForm" id="country_code_edit" name="country_code" />
                                    <input type="tel" id="phone_edit" class="form-control main_field" form="updateForm" placeholder="Enter Number" name="phone" autocomplete="off" aria-label="Phone Number">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 col-12 col_form_settings mb-2">
                                    <input type="password" class="form-control main_field" placeholder="Password" form="updateForm" name="password" aria-label="Password">
                                    <span class="text-gray" style="font-size: 12px">Enter Password If you want to change</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-12 col-12 ">
                            <div class="img_preview position-relative desktop_view">
                                <input type="file" id="photo2" class="form-control main_field position-relative" name="image" form="updateForm">
                                <img src="{{ asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid avtar_preview" alt="Select Avatar" id="photo2imgPreview2"/>
                            </div>
                            <div class="form_btn text-end mobile_margin">
                                <button type="submit" form="updateForm" class="btn save_form_btn">Update Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                    @foreach ($managers as $key=>$manager)
                        <tr>
                            <td>{{ $manager->first_name }}</td>
                            <td>+{{ $manager->country_code }} {{ $manager->phone }}</td>
                            <td class="">{{ $manager->email }}</td>
                            <td class="">
                                <div class="">
                                    <button class="btn-info btn btn-sm text-white mr-2 editButton" data-user="{{ json_encode($manager) }}">
                                        <em class="fa fa-pencil"></em>
                                    </button>
                                    <button class="btn-danger btn btn-sm text-white deleteButton" data-id="{{ $manager->id }}">
                                        <em class="fa fa-trash"></em>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $managers->links('pagination.new_design') }}
    </article>
    <form  action="{{ route('managers.destroy','~') }}" id="deleteForm" method="POST">
        @method('delete')
        @csrf
    </form>
</section>
@endsection
@section('footer_scripts')
<script>
    $(document).on('click','.deleteButton',function(){
        action = $('#deleteForm').attr('action');
        action = action.replace('~',$(this).data('id'));
        Swal.fire({
            title: "Delete Manager",
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



    $('#phone, #phone_edit').keyup(function () { 
        this.value = this.value.replace(/[^0-9+\.]/g,'');
    });
    
    $("#phone, #phone_edit").on("blur", function(e){

        var conuntrycode = $('#country_code').val();
        var mobNum = $(this).val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(mobNum)) {
            return true;
            // if(mobNum.length==10){
            //     return true;  
            // } else {
            //     $(this).val('')
            //     return false;
            // }
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
        $('.edit_box').find("input[name='name']").val(user.first_name);
        $('.edit_box').find("input[name='phone']").val(user.phone);
        $('.edit_box').find("input[name='country_code']").val(user.country_code);
        $('.edit_box').find("input[name='email']").val(user.email);
        $('.edit_box').find("input[name='password']").val('');
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
