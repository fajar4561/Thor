<div class="leftbar-tab-menu">
    <div class="main-icon-menu">
        <a href="beranda" class="logo logo-metrica d-block text-center">
            <span>
                <img src="<?=$link?>public/resources/assets/images/lg.png" alt="logo-small" class="logo-sm">
            </span>
        </a>
        <div class="main-icon-menu-body">
            <div class="position-reletive h-100" data-simplebar style="overflow-x: hidden;">
                <ul class="nav nav-tabs" role="tablist" id="tab-menu">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard" data-bs-trigger="hover">
                        <a href="#MetricaDashboard" id="dashboard-tab" class="nav-link <?php if ($_GET['halaman']=='beranda' OR $_GET['halaman']=='profil') {echo "active";} ?>">
                            <i class="ti ti-smart-home menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php if ($session_akses!=0) {?>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Apps" data-bs-trigger="hover">
                        <a href="#MetricaApps" id="apps-tab" class="nav-link <?php if ($_GET['halaman']=='detail-pegawai' OR $_GET['halaman']=='detail-transaksi-gaji' OR $_GET['halaman']=='transaksi-gaji' OR $_GET['halaman']=='ubah-gaji') {echo "active";} ?>">
                            <i class="ti ti-apps menu-icon"></i>
                        </a><!--end nav-link-->
                    </li><!--end nav-item-->
                    <?php } ?>
                    <!--
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="My" data-bs-trigger="hover">
                            <a href="#MetricaUikit" id="uikit-tab" class="nav-link">
                                <i class="ti ti-planet menu-icon"></i>
                            </a>
                        </li>
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Pages" data-bs-trigger="hover">
                            <a href="#MetricaPages" id="pages-tab" class="nav-link">
                                <i class="ti ti-files menu-icon"></i>
                            </a>
                        </li>
                    
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Authentication" data-bs-trigger="hover">
                            <a href="#MetricaAuthentication" id="authentication-tab" class="nav-link">
                                <i class="ti ti-shield-lock menu-icon"></i>
                            </a>
                        </li>
                    -->
                </ul><!--end nav-->
            </div><!--end /div-->
        </div><!--end main-icon-menu-body-->
        <div class="pro-metrica-end">
            <a href="" class="profile">
                <img src="<?=$link?>public/img/<?=$pecahuser['foto']?>" style=" aspect-ratio: 1 / 1; width: 100%; max-width: 100px; height: auto; border-radius: 50%; object-fit: cover;" alt="profile-user" class="rounded-circle thumb-sm">
            </a>
        </div><!--end pro-metrica-end-->
    </div>
    <!--end main-icon-menu-->

    <div class="main-menu-inner">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="<?=$link?>beranda" class="logo">
                <span>
                    <h3 class="p-2">RSPM</h3>
                    <!--
                    <img src="public/resources/assets/images/logo-dark.png" alt="logo-large" class="logo-lg logo-dark">
                    <img src="public/resources/assets/images/logo.png" alt="logo-large" class="logo-lg logo-light">
                -->
            </span>
        </a><!--end logo-->
    </div><!--end topbar-left-->
    <!--end logo-->
    <div class="menu-body navbar-vertical tab-content" data-simplebar>
        <div id="MetricaDashboard" class="main-icon-menu-pane tab-pane <?php if ($_GET['halaman']=='profil') {echo "active";}?>" role="tabpanel"
        aria-labelledby="dasboard-tab">
        <div class="title-box">
            <h6 class="menu-title">Dashboard</h6>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?=$link?>beranda">Beranda</a>
            </li><!--end nav-item-->
            <?php if ($session_akses!=0) {?>
                <li class="nav-item">
                    <a class="nav-link <?php if ($_GET['halaman']=='profil') {echo "active";}?>" href="<?=$link?>profil">Profil Saya</a>
                </li><!--end nav-item-->
            <?php } ?>
        </ul><!--end nav-->
    </div><!-- end Dashboards -->

</div>
<!--end menu-body-->
</div><!-- end main-menu-inner-->
</div>
<!-- end leftbar-tab-menu-->