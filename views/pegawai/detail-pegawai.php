<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';
?>
<?php
require 'env/koneksi.php';
$n = $_GET['n'];
// Dekripsi data

$ambil = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$n'");
$pecah = $ambil->fetch_assoc();
?>

<div class="row">
    <div class="col-12 p-3">
        <div class="card">
            <div class="card-body">
                <div class="met-profile">
                    <div class="row">
                        <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                            <div class="met-profile-main">
                                <div class="met-profile-main-pic">
                                    <img src="<?=$link?>public/img/<?=$pecah['foto']?>" alt="" style=" aspect-ratio: 1 / 1; width: 100%; max-width: 100px; height: auto; border-radius: 50%; object-fit: cover;">
                                </div>
                                <div class="met-profile_user-detail">
                                    <small><strong><?=ucwords($pecah['nama'])?></strong></small>                                                        
                                    <p class="mb-0 met-user-name-post"><?=$pecah['jabatan']?></p>
                                    <p class="mb-0 met-user-name-post"><?=$pecah['unit']?></p>                                                        
                                </div>
                            </div>                                                
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body py-0">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#Post" role="tab" aria-selected="true">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Gallery" role="tab" aria-selected="false">Gallery</a>
                    </li>                                                
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Settings" role="tab" aria-selected="false">Settings</a>
                    </li>
                </ul>
                <!--- Tab Pane -->
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="Post" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body  report-card">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col">
                                                        <p class="text-dark mb-1 fw-semibold">Views</p>
                                                        <h3 class="my-2 font-24 fw-bold">24k</h3>
                                                        <p class="mb-0 text-truncate text-muted"><i class="ti ti-bell text-warning font-18"></i>
                                                            <span class="text-dark fw-semibold">1500</span> New subscribers this week
                                                        </p>
                                                    </div>
                                                    <div class="col-auto align-self-center">
                                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light-alt rounded-circle mx-auto">
                                                            <i class="ti ti-eye font-30 align-self-center text-muted"></i>
                                                        </div>                                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--- End Of Tab Pane -->
            </div>
        </div>
    </div>
</div>
<script src="<?=$link?>env/js/notif.js"></script>
<script src="<?=$link?>env/js/tambah_user.js"></script>
<script src="<?=$link?>public/resources/assets/libs/@midzer/tobii/tobii.min.js"></script>
