<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../config/koneksi.php");

if (!isset($_GET['id'])) {
    header("Location: menu.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data menu
$query = mysqli_query($conn, "SELECT gambar FROM menu WHERE id='$id'");

if (mysqli_num_rows($query) == 0) {
    header("Location: menu.php");
    exit;
}

$data = mysqli_fetch_assoc($query);

// Hapus file gambar jika ada
if (!empty($data['gambar'])) {

    $file = "../assets/img/menu/" . $data['gambar'];

    if (file_exists($file)) {
        unlink($file);
    }

}

// Hapus data dari database
mysqli_query($conn, "DELETE FROM menu WHERE id='$id'");

// Kembali ke halaman menu
header("Location: menu.php");
exit;