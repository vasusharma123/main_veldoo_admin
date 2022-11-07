@extends('admin.layouts.master')

@section('content')
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('expenses.list') }}">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="driver" class="form-control">
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                                <option value="{{ $driver->id }}" {{ ($selected_driver == $driver->id)?"selected":"" }}>
                                                    {{ $driver->first_name . ' ' . $driver->last_name . ' (' . $driver->phone . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="expense_type" class="form-control">
                                            <option value="" >Select Expense Type</option>
                                            @foreach ($expense_types as $expense_type)
                                                <option value="{{ $expense_type->type }}" {{ ($selected_expense_type == $expense_type->type)?"selected":"" }}>{{ $expense_type->type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </form>
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
                                        <th>Date</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($expenses as $expense_key => $expense_value)
                                        <tr>
                                            <td>{{ $expense_value->id }}</td>
                                            <td>{{ $expense_value->driver->first_name . '' . $expense_value->driver->last_name }}
                                            </td>
                                            <td>{{ $expense_value->type }}</td>
                                            <td><a href="{{ route('bookings.show',$expense_value->ride_id) }}">{{ !empty($expense_value->ride_id) ? $expense_value->ride_id : '' }}</a>
                                            </td>
                                            <td>&#36;{{ $expense_value->amount }}</td>
                                            <td>{{ date('d M, Y', strtotime($expense_value->created_at)) }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('expenses.show',$expense_value->id) }}"
                                                    title="View"><i class="mdi mdi-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer py-4">
                            <nav aria-label="...">
                                {{ $expenses->appends(['driver' => $selected_driver, 'expense_type' => $selected_expense_type])->links() }}
                            </nav>
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
<script>
    $(document).find(".pagination").addClass("laravel_pagination");
</script>
@stop
