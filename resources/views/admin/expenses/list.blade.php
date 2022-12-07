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
                        <form action="" id="mainFrom">
                            @csrf
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="driver" class="form-control">
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                                <option value="{{ $driver->id }}" {{ ($selected_driver == $driver->id)?"selected":"" }} class="text-capitalize">
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
                                {{-- <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="driver" class="form-control">
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                                <option value="{{ $driver->id }}">
                                                    {{ $driver->first_name . ' ' . $driver->last_name . ' (' . $driver->phone . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-sm-6"></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-control-label">Start Date</label>
                                        <input type="text" class="form-control" id="start_date" name="start_date"
                                            value="{{ $selected_from_date }}">
                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-control-label">End Date</label>
                                        <input type="text" class="form-control" id="end_date" name="end_date"
                                            value="{{ $selected_to_date }}">
                                            @error('end_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6 text-right">
                                    <button type="button" style="margin-top: 30px" class="btn btn-primary submitBtn">Search</button>
                                    <button type="button" form="abc" style="margin-top: 30px" class="btn btn-primary exportBtn">Export</button>
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
                                            <td class="text-capitalize">{{ $expense_value->driver->first_name . ' ' . $expense_value->driver->last_name }}
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
    $("#start_date").datepicker({
            dateFormat: 'dd-mm-yy'
    });
    $("#end_date").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $(document).on('click','.exportBtn',function(){
        
        $('#mainFrom').attr('action',"{{ route('daily-report.expenses_export') }}");
        $('#mainFrom').attr('method',"POST");
        $('#mainFrom').submit();
    });
    $(document).on('click','.submitBtn',function(){
        $('#mainFrom').attr('action',"{{ route('expenses.list') }}");
        $('#mainFrom').attr('method',"GET");
        $('#mainFrom').submit();
    });
</script>
@stop
