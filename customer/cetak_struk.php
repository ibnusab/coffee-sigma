<?php
session_start();

include("../config/koneksi.php");
require_once("../vendor/autoload.php");

use Dompdf\Dompdf;
use Dompdf\Options;

if (!isset($_GET['kode'])) {
    die("Kode pesanan tidak ditemukan");
}

$kode = mysqli_real_escape_string($conn, $_GET['kode']);

$query = mysqli_query($conn,"
SELECT *
FROM pesanan
WHERE kode_pesanan='$kode'
LIMIT 1
");

if(mysqli_num_rows($query)==0){
    die("Data tidak ditemukan");
}

$data = mysqli_fetch_assoc($query);

$detail = mysqli_query($conn,"
SELECT
m.nama_menu,
dp.qty,
dp.harga,
dp.subtotal
FROM detail_pesanan dp
JOIN menu m ON dp.menu_id=m.id
WHERE dp.pesanan_id='".$data['id']."'
");

ob_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<style>

body{
    font-family:"Courier New", monospace;
    font-size:10px;
    color:#000;
    margin:8px;
    line-height:1.35;
}

.container{
    width:100%;
}

.center{
    text-align:center;
}

.right{
    text-align:right;
}

.bold{
    font-weight:bold;
}

.title{
    font-size:24px;
    font-weight:bold;
    letter-spacing:2px;
}

hr{
    border:none;
    border-top:1px dashed #000;
    margin:6px 0;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    padding:1px 0;
    vertical-align:top;
}

.info{
    width:100%;
    table-layout:fixed;
}

.info td:nth-child(1){
    width:60px;
}

.info td:nth-child(2){
    width:10px;
    text-align:center;
}

.info td:nth-child(3){
    width:auto;
    white-space:nowrap;
    font-size:9px;
}

.total{
    font-size:12px;
    font-weight:bold;
}

.footer{
    text-align:center;
    margin-top:8px;
    font-size:10px;
}

.small{
    font-size:9px;
}

</style>

</head>

<body>

<div class="container">

<div class="center">

<div class="title">
COFFEE SIGMA
</div>

<div class="small">

Jl. Komisaris Notosumarsono<br>
Purbalingga<br>
WA : 085956471207

</div>

</div>

<hr>

<table class="info">

<tr>
<table class="info">

<tr>
    <td>Date</td>
    <td>:</td>
    <td><?= date('d/m/Y H:i',strtotime($data['created_at'])); ?></td>
</tr>

<tr>
    <td>Order No</td>
    <td>:</td>
    <td><?= $data['kode_pesanan']; ?></td>
</tr>

<tr>
    <td>Sales Type</td>
    <td>:</td>
    <td><?= $data['tipe_pesanan']; ?></td>
</tr>

<tr>
    <td>Customer</td>
    <td>:</td>
    <td><?= $data['nama_pelanggan']; ?></td>
</tr>

<?php if($data['tipe_pesanan']=="Dine In"){ ?>

<tr>
    <td>Table</td>
    <td>:</td>
    <td><?= $data['nomor_meja']; ?></td>
</tr>

<?php } ?>

<tr>
    <td>Payment</td>
    <td>:</td>
    <td><?= $data['metode_pembayaran']; ?></td>
</tr>

</table>

<hr>

<?php
$totalItem = 0;
?>

<table>

<?php while($d = mysqli_fetch_assoc($detail)){ 

$totalItem += $d['qty'];


?>




<tr>

<td colspan="2" class="bold">

<?= strtoupper($d['nama_menu']); ?>

</td>

</tr>

<tr>

<td>

<?= $d['qty']; ?> x Rp <?= number_format($d['harga'],0,",","."); ?>

</td>

<td class="right">

Rp <?= number_format($d['subtotal'],0,",","."); ?>

</td>

</tr>

<tr>

<td colspan="2">

&nbsp;

</td>

</tr>

<?php } ?>

</table>

<hr>

<table>

<tr>

<td>Total Item</td>

<td class="right">

<?= $totalItem; ?>

</td>

</tr>

</table>

<hr>

<table>

<tr>

<td>Subtotal</td>

<td class="right">

Rp <?= number_format($data['subtotal'],0,",","."); ?>

</td>

</tr>

<tr>

<td>Biaya Layanan</td>

<td class="right">

Rp <?= number_format($data['biaya_layanan'],0,",","."); ?>

</td>

</tr>

<tr class="total">

<td>TOTAL</td>

<td class="right">

Rp <?= number_format($data['total'],0,",","."); ?>

</td>

</tr>

</table>

<hr>

<div class="footer">

<b>TERIMA KASIH</b>

<br>

Selamat Menikmati...

<br><br>

Coffee • Work • Chill

<br>

Instagram : @coffeesigma

<br>

WhatsApp : 085956471207

<br>

Wifi : CoffeeSigma

</div>

</div>

</body>

</html>

<?php

$html = ob_get_clean();

$options = new Options();

$options->set('isRemoteEnabled', true);
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Courier');

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html, 'UTF-8');

/*
=====================================================
HITUNG TINGGI STRUK OTOMATIS
=====================================================
*/

$detail_count = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM detail_pesanan
WHERE pesanan_id='".$data['id']."'
");

$row = mysqli_fetch_assoc($detail_count);

$total_menu = (int)$row['total'];

/*
Perkiraan tinggi (point)

Header      : 210
Menu        : 34/menu
Footer      : 170
*/

$tinggi = 210 + ($total_menu * 34) + 170;

/*
Minimal tinggi
*/

if($tinggi < 520){
    $tinggi = 520;
}

/*
80 mm Thermal
*/

$lebar = 226.77;

$dompdf->setPaper(
    [0,0,$lebar,$tinggi]
);

$dompdf->render();



$dompdf->stream(
    "Struk-".$data['kode_pesanan'].".pdf",
    array(
        "Attachment"=>false
    )
);

exit;
