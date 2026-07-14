<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../config/koneksi.php");

if (isset($_POST['nama_kategori'])) {

    $nama = mysqli_real_escape_string($conn, trim($_POST['nama_kategori']));

    if ($nama != "") {

        mysqli_query($conn, "
            INSERT INTO kategori (nama_kategori)
            VALUES ('$nama')
        ");

    }

}

header("Location: kategori.php");
exit;