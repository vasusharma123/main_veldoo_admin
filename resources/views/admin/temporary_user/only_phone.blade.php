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
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Country Code</th>
                                        <th>Phone</th>
                                        <th>Created By</th>
                                        <th>Created On</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @foreach ($users as $user_key => $user_value)
                                        <tr>
                                            <td>{{ (!empty($user_value->country_code))?"+".$user_value->country_code:"" }}</td>
                                            <td>{{ $user_value->phone }}</td>
                                            <td>{{ $user_value->creator->full_name }}</td>
                                            <td>{{ date('d M, Y h:i a', strtotime($user_value->created_at)) }}</td>
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

@stop
