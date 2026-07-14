<?php
include("../config/koneksi.php");
include("template/header.php");
include("template/sidebar.php");

$data = mysqli_query($conn,"SELECT * FROM kategori ORDER BY id DESC");
?>

<section class="content-header mb-4">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        <i class="fas fa-list text-warning"></i>
        Data Kategori
    </h2>

    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalTambah">

        <i class="fas fa-plus"></i>

        Tambah Kategori

    </button>

</div>

</div>

</section>



<div class="container-fluid">

<div class="card shadow-lg border-0 rounded-4">

<div class="card-body">

<table class="table table-bordered table-striped" id="kategoriTable">

<thead>

<tr>

<th width="70">No</th>

<th>Nama Kategori</th>

<th width="180">Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=mysqli_fetch_assoc($data)):

?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['nama_kategori']; ?></td>

<td>

<button
    type="button"
    class="btn btn-warning btn-sm btn-edit"
    data-id="<?= $row['id']; ?>"
    data-nama="<?= htmlspecialchars($row['nama_kategori']); ?>">

    <i class="fa fa-edit"></i>

</button>

<a
href="hapus_kategori.php?id=<?= $row['id'];?>"
class="btn btn-danger btn-sm btn-hapus">

<i class="fa fa-trash"></i>

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

<!-- Modal Tambah -->

<div class="modal fade" id="modalTambah">

<div class="modal-dialog">

<form action="tambah_kategori.php" method="POST">

<div class="modal-content">

<div class="modal-header">

<h5>Tambah Kategori</h5>

<button
class="btn-close"
data-bs-dismiss="modal">

</button>

</div>

<div class="modal-body">

<input
type="text"
name="nama_kategori"
class="form-control"
placeholder="Nama Kategori"
required>

</div>

<div class="modal-footer">

<button
class="btn btn-secondary"
data-bs-dismiss="modal">

Batal

</button>

<button
class="btn btn-primary">

Simpan

</button>

</div>

</div>

</form>

</div>

</div>

<!-- Modal Edit -->

<div class="modal fade" id="modalEdit">

<div class="modal-dialog">

<form action="edit_kategori.php" method="POST">

<input
type="hidden"
name="id"
id="edit_id">

<div class="modal-content">

<div class="modal-header">

<h5>Edit Kategori</h5>

<button
class="btn-close"
data-bs-dismiss="modal">

</button>

</div>

<div class="modal-body">

<input
type="text"
name="nama_kategori"
id="edit_nama"
class="form-control"
required>

</div>

<div class="modal-footer">

<button
class="btn btn-secondary"
data-bs-dismiss="modal">

Batal

</button>

<button
class="btn btn-warning">

Update

</button>

</div>

</div>

</form>

</div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // DataTable
    new DataTable("#kategoriTable");

    // Event Edit (aman untuk DataTables)
    document.addEventListener("click", function(e){

        const btn = e.target.closest(".btn-edit");

        if(!btn) return;

        document.getElementById("edit_id").value = btn.dataset.id;
        document.getElementById("edit_nama").value = btn.dataset.nama;

        const modal = new bootstrap.Modal(document.getElementById("modalEdit"));
        modal.show();

    });

    // Event Hapus
    document.addEventListener("click", function(e){

        const btn = e.target.closest(".btn-hapus");

        if(!btn) return;

        e.preventDefault();

        Swal.fire({
            title: "Hapus kategori?",
            text: "Data yang dihapus tidak bisa dikembalikan.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal"
        }).then((result)=>{

            if(result.isConfirmed){

                window.location = btn.href;

            }

        });

    });

});
</script>



</div>

<?php
include("template/footer.php");
?>