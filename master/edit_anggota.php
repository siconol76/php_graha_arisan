<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header("Location: ../masuk.php");
    exit;
}

include __DIR__ . "/../config/koneksi.php";

$id = $_GET['id'] ?? "";

if (!$id) {
    echo "<script>alert('ID anggota tidak ditemukan');location='anggota.php';</script>";
    exit;
}

// Ambil data anggota
$q = mysqli_query($conn, "SELECT * FROM anggota WHERE id='$id'");
$anggota = mysqli_fetch_assoc($q);

if (!$anggota) {
    echo "<script>alert('Data anggota tidak ditemukan');location='anggota.php';</script>";
    exit;
}
?>

<link rel="stylesheet" href="../assets/css/anggota.css">

<div class="content-box">
<h2>Edit Anggota</h2>

<form method="post">

  <div class="form-group">
    <label>Nama Anggota</label>
    <input type="text" name="nama" value="<?= htmlspecialchars($anggota['nama']) ?>" required>
  </div>

  <div class="form-group">
    <label>Status</label>
    <select name="status">
      <option value="aktif" <?= $anggota['status']=='aktif' ? 'selected' : '' ?>>Aktif</option>
      <option value="nonaktif" <?= $anggota['status']=='nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
    </select>
  </div>

  <button class="btn" name="update">Update</button>
  <a class="btn" href="anggota.php">Batal</a>

</form>
</div>

<?php
if (isset($_POST['update'])) {
    $nama   = htmlspecialchars($_POST['nama']);
    $status = $_POST['status'];

    $u = mysqli_query($conn, "
        UPDATE anggota 
        SET nama='$nama', status='$status'
        WHERE id='$id'
    ");

    if ($u) {
        echo "<script>alert('Data berhasil diupdate');location='anggota.php';</script>";
    } else {
        echo "<script>alert('Gagal update: ".mysqli_error($conn)."');</script>";
    }
}
?>
