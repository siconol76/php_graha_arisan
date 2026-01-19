<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include __DIR__ . "/../config/koneksi.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/laporan.css">
<title>Laporan Arisan</title>

<style>
@media print {
  button, form { display:none; }
}

body {
  font-family: Arial;
  font-size: 12px;
}

.kop {
  text-align: center;
  border-bottom: 3px solid #000;
  margin-bottom: 20px;
}

.kop h2, .kop h3 {
  margin: 0;
}

table {
  border-collapse: collapse;
  margin-top: 10px;
}

th, td {
  padding: 6px;
  border: 1px solid #000;
}

.ttd {
  margin-top: 80px;
  display: flex;
  justify-content: space-around;
  text-align: center;
}
</style>

<script>
<?php if(isset($_GET['tgl_awal'])){ ?>
window.onload = function(){
  window.print();
}
<?php } ?>
</script>

</head>
<body>

<!-- FORM FILTER -->
<form method="get">
  Dari Tanggal:
  <input type="date" name="tgl_awal" value="2026-01-01" required>

  Sampai Tanggal:
  <input type="date" name="tgl_akhir" value="2026-12-31" required>

  <button>Lihat Laporan</button>
</form>


<?php
if(isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])){

$tgl_awal  = $_GET['tgl_awal'];
$tgl_akhir = $_GET['tgl_akhir'];
?>

<!-- KOP SURAT -->
<div class="kop">
  <h2>ARISAN SEMETON GRAHA TIRTA</h2>
  <h3>LAPORAN KEUANGAN</h3>
  <p>Periode <?= date('d M Y', strtotime($tgl_awal)) ?> 
     s/d <?= date('d M Y', strtotime($tgl_akhir)) ?></p>
</div>

<table width="100%">
<tr>
  <th>Kode Akun</th>
  <th>Nama Akun</th>
  <th>Total Masuk</th>
  <th>Total Keluar</th>
  <th>Saldo</th>
</tr>

<?php
$q = mysqli_query($conn,"
SELECT 
  a.kode,
  a.nama_akun,
  SUM(t.masuk) AS tm,
  SUM(t.keluar) AS tk,
  (SUM(t.masuk)-SUM(t.keluar)) AS saldo
FROM akun_kas a
LEFT JOIN transaksi t 
  ON a.kode = t.kode_akun
  AND t.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
GROUP BY a.kode
");

$total_saldo = 0;

while($d = mysqli_fetch_assoc($q)){
  $total_saldo += $d['saldo'];
  echo "
  <tr>
    <td>{$d['kode']}</td>
    <td>{$d['nama_akun']}</td>
    <td align='right'>".number_format($d['tm'])."</td>
    <td align='right'>".number_format($d['tk'])."</td>
    <td align='right'>".number_format($d['saldo'])."</td>
  </tr>
  ";
}
?>

<tr>
  <th colspan="4">TOTAL SALDO</th>
  <th align="right"><?= number_format($total_saldo) ?></th>
</tr>
</table>


<!-- TTD -->
<div class="ttd">
  <div>
    <img src="../assets/img/ttd_ketua.png" width="120"><br>
    Ketua
  </div>
  <div>
    <img src="../assets/img/ttd_bendahara.png" width="120"><br>
    Bendahara
  </div>
  <div>
    <img src="../assets/img/ttd_sekretaris.png" width="120"><br>
    Sekretaris
  </div>
</div>

<?php } ?>

<br>
<button onclick="window.print()">CETAK / SAVE PDF</button>

</body>
</html>
