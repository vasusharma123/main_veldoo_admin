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
                            <th>Payed</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($all_purchases) && count($all_purchases) > 0)
                            @foreach ($all_purchases as $purchase_key => $purchase_value)
                                <tr>
                                    <td>{{ date('d.m.Y', strtotime($purchase_value->purchase_date)) }}</td>
                                    <td>{{ $purchase_value->service_provider->name }}</td>
                                    <td>
                                        <a href="#" class="tableLinks">Billing</a>
                                        <a href="#" class="tableLinks">Receipt</a>
                                        @if($purchase_key == 0)
                                        <a href="{{ route('service-provider.update_expiry',['id' => request('id')])}}" class="tableLinks editblue">Edit</a>
                                        @endif
                                    </td>
                                    <td>{{ $purchase_value->currency . ' ' . $purchase_value->paid_amount }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align:center"> No data exist</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </article>
    </section>
@endsection
