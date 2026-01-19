<?php
session_start(); // ✨ WAJIB DI SINI
include "../config/koneksi.php";

$user = $_POST['username'] ?? '';
$pass = md5($_POST['password'] ?? '');

$q = mysqli_query($conn, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
$d = mysqli_fetch_assoc($q);

if ($d) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $d['role'];
    $_SESSION['id']    = $d['id'];
    $_SESSION['nama']  = $d['nama']; 
    header("location:../dashboard/index.php");
    exit;
} else {
    echo "<script>alert('Login gagal!');window.location='login.php';</script>";
}
