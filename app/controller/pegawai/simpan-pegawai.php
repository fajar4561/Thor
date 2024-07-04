<?php 
session_start();

// deklarasi variabel
$nopeg = $_POST['nopeg'];
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$gender = $_POST['gender'];
$tmpt_lahir = $_POST['tmpt_lahir'];
$tgl_lahir = $_POST['tgl_lahir'];
$jabatan = $_POST['jabatan'];
$unit = $_POST['unit'];
$tmt = $_POST['tmt'];
$skpt = $_POST['skpt'];
$ijazah = $_POST['ijazah'];
$alamat = $_POST['alamat'];
$email = $_POST['email'];
$telpon = $_POST['telpon'];
$kawin = $_POST['kawin'];
$status_pegawai = $_POST['status_pegawai'];
//umur
$tanggal_lahir_obj = new DateTime($tgl_lahir);
$tanggal_hari_ini = new DateTime();
$diff = $tanggal_lahir_obj->diff($tanggal_hari_ini);
$umur_tahun = $diff->y;
$umur_bulan = $diff->m;
$umur_bulan += $umur_tahun * 12;
$umur_tahun = floor($umur_bulan / 12);
$umur_bulan = $umur_bulan % 12;

$umur = $umur_tahun." Th ".$umur_bulan." bln";

// MENGITUNG Masa kerja
$tanggal_masuk = new DateTime($tmt);
$selisih = $tanggal_masuk->diff($tanggal_hari_ini);
$sk_tahun = $selisih->y;
$sk_bulan = $selisih->m;
$sk_bulan += $sk_tahun * 12;
$sk_tahun = floor($sk_bulan / 12);
$sk_bulan = $sk_bulan % 12;

$masa =  $sk_tahun." Th ".$sk_bulan." bln";

$foto = $_FILES['foto']['name'];
$lokasi = $_FILES['foto']['tmp_name'];

// ambil data apakah nopeg sudah terdaftar apa belum pada database
require '../../../env/koneksi.php';
$ambil = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$nopeg'");
$yangcocok = $ambil->num_rows;

if ($yangcocok==1) {
	$_SESSION['pesan'] = 'Data pegawai dengan NIP  <strong>'.$nopeg.'</strong> telah terdaftar di database, Silahkan periksa kembali';
	$_SESSION['info'] = 'peringatan !';
	$_SESSION['warna'] = 'danger';
	echo "<script>window.location=history.go(-1);</script>";
}
else {
	// tahap 2
	// chek terlebihdahulu apakah nik sudah terdaftar
	$ambil2 = $koneksi->query("SELECT * FROM pegawai WHERE nik='$nik'");
	$yangcocok2 = $ambil2->num_rows;
	if ($yangcocok2==1) {
		$_SESSION['pesan'] = 'Data pegawai dengan NIK  <strong>'.$nik.'</strong> telah terdaftar di database, Silahkan periksa kembali';
		$_SESSION['info'] = 'peringatan !';
		$_SESSION['warna'] = 'danger';
		echo "<script>window.location=history.go(-1);</script>";
	}
	else {
		// tahapa 3
		// chek apakah alamat email sudah terdaftar apa belum
		$ambil3 = $koneksi->query("SELECT * FROM pegawai WHERE email='$email'");
		$yangcocok3 = $ambil3->num_rows;
		if ($yangcocok3==1) {
			$_SESSION['pesan'] = 'Data pegawai dengan alamat email  <strong>'.$email.'</strong> telah terdaftar di database, Silahkan periksa kembali';
			$_SESSION['info'] = 'peringatan !';
			$_SESSION['warna'] = 'danger';
			echo "<script>window.location=history.go(-1);</script>";
		}
		else {
			// chek terlebih dahulu apakah ada file foto upload apa tidak
			if (empty($lokasi)) {
				// chek terlebih dahulu dengan parameter gender
				if ($gender=='Laki-laki') {
					$fotobaru = 'man.png';
				}
				else {
					$fotobaru = 'woman.png';
				}
			}
			else {
				$uniqId = uniqid();
				$fotobaru = $uniqId."_".$foto;
				move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);
			}
			// simpan data
			$password = md5("$nopeg");
			$simpan = $koneksi->query("INSERT INTO pegawai (id, nopeg, nama, nik, gender, tmpt_lahir, tgl_lahir, umur, jabatan,unit, tmt, skpt, masa, ijazah, alamat, email, telpon,status_kawin,status_pegawai, username, password, foto) VALUES (null, '$nopeg', '$nama', '$nik', '$gender', '$tmpt_lahir', '$tgl_lahir', '$umur', '$jabatan', '$unit', '$tmt', '$skpt', '$masa', '$ijazah', '$alamat', '$email', '$telpon', '$kawin', '$status_pegawai',  '$nopeg', '$password', '$fotobaru')");

			// alihkan halaman
			$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di simpan !';
			$_SESSION['info'] = 'Berhasil !';
			$_SESSION['warna'] = 'success';
			echo "<script>location='../../../data-pegawai';</script>"; 


		}
	}
}


?>