<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';


?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Data Pegawai</h4>
                <p class="text-muted mb-0">Halaman ini digunakan untuk memasukkan informasi pegawai baru ke dalam sistem. Silakan lengkapi formulir di bawah untuk menambahkan detail pegawai.
                </p>
            </div><!--end card-header-->
            <div class="card-body">  
                <form method="post" action="app/controller/pegawai/simpan-pegawai.php" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3 row">
                                <label for="example-text-input" class="col-sm-2 col-form-label text-end">NIP <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="nopeg" placeholder="Nomor Induk Pegawai" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-email-input" class="col-sm-2 col-form-label text-end">Nama <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="nama" placeholder="Nama Lengkap Pegawai" required>
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label for="example-tel-input" class="col-sm-2 col-form-label text-end">NIK <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="nik" placeholder="Nomor Induk Keluarga" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-password-input" class="col-sm-2 col-form-label text-end">Gender <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10 p-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Laki-laki" checked>
                                        <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Perempuan">
                                        <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-number-input" class="col-sm-2 col-form-label text-end">Tempat Lahir <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="tmpt_lahir" placeholder="Tempat Lahir Pegawai" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Tgl Lahir <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="date" name="tgl_lahir" required>
                                </div>
                            </div> 
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-end">Jabatan <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <select id="default" name="jabatan" required>
                                        <option>---Pilih Jabatan---</option>
                                        <?php 
                                        require 'env/koneksi.php';
                                        $sql=$koneksi->query("SELECT * FROM master_pegawai ORDER BY jabatan ASC");
                                        while ($data=mysqli_fetch_assoc($sql)) 
                                        {
                                            ?>
                                            <option value="<?=$data['jabatan']?>"><?=$data['jabatan']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-end">Unit Kerja <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="unit" required>
                                        <option>---Pilih Unit Kerja---</option>
                                        <?php 
                                        $sql=$koneksi->query("SELECT * FROM master_unit ORDER BY unit_kerja ASC");
                                        while ($data=mysqli_fetch_assoc($sql)) 
                                        {
                                            ?>
                                            <option value="<?=$data['unit_kerja']?>"><?=$data['unit_kerja']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">TMT <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="date" name="tmt" required>
                                </div>
                            </div>                              
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3 row">
                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">SKPT <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="date" name="skpt" required>
                                </div>
                            </div>   
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-end">Ijazah <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="ijazah" required>
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
                                    <textarea class="form-control" name="alamat" rows="3" placeholder="Alamat Tempat Tinggal Karyawan" required></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Email <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="email" placeholder="Alamat Email" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Telpon <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="telpon" placeholder="Nomor Telepon / WA Pegawai" required>
                                </div>
                            </div>
                            <div class="mb-2 row">
                                <label class="col-sm-2 col-form-label text-end">Status Perkawinan</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="kawin" required>
                                        <option>--- Pilih Status Perkawinan ---</option>
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label text-end">Status Pegawai <code class="highlighter-rouge">*</code></label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="status_pegawai" required>
                                        <option>--- Pilih Status Pegawai ---</option>
                                        <option value="KONTRAK">KONTRAK</option>
                                        <option value="TETAP">TETAP</option>
                                        <option value="RESIGN">RESIGN</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end">Foto</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" name="foto" >
                                </div>
                            </div>
                            <div class="mb-3 row">
                                 <label for="example-datetime-local-input" class="col-sm-2 col-form-label text-end"> </label>
                                <div class="col-sm-6">
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                    <button class="btn btn-danger" type="reset">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>                                                                      
            </div>
        </div><!--end card-->
    </div><!--end col-->
</div><!--end row-->
<script src="env/js/notif.js"></script>
