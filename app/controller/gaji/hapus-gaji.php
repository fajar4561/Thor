<?php 
session_start();

require '../../../env/koneksi.php';

$kode = $_GET['kode'];
$nopeg = $_GET['nopeg'];
$tanggal_hari_ini = date("Y-m-d");

$koneksi->query("UPDATE gaji SET tgl_gaji='0',
	upah_awal ='0',
	bpjs_kerja='0',
	bpjs_kes='0',
	pph21='0',
	ppni='0',
	lain='0',
	tj_jbtn='0',
	tj_fungsional='0',
	fee_for_servis='0',
	tj_tpbri ='0',
	lembur='0',
	penyesuaian='0',
	tj_lain='0',
	total_pendapatan='0',
	status='0'
	WHERE kode_transaksi='$kode' AND nopeg='$nopeg'");


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


$_SESSION['pesan'] = 'Data Transaksi Gaji Berhasil di Hapus !';
$_SESSION['info'] = 'Berhasil !';
$_SESSION['warna'] = 'success';


echo "<script>location='../../../detail-transaksi-gaji/$kode';</script>";

?>