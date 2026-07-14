<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include("../config/koneksi.php");

if (isset($_GET['id'])) {

    $id = (int)$_GET['id'];

    mysqli_query($conn, "
        DELETE FROM kategori
        WHERE id='$id'
    ");

}

header("Location: kategori.php");
exit;