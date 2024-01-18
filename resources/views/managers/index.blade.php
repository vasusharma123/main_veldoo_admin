@extends('master_admin.layouts.after_login')

@section('header_menu_list')
    <li class="nav-item">
        <a class="nav-link active" href="">Manager</a>
    </li>
@endsection

@section('header_search_export')
    <div class="search">
        <form class="search_form">
            <div class="form-group searchinput position-relative trigger_parent">
                <input type="text" class="form-control input_search target" placeholder="Search" id="searchInput" />
                <i class="bi bi-search search_icons"></i>
            </div>
        </form>
    </div>
    <div class="bookBtnBox">
        <a class="openbook bookBtn p-0" href=""><i class="bi bi-plus-circle-fill topplusicon me-2"></i> <span>Add</span></a>
    </div>
    <div class="export_box">
        <a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
    </div>
@endsection

@section('content')

<section class="name_section_box"  style="
    padding: 10px 20px 0px 20px;
">
    <article class="container_box pt-0">
        @include('company.company_flash_message')
    </article>
</section>

<section class="addEditForm sectionsform">
                                        <article class="container-fluid com_tabs">
                                            <div class="form_add_managers">
                                            <form class="custom_form editForm admin_edit add_managers inside_custom_form " action="{{ route('master-manager.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                                                @csrf
                                                <div class="row w-100 m-0 form_inside_row">
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="row w-100 m-0">
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="name" name="name" placeholder="Enter Name" value="{{ old('name') ? old('name') : '' }}" required>

                                                                    <!-- <input type="text" class="form-control main_field" name="name" placeholder="Name" aria-label="Name" value="{{ old('name') ? old('name') : '' }}" required> -->

                                                                    <label for="name">Enter Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="email" class="form-control inputText" id="email" name="email" value="{{ old('email') ? old('email') : '' }}" placeholder="Enter Email"/>
                                                                   
                                                                    <!-- <input type="email" class="form-control main_field" name="email" placeholder="Email" aria-label="Email" value="{{ old('email') ? old('email') : '' }}" required> -->
                                                                    <label for="email">Example: admin@email-address.com</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                <input type="hidden" value="{{ old('country_code') ? old('country_code') : '+41' }}" class="country_code" id="country_code" name="country_code" />
                                                                <input type="tel" class="form-control inputText" id="phone" name="phone" placeholder="Enter Number" value="{{ old('phone') ? old('phone') : '' }}"  />
                                                                
                                                                <!-- <input type="tel" id="phone" class="form-control main_field" placeholder="Enter Number" name="phone" value="{{ old('phone') ? old('phone') : '' }}" aria-label="Phone Number"> -->

                                                                <label for="phone1">Example: +41 123 456 7899</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control inputText" id="password" name="password" placeholder="Enter Password" required>
                                                                    
                                                                    <!-- <input type="password" class="form-control main_field" placeholder="Password" name="password" aria-label="Password" required> -->
                                                                    <label for="password">Password</label>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="address" name="address" placeholder="Enter Street" />
                                                                    <label for="address">Enter Street</label>
                                                                </div>
                                                            </div> -->
                                                            <!-- <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="postcode" name="postcode" placeholder="Enter Post Code" />
                                                                    <label for="postcode">Enter post code</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="usercity" name="usercity" placeholder="Enter City" />
                                                                    <label for="usercity">Enter user city</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="usercountry" name="usercountry" placeholder="Enter Country" />
                                                                    <label for="usercountry">Enter user country</label>
                                                                </div>
                                                            </div>
                                                             -->
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="img_user_settled h-100">
                                                            <div class="view_image_user">

                                                                <img src="{{ asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid w-100 img_user_face diverSide" id="photo2imgPreview" />
                                                                <img src="{{ asset('assets/imgs/uploaded_icon.png') }}"  class="img-fluid w-100 img_user_icon" />
                                                                <input type="file" id="photo2" name="image" class="form-control hiddenForm" />
                                                            </div>
                                                            <input type="hidden" value="7"  id="type" name="type" />
                                                            <div class="form-group">
                                                                <input type="submit" value="Save" name="submit" class="form-control submit_btn driver_side"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            </div>

                                            <form id="updateForm" class="custom_form editForm admin_edit add_managers inside_custom_form " action="{{ route('master-manager.update','~') }}" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                                                @method('put')   
                                                @csrf
                                                <div class="row w-100 m-0 form_inside_row edit_box" style="display: none">
                                                    <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                                                        <div class="row w-100 m-0">
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="name" form="updateForm" name="name" placeholder="Enter Name" value="{{ old('name') ? old('name') : '' }}" required>

                                                                    <!-- <input type="text" class="form-control main_field" name="name" placeholder="Name" aria-label="Name" value="{{ old('name') ? old('name') : '' }}" required> -->

                                                                    <label for="name">Enter Name</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="email" class="form-control inputText" id="email" form="updateForm" name="email" value="{{ old('email') ? old('email') : '' }}" placeholder="Enter Email"/>
                                                                   
                                                                    <!-- <input type="email" class="form-control main_field" name="email" placeholder="Email" aria-label="Email" value="{{ old('email') ? old('email') : '' }}" required> -->
                                                                    <label for="email">Example: admin@email-address.com</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                <input type="hidden" value="" class="country_code" form="updateForm" id="country_code_edit"  name="country_code" />
                                                                <input type="tel" class="form-control inputText" id="phone_edit_number" form="updateForm" name="phone" placeholder="Enter Number" value=""  />
                                                                
                                                                <!-- <input type="tel" id="phone" class="form-control main_field" placeholder="Enter Number" name="phone" value="{{ old('phone') ? old('phone') : '' }}" aria-label="Phone Number"> -->

                                                                <label for="phone1">Example: +41 123 456 7899</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="password" class="form-control inputText" id="password"   form="updateForm" name="password" placeholder="Enter Password" required>
                                                                    
                                                                    <!-- <input type="password" class="form-control main_field" placeholder="Password" name="password" aria-label="Password" required> -->
                                                                    <label for="password">Password</label>
                                                                </div>
                                                            </div>
                                                            <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="address" name="address" placeholder="Enter Street" />
                                                                    <label for="address">Enter Street</label>
                                                                </div>
                                                            </div> -->
                                                            <!-- <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="postcode" name="postcode" placeholder="Enter Post Code" />
                                                                    <label for="postcode">Enter post code</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="usercity" name="usercity" placeholder="Enter City" />
                                                                    <label for="usercity">Enter user city</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control inputText" id="usercountry" name="usercountry" placeholder="Enter Country" />
                                                                    <label for="usercountry">Enter user country</label>
                                                                </div>
                                                            </div>
                                                             -->
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                                        <div class="img_user_settled h-100">
                                                            <div class="view_image_user">

                                                                <img src="{{ asset('new-design-company/assets/images/avatar-2.png') }}" class="img-fluid w-100 img_user_face diverSide" id="photo3imgPreview" />
                                                                <img src="{{ asset('assets/imgs/uploaded_icon.png') }}"  class="img-fluid w-100 img_user_icon" />
                                                                <input type="file"  id="photo3" name="image" class="form-control hiddenForm" />
                                                            </div>
                                                            <input type="hidden" value="7"  id="type" name="type" />
                                                            <div class="form-group">
                                                                <input type="submit" form="updateForm" type="submit" value="Update" class="form-control submit_btn driver_side"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </article>
                                    </section>




                                    <section class="addonTable sectionsform">
                                        <article class="container-fluid">
                                            <div class="table-responsive marginTbl">

                                                <table class="table table-borderless table-fixed customTable">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Phone number</th>
                                                            <th>Email Address</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($managers as $key=>$manager)    
                                                        <tr>
                                                        <td>{{ $manager->first_name }}</td>
                                                        <td> {{ $manager->phone ? '+' : '' }} {{ $manager->country_code }} {{ $manager->phone }}</td>
                                                        <td class="">{{ $manager->email }}</td>
                                                            <td class="switch_btn">
                                                                <label class="switch">
                                                                    <?php $id = Crypt::encrypt($manager->id); ?>
                                                                    <input type="checkbox" data-id="{{ $id }}" class="active_status active_status_{{ $id }}"  {{ $manager->status == 1 ? 'checked' : '' }}>
                                                                    <span class="slider round whitegrey_btn"></span>
                                                                </label>
                                                            </td>
                                                            <td class="actionbtns">
                                                                <a  class="actionbtnsLinks editButton" data-user="{{ Crypt::encrypt($manager->id) }}"><img src="{{ asset('assets/imgs/editpen.png' ) }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
                                                                <a  class="actionbtnsLinks"><img src="{{ asset('assets/imgs/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn deleteButton" data-id="{{$manager->id }}" alt="delete_btn"></a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </article>
                                    </section>

        <form  action="{{ route('master-manager.destroy','~') }}" id="deleteForm" method="POST">
            @method('delete')
            <input type="hidden" name="type" value="7">
        @csrf
    </form>

