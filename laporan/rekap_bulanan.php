<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include __DIR__ . "/../config/koneksi.php"; ?>
<link rel="stylesheet" href="../assets/css/laporan.css">

<form method="get">
  <input type="number" name="bulan" placeholder="Bulan (1-12)" required>
  <input type="number" name="tahun" placeholder="Tahun" required>
  <button>Lihat</button>
</form>

<?php
// CEK DULU: apakah form sudah dikirim?
if (isset($_GET['bulan']) && isset($_GET['tahun'])) {

  $bulan = $_GET['bulan'];
  $tahun = $_GET['tahun'];

  $q = mysqli_query($conn,"
    SELECT kode_akun,
    SUM(masuk) AS tm,
    SUM(keluar) AS tk,
    (SUM(masuk)-SUM(keluar)) AS saldo
    FROM transaksi
    WHERE MONTH(tanggal)='$bulan'
    AND YEAR(tanggal)='$tahun'
    GROUP BY kode_akun
  ");

  echo "<hr>";
  while($d = mysqli_fetch_assoc($q)){
    echo "
    Akun: {$d['kode_akun']} <br>
    Masuk: {$d['tm']} <br>
    Keluar: {$d['tk']} <br>
    Saldo: {$d['saldo']} <br><br>
    ";
  }

  echo "<a href='laporan_pdf.php?b=$bulan&t=$tahun'>Cetak PDF</a>";
}
?>

<?php include "../layout/footer.php"; ?>
