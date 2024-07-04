<?php
require '../../../env/koneksi.php'; 
$start = $_POST['start'];
$length = $_POST['length'];
$searchValue = $_POST['search']['value'];

$query = "SELECT * FROM pegawai WHERE nopeg !=123";
if (!empty($searchValue)) {
    $query .= " AND (nama LIKE '%$searchValue%' OR jabatan LIKE '%$searchValue%' OR unit LIKE '%$searchValue%')";
}
$query .= " ORDER BY nama ASC LIMIT $start, $length";

$result = $koneksi->query($query);
$data = array();

while ($row = $result->fetch_assoc()) {
    $rowData = array();
    $rowData[] = $row['nopeg'];
    $rowData[] = ucwords($row['nama']);
    $rowData[] = ucwords($row['jabatan']);
    $rowData[] = $row['unit'];
    $statusBadge = '';
    if ($row['status_pegawai'] == 'TETAP') {
        $statusBadge = '<span class="badge rounded-pill bg-success">Tetap</span>';
    } elseif ($row['status_pegawai'] == 'KONTRAK') {
        $statusBadge = '<span class="badge rounded-pill bg-primary">Kontrak</span>';
    } else {
        $statusBadge = '<span class="badge rounded-pill bg-danger">Resign</span>';
    }
    $rowData[] = $statusBadge;
    $rowData[] = '<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#exampleModalPrimary' . $row['nopeg'] . '">Ubah</a>
                 <a class="dropdown-item" href="app/controller/pegawai/hapus-pegawai.php?n=' . $row['nopeg'] . '" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ' . ucwords($row['nama']) . '?\')">Hapus</a>';
    $data[] = $rowData;
}

$response = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => mysqli_num_rows($koneksi->query("SELECT * FROM pegawai WHERE nopeg !=123")),
    "recordsFiltered" => mysqli_num_rows($result),
    "data" => $data
);

echo json_encode($response);

?>