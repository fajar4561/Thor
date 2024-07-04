<?php 
session_start();
require '../../../env/koneksi.php';

$n = $_GET['n'];
// Dekripsi data

$koneksi->query("DELETE FROM pegawai WHERE nopeg='$n'");

$_SESSION['pesan'] = 'Data Berhasil di hapus !';
$_SESSION['info'] = 'Berhasil !';
$_SESSION['warna'] = 'success';
echo "<script>location='../../../data-pegawai';</script>"; 




?>