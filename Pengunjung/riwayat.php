<?php
session_start();
// Ubah bagian ini agar keluar satu folder ke root
require_once("../koneksi.php"); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Pengunjung') {
    // Jika ditendang karena belum login, arahkan ke index.php di root
    header("location:../index.php?pesan=belum_login");
    exit();
}

$id_user_login = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa | Riwayat Peminjaman</title>
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
        <div class="image"><img src="../dist/img/Govin.png" class="img-circle elevation-2" alt="User Image" onerror="this.src='../dist/img/avatar5.png'"></div>
        <div class="info"><a href="#" class="d-block font-weight-bold"><?php echo $_SESSION['nama']; ?></a></div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
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
            <a href="riwayat.php" class="nav-link active">
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
      <div class="container-fluid"><h1 class="m-0 text-dark">Riwayat Peminjaman Buku Kamu</h1></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-md-12">
            <div class="card card-success card-outline">
              <div class="card-header"><h3 class="card-title font-weight-bold text-success">Daftar Pinjaman</h3></div>
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover table-bordered m-0">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Judul Buku</th>
                      <th class="text-center">Tanggal Pinjam</th>
                      <th class="text-center">Jatuh Tempo</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    // Query JOIN untuk menarik data pinjaman KHUSUS user yang sedang login
                    $query_riwayat = mysqli_query($koneksi, "SELECT detail_peminjaman.*, peminjaman.tgl_pinj, peminjaman.jth_tempo, peminjaman.status, buku.judul 
                                                             FROM detail_peminjaman 
                                                             INNER JOIN peminjaman ON detail_peminjaman.id_pinj = peminjaman.id_pinj
                                                             INNER JOIN buku ON detail_peminjaman.id_buku = buku.id_buku 
                                                             WHERE peminjaman.id_user = '$id_user_login'
                                                             ORDER BY peminjaman.id_pinj DESC");
                    
                    if ($query_riwayat && mysqli_num_rows($query_riwayat) > 0) {
                        while($row = mysqli_fetch_assoc($query_riwayat)) {
                            // Mengatur warna badge status dinamis
                            $badge_color = ($row['status'] == 'Dipinjam') ? 'badge-warning' : 'badge-success';
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><strong><?php echo $row['judul']; ?></strong></td>
                      <td class="text-center"><?php echo date('d-m-Y', strtotime($row['tgl_pinj'])); ?></td>
                      <td class="text-center text-danger font-weight-bold"><?php echo date('d-m-Y', strtotime($row['jth_tempo'])); ?></td>
                      <td class="text-center">
                        <span class="badge <?php echo $badge_color; ?>"><?php echo $row['status']; ?></span>
                      </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center text-muted p-4'>Kamu belum pernah meminjam buku apapun di perpustakaan.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
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