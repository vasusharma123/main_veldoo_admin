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
                        <form action="{{ route('daily-report.vehicle_export') }}" autocomplete="off" method="post" >
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
                                            <label class="form-control-label">Vehicle</label>
                                            <select class="form-control" name="vehicle_id" required>
                                                <option value="">-- Select Vehicle --</option>
                                                @foreach($vehicles as $vehicle_key => $vehicle_value)
                                                <option value="{{ $vehicle_value->id }}">{{ $vehicle_value->vehicle_number_plate." (".$vehicle_value->model." - ".$vehicle_value->year.")" }}</option>
                                                @endforeach
                                            </select>
                                            @error('driver_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
