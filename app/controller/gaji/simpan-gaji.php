<?php 
session_start();

require '../../../env/koneksi.php';


$tanggal_hari_ini = date("Y-m-d");
$bulan = $_SESSION['bulan'];
$tahun = $_SESSION['tahun'];

$length = count($_POST['nopeg']);


// Loop melalui setiap data
for ($i = 0; $i < $length; $i++) {
    // Mengambil nilai untuk setiap kunci
    $nopeg 									= $_POST['nopeg'][$i];
    $upah_awal 								= (int) preg_replace("/[^0-9]/", "", $_POST['upah_awal'][$i]);
    /*
    $penambahan_seharusnya 					= (int) preg_replace("/[^0-9]/", "", $_POST['penambahan_seharusnya'][$i]);
    $upah_seharusnya 						= (int) preg_replace("/[^0-9]/", "", $_POST['upah_seharusnya'][$i]);
    $penambahan_bulan_sebelumnya 			= (int) preg_replace("/[^0-9]/", "", $_POST['penambahan_bulan_sebelumnya'][$i]);
    $kelebihan_kekurangan 					= (int) preg_replace("/[^0-9]/", "", $_POST['kelebihan_kekurangan'][$i]);
    $upah_revisi 							= (int) preg_replace("/[^0-9]/", "", $_POST['upah_revisi'][$i]);
    */
    //potongan
    $bpjs_tenaga 							= (int) preg_replace("/[^0-9]/", "", $_POST['bpjs_tenaga'][$i]);
    $bpjs_kesehatan 						= (int) preg_replace("/[^0-9]/", "", $_POST['bpjs_kesehatan'][$i]);
    $pph21 									= (int) preg_replace("/[^0-9]/", "", $_POST['pph21'][$i]);
    $ppni 									= (int) preg_replace("/[^0-9]/", "", $_POST['ppni'][$i]);
    $lain 									= (int) preg_replace("/[^0-9]/", "", $_POST['lain'][$i]);
    // tunjangan
    $tj_jabatan 							= (int) preg_replace("/[^0-9]/", "", $_POST['tj_jabatan'][$i]);
    $tj_fungsional 							= (int) preg_replace("/[^0-9]/", "", $_POST['tj_fungsional'][$i]);
    $tj_tpbri 								= (int) preg_replace("/[^0-9]/", "", $_POST['tj_tpbri'][$i]);
    $fee_for_service 						= (int) preg_replace("/[^0-9]/", "", $_POST['fee_for_service'][$i]);
    $lembur									= (int) preg_replace("/[^0-9]/", "", $_POST['lembur'][$i]);
    // $thr 									= (int) preg_replace("/[^0-9]/", "", $_POST['thr'][$i]);
    $penyesuaian                  = (int) preg_replace("/[^0-9]/", "", $_POST['penyesuaian'][$i]);
    $tj_lain 								= (int) preg_replace("/[^0-9]/", "", $_POST['tj_lain'][$i]);

    // perhitungan
    // pendapatan
    $pendapatan = $upah_awal+$tj_jabatan+$tj_fungsional+$tj_tpbri+$fee_for_service+$lembur+$penyesuaian+$tj_lain;
      // potongan
      $potongan = $bpjs_tenaga+$bpjs_kesehatan+$pph21+$ppni+$lain;
      // tunjangan

      // total pendapatan
      $total_pendapatan = $pendapatan-$potongan;

    

    if ($total_pendapatan > 0 )
    {
    	// sinpan data
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
    		status='1' WHERE nopeg='$nopeg' AND bulan ='$bulan' AND tahun='$tahun'");
    }
}

// ambil data transaksi yang status 1
$ambil = $koneksi->query("SELECT * FROM gaji WHERE bulan='$bulan' AND tahun='$tahun' AND status='1'");
$jml_keinput = mysqli_num_rows($ambil);
while ($dta_gaji=mysqli_fetch_array($ambil))
{
  $array_total_gaji[] = $dta_gaji['total_pendapatan'];
}
$total_pendapatan = array_sum($array_total_gaji);

// update master transaksi gaji
$koneksi_master = $koneksi->query("SELECT * FROM transaksi_gaji WHERE periode_bulan='$bulan' AND periode_tahun='$tahun'");
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



// alihkan halaman
$_SESSION['pesan'] = 'Data Transaksi Gaji Periode '.$bulan.' Tahun '.$tahun.' Berhasil di Simpan !';
$_SESSION['info'] = 'Berhasil !';
$_SESSION['warna'] = 'success';

unset($_SESSION['tahun']);
unset($_SESSION['bulan']);

echo "<script>location='../../../data-gaji';</script>";


?>