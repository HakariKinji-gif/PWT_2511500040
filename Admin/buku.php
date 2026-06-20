<?php
session_start();
require_once("../koneksi.php");

// Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("location:../index.php?pesan=belum_login");
    exit();
}

// 1. PROSES TAMBAH BUKU
if (isset($_POST['tambah'])) {
    $judul        = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $penulis      = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $penerbit     = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $thn_penerbit = mysqli_real_escape_string($koneksi, $_POST['thn_penerbit']);
    $stok         = mysqli_real_escape_string($koneksi, $_POST['stok']);
    $id_kat       = mysqli_real_escape_string($koneksi, $_POST['id_kat']);

    $query = "INSERT INTO buku (judul, penulis, penerbit, thn_penerbit, stok, id_kat) 
              VALUES ('$judul', '$penulis', '$penerbit', '$thn_penerbit', '$stok', '$id_kat')";
    
    if (mysqli_query($koneksi, $query)) {
        header("location:buku.php?status=sukses_tambah");
    } else {
        header("location:buku.php?status=gagal");
    }
}

// 2. PROSES HAPUS BUKU
if (isset($_GET['hapus'])) {
    $id_buku = $_GET['hapus'];
    $query = "DELETE FROM buku WHERE id_buku = '$id_buku'";
    
    if (mysqli_query($koneksi, $query)) {
        header("location:buku.php?status=sukses_hapus");
    } else {
        header("location:buku.php?status=gagal");
    }
}

