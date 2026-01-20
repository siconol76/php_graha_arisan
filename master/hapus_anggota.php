<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header("Location: ../masuk.php");
    exit;
}
include __DIR__ . "/../auth/auth_check.php";
include __DIR__ . "/../config/koneksi.php";


$id = $_GET['id'] ?? "";

if (!$id) {
    echo "<script>alert('ID anggota tidak ditemukan');location='anggota.php';</script>";
    exit;
}

$d = mysqli_query($conn, "DELETE FROM anggota WHERE id='$id'");

if ($d) {
    echo "<script>alert('Anggota berhasil dihapus');location='anggota.php';</script>";
} else {
    echo "<script>alert('Gagal hapus: ".mysqli_error($conn)."');location='anggota.php';</script>";
}

