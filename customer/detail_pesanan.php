<?php
session_start();
include("../config/koneksi.php");

if (!isset($_GET['kode'])) {
    die("Kode pesanan tidak ditemukan.");
}

$kode = mysqli_real_escape_string($conn, $_GET['kode']);

/* ===========================
   AMBIL DATA PESANAN
=========================== */

$query = mysqli_query($conn, "
SELECT *
FROM pesanan
WHERE kode_pesanan='$kode'
LIMIT 1
");

if (!$query) {
    die(mysqli_error($conn));
}

if (mysqli_num_rows($query) == 0) {
    die("Data pesanan tidak ditemukan.");
}

$data = mysqli_fetch_assoc($query);

/* ===========================
   WARNA STATUS
=========================== */

/* ===========================
   WARNA STATUS PEMBAYARAN
=========================== */

switch ($data['status_pembayaran']) {

    case 'Sudah Bayar':
        $badgePembayaran = 'bg-success';
        break;

    case 'Belum Bayar':
        $badgePembayaran = 'bg-danger';
        break;

    default:
        $badgePembayaran = 'bg-secondary';
        break;
}

/* ===========================
   WARNA STATUS PESANAN
=========================== */

switch ($data['status']) {

    case 'Pending':
        $badgeStatus = 'bg-warning text-dark';
        break;

    case 'Diproses':
        $badgeStatus = 'bg-success';
        break;

    case 'Selesai':
        $badgeStatus = 'bg-primary';
        break;

    case 'Dibatalkan':
        $badgeStatus = 'bg-danger';
        break;

    default:
        $badgeStatus = 'bg-secondary';
        break;
}

$pesanan_id = $data['id'];

/* ===========================
   AMBIL DETAIL MENU
=========================== */

$detail = mysqli_query($conn, "
SELECT
    dp.qty,
    dp.harga,
    dp.subtotal,
    m.nama_menu
FROM detail_pesanan dp
JOIN menu m
ON dp.menu_id = m.id
WHERE dp.pesanan_id = '$pesanan_id'
");

?>
<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Detail Pesanan</title>
 <link rel="icon" type="image/png" href="../assets/img/logo.png">


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

body{
    background:#1f140d;
    color:#f5efe6;
}

.card{
    background:#2b1d14;
    border:1px solid rgba(255,193,7,.15);
    border-radius:18px;
    color:#f5efe6;
}

.card-body{
    color:#f5efe6;
}

/* Semua paragraf */
.card p{
    color:#e6d8c9;
    margin-bottom:18px;
}

/* Judul kecil seperti "Kode Pesanan", "Nama Pelanggan" */
.card p b{
    color:#ffc107;
    font-weight:600;
}

/* Judul tabel */
h4{
    color:#f5efe6;
}

/* Tabel */
.table{
    color:#f5efe6;
}

.table thead{
    background:#3b2a20;
    color:#ffc107;
}

.table td,
.table th{
    border-color:#5b4334;
}

/* Total */
.text-warning{
    color:#ffc107 !important;
}

/* Badge */
.badge{
    font-size:14px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="card shadow-lg">

<div class="card-body">

<h2 class="text-warning mb-4">

<i class="fa-solid fa-receipt"></i>

Detail Pesanan

</h2>

<hr>

<div class="row">

<div class="col-md-6">

<p>

<b>Kode Pesanan</b><br>

<?= $data['kode_pesanan']; ?>

</p>

<p>

<b>Nama Pelanggan</b><br>

<?= $data['nama_pelanggan']; ?>

</p>

<p>

<b>Tipe Pesanan</b><br>

<?= $data['tipe_pesanan']; ?>

</p>

<?php if($data['tipe_pesanan']=="Dine In"){ ?>

<p>

<b>Nomor Meja</b><br>

<?= $data['nomor_meja']; ?>

</p>

<?php } ?>

<p>

<b>Catatan</b><br>

<?php
if (!empty(trim($data['catatan']))) {
    echo nl2br(htmlspecialchars($data['catatan']));
} else {
    echo '<span class="text-secondary fst-italic">Tidak ada catatan</span>';
}
?>

</p>

</div>

<div class="col-md-6">

<p>

<b>Metode Pembayaran</b><br>

<?= $data['metode_pembayaran']; ?>

</p>

<p>

<b>Status Pembayaran</b><br>

<span class="badge <?= $badgePembayaran; ?> px-3 py-2">

    <?= $data['status_pembayaran']; ?>

</span>

</p>

<p>

<b>Status Pesanan</b><br>

<span class="badge <?= $badgeStatus; ?> px-3 py-2">

    <?= $data['status']; ?>

</span>

</p>

<p>

<b>Tanggal</b><br>

<?= $data['created_at']; ?>

</p>

</div>

</div>

<hr>

<h4 class="mb-3">

Menu yang Dipesan

</h4>

<table class="table table-bordered text-center align-middle">

<thead>

<tr>

<th>Menu</th>

<th>Harga</th>

<th>Qty</th>

<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php

while($d=mysqli_fetch_assoc($detail)){

?>

<tr>

<td><?= $d['nama_menu']; ?></td>

<td>Rp <?= number_format($d['harga'],0,",","."); ?></td>

<td><?= $d['qty']; ?></td>

<td>Rp <?= number_format($d['subtotal'],0,",","."); ?></td>

</tr>

<?php } ?>

</tbody>

</table>

<div class="row justify-content-end">

<div class="col-md-4">

<table class="table">

<tr>

<th>Subtotal</th>

<td class="text-end">

Rp <?= number_format($data['subtotal'],0,",","."); ?>

</td>

</tr>

<tr>

<th>Biaya Layanan</th>

<td class="text-end">

Rp <?= number_format($data['biaya_layanan'],0,",","."); ?>

</td>

</tr>

<tr>

<th>Total</th>

<td class="text-end fw-bold text-warning">

Rp <?= number_format($data['total'],0,",","."); ?>

</td>

</tr>

</table>

</div>

</div>

<div class="text-center mt-4 d-flex justify-content-center gap-2 flex-wrap">

    <a href="cetak_struk.php?kode=<?= $data['kode_pesanan']; ?>"
       class="btn btn-success"
       target="_blank">

        <i class="fa-solid fa-file-pdf"></i>
        Cetak Struk PDF

    </a>

    <a href="index.php" class="btn btn-warning">

        <i class="fa-solid fa-house"></i>
        Kembali ke Beranda

    </a>

</div>

</div>

</div>

</div>

</body>

</html>