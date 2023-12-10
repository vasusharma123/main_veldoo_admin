@extends('master_admin.layouts.after_login')

@section('header_menu_list')
    @include('master_admin.includes.service_provider_detail_header_menu_list')
@endsection

@section('content')
    <section class="addonTable sectionsform">
        <article class="container-fluid">
            <div class="table-responsive marginTbl">

                <table class="table table-borderless table-fixed customTable">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Service provider</th>
                            <th>Billing information</th>
                            <th>Paied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" style="text-align:center"> No data exist</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection
