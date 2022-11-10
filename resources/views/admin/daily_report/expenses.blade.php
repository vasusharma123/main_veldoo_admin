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
                    <div class="card-body">
                        @include('admin.layouts.flash-message')
                        <form action="{{ route('daily-report.expenses_export') }}" autocomplete="off" method="post" >
                            @csrf
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Start Date</label>
                                            <input type="text" class="form-control" id="start_date" name="start_date"
                                                value="" required>
                                                @error('start_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label">End Date</label>
                                            <input type="text" class="form-control" id="end_date" name="end_date"
                                                value="" required>
                                                @error('end_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                    </div>
                                </div>
                                <div class="row text-right">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-sm btn-primary">Export</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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
        $("#start_date").datepicker({
            dateFormat: 'dd-mm-yy'
        });
        $("#end_date").datepicker({
            dateFormat: 'dd-mm-yy'
        });
    </script>
@stop
