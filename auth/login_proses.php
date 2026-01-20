<?php
session_start();

include __DIR__ . "/../config/koneksi.php";

// Ambil input
$username = $_POST['username'] ?? '';
$password = md5($_POST['password'] ?? '');

// Query user
$q = mysqli_query($conn, "
  SELECT * FROM users
  WHERE username='$username'
    AND password='$password'
");

if (mysqli_num_rows($q) > 0) {
    // Login sukses → set session
    $d = mysqli_fetch_assoc($q);
    $_SESSION['login'] = true;
    $_SESSION['id']    = $d['id'];
    $_SESSION['nama']  = $d['nama'];
    $_SESSION['role']  = $d['role'];

    // Redirect ke dashboard
    header("Location: ../dashboard/index.php");
    exit;
} else {
    // Login gagal
    echo "<script>
            alert('Login gagal! Username atau password salah.');
            window.location.href='login.php';
          </script>";
}
