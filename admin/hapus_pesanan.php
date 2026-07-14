<?php
session_start();
include("../config/koneksi.php");

/* ===========================
   CEK LOGIN ADMIN
=========================== */

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ===========================
   CEK ID
=========================== */

if (!isset($_GET['id'])) {
    $_SESSION['error'] = "ID pesanan tidak ditemukan.";
    header("Location: pesanan.php");
    exit;
}

$id = (int) $_GET['id'];

/* ===========================
   CEK DATA PESANAN
=========================== */

$cek = mysqli_query($conn, "
SELECT id
FROM pesanan
WHERE id='$id'
LIMIT 1
");

if (mysqli_num_rows($cek) == 0) {

    $_SESSION['error'] = "Data pesanan tidak ditemukan.";

    header("Location: pesanan.php");
    exit;
}

/* ===========================
   TRANSAKSI DATABASE
=========================== */

mysqli_begin_transaction($conn);

try {

    // Hapus detail pesanan terlebih dahulu
    mysqli_query($conn, "
    DELETE FROM detail_pesanan
    WHERE pesanan_id='$id'
    ");

    // Hapus pesanan
    mysqli_query($conn, "
    DELETE FROM pesanan
    WHERE id='$id'
    ");

    mysqli_commit($conn);

    $_SESSION['success'] = "Pesanan berhasil dihapus.";

} catch (Exception $e) {

    mysqli_rollback($conn);

    $_SESSION['error'] = "Pesanan gagal dihapus.";

}

header("Location: pesanan.php");
exit;
?>