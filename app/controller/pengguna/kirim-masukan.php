<?php
session_start();
require '../../../env/koneksi.php';

date_default_timezone_set('Asia/Jakarta');

// deklarasi variabel
$tgl = date('Y-m-d');
$jam = date('H:i');
$nopeg = $_POST['nopeg'];
$input = $_POST['input'];


$koneksi->query("INSERT INTO saran (id,nopeg,tgl_saran,jam,saran) VALUES(null, '$nopeg', '$tgl', '$jam', '$input') ");


$_SESSION['pesan'] = 'Terimakasih Atas Masukan Anda !';
$_SESSION['info'] = 'Berhasil Mengirim !';
$_SESSION['warna'] = 'success';
echo "<script>window.location=history.go(-1);</script>";


?>