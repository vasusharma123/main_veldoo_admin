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
                                        <th>Driver</th>
                                        <th>Type</th>
                                        <th>Ride ID</th>
                                        <th>Amount</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($expenses as $expense_key => $expense_value)
                                        <tr>
                                            <td>{{ $expense_value->id }}</td>
                                            <td>{{ $expense_value->driver->first_name ."". $expense_value->driver->last_name }}</td>
                                            <td>{{ $expense_value->type }}</td>
                                            <td><a href="#">{{ (!empty($expense_value->ride_id))?$expense_value->ride_id:'' }}</a></td>
                                            <td>&#36;{{ $expense_value->amount }}</td>
                                            <td class="text-right">
                                                <a class="edit_expense_type_button" href="javascript:void(0);" title="Edit"><i class="mdi mdi-lead-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
        thead tr {
            white-space: nowrap;
        }
    </style>
    <script type="text/javascript">

    </script>
@stop
