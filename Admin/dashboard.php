<?php
session_start();
require_once("../koneksi.php");

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Perpustakaan | Kategori Buku</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="dashboard.php" class="nav-link">Home</a></li>
    </ul>
  </nav>

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="dashboard.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8" onerror="this.src='../dist/img/avatar5.png'">
      <span class="brand-text font-weight-light">Perpus Admin</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="../dist/img/Govin.jpeg" class="img-circle elevation-2" alt="User Image" onerror="this.src='../dist/img/avatar5.png'"></div>
        <div class="info"><a href="#" class="d-block"><?php echo $_SESSION['nama']; ?></a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <li class="nav-header">DATA MASTER</li>
          <li class="nav-item"><a href="kategori.php" class="nav-link"><i class="nav-icon fas fa-tags text-warning"></i><p>Kategori Buku</p></a></li>
          <li class="nav-item"><a href="buku.php" class="nav-link"><i class="nav-icon fas fa-book text-info"></i><p>Data Buku</p></a></li>
          <li class="nav-item"><a href="users.php" class="nav-link"><i class="nav-icon fas fa-users text-danger"></i><p>Data Anggota</p></a></li>
          <li class="nav-header">TRANSAKSI</li>
          <li class="nav-item"><a href="peminjaman.php" class="nav-link"><i class="nav-icon fas fa-arrow-right text-success"></i><p>Peminjaman Buku</p></a></li>
          <li class="nav-item"><a href="pengembalian.php" class="nav-link"><i class="nav-icon fas fa-arrow-left text-primary"></i><p>Pengembalian Buku</p></a></li>
          <li class="nav-header">AKUN</li>
          <li class="nav-item"><a href="../logout.php" class="nav-link bg-danger"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content pt-4">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            
            <div class="card card-primary card-outline">
              <div class="card-body">
                
                <?php
                  if (isset($_GET['page'])) {
                      $page = $_GET['page'];
                  } else {
                      $page = "";
                  }

                  if ($page == "") {
                      // Halaman default saat pertama kali login
                      echo "<h3>Selamat Datang, <b>".$_SESSION['nama']."</b>!</h3>";
                      echo "<p>Anda masuk sebagai hak akses: <b>".$role."</b>. Silakan pilih menu di samping untuk mengelola data perpustakaan.</p>";
                  } else if (!file_exists("page/$page.php")) {
                      echo "<div class='alert alert-danger'><h4><i class='icon fas fa-ban'></i> Error!</h4> File <b>page/$page.php</b> tidak ditemukan.</div>";
                  } else {
                      include "page/".$page.".php";
                  }
                ?>
                
              </div>
            </div>

          </div>
        </div>
        </div></div>
    </div>
  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
      Tugas Project Perpustakaan Web
    </div>
    <strong>Copyright &copy; 2026.</strong> All rights reserved.
  </footer>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<?php
} else {
    // Jika tidak ada session role, langsung tendang ke halaman login utama
    header("location:index.php?pesan=belum_login");
}
?>