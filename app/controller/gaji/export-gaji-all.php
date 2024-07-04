<?php 
session_start();
require '../../../env/koneksi.php';

$bulan2= $_GET['bulan'];
$tahun = $_GET['tahun'];

$sql = "SELECT pegawai.nopeg, nama, jabatan, unit, bulan, tahun FROM gaji 
        INNER JOIN pegawai ON gaji.nopeg=pegawai.nopeg 
        WHERE status_pegawai != 'RESIGN' AND bulan = '$bulan2' AND tahun = '$tahun' AND status = '0' 
        ORDER BY unit ASC, nama ASC";
$result = $koneksi->query($sql);

// Nama file CSV
$nama_file = '../../../public/file/gaji/Penggajian-Bulan-' . $bulan2 . '-' . $tahun . '.csv';
$header = array("No", "NIP", "Nama", "Jabatan", "Unit", "Periode Bulan", "Periode Tahun", "Upah", "TJ.JABATAN", "TJ.FUNGSIONAL", "TJ.RESIKO", "TJ.TPBR/KHUSUS", "FEE FOR SERVICE", "LEMBUR", "THR/THN", "LAIN-LAIN", "GAJI BRUTO", "BPJS TK", "BPJS KES", "PPH21", "PPNI","LAIN-LAIN", "TOTAL POTONGAN","GAJI NETTO", "OBAT","SERAGAM KARYAWAN", "KREDIT BTN", "LAIN-LAIN / BY PELATIHAN", "TOTAL POT", "TRANSFER");

// Buka file untuk ditulis
$file = fopen($nama_file, 'w');

// Tulis header ke file CSV
fputcsv($file, $header);
$nomor_baris = 1;

// Loop untuk menulis data
while ($row = $result->fetch_assoc()) {
    // Menambahkan nomor baris ke data
    $row_with_number = array_merge(array(sprintf('%d', $nomor_baris)), $row);

    $row_with_number['nopeg'] = "'" . $row_with_number['nopeg'];
    // Tulis baris data ke file CSV
    fputcsv($file, $row_with_number);

    // Increment nomor baris
    $nomor_baris++;
}

// Tutup file
fclose($file);

// Redirect atau download file
header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . basename($nama_file) . '";');
readfile($nama_file);
exit;


?>