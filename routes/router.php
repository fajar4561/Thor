<?php
if ($session_akses==0) {
	// jika pengguna biasa
	if (isset($_GET['halaman'])) {
		if ($_GET["halaman"] == "beranda") {
			require "views/user/base.php";
		}
		else if ($_GET["halaman"] == "detail-gaji") {
			require "views/gaji/detail-gaji.php";
		}
		else {
			echo "<script>location='beranda';</script>";
		}
	}
	else {
		echo "<script>location='beranda';</script>";
	}
}
else {
	if (isset($_GET['halaman'])) {
		if ($_GET["halaman"] == "beranda") {
			require "views/base.php";
		}
		// # pegawai #
		else if ($_GET["halaman"] == "input-pegawai") {
			require "views/pegawai/input-pegawai.php";
		}
		else if ($_GET["halaman"] == "data-pegawai") {
			require "views/pegawai/data-pegawai.php";
		}
		else if ($_GET["halaman"] == "detail-pegawai") {
			require "views/pegawai/detail-pegawai.php";
		}
		// # Gaji #
		else if ($_GET["halaman"] == "input-gaji") {
			require "views/gaji/input-gaji.php";
		}
		else if ($_GET["halaman"] == "data-gaji") {
			require "views/gaji/data-gaji.php";
		}
		else if ($_GET["halaman"] == "detail-transaksi-gaji") {
			require "views/gaji/detail-transaksi-gaji.php";
		}
		else if ($_GET["halaman"] == "transaksi-gaji") {
			require "views/gaji/transaksi-gaji.php";
		}
		else if ($_GET["halaman"] == "detail-gaji") {
			require "views/gaji/detail-gaji.php";
		}
		else if ($_GET["halaman"] == "ubah-gaji") {
			require "views/gaji/ubah-gaji.php";
		}
		else if ($_GET["halaman"] == "absensi") {
			require "views/absensi/absensi.php";
		}
		else if ($_GET["halaman"] == "profil") {
			require "views/user/base.php";
		}
		else {
			echo "<script>location='beranda';</script>";
		}
	}
	else {
		echo "<script>location='beranda';</script>";
	}
}
?>