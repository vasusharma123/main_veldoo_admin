@extends('admin.layouts.master')

@section('header_search_export')
<div class="search">
  <form class="search_form">
    <div class="form-group searchinput position-relative trigger_parent">
      <input
        type="text"
        name="data[q]"
        class="form-control input_search target myInput"
        placeholder="Search"
      />
      <i class="bi bi-search search_icons"></i>
    </div>
  </form>
</div>  
<div class="export_box">
  <a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
</div>
@endsection



@section('content')


<div class="formTableContent">

    <section class="name_section_box"  style="
    padding: 10px 20px 0px 20px;
">
    <article class="container_box pt-0">
        @include('company.company_flash_message')
    </article>
</section>

<div class="formTableContent">
        <section class="addEditForm sectionsform py-3"style="display:none;>
            <article class="container-fluid">
                <div class="form_add_expense" style="display:none;">
                    <form class="custom_form editForm "  action="{{ route('expense-type.store') }}" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                        @csrf    
                        <div class="row w-100 m-0 form_inside_row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row w-100 m-0">
                                    <div class="col-lg-7 col-md-7 col-sm-8 col-8 ps-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="exType" name="expenseType" placeholder="Expense type" required/>
                                            <label for="exType" class="mb-0">Add expense type</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-4 col-4 pe-0">
                                        <div class="img_user_settled h-100 me-0">
                                            
                                            <div class="form-group">
                                                <input type="submit" value="Save" name="submit" class="form-control submit_btn mt-1 mx-0" style="max-width:150px; margin-left: auto !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="update-form" style="display:none;">
                    <form id="updateForm" class="custom_form editForm "  action="{{ route('expense-type.update','~') }}" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                        @method('put')   
                        @csrf   
                        <div class="row w-100 m-0 form_inside_row edit_box">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="row w-100 m-0">
                                    <div class="col-lg-7 col-md-7 col-sm-8 col-8 ps-0">
                                        <div class="form-group">
                                            <input type="text" class="form-control inputText" id="exType" name="expenseType" placeholder="Expense type" required />
                                            <label for="exType" class="mb-0">Add expense type</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-4 col-4 pe-0">
                                        <div class="img_user_settled h-100 me-0">
                                            
                                            <div class="form-group">
                                                <input type="submit" value="Update " name="submit" class="form-control submit_btn mt-1 mx-0" style="max-width:150px; margin-left: auto !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>

                <form id="updateExpenseData"  class="custom_form editExpenseDataForm admin_edit inside_custom_form " action="{{ route('driver-expense.update','~') }}" method="POST" enctype="multipart/form-data" data-parsley-validate autocomplete="off">
                    @method('put')   
                    @csrf
                    <div class="row w-100 m-0 form_inside_row edit_expense_data_box" >
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="row w-100 m-0">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputText" id="expenseType" form="updateExpenseData" name="expenseType" placeholder="Enter Expense Type" value="" required>

                                        <!-- <input type="text" class="form-control main_field" name="name" placeholder="Name" aria-label="Name" value="{{ old('name') ? old('name') : '' }}" required> -->

                                        <label for="type">Enter Expense Type</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <input type="number" class="form-control inputText" id="amount" form="updateExpenseData" name="amount" value="" placeholder="Enter Amount" required/>
                                        
                                        <!-- <input type="email" class="form-control main_field" name="email" placeholder="Email" aria-label="Email" value="{{ old('email') ? old('email') : '' }}" required> -->
                                        <label for="amount">Enter Amount</label>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                    <textarea   class="form-control inputText" id="note" form="updateExpenseData" placeholder="Enter Note" name="note"  />
                                    </textarea >
                                    <label for="note">Enter Note</label>
                                    </div>
                                </div> 
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="img_user_settled h-100">
                                <div class="form-group">
                                    <input type="submit" form="updateExpenseData" type="submit" value="Update" class="form-control submit_btn driver_side"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </article>
        </section>
                                    
        <section class="addonTable sectionsform bg-transparent px-0 list-expense" style="display:none;">
            <article class="container-fluid">
                <div class="row m-0 w-100">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 p-0">
                        
                        <div class="table-responsive marginTbl">

                            <table class="table table-borderless table-fixed customTable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expensis as $expense)
                                    <tr>
                                        <td>{{$expense->title }}</td>
                                        <td class="actionbtns">
                                            <a class="actionbtnsLinks editButton" data-user="{{ Crypt::encrypt($expense->id) }}"><img src="{{ asset('assets/imgs/editpen.png' ) }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
                                            <a  class="actionbtnsLinks deleteButton" data-id="{{ $expense->id}}" ><img src="{{ asset('assets/imgs/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </section>

        <section class="addonTable sectionsform bg-transparent px-0 list-expense-data">
            <article class="container-fluid">
                <div class="row m-0 w-100">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                        
                        <div class="table-responsive marginTbl">

                            <table class="table table-borderless table-fixed customTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Driver</th>
                                        <th>Expense Type</th>
                                        <th>Ride Id</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenseData as $singleExpense)
                                    <tr>
                                        
                                        <td>{{$singleExpense->date }}</td>
                                        <td>{{$singleExpense->driver->first_name }}</td>
                                        <td>{{$singleExpense->type_detail }}</td>
                                        <td>{{$singleExpense->ride_id }}</td>
                                        <td>{{$singleExpense->amount }} CHF</td>
                                        <td class="actionbtns">
                                            <a class="actionbtnsLinks editExpenseData" data-user="{{ Crypt::encrypt($singleExpense->id) }}"><img src="{{ asset('assets/imgs/editpen.png' ) }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
                                            <a  class="actionbtnsLinks deleteExpenseData" data-id="{{ $singleExpense->id}}" ><img src="{{ asset('assets/imgs/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </article>
        </section>
        <form  action="{{ route('expense-type.destroy','~') }}" id="deleteForm" method="POST">
            @method('delete')
        @csrf
    </form>
    <form  action="{{ route('driver-expense.destroy','~') }}" id="deleteExpenseDataForm" method="POST">
            @method('delete')
        @csrf
    </form>
                     
