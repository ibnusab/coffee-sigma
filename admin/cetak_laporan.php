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

$tanggal = $_GET['tanggal'] ?? '';
$bulan   = $_GET['bulan'] ?? '';
$tahun   = $_GET['tahun'] ?? '';

if ($tanggal != "") {
    $tanggal = mysqli_real_escape_string($conn, $tanggal);
    $where .= " AND DATE(created_at)='$tanggal'";
}

if ($bulan != "") {
    $bulan = (int)$bulan;
    $where .= " AND MONTH(created_at)='$bulan'";
}

if ($tahun != "") {
    $tahun = (int)$tahun;
    $where .= " AND YEAR(created_at)='$tahun'";
}

/* ==========================================
   STATISTIK
========================================== */

$totalTransaksi = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) jumlah FROM pesanan $where
"))['jumlah'] ?? 0;

$totalPendapatan = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT SUM(total) total FROM pesanan $where
"))['total'] ?? 0;

/* ==========================================
   DATA
========================================== */

$data = mysqli_query($conn,"
SELECT * FROM pesanan $where ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Cetak Laporan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    font-family: Arial, sans-serif;
    font-size: 14px;
    padding: 30px;
    background: #f8f9fa;
}

.header{
    text-align: center;
    margin-bottom: 20px;
}

.header h2{
    font-weight: bold;
    margin-bottom: 5px;
}

.header p{
    color: #666;
    margin: 0;
}

.info-box{
    background: white;
    padding: 15px;
    border-radius: 10px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
}

.table th{
    background: #343a40 !important;
    color: white !important;
    text-align: center;
}

.table td{
    vertical-align: middle;
}

.filter-box{
    background: #ffffff;
    padding: 12px;
    border-left: 5px solid #0d6efd;
    margin-bottom: 20px;
    border-radius: 8px;
}

@media print{
    button{
        display:none;
    }
    body{
        background: white;
    }
}

</style>
</head>

<body>

<div class="container-fluid">

<!-- HEADER -->
<div class="header">
    <h2>COFFEE SIGMA</h2>
    <p>Laporan Penjualan</p>
</div>

<!-- FILTER INFO -->
<div class="filter-box">

<strong>Filter Digunakan:</strong><br>

<?php if($tanggal){ ?>
Tanggal: <?= date("d-m-Y", strtotime($tanggal)); ?><br>
<?php } ?>

<?php if($bulan){ ?>
Bulan: <?= date("F", mktime(0,0,0,$bulan,1)); ?><br>
<?php } ?>

<?php if($tahun){ ?>
Tahun: <?= $tahun; ?><br>
<?php } ?>

<?php if(!$tanggal && !$bulan && !$tahun){ ?>
Semua Data (Tanpa Filter)
<?php } ?>

</div>

<!-- INFO BOX -->
<div class="info-box">

<strong>Total Transaksi:</strong> <?= number_format($totalTransaksi); ?><br>
<strong>Total Pendapatan:</strong> Rp <?= number_format($totalPendapatan,0,",","."); ?><br>
<strong>Tanggal Cetak:</strong> <?= date("d-m-Y H:i"); ?>

</div>

<!-- TABLE -->
<table class="table table-bordered table-striped">

<thead>
<tr>
<th>No</th>
<th>Kode</th>
<th>Nama</th>
<th>Tipe</th>
<th>Pembayaran</th>
<th>Total</th>
<th>Tanggal</th>
</tr>
</thead>

<tbody>

<?php $no=1; while($d=mysqli_fetch_assoc($data)) : ?>

<tr>
<td><?= $no++; ?></td>
<td><b><?= $d['kode_pesanan']; ?></b></td>
<td><?= $d['nama_pelanggan']; ?></td>
<td><?= $d['tipe_pesanan']; ?></td>
<td><?= $d['metode_pembayaran']; ?></td>
<td>Rp <?= number_format($d['total'],0,",","."); ?></td>
<td><?= date("d-m-Y H:i",strtotime($d['created_at'])); ?></td>
</tr>

<?php endwhile; ?>

</tbody>
</table>

<!-- SIGN -->
<div class="text-end mt-5">
    <p>Mengetahui,</p>
    <br><br><br>
    <p><b>Admin Coffee Sigma</b></p>
</div>

<!-- BUTTON -->
<div class="text-center mt-4">

<button onclick="window.print()" class="btn btn-primary">
🖨 Cetak
</button>

<button onclick="window.close()" class="btn btn-secondary">
Tutup
</button>

</div>

</div>

</body>
</html>