@endsection
@section('footer_scripts')
<script>
    //$(document).on('click','.editButton',function(){
       

    
        $('.editButton').click(function(){ 
                 user = $(this).data('user');
                 event.preventDefault();
                 console.log(user);
                 $.ajax({
                    url: '/master/fetchManager',
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: user,
                        type: "master"
                        // Add other data as needed
                    },
                    success: function (data) {
                        if(data.length !=0){
                            console.log(data);
                            var inputEdit = document.querySelector("#phone_edit_number");
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
                                action = $('#updateForm').attr('action');
                                action = action.replace('~',data.id);
                                $('#updateForm').attr('action',action);
                                if ($('.edit_box').find("#imgPreview2").length > 0)
                                {
                                    $('.edit_box').find("#imgPreview2").attr('src',"{{ asset('storage') }}/"+data.image);
                                }
                                if ($('.edit_box').find("#imgPreview1").length > 0)
                                {
                                    $('.edit_box').find("#imgPreview1").attr('src',"{{ asset('storage') }}/"+data.image);
                                }
                        
                                if(data && data.phone){
                                    itiEdit.setNumber("+"+data.country_code+data.phone);
                                }
                        
                                $('.edit_box').find("input[name='name']").val(data.name);
                                $('.edit_box').find("input[name='phone']").val(data && data.phone ? data.phone : '' );
                                $('.edit_box').find("input[name='country_code']").val(data.country_code);
                                $('.edit_box').find("input[name='email']").val(data.email);
                                $('.edit_box').find("input[name='password']").val('');
                                if(data.image){
                                    var image = $("#photo3imgPreview");
                                    image.attr("src", data.image);
                                }
                                $('.edit_box').show();
                                $('.form_add_managers').hide();

                        }
                    
                    },
                    error: function(xhr, status, error) {
                             console.error('Ajax request failed:', status, error);
                     }
                 });
        
         
                
             });

             $(document).on('change','#photo3',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#photo3imgPreview').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            $(document).on('change','#photo2',function(e) {
                // Get the selected file
                var file = e.target.files[0];
                // console.log(e.target);

                // Check if the file is an image
                if (file && file.type.startsWith('image/')) {
                // Create a FileReader instance
                var reader = new FileReader();

                // Set up the FileReader onload event
                reader.onload = function(e) {
                    // Set the src attribute of the preview image
                    // console.log(e.target);
                    $('#photo2imgPreview').attr('src', e.target.result);
                }

                // Read the file as a Data URL
                reader.readAsDataURL(file);
                }
            });
            
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


            //var checkboxes = document.querySelectorAll('.active_status');

           // Ensure the script runs after the DOM is fully loaded
            document.addEventListener("DOMContentLoaded", function() {
            // Get all elements with the class 'myCheckbox'
            var checkboxes = document.querySelectorAll('.active_status');

            // Add onchange event listener to each checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var id = $(this).data('id');
                    Swal.fire({
                    title: "Status Change",
                    text: "Are you sure you want to change status ?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel please!",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        if (checkbox.checked) {
                            console.log(checkbox.id + ' is checked');
                            var status = 1;
                        } else {
                            console.log(checkbox.id + ' is not checked');
                            var status = 0;
                        }

                        $.ajax({
                        url: '/master/updateStatus',
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            id: id,
                            type: 7,
                            status: status
                            // Add other data as needed
                        },
                        success: function (data) {
                            
                        
                        },
                        error: function(xhr, status, error) {
                                console.error('Ajax request failed:', status, error);
                        }
                        });
        

                    }else{
                        if (checkbox.checked) {
                            checkbox.checked = false;
                        } else {
                            checkbox.checked = true;
                        }

                       // });
                        
                    }
                });

               
                });
            });
            });

             </script>
@endsection