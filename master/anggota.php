<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['login'])) {
    header("Location: ../masuk.php");
    exit;
}
include __DIR__ . "/../config/koneksi.php";
?>

<link rel="stylesheet" href="../assets/css/anggota.css">

<div class="content-box">
  <h2>Tambah Anggota</h2>

  <!-- Form Tambah -->
  <form method="post" action="">
    <div class="form-group">
      <label>Nama Anggota</label>
      <input type="text" name="nama" required>
    </div>

    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <option value="aktif">Aktif</option>
        <option value="nonaktif">Nonaktif</option>
      </select>
    </div>

    <button class="btn" name="save">Simpan</button>
  </form>
<?php
if (isset($_POST['save'])) {
    $nama   = htmlspecialchars($_POST['nama']);
    $status = $_POST['status'];

    $q = mysqli_query($conn,
        "INSERT INTO anggota (nama, status) VALUES ('$nama','$status')"
    );

    if ($q) {
        echo "<script>alert('Anggota berhasil ditambahkan!');location='anggota.php';</script>";
    } else {
        echo "<script>alert('Gagal: ". mysqli_error($conn) ."');</script>";
    }
}
?>
<h3>Daftar Anggota</h3>
<table>
<tr>
  <th>ID</th>
  <th>Nama</th>
  <th>Status</th>
  <th>Aksi</th>
</tr>

<?php
$q2 = mysqli_query($conn, "SELECT * FROM anggota ORDER BY id ASC");
while ($row = mysqli_fetch_assoc($q2)) {
  echo "
  <tr>
    <td>{$row['id']}</td>
    <td>{$row['nama']}</td>
    <td>{$row['status']}</td>
    <td>
      <a class='btn' href='edit_anggota.php?id={$row['id']}'>Edit</a>
      <a class='btn' href='hapus_anggota.php?id={$row['id']}' onclick=\"return confirm('Yakin mau dihapus?')\">Hapus</a>
    </td>
  </tr>
  ";
}
?>

</table>
