<?php

include 'config /koneksi.php';

if (!isset($_SESSION['username'])) {
    echo "User belum login!";
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['tambah'])) {
    $pl = $_POST['pl'];
    $pb = $_POST['pb'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {

        if ($data['password'] == $pl) {

            $update = mysqli_query($koneksi, "UPDATE users SET password='$pb' WHERE username='$username'");

            if ($update) {
                echo "<div class='alert alert-success'>Password berhasil diganti!</div>";
            } else {
                echo "<div class='alert alert-danger'>Gagal update password!</div>";
            }

        } else {
            echo "<div class='alert alert-danger'>Password lama salah!</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>User tidak ditemukan!</div>";
    }
}
?>

<div class="content-header">
  <div class="container-fluid"></div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">

        <form method="POST" action="">
          <div class="form-group">
            <label for="pl">Password Lama</label>
            <input type="password" name="pl" id="pl" placeholder="Password Lama" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="pb">Password Baru</label>
            <input type="password" name="pb" id="pb" placeholder="Password Baru" class="form-control" required>
          </div>

          <div class="form-group">
            <input type="submit" name="tambah" value="Ganti Password" class="btn btn-primary btn-sm">
          </div>
        </form>

      </div>
    </div>
  </div>
</section>