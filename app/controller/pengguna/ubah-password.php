<?php 
session_start();
require '../../../env/koneksi.php';

$id = $_POST['id'];
$password = md5($_POST['password']);

$foto = $_FILES['foto']['name'];
$lokasi = $_FILES['foto']['tmp_name'];

if (!empty($_POST['password'])) {
	
	$password=md5($_POST['password']);
	$koneksi->query("UPDATE pegawai SET password='$password' WHERE id='$id'");
}

if (!empty($lokasi)) {
	$uniqId = uniqid();
	$fotobaru = $uniqId."_".$foto;
	move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);
	$koneksi->query("UPDATE pegawai SET foto='$fotobaru' WHERE id='$id'");
}


$_SESSION['pesan'] = 'Data Berhasil Diperbaharui !';
$_SESSION['info'] = 'Berhasil !';
$_SESSION['warna'] = 'success';
echo "<script>window.location=history.go(-1);</script>";
 

?>