@extends('master_admin.layouts.after_login')

@section('header_menu_list')
    <li class="nav-item">
        <a class="nav-link active" href="/service-provider">List</a>
    </li>
@endsection

<?php // dd($data['user']); ?>
@section('header_search_export')
    <div class="search">
        <form class="search_form">
            <div class="form-group searchinput position-relative trigger_parent">
                <input type="text" class="form-control input_search target" placeholder="Search" id="searchInput" />
                <!-- <button type="submit" id="searchBtn" form="form1" value="Submit">Submit</button> -->
                <i class="bi bi-search search_icons"></i>
            </div>
        </form>
    </div>
    <div class="export_box">
        <a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
    </div>
@endsection

@section('content')
    <section class="addonTable sectionsform">
        <article class="container-fluid">
            <div class="table-responsive marginTbl">

                <table class="table table-borderless table-fixed customTable" id="service-provider">
                    <thead>
                        <tr>
                            <th class="text-center">Expires</th>
                            <th>Service provider</th>
                            <th>Phone number</th>
                            <th>Email Adress</th>
                            <th>License type</th>
                            <th class="text-center">Plan</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach($data['user'] as $user)
                        <tr>
                            
                            <td class="text-center">{{ $user['plans'] ? $user['plans']['expire_at'] : '' }}</td>
                            <td>{{$user['name']}}</td>
                            <td>+{{$user['country_code']}} {{$user['phone']}}</td>
                            <td>{{$user['email']}}</td>
                            <td>{{ $user['plans'] ? $user['plans']['plan']['plan_type'] : ''}}</td>
                            <td class="text-center">
                                @if ($user['plans'])
                                    <a class="plan valid"  href="/service-provider/current-plan?id={{ Crypt::encrypt($user['plans']['id']) }}">{{ $user['plans']['plan']['plan_name'] }}</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </article>
</section>
@endsection

@section('footer_scripts')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <style>
    </style>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10.5.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script>

    <script type="text/javascript">
       

    $(document).ready(function () {
        $('#searchInput').on('keyup', function () {
       
            var search = $('#searchInput').val();
            //console.log('Text typed: ' + $(this).val());
            //alert(search);
            $.ajax({
            url: '/fetchServiceProvider',
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                search: search,
                // Add other data as needed
            },
            success: function (data) {
                // Handle the received data
                var rowHtml ="";
                console.log(data);
                $('#service-provider tbody').empty();
                if(data.length !=0){
                    //alert('sdfs');
                    data.forEach(function(user) {
                        rowHtml += '<tr>';

                    // $('#service-provider tbody').append('<tr><td>' + user.expire_at + '</td><td>' + user.name + '</td><td>' + '+' + user.country_code + ' ' + user.phone + '</td><td>' + user.email + '</td><td>' + user.license_type + '</td><td>' + user.plan_name + '</td></tr>');
                    if(user.expire_at){
                        rowHtml += '<td>' + user.expire_at+ '</td>';
                    }else{
                        rowHtml += '<td> </td>';
                    }

                    if(user.name){
                        rowHtml += '<td>' + user.name+ '</td>';
                    }else{
                        rowHtml += '<td> </td>';
                    }
                    if(user.phone){
                        rowHtml += '<td>' + '+' + user.country_code + ' ' + user.phone+ '</td>';
                    }else{
                        rowHtml += '<td> </td>';
                    }
                    if(user.email){
                        rowHtml += '<td>' + user.email+ '</td>';
                    }else{
                        rowHtml += '<td> </td>';
                    }
                    if(user.license_type){
                        rowHtml += '<td>' + user.license_type+ '</td>';
                    }else{
                        rowHtml += '<td> </td>';
                    }
                    if(user.plan_name){
                        rowHtml += '<td class="text-center"><a class="plan valid"  href="/service-provider/current-plan?id='+user.encrypted_plan_attribute+'"</a>' + user.plan_name+ '</a></td>';
                    }else{
                        rowHtml += '<td class="text-center> </td>';
                    }
                    
                    rowHtml += '</tr>';
                    });

                
                    
                }else{
                    rowHtml += '<tr style="text-align: center;"><td colspan="6"> No data found</td></tr>';
                }
                $('#service-provider tbody').append(rowHtml);
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });


            // $.ajax({
            //     url: "/fetchServiceProvider",
            //     type: 'get',
            //     dataType: 'json',
            //     success: function(response) {
            //         alert(response);
            //     },
            //     error(response) {
            //         console.log(response.message);
            //         new swal("{{ __('Error') }}",response.message,"error");
            //         $(document).find(".verify_otp").removeAttr('disabled');
            //     }
            // });


        });


    });

    </script>
@stop
