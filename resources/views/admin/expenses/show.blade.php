@extends('admin.layouts.master')

@section('css')
<link href="{{ URL::asset('assets/plugins/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">
@endsection

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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="form-control-label">ID</h3>
                                    <p>{{ $expense_detail->id }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="form-control-label">Type</h3>
                                    <p>{{ $expense_detail->type }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="form-control-label">Driver</h3>
                                    <p><a href="{{ route('showDriver',$expense_detail->driver_id) }}">{{ $expense_detail->driver->first_name . ' ' . $expense_detail->driver->last_name }}</a></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="form-control-label">Amount</h3>
                                    <p>{{ $expense_detail->amount }}</p>
                                </div>
                            </div>
                            @if(!empty($expense_detail->ride_id))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="form-control-label">Ride</h3>
                                    <p><a href="{{ route('bookings.show',$expense_detail->ride_id) }}">{{ $expense_detail->ride_id }}</a></p>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3 class="form-control-label">Created At</h3>
                                    <p>{{ date('d M, Y h:i a', strtotime($expense_detail->created_at)) }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h3 class="form-control-label">Note</h3>
                                    <p>{{ $expense_detail->note }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($expense_detail->attachments) && count($expense_detail->attachments) > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Attachments</h4>
                    </div>
                    <div class="card-body">
                        <div class="popup-gallery row m-t-30">
                            @foreach($expense_detail->attachments as $attachment_value)
                            <div class="col-md-4">
                                <a href="{{url('storage/'.$attachment_value->url)}}" title=""> <img src="{{url('storage/'.$attachment_value->url)}}" class="img-responsive" alt="img" /> </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
@endsection
<!-- ============================================================== -->
<!-- End Container fluid  -->
@section('footer_scripts')
<script src="{{ URL::asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js') }}"></script>
<script>

</script>
@stop
