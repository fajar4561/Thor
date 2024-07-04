<?php 
session_start();
require '../../../env/koneksi.php';

// File CSV yang diunggah
$tanggal_hari_ini = date("Y-m-d");
$file = $_FILES['input-file']['tmp_name'];

$file_info = pathinfo($_FILES['input-file']['name']);
$file_ext = strtolower($file_info['extension']);

// Buka file CSV untuk dibaca
$handle = fopen($file, "r");

fgetcsv($handle, 1000, ",");

// Buang baris pertama (judul kolom)
//fgetcsv($handle, 1000, ",");
if ($file_ext !='csv') {
	$_SESSION['pesan'] = 'File Harus berformatkan ".csv" silahkan periksa kembali';
	$_SESSION['info'] = 'Gagal Import File !';
	$_SESSION['warna'] = 'danger';
	echo "<script>window.location=history.go(-1);</script>";
}
else {
	// Loop untuk membaca setiap baris data dari file CSV
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

		// deklarasi variabel

		$nopeg = str_replace("'", "", $data[1]);
		$bulan = $data[5];
		$tahun = $data[6];
		$upah_awal = floatval($data[7]);

		$tj_jabatan = floatval($data[8]);
		$tj_fungsional = floatval($data[9]);
		$tj_resiko = floatval($data[10]);
		$tj_tpbri = floatval($data[11]);
		$fee_for_service = floatval($data[12]);
		$lembur = floatval($data[13]);
		$thr = floatval($data[14]);
		$tj_lain = floatval($data[15]);

		//$gaji_bruto = floatval($data[16]); // gaji kotor
		$gaji_bruto = $upah_awal + $tj_jabatan + $tj_fungsional + $tj_resiko + $tj_tpbri + $fee_for_service + $lembur + $thr + $tj_lain;

		$bpjs_tenaga = floatval($data[17]);
		$bpjs_kesehatan = floatval($data[18]);

		$pph21 = floatval($data[19]);
		$ppni = floatval($data[20]);
		$lain = floatval($data[21]);

		//$total_potongan = floatval($data[22]);
		$total_potongan = $bpjs_tenaga + $bpjs_kesehatan+$pph21+$ppni+$lain;

		
		//$gaji_netto = floatval($data[23]); // dari hasil bruto di kurangi dari potongan pokok diluar slip
		$gaji_netto = $gaji_bruto-$total_potongan;


		$obat = floatval($data[24]);
		$seragam = floatval($data[25]);
		$kredit = floatval($data[26]);
		$pelatihan = floatval($data[27]);

		//$total_potongan_slip = floatval($data[28]);
		$total_potongan_slip = $obat + $seragam + $kredit+$pelatihan;

		//$transfer = floatval($data[29]);
		$transfer = $gaji_netto-$total_potongan_slip;

		$ambil_data_gaji = $koneksi->query("SELECT * FROM gaji WHERE bulan='$bulan' AND tahun='$tahun'");
		$ada_data = $ambil_data_gaji->num_rows;

		if ($ada_data>=1) {

			if ($gaji_netto > 0) {
				$update = $koneksi->query("UPDATE gaji SET
					tgl_gaji='$tanggal_hari_ini', 
					upah_awal ='$upah_awal',
					bpjs_kerja='$bpjs_tenaga',
					bpjs_kes='$bpjs_kesehatan',
					pph21='$pph21',
					ppni='$ppni',
					lain='$lain',
					tj_jbtn='$tj_jabatan',
					tj_fungsional='$tj_fungsional',
					tj_resiko='$tj_resiko',
					fee_for_servis='$fee_for_service',
					tj_tpbri =$tj_tpbri,
					lembur='$lembur',
					thr='$thr',
					tj_lain='$tj_lain',
					bruto='$gaji_bruto',
					total_potongan ='$total_potongan',
					total_pendapatan = '$gaji_netto',
					obat = '$obat',
					seragam ='$seragam',
					kredit = '$kredit',
					pelatihan = '$pelatihan',
					total_potongan_slip = '$total_potongan_slip',
					transfer ='$transfer',
					status='1' WHERE nopeg='$nopeg' AND bulan ='$bulan' AND tahun='$tahun' ");
			}

		}
		$bulan2 = $_SESSION['bulan2']=$bulan;
		$tahun2 = $_SESSION['tahun2']=$tahun;
		
		$ambil_gaji_bulan = $koneksi->query("SELECT * FROM transaksi_gaji WHERE periode_bulan='$bulan2' AND periode_tahun='$tahun2'");
		$gaji_bulan_cocok = $ambil_gaji_bulan->num_rows;

		if ($gaji_bulan_cocok==1) {
			$ambil = $koneksi->query("SELECT * FROM gaji WHERE bulan='$bulan2' AND tahun='$tahun2' AND status='1'");
			$jml_keinput = mysqli_num_rows($ambil);
			while ($dta_gaji=mysqli_fetch_array($ambil))
			{
				$array_total_gaji[] = $dta_gaji['total_pendapatan'];
			}
			$total_pendapatan = array_sum($array_total_gaji);

	// update master transaksi gaji
			$koneksi_master = $koneksi->query("SELECT * FROM transaksi_gaji WHERE periode_bulan='$bulan2' AND periode_tahun='$tahun2'");
			$data = $koneksi_master->fetch_assoc();

			$jml_karyawan= $data['jumlah_karyawan'];
			$kode_transaksi= $data['kode_transaksi'];
			$status_gaji ='selesai';


			if ($jml_karyawan==$jml_keinput) {
	// update data transaksi gaji
				$koneksi->query("UPDATE transaksi_gaji SET tgl_transaksi='$tanggal_hari_ini',
					proses='$jml_keinput',
					total_gaji='$total_pendapatan',
					status_transaksi='$status_gaji' WHERE kode_transaksi='$kode_transaksi'");
			}
			else {
				$koneksi->query("UPDATE transaksi_gaji SET tgl_transaksi='$tanggal_hari_ini',
					proses='$jml_keinput',
					total_gaji='$total_pendapatan' WHERE kode_transaksi='$kode_transaksi'");
			}

			$_SESSION['pesan'] = 'Data Transaksi Gaji Periode '.$bulan.' Tahun '.$tahun.' Berhasil di Simpan !';
			$_SESSION['info'] = 'Berhasil !';
			$_SESSION['warna'] = 'success';

			unset($_SESSION['bulan2']);
			unset($_SESSION['tahun2']);

			echo "<script>location='../../../data-gaji';</script>";
		}	
	}


}

?>