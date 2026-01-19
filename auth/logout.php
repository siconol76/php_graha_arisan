<?php
session_start();

// Hapus semua session
$_SESSION = [];

// Hapus session cookie (opsional tapi disarankan)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy(); // Hancurkan session

// Redirect ke login
header("Location: /arisan/auth/login.php");
exit;
