<?php
session_start();
require_once("../koneksi.php");

// Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("location:../index.php?pesan=belum_login");
    exit();
}

// PROSES PENGEMBALIAN BUKU
if (isset($_GET['proses_kembali'])) {
    $id_pinj = $_GET['proses_kembali'];
    $id_buku = $_GET['id_buku'];

    // 1. Update status di tabel peminjaman menjadi Dikembalikan
    $query_kembali = "UPDATE peminjaman SET status = 'Dikembalikan' WHERE id_pinj = '$id_pinj'";
    
    if (mysqli_query($koneksi, $query_kembali)) {
        // 2. Tambahkan kembali stok buku yang dikembalikan (+1)
        mysqli_query($koneksi, "UPDATE buku SET stok = stok + 1 WHERE id_buku = '$id_buku'");
        header("location:pengembalian.php?status=sukses_kembali");
        exit();
    } else {
        header("location:pengembalian.php?status=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Perpustakaan | Pengembalian Buku</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="dashboard.php" class="nav-link">Home</a></li>
    </ul>
  </nav>

  <!-- Sidebar Container -->
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
          <li class="nav-item"><a href="pengembalian.php" class="nav-link active"><i class="nav-icon fas fa-arrow-left text-primary"></i><p>Pengembalian Buku</p></a></li>
          <li class="nav-header">AKUN</li>
          <li class="nav-item"><a href="../logout.php" class="nav-link bg-danger"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid"><h1 class="m-0">Sirkulasi Pengembalian Buku</h1></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <!-- Notifikasi Status -->
        <?php if(isset($_GET['status'])): ?>
          <?php if($_GET['status'] == 'sukses_kembali'): ?>
            <div class="alert alert-success">Buku telah berhasil dikembalikan! Stok buku otomatis bertambah.</div>
          <?php elseif($_GET['status'] == 'gagal'): ?>
            <div class="alert alert-danger">Gagal memproses pengembalian buku.</div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="row">
          <!-- TABEL DAFTAR BUKU YANG HARUS DIKEMBALIKAN -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header bg-primary"><h3 class="card-title">Daftar Transaksi Aktif (Belum Kembali)</h3></div>
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover table-bordered m-0">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama Peminjam</th>
                      <th>Judul Buku</th>
                      <th class="text-center">Tgl Pinjam</th>
                      <th class="text-center">Jatuh Tempo</th>
                      <th class="text-center">Status</th>
                      <th style="width: 150px" class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    // Menggunakan struktur query JOIN ganda yang sudah disesuaikan dengan database milikmu
                    $query_kembali = mysqli_query($koneksi, "SELECT detail_peminjaman.*, peminjaman.tgl_pinj, peminjaman.jth_tempo, peminjaman.status, users.nama, buku.judul 
                                                             FROM detail_peminjaman 
                                                             INNER JOIN peminjaman ON detail_peminjaman.id_pinj = peminjaman.id_pinj
                                                             INNER JOIN users ON peminjaman.id_user = users.id_user
                                                             INNER JOIN buku ON detail_peminjaman.id_buku = buku.id_buku 
                                                             WHERE peminjaman.status = 'Dipinjam'
                                                             ORDER BY peminjaman.id_pinj ASC");
                    
                    if ($query_kembali && mysqli_num_rows($query_kembali) > 0) {
                        while($row = mysqli_fetch_assoc($query_kembali)) {
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><strong><?php echo $row['nama']; ?></strong></td>
                      <td><?php echo $row['judul']; ?></td>
                      <td class="text-center"><small><?php echo date('d-m-Y', strtotime($row['tgl_pinj'])); ?></small></td>
                      <td class="text-center"><small class="text-danger font-weight-bold"><?php echo date('d-m-Y', strtotime($row['jth_tempo'])); ?></small></td>
                      <td class="text-center"><span class="badge badge-warning"><?php echo $row['status']; ?></span></td>
                      <td class="text-center">
                        <!-- Tombol Proses Kembali mengirimkan id_pinj dan id_buku -->
                        <a href="pengembalian.php?proses_kembali=<?php echo $row['id_pinj']; ?>&id_buku=<?php echo $row['id_buku']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Konfirmasi bahwa buku ini sudah diterima kembali?')">
                          <i class="fas fa-check-circle"></i> Kembalikan
                        </a>
                      </td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center text-muted p-4'>Hebat! Tidak ada pinjaman yang menggantung. Semua buku sudah kembali.</td></tr>";
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

  <footer class="main-footer"><strong>Copyright &copy; 2026 Perpustakaan Sekolah.</strong></footer>
</div>

<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>