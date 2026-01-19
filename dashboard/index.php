<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../masuk.php");
    exit;
}

include __DIR__ . "/../config/koneksi.php";



$saldo = [];

$q = mysqli_query($conn,"
  SELECT a.kode, a.nama_akun,
         IFNULL(SUM(t.masuk),0) - IFNULL(SUM(t.keluar),0) AS saldo
  FROM akun_kas a
  LEFT JOIN transaksi t ON a.kode = t.kode_akun
  GROUP BY a.kode
");

while($d = mysqli_fetch_assoc($q)){
  $saldo[$d['kode']] = $d;
}
?>
<link rel="stylesheet" href="../assets/css/dashboard.css">


<div class="wrapper">

  <div class="sidebar">
    <img src="../assets/css/img/logo.png" width="120">
<ul>
  <li><a href="../master/anggota.php">Data Anggota</a></li>
  <li><a href="../transaksi/input.php">Input Transaksi</a></li>
  <li><a href="../laporan/rekap_bulanan.php">Rekap Bulanan</a></li>
  <li><a href="../laporan/rekap_detail.php">Detail Transaksi</a></li>
  <li><a href="../auth/keluar.php">Logout</a></li>
  <a href="masuk.php" class="btn-enter">Masuk ke Sistem</a>
</ul>
</div>

<div class="content">

    <div class="topbar">
      <div class="title">Dashboard</div>
      <div class="user">
  👤 <?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?> (<?= htmlspecialchars($_SESSION['role'] ?? '') ?>)
</div>
    </div>

    <div class="cards">

  <div class="card">
    <h4><?= $saldo['101']['nama_akun'] ?? 'Kas Arisan' ?></h4>
    <div class="nilai">
      Rp <?= number_format($saldo['101']['saldo'] ?? 0) ?>
    </div>
  </div>

  <div class="card">
    <h4><?= $saldo['102']['nama_akun'] ?? 'Kas Kecil' ?></h4>
    <div class="nilai">
      Rp <?= number_format($saldo['102']['saldo'] ?? 0) ?>
    </div>
  </div>

  <div class="card">
    <h4><?= $saldo['103']['nama_akun'] ?? 'Suka Duka' ?></h4>
    <div class="nilai">
      Rp <?= number_format($saldo['103']['saldo'] ?? 0) ?>
    </div>
  </div>

</div>


  </div>
</div>

<?php include "../layout/footer.php"; ?>
