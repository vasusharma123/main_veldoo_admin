@extends('admin.layouts.master')

@section('content')
<style>
    .c-pagination {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.25rem;
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
                <div class="card">
                    <div class="card-body">
                        @include('admin.layouts.flash-message')
                        <form action="">
                            <div class="d-flex">
                                <div class="form-group mr-2">
                                    <label for="">Start Date</label>
                                    <input type="text" id="min" value="{{ $start_date }}" class="filter-min" name="min">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="">End Date</label>
                                    <input type="text" id="max" value="{{ $end_date }}" class="filter-max" name="max">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="">Enter Keyword</label>
                                    <input type="text" class="filter-min" name="search" placeholder="Search keyword" value="{{ isset($_GET) && isset($_GET['search'])?$_GET['search']:'' }}">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-info btn-sm">
                                        Search
                                    </button>
                                    @if (isset($_GET) && !empty($_GET))
                                        <a class="btn btn-success btn-sm" href="{{ route('rides.index') }}">
                                            Clear
                                        </a>
                                    @endif
                                    <a class="btn btn-primary btn-sm" href="{{ route('ride/export') }}">
                                        Export
                                    </a>
                                </div>
                            </div>
                        </form>
                        {{-- <div class="row">
                            <div class="col-6">
                                <table border="0" cellspacing="5" cellpadding="5">
                                    <tbody>
                                        <tr>
                                            <td>Start date:</td>
                                            <td><input type="text" id="min" value="{{ $start_date }}" class="filter-min" name="min"></td>
                                        </tr>
                                        <tr>
                                            <td>End date:</td>
                                            <td><input type="text" id="max" value="{{ $end_date }}" class="filter-max" name="max"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-6">
                                <form action="">
                                    <table border="0" style="float: right" cellspacing="5" cellpadding="5">
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <input type="text" class="filter-min" name="search" placeholder="Search keyword" value="{{ isset($_GET) && isset($_GET['search'])?$_GET['search']:'' }}" required>
                                                    <button class="btn btn-info btn-sm">
                                                        Search
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div> --}}
                        <div class="box" id="">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>
                                                <button type="button" id='delete_record' class="btn btn-outline-secondary btn-sm" title="Delete Selected Rides">Delete</button>
                                            </th>
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
                                            <th>Payment Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rides as $ride)
                                            <tr>
                                                <td class="text-center">
                                                    <label class="custom-control custom-checkbox text-center" style="display: inline">
                                                        <input type="checkbox" data-id="{{ $ride->id }}" class="custom-control-input editor-active">
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </td>
                                                <td>{{ $ride->id }}</td>
                                                <td>{{ date('d/m/Y', strtotime($ride->ride_time)) }}</td>
                                                <td>{{ ucfirst($ride->first_name . ' ' . $ride->last_name) }}</td>
                                                <td>{{ ucfirst($ride->vehicle_number_plate) }}</td>
                                                <td>{{ ucfirst($ride->guest_first_name . ' ' . $ride->guest_last_name) }}</td>
                                                <td>{{ ucfirst($ride->pickup_address) }}</td>
                                                <td>{{ ucfirst($ride->dest_address) }}</td>
                                                <td>{{ ucfirst($ride->distance) }}</td>
                                                <td>{{ number_format($ride->ride_cost, 2) }}</td>
                                                <td>
                                                    @if ($ride->status == 0)
                                                        <label class="badge badge-info">Process</label>
                                                    @elseif ($ride->status == 1)
                                                        <label class="badge badge-warning">Accepted By Driver</label>
                                                    @elseif ($ride->status == 2)
                                                        <label class="badge badge-info">Ride Start</label>
                                                    @elseif ($ride->status == 3)
                                                        <label class="badge badge-success">Completed </label>
                                                    @elseif ($ride->status == 4)
                                                        <label class="badge badge-info">Driver Reached To Customer </label>
                                                    @elseif ($ride->status == -2)
                                                        <label class="badge badge-danger">Cancelled</label>
                                                    @elseif ($ride->status == -4 or $ride->status == 5)
                                                        <label class="badge badge-warning">Pending</label>
                                                    @elseif ($ride->status == -3)
                                                        <label class="badge badge-danger">Cancelled By Customer</label>
                                                    @endif
                                                </td>
                                                <td>{{ ucfirst($ride->payment_type) }}</td>
                                                <td>
                                                    <div class="btn-group dropright">
                                                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('bookings.show', $ride->id) }}">{{ trans("admin.View") }}</a>
                                                            <a class="dropdown-item delete_record" data-id="{{ $ride->id }}">{{ trans("admin.Delete") }}</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {{ $rides->appends($_GET)->links('vendor.pagination.bootstrap-4-c') }}
                                </div>
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

        $(document).on('change','#min, #max',function(){

            var min = $('#min').val();
            var max = $('#max').val();
            if (min != '' && max != '') {
                // var startDate = moment(min, 'DD-MM-YYYY');
                // var endDate = moment(max, 'DD-MM-YYYY');
                window.location.href = "{{ route('rides.index') }}?start_date="+min+"&end_date="+max;
            }
        });


        // $(document).ready(function() {
        //     $(function() {
        //         var table = $('.data-table').DataTable({
        //             order: [
        //                 [1, 'desc']
        //             ],
        //             processing: true,
        //             serverSide: true,
        //             ajax: "{{ url('admin/rides') }}",
        //             'columnDefs': [{
        //                     'targets': [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
        //                     'searchable': true,
        //                     'orderable': true,
        //                     'className': 'dt-body-center text-center new-class filterhead',

        //                 },
        //                 {
        //                     'targets': [0],
        //                     'searchable': false,
        //                     'orderable': false

        //                 }
        //             ],

        //             //   'order': [1, 'desc'],

        //             columns: [{
        //                     data: 'checkboxes',
        //                     name: 'checkboxes'
        //                 },
        //                 {
        //                     data: 'id',
        //                     name: 'id'
        //                 },
        //                 // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        //                 {
        //                     data: 'date',
        //                     name: 'date'
        //                 },
        //                 {
        //                     data: 'driver',
        //                     name: 'driver'
        //                 },
        //                 {
        //                     data: 'car',
        //                     name: 'car'
        //                 },
        //                 {
        //                     data: 'guest',
        //                     name: 'guest'
        //                 },
        //                 {
        //                     data: 'pick_up',
        //                     name: 'pick_up'
        //                 },
        //                 {
        //                     data: 'drop_off',
        //                     name: 'drop_off'
        //                 },
        //                 {
        //                     data: 'distance',
        //                     name: 'distance'
        //                 },
        //                 {
        //                     data: 'ride_cost',
        //                     name: 'ride_cost'
        //                 },
        //                 {
        //                     data: 'status',
        //                     name: 'status'
        //                 },
        //                 {
        //                     data: 'payment',
        //                     name: 'payment'
        //                 },
        //                 {
        //                     data: 'action',
        //                     name: 'action'
        //                 }
        //             ],
        //             dom: 'Bfrtip',
        //             buttons: [{
        //                     "extend": 'excel',
        //                     "text": 'Excel',
        //                     "titleAttr": 'Excel Export',
        //                     "action": excelexportaction
        //                 },
        //                 'pageLength'
        //             ],
        //         });
        //         // Refilter the table
        //         $('#min, #max').on('change', function() {
        //             table.draw();
        //         });
        //     });

        //     function excelexportaction() {
        //         window.location.href = "{{ route('ride/export') }}";
        //     }

        //     // Extend dataTables search
        //     $.fn.dataTableExt.afnFiltering.push(
        //         function(settings, data, dataIndex) {
        //             var min = $('#min').val()
        //             var max = $('#max').val()
        //             var createdAt = data[2]; // Our date column in the table
        //             //createdAt=createdAt.split(" ");
        //             if (min != '' && max != '') {
        //                 var startDate = moment(min, 'DD-MM-YYYY');
        //                 var endDate = moment(max, 'DD-MM-YYYY');
        //             } else {
        //                 var startDate = '';
        //                 var endDate = '';
        //             }
        //             var diffDate = moment(createdAt, 'DD-MM-YYYY');
        //             // console.log(diffDate);
        //             console.log('start' + startDate);
        //             console.log('end' + endDate);
        //             if (
        //                 (startDate === '' && endDate === '') ||
        //                 (startDate === '' && diffDate <= endDate) ||
        //                 (startDate <= diffDate && diffDate === '') ||
        //                 (startDate <= diffDate && diffDate <= endDate)
        //             ) {
        //                 return true;
        //             }
        //             return false;
        //         }
        //     );
        // });

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
                    var ride_id = $(this).attr('data-id');
                    $.ajax({
                        type: "delete",
                        url: "{{ url('admin/rides') }}/" + ride_id,
                        data: {
                            "_token": "{{ csrf_token() }}"
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
                            url: "{{ route('ride/delete_multiple') }}",
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
        })
    </script>
@stop
