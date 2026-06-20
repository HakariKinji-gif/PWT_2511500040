<?php
session_start();
include 'koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password']; // Jika nanti pakai password_hash, gunakan password_verify()

// Cari user berdasarkan username
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($query);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($query);

    // Buat session untuk menyimpan data login
    $_SESSION['id_user']   = $data['id_user'];
    $_SESSION['nama']      = $data['nama'];
    $_SESSION['username']  = $data['username'];
    $_SESSION['role']      = $data['role'];

    // Alihkan halaman berdasarkan role
    if ($data['role'] == "Admin") {
        header("location:admin/dashboard.php");
    } else if ($data['role'] == "Pengunjung") {
        header("location:pengunjung/dashboard.php");
    }
} else {
    // Jika login gagal
    header("location:index.php?pesan=gagal");
}
?>