@extends('company.layouts.app')
@section('content')
{{ Form::open(array('url' => route('company-users.store'),'class'=>'form-horizontal form-material add_details_form','id'=>'store','enctype' => 'multipart/form-data')) }}
    @csrf
    <div class="row">
        <div class="col-12">
            <h2 class="board_title">Users</h2>
            @include('company.company_flash_message')
        </div>
        <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 col-xs-12">
            <div class="search_list">
                <div class="searc_input">
                    <input type="search" class="form-control input_fields_search search_input" placeholder="Search">
                    <i class="bi bi-search button_search"></i>
                </div>
                <div class="list_search_output">
                    <ul class="list-group list-group-flush usersLiPar">
                        @foreach ($users as $key=>$user)
                            <li class="list-group-item usersLi" data-key="{{ $key }}">
                                <a href="#"> 
                                    <span class="point_list position-relative text-capitalize">
                                        <input type="checkbox" name="selectedPoint" class="input_radio_selected">
                                        {{ $user->first_name.' '.$user->last_name }}
                                    </span>
                                </a> 
                                <span class="action_button deleteButton" data-id="{{ $user->id }}" style="cursor: pointer">
                                    {{-- <span class="code_country position-relative">SA</span>  --}}
                                    <i class="bi bi-trash3 dlt_list_btn"></i>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- List Search End -->
            </div>
            <!-- Search List -->
            <div class="details_box add_box">
                <div class="boxHeader">
                    <h2 class="board_title mb-0">Add User</h2>
                    <button class="btn save_btn">Add</button>
                </div>
                {{-- <div class="form-group">
                    <input type="text" class="form-control inside_input_field mb-2" placeholder="First Name" required />
                </div> --}}
                <div class="form-group">
                    <input type="text" name="phone" id="Regphones" class="form-control inside_input_field mb-2" placeholder="Phone Number"/>
                    <input type="hidden" value="+1" class="country_code" id="country_code" name="country_code" />
                </div>
                <div class="check_user_info">
                    <div class="form-group " style="text-align: right">
                        <button class="btn save_btn check_user_info_btn" type="button">Check</button>
                    </div>
                </div>
                <div class="user_info" style="display: none">
                    <div class="form-group">
                        <input type="text" class="form-control inside_input_field mb-2" name="first_name" placeholder="First Name" required />
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control inside_input_field mb-2" name="last_name" placeholder="Last Name" required />
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control inside_input_field mb-2" name="email" placeholder="Email" required />
                    </div>
                </div>
                {{-- <div class="form-group">
                    <input type="password" class="form-control inside_input_field mb-2" name="password" placeholder="Password" required />
                </div> --}}
                {{-- <div class="form-group">
                    <textarea class="form-control inside_input_field mb-2" required placeholder="Note" rows="5"></textarea>
                </div> --}}
            </div>
            <div class="details_box edit_box" style="display: none">
                <div class="boxHeader">
                    <h2 class="board_title mb-0">Edit Manager</h2>
                    <button class="btn save_btn" type="submit" form="updateForm">Update</button>
                    <button class="btn save_btn add_new_manager_btn" type="button">Add</button>
                </div>
                {{-- <div class="form-group">
                    <input type="text" class="form-control inside_input_field mb-2" placeholder="First Name" required />
                </div> --}}
                <div class="form-group">
                    <input type="text" class="form-control inside_input_field mb-2" form="updateForm" name="first_name" placeholder="First Name" required />
                </div>
                <div class="form-group">
                    <input type="text" class="form-control inside_input_field mb-2" form="updateForm" name="last_name" placeholder="Last Name" required />
                </div>
                <div class="form-group">
                    <input type="text" name="phone" id="Regphones_edit" form="updateForm" class="form-control inside_input_field mb-2" placeholder="Phone Number"/>
                    <input type="hidden" value="+1" class="country_code_edit" form="updateForm" id="country_code_edit" name="country_code" />
                </div>
                <div class="form-group">
                    <input type="email" class="form-control inside_input_field mb-2" form="updateForm" name="email" placeholder="Email" required />
                </div>
                {{-- <div class="form-group">
                    <input type="password" class="form-control inside_input_field mb-2" form="updateForm" name="password" placeholder="Password"/>
                    <span class="text-gray" style="font-size: 12px">Enter Password If you want to change</span>
                </div> --}}
                {{-- <div class="form-group">
                    <textarea class="form-control inside_input_field mb-2" required placeholder="Note" rows="5"></textarea>
                </div> --}}
            </div>
        </div>
        <!-- Left Side Board -->
        <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 col-xs-12">
            <div class="map_views h-100">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d102152.55978232603!2d75.46373732010797!3d31.370071732694594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1673768174190!5m2!1sen!2sin" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
        <!-- Right Map Side-->
    </div>
