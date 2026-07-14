<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $id = (int)$_POST['id'];

    $status = mysqli_real_escape_string(
        $conn,
        $_POST['status']
    );

    $status_pembayaran = mysqli_real_escape_string(
        $conn,
        $_POST['status_pembayaran']
    );

    $update = mysqli_query($conn,"
        UPDATE pesanan
        SET
            status='$status',
            status_pembayaran='$status_pembayaran'
        WHERE id='$id'
    ");

    if($update){

        $_SESSION['success']="Status berhasil diupdate.";

    }else{

        $_SESSION['error']=mysqli_error($conn);

    }

}

header("Location: pesanan.php");
exit;