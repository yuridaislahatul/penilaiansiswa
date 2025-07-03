<?php
session_start();
include 'koneksi.php';

if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: login.php");
  exit();
}

if (isset($_POST['login'])) {
  $user = mysqli_real_escape_string($koneksi, $_POST['username']);
  $pass = mysqli_real_escape_string($koneksi, $_POST['password']);

  $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$user' AND password='$pass'");
  if (mysqli_num_rows($cek) > 0) {
    $_SESSION['user'] = $user;
    header("Location: index.php");
    exit();
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Penilaian Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #0052D4, #4364F7, #6FB1FC);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .login-box {
      background: white;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 400px;
    }
    .login-header {
      text-align: center;
      margin-bottom: 30px;
    }
    .login-header i {
      font-size: 55px;
      color: #0052D4;
      margin-bottom: 10px;
    }
    .login-header h4 {
      margin: 0;
      font-weight: 600;
      color: #333;
    }
    .form-control {
      border-radius: 8px;
    }
    .btn-primary {
      background-color: #0052D4;
      border: none;
      border-radius: 8px;
    }
    .btn-primary:hover {
      background-color: #0039a6;
    }
    .form-check-label {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <div class="login-box">
    <div class="login-header">
      <i class="bi bi-mortarboard-fill"></i>
      <h4>Sistem Penilaian Siswa</h4>
      <p class="text-muted small">Silakan login untuk melanjutkan</p>
    </div>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="form-group">
        <label><i class="bi bi-person-fill"></i> Username</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <div class="form-group">
        <label><i class="bi bi-lock-fill"></i> Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="form-group form-check">
        <input type="checkbox" name="remember" class="form-check-input">
        <label class="form-check-label">Ingat saya</label>
      </div>
      <button type="submit" name="login" class="btn btn-primary btn-block">
        <i class="bi bi-box-arrow-in-right"></i> Masuk
      </button>
    </form>
  </div>

</body>
</html>
