<?php 
session_start();
error_reporting(0);
ini_set('display_errors', 0);
$title = str_replace("-", " ", $_GET['halaman']);

if ($_GET['halaman']=='detail-pegawai' OR $_GET['halaman']=='detail-transaksi-gaji' OR $_GET['halaman']=='transaksi-gaji' OR $_GET['halaman']=='detail-gaji' OR $_GET['halaman']=='ubah-gaji' OR isset($_GET['pesan'])) 
{
    $link = "../";
    require 'env/koneksi.php'; 
}
else {
    $link="";
    require $link.'env/koneksi.php'; 
}


if(!isset($_SESSION["username"])) {
    // alihkan ke halaman login
    header("Location: login");
}
else {
    // ambil id user yg login
    $idUser = $_SESSION["username"];
    // ambil data user yg login
    $sqlUser = "SELECT * FROM pegawai WHERE username = '$idUser' ";
    $ambilUser = $koneksi->query($sqlUser);
    $pecahuser = $ambilUser->fetch_assoc();

    $session_akses = $pecahuser['admin'];

}


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    

    <meta charset="utf-8" />
            <title>RSPM - <?=ucwords($title)?></title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
            <meta content="" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />

            <!-- App favicon -->
            <link rel="shortcut icon" href="<?=$link?>public/resources/assets/images/head.ico">

       


     <?php 
        
    ?>
        
     <!-- Tambahan komponen-->
     <link href="<?=$link?>public/resources/assets/libs/simple-datatables/style.css" rel="stylesheet" type="text/css" />
     <link href="<?=$link?>public/resources/assets/libs/mobius1-selectr/selectr.min.css" rel="stylesheet" type="text/css" />
     <link href="<?=$link?>public/resources/assets/libs/huebee/huebee.min.css" rel="stylesheet" type="text/css" />
     <link href="<?=$link?>public/resources/assets/libs/vanillajs-datepicker/css/datepicker.min.css" rel="stylesheet" type="text/css" />
     <!-- App css -->
     <link href="<?=$link?>public/resources/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
     <link href="<?=$link?>public/resources/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
     <link href="<?=$link?>public/resources/assets/css/app.min.css" rel="stylesheet" type="text/css" />
     <script src="<?=$link?>public/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>

     <link href="<?=$link?>public/plugins/datatables/css/dataTables.css" rel="stylesheet" type="text/css" />
     <link href="<?=$link?>public/plugins/datatables/css/fixedColumns.dataTables.css" rel="stylesheet" type="text/css" />

     <link href="<?=$link?>public/plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />
     <script src="<?=$link?>public/plugins/select2/select2.min.js"></script>



</head>