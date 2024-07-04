<?php 
require '../../../env/koneksi.php';
require '../../../env/tgl_indo.php';
require '../../../env/terbilang.php';
require '../../../env/nama_bulan.php';

$kode = $_GET['kode'];
$nopeg = $_GET['nopeg'];

// Ambil data gaji berdasarkan kode transaksi dan nopeg
$pecah = $koneksi->query("SELECT * FROM gaji WHERE kode_transaksi='$kode' AND nopeg='$nopeg'")->fetch_assoc();

// Ambil data pegawai berdasarkan nopeg
$data = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$nopeg'")->fetch_assoc();

// Hitung total pendapatan dan potongan
$pendapatan = array_sum([
    $pecah['upah_awal'],
    $pecah['revisi'],
    $pecah['tj_jbtn'],
    $pecah['tj_fungsional'],
    $pecah['tj_tpbri'],
    $pecah['fee_for_servis'],
    $pecah['lembur'],
    $pecah['thr'],
    $pecah['tj_lain']
]);

$potongan = array_sum([
    $pecah['bpjs_kerja'],
    $pecah['bpjs_kes'],
    $pecah['pph21'],
    $pecah['ppni'],
    $pecah['lain']
]);

$total_pendapatan = $pendapatan - $potongan;

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
            <title>Gaji <?=bulan_indonesia($pecah['bulan'])?> <?=$pecah['tahun']?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
            <meta content="" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />

            <!-- App favicon -->
            <link rel="shortcut icon" href="../../../public/resources/assets/images/favicon.ico">

	<link href="../../../public/resources/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="../../../public/resources/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
	<link href="../../../public/resources/assets/css/app.min.css" rel="stylesheet" type="text/css" />

<style type="text/css">
	body {
		width: 353mm; /* Lebar kertas B3 */
		height: 500mm; /* Tinggi kertas B3 */
		margin: auto; /* Hilangkan margin */
		padding: 10mm; /* Tambahkan padding untuk memberikan ruang di sekitar konten */
		box-sizing: border-box; /* Termasuk padding dalam perhitungan lebar dan tinggi */
		overflow: hidden; /* Hilangkan scroll */
	}

/* Styling dasar untuk konten */
.content {
	width: 100%;
	height: 100%;
	background-color: #fff; /* Warna latar belakang putih */
	border: 1px solid #000; /* Tambahkan border hitam tipis */
	box-sizing: border-box; /* Termasuk padding dalam perhitungan lebar dan tinggi */
}

/* Menambahkan beberapa styling dasar */
h1 {
	font-size: 24pt;
	text-align: center;
	margin-top: 20mm;
}

p {
	font-size: 12pt;
	margin: 10mm 0;
	text-align: justify;
}

/* Gaya untuk membuat gambar responsif */
    .img-responsive {
        max-width: calc(100% - 2px); /* Maksimum lebar gambar adalah lebar .content dikurangi 2px (untuk border) */
  		max-height: calc(100% - 2px);
        height: auto;
        display: block; /* Atur gambar agar ditampilkan sebagai blok */
  		margin: 0 auto; /* Pusatkan gambar di dalam elemen yang mengandungnya */

    }
    
    @media print {
    .content:last-child {
        page-break-after: avoid; /* Menghindari pemisahan halaman setelah elemen terakhir */
    }
}
</style>

