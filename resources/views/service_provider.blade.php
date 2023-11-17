@extends('master_admin.layouts.plans')
@section('content')
<section class="addonTable sectionsform">
                                        <article class="container-fluid">
                                            <div class="table-responsive marginTbl">
                                                
                                                <table class="table table-borderless table-fixed customTable">
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
                                                    @foreach ($data['user'] as $item)
                                                        <tr>
                                                            <td>00:00:00</td>
                                                            <td>{{ $item->first_name }}</td>
                                                            <td>{{ $item->phone }}</td>
                                                            <td>{{ $item->email }}</td>
                                                            <td>Monthly</td>
                                                            <td class="text-center"><a href="/master-plan?id={{ encrypt($item->id) }}"  class="plan valid">Silver</a></td>
                                                            <!-- Add more cells for other columns -->
                                                        </tr>
                                                    @endforeach
                                                        
                                                        
                                                    </tbody>
                                                </table>

                                                @if(!empty($data['user']))
                                                    {{ $data['user']->links('pagination.new_design') }}
                                                 @endif


                                            </div>
                                        </article>
                                    </section>
@endsection