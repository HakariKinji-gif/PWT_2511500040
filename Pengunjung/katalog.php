<?php
session_start();
// Tambahkan ../ sebelum nama file
require_once("../koneksi.php");

// Proteksi Halaman: Pastikan yang akses adalah Pengunjung/Siswa
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
  <title>Siswa | Katalog Buku</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
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

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-light-success elevation-4">
    <a href="dashboard.php" class="brand-link bg-success text-white">
      <span class="brand-text font-weight-bold pl-3">E-Perpustakaan</span>
    </a>
    <div class="sidebar">
      <!-- User Panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image"><img src="../dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image"></div>
        <div class="info"><a href="#" class="d-block font-weight-bold"><?php echo $_SESSION['nama']; ?></a></div>
      </div>
      <!-- Menu Navigation -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i><p>Dashboard</p>
            </a>
          </li>
          <li class="nav-header">MENU UTAMA</li>
          <li class="nav-item">
            <a href="katalog.php" class="nav-link active">
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

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid"><h1 class="m-0 text-dark">Koleksi Buku Tersedia</h1></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <!-- FILTER PENCARIAN & KATEGORI -->
        <div class="card card-outline card-success mb-4">
          <div class="card-body">
            <form method="GET" action="katalog.php" class="row">
              <div class="col-md-5 mb-2">
                <input type="text" name="cari" class="form-control" placeholder="Cari judul buku atau penulis..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
              </div>
              <div class="col-md-4 mb-2">
                <select name="kategori" class="form-control">
                  <option value="">-- Semua Kategori --</option>
                  <?php 
                  $kat = mysqli_query($koneksi, "SELECT * FROM kategori_buku ORDER BY nm_kat ASC");
                  while($k = mysqli_fetch_assoc($kat)) {
                      $sel = (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kat']) ? 'selected' : '';
                      echo "<option value='".$k['id_kat']."' $sel>".$k['nm_kat']."</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-search"></i> Filter</button>
              </div>
            </form>
          </div>
        </div>

        <!-- GRID TAMPILAN KATALOG BUKU -->
        <div class="row">
          <?php
          $where_clause = "WHERE 1=1";
          if (!empty($_GET['cari'])) {
              $cari = mysqli_real_escape_string($koneksi, $_GET['cari']);
              $where_clause .= " AND (buku.judul LIKE '%$cari%' OR buku.penulis LIKE '%$cari%')";
          }
          if (!empty($_GET['kategori'])) {
              $kategori = mysqli_real_escape_string($koneksi, $_GET['kategori']);
              $where_clause .= " AND buku.id_kat = '$kategori'";
          }

          $query_buku = mysqli_query($koneksi, "SELECT buku.*, kategori_buku.nm_kat 
                                                FROM buku 
                                                LEFT JOIN kategori_buku ON buku.id_kat = kategori_buku.id_kat 
                                                $where_clause ORDER BY buku.id_buku DESC");

          if (mysqli_num_rows($query_buku) > 0) {
              while($b = mysqli_fetch_assoc($query_buku)) {
          ?>
          <div class="col-md-4 col-sm-6 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
              <div class="card-header text-muted border-bottom-0">
                <span class="badge badge-success"><?php echo $b['nm_kat'] ? $b['nm_kat'] : 'Umum'; ?></span>
              </div>
              <div class="card-body pt-0">
                <h2 class="lead"><b><?php echo $b['judul']; ?></b></h2>
                <p class="text-muted text-sm mb-1"><b>Penulis: </b> <?php echo $b['penulis']; ?> </p>
                <p class="text-muted text-sm mb-3"><b>Penerbit: </b> <?php echo $b['penerbit']; ?> (<?php echo $b['thn_penerbit']; ?>)</p>
                
                <!-- Status Ketersediaan Stok -->
                <?php if($b['stok'] > 0): ?>
                  <span class="text-success font-weight-bold text-sm"><i class="fas fa-check-circle"></i> Tersedia di Rak (Stok: <?php echo $b['stok']; ?>)</span>
                <?php else: ?>
                  <span class="text-danger font-weight-bold text-sm"><i class="fas fa-times-circle"></i> Sedang Kosong / Dipinjam</span>
                <?php endif; ?>
              </div>
              <div class="card-footer bg-white text-right">
                <button class="btn btn-xs btn-outline-secondary" disabled>
                  <i class="fas fa-book"></i> Baca di Tempat
                </button>
              </div>
            </div>
          </div>
          <?php 
              }
          } else {
              echo "<div class='col-12 text-center p-5'><h5 class='text-muted'>Buku yang kamu cari tidak ditemukan.</h5></div>";
          }
          ?>
        </div>

      </div>
    </div>
  </div>

  <footer class="main-footer"><strong>Copyright &copy; 2026 Digital Library.</strong></footer>
</div>

<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>