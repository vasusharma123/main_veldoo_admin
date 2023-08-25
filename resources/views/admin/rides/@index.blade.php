@extends('admin.layouts.master')

@section('content')
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card" >
                    <div class="card-body">
                        @include('admin.layouts.flash-message')
                        
                    
                        <div class=" box" id="allDataUpdate">
                            <div class="">
                
                                <table border="0" cellspacing="5" cellpadding="5">
        <tbody><tr>
            <td>Start date:</td>
            <td><input type="text" id="min" class="filter-min" name="min"></td>
        </tr>
        <tr>
            <td>End date:</td>
            <td><input type="text" id="max" class="filter-max" name="max"></td>
        </tr>
    </tbody></table>
    <table class="table table-bordered data-table table-responsive " width="100%">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Week</th>
                <th>Day</th>
                <th>Date</th>
                <th>Driver</th>
                <th>Car</th>
                <th>Guest</th>
                <th>Pick Up</th>
                <th>Drop Off</th>
                <th>Distance</th>
                <th>Status</th>
                <th>Comment</th>
                <th>Payment</th>
                
            </tr>
        </thead>
        <tbody>
            
            
        </tbody>
    </table>
</div>
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
.table-responsive{
    overflow-x: scroll;
}
thead tr{
    white-space: nowrap;
}
table.dataTable td.dataTables_empty {
    text-align: center;
}
</style>
<script type="text/javascript">
$("#min").datepicker({ dateFormat: 'dd/mm/yy'});
 $("#max").datepicker({ dateFormat: 'dd/mm/yy'});
        

$(document).ready(function(){
   $(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: false,
           ajax: "{{ url('admin/rides') }}",
               'columnDefs': [{
         'targets': [0,1,2,3,4,5,6,7,8,9,10,11,12],
         'searchable':true,
         'orderable':true,
          'className': 'dt-body-center text-center new-class filterhead',
             
      } 
      ],
       
         //   'order': [1, 'desc'],
          
            columns: [
                // {
                    // data: 'id',
                    // name: 'id'
                // },

                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {
                    data: 'week',
                    name: 'week'
                },
                {
                    data: 'day',
                    name: 'day',
                    orderable: true, searchable: true
                },
               
                {
                    data: 'date',
                    name: 'date'
                },
                {
                    data:'driver',
                    name:'driver'
                },
                {
                    data:'car',
                    name:'car'
                },
                {
                    data: 'guest',
                    name: 'guest'
                },
                {
                    data: 'pick_up',
                    name: 'pick_up'
                },
                {
                    data: 'drop_off',
                    name: 'drop_off'
                },
                {
                    data: 'distance',
                    name: 'distance'
                },
                 {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'comment',
                    name: 'comment'
                },
                {
                    data: 'payment',
                    name: 'payment'
                },
                
                
            ],
            dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf', 'print', 'pageLength'
        ],  
        });
         // Refilter the table
        $('#min, #max').on('change', function () {
            
            table.draw();
        });
   
   });   

 
        // Extend dataTables search
  $.fn.dataTableExt.afnFiltering.push(
        function( settings, data, dataIndex ) {
            var min  = $('#min').val()
            var max  = $('#max').val()
            var createdAt = data[3]; // Our date column in the table
            //createdAt=createdAt.split(" ");
            var startDate   = moment(min,'DD-MM-YYYY');
            var endDate     = moment(max,'DD-MM-YYYY');
            var diffDate = moment(createdAt,'DD-MM-YYYY');
            console.log(diffDate);
            console.log(startDate);
            console.log(endDate);
            if (
              (startDate === null && endDate ===null) ||
              (startDate===null && diffDate <= endDate) ||
              (startDate<=diffDate && diffDate ===null) ||
              (startDate<= diffDate && diffDate <= endDate)
              

            ) {  return true;  }
            return false;

        }
    );

        
    });

   

</script>
@stop