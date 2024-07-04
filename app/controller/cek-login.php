<?php 
require '../../env/koneksi.php';

session_start(); // Memulai sesi jika belum dimulai

// Pastikan koneksi ke database berhasil
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data dari form (dan lakukan sanitasi jika diperlukan)
$username = $_POST['username'];
$password = md5($_POST['password']); // Pastikan ini sesuai dengan metode hash yang digunakan saat menyimpan kata sandi

// Siapkan pernyataan yang disiapkan
$stmt = $koneksi->prepare("SELECT * FROM pegawai WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password); // 'ss' berarti kedua parameter adalah string

// Jalankan pernyataan yang disiapkan
$stmt->execute();

// Dapatkan hasil
$result = $stmt->get_result();

// Periksa apakah ada pengguna yang cocok
if ($result->num_rows == 1) {
    // Simpan informasi pengguna ke sesi
    $_SESSION['username'] = $username; // Gunakan 'nopeg' jika 'username' tidak ada di database
    header("Location: ../../beranda");
    exit(); // Hentikan eksekusi skrip lebih lanjut
} else {
    echo "<script>alert('Username/password tidak terdaftar');</script>";
    echo "<script>location='../../login';</script>";
    exit(); // Hentikan eksekusi skrip lebih lanjut
}

// Tutup pernyataan
$stmt->close();

// Tutup koneksi
$koneksi->close();




?>