@include('master_admin.layouts.head')

<body>
    <div class="main_wrapper">
        @include('master_admin.layouts.header')
        <main class="body_content">
            <div class="inside_body">
                <div class="container-fluid p-0">
                    <div class="row m-0 w-100">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                            <div class="body_flow">
                                @include('master_admin.layouts.sidebar')
                                <div class="formTableContent">
                                  @yield('content')
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
@include('master_admin.layouts.footer')