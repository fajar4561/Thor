<?php 
session_start();
require '../../../env/koneksi.php';

// File CSV yang diunggah
$file = $_FILES['input-file']['tmp_name'];

$file_info = pathinfo($_FILES['input-file']['name']);
$file_ext = strtolower($file_info['extension']);


// kasih pesan error apabila file yang diupload bukan berjeniskan CSV

if ($file_ext !='csv') {
	$_SESSION['pesan'] = 'File Harus berformatkan ".csv" silahkan periksa kembali';
	$_SESSION['info'] = 'Gagal Import File !';
	$_SESSION['warna'] = 'danger';
	echo "<script>window.location=history.go(-1);</script>";
}
else {
	// Buka file CSV untuk dibaca
	$handle = fopen($file, "r");

	// Buang baris pertama (judul kolom)
	fgetcsv($handle, 1000, ",");

    // Loop untuk membaca setiap baris data dari file CSV
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
	        // Memecah data menjadi variabel-variabel terpisah
		
		$nama = trim($data[2]);
		$nopeg = str_replace("'", "", $data[1]);
		$gen = $data[3];
		// gender
		if ($gen == 'L') {
			$gender ='Laki-laki';
		}
		else {
			$gender ='Perempuan';
		}

		$nik = str_replace("'", "", $data[4]);
		$tmpt_lahir = $data[10];
		$tanggal_input =$data[11];
		$tanggal_parts = explode('/', $tanggal_input);
		$tgl_lahir = date("Y-m-d", mktime(0, 0, 0, $tanggal_parts[1], $tanggal_parts[0], $tanggal_parts[2]));
		
		// jabatan
		$jabatan0 = $data[5];
		$baris = explode("\n", $jabatan0);
		$baris = array_map('trim', $baris);
		$baris = array_filter($baris);
		$jabatan = implode("\n", $baris);
		//akhir jabatan
		// unit
		$unit0 = $data[6];
		$baris2 = explode("\n", $unit0);
		$baris2 = array_map('trim', $baris2);
		$baris2 = array_filter($baris2);
		$unit = implode("\n", $baris2);
		// akhir unit
		$tmt = $data[7];
		$skpt = $data[8];
		$alamat = $data[9];
		$status_kawin = $data[12];
		$status_pegawai = $data[13];
		$telpon = str_replace("'", "", $data[14]);
		$email = $data[15];
		// menghitung umur
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
		/*
		$tanggal_masuk = new DateTime($tmt);
		$selisih = $tanggal_masuk->diff($tanggal_hari_ini);
		$sk_tahun = $selisih->y;
		$sk_bulan = $selisih->m;
		$sk_bulan += $sk_tahun * 12;
		$sk_tahun = floor($sk_bulan / 12);
		$sk_bulan = $sk_bulan % 12;
		*/
		$tahun_sekarang = date("Y");
		$sk_tahun = $tahun_sekarang - $tmt;
		$masa =  $sk_tahun." Th ";

		$password = md5($nopeg);

		//chek apakah nopeg sudah terdaftar apa belum
		$ambil= $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$nopeg'");
		$cocok = $ambil->num_rows;

		if ($cocok!=1) {
			$ambil2 = $koneksi->query("SELECT * FROM master_pegawai WHERE jabatan='$jabatan'");
			$cocok2 = $ambil2->num_rows;
			if ($cocok2!=1) {
				// simpan ke master_pegawai sebagai jabatan baru
				$koneksi->query("INSERT INTO master_pegawai (id, jabatan) VALUES(null, '$jabatan')");
			}
			// simpan data pegawai
			if ($gender=='Laki-laki') {
				$fotobaru = 'man.png';
			}
			else {
				$fotobaru = 'woman.png';
			}
			// chek apakah unit kerja sudah ada apa belum
			$ambil3= $koneksi->query("SELECT * FROM master_unit WHERE unit_kerja='$unit'");
			$cocok3 = $ambil3->num_rows;
			if ($cocok3!=1) {
				$koneksi->query("INSERT INTO master_unit (id, unit_kerja) VALUES(null, '$unit')");
			}

			$stmt = $koneksi->prepare("INSERT INTO pegawai (id, nopeg, nama, nik, gender, tmpt_lahir, tgl_lahir, umur, jabatan, unit, tmt, skpt, masa, alamat, email, telpon, status_kawin, status_pegawai, username, password, foto) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

			// Bind parameter ke prepared statement
			$stmt->bind_param("ssssssssssssssssssss", $nopeg, $nama, $nik, $gender, $tmpt_lahir, $tgl_lahir, $umur, $jabatan, $unit, $tmt, $skpt, $masa, $alamat, $email, $telpon, $status_kawin, $status_pegawai,  $nopeg, $password, $fotobaru);

			$stmt->execute();

		}

		
	  

		
	}

	$_SESSION['pesan'] = 'Data pegawai Berhasil di Import dan di Perbaharui !';
	$_SESSION['info'] = 'Berhasil !';
	$_SESSION['warna'] = 'success';
	echo "<script>location='../../../data-pegawai';</script>"; 
}
?>