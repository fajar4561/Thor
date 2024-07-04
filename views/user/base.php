<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';
?>
<?php
require 'env/koneksi.php';
$n = $pecahuser['nopeg'];
// Dekripsi data

$ambil = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$n'");
$pecah = $ambil->fetch_assoc();


?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body" style="background-image: url('<?=$link?>public/resources/assets/images/bg1.jpg'); background-size: cover; background-position: center center;">
                <div class="met-profile" >
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
                        </div><!--end col-->

                        <div class="col-lg-4 ms-auto align-self-center">
                            

                        </div><!--end col-->
                        <div class="col-lg-3 align-self-center">
                            <div class="row">
                                
                            </div><!--end row-->                                               
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end f_profile-->                                                                                
            </div><!--end card-body-->  
            <div class="card-body p-0">    
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link <?php if ($_GET['pesan']) {echo "";} else {echo "active";}?>" data-bs-toggle="tab" href="#Post" role="tab" aria-selected="<?php if ($_GET['pesan']) {echo "false";} else {echo "true";}?>" >Gajiku</a>
                    </li>                                               
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#Settings" role="tab" aria-selected="false">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#absensi" role="tab" aria-selected="false">Absensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($_GET['pesan']) {echo "active";}?>" data-bs-toggle="tab" href="#saran" role="tab" aria-selected="<?php if ($_GET['pesan']) {echo "active";} else {echo "false";}?>">Kritik & Saran</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane p-3 <?php if ($_GET['pesan']) {echo "";} else {echo "active";}?>" id="Post" role="tabpanel">
                        <div class="row mt-2 p-2">
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="datatable_1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal</th>
                                                    <th>Periode</th>
                                                    <th>Opsi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $ambildata = $koneksi->query("SELECT * FROM gaji WHERE nopeg='$n' AND status=1");
                                                    $no = 1;
                                                    require 'env/tgl_indo.php';
                                                    require 'env/nama_bulan.php';
                                                    while ($data = mysqli_fetch_assoc($ambildata)) {
                                                ?>
                                                <tr>
                                                    <td><?=$no++?></td>
                                                    <td><?=tgl_indo($data['tgl_gaji'])?></td>
                                                    <td><?=bulan_indonesia($data['bulan'])?> <?=$data['tahun']?></td>
                                                    <td>
                                                        <a class="btn btn-icon-circle btn-icon-circle-sm" data-bs-toggle="dropdown" aria-expanded="true"><i class="ti ti-eye-check font-16 me-1 align-text-bottom"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="<?=$link?>detail-gaji/<?=$data['kode_transaksi']?>&nopeg=<?=$n?>">Slip Gaji</a>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary<?=$data['id']?>">Slip Potongan</a>
                                                        </div>
                                                        <a class="btn btn-icon-circle btn-icon-circle-sm" href="<?=$link?>app/print/gaji/pdf.php?kode=<?=$data['kode_transaksi']?>&nopeg=<?=$n?>" target="_blank"><i class="ti ti-download font-16 me-1 align-text-bottom" data-toggle="tooltip" data-placement="top" title="Download Slip Gaji"></i></a>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="exampleModalPrimary<?=$data['id']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalPrimary1" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Slip Potongan</h6>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div><!--end modal-header-->
                                                            <div class="modal-body">
                                                                <div class="row p-3">
                                                                    <div class="col-lg-12">
                                                                        <h5>Potongan <?=bulan_indonesia($data['bulan'])?> <?=$data['tahun']?></h5>
                                                                        <span class="badge bg-soft-secondary"><?=$pecah['nama']?></span>
                                                                        <small class="text-muted ml-2">No : <?=$data['no_gaji']?></small>
                                                                        <ul class="mt-3 mb-0">
                                                                            <li>Gaji Netto : Rp.<?=number_format($data['total_pendapatan'])?></li>
                                                                            <li>Obat : Rp.<?=number_format($data['obat'])?></li>
                                                                            <li>Seragam : Rp.<?=number_format($data['seragam'])?></li>
                                                                            <li>Kredit BTN : Rp.<?=number_format($data['kredit'])?></li>
                                                                            <li>Pelatihan : Rp.<?=number_format($data['pelatihan'])?></li>
                                                                            <li>Total Potongan : Rp.<?=number_format($data['total_potongan_slip'])?></li>
                                                                            <li>Transfer : Rp.<?=number_format($data['transfer'])?></li>
                                                                        </ul>
                                                                    </div><!--end col-->
                                                                </div><!--end row-->                                                    
                                                            </div><!--end modal-body-->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                            </div><!--end modal-footer-->
                                                        </div><!--end modal-content-->
                                                    </div><!--end modal-dialog-->
                                                </div><!--end modal-->   
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!--end row--> 
                                  
                            </div><!--end col-->
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col">                      
                                                <h4 class="card-title">Berkas Kepegawaian</h4>                      
                                            </div><!--end col-->
                                            <div class="col-auto"> 
                                                <div class="dropdown">
                                                    
                                                 <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">Today</a>
                                                    <a class="dropdown-item" href="#">Yesterday</a>
                                                    <a class="dropdown-item" href="#">Last Week</a>
                                                </div>
                                            </div>               
                                        </div><!--end col-->
                                        <div class="row mt-2 align-self-center">
                                            <div class="col-lg-12">
                                                <ul class="list-group">
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                       <div>
                                                            Ijazah
                                                        </div>
                                                        <i class="la la-close text-danger font-16 me-2"></i>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                       <div>
                                                            KTP
                                                        </div>
                                                        <i class="la la-close text-danger font-16 me-2"></i>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                       <div>
                                                            KK
                                                        </div>
                                                        <i class="la la-close text-danger font-16 me-2"></i>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                       <div>
                                                            Sertifikat
                                                        </div>
                                                        <i class="la la-close text-danger font-16 me-2"></i>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-12 mt-2 lign-self-center">
                                                <a href="#" class="btn btn-primary btn-square btn-outline-dashed">Upload Berkas</a>
                                            </div>
                                        </div>
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="blog-card">
                                                                                
                                    </div><!--end blog-card-->                                                                                   
                                </div><!--end card-body-->
                            </div><!--end card-->                                           
                    </div><!--end col-->
                </div><!--end row-->  
            </div>
            <!-- Pengaturan pegawai -->                                                
            <div class="tab-pane p-3" id="Settings" role="tabpanel">
                <!--Start-->    
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row align-items-center">
                                        <div class="col">                      
                                            <h4 class="card-title">Personal Information</h4>                      
                                        </div><!--end col-->                                                       
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table class="table table-sm">
                                                <tr>
                                                    <th>NIP</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['nopeg']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['nama']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jenis Kelamin</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['gender']?></td>
                                                </tr>
                                                <tr>
                                                    <th>TTL</th>
                                                    <th>:</th>
                                                    <td><?=ucwords($pecah['tmpt_lahir'])?>, <?=tgl_indo($pecah['tgl_lahir'])?></td>
                                                </tr>
                                                <tr>
                                                    <th>Umur</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['umur']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Alamat</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['alamat']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Unit Kerja</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['unit']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Jabatan</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['jabatan']?></td>
                                                </tr>
                                                <tr>
                                                    <th>Masa Kerja</th>
                                                    <th>:</th>
                                                    <td><?=$pecah['masa']?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>                                                 
                                </div>                                            
                            </div>
                        </div> <!--end col--> 
                        <div class="col-lg-6 col-xl-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Ubah profil</h4>
                                        </div><!--end card-header-->
                                        <form action="<?=$link?>app/controller/pengguna/ubah-password.php" method="post" enctype="multipart/form-data">
                                                <div class="card-body"> 
                                                    <div class="form-group mb-3 row">
                                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Password</label>
                                                        <div class="col-lg-9 col-xl-8">
                                                            <input type="hidden" name="id" value="<?=$pecah['id']?>">
                                                            <input class="form-control" type="password" name="password" id="password" placeholder="Kata Sandi Baru">
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 row">
                                                        <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Ulangi Password</label>
                                                        <div class="col-lg-9 col-xl-8">
                                                            <input class="form-control" type="password" id="konfirmasiPassword" placeholder="Ulangi Password" onkeyup="confirmPassword()">
                                                            <div class="invalid-feedback">
                                                              * Password tidak sama!<br>
                                                              * Pastikan password sama !<br>
                                                              * Pastikan Jumlah password 6 karakter
                                                          </div>
                                                      </div>
                                                  </div>
                                                  <div class="form-group mb-3 row">
                                                    <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label"> </label>
                                                    <div class="col-lg-9 col-xl-8">
                                                        <div class="form-check form-check-inline switch">
                                                            <input type="checkbox" class="form-check-input" id="lihatPassword" onclick="showHide()">
                                                            <label class="form-label" for="lihatPassword">Lihat Password</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 row">
                                                    <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Foto</label>
                                                    <div class="col-lg-9 col-xl-8">
                                                        <input class="form-control" type="file" name="foto">
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3 row">
                                                    <div class="col-lg-9 col-xl-8 offset-lg-3">
                                                        <button type="submit" class="btn btn-de-primary" name="btn_simpan" >Ubah</button>
                                                    </div>
                                                </div>   
                                            </div><!--end card-body-->
                                        </form>
                                    </div><!--end card-->
                                </div>
                                <div class="col-lg-12">
                                    
                                </div>
                            </div>
                        </div> <!-- end col -->                                                                              
                    </div><!--end row-->
                <!--end-->
            </div>
            <div class="tab-pane p-3" id="absensi" role="tabpanel">
                <div class="row" style="background-image: url('<?=$link?>public/resources/assets/images/p-1.png'); background-size: cover; background-position: center center;">
                    <div class="col-lg-5 mx-auto">
                        <div class="card">
                            <div class="card-body p-0 auth-header-box bg-dark">
                                <div class="text-center p-3">
                                    <a href="<?=$link?>beranda" class="logo logo-admin">
                                        <img src="<?=$link?>public/resources/assets/images/lg.png" height="60" alt="logo" class="auth-logo">
                                    </a>
                                    <h4 class="mt-2 mb-1 fw-semibold text-white font-18">Coming Soon !!!</h4>   
                                    <p class="text-muted  mb-0">Fitur ini akan segera hadir di update berikutnya.</p>  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="ex-page-content text-center">
                                    <img src="<?=$link?>public/resources/assets/images/error.svg" alt="0" class="" height="170">
                                    <h1 class="mt-5 mb-4">404!</h1>  
                                    <h5 class="font-16 text-muted mb-5">Please Wait Until Next Update</h5>                                    
                                </div>          
                                <a class="btn btn-primary w-100" href="<?=$link?>beranda">Back to Dashboard <i class="fas fa-redo ml-1"></i></a>                         
                            </div><!--end card-body-->
                            <div class="card-body bg-light-alt text-center">
                                &copy; <script>
                                    document.write(new Date().getFullYear())
                                </script> Team IT RSPM                                           
                            </div><!--end card-body-->
                        </div><!--end card-->
                    </div><!--end col-->
                </div>
            </div>
            <div class="tab-pane p-3 <?php if ($_GET['pesan']) {echo "active";} else {echo " ";}?>" id="saran" role="tabpanel">
                <div class="row p-3 justify-content-center">
                    <?php if ($session_akses==1) { ?>
                        <div class="col-12">
                            <div class="email-leftbar">
                                <button type="button" class="btn btn-primary btn-sm w-100 " data-bs-toggle="modal" data-animation="bounce" data-bs-target="#compose-modal">
                                    <i class="fas fa-feather-alt me-2"></i>Compose
                                </button>

                                <div class="card mt-3">
                                    <div class="card-body">
                                        <div class="mail-list">
                                            <a href="#" class="active pt-0"><i class="las la-inbox font-15 me-1"></i>Inbox <span class="ms-1">(5)</span></a>
                                            <a href="#"><i class="las la-star font-15 me-1"></i>Starred</a>
                                            <a href="#"><i class="las la-tag font-15 me-1"></i>Important</a>
                                            <a href="#"><i class="las la-file-alt font-15 me-1"></i>Draft</a>
                                            <a href="#"><i class="las la-paper-plane font-15 me-1"></i>Sent Mail</a>
                                            <a href="#"><i class="las la-trash-alt font-15 me-1"></i>Trash</a>
                                        </div>   
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div>
                            <!-- End Left sidebar -->


                            <!-- Right Sidebar -->
                            <div class="email-rightbar">
                                <div class="float-end d-flex justify-content-between">
                                    <div class="btn-group ms-1">
                                        <button type="button" class="btn btn-sm btn-de-secondary  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-question-circle"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Updates</a>
                                            <a class="dropdown-item" href="#">Social</a>
                                            <a class="dropdown-item" href="#">Team Manage</a>
                                        </div>
                                    </div>
                                    <div class="btn-group ms-1">
                                        <button type="button" class="btn btn-sm btn-de-secondary  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Display density</a>
                                            <a class="dropdown-item" href="#">Themes</a>
                                            <a class="dropdown-item" href="#">Help</a>
                                        </div>
                                    </div>
                                </div><!-- end div -->
                                <div class="btn-toolbar" role="toolbar">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-de-secondary "><i class="fas fa-inbox"></i></button>
                                        <button type="button" class="btn btn-sm btn-de-secondary "><i class="fas fa-exclamation-circle"></i></button>
                                        <button type="button" class="btn btn-sm btn-de-secondary "><i class="fas fa-trash"></i></button>
                                    </div>
                                    <div class="btn-group ms-1">
                                        <button type="button" class="btn btn-sm btn-de-secondary  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-folder"></i><i class="mdi mdi-chevron-down ms-1"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Updates</a>
                                            <a class="dropdown-item" href="#">Social</a>
                                            <a class="dropdown-item" href="#">Team Manage</a>
                                        </div>
                                    </div>
                                    <div class="btn-group ms-1">
                                        <button type="button" class="btn btn-sm btn-de-secondary  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-tag"></i><i class="mdi mdi-chevron-down ms-1"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Updates</a>
                                            <a class="dropdown-item" href="#">Social</a>
                                            <a class="dropdown-item" href="#">Team Manage</a>
                                        </div>
                                    </div>

                                    <div class="btn-group ms-1">
                                        <button type="button" class="btn btn-sm btn-de-secondary  dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            More<i class="mdi mdi-chevron-down ms-1"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Mark as Unread</a>
                                            <a class="dropdown-item" href="#">Mark as Important</a>
                                            <a class="dropdown-item" href="#">Add to Tasks</a>
                                            <a class="dropdown-item" href="#">Add Star</a>
                                            <a class="dropdown-item" href="#">Mute</a>
                                        </div>
                                    </div>                                        
                                </div><!-- end toolbar -->


                                <div class="card my-3">
                                    <?php if (isset($_GET['pesan'])) {?>
                                        <div class="card-body">
                                            <div class="media mb-4">
                                                <?php
                                                    $pesan = $_GET['pesan']; 
                                                    $stmt = $koneksi->prepare("SELECT * FROM saran INNER JOIN pegawai ON pegawai.nopeg = saran.nopeg WHERE saran.id = ?");
                                                    // Bind parameter
                                                    $stmt->bind_param("s", $pesan);

                                                    // Jalankan query
                                                    $stmt->execute();

                                                    // Ambil hasil query
                                                    $result = $stmt->get_result();
                                                    $data_pesan = $result->fetch_assoc();
                                                ?>
                                                <img class="d-flex me-2 rounded-circle thumb-md" src="<?=$link?>public/img/<?=$data_pesan['foto']?>" alt="Generic placeholder image">
                                                <div class="media-body align-self-center">
                                                    <h5 class="font-14 m-0"><?=$data_pesan['nama']?></h5>
                                                    <small class="text-muted"><?=$data_pesan['unit']?> - <?=$data_pesan['jabatan']?></small>
                                                </div>
                                            </div>
                                            <p><?=nl2br($data_pesan['saran'])?></p>
                                            <a href="../profil" class="btn btn-de-primary btn-sm"><i class="mdi mdi-reply"></i> Kembali</a>
                                            
                                        </div>

                                    <?php } else { ?>
                                        <ul class="message-list">
                                            <?php
                                            require_once 'env/tgl_indo.php';  
                                            $ambil_saran = $koneksi->query("SELECT * FROM saran ORDER BY tgl_saran ASC");
                                            while ($data_saran = mysqli_fetch_assoc($ambil_saran)) {
                                                $saran_nopeg = $data_saran['nopeg'];
                                            // ambil data beradasarkan nopeg
                                                $ambil_nopeg = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$saran_nopeg'");
                                                $data_nopeg = $ambil_nopeg->fetch_assoc();
                                                ?>
                                                <li>                                           
                                                    <div class="col-mail col-mail-1">
                                                        <div class="checkbox-wrapper-mail">
                                                            <input type="checkbox" id="chk7">
                                                            <label for="chk7" class="toggle"></label>
                                                        </div>
                                                        <a href="profil/<?=$data_saran['id']?>">
                                                            <p class="title"><?=$data_nopeg['nama']?></p><span class="star-toggle far fa-star"></span>
                                                        </a>                                                     
                                                    </div>
                                                    <div class="col-mail col-mail-2">
                                                        <a href="profil/<?=$data_saran['id']?>" class="subject"> <span class="teaser"><?=$data_saran['saran']?></span>
                                                        </a>
                                                        <div class="date"><?=tgl_indo($data_saran['tgl_saran'])?></div>
                                                    </div>                                           
                                                </li>
                                            <?php }  ?>
                                        </ul>
                                    <?php } ?>
                                </div> <!-- panel -->

                                <div class="row mb-3">
                                    <div class="col-7 align-self-center">
                                        Showing 1 - 20 of 1,524
                                    </div><!-- end Col -->
                                    <div class="col-5">
                                        <div class="btn-group float-end">
                                            <button type="button" class="btn btn-sm btn-de-secondary waves-effect mb-0"><i class="fa fa-chevron-left"></i></button>
                                            <button type="button" class="btn btn-sm btn-de-secondary waves-effect mb-0"><i class="fa fa-chevron-right"></i></button>
                                        </div>
                                    </div><!-- end Col -->
                                </div> <!--end row-->   
                            </div>
                        </div>
                    <?php } else { ?>
                    <div class="col-md-9">
                       
                        <div class="card">
                            <div class="card-header" style="background-image: url('<?=$link?>public/resources/assets/images/small/feed.jpg'); background-size: cover; background-position: center center;">
                                <h2 class="card-title text-white">Bantu Kami Menjadi Lebih Baik</h2>
                                <p>Masukan Anda sangat berharga bagi kami. Silakan sampaikan kritik dan saran Anda melalui formulir di bawah ini.</p>
                            </div>
                            <form method="post" action="<?=$link?>app/controller/pengguna/kirim-masukan.php">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="nopeg" value="<?=$n?>">
                                            <textarea name="input" class="form-control" rows="5" placeholder="Tinggalkan pesan di sini .........."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-12 offset-lg-5">
                                            <button type="submit" class="btn btn-de-primary">Kirm</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>        
    </div> <!--end card-body-->                            
</div><!--end card-->
</div>
</div><!--end row-->
<script src="<?=$link?>env/js/notif.js"></script>
<script src="<?=$link?>env/js/tambah_user.js"></script>
<script src="<?=$link?>public/resources/assets/libs/@midzer/tobii/tobii.min.js"></script>
<script src="<?=$link?>public/resources/assets/libs/hopscotch/js/hopscotch.min.js"></script> 
<script src="<?=$link?>public/resources/assets/js/pages/tour.init.js"></script> 
<script type="text/javascript">
    document.getElementById("startButton").addEventListener("click", async () => {
            try {
                const reader = new NDEFReader();

                reader.addEventListener("reading", ({ message, serialNumber }) => {
                    console.log("Message read:", message);
                    console.log("Serial number:", serialNumber);
                    document.getElementById("output").innerHTML = `Message read: ${JSON.stringify(message)} <br> Serial number: ${serialNumber}`;
                });

                await reader.scan();

                console.log("NFC reader started.");
            } catch (error) {
                console.error("Error starting NFC reader:", error);
                alert("Error starting NFC reader: " + error.message);
            }
        });
</script>
