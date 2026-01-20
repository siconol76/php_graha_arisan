<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: ../masuk.php");
    exit;
}
include __DIR__ . "/../auth/auth_check.php";
include __DIR__ . "/../config/koneksi.php"; ?>
<link rel="stylesheet" href="../assets/css/transaksi.css">

<div class="form-transaksi">
  <h2>Input Transaksi</h2>

  <form method="post">
    <div class="form-group">
      <label>Tanggal</label>
      <input type="date" name="tgl" required>
    </div>

    <div class="form-group">
      <label>Akun</label>
      <select name="akun" required>
        <option value="101">Kas Arisan</option>
        <option value="102">Kas Kecil</option>
        <option value="103">Suka Duka</option>
      </select>
    </div>

    <div class="form-group">
      <label>Keterangan</label>
      <input type="text" name="ket" placeholder="Keterangan transaksi" required>
    </div>

    <div class="form-group">
      <label>Masuk (Rp)</label>
      <input type="number" name="masuk" placeholder="0" min="0">
    </div>

    <div class="form-group">
      <label>Keluar (Rp)</label>
      <input type="number" name="keluar" placeholder="0" min="0">
    </div>

    <button name="simpan">Simpan Transaksi</button>
  </form>
</div>


<?php
if(isset($_POST['simpan'])){
mysqli_query($conn,"INSERT INTO transaksi VALUES
(NULL,'$_POST[tgl]','$_POST[akun]','$_POST[ket]','$_POST[masuk]','$_POST[keluar]')");
echo "Tersimpan";
}
?>

<?php include "../layout/footer.php"; ?>
