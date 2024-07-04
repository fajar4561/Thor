<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';

require 'env/koneksi.php';
require 'env/tgl_indo.php';

if (isset($_SESSION['bulan'])) {
    unset($_SESSION['bulan']);
    unset($_SESSION['tahun']);
}


?>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <h4 class="card-title">Halaman Data Transaksi Gaji</h4>
                        <p class="text-muted mb-0">Halaman ini digunakan untuk berisikan informasi transkasi penggajian pegawai dalam sistem. Anda dapat mengubah dan menambahkan data baru ke sistem.
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <div class="p-2">
                            <div class="button-items">
                                <button type="button" class="btn btn-primary btn-square btn-outline-dashed dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Opsi <i class="mdi mdi-chevron-down"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="input-gaji">Tambah Data</a>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">Import Data</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end card-header-->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table table-responsive">
                            <table class="table table-sm" id="datatable_1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Periode</th>
                                        <th>Jumlah Karyawan</th>
                                        <th>Terproses</th>
                                        <th>Progresi</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $ambildata = $koneksi->query("SELECT * FROM transaksi_gaji ORDER BY kode_transaksi DESC");
                                        $no = 1;
                                        while ($data = mysqli_fetch_assoc($ambildata)) { 
                                        require_once 'env/nama_bulan.php';
                                        $progres = ($data['proses']/$data['jumlah_karyawan']) * 100;
                                    ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td><?=$data['kode_transaksi']?></td>
                                            <?php if ($data['tgl_transaksi']=='0000-00-00') { ?>
                                                <td> </td>
                                            <?php } else { ?>
                                                <td><?=tgl_indo($data['tgl_transaksi'])?></td>
                                            <?php } ?>
                                        <td><?=ucwords(bulan_indonesia($data['periode_bulan']))?> <?=$data['periode_tahun']?></td>
                                        <td><?=$data['jumlah_karyawan']?></td>
                                        <td><?=$data['proses']?></td>
                                        <td>
                                            <?php
                                                // Hitung kelas warna berdasarkan persentase
                                                if ($progres <= 20) {
                                                    $warna = "bg-danger"; // Warna merah untuk persentase 0% - 20%
                                                } elseif ($progres <= 40) {
                                                    $warna = "bg-warning"; // Warna oranye untuk persentase 20% - 40%
                                                } elseif ($progres <= 60) {
                                                    $warna = "bg-info"; // Warna kuning untuk persentase 40% - 60%
                                                } elseif ($progres <= 80) {
                                                    $warna = "bg-primary"; // Warna hijau untuk persentase 60% - 80%
                                                } else {
                                                    $warna = "bg-success"; // Warna biru untuk persentase 80% - 100%
                                                }
                                            ?>
                                            <small class="float-end ms-2 pt-1 font-10"><?=round($progres)?>%</small>
                                            <div class="progress mt-2" style="height:3px;">
                                                <div class="progress-bar <?=$warna?>" role="progressbar" style="width: <?php echo $progres; ?>%;" aria-valuenow="<?php echo $progres; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php 
                                                if ($data['status_transaksi']=='belum selesai')
                                                {
                                                    echo '<span class="badge rounded-pill bg-danger">Belum Selesai</span>';
                                                }
                                                else {
                                                    echo '<span class="badge rounded-pill bg-success">Selesai</span>';
                                                }
                                            ?>
                                        </td>
                                        
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                    <i class="las la-ellipsis-v font-20 text-muted"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                                    <a class="dropdown-item" href="detail-transaksi-gaji/<?=$data['kode_transaksi']?>">Detail</a>
                                                    <?php if ($data['jumlah_karyawan']!=$data['proses']) { ?>
                                                        <a class="dropdown-item" href="app/controller/gaji/export-gaji-all.php?kode=<?=$data['kode_transaksi']?>&bulan=<?=$data['periode_bulan']?>&tahun=<?=$data['periode_tahun']?>">Export</a>
                                                    <?php } ?>
                                                    <?php if ($session_akses==1) {?>
                                                    <a class="dropdown-item" href="app/controller/gaji/hapus-transaksi-gaji.php?kode=<?=$data['kode_transaksi']?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini ???')">Hapus</a>
                                                    <?php } ?>
                                                    <!--
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary<?=$data['id']?>">Ubah</a>
                                                    -->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                                                            
            </div>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
<div class="modal fade" id="exampleModalPrimary" tabindex="-1" role="dialog" aria-labelledby="exampleModalPrimary1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Import Gaji Pegawai</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->
            <form method="post" action="app/controller/gaji/import-gaji.php" enctype="multipart/form-data">
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
