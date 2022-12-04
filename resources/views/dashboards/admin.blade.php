@extends('admin.layouts.master')

@section('content')
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="card-group">
                <div class="card">
                    <a href="{{route('users.index')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-car text-success"></i></h2>
                                    <h3 class="">{{$rider_count}}</h3>
                                    <h6 class="card-subtitle">Total Users</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 40%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="card">
                    <a href="{{route('users.drivers')}}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="m-b-0"><i class="mdi mdi-account-circle text-purple"></i></h2>
                                    <h3 class="">{{$driver_count}}</h3>
                                    <h6 class="card-subtitle">Total Drivers</h6></div>
                                <div class="col-12">
                                    <div class="progress">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div> 
                <div class="card">
                    <a href="{{url('admin/rides')}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="m-b-0"><i class="mdi mdi-account-circle text-warning"></i></h2>
                                <h3 class="">{{$booking_count}}</h3>
                                <h6 class="card-subtitle">Total Bookings</h6></div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
        </div>
                    <div class="card-group">
                        <div class="card">
                        <a href="{{url('admin/booking/past-bookings')}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-account-circle text-success"></i></h2>
                                        <h3 class="">{{$past_booking_count}}</h3>
                                        <h6 class="card-subtitle">Past Bookings</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    <div class="card">
                        <a href="{{url('admin/booking/current-bookings')}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-account-circle text-warning"></i></h2>
                                        <h3 class="">{{$current_booking_count}}</h3>
                                        <h6 class="card-subtitle">Current Bookings</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    <div class="card">
                        <a href="{{url('admin/booking/upcoming-bookings')}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-account-circle text-info"></i></h2>
                                        <h3 class="">{{$upcoming_booking_count}}</h3>
                                        <h6 class="card-subtitle">Upcoming Bookings</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                </div>
                    <div class="card-group">
                        <div class="card">
                        <a href="javascript:;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-currency-usd text-primary"></i></h2>
                                        <h3 class="">{{$revenue}}</h3>
                                        <h6 class="card-subtitle">Total Revenue</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="card">
                        <a href="{{route('company.index')}}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-account-circle text-primary"></i></h2>
                                        <h3 class="">{{$companies_registered}}</h3>
                                        <h6 class="card-subtitle">Company Registered</h6></div>
                                    <div class="col-12">
                                        <div class="progress">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 56%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <p id="demo"></p>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var x = document.getElementById("demo");

        //function getLocation() {
            $(function(){
        if (navigator.geolocation) {
            navigator.geolocation.watchPosition(showPosition);
        } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
            });
        //}
            
        function showPosition(position) {
            var lat=position.coords.latitude;
            var lng=position.coords.longitude;
            $.ajax({
                type: "GET",
                url: "{{url('admin/update-lat-long')}}",
                data : {lat:lat,lng:lng},
                success: function (data) {
                    
                }
            });
        
        }
    </script>
@stop
