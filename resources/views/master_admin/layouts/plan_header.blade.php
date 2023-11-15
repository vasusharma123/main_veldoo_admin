<header class="main_header">
            <section class="menu_top">
                <article class="container-fluid">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-5 col-5 align-self-center">
                            <div class="logo_box">
                                <img src="assets/imgs/brand_logo.png" class="img-fluid w-100 brnd_img" alt="Brnad Name Veldoo" />
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-2 col-sm-2 col-2 align-self-center trigger_parent">
                            <button class="btn collpasenav_btn trigger_btn"><i class="bi bi-three-dots-vertical"></i></button>
                            <ul class="nav top_tab_menu target">

                            <?php $currentUri  = $_SERVER['REQUEST_URI'];
                            $uriWithoutSlashOrAsterisk = str_replace('/', '', $currentUri);

                            if($uriWithoutSlashOrAsterisk == 'service-provider'){ ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="/service-provider">List</a>
                                     </li>
                           <?php }else{
                            ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'master-plan') { echo "active";  }  ?>" href="/master-plan">Plan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'plan-detail' ) { echo "active";  } ?>" href="/plan-detail">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'billing') { echo "active";  } ?>" href="/billing">Billing</a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="col-lg-5 col-md-7 col-sm-5 col-5 align-self-center">
                            <div class="right_content_menu">
                                <div class="search">
                                    <form class="search_form">
                                        <div class="form-group searchinput position-relative trigger_parent">
                                            <input type="text" class="form-control input_search target" placeholder="Search"/>
                                            <i class="bi bi-search search_icons"></i>
                                        </div>
                                    </form>
                                </div>
                                <div class="export_box">
                                    <a href="#" class="iconExportLink"><i class="bi bi-upload exportbox"></i></a>
                                </div>
                                <div class="avatar_info_box">
                                    <img src="{{ Auth::user()->image?env('URL_PUBLIC').'/'.Auth::user()->image:asset('new-design-company/assets/images/user.png') }}" alt="User avatar" class="img-fluid w-100 avatar_img" />
                                    <div class="user_info">
                                        <h4 class="nameOfUser">{{ Auth::user()->name}}</h4>
                                        <p class="userInfo">Master Admin</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </section>
        </header>