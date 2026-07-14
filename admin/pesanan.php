<?php
session_start();
include("../config/koneksi.php");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

/* ==========================
   FILTER
========================== */

$where = "WHERE 1=1";

if (isset($_GET['status']) && $_GET['status'] != "") {

    $status = mysqli_real_escape_string($conn, $_GET['status']);

    $where .= " AND status='$status'";
}

if (isset($_GET['keyword']) && $_GET['keyword'] != "") {

    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);

    $where .= " AND (

        kode_pesanan LIKE '%$keyword%'

        OR nama_pelanggan LIKE '%$keyword%'

        OR tipe_pesanan LIKE '%$keyword%'

    )";
}

/* ==========================
   AMBIL DATA PESANAN
========================== */

$pesanan = mysqli_query($conn, "
SELECT *
FROM pesanan
$where
ORDER BY id DESC
");
?>

<?php include("template/header.php"); ?>
<?php include("template/sidebar.php"); ?>

<section class="content-header mb-4">

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center">

            <h2 class="fw-bold">
                <i class="fas fa-shopping-cart text-warning"></i>
                Data Pesanan
            </h2>

        </div>

    </div>

</section>

<div class="container-fluid">

    <div class="card shadow-lg border-0 rounded-4">

        <div class="card-body">

<div class="card-header bg-white border-0 py-3">

<form method="GET">

<div class="row">

<div class="col-md-5">

<input
type="text"
name="keyword"
class="form-control"
placeholder="Cari kode / nama pelanggan..."
value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">

</div>

<div class="col-md-3">

<select
name="status"
class="form-select">

<option value="">Semua Status</option>

<option
value="Pending"
<?= (isset($_GET['status']) && $_GET['status']=="Pending")?"selected":""; ?>>
Pending
</option>

<option
value="Diproses"
<?= (isset($_GET['status']) && $_GET['status']=="Diproses")?"selected":""; ?>>
Diproses
</option>

<option
value="Selesai"
<?= (isset($_GET['status']) && $_GET['status']=="Selesai")?"selected":""; ?>>
Selesai
</option>

<option
value="Dibatalkan"
<?= (isset($_GET['status']) && $_GET['status']=="Dibatalkan")?"selected":""; ?>>
Dibatalkan
</option>

</select>

</div>

<div class="col-md-2">

<button
class="btn btn-primary w-100">

<i class="fas fa-search"></i>

Cari

</button>

</div>

<div class="col-md-2">

<a
href="pesanan.php"
class="btn btn-secondary w-100">

Reset

</a>

</div>

</div>

</form>

</div>

<div class="card-body">

<div class="table-responsive">

<table
id="pesananTable"
class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th width="60">No</th>

<th>Kode</th>

<th>Nama</th>

<th>Tipe</th>

<th>Meja</th>

<th>Total</th>

<th>Pembayaran</th>

<th>Status</th>

<th>Tanggal</th>

<th width="170">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no = 1;

while($p = mysqli_fetch_assoc($pesanan)) :

?>

<tr>

<td><?= $no++; ?></td>

<td>

<b><?= $p['kode_pesanan']; ?></b>

</td>

<td>

<?= $p['nama_pelanggan']; ?>

</td>

<td>

<?= $p['tipe_pesanan']; ?>

</td>

<td>

<?= $p['tipe_pesanan']=="Dine In" ? $p['nomor_meja'] : "-"; ?>

</td>

<td>

Rp <?= number_format($p['total'],0,",","."); ?>

</td>

<td>

<?php

if($p['status_pembayaran']=="Sudah Bayar"){

echo "<span class='badge bg-success'>Sudah Bayar</span>";

}else{

echo "<span class='badge bg-danger'>Belum Bayar</span>";

}

?>

</td>

<td>

<?php

switch($p['status']){

case "Pending":

echo "<span class='badge bg-warning text-dark'>Pending</span>";

break;

case "Diproses":

echo "<span class='badge bg-info text-dark'>Diproses</span>";

break;

case "Selesai":

echo "<span class='badge bg-success'>Selesai</span>";

break;

default:

echo "<span class='badge bg-danger'>Dibatalkan</span>";

}

?>

</td>

<td>

<?= date("d-m-Y H:i", strtotime($p['created_at'])); ?>

</td>

<td>

<a
href="../customer/detail_pesanan.php?kode=<?= $p['kode_pesanan']; ?>"
target="_blank"
class="btn btn-info btn-sm text-white"
title="Lihat Detail">

<i class="fas fa-eye"></i>

</a>

<button
type="button"
class="btn btn-warning btn-sm btn-edit"

data-id="<?= $p['id']; ?>"

data-status="<?= $p['status']; ?>"

data-bayar="<?= $p['status_pembayaran']; ?>"

title="Edit Status">

<i class="fas fa-edit"></i>

</button>

<a
href="hapus_pesanan.php?id=<?= $p['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus pesanan ini?')"
title="Hapus">

<i class="fas fa-trash"></i>

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</section>

<!-- =========================================
     MODAL EDIT STATUS PESANAN
========================================= -->

<div class="modal fade"
     id="modalEditStatus"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form
                action="edit_status.php"
                method="POST">

                <!-- ID PESANAN -->

                <input
                    type="hidden"
                    name="id"
                    id="edit_id">

                <div class="modal-header bg-warning">

                    <h5 class="modal-title text-dark">

                        <i class="fas fa-edit"></i>

                        Edit Status Pesanan

                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">

                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Status Pembayaran

                        </label>

                        <select
                            name="status_pembayaran"
                            id="edit_bayar"
                            class="form-select">

                            <option value="Belum Bayar">

                                Belum Bayar

                            </option>

                            <option value="Sudah Bayar">

                                Sudah Bayar

                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label fw-bold">

                            Status Pesanan

                        </label>

                        <select
                            name="status"
                            id="edit_status"
                            class="form-select">

                            <option value="Pending">

                                Pending

                            </option>

                            <option value="Diproses">

                                Diproses

                            </option>

                            <option value="Selesai">

                                Selesai

                            </option>

                            <option value="Dibatalkan">

                                Dibatalkan

                            </option>

                        </select>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        <i class="fas fa-times"></i>

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">

                        <i class="fas fa-save"></i>

                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?php include("template/footer.php"); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ===========================
    // DATATABLE
    // ===========================
    if (typeof DataTable !== "undefined") {

        new DataTable("#pesananTable", {
    responsive: true,
    autoWidth: false,
    scrollX: true,

    columnDefs: [
        { width: "60px", targets: 0 },
        { width: "120px", targets: 1 },
        { width: "220px", targets: 2 },
        { width: "120px", targets: 3 },
        { width: "90px", targets: 4 },
        { width: "140px", targets: 5 },
        { width: "150px", targets: 6 },
        { width: "130px", targets: 7 },
        { width: "170px", targets: 8 },
        { width: "150px", targets: 9 }
    ]
});

    }

    // ===========================
    // MODAL EDIT STATUS
    // ===========================

    const modalElement = document.getElementById("modalEditStatus");

    if (!modalElement) return;

    const modal = new bootstrap.Modal(modalElement);

    document.addEventListener("click", function (e) {

    const btn = e.target.closest(".btn-edit");
    if (!btn) return;

    document.getElementById("edit_id").value = btn.dataset.id;
    document.getElementById("edit_status").value = btn.dataset.status;
    document.getElementById("edit_bayar").value = btn.dataset.bayar;

    modal.show();

});

});
</script>

</body>
</html>