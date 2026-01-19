<?php
include "../config/koneksi.php";
if(!isset($_SESSION['login'])){
  header("location:../auth/login.php");
}
?>
<h3>APLIKASI ARISAN</h3>
<hr>
