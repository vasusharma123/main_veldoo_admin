        <div class="sidebarFlow">
                <i class="bi bi-chevron-right sidebarToggler"></i>
                <section class="sidebar">
                    <i class="bi bi-x-lg sidebarToggler">&nbsp; <span>Close</span></i>
                    <article class="all_sidebar_box">
                        <ul class="nav sidebarLists w-100">
                        <?php $currentUri  = request()->path();
                            $uriWithoutSlashOrAsterisk = str_replace('/', '', $currentUri); ?>


                            <li class="nav-item w-100">
                                <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'master-dashboard') { echo "active";  }  ?>" href="/master-dashboard">
                                    <img src="assets/imgs/dashboard.png" class="img-fluid w-100 sidebarImgs" alt="dashboard"/> 
                                    <span class="sidebarText">Dashboard</span>
                                    <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                </a>
                            </li>
                            <li class="nav-item w-100">
                                <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'service-provider' || $uriWithoutSlashOrAsterisk == 'master-plan' || $uriWithoutSlashOrAsterisk == 'plan-detail' || $uriWithoutSlashOrAsterisk == 'billing') { echo "active";  }  ?>" href="/service-provider">
                                    <img src="assets/imgs/users.png" class="img-fluid w-100 sidebarImgs" alt="users"/> 
                                    <span class="sidebarText">Service provider</span>
                                    <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                </a>
                            </li>
                            
                            <li class="nav-item w-100">
                                <a class="nav-link <?php if($uriWithoutSlashOrAsterisk == 'master-setting') { echo "active";  }  ?> " href="master-setting">
                                    <img src="assets/imgs/setting.png" class="img-fluid w-100 sidebarImgs" alt="Settings"/> 
                                    <span class="sidebarText">Settings</span>
                                    <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                </a>
                            </li>
                            <li class="nav-item w-100">
                                <a class="nav-link" href="/master-logout">
                                    <img src="assets/imgs/logout.png" class="img-fluid w-100 sidebarImgs" alt="logout"/> 
                                    <span class="sidebarText">Logout</span>
                                    <i class="bi bi-chevron-right sidebarIcon ms-auto"></i>
                                </a>
                            </li>
                        </ul>
                    </article>
                </section>
            </div>