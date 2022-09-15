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
                        <div class=" box" id="allDataUpdate">
                            <div class="table-responsive">
                                <table border="0" cellspacing="5" cellpadding="5">
                                    <tbody>
                                        <tr>
                                            <td>Start date:</td>
                                            <td><input type="text" id="min" class="filter-min" name="min"></td>
                                        </tr>
                                        <tr>
                                            <td>End date:</td>
                                            <td><input type="text" id="max" class="filter-max" name="max"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered data-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Date</th>
                                            <th>Driver</th>
                                            <th>Car</th>
                                            <th>Guest</th>
                                            <th>Pick Up</th>
                                            <th>Drop Off</th>
                                            <th>Distance</th>
                                            <th>Ride Cost</th>
                                            <th>Status</th>
                                            <th>Payment</th>
                                            <th>Action</th>
                                        </tr>
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
    <script type="text/javascript">
        $("#min").datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $("#max").datepicker({
            dateFormat: 'dd/mm/yy'
        });


        $(document).ready(function() {
            $(function() {
                var table = $('.data-table').DataTable({
                    order: [
                        [0, 'desc']
                    ],
                    processing: true,
                    serverSide: false,
                    ajax: "{{ url('admin/rides') }}",
                    'columnDefs': [{
                        'targets': [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                        'searchable': true,
                        'orderable': true,
                        'className': 'dt-body-center text-center new-class filterhead',

                    }],

                    //   'order': [1, 'desc'],

                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'driver',
                            name: 'driver'
                        },
                        {
                            data: 'car',
                            name: 'car'
                        },
                        {
                            data: 'guest',
                            name: 'guest'
                        },
                        {
                            data: 'pick_up',
                            name: 'pick_up'
                        },
                        {
                            data: 'drop_off',
                            name: 'drop_off'
                        },
                        {
                            data: 'distance',
                            name: 'distance'
                        },
                        {
                            data: 'ride_cost',
                            name: 'ride_cost'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'payment',
                            name: 'payment'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        }
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'csv', 'excel', 'pdf', 'print', 'pageLength'
                    ],
                });
                // Refilter the table
                $('#min, #max').on('change', function() {
                    table.draw();
                });
            });

            // Extend dataTables search
            $.fn.dataTableExt.afnFiltering.push(
                function(settings, data, dataIndex) {
                    var min = $('#min').val()
                    var max = $('#max').val()
                    var createdAt = data[1]; // Our date column in the table
                    //createdAt=createdAt.split(" ");
                    if (min != '' && max != '') {
                        var startDate = moment(min, 'DD-MM-YYYY');
                        var endDate = moment(max, 'DD-MM-YYYY');
                    } else {
                        var startDate = '';
                        var endDate = '';
                    }
                    var diffDate = moment(createdAt, 'DD-MM-YYYY');
                    // console.log(diffDate);
                    console.log('start' + startDate);
                    console.log('end' + endDate);
                    if (
                        (startDate === '' && endDate === '') ||
                        (startDate === '' && diffDate <= endDate) ||
                        (startDate <= diffDate && diffDate === '') ||
                        (startDate <= diffDate && diffDate <= endDate)
                    ) {
                        return true;
                    }
                    return false;
                }
            );
        });
    </script>
@stop