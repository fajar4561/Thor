<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';
?>
<?php
require 'env/koneksi.php';
require_once 'env/nama_bulan.php';
require_once 'env/tgl_indo.php';

$kode = $_GET['kode'];
$nopeg = $_GET['nopeg'];

// ambil data dari gaji

$ambil = $koneksi->query("SELECT * FROM gaji WHERE kode_transaksi='$kode' AND nopeg='$nopeg'");
$row = $ambil->fetch_assoc();

// ambil data pegawai
$ambil_pegawai = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$nopeg'");
$pecah= $ambil_pegawai->fetch_assoc();

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="met-profile">
                    <div class="row">
                        <div class="col-lg-5 align-self-center mb-3 mb-lg-0">
                            <div class="met-profile-main">
                                <div class="met-profile-main-pic">
                                    <img src="<?=$link?>public/img/<?=$pecah['foto']?>" alt="" style="border-radius: 50%; width: 70%; height: auto; display: block; margin: 0 auto; overflow: hidden;" class="rounded-circle">
                                </div>
                                <div class="met-profile_user-detail">
                                    <h5 class="met-user-name"><small><?=ucwords($pecah['nama'])?></small></h5>                              
                                    <p class="mb-0 met-user-name-post"><?=$pecah['jabatan']?></p>  
                                    <small><p class="mb-0 met-user-name-post"><?=$pecah['unit']?></p></small>                                                      
                                </div>
                            </div>                                                
                        </div><!--end col-->

                        <div class="col-lg-4 align-self-center">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>:</th>
                                    <td><?=$kode?></td>
                                </tr>
                                <tr>
                                    <th>NIP</th>
                                    <th>:</th>
                                    <td><?=$nopeg?></td>
                                </tr>
                                <tr>
                                    <th>Periode Gaji</th>
                                    <th>:</th>
                                    <td><?=bulan_indonesia($row['bulan'])?> <?=$row['tahun']?></td>
                                </tr>
                                <tr>
                                    <th>Tgl Input</th>
                                    <th>:</th>
                                    <td><?=tgl_indo($row['tgl_gaji'])?></td>
                                </tr>
                                <tr>
                                    <th></th>
                                </tr>
                            </table>
                        </div><!--end col-->
                        <div class="col-lg-3 ms-auto align-self-center">
                            
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end f_profile-->                                                                                
            </div><!--end card-body-->  
            <div class="card-body p-0">    
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#Post" role="Settings" aria-selected="true">Form Ubah Gaji</a>
                    </li>                                               
                </ul>
            <!-- Pengaturan pegawai -->                                                
            <div class="tab-pane p-3 active" id="Settings" role="tabpanel">
                <form method="post" action="../app/controller/gaji/ubah-gaji.php">
                    <input type="hidden" name="kode" value="<?=$kode?>">
                    <input type="hidden" name="nopeg" value="<?=$nopeg?>">
                    <input type="hidden" name="id" value="<?=$row['id']?>">
                    <div class="row">
                        <div class="col-lg-6 col-xl-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">                      
                                                    <h4 class="card-title">Pendapatan</h4>                      
                                                </div><!--end col-->                                                       
                                            </div>  <!--end row-->                                  
                                        </div><!--end card-header-->
                                        <div class="card-body">
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Upah</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah1" class="form-control" name="upah_awal" value="Rp. <?=number_format($row['upah_awal'],0,',','.')?>">
                                                </div>
                                            </div>                                                                           
                                        </div>                                            
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">                      
                                                    <h4 class="card-title">Tunjuangan</h4>                      
                                                </div><!--end col-->                                                       
                                            </div>  <!--end row-->                                  
                                        </div><!--end card-header-->
                                        <div class="card-body">
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Tj. Jabatan</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah7" class="form-control" name="tj_jabatan" value="Rp. <?=number_format($row['tj_jbtn'],0,',','.')?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Tj. Fungsional</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah8" class="form-control" name="tj_fungsional" value="Rp. <?=number_format($row['tj_fungsional'],0,',','.')?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Tj. TPBR / Khusus</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah10" class="form-control" name="tj_tpbri" value="Rp. <?=number_format($row['tj_tpbri'],0,',','.')?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Fee For Service</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah11" class="form-control" name="fee_for_service" value="Rp. <?=number_format($row['fee_for_servis'],0,',','.')?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Lembur</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah12" class="form-control" name="lembur" value="Rp. <?=number_format($row['lembur'],0,',','.')?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Penyesuaian Gaji</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah13" class="form-control" name="penyesuaian" value="Rp. <?=number_format($row['penyesuaian'],0,',','.')?>">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-3 col-lg-3 text-end mb-lg-0 align-self-center form-label">Tj. Lain-lain</label>
                                                <div class="col-lg-9 col-xl-8">
                                                    <input type="text" id="rupiah14" class="form-control" name="tj_lain" value="Rp. <?=number_format($row['penyesuaian'],0,',','.')?>">
                                                </div>
                                            </div>                                                                               
                                        </div>                                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-6">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row align-items-center">
                                                <div class="col">                      
                                                    <h4 class="card-title">Potongan</h4>                      
                                                </div><!--end col-->                                                       
                                            </div>  <!--end row-->                                  
                                        </div><!--end card-header-->
                                        <div class="card-body">
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-4 col-lg-4 text-end mb-lg-0 align-self-center form-label">BPJS Tenaga Kerja</label>
                                                <div class="col-lg-8 col-xl-8">
                                                    <input class="form-control" type="text" id="rupiah2" value="Rp. <?=number_format($row['bpjs_kerja'],0,',','.')?>" name="bpjs_tenaga">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-4 col-lg-4 text-end mb-lg-0 align-self-center form-label">BPJS Kesehantan</label>
                                                <div class="col-lg-8 col-xl-8">
                                                    <input class="form-control" type="text" id="rupiah3" value="Rp. <?=number_format($row['bpjs_kes'],0,',','.')?>" name="bpjs_kesehatan">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-4 col-lg-4 text-end mb-lg-0 align-self-center form-label">PPH21</label>
                                                <div class="col-lg-8 col-xl-8">
                                                    <input class="form-control" type="text" id="rupiah4" value="Rp. <?=number_format($row['pph21'],0,',','.')?>" name="pph21">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-4 col-lg-4 text-end mb-lg-0 align-self-center form-label">PPNI</label>
                                                <div class="col-lg-8 col-xl-8">
                                                    <input class="form-control" type="text" id="rupiah5" value="Rp. <?=number_format($row['ppni'],0,',','.')?>" name="ppni">
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 row">
                                                <label class="col-xl-4 col-lg-4 text-end mb-lg-0 align-self-center form-label">Lainnya</label>
                                                <div class="col-lg-8 col-xl-8">
                                                    <input class="form-control" type="text" id="rupiah6" value="Rp. <?=number_format($row['lain'],0,',','.')?>" name="lain">
                                                </div>
                                            </div>                                                                                
                                        </div>                                            
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-square btn-outline-dashed">Ubah</button>
                                <a href="../detail-transaksi-gaji/<?=$kode?>" class="btn btn-secondary btn-square btn-outline-dashed">Batal</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>        
    </div> <!--end card-body-->                            
</div><!--end card-->
</div>
</div><!--end row-->
<script src="env/js/notif.js"></script>
<?php 
require 'env/rupiah2.php';
?>
