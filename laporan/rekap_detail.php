<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include __DIR__ . "/../config/koneksi.php";

$tgl_awal  = $_GET['tgl_awal']  ?? '2026-01-01';
$tgl_akhir = $_GET['tgl_akhir'] ?? '2026-12-31';

// NAMA KETUA & BENDAHARA
$ketua = mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama FROM users WHERE role='ketua'"));
$bendahara = mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama FROM users WHERE role='bendahara'"));
$sekretaris = mysqli_fetch_assoc(mysqli_query($conn,"SELECT nama FROM users WHERE role='sekretaris'"));
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../assets/css/laporan.css">
<title>Laporan Arisan</title>

<style>
@media print { form, button { display:none; } }
body { font-family: Arial; font-size: 12px; }
.kop { text-align:center; border-bottom:3px solid #000; margin-bottom:20px; }
table { border-collapse: collapse; margin-top:10px; }
th, td { border:1px solid #000; padding:5px; }
.akun { margin-top:30px; }
.ttd { margin-top:80px; display:flex; justify-content:space-around; text-align:center; }
</style>

<script>
window.onload = () => window.print();
</script>

</head>
<body>

<form method="get">
  Dari: <input type="date" name="tgl_awal" value="<?= $tgl_awal ?>">
  Sampai: <input type="date" name="tgl_akhir" value="<?= $tgl_akhir ?>">
  <button>Lihat</button>
</form>

<div class="kop">
  <h2>ARISAN SEMETON GRAHA TIRTA</h2>
  <h3>LAPORAN DETAIL</h3>
  <p>Periode <?= date('d M Y',strtotime($tgl_awal)) ?> s/d <?= date('d M Y',strtotime($tgl_akhir)) ?></p>
</div>

<?php
// SALDO AWAL
$saldo_awal = [];
$q_awal = mysqli_query($conn,"
SELECT kode_akun, SUM(masuk - keluar) saldo
FROM transaksi
WHERE tanggal < '$tgl_awal'
GROUP BY kode_akun
");
while($s=mysqli_fetch_assoc($q_awal)){
  $saldo_awal[$s['kode_akun']] = $s['saldo'];
}

// LOOP AKUN
$q_akun = mysqli_query($conn,"SELECT * FROM akun_kas");
while($akun=mysqli_fetch_assoc($q_akun)){

$kode = $akun['kode'];
$awal = $saldo_awal[$kode] ?? 0;
$berjalan = $awal;
?>

<div class="akun">
<b><?= $kode ?> - <?= $akun['nama_akun'] ?></b><br>
Saldo Awal : <?= number_format($awal) ?>

<table width="100%">
<tr>
  <th>Tanggal</th>
  <th>Keterangan</th>
  <th>Masuk</th>
  <th>Keluar</th>
  <th>Saldo</th>
</tr>

<?php
$q_trx = mysqli_query($conn,"
SELECT * FROM transaksi
WHERE kode_akun='$kode'
AND tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'
ORDER BY tanggal
");

while($t=mysqli_fetch_assoc($q_trx)){
  $berjalan += ($t['masuk'] - $t['keluar']);
  echo "
  <tr>
    <td>{$t['tanggal']}</td>
    <td>{$t['keterangan']}</td>
    <td align='right'>".number_format($t['masuk'])."</td>
    <td align='right'>".number_format($t['keluar'])."</td>
    <td align='right'>".number_format($berjalan)."</td>
  </tr>
  ";
}
?>

<tr>
  <th colspan="4">Saldo Akhir</th>
  <th align="right"><?= number_format($berjalan) ?></th>
</tr>
</table>
</div>

<?php } ?>

<div class="ttd">
  <div>
    Ketua<br><img src="../assets/img/ttd_ketua.png" width="120"><br><br>
    <b><?= $ketua['nama'] ?></b>
  </div>
  <div>
    Bendahara<br><img src="../assets/img/ttd_bendahara.png" width="120"><br><br>
    <b><?= $bendahara['nama'] ?></b>
  </div>
  <div>
    Sekretaris<br><img src="../assets/img/ttd_sekretaris.png" width="120"><br><br>
    <b><?= $sekretaris['nama'] ?></b>
  </div>
</div>

</body>
</html>
