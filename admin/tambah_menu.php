<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../config/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $kategori   = (int) $_POST['kategori_id'];
    $nama       = mysqli_real_escape_string($conn, trim($_POST['nama_menu']));
    $deskripsi  = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
    $harga      = (int) $_POST['harga'];
    $stok       = (int) $_POST['stok'];
    $badge      = mysqli_real_escape_string($conn, $_POST['badge']);
    $status     = mysqli_real_escape_string($conn, $_POST['status']);

    $gambar = "";

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

        $folder = "../assets/img/menu/";

        $namaFile = $_FILES['gambar']['name'];
        $tmpFile  = $_FILES['gambar']['tmp_name'];
        $ukuran   = $_FILES['gambar']['size'];

        $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

        $allow = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $allow)) {
            die("Format gambar harus JPG, JPEG, PNG atau WEBP.");
        }

        if ($ukuran > 2 * 1024 * 1024) {
            die("Ukuran gambar maksimal 2 MB.");
        }

        $gambar = time() . "_" . rand(1000,9999) . "." . $ext;

        move_uploaded_file($tmpFile, $folder . $gambar);

    }

    mysqli_query($conn, "
        INSERT INTO menu
        (
            kategori_id,
            nama_menu,
            deskripsi,
            harga,
            gambar,
            stok,
            badge,
            status
        )
        VALUES
        (
            '$kategori',
            '$nama',
            '$deskripsi',
            '$harga',
            '$gambar',
            '$stok',
            '$badge',
            '$status'
        )
    ");

    header("Location: menu.php");
    exit;
}

header("Location: menu.php");
exit;