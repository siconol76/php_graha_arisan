<!DOCTYPE html>
<html>
<head>
<title>Login Arisan</title>
<link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>

<div class="login-box">
  <div class="login-title">
    <h2>ARISAN GRAHA TIRTA</h2>
    <p>Silakan login</p>
  </div>
<form method="post" action="login_proses.php">

  <div class="form-group">
      <label>Username</label>
      <input type="text" name="username" required>
    </div>

    <div class="form-group password-box">
      <label>Password</label>
      <input type="password" name="password" id="password" required>
      <span onclick="toggle()">👁</span>
    </div>
  <button name="login" class="btn-login">LOGIN</button>
</form>
<div class="login-footer">
    © 2026 Arisan Graha Tirta
  </div>
</div>

<script>
function toggle(){
  const p=document.getElementById('password');
  p.type = p.type==='password' ? 'text':'password';
}
</script>

</body>
</html>
