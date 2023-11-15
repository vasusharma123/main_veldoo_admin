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
                                                        <tr>
                                                            <td class="text-center">00:00:00</td>
                                                            <td>Veldoo</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td>Monthly</td>
                                                            <td class="text-center"><a href="/master-plan" class="plan valid">Silver</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">00:00:00</td>
                                                            <td>Veldoo</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td>Yearly</td>
                                                            <td class="text-center"><a href="/master-plan" class="plan valid">Gold</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">00:00:00</td>
                                                            <td>Veldoo</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td>Monthly</td>
                                                            <td class="text-center"><a href="/master-plan" class="plan valid">Platinum</a></td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td class="text-center">00:00:00</td>
                                                            <td>Veldoo</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td>Yearly</td>
                                                            <td class="text-center"><a href="/master-plan" class="plan invalid">Inactive</a></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">00:00:00</td>
                                                            <td>Veldoo</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td>Yearly</td>
                                                            <td class="text-center"><a href="/master-plan" class="plan valid">Gold</a></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">00:00:00</td>
                                                            <td>Veldoo</td>
                                                            <td>+91 956256484</td>
                                                            <td>ramkumar@gmail.com</td>
                                                            <td>Test</td>
                                                            <td class="text-center"><a href="/master-plan" class="plan valid">Test</a></td>
                                                        </tr>
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </article>
                                    </section>
@endsection