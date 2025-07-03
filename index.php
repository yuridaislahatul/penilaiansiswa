<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Penilaian Siswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .wrapper {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    .content {
      flex: 1;
      display: flex;
    }

    .sidebar {
      width: 230px;
      background-color:rgb(2, 174, 217);
      color: white;
      padding-top: 30px;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }

    .sidebar h4 {
      font-size: 22px;
      font-weight: bold;
      text-align: center;
      margin-bottom: 30px;
    }

    .sidebar a {
      color: white;
      display: block;
      padding: 12px 20px;
      text-decoration: none;
      transition: all 0.3s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: rgba(10, 74, 117, 0.1);
    }

    .sidebar a i {
      margin-right: 8px;
    }

    .main-content {
      margin-left: 230px;
      padding: 30px;
      flex: 1;
    }

    .navbar-custom {
      background-color:rgb(63, 167, 181);
      color: white;
      padding: 15px 30px;
    }

    .navbar-custom .navbar-text {
      color: white;
      font-size: 18px;
      font-weight: 500;
    }

    .custom-card {
      background: white;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.08);
      transition: all 0.3s;
    }

    .custom-card:hover {
      transform: translateY(-2px);
    }

    footer {
      background-color: #2e3b55;
      color: white;
      padding: 15px 30px;
      text-align: center;
    }

    @media (max-width: 768px) {
      .sidebar {
        position: relative;
        width: 100%;
        height: auto;
      }
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
<div class="wrapper">
  <div class="content">
    <!-- Sidebar -->
    <div class="sidebar">
      <h4><i class="bi bi-mortarboard-fill"></i> Penilaian</h4>
      <a href="?page=home" class="<?= $page == 'home' ? 'active' : '' ?>"><i class="bi bi-house-door-fill"></i> Dashboard</a>
      <a href="?page=kelas" class="<?= $page == 'kelas' ? 'active' : '' ?>"><i class="bi bi-building"></i> Data Kelas</a>
      <a href="?page=siswa" class="<?= $page == 'siswa' ? 'active' : '' ?>"><i class="bi bi-people-fill"></i> Data Siswa</a>
      <a href="?page=nilai" class="<?= $page == 'nilai' ? 'active' : '' ?>"><i class="bi bi-clipboard-data-fill"></i> Data Nilai</a>
      <a href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main -->
    <div class="main-content">
      <div class="navbar-custom mb-4 shadow-sm rounded">
        <span class="navbar-text"><i class="bi bi-speedometer2"></i> Sistem Penilaian Siswa</span>
      </div>

      <?php
      if ($page == 'home') {
        echo '
        <div class="custom-card">
          <h4 class="mb-3"><i class="bi bi-info-circle-fill"></i> Selamat Datang</h4>
          <p>Halo <b>' . $_SESSION['user'] . '</b>, selamat datang di Sistem Penilaian Siswa. Gunakan menu di samping untuk mengelola data kelas, siswa, dan nilai.</p>
        </div>';
      } elseif ($page == 'kelas') {
        include 'kelas.php';
      } elseif ($page == 'siswa') {
        include 'siswa.php';
      } elseif ($page == 'nilai') {
        include 'nilai.php';
      } else {
        echo "<div class='alert alert-warning'>Halaman tidak ditemukan!</div>";
      }
      ?>
    </div>
  </div>

  <!-- Footer -->
 
</div>
</body>
</html>
