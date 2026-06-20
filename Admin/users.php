<?php
session_start();
require_once("../koneksi.php");

// Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header("location:../index.php?pesan=belum_login");
    exit();
}

// 1. PROSES TAMBAH USER / ANGGOTA
if (isset($_POST['tambah'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
    $role     = mysqli_real_escape_string($koneksi, $_POST['role']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telp     = mysqli_real_escape_string($koneksi, $_POST['telp']);

    // Cek apakah username sudah dipakai atau belum
    $cek_username = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        header("location:users.php?status=username_kembar");
        exit();
    }

    $query = "INSERT INTO users (nama, username, password, role, email, telp) 
              VALUES ('$nama', '$username', '$password', '$role', '$email', '$telp')";
    
    if (mysqli_query($koneksi, $query)) {
        header("location:users.php?status=sukses_tambah");
    } else {
        header("location:users.php?status=gagal");
    }
}

// 2. PROSES HAPUS USER / ANGGOTA
if (isset($_GET['hapus'])) {
    $id_user = $_GET['hapus'];
    
    // Jangan izinkan admin menghapus akun dirinya sendiri yang sedang login
    if ($id_user == $_SESSION['id_user']) {
        header("location:users.php?status=gagal_hapus_diri");
        exit();
    }

    $query = "DELETE FROM users WHERE id_user = '$id_user'";
    if (mysqli_query($koneksi, $query)) {
        header("location:users.php?status=sukses_hapus");
    } else {
        header("location:users.php?status=gagal");
    }
}

// 3. PROSES UPDATE USER / ANGGOTA
if (isset($_POST['update'])) {
    $id_user  = mysqli_real_escape_string($koneksi, $_POST['id_user']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $role     = mysqli_real_escape_string($koneksi, $_POST['role']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $telp     = mysqli_real_escape_string($koneksi, $_POST['telp']);
    
    // Logika Password: Jika password diisi baru, maka update password. Jika kosong, biarkan password lama.
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($koneksi, $_POST['password']);
        $query = "UPDATE users SET nama='$nama', username='$username', password='$password', role='$role', email='$email', telp='$telp' WHERE id_user='$id_user'";
    } else {
        $query = "UPDATE users SET nama='$nama', username='$username', role='$role', email='$email', telp='$telp' WHERE id_user='$id_user'";
    }
    
    if (mysqli_query($koneksi, $query)) {
        header("location:users.php?status=sukses_update");
        exit();
    } else {
        header("location:users.php?status=gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Perpustakaan | Data Anggota</title>
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
          <li class="nav-item"><a href="users.php" class="nav-link active"><i class="nav-icon fas fa-users text-danger"></i><p>Data Anggota</p></a></li>
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
      <div class="container-fluid"><h1 class="m-0">Manajemen Anggota & Hak Akses</h1></div>
    </div>

    <div class="content">
      <div class="container-fluid">
        
        <?php if(isset($_GET['status'])): ?>
          <?php if($_GET['status'] == 'sukses_tambah'): ?>
            <div class="alert alert-success">Anggota baru berhasil didaftarkan!</div>

          <?php elseif($_GET['status'] == 'sukses_hapus'): ?>
            <div class="alert alert-warning">Data Anggota berhasil dihapus!</div>
          <?php elseif($_GET['status'] == 'username_kembar'): ?>
            <div class="alert alert-danger">Username sudah digunakan! Pilih username lain.</div>
          <?php elseif($_GET['status'] == 'gagal_hapus_diri'): ?>
            <div class="alert alert-danger">Anda tidak bisa menghapus akun Anda sendiri yang sedang aktif!</div>
          <?php elseif($_GET['status'] == 'gagal'): ?>
            <div class="alert alert-danger">Terjadi kesalahan pada sistem data.</div>
          <?php elseif($_GET['status'] == 'sukses_update'): ?>
            <div class="alert alert-success">Data Anggota berhasil diperbarui!</div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="row">
          <div class="col-md-4">
            <div class="card card-danger">
              <div class="card-header"><h3 class="card-title">Registrasi Anggota Baru</h3></div>
              <form action="users.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Username (Untuk Login)</label>
                    <input type="text" name="username" class="form-control" required autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                  </div>
                  <div class="form-group">
                    <label>Hak Akses / Role</label>
                    <select name="role" class="form-control" required>
                      <option value="Pengunjung">Pengunjung / Siswa</option>
                      <option value="Admin">Admin</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@mail.com">
                  </div>
                  <div class="form-group">
                    <label>No. Telepon / WA</label>
                    <input type="text" name="telp" class="form-control">
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" name="tambah" class="btn btn-danger btn-block">Daftarkan Anggota</button>
                </div>
              </form>
            </div>
          </div>

          <div class="col-md-8">
            <div class="card">
              <div class="card-header bg-secondary"><h3 class="card-title">Daftar Anggota Sistem</h3></div>
              <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover table-bordered m-0">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Nama Lengkap</th>
                      <th>Username</th>
                      <th>Kontak</th>
                      <th style="width: 80px" class="text-center">Role</th>
                      <th style="width: 200px" class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_user = mysqli_query($koneksi, "SELECT * FROM users ORDER BY id_user DESC");
                    while($row = mysqli_fetch_assoc($query_user)) {
                    ?>
                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td><strong><?php echo $row['nama']; ?></strong></td>
                      <td><code><?php echo $row['username']; ?></code></td>
                      <td>
                        <small>
                          <b>Email:</b> <?php echo $row['email'] ? $row['email'] : '-'; ?><br>
                          <b>Telp:</b> <?php echo $row['telp'] ? $row['telp'] : '-'; ?>
                        </small>
                      </td>
                      <td class="text-center">
                        <span class="badge <?php echo $row['role'] == 'Admin' ? 'badge-danger' : 'badge-success'; ?>">
                          <?php echo $row['role']; ?>
                        </span>
                      </td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center" style="gap: 5px;">
                          <button type="button" class="btn btn-warning btn-xs text-white" data-toggle="modal" data-target="#modal-edit-user<?php echo $row['id_user']; ?>">
                            <i class="fas fa-edit"></i> Edit
                          </button>
                          
                          <a href="users.php?hapus=<?php echo $row['id_user']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                            <i class="fas fa-trash"></i> Hapus
                          </a>
                        </div>
                      </td>
                    </tr>

                    <div class="modal fade" id="modal-edit-user<?php echo $row['id_user']; ?>">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header bg-warning">
                            <h4 class="modal-title text-white">Edit Data Anggota</h4>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="users.php" method="POST">
                            <div class="modal-body text-left">
                              <input type="hidden" name="id_user" value="<?php echo $row['id_user']; ?>">
                              
                              <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" required autocomplete="off">
                              </div>
                              <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required autocomplete="off">
                              </div>
                              <div class="form-group">
                                <label>Password <small class="text-muted">(Kosongkan jika tidak ingin diubah)</small></label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password baru saja jika ingin ganti">
                              </div>
                              <div class="form-group">
                                <label>Hak Akses / Role</label>
                                <select name="role" class="form-control" required>
                                  <option value="Pengunjung" <?php echo ($row['role'] == 'Pengunjung') ? 'selected' : ''; ?>>Pengunjung / Siswa</option>
                                  <option value="Admin" <?php echo ($row['role'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>">
                              </div>
                              <div class="form-group">
                                <label>No. Telepon / WA</label>
                                <input type="text" name="telp" class="form-control" value="<?php echo $row['telp']; ?>">
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
                    <?php } ?>
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