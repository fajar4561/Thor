<?php 
require 'env/koneksi.php';

if (isset($_POST['cari'])) {

    // deklarasikan session bulan dan tahun yang dipilih
    $bulan2 = $_SESSION['bulan'];
    $tahun = $_SESSION['tahun'];
    $jenis= $_POST['jenis'];

    if ($jenis==1) { // sortir data berdasarkan unit
        $unit = $_POST['unit'];
        $ambildata = $koneksi->query("SELECT * FROM gaji INNER JOIN pegawai ON gaji.nopeg=pegawai.nopeg WHERE status_pegawai!='RESIGN' AND unit='$unit' AND bulan='$bulan2' AND tahun='$tahun' AND status='0' ORDER BY nama ASC");

        $sql = "SELECT pegawai.nopeg, nama, jabatan, unit, bulan, tahun FROM gaji INNER JOIN pegawai ON gaji.nopeg=pegawai.nopeg WHERE status_pegawai!='RESIGN' AND unit='$unit' AND bulan='$bulan2' AND tahun='$tahun' AND status='0' ORDER BY nama ASC";
        $result = $koneksi->query($sql);

        // export ke file excel
        $nama_file = 'public/file/gaji/Penggajian-'.$unit.'-Bulan-'.$bulan2.'-'.$tahun.'.csv';
        $header = array("No", "NIP", "Nama", "Jabatan", "Unit", "Periode Bulan", "Periode Tahun", "Upah", "TJ.JABATAN", "TJ.FUNGSIONAL", "TJ.RESIKO", "TJ.TPBR/KHUSUS", "FEE FOR SERVICE", "LEMBUR", "THR/THN", "LAIN-LAIN", "GAJI BRUTO", "BPJS TK", "BPJS KES", "PPH21", "PPNI","LAIN-LAIN", "TOTAL POTONGAN","GAJI NETTO", "OBAT","SERAGAM KARYAWAN", "KREDIT BTN", "LAIN-LAIN / BY PELATIHAN", "TOTAL POT", "TRANSFER");

        // Buka file untuk ditulis
        $file = fopen($nama_file, 'w');

        // Tulis header ke file CSV
        fputcsv($file, $header);
        $nomor_baris = 1;

        // Loop untuk menulis data
        // Loop untuk menulis data
        while ($row = $result->fetch_assoc()) {
    // Menambahkan nomor baris ke data
            $row_with_number = array_merge(array(sprintf('%d', $nomor_baris)), $row);
            
    // Mengonversi nilai nopeg menjadi string dan menambahkan tanda kutip di awal
            $row_with_number['nopeg'] = "'" . $row_with_number['nopeg'];
            
    // Tulis baris data ke file CSV
            fputcsv($file, $row_with_number);
            
    // Increment nomor baris
            $nomor_baris++;
        }

        // Tutup file
        fclose($file);
    }
    else {
        $ambildata = $koneksi->query("SELECT * FROM gaji INNER JOIN pegawai ON gaji.nopeg=pegawai.nopeg WHERE status_pegawai!='RESIGN' AND bulan='$bulan2' AND tahun='$tahun' ORDER BY nama ASC");

        $sql = "SELECT pegawai.nopeg, nama, jabatan, unit, bulan, tahun FROM gaji INNER JOIN pegawai ON gaji.nopeg=pegawai.nopeg WHERE status_pegawai!='RESIGN' AND bulan='$bulan2' AND tahun='$tahun' AND status='0' ORDER BY nama ASC";
        $result = $koneksi->query($sql);

        // export ke file excel
        $nama_file = 'public/file/gaji/Penggajian-Bulan-'.$bulan2.'-'.$tahun.'.csv';
        $header = array("No", "NIP", "Nama", "Jabatan", "Unit", "Periode Bulan", "Periode Tahun", "Upah", "TJ.JABATAN", "TJ.FUNGSIONAL", "TJ.RESIKO", "TJ.TPBR/KHUSUS", "FEE FOR SERVICE", "LEMBUR", "THR/THN", "LAIN-LAIN", "GAJI BRUTO", "BPJS TK", "BPJS KES", "PPH21", "PPNI","LAIN-LAIN", "TOTAL POTONGAN","GAJI NETTO", "OBAT","SERAGAM KARYAWAN", "KREDIT BTN", "LAIN-LAIN / BY PELATIHAN", "TOTAL POT", "TRANSFER");

        // Buka file untuk ditulis
        $file = fopen($nama_file, 'w');

        // Tulis header ke file CSV
        fputcsv($file, $header);
        $nomor_baris = 1;

       // Loop untuk menulis data
        while ($row = $result->fetch_assoc()) {
    // Menambahkan nomor baris ke data
            $row_with_number = array_merge(array(sprintf('%d', $nomor_baris)), $row);
            
    // Mengonversi nilai nopeg menjadi string dan menambahkan tanda kutip di awal
            $row_with_number['nopeg'] = "'" . $row_with_number['nopeg'];
            
    // Tulis baris data ke file CSV
            fputcsv($file, $row_with_number);
            
    // Increment nomor baris
            $nomor_baris++;
        }

        // Tutup file
        fclose($file);
    }
$jml_data = mysqli_num_rows($ambildata);
}
else {
    $jml_data = 0;
}