</div>
					
@endsection	
@section('footer_scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$('.editButton').click(function(){ 
        user = $(this).data('user');
        event.preventDefault();
        console.log(user);
        $.ajax({
        url: '/admin/fetchExpense',
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: user,
            type: "sp"
            // Add other data as needed
        },
        success: function (data) {
            if(data.length !=0){
                
                    action = $('#updateForm').attr('action');
                    action = action.replace('~',data.id);
                    $('.edit_box').find("input[name='expenseType']").val(data.expenseType);
                    $('#updateForm').attr('action',action);
                    $('.update-form').show();
                    $('.addEditForm').show();
                    $('.form_add_expense').hide();

            }
        
        },
        error: function(xhr, status, error) {
                    console.error('Ajax request failed:', status, error);
            }
        });

});

            $(document).on('click','.deleteButton',function(){
                action = $('#deleteForm').attr('action');
                action = action.replace('~',$(this).data('id'));
                Swal.fire({
                    title: "Delete Expense Type",
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

            $(document).on('click','.deleteExpenseData',function(){
                action = $('#deleteExpenseDataForm').attr('action');
                action = action.replace('~',$(this).data('id'));
                Swal.fire({
                    title: "Delete Expense",
                    text: "Are you sure you want to delete?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $('#deleteExpenseDataForm').attr('action',action);
                        $('#deleteExpenseDataForm').submit();     // submitting the form when user press yes
                    }
                });
            }); 
            $(document).on('click','.add-expense',function(){
                $(this).addClass('active');
                $('.expense-list-active').removeClass('active');
                $('.form_add_expense').show();
                $('.addEditForm').show();
                $('.list-expense').show();
                $('.update-form').hide();
                $('.list-expense-data').hide();
                $('.editExpenseDataForm').hide();
            });
            
    $('.editExpenseData').click(function(){ 
        user = $(this).data('user');
        event.preventDefault();
        console.log(user);
        $.ajax({
        url: '/admin/fetchExpenseData',
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            id: user,
            type: "sp"
            // Add other data as needed
        },
        success: function (data) {
            if(data.length !=0){

                console.log(data);
                     action = $('#updateExpenseData').attr('action');
                     action = action.replace('~',data.id);
                     $('.edit_expense_data_box').find("input[name='amount']").val(data.amount);
                     $('.edit_expense_data_box').find("input[name='expenseType']").val(data.type_detail);
                     $('#note').val(data.note);
                     $('#updateExpenseData').attr('action',action);
                    $('.addEditForm').show();
                     $('#updateExpenseData').show();
                    // $('.addEditForm').show();
                    // $('.form_add_expense').hide();

            }
        
        },
        error: function(xhr, status, error) {
                    console.error('Ajax request failed:', status, error);
            }
        });

});

</script>
@endsection