<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';
?>
<?php
require 'env/koneksi.php';
$kode = $_GET['kode'];
// Dekripsi data

$ambil = $koneksi->query("SELECT * FROM transaksi_gaji WHERE kode_transaksi='$kode'");
$pecah = $ambil->fetch_assoc();
$bulan = $pecah['periode_bulan'];
$tahun = $pecah['periode_tahun'];
require 'env/nama_bulan.php';

?>

<div class="row">
    <div class="col-sm-12">
        <div class="card">  
            <div class="card-body p-0">    
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#Post" role="tab" aria-selected="true">Detail Transaksi</a>
                    </li>                                               
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane p-3 active" id="Post" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">                                                        
                                            <div class="card-body  report-card">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col">
                                                        <h3 class="my-2 font-24 fw-bold">Periode <?=ucwords($nama)?> <?=$pecah['periode_tahun']?></h3>
                                                        <p class="mb-0 text-truncate text-muted"><i class="ti ti-bell text-warning font-18"></i>
                                                            Diserhakan <span class="text-dark fw-semibold"><?=ucwords(bulan_indonesia($bulan+1))?> <?=$pecah['periode_tahun']?></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-auto align-self-center">
                                                        <div class="d-flex justify-content-center align-items-center thumb-xl bg-light-alt rounded-circle mx-auto">
                                                            <i class="ti ti-eye font-30 align-self-center text-muted"></i>
                                                        </div>                                                                    
                                                    </div>
                                                </div>
                                            </div><!--end card-body-->          
                                        </div> <!--end card-->    
                                    </div><!--end col-->
                                </div><!--end row--> 
                                <div class="card">
                                    <div class="card-body">
                                    <?php if ($pecah['total_gaji'] > 0 ) { ?>
                                        <div class="table-responsive">
                                            <table class="teble table-sm" id="datatable_1">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>NIP</th>
                                                        <th>Nama</th>
                                                        <th>No Gaji</th>
                                                        <th>Unit</th>
                                                        <th>Total Gaji</th>
                                                        <th> </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $ambildata = $koneksi->query("SELECT * FROM gaji INNER JOIN pegawai ON gaji.nopeg=pegawai.nopeg WHERE bulan='$bulan' AND tahun='$tahun' AND status=1");
                                                    $no = 1;
                                                    while ($data = mysqli_fetch_assoc($ambildata)) {
                                                    ?>
                                                    <tr>
                                                        <td><?=$no++?></td>
                                                        <td><?=$data['nopeg']?></td>
                                                        <td><?=$data['nama']?></td>
                                                        <td><?=$data['no_gaji']?></td>
                                                        <td><?=$data['unit']?></td>
                                                        <td>Rp.<?=number_format($data['total_pendapatan'])?></td>
                                                        <td>
                                                           <div class="dropdown d-inline-block">
                                                                <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                                    <i class="las la-ellipsis-v font-20 text-muted"></i>
                                                                </a>
                                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                                                    <a class="dropdown-item" href="../detail-gaji/<?=$kode?>&nopeg=<?=$data['nopeg']?>"><i class="ti ti-eye-check font-16 me-1 align-text-bottom"></i> Lihat</a>
                                                                    <a class="dropdown-item" href="../ubah-gaji/<?=$kode?>&nopeg=<?=$data['nopeg']?>"><i class="ti ti-eye-check font-16 me-1 align-text-bottom"></i> Ubah</a>
                                                                    <a class="dropdown-item" href="../app/controller/gaji/hapus-gaji.php?kode=<?=$kode?>&nopeg=<?=$data['nopeg']?>"><i class="ti ti-trash font-16 me-1 align-text-bottom"></i> Hapus</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php } else { ?>
                                        <center><p>Belum ada Data transaksi gaji Yang terinput</p></center>
                                    <?php } ?>                                                    
                                    </div>
                                </div>  
                            </div><!--end col-->
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col">                      
                                                <h4 class="card-title">Unit Kerja</h4>                      
                                            </div><!--end col-->
                                            <div class="col-auto"> 
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                     Opsi<i class="las la-angle-down ms-1"></i>
                                                 </a>
                                                 <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">Import File Gaji</a>
                                                </div>
                                            </div>               
                                        </div><!--end col-->
                                    </div>  <!--end row-->                                  
                                </div><!--end card-header-->
                                <div class="card-body">
                                    <div class="blog-card">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="list-group">
                                                    <?php
                                                        $sql = "SELECT master_unit.*, pegawai.* 
                                                        FROM master_unit 
                                                        INNER JOIN pegawai ON master_unit.unit_kerja = pegawai.unit 
                                                        GROUP BY master_unit.unit_kerja 
                                                        ORDER BY master_unit.unit_kerja ASC";
                                                        $result = $koneksi->query($sql);
                                                        while ($data=mysqli_fetch_assoc($result)) 
                                                        {
                                                            // ambil data jumlah pegawai berdasarkan unit
                                                            $unit = $data['unit_kerja'];
                                                            $ambil = $koneksi->query("SELECT * FROM pegawai WHERE status_pegawai!='RESIGN' AND unit='$unit'");
                                                            $jumlah_pegawai =mysqli_num_rows($ambil);
                                                            $row = $ambil->fetch_assoc();

                                                            $nopeg= $row['nopeg'];

                                                            // ambil data yang sudah terinput
                                                            $ambil_gaji = $koneksi->query("SELECT * FROM gaji INNER JOIN pegawai ON gaji.nopeg=pegawai.nopeg WHERE bulan='$bulan' AND tahun='$tahun' AND unit='$unit' AND status=1");
                                                            $jml_selesai = mysqli_num_rows($ambil_gaji);
                                                    ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <?php if ($jumlah_pegawai==$jml_selesai) { ?>
                                                            <div>
                                                                <i class="la la-check text-success font-16 me-2"></i> <?=$data['unit_kerja']?><small> (<?=$jumlah_pegawai?>)</small>
                                                            </div>
                                                            <?php if ($jml_selesai > 0 ) { ?>
                                                                <span class="badge badge-outline-primary badge-pill"><?=$jml_selesai?></span>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            <div>
                                                                <i class=" me-2"></i><a href="../transaksi-gaji/GJ-001&bulan=<?=$bulan?>&tahun=<?=$tahun?>&unit=<?=$data['unit_kerja']?>&jenis=1"><?=$data['unit_kerja']?></a> <small>(<?=$jumlah_pegawai?>)</small>
                                                            </div>
                                                            <?php if ($jml_selesai > 0 ) { ?>
                                                                <span class="badge badge-outline-primary badge-pill"><?=$jml_selesai?></span>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </li>
                                                    <?php } ?>
                                                </ul><!--end list-group-->
                                            </div>
                                        </div>                                        
                                    </div><!--end blog-card-->                                                                                   
                                </div><!--end card-body-->
                            </div><!--end card--> 
                        </div><!--end card-->                                            
                    </div><!--end col-->
                </div><!--end row-->  
            </div>
            <!-- Pengaturan pegawai -->                                              
        </div>        
    </div> <!--end card-body-->                            
</div><!--end card-->
</div>
</div><!--end row-->

<div class="modal fade" id="exampleModalPrimary" tabindex="-1" role="dialog" aria-labelledby="exampleModalPrimary1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Import Gaji Pegawai</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->
            <form method="post" action="<?=$link?>app/controller/gaji/import-gaji.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="d-grid">
                                <p class="text-muted">Pastikan File yang diupload berformatkan "CSV".</p>
                                <div class="preview-box d-block justify-content-center rounded shadow overflow-hidden bg-light p-1"></div>
                                <input type="file" id="input-file" name="input-file" onchange="handleChange()" hidden />
                                <label class="btn-upload btn btn-primary mt-4" for="input-file">Upload File</label>
                            </div>
                        </div>
                    </div>                                                   
                </div><!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-de-primary btn-sm" id="submit-btn" hidden>Save</button>
                </div><!--end modal-footer-->
            </form>
        </div><!--end modal-content-->
    </div><!--end modal-dialog-->
</div>
<script src="env/js/notif.js"></script>
<script>
   $(document).ready(function() {
        $('#example').DataTable({
            scrollX: true,
            scrollY: 500,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 3 // atur jumlah kolom yang akan dibekukan
            },
            paging: false, // menonaktifkan paging
            searching: true, // Aktifkan fitur pencarian
            language: {
                search: "Cari:", // Ubah teks pencarian sesuai keinginan Anda
                searchPlaceholder: "Masukkan kata kunci..." // Ubah placeholder input pencarian sesuai keinginan Anda
            }
        });
    });
</script>
<script>
function handleChange() {
    // Ambil input file
    var inputFile = document.getElementById('input-file');
    
    // Cek apakah file telah dipilih
    if (inputFile.files.length > 0) {
        // Jika file dipilih, tampilkan tombol submit dan submitkan formulir
        document.getElementById('submit-btn').click();
    }
}
</script>