?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Input Gaji Pegawai</h4>
                <p class="text-muted mb-0">Pastikan Anda mengisi semua <code class="highlighter-rouge">formulir</code> dan <code class="highlighter-rouge">&lt;input&gt;</code> <code class="highlighter-rouge">gaji</code> karyawan dengan benar.</p>
            </div><!--end card-header-->
            <div class="card-body">
                <div class="row p-1">
                    <div class="col-lg-6">
                        <form>
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="inputPassword6" class="col-form-label">Periode Gaji</label>
                                </div>
                                <div class="col-auto">
                                    <select class="select2 form-control" name="bulan" id="bulan" required>
                                        <?php 
                                            if (isset($_SESSION['bulan'])) {
                                            $bulan = $_SESSION['bulan'];
                                            require 'env/nama_bulan.php';
                                        ?>
                                            <option value="<?=$bulan?>"><?=$nama?></option>
                                        <?php } ?>
                                        <option>---Pilih Bulan---</option>
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3">Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                        <option value="7">Juli</option>
                                        <option value="8">Agustus</option>
                                        <option value="9">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="11">November</option>
                                        <option value="12">Desember</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select class="select2 form-select" name="tahun" id="tahun" required>
                                        <?php
                                            echo '<option selected>--- Pilih Tahun ---</option>'; 
                                            $mulai= date('Y') - 5;for($i = $mulai;$i<$mulai + 100;$i++)
                                            {
                                                $sel = $i == date('Y') ? ' selected="selected"' : '';
                                                echo '<option value="'.$i.'">'.$i.'</option>'; 
                                            } 
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <form method="post">
                            <div class="row g-3 align-items-center">
                                <div class="col-sm-2">
                                    <label for="inputPassword6" class="col-form-label">Data</label>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-select select2" name="jenis" onChange="tampil(this.value)">
                                        <option>--- Pilih ---</option>
                                        <option value="1">Unit</option>
                                        <option value="2">Semua Data</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <div id="tampil"></div>
                                </div>
                                <div class="col-sm-3">
                                    <div id="tampil2"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if (isset($_POST['cari'])) { ?>
                    <?php if ($jml_data > 0) { ?>
                        <div class="row mt-3">
                            <div class="col-sm-12">
                                <form method="post" action="app/controller/gaji/simpan-gaji.php">
                                    <div class="table-responsive">
                                        <table id="example" class="table table-sm table-striped" style="white-space: nowrap;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Unit</th>
                                                    <th>Upah</th>
                                                    <th>BPJS Tenaga Kerja</th>
                                                    <th>BPJS Kesehatan</th>
                                                    <th>PPH 21</th>
                                                    <th>PPNI</th>
                                                    <th>Lain-lain</th>
                                                    <th>TJ. Jabatan</th>
                                                    <th>TJ. Fungsional</th>
                                                    <th>TJ. TPBR/Khusus</th>
                                                    <th>Fee For Service</th>
                                                    <th>Lembur Pelayanan</th>
                                                    <th>Penyesuaian Gaji</th>
                                                    <th>TJ Lain-lain</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php
                                                    $no = 1;
                                                    while ($data = mysqli_fetch_assoc($ambildata)) { 
                                                 ?>
                                                    <tr>
                                                       <td><?=$no++?></td>
                                                       <td><?=$data['nopeg']?></td>
                                                       <td><?=strtoupper($data['nama'])?></td>
                                                       <td><?=$data['jabatan']?></td>
                                                       <td><?=$data['unit']?></td>
                                                       <input type="hidden" name="nopeg[]" value="<?=$data['nopeg']?>">
                                                       <td><input type="text" id="rupiah1<?=$data['id']?>" class="form-control" style="width: 120px;" name="upah_awal[]"></td>
                                                       <td><input type="text" id="rupiah7<?=$data['id']?>" style="width: 120px;" name="bpjs_tenaga[]" class="form-control"></td>
                                                       <td><input type="text" id="rupiah8<?=$data['id']?>" name="bpjs_kesehatan[]" class="form-control"></td>
                                                       <td><input type="text" id="rupiah18<?=$data['id']?>" name="pph21[]" style="width: 100px;"  class="form-control"></td>
                                                       <td><input type="text" id="rupiah9<?=$data['id']?>" name="ppni[]" style="width: 100px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah10<?=$data['id']?>" name="lain[]" style="width: 120px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah11<?=$data['id']?>" name="tj_jabatan[]" style="width: 120px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah12<?=$data['id']?>" name="tj_fungsional[]" style="width: 120px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah13<?=$data['id']?>" name="tj_tpbri[]" style="width: 120px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah14<?=$data['id']?>" name="fee_for_service[]" style="width: 120px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah15<?=$data['id']?>" name="lembur[]" style="width: 120px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah16<?=$data['id']?>" name="penyesuaian[]" style="width: 120px;" class="form-control"></td>
                                                       <td><input type="text" id="rupiah17<?=$data['id']?>" name="tj_lain[]" style="width: 120px;" class="form-control" ></td>

                                                       <!---JS ubah ke format Rupiah-->
                                                       <?php 
                                                        require 'env/rupiah.php';
                                                       ?>

                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="d-flex flex-row-reverse">
                                          <?php if (isset($_POST['cari'])) { ?>
                                            <div class="p-2"><a href="<?=$nama_file?>" class="btn btn-secondary btn-square btn-outline-dashed">Export</a></div>  
                                          <?php } ?>
                                          <div class="p-2"><button class="btn btn-primary btn-square btn-outline-dashed" type="submit">Simpan</button></div>
                                          <div class="p-2">
                                            <a class="btn btn-info btn-square btn-outline-dashed" href="#" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary">Import</a>
                                          </div>
                                      </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row mt-3 p-3">
                            <div class="col-sm-12">
                                <center><p class="text-uppercase">Data Unit <?=$unit?> Kosong</p></center>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>                                                       
            </div><!--end card-body-->
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
    function tampil(jenis) {
        var tampil = "";
        switch (jenis) {
            case "1":
                <?php
                // Query untuk mengambil data jabatan
                $sql = $koneksi->query("SELECT * FROM master_unit ORDER BY unit_kerja ASC");
                $tampil_opsi = "";
                while ($data = mysqli_fetch_assoc($sql)) {
                    // Tambahkan opsi jabatan ke dalam variabel JavaScript $tampil_opsi
                    $tampil_opsi .= '<option value="'.$data['unit_kerja'].'">'. $data['unit_kerja'].'</option>';
                }
                ?>
                tampil = '<div class="col-auto"><select name="unit" class="form-select" required><option>---Pilih Unit---</option><?php echo $tampil_opsi; ?></select></div>';
                break;
            case "2":
                tampil ='<button class="btn btn-primary btn-sm" type="submit" name="cari">Tampilkan</button>';
                break;
            default:
                tampil = "";
                break;
        }
        var tampil2 ="";
        switch (jenis) {
        case "1":
            tampil2 ='<button class="btn btn-primary btn-sm" type="submit" name="cari">Tampilkan</button>';
            break;
        default:
            tampil2 = "";
            break;
        }
        document.getElementById('tampil').innerHTML = tampil;
        document.getElementById('tampil2').innerHTML = tampil2;
    }
</script>


<script>
    $(document).ready(function() {
            // Tambahkan event listener untuk menanggapi perubahan pada elemen select
            $('#tahun').change(function() {
                // Ambil nilai yang dipilih
                var tahun = $(this).val();
                var bulan = $("select[name=bulan").val();
                
                // Tampilkan nilai yang dipilih dalam sebuah alert
                // alert("Anda memilih bulan dengan nilai: " + bulan + tahun);

                $.ajax({
                    url: 'app/controller/gaji/simpan_session.php', // Ganti 'simpan_session.php' dengan nama file PHP yang Anda inginkan
                    type: 'POST',
                    data: { 
                        tahun: tahun, // Tambahkan data jumlah_tahun
                        bulan: bulan  
                        },
                    /*
                    success: function(response) {
                        alert(response); // Menampilkan pesan respons dari PHP
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr);
                    }
                    */
                });    
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