</form>
<form onsubmit="return confirm('Are you sure?')" action="{{ route('company-users.destroy','~') }}" id="deleteForm" method="POST">
    @method('delete')
    @csrf
</form>
<form action="{{ route('company-users.update','~') }}" id="updateForm" method="POST">
    @method('put')
    @csrf
</form>
@endsection
<!-- ============================================================== -->
<!-- End Container fluid  -->
@section('footer_scripts')
    <script type="text/javascript">
        users_fixed = JSON.parse('<?php echo ($users) ?>');
        users = JSON.parse('<?php echo ($users) ?>');

        $(document).on('click','.check_user_info_btn',function(){
            country_code = $('#country_code').val();
            phone = $('#Regphones').val();
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
                        location.reload();
                    }
                    if (data.status==2) 
                    {
                        alert('User not found. please fill additional information');
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
            $('#deleteForm').attr('action',action);
            $('#deleteForm').submit();
        });
        $(document).on('click','.add_new_manager_btn',function(){
            $('.edit_box').hide();
            $('.add_box').show();
            $('.check_user_info').show();
            $('.user_info').hide();
        });
        $(document).on('click','.usersLi',function(){
            user = users[$(this).data('key')];
            action = $('#updateForm').attr('action');
            action = action.replace('~',user.id);
            $('#updateForm').attr('action',action);

            $('.edit_box').find("input[name='first_name']").val(user.first_name);
            $('.edit_box').find("input[name='last_name']").val(user.last_name);
            $('.edit_box').find("input[name='phone']").val(user.phone);
            $('.edit_box').find("input[name='country_code']").val(user.country_code);
            $('.edit_box').find("input[name='email']").val(user.email);

            input_edit = $('#Regphones_edit').intlTelInput("setNumber","+"+user.country_code+user.phone);
            input_edit.on("countrychange", function() {
                $(".country_code_edit").val($("#Regphones_edit").intlTelInput("getSelectedCountryData").dialCode);
            });

            $('.edit_box').show();
            $('.add_box').hide();
        });
        $(document).on('click', '#delete_record', function(e) {
            e.preventDefault();
            var selected_checkbox = [];
            $("input.editor-active:checked").each(function() {
                selected_checkbox.push($(this).data("id"));
            });
            if (selected_checkbox.length) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete these rides!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "delete",
                            url: "{{ route('company.rides.delete_multiple') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "selected_ids": selected_checkbox
                            },
                            success: function(data) {
                                if (data.status) {
                                    Swal.fire({
                                        title: 'Deleted',
                                        text: data.message,
                                        icon: 'success',
                                        showConfirmButton: false
                                    });
                                    setTimeout(function() {
                                        location.reload(true);
                                    }, 2000);
                                } else {
                                    Swal.fire(
                                        'Error',
                                        data.message,
                                        'error'
                                    )
                                }
                            }
                        });
                    }
                });
            } else {
                Swal.fire(
                    'Error',
                    "Select atleast one ride",
                    'error'
                )
            }
        });

        $(document).on('keyup','.search_input',function(){
            if ($(this).val()!="") 
            {
                filters.searchText = $(this).val();
                filterUsers = renderBySearch(users_fixed, filters,"users");
            }
            else
            {
                filterUsers = users_fixed;
            }
            div = "";
            $.each(filterUsers, function (index, filterUser) {
                div += `<li class="list-group-item usersLi" data-key="`+index+`">
                                <a href="#"> 
                                    <span class="point_list position-relative text-capitalize">
                                        <input type="checkbox" name="selectedPoint" class="input_radio_selected">
                                        `+filterUser.first_name+` `+filterUser.last_name+`
                                    </span>
                                </a> 
                                <span class="action_button deleteButton" data-id=" `+filterUser.id+`" style="cursor: pointer">
                                    <i class="bi bi-trash3 dlt_list_btn"></i>
                                </span>
                            </li>`;
            });
            $('.usersLiPar').html(div);
        });
    </script>
@stop
