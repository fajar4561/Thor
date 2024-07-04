<?php 
session_start();
require '../../../env/koneksi.php';

//deklarasi variabel
$id = $_POST['id'];
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
$kawin = $_POST['kawin'];
$status_pegawai = $_POST['status_pegawai'];
$telpon = $_POST['telpon'];
$username = $_POST['username'];

$p = md5($_POST['password']);

$ambil_pass = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$nopeg'");
$data_pass = $ambil_pass->fetch_assoc();
if (!empty($_POST['password'])) {
	
	$password=$p;
}
else {
	$password = $data_pass['password'];
}

//umur
$tanggal_lahir_obj = new DateTime($tgl_lahir);
$tanggal_hari_ini = new DateTime();
$umur = $tanggal_lahir_obj->diff($tanggal_hari_ini)->y;

$foto = $_FILES['foto']['name'];
$lokasi = $_FILES['foto']['tmp_name'];

// ambil data berdasarkan parameter nopeg
$ambil = $koneksi->query("SELECT * FROM pegawai WHERE id='$id'");
$pecah = $ambil->fetch_assoc();

// deklarasi variabel data lama
$nopeg_lama = $pecah['nopeg'];
$nik_lama = $pecah['nik'];
$email_lama = $pecah['email'];

// apabila nopeg mengalami perubahan
if ($nopeg_lama!=$nopeg) {
	//chek apakah nopeg yang diinputkan sudah terdaftar di database apa belum
	$ambil2= $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$nopeg'");
	$yangcocok = $ambil2->num_rows;

	if ($yangcocok==1) {
		$_SESSION['pesan'] = 'Data pegawai dengan NIP  <strong>'.$nopeg.'</strong> telah terdaftar di database, Silahkan periksa kembali';
		$_SESSION['info'] = 'peringatan !';
		$_SESSION['warna'] = 'danger';
		echo "<script>window.location=history.go(-1);</script>";
	}
	else {
		// jika nopeg baru tidak terdaftar
		// chek apakah nik mengalami perubahan apa tidak
		if ($nik_lama!=$nik) {
			// chek apakah nik yang baru sudah terdaftar apa belum
			$ambil3 = $koneksi->query("SELECT * FROM pegawai WHERE nik='$nik'");
			$yangcocok2 = $ambil3->num_rows;

			if ($yangcocok2==1) {
			 	$_SESSION['pesan'] = 'Data pegawai dengan NIK  <strong>'.$nik.'</strong> telah terdaftar di database, Silahkan periksa kembali';
				$_SESSION['info'] = 'peringatan !';
				$_SESSION['warna'] = 'danger';
				echo "<script>window.location=history.go(-1);</script>";
			 }
			 else {
			 	// apabila nik yang baru tidak terdaftar
			 	// chek apakah email mengalami perubahan apa tidak
			 	if ($email_lama!=$email) {
			 		$ambil4 = $koneksi->query("SELECT * FROM pegawai WHERE email='$email'");
			 		$yangcocok3 = $ambil4->num_rows;
			 		if ($yangcocok3==1) {
			 			$_SESSION['pesan'] = 'Data pegawai dengan alamat email  <strong>'.$email.'</strong> telah terdaftar di database, Silahkan periksa kembali';
			 			$_SESSION['info'] = 'peringatan !';
			 			$_SESSION['warna'] = 'danger';
			 			echo "<script>window.location=history.go(-1);</script>";
			 		}
			 		else {
			 		// jika email yang baru tidak terdafatar maka,
			 		// update data
			 		// chek apakah ada inputan foto apa tidak
			 			if (empty($lokasi)) {
							// update data tanpa photo
			 				$koneksi->query("UPDATE pegawai SET 
			 					nopeg='$nopeg',
			 					nama='$nama',
			 					nik='$nik',
			 					gender='$gender',
			 					tmpt_lahir='$tmpt_lahir',
			 					tgl_lahir='$tgl_lahir',
			 					umur='$umur',
			 					jabatan='$jabatan',
			 					unit='$unit',
			 					tmt='$tmt',
			 					skpt='$skpt',
			 					ijazah='$ijazah',
			 					alamat='$alamat',
			 					email='$email',
			 					telpon='$telpon',
			 					status_kawin = '$kawin',
			 					status_pegawai = '$status_pegawai',
			 					username = '$username',
			 					password = '$password'
			 					WHERE id='$id' ");

			 				$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
			 				$_SESSION['info'] = 'Berhasil !';
			 				$_SESSION['warna'] = 'success';
			 				echo "<script>location='../../../data-pegawai';</script>"; 
			 			}
			 			else {
			 				$uniqId = uniqid();
			 				$fotobaru = $uniqId."_".$foto;
			 				move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

			 				$koneksi->query("UPDATE pegawai SET 
			 					nopeg='$nopeg',
			 					nama='$nama',
			 					nik='$nik',
			 					gender='$gender',
			 					tmpt_lahir='$tmpt_lahir',
			 					tgl_lahir='$tgl_lahir',
			 					umur='$umur',
			 					jabatan='$jabatan',
			 					unit='$unit',
			 					tmt='$tmt',
			 					skpt='$skpt',
			 					ijazah='$ijazah',
			 					alamat='$alamat',
			 					email='$email',
			 					telpon='$telpon',
			 					status_kawin = '$kawin',
			 					status_pegawai = '$status_pegawai',
			 					username = '$username',
			 					password = '$password',
			 					foto='$fotobaru'
			 					WHERE id='$id' ");

			 				$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
			 				$_SESSION['info'] = 'Berhasil !';
			 				$_SESSION['warna'] = 'success';
			 				echo "<script>location='../../../data-pegawai';</script>"; 
			 			}
			 		}
			 	}
			 	else {
			 		if (empty($lokasi)) {
							// update data tanpa photo
			 			$koneksi->query("UPDATE pegawai SET 
			 				nopeg='$nopeg',
			 				nama='$nama',
			 				nik='$nik',
			 				gender='$gender',
			 				tmpt_lahir='$tmpt_lahir',
			 				tgl_lahir='$tgl_lahir',
			 				umur='$umur',
			 				jabatan='$jabatan',
			 				unit='$unit',
			 				tmt='$tmt',
			 				skpt='$skpt',
			 				ijazah='$ijazah',
			 				alamat='$alamat',
			 				email='$email',
			 				telpon='$telpon',
			 				status_kawin = '$kawin',
			 				status_pegawai = '$status_pegawai',
			 				username = '$username',
			 				password = '$password'
			 				WHERE id='$id' ");

			 			$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
			 			$_SESSION['info'] = 'Berhasil !';
			 			$_SESSION['warna'] = 'success';
			 			echo "<script>location='../../../data-pegawai';</script>"; 
			 		}
			 		else {
			 			$uniqId = uniqid();
			 			$fotobaru = $uniqId."_".$foto;
			 			move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

			 			$koneksi->query("UPDATE pegawai SET 
			 				nopeg='$nopeg',
			 				nama='$nama',
			 				nik='$nik',
			 				gender='$gender',
			 				tmpt_lahir='$tmpt_lahir',
			 				tgl_lahir='$tgl_lahir',
			 				umur='$umur',
			 				jabatan='$jabatan',
			 				unit='$unit',
			 				tmt='$tmt',
			 				skpt='$skpt',
			 				ijazah='$ijazah',
			 				alamat='$alamat',
			 				email='$email',
			 				telpon='$telpon',
			 				status_kawin = '$kawin',
			 				status_pegawai = '$status_pegawai',
			 				username = '$username',
			 				password = '$password',
			 				foto='$fotobaru'
			 				WHERE id='$id' ");

			 			$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
			 			$_SESSION['info'] = 'Berhasil !';
			 			$_SESSION['warna'] = 'success';
			 			echo "<script>location='../../../data-pegawai';</script>"; 
			 		}
			 	}
			} 
		}
		else {
			// jika nik tidak mengalami perubahan
			// chek email apakah mengalami perubahan apa tidak
			if ($email_lama!=$email) {
				$ambil4 = $koneksi->query("SELECT * FROM pegawai WHERE email='$email'");
				$yangcocok3 = $ambil4->num_rows;
				if ($yangcocok3==1) {
					$_SESSION['pesan'] = 'Data pegawai dengan alamat email  <strong>'.$email.'</strong> telah terdaftar di database, Silahkan periksa kembali';
					$_SESSION['info'] = 'peringatan !';
					$_SESSION['warna'] = 'danger';
					echo "<script>window.location=history.go(-1);</script>";
				}
				else {
			    // jika email yang baru tidak terdafatar maka,
			 	// update data
			 	// chek apakah ada inputan foto apa tidak
					if (empty($lokasi)) {
							// update data tanpa photo
						$koneksi->query("UPDATE pegawai SET 
							nopeg='$nopeg',
							nama='$nama',
							nik='$nik',
							gender='$gender',
							tmpt_lahir='$tmpt_lahir',
							tgl_lahir='$tgl_lahir',
							umur='$umur',
							jabatan='$jabatan',
							unit='$unit',
							tmt='$tmt',
							skpt='$skpt',
							ijazah='$ijazah',
							alamat='$alamat',
							email='$email',
							telpon='$telpon',
							status_kawin = '$kawin',
							status_pegawai = '$status_pegawai',
							username = '$username',
							password = '$password'
							WHERE id='$id' ");

						$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
						$_SESSION['info'] = 'Berhasil !';
						$_SESSION['warna'] = 'success';
						echo "<script>location='../../../data-pegawai';</script>"; 
					}
					else {
						$uniqId = uniqid();
						$fotobaru = $uniqId."_".$foto;
						move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

						$koneksi->query("UPDATE pegawai SET 
							nopeg='$nopeg',
							nama='$nama',
							nik='$nik',
							gender='$gender',
							tmpt_lahir='$tmpt_lahir',
							tgl_lahir='$tgl_lahir',
							umur='$umur',
							jabatan='$jabatan',
							unit='$unit',
							tmt='$tmt',
							skpt='$skpt',
							ijazah='$ijazah',
							alamat='$alamat',
							email='$email',
							telpon='$telpon',
							status_kawin = '$kawin',
							status_pegawai = '$status_pegawai',
							username = '$username',
							password = '$password',
							foto='$fotobaru'
							WHERE id='$id' ");

						$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
						$_SESSION['info'] = 'Berhasil !';
						$_SESSION['warna'] = 'success';
						echo "<script>location='../../../data-pegawai';</script>"; 
					}
				}
			}
			else {
				if (empty($lokasi)) {
							// update data tanpa photo
					$koneksi->query("UPDATE pegawai SET 
						nopeg='$nopeg',
						nama='$nama',
						nik='$nik',
						gender='$gender',
						tmpt_lahir='$tmpt_lahir',
						tgl_lahir='$tgl_lahir',
						umur='$umur',
						jabatan='$jabatan',
						unit='$unit',
						tmt='$tmt',
						skpt='$skpt',
						ijazah='$ijazah',
						alamat='$alamat',
						email='$email',
						telpon='$telpon',
						status_kawin = '$kawin',
						status_pegawai = '$status_pegawai',
						username = '$username',
						password = '$password'
						WHERE id='$id' ");

					$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
					$_SESSION['info'] = 'Berhasil !';
					$_SESSION['warna'] = 'success';
					echo "<script>location='../../../data-pegawai';</script>"; 
				}
				else {
					$uniqId = uniqid();
					$fotobaru = $uniqId."_".$foto;
					move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

					$koneksi->query("UPDATE pegawai SET 
						nopeg='$nopeg',
						nama='$nama',
						nik='$nik',
						gender='$gender',
						tmpt_lahir='$tmpt_lahir',
						tgl_lahir='$tgl_lahir',
						umur='$umur',
						jabatan='$jabatan',
						unit='$unit',
						tmt='$tmt',
						skpt='$skpt',
						ijazah='$ijazah',
						alamat='$alamat',
						email='$email',
						telpon='$telpon',
						status_kawin = '$kawin',
						status_pegawai = '$status_pegawai',
						username = '$username',
						password = '$password'
						foto='$fotobaru'
						WHERE id='$id' ");

					$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
					$_SESSION['info'] = 'Berhasil !';
					$_SESSION['warna'] = 'success';
					echo "<script>location='../../../data-pegawai';</script>"; 
				}
			}
		}
	}
}
// parameter 2
else if ($nik!=$nik_lama) {
	// jika nik mengalami perubahan input
	// chek apakah nik baru sudah terdafatar apa belum
	$ambil3 = $koneksi->query("SELECT * FROM pegawai WHERE nik='$nik'");
	$yangcocok2 = $ambil3->num_rows;
	if ($yangcocok2==1) {
		$_SESSION['pesan'] = 'Data pegawai dengan NIK  <strong>'.$nik.'</strong> telah terdaftar di database, Silahkan periksa kembali';
		$_SESSION['info'] = 'peringatan !';
		$_SESSION['warna'] = 'danger';
		echo "<script>window.location=history.go(-1);</script>";
	}
	else {
		// jika tidak nik tidak mengalami perubahan
		// chek apakah email mengalami perubahan apa tidak
		if ($email_lama!=$email) {
			// jika mengalami perubahan, chek apakah email baru sudah terdafatar apa belum
			$ambil4 = $koneksi->query("SELECT * FROM pegawai WHERE email='$email'");
			$yangcocok3 = $ambil4->num_rows;
			if ($yangcocok3==1) {
				$_SESSION['pesan'] = 'Data pegawai dengan alamat email  <strong>'.$email.'</strong> telah terdaftar di database, Silahkan periksa kembali';
				$_SESSION['info'] = 'peringatan !';
				$_SESSION['warna'] = 'danger';
				echo "<script>window.location=history.go(-1);</script>";
			}
			else {
				// apabila email baaru terdafatar
				// chek apakah ada inputan foto
				if (empty($lokasi)) {
					// update data tanpa photo
					$koneksi->query("UPDATE pegawai SET 
						nopeg='$nopeg',
						nama='$nama',
						nik='$nik',
						gender='$gender',
						tmpt_lahir='$tmpt_lahir',
						tgl_lahir='$tgl_lahir',
						umur='$umur',
						jabatan='$jabatan',
						unit='$unit',
						tmt='$tmt',
						skpt='$skpt',
						ijazah='$ijazah',
						alamat='$alamat',
						email='$email',
						telpon='$telpon',
						status_kawin = '$kawin',
						status_pegawai = '$status_pegawai',
						username = '$username',
						password = '$password'
						WHERE id='$id' ");

					$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
					$_SESSION['info'] = 'Berhasil !';
					$_SESSION['warna'] = 'success';
					echo "<script>location='../../../data-pegawai';</script>"; 
				}
				else {
					$uniqId = uniqid();
					$fotobaru = $uniqId."_".$foto;
					move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

					$koneksi->query("UPDATE pegawai SET 
						nopeg='$nopeg',
						nama='$nama',
						nik='$nik',
						gender='$gender',
						tmpt_lahir='$tmpt_lahir',
						tgl_lahir='$tgl_lahir',
						umur='$umur',
						jabatan='$jabatan',
						unit='$unit',
						tmt='$tmt',
						skpt='$skpt',
						ijazah='$ijazah',
						alamat='$alamat',
						email='$email',
						telpon='$telpon',
						status_kawin = '$kawin',
						status_pegawai = '$status_pegawai',
						username = '$username',
						password = '$password',
						foto='$fotobaru'
						WHERE id='$id' ");

					$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
					$_SESSION['info'] = 'Berhasil !';
					$_SESSION['warna'] = 'success';
					echo "<script>location='../../../data-pegawai';</script>"; 
				}
			}
		}
		else {
			// jika tidak mengalami perubahan email
			if (empty($lokasi)) {
				// update data tanpa photo
				$koneksi->query("UPDATE pegawai SET 
					nopeg='$nopeg',
					nama='$nama',
					nik='$nik',
					gender='$gender',
					tmpt_lahir='$tmpt_lahir',
					tgl_lahir='$tgl_lahir',
					umur='$umur',
					jabatan='$jabatan',
					unit='$unit',
					tmt='$tmt',
					skpt='$skpt',
					ijazah='$ijazah',
					alamat='$alamat',
					email='$email',
					telpon='$telpon',
					status_kawin = '$kawin',
					status_pegawai = '$status_pegawai',
					username = '$username',
					password = '$password'
					WHERE id='$id' ");

				$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
				$_SESSION['info'] = 'Berhasil !';
				$_SESSION['warna'] = 'success';
				echo "<script>location='../../../data-pegawai';</script>"; 
			}
			else {
				$uniqId = uniqid();
				$fotobaru = $uniqId."_".$foto;
				move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

				$koneksi->query("UPDATE pegawai SET 
					nopeg='$nopeg',
					nama='$nama',
					nik='$nik',
					gender='$gender',
					tmpt_lahir='$tmpt_lahir',
					tgl_lahir='$tgl_lahir',
					umur='$umur',
					jabatan='$jabatan',
					unit='$unit',
					tmt='$tmt',
					skpt='$skpt',
					ijazah='$ijazah',
					alamat='$alamat',
					email='$email',
					telpon='$telpon',
					status_kawin = '$kawin',
					status_pegawai = '$status_pegawai',
					username = '$username',
					password = '$password'
					foto='$fotobaru'
					WHERE id='$id' ");

				$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
				$_SESSION['info'] = 'Berhasil !';
				$_SESSION['warna'] = 'success';
				echo "<script>location='../../../data-pegawai';</script>"; 
			}
		}
	}

}
else if ($email_lama!=$email) {
	// jika email mengalamai perubahan dari data lama
	// chek apakah email baru sudah terdaftar apa belum
	$ambil4 = $koneksi->query("SELECT * FROM pegawai WHERE email='$email'");
	$yangcocok3 = $ambil4->num_rows;
	if ($yangcocok3==1) {
		$_SESSION['pesan'] = 'Data pegawai dengan alamat email  <strong>'.$email.'</strong> telah terdaftar di database, Silahkan periksa kembali';
		$_SESSION['info'] = 'peringatan !';
		$_SESSION['warna'] = 'danger';
		echo "<script>window.location=history.go(-1);</script>";
	}
	else {
		if (empty($lokasi)) {
				// update data tanpa photo
			$koneksi->query("UPDATE pegawai SET 
				nopeg='$nopeg',
				nama='$nama',
				nik='$nik',
				gender='$gender',
				tmpt_lahir='$tmpt_lahir',
				tgl_lahir='$tgl_lahir',
				umur='$umur',
				jabatan='$jabatan',
				unit='$unit',
				tmt='$tmt',
				skpt='$skpt',
				ijazah='$ijazah',
				alamat='$alamat',
				email='$email',
				telpon='$telpon',
				status_kawin = '$kawin',
				status_pegawai = '$status_pegawai',
				username = '$username',
				password = '$password'
				WHERE id='$id' ");

			$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
			$_SESSION['info'] = 'Berhasil !';
			$_SESSION['warna'] = 'success';
			echo "<script>location='../../../data-pegawai';</script>"; 
		}
		else {
			$uniqId = uniqid();
			$fotobaru = $uniqId."_".$foto;
			move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

			$koneksi->query("UPDATE pegawai SET 
				nopeg='$nopeg',
				nama='$nama',
				nik='$nik',
				gender='$gender',
				tmpt_lahir='$tmpt_lahir',
				tgl_lahir='$tgl_lahir',
				umur='$umur',
				jabatan='$jabatan',
				unit='$unit',
				tmt='$tmt',
				skpt='$skpt',
				ijazah='$ijazah',
				alamat='$alamat',
				email='$email',
				telpon='$telpon',
				status_kawin = '$kawin',
				status_pegawai = '$status_pegawai',
				username = '$username',
				password = '$password',
				foto='$fotobaru'
				WHERE id='$id' ");

			$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
			$_SESSION['info'] = 'Berhasil !';
			$_SESSION['warna'] = 'success';
			echo "<script>location='../../../data-pegawai';</script>"; 
		}
	}
}
else {
	// kondisi nopeg,nik dan email tidak mengalami perubahan dari data lama
	// chek apakah ada inputan foto apa tidak
	if (empty($lokasi)) {
				// update data tanpa photo
		$koneksi->query("UPDATE pegawai SET 
			nopeg='$nopeg',
			nama='$nama',
			nik='$nik',
			gender='$gender',
			tmpt_lahir='$tmpt_lahir',
			tgl_lahir='$tgl_lahir',
			umur='$umur',
			jabatan='$jabatan',
			unit='$unit',
			tmt='$tmt',
			skpt='$skpt',
			ijazah='$ijazah',
			alamat='$alamat',
			email='$email',
			telpon='$telpon',
			status_kawin = '$kawin',
			status_pegawai = '$status_pegawai',
			username = '$username',
			password = '$password'
			WHERE id='$id' ");

		$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
		$_SESSION['info'] = 'Berhasil !';
		$_SESSION['warna'] = 'success';
		echo "<script>location='../../../data-pegawai';</script>"; 
	}
	else {
		$uniqId = uniqid();
		$fotobaru = $uniqId."_".$foto;
		move_uploaded_file($lokasi, "../../../public/img/".$fotobaru);

		$koneksi->query("UPDATE pegawai SET 
			nopeg='$nopeg',
			nama='$nama',
			nik='$nik',
			gender='$gender',
			tmpt_lahir='$tmpt_lahir',
			tgl_lahir='$tgl_lahir',
			umur='$umur',
			jabatan='$jabatan',
			unit='$unit',
			tmt='$tmt',
			skpt='$skpt',
			ijazah='$ijazah',
			alamat='$alamat',
			email='$email',
			telpon='$telpon',
			status_kawin = '$kawin',
			status_pegawai = '$status_pegawai',
			username = '$username',
			password = '$password',
			foto='$fotobaru'
			WHERE id='$id' ");

		$_SESSION['pesan'] = 'Data pegawai <strong>'.$nama.'</strong> Berhasil di perbaharui !';
		$_SESSION['info'] = 'Berhasil !';
		$_SESSION['warna'] = 'success';
		echo "<script>location='../../../data-pegawai';</script>"; 
		
	}
}

?>