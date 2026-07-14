<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* =====================================================
   FILTER LAPORAN
===================================================== */

$where = "WHERE status='Selesai'";

$tanggal = $_GET['tanggal'] ?? "";
$bulan    = $_GET['bulan'] ?? "";
$tahun    = $_GET['tahun'] ?? "";

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

/* =====================================================
   STATISTIK
===================================================== */

// Total transaksi
$qTransaksi = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM pesanan
$where
");

$totalTransaksi = mysqli_fetch_assoc($qTransaksi)['total'] ?? 0;


// Total pendapatan
$qPendapatan = mysqli_query($conn,"
SELECT SUM(total) AS total
FROM pesanan
$where
");

$totalPendapatan = mysqli_fetch_assoc($qPendapatan)['total'] ?? 0;


// Total pelanggan
$qPelanggan = mysqli_query($conn,"
SELECT COUNT(DISTINCT nama_pelanggan) AS total
FROM pesanan
$where
");

$totalPelanggan = mysqli_fetch_assoc($qPelanggan)['total'] ?? 0;


/* =====================================================
   DATA TABEL
===================================================== */

$data = mysqli_query($conn,"
SELECT *
FROM pesanan
$where
ORDER BY created_at DESC
");
?>

<?php include("template/header.php"); ?>
<?php include("template/sidebar.php"); ?>

<section class="content-header mb-4">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h2 class="fw-bold">
    <i class="fas fa-chart-line text-success me-2"></i>
    Laporan Penjualan
</h2>

</div>

</div>

</section>

<div class="container-fluid">

<!-- =====================================================
     FILTER
===================================================== -->

<div class="card shadow border-0 mb-4">

<div class="card-header bg-white">

<h5 class="mb-0">

<i class="fas fa-filter text-primary"></i>

Filter Laporan

</h5>

</div>

<div class="card-body">

<form method="GET">

<div class="row g-3 align-items-end">

<!-- TANGGAL -->

<div class="col-lg-3 col-md-6">

<label class="form-label">

Tanggal

</label>

<input
type="date"
name="tanggal"
class="form-control"
value="<?= htmlspecialchars($tanggal); ?>">

</div>

<!-- BULAN -->

<div class="col-lg-3 col-md-6">

<label class="form-label">

Bulan

</label>

<select
name="bulan"
class="form-select">

<option value="">Semua Bulan</option>

<?php
for($i=1;$i<=12;$i++):
?>

<option
value="<?= $i; ?>"
<?= ($bulan==$i) ? "selected" : ""; ?>>

<?= date("F", mktime(0,0,0,$i,1)); ?>

</option>

<?php endfor; ?>

</select>

</div>

<!-- TAHUN -->

<div class="col-lg-2 col-md-6">

<label class="form-label">

Tahun

</label>

<select
name="tahun"
class="form-select">

<option value="">Semua Tahun</option>

<?php
for($i=date("Y"); $i>=2024; $i--):
?>

<option
value="<?= $i; ?>"
<?= ($tahun==$i) ? "selected" : ""; ?>>

<?= $i; ?>

</option>

<?php endfor; ?>

</select>

</div>

<!-- FILTER -->

<div class="col-lg-2 col-md-6 d-grid">

<button
type="submit"
class="btn btn-primary">

<i class="fas fa-search"></i>

Filter

</button>

</div>

<!-- RESET -->

<div class="col-lg-2 col-md-6 d-grid">

<a
href="laporan.php"
class="btn btn-secondary">

<i class="fas fa-rotate-left"></i>

Reset

</a>

</div>

</div>

</form>

</div>

</div>

<!-- =====================================================
     CARD STATISTIK
===================================================== -->

<div class="row">

<!-- ==========================================
     CARD TOTAL TRANSAKSI
========================================== -->

<div class="col-lg-4 col-md-6 mb-4">

    <div class="card border-0 shadow bg-primary text-white h-100">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="text-uppercase">

                        Total Transaksi

                    </h6>

                    <h2 class="fw-bold mb-0">

                        <?= number_format($totalTransaksi); ?>

                    </h2>

                    <small>

                        Pesanan selesai

                    </small>

                </div>

                <i class="fas fa-shopping-cart fa-3x opacity-50"></i>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================
     CARD PENDAPATAN
========================================== -->

<div class="col-lg-4 col-md-6 mb-4">

    <div class="card border-0 shadow bg-success text-white h-100">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="text-uppercase">

                        Total Pendapatan

                    </h6>

                    <h2 class="fw-bold mb-0">

                        Rp <?= number_format($totalPendapatan,0,",","."); ?>

                    </h2>

                    <small>

                        Semua transaksi selesai

                    </small>

                </div>

                <i class="fas fa-wallet fa-3x opacity-50"></i>

            </div>

        </div>

    </div>

</div>

<!-- ==========================================
     CARD PELANGGAN
========================================== -->

<div class="col-lg-4 col-md-6 mb-4">

    <div class="card border-0 shadow bg-warning text-dark h-100">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h6 class="text-uppercase">

                        Total Pelanggan

                    </h6>

                    <h2 class="fw-bold mb-0">

                        <?= number_format($totalPelanggan); ?>

                    </h2>

                    <small>

                        Pelanggan unik

                    </small>

                </div>

                <i class="fas fa-users fa-3x opacity-50"></i>

            </div>

        </div>

    </div>

</div>

</div>

<!-- ==========================================
     TOMBOL AKSI
========================================== -->

<div class="card shadow border-0 mb-4">

    <div class="card-body">

        <div class="d-flex flex-wrap justify-content-end gap-2">

            <a href="laporan.php" class="btn btn-secondary">

                <i class="fas fa-sync-alt"></i>

                Refresh

            </a>

            <a 
    href="cetak_laporan.php<?= !empty($_SERVER['QUERY_STRING']) ? '?' . htmlspecialchars($_SERVER['QUERY_STRING']) : '' ?>" 
    target="_blank" 
    class="btn btn-danger">

    <i class="fas fa-file-pdf"></i>
    Cetak PDF

</a>

            <a
            href="export_excel.php
            <?=
            !empty($_SERVER['QUERY_STRING'])
            ?
            '?'.$_SERVER['QUERY_STRING']
            :
            '';
            ?>"
            class="btn btn-success">

                <i class="fas fa-file-excel"></i>

                Export Excel

            </a>

        </div>

    </div>

</div>

<!-- ==========================================
     TABEL LAPORAN
========================================== -->

<div class="card shadow border-0">

<div class="card-header bg-white">

<h5 class="mb-0">

<i class="fas fa-table text-primary"></i>

Data Laporan Penjualan

</h5>

</div>

<div class="card-body">

<div class="table-responsive">

<table
id="laporanTable"
class="table table-bordered table-hover table-striped align-middle w-100">

<thead class="table-dark">

<tr>

<th width="60">No</th>

<th>Kode Pesanan</th>

<th>Nama Pelanggan</th>

<th>Tipe</th>

<th>Metode Bayar</th>

<th>Total</th>

<th>Status Bayar</th>

<th>Status Pesanan</th>

<th>Tanggal</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($d=mysqli_fetch_assoc($data)):

?>

<tr>

<td>

<?= $no++; ?>

</td>

<td>

<strong>

<?= $d['kode_pesanan']; ?>

</strong>

</td>

<td>

<?= htmlspecialchars($d['nama_pelanggan']); ?>

</td>

<td>

<?= $d['tipe_pesanan']; ?>

</td>

<td>

<?= $d['metode_pembayaran']; ?>

</td>

<td>

<strong class="text-success">

Rp <?= number_format($d['total'],0,",","."); ?>

</strong>

</td>

<td>

<?php

if($d['status_pembayaran']=="Sudah Bayar"){

?>

<span class="badge bg-success">

Sudah Bayar

</span>

<?php

}else{

?>

<span class="badge bg-danger">

Belum Bayar

</span>

<?php

}

?>

</td>

<td>

<?php

switch($d['status']){

case "Pending":

?>

<span class="badge bg-warning text-dark">

Pending

</span>

<?php

break;

case "Diproses":

?>

<span class="badge bg-info text-dark">

Diproses

</span>

<?php

break;

case "Selesai":

?>

<span class="badge bg-success">

Selesai

</span>

<?php

break;

default:

?>

<span class="badge bg-danger">

Dibatalkan

</span>

<?php

}

?>

</td>

<td>

<?= date("d-m-Y H:i",strtotime($d['created_at'])); ?>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>


<?php include("template/footer.php"); ?>

<style>

/* ==============================
   CARD
============================== */

.card{

    border-radius:12px;

}

.card-header{

    border-bottom:1px solid #e9ecef;

}

/* ==============================
   TABEL
============================== */

.table{

    margin-bottom:0;

}

.table th{

    white-space:nowrap;

    vertical-align:middle;

}

.table td{

    vertical-align:middle;

}

/* ==============================
   BADGE
============================== */

.badge{

    font-size:13px;

    padding:8px 12px;

}

/* ==============================
   DATATABLE
============================== */

.dataTables_wrapper{

    width:100%;

}

.dataTables_filter{

    margin-bottom:15px;

}

.dataTables_length{

    margin-bottom:15px;

}

.dataTables_info{

    margin-top:15px;

}

.dataTables_paginate{

    margin-top:15px;

}

/* ==============================
   RESPONSIVE
============================== */

@media(max-width:768px){

    .content-header h2{

        font-size:24px;

    }

    .btn{

        margin-bottom:5px;

    }

}

</style>

<script>
document.addEventListener("DOMContentLoaded", function () {

    new DataTable("#laporanTable", {
        responsive: false,
        autoWidth: false,
        scrollX: true,
        pageLength: 10,
        ordering: true,
        order: [[8, "desc"]],

        columnDefs: [
            { width: "60px", targets: 0 },
            { width: "150px", targets: 1 },
            { width: "180px", targets: 2 },
            { width: "120px", targets: 3 },
            { width: "150px", targets: 4 },
            { width: "140px", targets: 5 },
            { width: "130px", targets: 6 },
            { width: "130px", targets: 7 },
            { width: "170px", targets: 8 }
        ],

        language: {
            search: "Cari Data :",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            zeroRecords: "Data tidak ditemukan",
            emptyTable: "Belum ada laporan",
            paginate: {
                first: "Awal",
                last: "Akhir",
                next: "›",
                previous: "‹"
            }
        }

    });

});
</script>

