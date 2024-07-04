<?php

if (isset($bulan)) {
    if ($bulan >= 1)
    {
      $nama="Januari";
  }
  if ($bulan >= 2) {
  # code...
      $nama = "Februari";
  }
  if ($bulan >= 3 ) {
  # code...
      $nama = "Maret";
  }
  if ($bulan >= 4 ) {
  # code...
      $nama= "April";
  }
  if ($bulan >= 5) {
  # code...
      $nama= "Mei";
  }
  if ($bulan >= 6) {
  # code...
      $nama="Juni";
  }
  if ($bulan >= 7) {
  # code...
      $nama="Juli";
  }
  if ($bulan >= 8) {
  # code...
      $nama="Agustus";
  }
  if ($bulan >= 9) {
  # code...
      $nama="September";
  }
  if ($bulan >= 10) {
  # code...
      $nama="Oktober";
  }
  if ($bulan >= 11) {
  # code...
      $nama="November";
  }
  if ($bulan >= 12) {
  # code...
      $nama="Desember";
  }

}

function bulan_indonesia($bulan) {
    switch($bulan) {
        case 1:
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
        default:
            return "Bulan tidak valid";
    }
}

?>