@extends('master_admin.layouts.after_login')

@section('header_search_export')
    <div class="search">
        <form class="search_form">
            <div class="form-group searchinput position-relative trigger_parent">
                <input type="text" class="form-control input_search target" placeholder="Search" id="searchInput" />
                <i class="bi bi-search search_icons"></i>
            </div>
        </form>
    </div>
    <div class="export_box">
        <a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
    </div>
@endsection

@section('content')

<section class="name_section_box">
    <article class="container_box pt-0">
        @include('company.company_flash_message')
    </article>
</section>

<section class="addEditForm sectionsform">
                                        <article class="container-fluid com_tabs">
                                            <form class="custom_form editForm admin_edit add_managers inside_custom_form " action="{{ route('master-managers.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
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

                                                                <img src="assets/imgs/avatar-2.png" class="img-fluid w-100 img_user_face diverSide" />
                                                                <img src="assets/imgs/uploaded_icon.png" class="img-fluid w-100 img_user_icon" />
                                                                <input type="file" name="fileUser" class="form-control hiddenForm" />
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <input type="submit" value="Save" name="submit" class="form-control submit_btn driver_side"/>
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
                                                            <th>Surname</th>
                                                            <th>Phone number</th>
                                                            <th>Email Adress</th>
                                                            <th>Master</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Raman</td>
                                                            <td>Kumar</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td class="switch_btn">
                                                                <label class="switch">
                                                                    <input type="checkbox" checked>
                                                                    <span class="slider round whitegrey_btn"></span>
                                                                </label>
                                                            </td>
                                                            <td class="actionbtns">
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/editpen.png" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/deleteBox.png" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Raman</td>
                                                            <td>Kumar</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td class="switch_btn">
                                                                <label class="switch">
                                                                    <input type="checkbox">
                                                                    <span class="slider round whitegrey_btn"></span>
                                                                </label>
                                                            </td>
                                                            <td class="actionbtns">
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/editpen.png" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/deleteBox.png" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Raman</td>
                                                            <td>Kumar</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td class="switch_btn">
                                                                <label class="switch">
                                                                    <input type="checkbox" checked>
                                                                    <span class="slider round whitegrey_btn"></span>
                                                                </label>
                                                            </td>
                                                            <td class="actionbtns">
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/editpen.png" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/deleteBox.png" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Raman</td>
                                                            <td>Kumar</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td class="switch_btn">
                                                                <label class="switch">
                                                                    <input type="checkbox" >
                                                                    <span class="slider round whitegrey_btn"></span>
                                                                </label>
                                                            </td>
                                                            <td class="actionbtns">
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/editpen.png" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
                                                                <a href="#" class="actionbtnsLinks"><img src="assets/imgs/deleteBox.png" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
                                                            </td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </article>
                                    </section>



@endsection
