<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';

require 'env/koneksi.php';
$sql = "SELECT nopeg, nama, gender,CAST(nik AS CHAR) AS nik, jabatan, unit, tmt, skpt, alamat, tmpt_lahir, tgl_lahir, status_kawin, Status_pegawai, telpon, email FROM pegawai ORDER BY unit ASC, nama ASC";
$result = $koneksi->query($sql);

// hapus file
unlink('public/file/pegawai/data-pegawai.csv');

if ($result->num_rows > 0) {
    // Nama file CSV dan header
    $nama_file = 'public/file/pegawai/data-pegawai.csv';
    $header = array("No", "NIP", "Nama", "Gender", 'NIK', "Jabatan", "UNIT", "TMT", "SKPT", "Alamat", "Tempat Lahir", "Tanggal Lahir", "Status Perkawinan", "Status Pegawai", "Nomor Telepon", "Email");

    // Buka file untuk ditulis
    $file = fopen($nama_file, 'w');

    // Tulis header ke file CSV
    fputcsv($file, $header);
    $nomor_baris = 1;

    // Loop untuk menulis data
    while ($row = $result->fetch_assoc()) {
        // Ubah NIK menjadi string
        $row['nopeg'] = "'" . $row['nopeg'];
        $row['nik'] = "'" . $row['nik'];
        $row['telpon'] = "'" . $row['telpon'];

        $tgl_lahir_indonesia = date('d-m-Y', strtotime($row['tgl_lahir']));
        $row['tgl_lahir'] = $tgl_lahir_indonesia;

        // Ubah nilai gender jika diperlukan
        if ($row['gender'] == 'Laki-laki') {
            $row['gender'] = 'L';
        }
        else if ($row['gender'] == 'Perempuan')
        {
            $row['gender'] = 'P';
        }
        // Menambahkan nomor baris ke data
        $row_with_number = array_merge(array(sprintf('%d', $nomor_baris)), $row);
        
        // Tulis baris data ke file CSV
        fputcsv($file, $row_with_number);

        // Increment nomor baris
        $nomor_baris++;
    }

    // Tutup file
    fclose($file);

    // Tautan untuk mengunduh file CSV
    //echo '<a href="'.$nama_file.'" download>Unduh file CSV</a>';
}

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-10">
                        <h4 class="card-title">Halaman Data Pegawai</h4>
                        <p class="text-muted mb-0">Halaman ini digunakan untuk berisikan informasi pegawai baru ke dalam sistem. Anda dapat mengubah dan menambahkan data baru ke sistem.
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <div class="p-2">
                            <div class="button-items">
                                <button type="button" class="btn btn-primary btn-square btn-outline-dashed dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Opsi <i class="mdi mdi-chevron-down"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="input-pegawai">Tambah Data</a>
                                    <a class="dropdown-item" href="<?=$nama_file?>">Export Data</a>
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
                        <div class="table-responsive">
                            <table class="table table-sm nowrap" id="datatable_1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th></th>
                                        <th>Nama</th>
                                        <th>Kel</th>
                                        <th>Jabatan</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $ambildata = $koneksi->query("SELECT * FROM pegawai WHERE nopeg !=123 ORDER BY nama ASC");
                                        $no = 1;
                                        while ($data = mysqli_fetch_assoc($ambildata)) { 
                                    ?>
                                    <tr>
                                        <td><?=$no++?></td>
                                        <td>
                                           <!-- <img src="public/img/<?=$data['foto']?>" alt="" style=" aspect-ratio: 1 / 1; width: 100%; max-width: 100px; height: auto; border-radius: 50%; object-fit: cover;" class="rounded-circle thumb-xs me-1"> -->
                                            <?=$data['nopeg']?>
                                        </td>
                                        <td><?=ucwords($data['nama'])?></td>
                                        <td><?=ucwords($data['gender'])?></td>
                                        <td><?=ucwords($data['jabatan'])?></td>
                                        <td><?=$data['unit']?></td>
                                        <td>
                                            <?php 
                                                if ($data['status_pegawai']=='TETAP')
                                                {
                                                    echo '<span class="badge rounded-pill bg-success">Tetap</span>';
                                                }
                                                else if ($data['status_pegawai']=='KONTRAK')
                                                {
                                                    echo '<span class="badge rounded-pill bg-primary">Kontrak</span>';
                                                }  
                                                else {
                                                    echo '<span class="badge rounded-pill bg-danger">Resign</span>';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <div class="dropdown d-inline-block">
                                                <a class="dropdown-toggle arrow-none" id="dLabel11" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                    <i class="las la-ellipsis-v font-20 text-muted"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dLabel11">
                                                    <!--<a class="dropdown-item" href="detail-pegawai/<?=$data['nopeg']?>">Detail</a> -->
                                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary<?=$data['nopeg']?>">Ubah</a>
                                                    <a class="dropdown-item" href="app/controller/pegawai/hapus-pegawai.php?n=<?=$data['nopeg']?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data <?=ucwords($data['nama'])?> ?')">Hapus</a>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Modal edit Data-->
                                        <div class="modal fade" id="exampleModalPrimary<?=$data['nopeg']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalPrimary1<?=$data['id']?>" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary">
                                                        <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1<?=$data['nopeg']?>">Data <?=ucwords($data['nama'])?></h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div><!--end modal-header-->
                                                    <form method="post" action="app/controller/pegawai/ubah-pegawai.php" enctype="multipart/form-data">
                                                        <div class="modal-body bg-white">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <h5>Form Ubah Data</h5>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3 row">
                                                                                <label for="example-text-input" class="col-sm-2 col-form-label text-end">NIP <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" value="<?=$data['nopeg']?>" type="text" name="nopeg" placeholder="Nomor Induk Pegawai" readonly>
                                                                                    <input type="hidden" name="id" value="<?=$data['id']?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Nama <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="text" value="<?=$data['nama']?>" name="nama" placeholder="Nama Lengkap Pegawai" required>
                                                                                </div>
                                                                            </div> 
                                                                            <div class="mb-3 row">
                                                                                <label for="example-tel-input" class="col-sm-2 col-form-label text-end">NIK <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="text" value="<?=$data['nik']?>" name="nik" placeholder="Nomor Induk Keluarga" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-password-input" class="col-sm-2 col-form-label text-end">Gender <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10 p-2">
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Laki-laki" <?php if ($data["gender"]=="Laki-laki") {echo "checked"; } ?>>
                                                                                        <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                                                                                    </div>
                                                                                    <div class="form-check form-check-inline">
                                                                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Perempuan" <?php if ($data["gender"]=="Perempuan") {echo "checked"; } ?>>
                                                                                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-number-input" class="col-sm-2 col-form-label text-end">Tempat Lahir <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="text" value="<?=$data['tmpt_lahir']?>" name="tmpt_lahir" placeholder="Tempat Lahir Pegawai" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Tgl Lahir <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="date" name="tgl_lahir" value="<?=$data['tgl_lahir']?>" required>
                                                                                </div>
                                                                            </div> 
                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label text-end">Jabatan<code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-control" name="jabatan" required>
                                                                                        <option value="<?=$data['jabatan']?>"><?=$data['jabatan']?></option>
                                                                                        <option>---Pilih Jabatan---</option>
                                                                                        <?php 
                                                                                        $sql=$koneksi->query("SELECT * FROM master_pegawai ORDER BY jabatan ASC");
                                                                                        while ($dat=mysqli_fetch_assoc($sql)) 
                                                                                        {
                                                                                            ?>
                                                                                            <option value="<?=$dat['jabatan']?>"><?=$dat['jabatan']?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label text-end">Unit<code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-control" name="unit" required>
                                                                                        <option value="<?=$data['unit']?>"><?=$data['unit']?></option>
                                                                                        <option>---Pilih Unit---</option>
                                                                                        <?php 
                                                                                        $sql=$koneksi->query("SELECT * FROM master_unit ORDER BY unit_kerja ASC");
                                                                                        while ($dat=mysqli_fetch_assoc($sql)) 
                                                                                        {
                                                                                            ?>
                                                                                            <option value="<?=$dat['unit_kerja']?>"><?=$dat['unit_kerja']?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">TMT <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="date" name="tmt" value="<?=$data['tmt']?>" required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">SKPT <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="date" name="skpt" value="<?=$data['skpt']?>" required>
                                                                                </div>
                                                                            </div>                                 
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label text-end">Ijazah <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-select" name="ijazah">
                                                                                        <option value="<?=$data['ijazah']?>"><?=$data['ijazah']?></option>
                                                                                        <option>---Pilih Ijazah---</option>
                                                                                        <option value="SMA">SMA/SMK</option>
                                                                                        <option value="DI">DI</option>
                                                                                        <option value="DII">DII</option>
                                                                                        <option value="DIII">DIII</option>
                                                                                        <option value="DIV">DIV</option>
                                                                                        <option value="SI">SI</option>
                                                                                        <option value="SII">SII</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Alamat <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat Tempat Tinggal Karyawan"><?=$data['alamat']?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Email <code class="highlighter-rouge">*</code></label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="text" value="<?=$data['email']?>" name="email" placeholder="Alamat Email">
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-2 row">
                                                                                <label class="col-sm-2 col-form-label text-end">Status Kawinan</label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-select" name="kawin">
                                                                                        <option value="<?=$data['status_kawin']?>"><?=$data['status_kawin']?></option>
                                                                                        <option>--- Pilih Status Perkawinan ---</option>
                                                                                        <option value="Belum Kawin">Belum Kawin</option>
                                                                                        <option value="Kawin">Kawin</option>
                                                                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                                                                        <option value="Cerai Mati">Cerai Mati</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label class="col-sm-2 col-form-label text-end">Status Pegawai</label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-select" name="status_pegawai" required>
                                                                                        <option value="<?=$data['status_pegawai']?>"><?=$data['status_pegawai']?></option>
                                                                                        <option>--- Pilih Status Pegawai ---</option>
                                                                                        <option value="KONTRAK">KONTRAK</option>
                                                                                        <option value="TETAP">TETAP</option>
                                                                                        <option value="RESIGN">RESIGN</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Telepon</label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="text" value="<?=$data['telpon']?>" name="telpon" placeholder="Nomor Telepon / WA Pegawai" >
                                                                                </div>
                                                                            </div>
                                                                            <?php if ($session_akses==1) { ?>
                                                                            <input class="form-control" type="hidden" value="<?=$data['username']?>" name="username" placeholder="Username Pegawai" >
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Pswd</label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="text" name="password" placeholder="Kata Sandi Pegawai">
                                                                                </div>
                                                                            </div>
                                                                            <div class="mb-3 row">
                                                                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Foto</label>
                                                                                <div class="col-sm-10">
                                                                                    <input class="form-control" type="file" name="foto" >
                                                                                </div>
                                                                            </div>
                                                                            <?php } else { ?>
                                                                                <input class="form-control" type="hidden" name="password" placeholder="Kata Sandi Pegawai">
                                                                                <input class="form-control" type="hidden" name="foto" >
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div><!--end col-->
                                                            </div><!--end row-->                                                    
                                                        </div><!--end modal-body-->
                                                        <div class="modal-footer bg-white">
                                                            <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-de-primary btn-sm">Save changes</button>
                                                        </div>
                                                    </form><!--end modal-footer-->
                                                </div><!--end modal-content-->
                                            </div><!--end modal-dialog-->
                                        </div>
                                        <!-- End Modal edit Data-->
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
                <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">Import Data Pegawai</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->
            <form method="post" action="app/controller/pegawai/import-pegawai.php" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="d-grid">
                                <p class="text-muted">Pastikan File yang diupload berformatkan "CSV".</p>
                                <div class="preview-box d-block justify-content-center rounded shadow overflow-hidden bg-light p-1"></div>
                                <input type="file" id="input-file" name="input-file" onchange="handleChange()" hidden />
                                <label class="btn-upload btn btn-primary mt-4" for="input-file">Pilih File</label>
                            </div>
                        </div>
                    </div>                                                   
                </div><!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-de-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-de-primary btn-sm"  id="submit-btn" hidden>Save</button>
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
