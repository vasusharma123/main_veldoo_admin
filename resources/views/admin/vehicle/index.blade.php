@extends('admin.layouts.master')

@section('content')
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @include('admin.layouts.flash-message')

                        <div class="box" id="allDataUpdate">
                            <div class="table-responsive">
                                <table class="table table-bordered data-table">
                                    <thead class="thead-light">
                                        <th>ID</th>
                                        <th>Car Type</th>
                                        <th>Year</th>
                                        <th>Model</th>
                                        <th>Color</th>
                                        <th>Vehicle Image</th>
                                        <th>Vehicle Number Plate</th>
                                        <th>Mileage</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <style>
        .table-responsive {
            overflow-x: scroll;
        }

        thead tr {
            white-space: nowrap;
        }

        table.dataTable td.dataTables_empty {
            text-align: center;
        }
    </style>
    <script src="http://cdn.jsdelivr.net/npm/sweetalert2@10.5.0/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        $(function() {
            var table = $('.data-table').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ url('admin/vehicle') }}",
                'columnDefs': [{
                    'targets': [0, 1, 2, 3, 4, 5, 6, 7],
                    'searchable': true,
                    'orderable': true,
                    'className': 'dt-body-center text-center new-class',

                }],

                //   'order': [1, 'desc'],

                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {
                        data: 'car_type',
                        name: 'car_type',
                        orderable: true,
                        searchable: true
                    },

                    {
                        data: 'year',
                        name: 'year'
                    },
                    {
                        data: 'model',
                        name: 'model'
                    },
                    {
                        data: 'color',
                        name: 'color'
                    },
                    {
                        data: 'vehicle_image',
                        name: 'vehicle_image'
                    },
                    {
                        data: 'vehicle_number_plate',
                        name: 'vehicle_number_plate'
                    }, {
                        data: 'mileage',
                        name: 'mileage'
                    }, {
                        data: 'action',
                        name: 'action'
                    },

                ],
                dom: 'Bfrtip',
                buttons: [
                    'pageLength'
                ],
            });
        });


        $(document).on('click', '.delete_record', function() {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Deleted',
                        text: "Vehicle has been deleted.",
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    var user_id = $(this).attr('data-id');

                    $.ajax({
                        type: "post",
                        url: "{{ url('admin/vehicle/delete') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": user_id,
                        },
                        success: function(data) {

                            if (data) {
                                location.reload(true);
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.car_free', function() {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Free it!'
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Success',
                        text: "Car has been update  successfully.",
                        icon: 'success',
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                    var carId = $(this).attr('data-id');

                    $.ajax({
                        type: "post",
                        url: "{{ url('admin/vehicle/carFree') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": carId,
                        },
                        success: function(data) {

                            if (data) {
                                location.reload(true);
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop
