@extends('admin.layouts.master')

@section('content')
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-right">
                        <button type="button" class="btn btn-sm btn-primary add_expense_type_button">New</button>
                    </div>
                    <div class="card-body">
                        @include('admin.layouts.flash-message')
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($expense_types as $type_key => $type_value)
                                        <tr>
                                            <td>{{ $type_value->id }}</td>
                                            <td>{{ $type_value->title }}</td>
                                            <td class="text-right">
                                                <a class="edit_expense_type_button" href="javascript:void(0);"
                                                    data-id="{{ $type_value->id }}" data-title="{{ $type_value->title }}"
                                                    title="Edit"><i class="mdi mdi-lead-pencil"></i></a>
                                                <a class="text-danger" href="javascript:void(0)"
                                                    onclick="deleteExpenseType('{{ $type_value->id }}')" title="Delete"><i
                                                        class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 " id="add_expense_type_div">
                <div class="card">
                    <form action="{{ route('expenses.type_add') }}" method="post" id="add_expense_type_form">
                        @csrf
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Add Expense Type</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Title</label>
                                            <input type="text" class="form-control" name="title" value=""
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4 " id="edit_expense_type_div" style="display:none">
                <div class="card">
                    <form action="{{ route('expenses.type_edit') }}" method="post" id="edit_expense_type_form">
                        @csrf
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Edit Expense Type</h3>
                                </div>
                                <div class="col-4 text-right">
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">Title</label>
                                            <input type="hidden" name="id" id="edit_modal_id">
                                            <input type="text" class="form-control" name="title" id="edit_modal_title"
                                                value="" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
@endsection
<!-- ============================================================== -->
<!-- End Container fluid  -->
@section('footer_scripts')
    <style>
        thead tr {
            white-space: nowrap;
        }
    </style>
    <script type="text/javascript">
        $(document).on('click', '.add_expense_type_button', function() {
            $('#add_expense_type_div').show();
            $('#edit_expense_type_div').hide();
        })

        $(document).on('submit', "#add_expense_type_form", function(e) {
            e.preventDefault();
            $(".preloader").show();
            var formData = new FormData(this);
            $.ajax({
                url: "{{ route('expenses.type_add') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 1) {
                        Swal.fire("Sucess!", response.message, "success");
                        setTimeout(function() {
                            location.reload()
                        }, 3000);
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                    $(".preloader").hide();
                },
            });
        });

        $(document).on('click', '.edit_expense_type_button', function() {
            var expense_type_id = $(this).data('id');
            $("#edit_modal_id").val(expense_type_id);
            var expense_type_title = $(this).data('title');
            $("#edit_modal_title").val(expense_type_title);
            $('#add_expense_type_div').hide();
            $('#edit_expense_type_div').show();
        })

        $(document).on('submit', "#edit_expense_type_form", function(e) {
            e.preventDefault();
            $(".preloader").show();
            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('expenses.type_edit') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status == 1) {
                        Swal.fire("Sucess!", response.message, "success");
                        setTimeout(function() {
                            location.reload()
                        }, 2000);
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                    $(".preloader").hide();
                },
            });
        });

        function deleteExpenseType(id) {
            Swal.fire({
                    title: "Delete?",
                    text: "Please confirm! You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((willDelete) => {
                    if (willDelete.value) {
                        $("#loader").show();
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('expenses.type_delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                'id': id
                            },
                            dataType: 'JSON',
                            success: function(results) {
                                if (results.status == 1) {
                                    Swal.fire("Success!", results.message, "success");
                                    setTimeout(function() {
                                        location.reload()
                                    }, 2000);
                                } else {
                                    Swal.fire("Error!", results.message, "error");
                                }
                                $("#loader").hide();
                            }
                        });
                    }
                });
        }
    </script>
@stop
