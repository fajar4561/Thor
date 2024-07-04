<?php
session_start(); // Mulai sesi PHP

if (isset($_POST['tahun'])) {
    $_SESSION['tahun'] = $_POST['tahun'];
    $_SESSION['bulan'] = $_POST['bulan'];

    $bulan = $_SESSION['bulan'];
    $tahun = $_SESSION['tahun'];   
    require '../../../env/koneksi.php';
    $no = 0;
    $ambildata = $koneksi->query("SELECT * FROM pegawai WHERE status_pegawai!='RESIGN' ORDER BY nama ASC");
    // mengitung jumlah karyawan
    $jml_karyawan = mysqli_num_rows($ambildata);
    // chek terlebih dahulu apakah sudah ada kode transaksi pada tabel transaksi_gaji
    // dengan cara menggunakan parameter periode bulan dan tahun
    $ambil_transaksi= $koneksi->query("SELECT * FROM transaksi_gaji WHERE periode_bulan='$bulan' AND periode_tahun='$tahun'");
    $data_transaksi_cocok = $ambil_transaksi->num_rows;

    if ($data_transaksi_cocok !=1) {
        $quer = mysqli_query($koneksi, "SELECT max(kode_transaksi) as kodeTerbesar FROM transaksi_gaji ");
        $dat = mysqli_fetch_array($quer);
        $kode = $dat['kodeTerbesar'];
        $urutan = (int) substr($kode, 3, 3);
        $urutan++;
        $huruf='GJ-';
        $kode = $huruf. sprintf("%03s", $urutan);

        // status transaksi
        $status_transaksi = 'belum selesai';

        // simpan data ke transaksi gaji
        $koneksi->query("INSERT INTO transaksi_gaji (id,kode_transaksi,periode_bulan,periode_tahun,jumlah_karyawan,status_transaksi) VALUES(null, '$kode', '$bulan', '$tahun', '$jml_karyawan', '$status_transaksi')");
    }

    while ($data = mysqli_fetch_assoc($ambildata)) 
    {
        $no ++;
        $nopeg = $data['nopeg'];
        $status = 0;
        // proteksi penyimpanan data ganda
        $ambil = $koneksi->query("SELECT * FROM gaji WHERE nopeg='$nopeg' AND bulan='$bulan' AND tahun='$tahun'");
        $cocok = $ambil->num_rows;

        if ($cocok !=1 ) {
            // simpan data
            $koneksi->query("INSERT INTO gaji (id,kode_transaksi,bulan,tahun,no_gaji,nopeg,status) VALUES(null, '$kode', '$bulan', '$tahun', '$no', '$nopeg', '$status')");
        }
    }
}

/*
else {
    echo "Data tidak diterima.";
}
*/
?>