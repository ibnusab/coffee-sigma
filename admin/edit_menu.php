<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../config/koneksi.php");

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("Location: menu.php");
    exit;
}

$id         = (int) $_POST['id'];
$kategori   = (int) $_POST['kategori_id'];
$nama       = mysqli_real_escape_string($conn, trim($_POST['nama_menu']));
$deskripsi  = mysqli_real_escape_string($conn, trim($_POST['deskripsi']));
$harga      = (int) $_POST['harga'];
$stok       = (int) $_POST['stok'];
$badge      = mysqli_real_escape_string($conn, $_POST['badge']);
$status     = mysqli_real_escape_string($conn, $_POST['status']);

$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM menu WHERE id='$id'")
);

$gambar = $data['gambar'];

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {

    $folder = "../assets/img/menu/";

    $namaFile = $_FILES['gambar']['name'];
    $tmpFile  = $_FILES['gambar']['tmp_name'];
    $ukuran   = $_FILES['gambar']['size'];

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    $allow = ['jpg','jpeg','png','webp'];

    if (!in_array($ext, $allow)) {

        die("Format gambar tidak didukung.");

    }

    if ($ukuran > 2 * 1024 * 1024) {

        die("Ukuran gambar maksimal 2 MB.");

    }

    $gambarBaru = time() . "_" . rand(1000,9999) . "." . $ext;

    if (move_uploaded_file($tmpFile, $folder . $gambarBaru)) {

        if (!empty($gambar) && file_exists($folder . $gambar)) {

            unlink($folder . $gambar);

        }

        $gambar = $gambarBaru;

    }

}

mysqli_query($conn, "

UPDATE menu SET

kategori_id='$kategori',
nama_menu='$nama',
deskripsi='$deskripsi',
harga='$harga',
gambar='$gambar',
stok='$stok',
badge='$badge',
status='$status'

WHERE id='$id'

");

header("Location: menu.php");
exit;