</head>
<body onload="window.print();">
	<div class="container">
		<div class="content">
			<div class="row mt-4">
				<div class="col-lg-10 mx-auto">
					<div class="row justify-content-center">
						<div class="p-2">
							<center><img src="../../../public/img/kop.JPG" alt="logo-small" class="img-responsive"></center>
						</div>  
					</div>
					<div class="row p-3">
						<div class="row d-flex justify-content-md-between">
							<div class="col-md-7">
								<table class="table table-sm table-borderless">
									<tr style="line-height: 1;">
										<th>NO</th>
										<td>:</td>
										<td><?=$pecah['no_gaji']?></td>
									</tr>
									<tr style="line-height: 1;">
										<th>NAMA</th>
										<td>:</td>
										<td class="text-uppercase"><?=$data['nama']?></td>
									</tr>
									<tr style="line-height: 1;">
										<th>JABATAN</th>
										<td>:</td>
										<td class="text-uppercase"><?=$data['jabatan']?></td>
									</tr>
									<tr style="line-height: 1;">
										<th class="text-uppercase">Unit kerja</th>
										<td>:</td>
										<td class="text-uppercase"><?=$data['unit']?></td>
									</tr>
									<tr style="line-height: 1;">
										<th class="text-uppercase">Keterangan</th>
										<td>:</td>
										<td class="text-uppercase">
											<?php 
											$bulan = $pecah['bulan'];
											$terima = $bulan+1;
											?>
											<strong class="text-uppercase">gaji <?=bulan_indonesia($bulan)?> diterimakan <?=bulan_indonesia($terima).' '.$pecah['tahun']?> </strong>
										</td>
									</tr>
								</table>
							</div>                       
						</div><!--end row-->

						<div class="row mt-2">
							<div class="col-sm-6">
								<table class="table table-sm table-borderless">
									<tr>
										<th class="text-uppercase" colspan="4">Rincian Pendapatan</th>
									</tr>
									<?php 
									function format_currency($value) {
										return $value != 0 ? 'Rp.' . number_format($value) : '';
									}

									$data = [
										'upah_awal' => $pecah['upah_awal'],
										'tj_jbtn' => $pecah['tj_jbtn'],
										'tj_fungsional' => $pecah['tj_fungsional'],
										'tj_tpbri' => $pecah['tj_tpbri'],
										'fee_for_servis' => $pecah['fee_for_servis'],
										'lembur' => $pecah['lembur'],
										'penyesuaian' => $pecah['penyesuaian'],
										'tj_lain' => $pecah['tj_lain'],
									];

									$labels = [
										'upah_awal' => 'Upah',
										'tj_jbtn' => 'TJ. Jabatan',
										'tj_fungsional' => 'TJ. Fungsional',
										'tj_tpbri' => 'TJ. TPBRI / Khusus',
										'fee_for_servis' => 'Fee For Servis',
										'lembur' => 'Lembur Pelayanan',
										'penyesuaian' => 'Penyesuaian Gaji',
										'tj_lain' => 'Lain-lain',
									];

									$index = 1;
									foreach ($data as $key => $value) {
										echo '<tr>';
										echo '<td>' . $index++ . '.</td>';
										echo '<td>' . $labels[$key] . '</td>';
										echo '<td>:</td>';
										echo '<td>' . format_currency($value) . '</td>';
										echo '</tr>';
									}
									?>

								</table>                                          
							</div>  <!--end col-->
							<div class="col-sm-6">
								<table class="table table-sm table-borderless">
									<tr>
										<th class="text-uppercase" colspan="4">Potongan</th>
									</tr>
									<?php
									$index2 = 1; 
									$data_potongan = [
										'bpjs_kerja' => $pecah['bpjs_kerja'],
										'bpjs_kes' => $pecah['bpjs_kes'],
										'pph21' => $pecah['pph21'],
										'ppni' => $pecah['ppni'],
										'lain' => $pecah['lain'],
									];

									$label_potongan = [
										'bpjs_kerja' =>'BPJS Tenaga Kerja',
										'bpjs_kes' => 'BPJS Kesehatan',
										'pph21' => 'PPH21',
										'ppni' => 'PPNI',
										'lain' => 'Lain-lain',
									];

									foreach ($data_potongan as $keys => $values) {
										echo '<tr>';
										echo '<td>' . $index2++ . '.</td>';
										echo '<td>' . $label_potongan[$keys] . '</td>';
										echo '<td>:</td>';
										echo '<td>' . format_currency($values) . '</td>';
										echo '</tr>';
									}

									?>

								</table>                                          
							</div>                                      
						</div>
						<div class="row">
							<div class="col-sm-6">
								<table class="table table-sm table-borderless">
									<tr>
										<th class="text-uppercase" colspan="4">pendapatan</th>
									</tr>
									<tr>
										<td><strong>1.</strong></td>
										<td><strong>Total Pendapatan</strong></td>
										<td>:</td>
										<td><strong>Rp.<?=number_format($pecah['bruto'])?></strong></td>
									</tr>
									<tr>
										<td><strong>2.</strong></td>
										<td><strong>Total Potongan</strong></td>
										<td>:</td>
										<td><strong>Rp.<?=number_format($pecah['total_potongan'])?></strong></td>
									</tr>
									<tr>
										<td><strong>3.</strong></td>
										<td><strong>Pendapatan Bersih</strong></td>
										<td>:</td>
										<td><strong>Rp.<?=number_format($pecah['total_pendapatan'])?></strong></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="row mt-2">
							<div class="col-lg-6">
								<table class="table table-sm table-borderless">
									<tr style="margin: 0;padding: 0; line-height: 1;">
										<td class="text-uppercase">semarang, <?=tgl_indo($pecah['tgl_gaji'])?></td>
									</tr>
									<tr style="margin: 0;padding: 0; line-height: 1;">
										<td class="text-uppercase">Mengetahui</td>
									</tr>
									<tr style="margin: 0;padding: 0; line-height: 1;">
										<td class="text-uppercase">wadir keuangan rs. permata medika</td>
									</tr>
									<tr style="margin: 0;padding: 0;  line-height: 1;">
										<td><strong>Dr. H. UTOMO.DS., Sp. OG</strong></td>
									</tr>
								</table>
							</div> <!--end col-->                                       
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>