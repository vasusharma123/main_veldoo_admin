@extends('master_admin.layouts.after_login')

@section('header_search_export')
    <div class="search">
        <form class="search_form">
            <div class="form-group searchinput position-relative trigger_parent">
                <input type="text" class="form-control input_search target" placeholder="Search" id="searchInput" />
                <i class="bi bi-search search_icons"></i>
            </div>
        </form>
    </div>
    <div class="export_box">
        <a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
    </div>
@endsection

@section('content')
    <section class="addEditForm sectionsform">
        <h1 class="text-center">Under Construction</h1>
    </section>
@endsection
