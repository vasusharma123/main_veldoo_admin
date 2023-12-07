@extends('master_admin.layouts.plans')
@section('content')
<section class="addonTable sectionsform">
    <article class="container-fluid">
        <div class="table-responsive marginTbl">
            
            <!-- <table class="table table-borderless table-fixed customTable" id="service-provider">
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
               
                    
                    
                </tbody>
            </table> -->


            <table class="table table-bordered yajra-datatable">
                <thead>
                    <tr>
                        <th class="text-center">Expires</th>
                        <th>Service provider</th>
                        <th>Phone number</th>
                        <th>Email Address</th>
                        <th>License type</th>
                        <th class="text-center">Plan</th>
                    </tr>
                </thead>
                <tbody>
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
        .table-responsive {
            overflow-x: scroll;
        }

        thead tr {
            white-space: nowrap;
        }

        table.dataTable td.dataTables_empty {
            text-align: center;
        }
        .buttons-csv {
            display:none !important;
        
        }
        .buttons-excel  {
            display:none !important;
        }
        #DataTables_Table_0_filter{
            display:none !important;
        }
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
  $(function () {

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        "lengthMenu": [10],
        ajax: "/fetchServiceProvider",
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'csv',
                text: 'Download CSV',
                filename: 'service_provider',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Include only columns with indices 0, 1, and 3
                }
            
            },
            {
                extend: 'excel',
                text: 'Download excel',
                filename: 'service_provider',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4] // Include only columns with indices 0, 1, and 3
                }
            
            }
        ],
        columns: [
            {data: 'expire_at', name: 'expire_at'},
            {data: 'service_provider_name', name: 'service_provider_name'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'email_address', name: 'email_address'},
            {data: 'license_type', name: 'license_type'},
           
                {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });

        $('#searchInput').on('keyup', function() {
            var searchValue = $(this).val();
            table.search(searchValue).draw();
        });

        $('.iconExportLink').on('click', function() {
        // Trigger the DataTables CSV export
        table.button('.buttons-csv').trigger();
    });


  });
</script>
@stop
