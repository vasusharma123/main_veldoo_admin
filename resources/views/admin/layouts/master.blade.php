@include('admin.layouts.head')
@include('admin.layouts.header2')
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
		@include('admin.layouts.topbar')
        @if (Auth::user()->user_type==4 || Auth::user()->user_type==5)
            @include('company.elements.sidebar')
        @else
            @include('admin.layouts.sidebar')
        @endif
        <!-- Page wrapper  -->
		
        <!-- ============================================================== -->
        <div class="page-wrapper">
			@include('admin.layouts.breadcrumb')
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
             @yield('content')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
			@include('admin.layouts.copyright')
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
@include('admin.layouts.footer1')