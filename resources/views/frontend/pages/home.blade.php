<!DOCTYPE html>
<html lang="de-DE">
<head>
    <title>Veldoo 2000 Taxi Driver – Mit unser Veldoo-App verwaltest du dein Taxi-Unternehmen ganz einfach vollkommen digital.</title>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap V5 CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6-->
    <script src="https://kit.fontawesome.com/9421a306f6.js" crossorigin="anonymous"></script>
    <link href="{{ asset('landing_page_assets/css/ekiticons.css')}}" media="all" rel="stylesheet">
    <!-- Aminated CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Bootstrap icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('landing_page_assets/css/style.css')}}" />
</head>
<body data-bs-spy="scroll" data-bs-target=".spymenu, .dt" data-bs-offset="80" >
    <div class="main_wrapper">
        <header class="main_header">
            <nav class="navbar navbar-expand-lg navbar-dark primary_navbar fixed-top spymenu">
                <div class="container header_container">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('landing_page_assets/img/brand_logo.png')}}" class="img-fluid img-responsive w-100 brand_img" alt="Logo Veldoo" />
                    </a>
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#primaryNav">
                        <span class="toggler_icon"><i class="fas fa-bars bartoggler" style="color: #ffffff;"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="primaryNav">
                        <ul class="navbar-nav align-items-center ms-auto">
                            <li class="nav-item text_items dotlist">
                                <a class="nav-link text-links clickcloppase" href="#home">Home</a>
                            </li>
                            <li class="nav-item text_items dotlist">
                                <a class="nav-link text-links clickcloppase" href="#funktionen">Funktionen</a>
                            </li>
                            <li class="nav-item text_items dotlist">
                                <a class="nav-link text-links clickcloppase" href="#dieProbleme">Die Probleme</a>
                            </li>
                            <li class="nav-item text_items dotlist">
                                <a class="nav-link text-links clickcloppase" href="#dieLosungen">Die Lösungen</a>
                            </li>
                            <li class="nav-item text_items dotlist">
                                <a class="nav-link text-links clickcloppase" href="#uberUns">Über uns</a>
                            </li>
                            <li class="nav-item text_items dotlist">
                                <a class="nav-link text-links clickcloppase" href="#faq">FAQ</a>
                            </li>
                            <li class="nav-item text_items dotlist">
                                <a class="nav-link text-links clickcloppase" href="#download">Download</a>
                            </li>
                            <li class="nav-item text_items">
                                <div id="google_translate_element"></div>
                            </li>
                           
                            <li class="nav-item btn-last-link">
                                <a class="nav-link btn-form-link" href="{{ route('service-provider.register') }}"><span class="btn_icons"><i class="fas fa-mouse-pointer"></i></span><span class="btn_text">Jetzt registrieren!</span> </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="main_body_content">

            <section class="top_banner" id="home">
                <div class="hero_banner_content">
                    <article class="container">
                        <div class="row">
                            <div class="col-12">
                                <h1 class="main_baner_title text-center">VELDOO 2000 Taxi Driver</h1>
                                <h2 class="main_baner_Subtitle text-center">Mit unser Veldoo-App verwaltest du dein Taxi-Unternehmen ganz einfach vollkommen digital.</h2>
                            </div>
                        </div>
                        
                        <div class="row position_dynamic">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 " style="padding: 10px;">
                                <div class="phone_image_box">
                                    <img src="{{ asset('landing_page_assets/img/banner_image.png')}}" class="img-fluid img-responsive phone_img" alt="Phone Veldoo" />
                                    <button class="btn play_button"><span class="btniconsplay position-relative"><i class="fas fa-play"></i></span></button>
                                    <span class="btn-last-link video_section_button desktop_hide">
                                        <a class="nav-link btn-form-link" href="{{ route('service-provider.register') }}"><span class="btn_icons"><i class="fas fa-mouse-pointer"></i></span><span class="btn_text">Jetzt registrieren!</span> </a>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row sepector_row">

                            <div class="col-lg-6 col-md-12 col-sm-12 col-12" style="padding: 10px;">
                                <div class="leftcontent">
                                    <p class="mainline">Alles, was du bisher mühevoll einzeln erfassen musstest, findest du ab sofort auf einen Blick in der App.</p>
                                    <ul class="list-group checkList">
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check-circle checkIcononList"></i>
                                            <span class="listContent">Wo sind deine Fahrer?</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check-circle checkIcononList"></i>
                                            <span class="listContent">Wer hat wie viele Kilometer zurückgelegt?</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check-circle checkIcononList"></i>
                                            <span class="listContent">Welche Einnahmen wurden erzielt?</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check-circle checkIcononList"></i>
                                            <span class="listContent">Welche Kosten sind angefallen?</span>
                                        </li>
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="fas fa-check-circle checkIcononList"></i>
                                            <span class="listContent">Wann müssen deine Fahrzeuge zum Kundendienst?</span>
                                        </li>
                                    </ul>
                                    
                                    <p class="mainline mt-4">So funktioniert ein effizientes und zukunftsfähiges <br/>Taxi-Geschäft!</p>
                                    <ul class="row hr_store icon_widget_list store_links p-0 top_banner_hr_store">
                                        <div class="col-lg-5 col-sm-12 buttonSpect">
                                            
                                            <li class="list-group-item ">
                                                <a class="btn_store" href="https://apps.apple.com/in/app/id1645847445">
                                                    <i class="fab fa-apple playsoteIcons"></i>
                                                    <span class="text_storebtn_body">
                                                        <span class="info_box_title">Download auf</span>
                                                        <span class="info_box_store">App Store</span>
                                                    </span>
                                                </a>
                                            </li>
                                        </div>
                                        <div class="col-lg-5 col-sm-12 buttonSpect">
                                            
                                            <li class="list-group-item ">
                                                <a class="btn_store" href="https://play.google.com/store/apps/details?id=com.veldoo.driver">
                                                    <i class="fab fa-google-play playsoteIcons"></i>
                                                    <span class="text_storebtn_body">
                                                        <span class="info_box_title">Download auf</span>
                                                        <span class="info_box_store">Play Store</span>
                                                    </span>
                                                </a>
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-0">
                                 {{-- <div class="phone_image_box">
                                    <img src="{{ asset('landing_page_assets/img/banner_image.png')}}" class="img-fluid img-responsive w-100 phone_img" alt="Phone Veldoo" />
                                </div>  --}}
                            </div>
                        </div>

                    </article>
                </div>
                <!-- Hero Banner conten -->
                <div class="divide_shape">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                        <path class="elementor-shape-fill" opacity="0.33" d="M473,67.3c-203.9,88.3-263.1-34-320.3,0C66,119.1,0,59.7,0,59.7V0h1000v59.7 c0,0-62.1,26.1-94.9,29.3c-32.8,3.3-62.8-12.3-75.8-22.1C806,49.6,745.3,8.7,694.9,4.7S492.4,59,473,67.3z"></path>
                        <path class="elementor-shape-fill" opacity="0.66" d="M734,67.3c-45.5,0-77.2-23.2-129.1-39.1c-28.6-8.7-150.3-10.1-254,39.1 s-91.7-34.4-149.2,0C115.7,118.3,0,39.8,0,39.8V0h1000v36.5c0,0-28.2-18.5-92.1-18.5C810.2,18.1,775.7,67.3,734,67.3z"></path>
                        <path class="elementor-shape-fill" d="M766.1,28.9c-200-57.5-266,65.5-395.1,19.5C242,1.8,242,5.4,184.8,20.6C128,35.8,132.3,44.9,89.9,52.5C28.6,63.7,0,0,0,0 h1000c0,0-9.9,40.9-83.6,48.1S829.6,47,766.1,28.9z"></path>
                    </svg>
                </div>
            </section>
            <!-- Top Banner End -->

            <section class="features_section" id="funktionen">
                <article class="container-fluid">
                    <h3 class="section_name">Unsere <strong>Features</strong></h3>
                    <p class="taglines">Ein kleiner Ausschnitt unserer besten Features</p>
                    <div class="row">

                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 order-2 order-lg-1" data-aos="fade-right">
                            <div class="outside_features_list">
                                <div class="ot_list_content">
                                    <div class="ot_body">
                                        <i aria-hidden="true" class="icon icon-calendar ot_icons"></i>
                                        <div class="ot_body_content">
                                            <h4 class="ot_title">Farhrenbuch</h4>
                                            <p class="ot_para mb-0">
                                                Zu jedem Zeitpunkt die Kontrolle über das Geschäft behalten wie die Auflistung aller Fahrten & Einnahmen.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- List End -->

                                <div class="ot_list_content">
                                    <div class="ot_body">
                                        <!-- <i aria-hidden="true" class="icon icon-coupon-code ot_icons "></i> -->
                                        <img src="{{ asset('landing_page_assets/img/ticket.svg')}}" class="img-fluid ot_icons" alt="ticket"/>
                                        <div class="ot_body_content">
                                            <h4 class="ot_title">Meilenstein</h4>
                                            <p class="ot_para mb-0">
                                                Tolle Rabatte auf gefahrene Kilometer sammeln. Die Kunden entscheiden selbst wieviel Rabatte sie bekommen.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- List End -->

                                <div class="ot_list_content">
                                    <div class="ot_body">
                                        <i aria-hidden="true" class="icon icon-speakers ot_icons"></i>
                                        <div class="ot_body_content">
                                            <h4 class="ot_title">Promotionen</h4>
                                            <p class="ot_para mb-0">
                                                Tolle Promotioncodes für die Kunden mit diversen Wochenend Rabatten und noch vieles mehr.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- List End -->

                            </div>
                        </div>
                        <!-- /col List End -->
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 order-1 order-lg-2" data-aos="zoom-in">
                            <img src="{{ asset('landing_page_assets/img/banner_image.png')}}" alt="phone image" class="img-fluid img-responsive w-100 middleImg mobile_hide" />
                            <img src="{{ asset('landing_page_assets/img/banner_shadowLess.png')}}" alt="phone image" class="img-fluid img-responsive w-100 middleImg desktopImg_hide" />
                        </div>
                        
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12 order-3 order-lg-3" data-aos="fade-left">
                            <div class="outside_features_list">
                                <div class="ot_list_content">
                                    <div class="ot_body">
                                        <i aria-hidden="true" class="icon icon-users ot_icons"></i>
                                        <div class="ot_body_content">
                                            <h4 class="ot_title">Freunde einladen</h4>
                                            <p class="ot_para mb-0">
                                                Freie Kilometer bei Einladungen von Freunden. Bei jeder einladung Promotioncodes erhalten.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- List End -->

                                <div class="ot_list_content">
                                    <div class="ot_body">
                                        <i aria-hidden="true" class="icon ot_icons icon-settings1"></i>
                                        <div class="ot_body_content">
                                            <h4 class="ot_title">Tolle Einstellungen</h4>
                                            <p class="ot_para mb-0">
                                                Neue sowie Stammkunden mit unseren tollen Einstellungen und Features bekommen.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- List End -->

                                <div class="ot_list_content">
                                    <div class="ot_body">
                                        <i aria-hidden="true" class="icon icon-Download ot_icons"></i>
                                        <div class="ot_body_content">
                                            <h4 class="ot_title">Erhältlich für IOS & Android</h4>
                                            <p class="ot_para mb-0">
                                                Unsere Einzigartige APP jetzt erhältlich bei Apple App-Store & Google Play-Store.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- List End -->

                            </div>
                        </div>
                        <!-- /col List End -->

                    </div>
                </article>
            </section>

            <section class="divider_part">
                <div class="svg_parth">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none">
                        <path class="elementor-shape-fill" d="M1000,4.3V0H0v4.3C0.9,23.1,126.7,99.2,500,100S1000,22.7,1000,4.3z"></path>
                    </svg>
                </div>
                <div class="features_cards_list">
                    <div class="container features_card_container">
                        <div class="row" data-aos="zoom-in">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="features_cards">
                                    <div class="features_cardy_body text-center">
                                        <div class="ft_card_icon">
                                            <i aria-hidden="true" class="icon icon-handshake"></i>
                                        </div>
                                        <h2 class="ft_card_header">Kunde1</h2>
                                        <p class="ft_para">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="features_cards">
                                    <div class="features_cardy_body text-center">
                                        <div class="ft_card_icon">
                                            <i aria-hidden="true" class="icon icon-handshake"></i>
                                        </div>
                                        <h2 class="ft_card_header">Kunde2</h2>
                                        <p class="ft_para">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                                <div class="features_cards">
                                    <div class="features_cardy_body text-center">
                                        <div class="ft_card_icon">
                                            <i aria-hidden="true" class="icon icon-handshake"></i>
                                        </div>
                                        <h2 class="ft_card_header">Kunde3</h2>
                                        <p class="ft_para">
                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="problems_section" id="dieProbleme">
                <article class="container-fluid width_14k">
                    <div class="row">
                        <div class="col-lg-8 col-md-9 col-sm-12 col-12">
                            <div class="problems_content">
                                <h3 class="section_name lightGreyText">Die <strong>Probleme</strong></h3>
                                <p class="taglines text-white text-start">Die meisten Herausforderungen die ein Taxi Unternehmen hat.</p>
                                <ul class="list-group icons_faces_list">

                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-frown faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Du setzt immer noch auf analoge Zettelwirtschaft in deinem Taxi-Unternehmen?
                                        </span>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-frown faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Die Verwaltung deiner Fahrer und deren Fahrten kostet dich viel Zeit und Nerven?
                                        </span>
                                    </li>
                                    
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-frown faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Dir fehlt der Überblick über deine Fahrer und ihre Fahrten? 
                                        </span>
                                    </li>
                                    
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-frown faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Du willst die Einnahmen und Ausgaben deiner Fahrer im Blick behalten?
                                        </span>
                                    </li>
                                    
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-frown faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Du willst keine teure Werbung schalten, um neue Fahrgäste anzusprechen?
                                        </span>
                                    </li>

                                </ul>
                                <span class="btn-last-link video_section_button newbutton">
                                    <a class="nav-link btn-form-link" href="#"><span class="btn_icons"><i class="fas fa-mouse-pointer" aria-hidden="true"></i></span><span class="btn_text">Kostenloses Beratungsgespräch</span> </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            </section>

            <section class="unser_erflog">
                <article class="container erflog_container">
                    <h3 class="section_name">Unser <strong>Erfolg</strong></h3>
                    <p class="taglines">So funktioniert ein effizientes und zukunftsfähiges Taxi-Geschäft!</p>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="erflog_cards">
                                <div class="erflog_cardy_body text-center">
                                    <div class="erf_card_icon">
                                        <i aria-hidden="true" class="fas fa-cloud-download-alt erf_icons_view"></i>
                                    </div>
                                    <h2 class="odometer_text"><span class="prefix">+</span><span class="counter" id="odometer">9.250</span></h2>
                                    <p class="erf_para">
                                        Aktive Downloads
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="erflog_cards">
                                <div class="erflog_cardy_body text-center">
                                    <div class="erf_card_icon">
                                        <i aria-hidden="true" class="fas fa-user-check erf_icons_view"></i>
                                    </div>
                                    <h2 class="odometer_text"><span class="prefix">+</span><span class="counter" id="odometer2">5.250</span></h2>
                                    <p class="erf_para">
                                        Zufriedene Benutzer
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="erflog_cards">
                                <div class="erflog_cardy_body text-center">
                                    <div class="erf_card_icon">
                                        <i aria-hidden="true" class="fas fa-user-graduate erf_icons_view"></i>
                                    </div>
                                    <h2 class="odometer_text"><span class="prefix">+</span><span class="counter" id="odometer3">5.250</span></h2>
                                    <p class="erf_para">
                                        Registrierte Kunden
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
            <!-- Erflog -->

            <section class="losungen" id="dieLosungen">
                <article class="container-fluid width_14k">
                    <div class="row">
                        <div class="lor_left-col">
                            <div class="phone_image_box_log position-relative">
                                <img src="{{ asset('landing_page_assets/img/log_phone.png')}}" class="img-fluid img-responsive phone_img" alt="Phone Veldoo">
                                
                                <span class="btn-last-link video_section_button" data-aos="zoom-in">
                                    <a class="nav-link btn-form-link" href="{{ route('service-provider.register') }}"><span class="btn_icons"><i class="fas fa-mouse-pointer" aria-hidden="true"></i></span><span class="btn_text">Jetzt registrieren!</span> </a>
                                </span>
                            </div>
                        </div>
                        <div class="lor_right-col">
                            <div class="problems_content losungen_content">
                                <h3 class="section_name lightGreyText">Die <strong>Lösungen</strong></h3>
                                <p class="taglines text-white text-start mt-0">Mit unser Veldoo-App verwaltest du dein Taxi-Unternehmen ganz einfach vollkommen digital.</p>
                                <ul class="list-group icons_faces_list">

                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-grin-stars faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Wo sind deine Fahrer?
                                        </span>
                                    </li>
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-grin-stars faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Wer hat wie viele Kilometer zurückgelegt?
                                        </span>
                                    </li>
                                    
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-grin-stars faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Welche Einnahmen wurden erzielt?
                                        </span>
                                    </li>
                                    
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-grin-stars faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Welche Kosten sind angefallen?
                                        </span>
                                    </li>
                                    
                                    
                                    <li class="list-group-item">
                                        <i aria-hidden="true" class="fas fa-grin-stars faceIconDisplay"></i>
                                        <span class="listcontent">
                                            Wann müssen deine Fahrzeuge zum Kundendienst?
                                        </span>
                                    </li>

                                </ul>
                                <p class="taglines text-white text-start smtext">Alles, was du bisher mühevoll einzeln erfassen musstest, findest du ab sofort auf einen Blick in der App.</p>
                                <ul class="row hr_store icon_widget_list store_links p-0 top_banner_hr_store" data-aos="fade-down">
                                    <div class="col-lg-6 col-sm-12 buttonSpect">
                                        
                                        <li class="list-group-item orangeBG">
                                            <a class="btn_store" href="https://apps.apple.com/in/app/id1645847445">
                                                <i class="fab fa-apple playsoteIcons" aria-hidden="true"></i>
                                                <span class="text_storebtn_body">
                                                    <span class="info_box_title">Download auf</span>
                                                    <span class="info_box_store">App Store</span>
                                                </span>
                                            </a>
                                        </li>
                                    </div>
                                    <div class="col-lg-6 col-sm-12 buttonSpect">
                                        
                                        <li class="list-group-item orangeBG">
                                            <a class="btn_store" href="https://play.google.com/store/apps/details?id=com.veldoo.driver">
                                                <i class="fab fa-google-play playsoteIcons" aria-hidden="true"></i>
                                                <span class="text_storebtn_body">
                                                    <span class="info_box_title">Download auf</span>
                                                    <span class="info_box_store">Play Store</span>
                                                </span>
                                            </a>
                                        </li>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>
            </section>

            <section class="uber_uns_section" id="uberUns">
                <article class="container uns_container width_14k">
                    <div class="uns_row">
                        <div class="uns_left">
                            <h3 class="uns_title">Veldoo</h3>
                            <img src="{{ asset('landing_page_assets/img/ueber.png')}}" class="img-fluid img-repsonsive uns_imgs"  alt="layres image"/>
                        </div>
                        <div class="uns_right">
                            <div class="uns_right_content">
                                <h4 class="unsHeading">Über uns</h4>
                                <p class="uns_para">
                                    Mein Schwiegervater ist selbst über 25 Jahre Taxi-Unternehmer und hat erkannt, dass er sein Unternehmen digitalisieren muss, um zukunftsfähig zu bleiben.
                                </p>
                                <p class="uns_para">
                                    Daraufhin hat er mich damit beauftragt, eine App zu entwickeln, die alle seine Geschäftsprozesse abbilden kann.
                                </p>
                                <p class="uns_para">
                                    In der App stecken über 2 Jahre Entwicklungsarbeit.
                                    Unser Ziel: unseren Kunden ein Werkzeug an die Hand geben, mit dem sie wirklich alles rund um ihren Taxi-Betrieb managen können.
                                </p>
                                <span class="btn-last-link video_section_button newbutton shadowless">
                                    <a class="nav-link btn-form-link" href="#"><span class="btn_icons"><i class="fas fa-mouse-pointer" aria-hidden="true"></i></span><span class="btn_text">Kostenloses Beratungsgespräch</span> </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </article>
            </section>

            <section class="dich_section" >
                <article class="container-fluid width_14k dich_container" data-aos="zoom-in">
                    <div class="row">
                        <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                            <h4 class="dich_title">Wir unterstützen Dich</h4>
                            <p class="dich_para">
                                Du bist Dir unsicher, wie du unsere App am besten einsetzen sollst? Wir helfen Dir gerne weiter und beraten Dich in einem kostenlosen Beratungsgespräch!
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                            <h4 class="dich_title">Kontakt</h4>
                            <ul class="list-group icons_faces_list dish_contactlist pt-0">

                                <li class="list-group-item dish_contactList">
                                    <i aria-hidden="true" class="fas fa-phone-alt faceIconDisplay"></i>
                                    <a href="tel:+41 234 567 890" class="listcontent text-white text-decoration-none">
                                        Telefon: +41 234 567 890
                                    </a>
                                </li>
                                <li class="list-group-item dish_contactList">
                                    <i aria-hidden="true" class="fas fa-mail-bulk faceIconDisplay"></i>
                                    <a href="mailto:office@veldoo.com" class="listcontent text-white text-decoration-none">
                                        E-Mail: office@veldoo.com
                                    </a>
                                </li>

                            </ul>
                            <span class="btn-last-link video_section_button newbutton dich_btn">
                                <a class="nav-link btn-form-link" href="#"><span class="btn_icons"><i class="fas fa-mouse-pointer" aria-hidden="true"></i></span><span class="btn_text">Kostenloses Beratungsgespräch</span> </a>
                            </span>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 col-12">
                            <div class="autor_info_dich">
                                <img src="{{ asset('landing_page_assets/img/ceo.jpg')}}" class="img-fluid img-repsonsive w-100 ceo_img" alt="Author Image" />
                                <div class="autor_details">
                                    <p class="name_auth">Aca Pavlovic</p>
                                    <p class="occupations_auth">Beratungs-Experte</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>

            <section class="faqs_section" id="faq">
                <article class="container-fluid width_14k">
                    
                    <h3 class="section_name text-center">Die <strong>FAQ´s</strong></h3>
                    <div class="row faqs_rows">
                        <div class="left_faq">
                            <div class="accordion faqs_accordion" id="FAQsQuesions">

                                <div class="accordion-item">
                                  <h2 class="accordion-header" id="question1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <i class="fas fa-question questionMarks"></i>
                                        <span class="btn_acc_txt">Wann erhalten wir die fertigen Videos?</span>
                                    </button>
                                  </h2>
                                  <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#FAQsQuesions">
                                    <div class="accordion-body">
                                        <p>So schnell wie möglich. Natürlich kommt es auf die Länge und Anzahl der von Ihnen gebuchten Videos an, doch in der Regel erhalten Sie Ihre fertigen Videos nach drei Tagen.</p>
                                    </div>
                                  </div>
                                </div>

                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="question2">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                          <i class="fas fa-question questionMarks"></i>
                                          <span class="btn_acc_txt">Ist es möglich, die Videos für Social-Media-Zwecke auch schon wenige Stunden nach dem Event zu bekommen?</span>
                                      </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#FAQsQuesions">
                                      <div class="accordion-body">
                                          <p>Ja, auch das ist bei Bedarf möglich. Genaueres besprechen wir gerne persönlich.</p>
                                      </div>
                                    </div>
                                </div>

                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="question3">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                          <i class="fas fa-question questionMarks"></i>
                                          <span class="btn_acc_txt">Ist es möglich, ein- und dasselbe Video sowohl im 16:9 als auch im 9:16 Format zu bekommen?</span>
                                      </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#FAQsQuesions">
                                      <div class="accordion-body">
                                          <p>Ja. Doch nicht immer ist das die optimale Idee. Jede Social-Media-Plattform hat ihre eigenen Gesetze und Prinzipien. Lassen Sie uns hier genauer miteinander sprechen.</p>
                                      </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="question4">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                          <i class="fas fa-question questionMarks"></i>
                                          <span class="btn_acc_txt">Was kostet Ihre Dienstleistung?</span>
                                      </button>
                                    </h2>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#FAQsQuesions">
                                      <div class="accordion-body">
                                          <p>Pauschal ist diese Frage natürlich nicht zu beantworten. Sehen Sie sich hierzu meine Preispakete an.</p>
                                      </div>
                                    </div>
                                </div>

                                
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="question5">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                          <i class="fas fa-question questionMarks"></i>
                                          <span class="btn_acc_txt">Was ist Ihre Dienstleistung?</span>
                                      </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#FAQsQuesions">
                                      <div class="accordion-body">
                                          <p>Ich bin Videograf, der sich auf die Produktion hochwertiger Eventvideos spezialisiert hat. Ich liefere Ihnen Videos für Ihre Website und/oder Ihre Social-Media-Kanäle, üblicherweise im 16:9 bzw. 9:16 Format. Meine Videos haben je nach Umfang und Verwendungszweck eine Länge bis maximal fünf Minuten. Lassen Sie uns miteinander sprechen, welche Vorstellungen sie haben.</p>
                                      </div>
                                    </div>
                                </div>


                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="question6">
                                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                          <i class="fas fa-question questionMarks"></i>
                                          <span class="btn_acc_txt">Welche Art von Events filmen Sie?</span>
                                      </button>
                                    </h2>
                                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#FAQsQuesions">
                                      <div class="accordion-body">
                                          <p>Ich habe mich auf Messen, Konferenzen, Firmenevents und Kulturveranstaltungen spezialisiert.</p>
                                      </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="right_faq">
                            <div class="sideHand_image_box">
                                <img src="{{ asset('landing_page_assets/img/handPhone.png')}}" alt="Hand Phone" class="img-fluid img-reponsive handPhoneImage" />
                            </div>
                        </div>
                    </div>
                </article>
            </section>

        </main>
        <footer class="main_footer" id="download">
            <section class="footer_content">
                <article class="container">
                    <div class="row">
                        <div class="col-12 p-0">
                            <h1 class="footer_section_title">
                                Sie haben <strong>persönliche & individuelle</strong> Fragen?
                                <br/>Wir freuen uns auf Ihre <strong>Kontaktaufnahme!</strong>
                            </h1>
                        </div>
                        
                        <div class="col-12 p-0">
                            <div class="send_msg_done contact_form text-center mb-4">
                                <p class="icon_msg mb-0"><i class="bi bi-check-lg check_icon"></i></p>
                                <label class="form_label send_msg mb-0 d-block">Vielen Dank für Ihr Interesse! Ihre Nachricht ist bei uns eingetroffen und wird an die zuständige Fachabteilung weitergeleitet. Ein Mitarbeiter wird Ihre Anfrage bearbeiten und sich umgehend bei Ihnen melden.</label>
                            </div>
                        </div>
                        <!-- Form -->
                        <div class="col-12 p-0">
                            <form class="contact_form send_form_contact">
                                <div class="row w-100 m-0">

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group">
                                            <label class="form_label require_field" for="name">Name<span class="important_sign">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control input_box field_necessary" required/>
                                            <p class="mb-0 error_msg">Dieses Feld ist erforderlich.</p>
                                            <p class="instructions_msg mb-0">Bitte geben Sie Ihren Vor- & Nachnamen ein</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group">
                                            <label class="form_label require_field" for="firma">Firma<span class="important_sign">*</span></label>
                                            <input type="text" name="firma" id="firma" class="form-control input_box field_necessary" required/>
                                            <p class="mb-0 error_msg">Dieses Feld ist erforderlich.</p>
                                            <p class="instructions_msg mb-0">Bitte geben Sie Ihren Firmennamen ein</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group">
                                            <label class="form_label require_field" for="telefonnummer">Telefonnummer<span class="important_sign">*</span></label>
                                            <input type="tel" name="telefonnummer" id="telefonnummer" class="form-control input_box field_necessary" required/>
                                            <p class="mb-0 error_msg">Dieses Feld ist erforderlich.</p>
                                            <p class="instructions_msg mb-0">Beispiel: +43 212 695 1962</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group">
                                            <label class="form_label require_field" for="emailAddress">E-Mail Adresse<span class="important_sign">*</span></label>
                                            <input type="email" name="emailAddress" id="emailAddress" class="form-control input_box field_necessary" required/>
                                            <p class="mb-0 error_msg">Dieses Feld ist erforderlich.</p>
                                            <p class="instructions_msg mb-0">Beispiel: ihre@email-adresse.com</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group">
                                            <label class="form_label require_field" for="date">Wunschtermin: Datum<span class="important_sign">*</span></label>
                                            <input type="date" name="date" id="date" class="form-control input_box field_necessary" required/>
                                            <p class="mb-0 error_msg">Dieses Feld ist erforderlich.</p>
                                            <p class="instructions_msg mb-0">Bitte geben Sie Ihren Wunsch Datum ein</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group">
                                            <label class="form_label require_field" for="timmer">Wunschtermin: Uhrzeit<span class="important_sign">*</span></label>
                                            <input type="time" name="timmer" id="timmer" class="form-control input_box field_necessary" required/>
                                            <p class="mb-0 error_msg">Dieses Feld ist erforderlich.</p>
                                            <p class="instructions_msg mb-0">Bitte geben Sie Ihren Wunsch Uhrzeit ein</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group">
                                            <label class="form_label require_field" for="msgs">Welches Anliegen führt Sie zu uns?<span class="important_sign">*</span></label>
                                            <textarea rows="10" cols="30" style="height: 140px;" name="msgs" id="msgs" class="form-control input_box field_necessary" required></textarea>
                                            <p class="mb-0 error_msg">Dieses Feld ist erforderlich.</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
                                        <div class="form-group text-end">
                                            <button class="btn-submit" type="submit">
                                               <span class="btn_icons"><i class="fas fa-mouse-pointer"></i></span><span class="btn_text">Anfrage senden</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /Form -->

                        <div class="col-12 p-0">
                            <div class="footer_img text-center">
                                <img src="{{ asset('landing_page_assets/img/ftr_brand_logo.png')}}" class="img-fluid img-responsive w-100 brand_img" alt="Logo Veldoo" />
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 p-0">
                            <div class="ftr_widget">
                                <h4 class="widget_title">Firmensitz</h4>
                                <ul class="list-group icon_widget_list">
                                    <li class="list-group-item">
                                        <i class="fas fa-building leftIcons"></i>
                                        <a class="textList">
                                            Veldoo <br/>Firmenadrasse 10 <br/>CH-1555 Bern
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fas fa-phone-alt leftIcons"></i>
                                        <a class="textList">
                                            Telefon: +41 123 456 789
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fas fa-mail-bulk leftIcons"></i>
                                        <a class="textList" href="mailto:office@veldoo.com">
                                            E-Mail: office@veldoo.com
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fas fa-globe leftIcons"></i>
                                        <a class="textList" target="_blank" href="www.veldoo.com">
                                            Web: www.veldoo.com
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        
                        
                        <div class="col-lg-4 col-md-4 col-sm-6 col-12 p-0">
                            <div class="ftr_widget">
                                <h4 class="widget_title">Navigation</h4>
                                <ul class="list-group icon_widget_list page_links">
                                    <li class="list-group-item">
                                        <a class="textList list-group-links" href="#home">Home</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList list-group-links" href="#funktionen">Funktionen</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList list-group-links" href="#dieProbleme">Die Probleme</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList list-group-links" href="#dieLosungen">Die Lösungen</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList list-group-links" href="#uberUns">Über uns</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList list-group-links" href="#faq">FAQ</a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList list-group-links active" href="#download">Download</a>
                                    </li>
                                    
                                </ul>
                               
                            </div>
                        </div>

                        
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 p-0">
                            <div class="ftr_widget">
                                <h4 class="widget_title">Veldoo 2000 Taxi Driver</h4>
                                <ul class="list-group icon_widget_list store_links">
                                    <li class="list-group-item orangeBG">
                                        <a class="btn_store" href="https://apps.apple.com/in/app/id1645847445">
                                            <i class="fab fa-apple playsoteIcons"></i>
                                            <span class="text_storebtn_body">
                                                <span class="info_box_title">Download auf</span>
                                                <span class="info_box_store">App Store</span>
                                            </span>
                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="btn_store" href="https://play.google.com/store/apps/details?id=com.veldoo.driver">
                                            <i class="fab fa-google-play playsoteIcons"></i>
                                            <span class="text_storebtn_body">
                                                <span class="info_box_title">Download auf</span>
                                                <span class="info_box_store">Play Store</span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                                <h4 class="widget_title socialTitle">Social Media</h4>
                                <ul class="list-group icon_widget_list social_icons_List d-flex">
                                    <li class="list-group-item">
                                        <a class="textList social_icons" href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList social_icons" href="https://linkedin.com"><i class="fab fa-linkedin-in"></i></a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList social_icons" href="https://instargram.com"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList social_icons" href="https://tiktok.com"><i class="fab fa-tiktok"></i></a>
                                    </li>
                                    <li class="list-group-item">
                                        <a class="textList social_icons" href="https://youtube.com"><i class="fab fa-youtube"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="copyrightContentBox">
                        <h4 class="copyRightText m-0 p-0">Copyright 2023 © Alle Rechte vorbehalten.<br> <a href="https://www.explain-it-simple.com/" class="text-decoration-none" target="_blank">Development</a>  © 
                            <a style="text-decoration:underline;" href="https://company4youandme.com/" target="_blank">Company 4 You &amp; Me</a></h4>
                    </div>
                    <div class="dividerLine"></div>
                    <div class="bottomNav">
                        <ul class="nav last_ftr_nav">
                            <li class="nav-item">
                                <a href="/agb" class="nav-link">AGB</a>
                            </li>
                            <li class="nav-item">
                                <a href="/impressum" class="nav-link">Impressum</a>
                            </li>
                            <li class="nav-item">
                                <a href="/datenschutz" class="nav-link">Datenschutz</a>
                            </li>
                        </ul>
                    </div>
                </article>
            </section>
        </footer>

        <a href="#home" class="scroll-to-top-button text-decoration-none"><i class="fas fa-chevron-up"></i></a>

       
        
    </div>
    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <!-- Odo Metter-->
    <script src="{{ asset('landing_page_assets/js/jquery.countup.js')}}"></script>
    <!-- Bootstrap V5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Animation JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
    
          new google.translate.TranslateElement({pageLanguage: 'de', includedLanguages : 'en,de,de', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
        }
        </script>
    <!-- Custom JS -->
    <script src="{{ asset('landing_page_assets/js/main.js')}}"></script>
    <script>
        $('.counter').countUp();

        AOS.init({
            duration: "1000"
        });
      

        $(window).on('load', function() {
  $('.goog-te-gadget').html($('.goog-te-gadget').children());
  $("#google-translate").fadeIn('1000');


  function cleartimer() {     
      setTimeout(function(){ 
          window.clearInterval(myVar); 
      }, 500);             
  }
  function myTimer() {
      if ($('.goog-te-combo option:first').length) {
          $('.goog-te-combo option:first').html('Translate');
          cleartimer();
      }
  }
  var myVar = setInterval(function(){ myTimer() }, 0); 

});
    </script>
  
    
    
</body>
</html>