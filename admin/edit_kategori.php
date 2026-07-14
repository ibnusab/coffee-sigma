<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../config/koneksi.php");

if (isset($_POST['id']) && isset($_POST['nama_kategori'])) {

    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn, trim($_POST['nama_kategori']));

    if ($nama != "") {

        mysqli_query($conn, "
            UPDATE kategori
            SET nama_kategori='$nama'
            WHERE id='$id'
        ");

    }

}

header("Location: kategori.php");
exit;