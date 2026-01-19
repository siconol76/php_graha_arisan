<?php
include __DIR__ . "/../config/koneksi.php";
if(!isset($_SESSION['login'])){
  header("location:../auth/masuk.php");
}
?>
<h3>APLIKASI ARISAN</h3>
<hr>
