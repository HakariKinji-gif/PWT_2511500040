<?php
session_start();
require_once("../koneksi.php");

// Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("location:../index.php?pesan=belum_login");
    exit();
}

// 1. PROSES TAMBAH KATEGORI
if (isset($_POST['tambah'])) {
    $nm_kat = mysqli_real_escape_string($koneksi, $_POST['nm_kat']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    $query = "INSERT INTO kategori_buku (nm_kat, deskripsi) VALUES ('$nm_kat', '$deskripsi')";
    if (mysqli_query($koneksi, $query)) {
        header("location:kategori.php?status=sukses_tambah");
    } else {
        header("location:kategori.php?status=gagal");
    }
}

// 2. PROSES HAPUS KATEGORI
if (isset($_GET['hapus'])) {
    $id_kat = $_GET['hapus'];
    $query = "DELETE FROM kategori_buku WHERE id_kat = '$id_kat'";
    if (mysqli_query($koneksi, $query)) {
        header("location:kategori.php?status=sukses_hapus");
    } else {
        header("location:kategori.php?status=gagal");
    }
}

// 3. PROSES UPDATE KATEGORI
if (isset($_POST['update'])) {
    $id_kat    = mysqli_real_escape_string($koneksi, $_POST['id_kat']);
    $nm_kat    = mysqli_real_escape_string($koneksi, $_POST['nm_kat']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    
    $query = "UPDATE kategori_buku SET nm_kat = '$nm_kat', deskripsi = '$deskripsi' WHERE id_kat = '$id_kat'";
    
    if (mysqli_query($koneksi, $query)) {
        header("location:kategori.php?status=sukses_update");
        exit();
    } else {
        header("location:kategori.php?status=gagal");
        exit();
    }
}
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
          <li class="nav-item"><a href="kategori.php" class="nav-link active"><i class="nav-icon fas fa-tags text-warning"></i><p>Kategori Buku</p></a></li>
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
    <div class="content-header">
      <div class="container-fluid"><h1 class="m-0">Manajemen Kategori Buku</h1></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <?php if(isset($_GET['status'])): ?>
          <?php if($_GET['status'] == 'sukses_tambah'): ?>
            <div class="alert alert-success">Kategori baru berhasil ditambahkan!</div>
          <?php elseif($_GET['status'] == 'sukses_hapus'): ?>
            <div class="alert alert-warning">Kategori berhasil dihapus!</div>
          <?php elseif($_GET['status'] == 'gagal'): ?>
            <div class="alert alert-danger">Terjadi kesalahan operasi data.</div>
          <?php elseif($_GET['status'] == 'sukses_update'): ?>
            <div class="alert alert-success">Kategori berhasil diperbarui!</div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-4">
            <div class="card card-primary">
              <div class="card-header"><h3 class="card-title">Tambah Kategori</h3></div>
              <form action="kategori.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nm_kat" class="form-control" placeholder="Contoh: Novel, Sains, Sejarah" required autocomplete="off">
                  </div>
                  <div class="form-group">
  <label>Deskripsi Kategori</label>
  <textarea name="deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..."></textarea>
</div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="tambah" class="btn btn-primary btn-block">Simpan Kategori</button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-header bg-secondary"><h3 class="card-title">Daftar Kategori Terdaftar</h3></div>
              <div class="card-body p-0">
                <table class="table table-striped table-bordered m-0">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama Kategori</th>
                      <th>Deskripsi</th>
                      <th style="width: 100px" class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_tampil = mysqli_query($koneksi, "SELECT * FROM kategori_buku ORDER BY id_kat DESC");
                    if (mysqli_num_rows($query_tampil) > 0) {
                        while($row = mysqli_fetch_assoc($query_tampil)) {
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><strong><?php echo $row['nm_kat']; ?></strong></td>
                      <td><?php echo $row['deskripsi'] ? $row['deskripsi'] : '-'; ?></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-xs text-white" data-toggle="modal" data-target="#modal-edit<?php echo $row['id_kat']; ?>">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                        
                        <a href="kategori.php?hapus=<?php echo $row['id_kat']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus?')">
                          <i class="fas fa-trash"></i> Hapus
                        </a>
                      </td>
                    </tr>

                    <div class="modal fade" id="modal-edit<?php echo $row['id_kat']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title text-white">Edit Kategori</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="kategori.php" method="POST">
                            <div class="modal-body">
                              <input type="hidden" name="id_kat" value="<?php echo $row['id_kat']; ?>">
                              
                              <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" name="nm_kat" class="form-control" value="<?php echo $row['nm_kat']; ?>" required autocomplete="off">
                              </div>
                              <div class="form-group">
                                <label>Deskripsi Kategori</label>
                                <textarea name="deskripsi" class="form-control" rows="3"><?php echo $row['deskripsi']; ?></textarea>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                              <button type="submit" name="update" class="btn btn-warning text-white">Simpan Perubahan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <?php 
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center text-muted p-3'>Belum ada data kategori.</td></tr>";
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