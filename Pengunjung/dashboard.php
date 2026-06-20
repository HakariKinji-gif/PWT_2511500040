<?php
session_start();
require_once("../koneksi.php"); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Pengunjung') {
    header("location:../index.php?pesan=belum_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa | Ruang Baca Digital</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-success navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><span class="nav-link font-weight-bold text-white">Portal Perpustakaan Siswa</span></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link text-white">Akses: <span class="badge badge-light text-success font-weight-bold">Pengunjung</span></span>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-light-success elevation-4">
    <a href="dashboard.php" class="brand-link bg-success text-white">
      <span class="brand-text font-weight-bold pl-3">E-Perpustakaan</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="../dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image"></div>
        <div class="info"><a href="#" class="d-block font-weight-bold"><?php echo $_SESSION['nama']; ?></a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-th"></i><p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MENU UTAMA</li>
          <li class="nav-item">
            <a href="katalog.php" class="nav-link">
              <i class="nav-icon fas fa-book-open"></i><p>Katalog Buku</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="riwayat.php" class="nav-link">
              <i class="nav-icon fas fa-history"></i><p>Riwayat Pinjaman</p>
            </a>
          </li>
          <li class="nav-header">AKUN</li>
          <li class="nav-item">
            <a href="../logout.php" class="nav-link bg-danger text-white">
              <i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-dark">Ruang Baca Digital</h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <div class="card card-outline card-success elevation-1">
          <div class="card-body">
            <h3>Halo, Selamat Datang <strong class="text-success"><?php echo $_SESSION['nama']; ?>!</strong></h3>
            <p class="text-muted mb-0 mt-2">
              Mau baca buku apa kita hari ini? Kamu bisa mulai menjelajahi koleksi buku terlengkap kami pada menu <strong>Katalog Buku</strong> di menu sebelah kiri.
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2026 Digital Library.</strong>
  </footer>
</div>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html><?php
session_start();
require_once("../koneksi.php"); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Pengunjung') {
    header("location:../index.php?pesan=belum_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa | Ruang Baca Digital</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-success navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><span class="nav-link font-weight-bold text-white">Portal Perpustakaan Siswa</span></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link text-white">Akses: <span class="badge badge-light text-success font-weight-bold">Pengunjung</span></span>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-light-success elevation-4">
    <a href="dashboard.php" class="brand-link bg-success text-white">
      <span class="brand-text font-weight-bold pl-3">E-Perpustakaan</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="../dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image"></div>
        <div class="info"><a href="#" class="d-block font-weight-bold"><?php echo $_SESSION['nama']; ?></a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-th"></i><p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MENU UTAMA</li>
          <li class="nav-item">
            <a href="katalog.php" class="nav-link">
              <i class="nav-icon fas fa-book-open"></i><p>Katalog Buku</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="riwayat.php" class="nav-link">
              <i class="nav-icon fas fa-history"></i><p>Riwayat Pinjaman</p>
            </a>
          </li>
          <li class="nav-header">AKUN</li>
          <li class="nav-item">
            <a href="../logout.php" class="nav-link bg-danger text-white">
              <i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-dark">Ruang Baca Digital</h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <div class="card card-outline card-success elevation-1">
          <div class="card-body">
            <h3>Halo, Selamat Datang <strong class="text-success"><?php echo $_SESSION['nama']; ?>!</strong></h3>
            <p class="text-muted mb-0 mt-2">
              Mau baca buku apa kita hari ini? Kamu bisa mulai menjelajahi koleksi buku terlengkap kami pada menu <strong>Katalog Buku</strong> di menu sebelah kiri.
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2026 Digital Library.</strong>
  </footer>
</div>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html><?php
session_start();
require_once("../koneksi.php"); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Pengunjung') {
    header("location:../index.php?pesan=belum_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa | Ruang Baca Digital</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-success navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><span class="nav-link font-weight-bold text-white">Portal Perpustakaan Siswa</span></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link text-white">Akses: <span class="badge badge-light text-success font-weight-bold">Pengunjung</span></span>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-light-success elevation-4">
    <a href="dashboard.php" class="brand-link bg-success text-white">
      <span class="brand-text font-weight-bold pl-3">E-Perpustakaan</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="../dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image"></div>
        <div class="info"><a href="#" class="d-block font-weight-bold"><?php echo $_SESSION['nama']; ?></a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-th"></i><p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MENU UTAMA</li>
          <li class="nav-item">
            <a href="katalog.php" class="nav-link">
              <i class="nav-icon fas fa-book-open"></i><p>Katalog Buku</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="riwayat.php" class="nav-link">
              <i class="nav-icon fas fa-history"></i><p>Riwayat Pinjaman</p>
            </a>
          </li>
          <li class="nav-header">AKUN</li>
          <li class="nav-item">
            <a href="../logout.php" class="nav-link bg-danger text-white">
              <i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-dark">Ruang Baca Digital</h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <div class="card card-outline card-success elevation-1">
          <div class="card-body">
            <h3>Halo, Selamat Datang <strong class="text-success"><?php echo $_SESSION['nama']; ?>!</strong></h3>
            <p class="text-muted mb-0 mt-2">
              Mau baca buku apa kita hari ini? Kamu bisa mulai menjelajahi koleksi buku terlengkap kami pada menu <strong>Katalog Buku</strong> di menu sebelah kiri.
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2026 Digital Library.</strong>
  </footer>
</div>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html><?php
session_start();
require_once("../koneksi.php"); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Pengunjung') {
    header("location:../index.php?pesan=belum_login");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa | Ruang Baca Digital</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-success navbar-dark">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><span class="nav-link font-weight-bold text-white">Portal Perpustakaan Siswa</span></li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <span class="nav-link text-white">Akses: <span class="badge badge-light text-success font-weight-bold">Pengunjung</span></span>
      </li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-light-success elevation-4">
    <a href="dashboard.php" class="brand-link bg-success text-white">
      <span class="brand-text font-weight-bold pl-3">E-Perpustakaan</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="../dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image"></div>
        <div class="info"><a href="#" class="d-block font-weight-bold"><?php echo $_SESSION['nama']; ?></a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link active">
              <i class="nav-icon fas fa-th"></i><p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MENU UTAMA</li>
          <li class="nav-item">
            <a href="katalog.php" class="nav-link">
              <i class="nav-icon fas fa-book-open"></i><p>Katalog Buku</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="riwayat.php" class="nav-link">
              <i class="nav-icon fas fa-history"></i><p>Riwayat Pinjaman</p>
            </a>
          </li>
          <li class="nav-header">AKUN</li>
          <li class="nav-item">
            <a href="../logout.php" class="nav-link bg-danger text-white">
              <i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <h1 class="m-0 text-dark">Ruang Baca Digital</h1>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <div class="card card-outline card-success elevation-1">
          <div class="card-body">
            <h3>Halo, Selamat Datang <strong class="text-success"><?php echo $_SESSION['nama']; ?>!</strong></h3>
            <p class="text-muted mb-0 mt-2">
              Mau baca buku apa kita hari ini? Kamu bisa mulai menjelajahi koleksi buku terlengkap kami pada menu <strong>Katalog Buku</strong> di menu sebelah kiri.
            </p>
          </div>
        </div>

      </div>
    </div>
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; 2026 Digital Library.</strong>
  </footer>
</div>
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>