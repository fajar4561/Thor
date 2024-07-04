<?php
date_default_timezone_set('Asia/Jakarta');
require 'env/koneksi.php';
require 'env/tgl_indo.php';
$ambil_pegawai = $koneksi->query("SELECT * FROM pegawai WHERE status_pegawai !='REISGN'");
$jml_pegawai = mysqli_num_rows($ambil_pegawai);

$ambil_pegawai_tetap = $koneksi->query("SELECT * FROM pegawai WHERE status_pegawai ='TETAP'");
$jml_pegawai_tetap = mysqli_num_rows($ambil_pegawai_tetap);

$ambil_pegawai_kontrak = $koneksi->query("SELECT * FROM pegawai WHERE status_pegawai ='KONTRAK'");
$jml_pegawai_kontrak = mysqli_num_rows($ambil_pegawai_kontrak);

$ambil_pegawai_resign = $koneksi->query("SELECT * FROM pegawai WHERE status_pegawai ='RESIGN'");
$jml_pegawai_resign = mysqli_num_rows($ambil_pegawai_resign);

$tanggal_hari_ini = date("Y-m-d");
$jam = date('H');

// ucapan sistem
if ($jam >= 5 && $jam < 12) {
    $ucapan = "Selamat Pagi";
} elseif ($jam >= 12 && $jam < 18) {
    $ucapan = "Selamat Siang";
} else {
    $ucapan = "Selamat Malam";
}
?>
<div class="row p-2">
    <div class="col-lg-3">
        <div class="row">
            <div class="col-auto">
                <div class="card">
                    <img class="card-img-top img-fluid bg-light-alt" src="<?=$link?>public/resources/assets/images/small/beranda.jpg" alt="Card image cap">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">
                                    <?=$ucapan?>
                                </h4>               
                            </div><!--end col-->  
                            <div class="col-auto">                  
                                <span class="badge badge-outline-light"><?=tgl_indo($tanggal_hari_ini)?></span>              
                            </div><!--end col-->                                                                            
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->
                </div>
            </div>
            <div class="col-auto">
               <div class="dash-datepick">
                    <input type="hidden" id="light_datepicker"/>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Jumlah Karyawan</p>
                                <h3 class="my-1 font-20 fw-bold"><?=$jml_pegawai?></h3>
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    <i class="ti ti-users font-24 align-self-center text-muted"></i>
                                </div>
                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">                                                
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Karyawan Tetap</p>
                                <h3 class="my-1 font-20 fw-bold"><?=$jml_pegawai_tetap?></h3>
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    <i class="ti ti-report font-24 align-self-center text-muted"></i>
                                </div>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">                                                
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Karyawan Kontrak</p>
                                <h3 class="my-1 font-20 fw-bold"><?=$jml_pegawai_kontrak?></h3>
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    <i class="ti ti-clock font-24 align-self-center text-muted"></i>
                                </div>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center">                                                
                            <div class="col-9">
                                <p class="text-dark mb-0 fw-semibold">Pegawai Resign</p>
                                <h3 class="my-1 font-20 fw-bold"><?=$jml_pegawai_resign?></h3>
                            </div><!--end col-->
                            <div class="col-3 align-self-center">
                                <div class="d-flex justify-content-center align-items-center thumb-md bg-light-alt rounded-circle mx-auto">
                                    <i class="ti ti-clock font-24 align-self-center text-muted"></i>
                                </div>
                            </div> <!--end col-->
                        </div><!--end row-->
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div>
            <div class="col-md-6 col-lg-12">
                <div class="card">   
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Customer Satisfaction</h4>                      
                            </div><!--end col-->                                       
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->  
                    <div class="card-body">
                        <div class="position-absolute bottom-50 start-50 translate-middle mb-n2">
                            <h3 class="mb-0">94.5%</h3>
                            <p class="mb-0 text-uppercase fw-semibold text-muted">Happiness</p>
                        </div> 
                        <div id="ana_device" class="apex-charts mb-2"></div>  
                        <ul class="list-inline mb-0 text-center">
                            <li class="list-inline-item mb-2 mb-lg-0 fw-semibold">
                                <i class="far fa-grin-stars text-primary font-16 align-middle me-1"></i>Excellent
                            </li>
                            <li class="list-inline-item mb-2 mb-lg-0 fw-semibold">
                                <i class="far fa-smile me-1 mb-lg-0 font-16 align-middle" style="color: #fdb5c8;"></i>Very Good
                            </li>
                            <li class="list-inline-item mb-2 fw-semibold">
                                <i class="far fa-meh text-info me-1 font-16 align-middle"></i>Good
                            </li>
                            <li class="list-inline-item fw-semibold">
                                <i class="far fa-frown  me-1 font-16 align-middle" style="color: #c693ff;"></i>Fair
                            </li>
                        </ul>  
                        <hr class="hr-dashed">                                                                   
                        <div class="media">
                            <span class="thumb-sm justify-content-center d-flex align-items-center bg-soft-warning rounded-circle me-2">MT</span>                                    
                            <div class="media-body align-self-center">
                                <p class="text-muted mb-0">There are many variations of passages of Lorem Ipsum available... 
                                    <a href="#" class="text-primary">Read more</a>
                                </p>                                           
                            </div><!--end media-body-->
                        </div>
                    </div><!--end card-body-->    
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?=$link?>public/resources/assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?=$link?>public/resources/assets/js/pages/helpdesk-index.init.js"></script>
<script src="<?=$link?>public/resources/assets/libs/litepicker/litepicker.js"></script>
<script src="<?=$link?>public/resources/assets/js/pages/projects-index.init.js"></script>