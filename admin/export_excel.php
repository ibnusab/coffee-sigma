<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ==========================================
   FILTER
========================================== */

$where = "WHERE status='Selesai'";

if(isset($_GET['tanggal']) && $_GET['tanggal']!=""){
    $tanggal = mysqli_real_escape_string($conn,$_GET['tanggal']);
    $where .= " AND DATE(created_at)='$tanggal'";
}

if(isset($_GET['bulan']) && $_GET['bulan']!=""){
    $bulan = (int)$_GET['bulan'];
    $where .= " AND MONTH(created_at)='$bulan'";
}

if(isset($_GET['tahun']) && $_GET['tahun']!=""){
    $tahun = (int)$_GET['tahun'];
    $where .= " AND YEAR(created_at)='$tahun'";
}

/* ==========================================
   HEADER EXCEL
========================================== */

$namaFile = "Laporan_Penjualan_" . date("Ymd_His") . ".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$namaFile\"");

/* ==========================================
   STATISTIK
========================================== */

$q1 = mysqli_query($conn,"
SELECT COUNT(*) jumlah
FROM pesanan
$where
");

$totalTransaksi = mysqli_fetch_assoc($q1)['jumlah'];

$q2 = mysqli_query($conn,"
SELECT SUM(total) total
FROM pesanan
$where
");

$totalPendapatan = mysqli_fetch_assoc($q2)['total'];

$q3 = mysqli_query($conn,"
SELECT COUNT(DISTINCT nama_pelanggan) pelanggan
FROM pesanan
$where
");

$totalPelanggan = mysqli_fetch_assoc($q3)['pelanggan'];

/* ==========================================
   DATA
========================================== */

$data = mysqli_query($conn,"
SELECT *
FROM pesanan
$where
ORDER BY created_at DESC
");
?>

<table border="0">

<tr>
<td colspan="8" align="center">

<h2>LAPORAN PENJUALAN COFFEE SIGMA</h2>

</td>
</tr>

<tr>
<td colspan="8">

Tanggal Export :
<?= date("d-m-Y H:i:s"); ?>

</td>
</tr>

<tr><td colspan="8"></td></tr>

<tr>

<td><b>Total Transaksi</b></td>

<td>

<?= $totalTransaksi; ?>

</td>

</tr>

<tr>

<td><b>Total Pendapatan</b></td>

<td>

Rp <?= number_format($totalPendapatan,0,",","."); ?>

</td>

</tr>

<tr>

<td><b>Total Pelanggan</b></td>

<td>

<?= $totalPelanggan; ?>

</td>

</tr>

</table>

<br>

<table border="1">

<thead>

<tr bgcolor="#CCCCCC">

<th>No</th>

<th>Kode Pesanan</th>

<th>Nama Pelanggan</th>

<th>Tipe Pesanan</th>

<th>Nomor Meja</th>

<th>Metode Pembayaran</th>

<th>Status Pembayaran</th>

<th>Status Pesanan</th>

<th>Subtotal</th>

<th>Biaya Layanan</th>

<th>Total</th>

<th>Tanggal</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($d = mysqli_fetch_assoc($data)){

?>

<tr>

<td>

<?= $no++; ?>

</td>

<td>

<?= $d['kode_pesanan']; ?>

</td>

<td>

<?= $d['nama_pelanggan']; ?>

</td>

<td>

<?= $d['tipe_pesanan']; ?>

</td>

<td>

<?= $d['tipe_pesanan']=="Dine In"
? $d['nomor_meja']
: "-"; ?>

</td>

<td>

<?= $d['metode_pembayaran']; ?>

</td>

<td>

<?= $d['status_pembayaran']; ?>

</td>

<td>

<?= $d['status']; ?>

</td>

<td>

Rp <?= number_format($d['subtotal'],0,",","."); ?>

</td>

<td>

Rp <?= number_format($d['biaya_layanan'],0,",","."); ?>

</td>

<td>

Rp <?= number_format($d['total'],0,",","."); ?>

</td>

<td>

<?= date("d-m-Y H:i",strtotime($d['created_at'])); ?>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<br><br>

<table border="0">

<tr>

<td width="800"></td>

<td align="center">

<?= date("d F Y"); ?>

<br><br><br><br>

<b>Admin Coffee Sigma</b>

</td>

</tr>

</table>