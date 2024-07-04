<?php 

session_start();
require '../../../env/koneksi.php';

$tanggal_hari_ini = date("Y-m-d");

$kode = $_POST['kode'];
$id = $_POST['id'];
$nopeg 									= $_POST['nopeg'];
$upah_awal 								= (int) preg_replace("/[^0-9]/", "", $_POST['upah_awal']);
    /*
    $penambahan_seharusnya 					= (int) preg_replace("/[^0-9]/", "", $_POST['penambahan_seharusnya']);
    $upah_seharusnya 						= (int) preg_replace("/[^0-9]/", "", $_POST['upah_seharusnya']);
    $penambahan_bulan_sebelumnya 			= (int) preg_replace("/[^0-9]/", "", $_POST['penambahan_bulan_sebelumnya']);
    $kelebihan_kekurangan 					= (int) preg_replace("/[^0-9]/", "", $_POST['kelebihan_kekurangan']);
    $upah_revisi 							= (int) preg_replace("/[^0-9]/", "", $_POST['upah_revisi']);
    */
    //potongan
$bpjs_tenaga 							= (int) preg_replace("/[^0-9]/", "", $_POST['bpjs_tenaga']);
$bpjs_kesehatan 						= (int) preg_replace("/[^0-9]/", "", $_POST['bpjs_kesehatan']);
$pph21 									= (int) preg_replace("/[^0-9]/", "", $_POST['pph21']);
$ppni 									= (int) preg_replace("/[^0-9]/", "", $_POST['ppni']);
$lain 									= (int) preg_replace("/[^0-9]/", "", $_POST['lain']);
// tunjangan
$tj_jabatan 							= (int) preg_replace("/[^0-9]/", "", $_POST['tj_jabatan']);
$tj_fungsional 							= (int) preg_replace("/[^0-9]/", "", $_POST['tj_fungsional']);
$tj_tpbri 								= (int) preg_replace("/[^0-9]/", "", $_POST['tj_tpbri']);
$fee_for_service 						= (int) preg_replace("/[^0-9]/", "", $_POST['fee_for_service']);
$lembur									= (int) preg_replace("/[^0-9]/", "", $_POST['lembur']);
// $thr 									= (int) preg_replace("/[^0-9]/", "", $_POST['thr']);
$penyesuaian                  = (int) preg_replace("/[^0-9]/", "", $_POST['penyesuaian']);
$tj_lain 								= (int) preg_replace("/[^0-9]/", "", $_POST['tj_lain']);

// perhitungan
// pendapatan
$pendapatan = $upah_awal+$tj_jabatan+$tj_fungsional+$tj_tpbri+$fee_for_service+$lembur+$penyesuaian+$tj_lain;
// potongan
$potongan = $bpjs_tenaga+$bpjs_kesehatan+$pph21+$ppni+$lain;
// tunjangan

// total pendapatan
$total_pendapatan = $pendapatan-$potongan;


$koneksi->query("UPDATE gaji SET tgl_gaji='$tanggal_hari_ini', 
	upah_awal ='$upah_awal',
	bpjs_kerja='$bpjs_tenaga',
	bpjs_kes='$bpjs_kesehatan',
	pph21='$pph21',
	ppni='$ppni',
	lain='$lain',
	tj_jbtn='$tj_jabatan',
	tj_fungsional='$tj_fungsional',
	fee_for_servis='$fee_for_service',
	tj_tpbri =$tj_tpbri,
	lembur='$lembur',
	penyesuaian='$penyesuaian',
	tj_lain='$tj_lain',
	total_pendapatan='$total_pendapatan',
	status='1' WHERE id='$id'");

// ambil data transaksi yang status 1
$ambil = $koneksi->query("SELECT * FROM gaji WHERE kode_transaksi='$kode' AND status='1'");
$jml_keinput = mysqli_num_rows($ambil);
while ($dta_gaji=mysqli_fetch_array($ambil))
{
  $array_total_gaji[] = $dta_gaji['total_pendapatan'];
}
$total_pendapatan = array_sum($array_total_gaji);

// update master transaksi gaji
$koneksi_master = $koneksi->query("SELECT * FROM transaksi_gaji WHERE kode_transaksi='$kode'");
$data = $koneksi_master->fetch_assoc();

$jml_karyawan= $data['jumlah_karyawan'];
$kode_transaksi= $data['kode_transaksi'];


if ($jml_karyawan==$jml_keinput) {
	// update data transaksi gaji
	$koneksi->query("UPDATE transaksi_gaji SET tgl_transaksi='$tanggal_hari_ini',
		proses='$jml_keinput',
		total_gaji='$total_pendapatan',
		status_transaksi='selesai' WHERE kode_transaksi='$kode_transaksi'");
}
else {
	$koneksi->query("UPDATE transaksi_gaji SET tgl_transaksi='$tanggal_hari_ini',
		proses='$jml_keinput',
		total_gaji='$total_pendapatan', status_transaksi='belum selesai' WHERE kode_transaksi='$kode_transaksi'");
}

$_SESSION['pesan'] = 'Data Transaksi Gaji Berhasil di Ubah !';
$_SESSION['info'] = 'Berhasil !';
$_SESSION['warna'] = 'success';


echo "<script>location='../../../detail-transaksi-gaji/$kode';</script>";


?>