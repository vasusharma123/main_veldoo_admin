<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
	@if(!empty($setting['admin_favicon']) && file_exists('storage/'.$setting['admin_favicon']))
		<link rel="icon" type="image/png" sizes="16x16" href="{{ config('app.url_public').'/'.$setting['admin_favicon'] }}">
	@else
		<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png')}}">
	@endif
		<title>{{ (!empty($action) ? $action : '').(!empty($setting['site_name']) ? ' | '.$setting['site_name'] : ' | Admin') }}</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('/assets/css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('/assets/css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/sweetalert/sweetalert.css')}}" id="theme" rel="stylesheet">
	<!--BOOSTRAP DATEPICKER-->
    <link href="{{ asset('/assets/plugins/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
	<!--ION RANGE SLIDER-->
    <link href="{{ asset('/assets/plugins/ion-rangeslider/css/ion.rangeSlider.css')}}" rel="stylesheet">
    <link href="{{ asset('/assets/plugins/ion-rangeslider/css/ion.rangeSlider.skinModern.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
	<!--SELECT 2-->
    <link href="{{ asset('/assets/plugins/select2/dist/css/select2.css')}}" rel="stylesheet">
	<!--bootstrap3-->
	@yield ('css')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
	<style>
	@if(!empty($setting['admin_primary_color']))
		:root {
			--primary-color: {{ $setting['admin_primary_color'] }} !important;
		}
	@else
		:root {
			--primary-color: #1976d2 !important;
		}
	@endif	
		#loading {
			background-color: rgba(0, 0, 0, 0.5);
			height: 100%;
			position: fixed;
			width: 100%;
			cursor: wait;
			z-index: 99;
		}
		label.error{ color:#f00; }
		.makered{color:#f00;}
		.form-control.error{border-color:#f00;box-shadow:none;}
		.form-control.error	{
				background-image: linear-gradient(#ff0808, #ff1010), linear-gradient(rgb(255, 11, 11), rgba(255, 8, 8)) !important;
		}
		.btn-group {  
			white-space: nowrap;              
		}

		@media (max-width: 767px) {
			.table-responsive .dropdown-menu {
				/* position: static !important; */
			}
		}
		<!---@media (min-width: 768px) {
			.table-responsive {
				overflow: inherit;
			}
		}-->
		.table tr td strong{
			font-weight:500;
		}
		/* .container-fluid {min-height: 700px;} */
		select#user {
    width: 100% !important;
}
.select2-container {
    width: 100% !important;
}
table.dataTable td.dataTables_empty {
    text-align: center;
}
	</style>
</head>
<?php //dd($setting); ?>