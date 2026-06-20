<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan XAMPP bawaan
$db   = "perpustakaan";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>