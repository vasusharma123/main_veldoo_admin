@extends('master_admin.layouts.plans')
@section('content')
<section class="addonTable planSections">
        <article class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 ">
                    <section class="sectionsform">
                        <div class="leftcontent">
                            <h2 class="titleCards">
                                Gold license
                            </h2>
                            <p class="numberUsers">
                                <img src="assets/imgs/users-black.png" alt="user icon" class="img-fluid w-100 usernumbericon" />
                                <span class="numberoflist">1-10 Cars</span>
                            </p>
                            <ul class="list-group checklistcars">
                                <li class="list-group-item">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext">Organize all your teams contents</span>
                                </li>
                                <li class="list-group-item">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext">Monitor activity with the admin console</span>
                                </li>
                                <li class="list-group-item">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext">180-day accident and theft recovery </span>
                                </li>
                                <li class="list-group-item">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext">Invoice history </span>
                                </li>
                                <li class="list-group-item">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext">Company booking </span>
                                </li>
                                <li class="list-group-item">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext">Guest booking </span>
                                </li>
                                <li class="list-group-item notused">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext"> On line ride management </span>
                                </li>
                                <li class="list-group-item notused">
                                    <img src="assets/imgs/checkmarks.png" alt="user icon" class="img-fluid w-100 checkmarkIconsImgs" />
                                    <span class="listcheckmarktext">On line ride management </span>
                                </li>
                            </ul>
                            <h4 class="permonthprice">
                                CHF 200 / month
                            </h4>
                        </div>
                    </section>
                </div>
                
                <div class="col-lg-6 col-md-12 col-sm-12 ">
                    <section class="sectionsform">
                        <div class="leftcontent">
                            <h2 class="sidePaidTitle">
                                Paid license
                            </h2>
                            <ul class="list-group paidList">
                                <li class="list-group-item">
                                    <span class="LeftItmes">Silver licenses (5)</span>
                                    <span class="RightItmes">CHF 200.00</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="LeftItmes highbold">EXPIRATION DATE</span>
                                    <span class="RightItmes highbold">09.11.2023</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="LeftItmes">Last Payment</span>
                                    <span class="RightItmes">CHF 200.00</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="LeftItmes">Next Payment</span>
                                    <span class="RightItmes">CHF 200.00</span>
                                </li>
                            </ul>
                            
                        </div>
                    </section>
                    <a href="/service-provider" class="form-control submit_btn planbuttons">View all invoices</a>
                </div>
            </div>
        </article>
    </section>

@endsection