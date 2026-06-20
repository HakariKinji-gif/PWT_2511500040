<?php
session_start();
require_once("../koneksi.php");

// Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("location:../index.php?pesan=belum_login");
    exit();
}

// PROSES INPUT PEMINJAMAN
if (isset($_POST['pinjam'])) {
    $id_user    = $_POST['id_user'];
    $id_buku    = $_POST['id_buku'];
    $tgl_pinj   = $_POST['tgl_pinjam'];  // dari form input name="tgl_pinjam"
    $jth_tempo  = $_POST['tgl_kembali']; // dari form input name="tgl_kembali"
    $status     = "Dipinjam";
    $jumlah     = 1;

    // 1. Cek dulu apakah stok buku masih ada
    $cek_stok = mysqli_query($koneksi, "SELECT stok FROM buku WHERE id_buku = '$id_buku'");
    $data_buku = mysqli_fetch_assoc($cek_stok);

    if ($data_buku['stok'] < 1) {
        header("location:peminjaman.php?status=stok_habis");
        exit();
    }

    // 2. Input ke tabel induk (peminjaman) menggunakan kolom tgl_pinj dan jth_tempo
    $query_induk = "INSERT INTO peminjaman (id_user, tgl_pinj, jth_tempo, status) 
                    VALUES ('$id_user', '$tgl_pinj', '$jth_tempo', '$status')";
    
    if (mysqli_query($koneksi, $query_induk)) {
        // Ambil ID peminjaman yang baru saja masuk
        $id_pinj = mysqli_insert_id($koneksi);

        // 3. Input ke tabel anak (detail_peminjaman) sesuai image_a3512a.png
        // (Sesuaikan kata detail_peminjaman dengan nama tabelmu jika berbeda)
        $query_detail = "INSERT INTO detail_peminjaman (id_pinj, id_buku, jumlah) 
                         VALUES ('$id_pinj', '$id_buku', '$jumlah')";
        
        if (mysqli_query($koneksi, $query_detail)) {
            // 4. Potong stok buku di tabel buku
            mysqli_query($koneksi, "UPDATE buku SET stok = stok - 1 WHERE id_buku = '$id_buku'");
            header("location:peminjaman.php?status=sukses_pinjam");
            exit();
        }
    }
    
    // Jika ada yang gagal, lempar status gagal
    header("location:peminjaman.php?status=gagal");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Perpustakaan | Peminjaman Buku</title>
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
          <li class="nav-item"><a href="peminjaman.php" class="nav-link active"><i class="nav-icon fas fa-arrow-right text-success"></i><p>Peminjaman Buku</p></a></li>
          <li class="nav-item"><a href="pengembalian.php" class="nav-link"><i class="nav-icon fas fa-arrow-left text-primary"></i><p>Pengembalian Buku</p></a></li>
          <li class="nav-header">AKUN</li>
          <li class="nav-item"><a href="../logout.php" class="nav-link bg-danger"><i class="nav-icon fas fa-sign-out-alt"></i><p>Logout</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid"><h1 class="m-0">Sirkulasi Peminjaman Buku</h1></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <?php if(isset($_GET['status'])): ?>
          <?php if($_GET['status'] == 'sukses_pinjam'): ?>
            <div class="alert alert-success">Transaksi peminjaman berhasil dicatat! Stok buku otomatis berkurang.</div>
          <?php elseif($_GET['status'] == 'stok_habis'): ?>
            <div class="alert alert-danger">Gagal! Stok buku tersebut sedang kosong/habis.</div>
          <?php elseif($_GET['status'] == 'gagal'): ?>
            <div class="alert alert-danger">Terjadi kesalahan pada sistem data transaksi.</div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-4">
            <div class="card card-success">
              <div class="card-header"><h3 class="card-title">Catat Peminjaman</h3></div>
              <form action="peminjaman.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Peminjam (Siswa/User)</label>
                    <select name="id_user" class="form-control" required>
                      <option value="">-- Pilih Anggota --</option>
                      <?php
                      $u_query = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'Pengunjung' ORDER BY nama ASC");
                      while($u = mysqli_fetch_assoc($u_query)) {
                          echo "<option value='".$u['id_user']."'>".$u['nama']." (".$u['username'].")</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Buku yang Dipinjam</label>
                    <select name="id_buku" class="form-control" required>
                      <option value="">-- Pilih Buku --</option>
                      <?php
                      $b_query = mysqli_query($koneksi, "SELECT * FROM buku WHERE stok > 0 ORDER BY judul ASC");
                      while($b = mysqli_fetch_assoc($b_query)) {
                          echo "<option value='".$b['id_buku']."'>".$b['judul']." [Stok: ".$b['stok']."]</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tgl_pinjam" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                  </div>
                  <div class="form-group">
                    <label>Tanggal Wajib Kembali</label>
                    <input type="date" name="tgl_kembali" class="form-control" value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="pinjam" class="btn btn-success btn-block">Konfirmasi Pinjam</button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-header bg-secondary"><h3 class="card-title">Daftar Buku Sedang Dipinjam</h3></div>
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover table-bordered m-0">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama Peminjam</th>
                      <th>Judul Buku</th>
                      <th>Tgl Pinjam</th>
                      <th>Batas Kembali</th>
                      <th style="width: 80px" class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    // KODE QUERY YANG SUDAH DISESUAIKAN NAMA KOLOMNYA
                    $query_pinjam = mysqli_query($koneksi, "SELECT detail_peminjaman.*, peminjaman.tgl_pinj, peminjaman.jth_tempo, peminjaman.status, users.nama, buku.judul 
                                                            FROM detail_peminjaman 
                                                            INNER JOIN peminjaman ON detail_peminjaman.id_pinj = peminjaman.id_pinj
                                                            INNER JOIN users ON peminjaman.id_user = users.id_user
                                                            INNER JOIN buku ON detail_peminjaman.id_buku = buku.id_buku 
                                                            WHERE peminjaman.status = 'Dipinjam'
                                                            ORDER BY peminjaman.id_pinj DESC");
                    
                    if ($query_pinjam && mysqli_num_rows($query_pinjam) > 0) {
                        while($row = mysqli_fetch_assoc($query_pinjam)) {
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><strong><?php echo $row['nama']; ?></strong></td>
                      <td><?php echo $row['judul']; ?></td>
                      <!-- Memakai tgl_pinj dan jth_tempo sesuai database -->
                      <td><small><?php echo date('d-m-Y', strtotime($row['tgl_pinj'])); ?></small></td>
                      <td><small class="text-danger font-weight-bold"><?php echo date('d-m-Y', strtotime($row['jth_tempo'])); ?></small></td>
                      <td class="text-center"><span class="badge badge-warning"><?php echo $row['status']; ?></span></td>
                    </tr>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center text-muted p-3'>Saat ini tidak ada buku yang sedang dipinjam.</td></tr>";
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