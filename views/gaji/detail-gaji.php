<?php 
if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
    echo '<div class="row mb-3"><div class="p-2"><div id="pesan" class="alert alert-'.$_SESSION['warna'].' alert-dismissible fade show border-0 b-round" role="alert"><strong>'.$_SESSION['info'].'</strong> '.$_SESSION['pesan'].'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div></div></div>';
}
$_SESSION['pesan'] = '';

require 'env/koneksi.php';
require 'env/tgl_indo.php';
require 'env/terbilang.php';

$kode = $_GET['kode'];
$nopeg = $_GET['nopeg'];

// Ambil data gaji berdasarkan kode transaksi dan nopeg
$pecah = $koneksi->query("SELECT * FROM gaji WHERE kode_transaksi='$kode' AND nopeg='$nopeg'")->fetch_assoc();

// Ambil data pegawai berdasarkan nopeg
$data = $koneksi->query("SELECT * FROM pegawai WHERE nopeg='$nopeg'")->fetch_assoc();

?>

<style>
    /* Gaya untuk margin di tengah */
    .centered {
        margin: 0 auto;
        display: block;
        text-align: center; /* Untuk mengatur posisi konten ke tengah */
    }

    /* Gaya untuk membuat gambar responsif */
    .img-responsive {
        max-width: 100%;
        height: auto;
    }

    /* Media query untuk layar yang lebih kecil */
    @media (max-width: 768px) {
        .img-responsive {
            max-width: 90%; /* Misalnya, ukuran gambar maksimum 80% dari lebar layar saat layar diresize */
        }
    }

    @media print {
        @page {
            size: A5; /* Atur ukuran kertas menjadi A5 saat mencetak */
        }
    }
</style>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-body"> 
                <div class="row justify-content-center">
                    <div class="p-2 centered">
                        <img src="<?=$link?>/public/img/kop.JPG" alt="logo-small" class="img-responsive" height="120">
                    </div>  
                </div><!--end row-->     
            </div><!--end card-body-->
            <div class="card-body" >
                <div class="row d-flex justify-content-md-between">
                    <div class="col-md-6">
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
                                        require 'env/nama_bulan.php';
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
                                    'tj_resiko' => $pecah['tj_resiko'],
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
                                    'tj_resiko' => 'TJ. Resiko',
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
                </div><!--end row-->
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
                </div><!--end row-->
                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-12 col-xl-4">
                        <div class="float-end d-print-none mt-2 mt-md-0">
                            <a href="../app/print/gaji/pdf.php?kode=<?=$kode?>&nopeg=<?=$nopeg?>" target="_blank" class="btn btn-info btn-sm">Download</a>
                            <?php if ($session_akses==0) { ?>
                                <a href="<?=$link?>beranda" class="btn btn-de-danger btn-sm">Cancel</a>
                            <?php } else { ?>
                                <button onclick="window.history.back()" class="btn btn-de-danger btn-sm">Cancel</button>
                            <?php } ?>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div>
        </div>
    </div>
</div><!--end row-->
<script src="env/js/notif.js"></script>