// 3. PROSES UPDATE BUKU
if (isset($_POST['update'])) {
    $id_buku      = mysqli_real_escape_string($koneksi, $_POST['id_buku']);
    $judul        = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $id_kat       = mysqli_real_escape_string($koneksi, $_POST['id_kat']);
    $penulis      = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $penerbit     = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $thn_penerbit = mysqli_real_escape_string($koneksi, $_POST['thn_penerbit']);
    $stok         = mysqli_real_escape_string($koneksi, $_POST['stok']);

    $query = "UPDATE buku SET 
              judul        = '$judul', 
              id_kat       = '$id_kat', 
              penulis      = '$penulis', 
              penerbit     = '$penerbit', 
              thn_penerbit = '$thn_penerbit', 
              stok         = '$stok' 
              WHERE id_buku = '$id_buku'";
    
    if (mysqli_query($koneksi, $query)) {
        header("location:buku.php?status=sukses_update");
        exit();
    } else {
        header("location:buku.php?status=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Perpustakaan | Data Buku</title>
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
          <li class="nav-item"><a href="buku.php" class="nav-link active"><i class="nav-icon fas fa-book text-info"></i><p>Data Buku</p></a></li>
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
      <div class="container-fluid"><h1 class="m-0">Manajemen Data Buku</h1></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <?php if(isset($_GET['status'])): ?>
          <?php if($_GET['status'] == 'sukses_tambah'): ?>
            <div class="alert alert-success">Buku baru berhasil disimpan!</div>
          <?php elseif($_GET['status'] == 'sukses_hapus'): ?>
            <div class="alert alert-warning">Buku berhasil dihapus dari sistem!</div>
          <?php elseif($_GET['status'] == 'gagal'): ?>
            <div class="alert alert-danger">Gagal memproses data buku.</div>
          <?php elseif($_GET['status'] == 'sukses_update'): ?>
            <div class="alert alert-success">Data buku berhasil diperbarui!</div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-4">
            <div class="card card-info">
              <div class="card-header"><h3 class="card-title">Tambah Buku Baru</h3></div>
              <form action="buku.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" class="form-control" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Kategori Buku</label>
                    <select name="id_kat" class="form-control" required>
                      <option value="">-- Pilih Kategori --</option>
                      <?php
                      $kat_query = mysqli_query($koneksi, "SELECT * FROM kategori_buku ORDER BY nm_kat ASC");
                      while($k = mysqli_fetch_assoc($kat_query)) {
                          echo "<option value='".$k['id_kat']."'>".$k['nm_kat']."</option>";
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Penulis</label>
                    <input type="text" name="penulis" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Tahun Terbit</label>
                    <input type="number" name="thn_penerbit" class="form-control" min="1900" max="2030" placeholder="Contoh: 2024" required>
                  </div>
                  <div class="form-group">
                    <label>Stok Buku</label>
                    <input type="number" name="stok" class="form-control" min="0" default="0" required>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="tambah" class="btn btn-info btn-block">Simpan Buku</button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-header bg-secondary"><h3 class="card-title">Koleksi Buku</h3></div>
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover table-bordered m-0">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Judul Buku</th>
                      <th>Kategori</th>
                      <th>Detail Info</th>
                      <th style="width: 40px" class="text-center">Stok</th>
                      <th style="width: 150px" class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_buku = mysqli_query($koneksi, "SELECT buku.*, kategori_buku.nm_kat 
                                                          FROM buku 
                                                          LEFT JOIN kategori_buku ON buku.id_kat = kategori_buku.id_kat 
                                                          ORDER BY id_buku DESC");
                    
                    if (mysqli_num_rows($query_buku) > 0) {
                        while($row = mysqli_fetch_assoc($query_buku)) {
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><strong><?php echo $row['judul']; ?></strong></td>
                      <td><span class="badge badge-info"><?php echo $row['nm_kat'] ? $row['nm_kat'] : 'Tanpa Kategori'; ?></span></td>
                      <td>
                        <small>
                          <b>Penulis:</b> <?php echo $row['penulis']; ?><br>
                          <b>Penerbit:</b> <?php echo $row['penerbit']; ?> (<?php echo $row['thn_penerbit']; ?>)
                        </small>
                      </td>
                      <td class="text-center"><b><?php echo $row['stok']; ?></b></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-warning btn-xs text-white" data-toggle="modal" data-target="#modal-edit-buku<?php echo $row['id_buku']; ?>">
                          <i class="fas fa-edit"></i> Edit
                        </button>
                        
                        <a href="buku.php?hapus=<?php echo $row['id_buku']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                          <i class="fas fa-trash"></i> Hapus
                        </a>
                      </td>
                    </tr>

                    <div class="modal fade" id="modal-edit-buku<?php echo $row['id_buku']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title text-white">Edit Informasi Buku</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="buku.php" method="POST">
                            <div class="modal-body">
                              <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                              
                              <div class="form-group">
                                <label>Judul Buku</label>
                                <input type="text" name="judul" class="form-control" value="<?php echo $row['judul']; ?>" required autocomplete="off">
                              </div>
                              
                              <div class="form-group">
                                <label>Kategori Buku</label>
                                <select name="id_kat" class="form-control" required>
                                  <?php
                                  $kat_query = mysqli_query($koneksi, "SELECT * FROM kategori_buku ORDER BY nm_kat ASC");
                                  while($k = mysqli_fetch_assoc($kat_query)) {
                                      // Logika 'selected' agar kategori lama otomatis terpilih
                                      $selected = ($k['id_kat'] == $row['id_kat']) ? 'selected' : '';
                                      echo "<option value='".$k['id_kat']."' $selected>".$k['nm_kat']."</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                              
                              <div class="form-group">
                                <label>Penulis</label>
                                <input type="text" name="penulis" class="form-control" value="<?php echo $row['penulis']; ?>" required>
                              </div>
                              <div class="form-group">
                                <label>Penerbit</label>
                                <input type="text" name="penerbit" class="form-control" value="<?php echo $row['penerbit']; ?>" required>
                              </div>
                              <div class="form-group">
                                <label>Tahun Terbit</label>
                                <input type="number" name="thn_penerbit" class="form-control" min="1900" max="2030" value="<?php echo $row['thn_penerbit']; ?>" required>
                              </div>
                              <div class="form-group">
                                <label>Stok Buku</label>
                                <input type="number" name="stok" class="form-control" min="0" value="<?php echo $row['stok']; ?>" required>
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
                        echo "<tr><td colspan='6' class='text-center text-muted p-3'>Belum ada koleksi buku. Silakan input di sebelah kiri.</td></tr>";
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