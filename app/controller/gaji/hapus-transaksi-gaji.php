<?php 
session_start();

require '../../../env/koneksi.php';

$kode = $_GET['kode'];

$koneksi->query("DELETE FROM gaji WHERE kode_transaksi='$kode'");
$koneksi->query("DELETE FROM transaksi_gaji WHERE kode_transaksi='$kode'");

$_SESSION['pesan'] = 'Data Transaksi Gaji Berhasil di Hapus !';
$_SESSION['info'] = 'Berhasil !';
$_SESSION['warna'] = 'success';


echo "<script>location='../../../data-gaji';</script>";

?>