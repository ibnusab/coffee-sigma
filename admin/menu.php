<?php
include("../config/koneksi.php");
include("template/header.php");
include("template/sidebar.php");

$menu = mysqli_query($conn,"
SELECT menu.*, kategori.nama_kategori
FROM menu
JOIN kategori ON kategori.id = menu.kategori_id
ORDER BY menu.id DESC
");

$kategori = mysqli_query($conn,"
SELECT *
FROM kategori
ORDER BY nama_kategori ASC
");
?>



    <section class="content-header mb-4">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2 class="fw-bold">
        <i class="fas fa-mug-hot text-primary"></i>
        Data Menu
    </h2>

    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalTambah">

        <i class="fas fa-plus"></i>
        Tambah Menu

    </button>

</div>

</div>

</section>

<div class="container-fluid">

<div class="card shadow-lg border-0 rounded-4">

<div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle w-100" id="menuTable">
<thead class="table-dark">

<tr>

<th width="60">No</th>

<th width="90">Gambar</th>

<th>Nama Menu</th>

<th>Kategori</th>

<th>Harga</th>

<th>Stok</th>

<th>Badge</th>

<th>Status</th>

<th width="170">Aksi</th>

</tr>

</thead>

<tbody>

<?php
$no=1;
while($m=mysqli_fetch_assoc($menu)):
?>

<tr>

<td><?= $no++; ?></td>

<td>

<img
src="../assets/img/menu/<?= $m['gambar'];?>"
width="70"
height="70"
style="object-fit:cover;border-radius:10px;">

</td>

<td>

<strong><?= $m['nama_menu']; ?></strong>

<br>

<small class="text-muted">

<?= substr($m['deskripsi'],0,40); ?>...

</small>

</td>

<td><?= $m['nama_kategori']; ?></td>

<td>Rp <?= number_format($m['harga'],0,",","."); ?></td>

<td><?= $m['stok']; ?></td>

<td><?= $m['badge']; ?></td>

<td>

<?php if($m['status']=="aktif"){ ?>

<span class="badge bg-success">Aktif</span>

<?php }else{ ?>

<span class="badge bg-danger">Nonaktif</span>

<?php } ?>

</td>

<td>

<button
    type="button"
    class="btn btn-warning btn-sm btn-edit"

    data-id="<?= $m['id']; ?>"
    data-kategori="<?= $m['kategori_id']; ?>"
    data-nama="<?= htmlspecialchars($m['nama_menu'], ENT_QUOTES); ?>"
    data-harga="<?= $m['harga']; ?>"
    data-stok="<?= $m['stok']; ?>"
    data-badge="<?= $m['badge']; ?>"
    data-status="<?= $m['status']; ?>"
    data-deskripsi="<?= htmlspecialchars($m['deskripsi'], ENT_QUOTES); ?>"
    data-gambar="<?= $m['gambar']; ?>">

    <i class="fa fa-edit"></i>

</button>

<a
    href="hapus_menu.php?id=<?= $m['id']; ?>"
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

</div>

<!-- =======================
MODAL TAMBAH
======================= -->

<div class="modal fade" id="modalTambah">

<div class="modal-dialog modal-lg">

<form
action="tambah_menu.php"
method="POST"
enctype="multipart/form-data">

<div class="modal-content">

<div class="modal-header">

<h5>Tambah Menu</h5>

<button
class="btn-close"
data-bs-dismiss="modal">

</button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-6 mb-3">

<label>Nama Menu</label>

<input
type="text"
name="nama_menu"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Kategori</label>

<select
name="kategori_id"
class="form-select"
required>

<option value="">Pilih</option>

<?php
mysqli_data_seek($kategori,0);
while($k=mysqli_fetch_assoc($kategori)):
?>

<option value="<?= $k['id']; ?>">

<?= $k['nama_kategori']; ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Harga</label>

<input
type="number"
name="harga"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Stok</label>

<input
type="number"
name="stok"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Badge</label>

<select
name="badge"
class="form-select">

<option value="none">None</option>
<option value="Best Seller">Best Seller</option>
<option value="New">New</option>
<option value="Signature">Signature</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select
name="status"
class="form-select">

<option value="aktif">Aktif</option>
<option value="nonaktif">Nonaktif</option>

</select>

</div>

<div class="col-12 mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
class="form-control"
rows="3"></textarea>

</div>

<div class="col-12">

<label>Upload Gambar</label>

<input
type="file"
name="gambar"
class="form-control"
accept="image/*"
required>

</div>

</div>

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

<!-- ==========================
MODAL EDIT
========================== -->

<div class="modal fade" id="modalEdit">

<div class="modal-dialog modal-lg">

<form
action="edit_menu.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
id="edit_id">

<div class="modal-content">

<div class="modal-header">

<h5>Edit Menu</h5>

<button
class="btn-close"
data-bs-dismiss="modal">
</button>

</div>

<div class="modal-body">

<div class="row">

<div class="col-md-6 mb-3">

<label>Nama Menu</label>

<input
type="text"
name="nama_menu"
id="edit_nama"
class="form-control"
required>

</div>

<div class="col-md-6 mb-3">

<label>Kategori</label>

<select
name="kategori_id"
id="edit_kategori"
class="form-select">

<?php
mysqli_data_seek($kategori,0);
while($k=mysqli_fetch_assoc($kategori)):
?>

<option value="<?= $k['id']; ?>">

<?= $k['nama_kategori']; ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Harga</label>

<input
type="number"
name="harga"
id="edit_harga"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Stok</label>

<input
type="number"
name="stok"
id="edit_stok"
class="form-control">

</div>

<div class="col-md-6 mb-3">

<label>Badge</label>

<select
name="badge"
id="edit_badge"
class="form-select">

<option value="none">None</option>
<option value="Best Seller">Best Seller</option>
<option value="New">New</option>
<option value="Signature">Signature</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select
name="status"
id="edit_status"
class="form-select">

<option value="aktif">Aktif</option>
<option value="nonaktif">Nonaktif</option>

</select>

</div>

<div class="col-12 mb-3">

<label>Deskripsi</label>

<textarea
name="deskripsi"
id="edit_deskripsi"
class="form-control"
rows="3"></textarea>

</div>

<div class="col-12 mb-3">

<img
id="preview_gambar"
src=""
width="120"
class="rounded border">

</div>

<div class="col-12">

<label>Ganti Gambar</label>

<input
type="file"
name="gambar"
class="form-control">

</div>

</div>

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

                </div>
            </div>

        </div>

    



<?php
include("template/footer.php");
?>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ===========================
    // DataTable
    // ===========================

    new DataTable("#menuTable",{
    responsive:true,
    autoWidth:false,
    scrollX:true,
    columnDefs:[
        { width:"60px", targets:0 },
        { width:"90px", targets:1 },
        { width:"220px", targets:2 },
        { width:"180px", targets:3 },
        { width:"120px", targets:4 },
        { width:"70px", targets:5 },
        { width:"120px", targets:6 },
        { width:"100px", targets:7 },
        { width:"120px", targets:8 }
    ]
});

    // ===========================
    // Edit Menu
    // ===========================

    document.addEventListener("click", function (e) {

        const btn = e.target.closest(".btn-edit");

        if (!btn) return;

        document.getElementById("edit_id").value = btn.dataset.id;
        document.getElementById("edit_nama").value = btn.dataset.nama;
        document.getElementById("edit_kategori").value = btn.dataset.kategori;
        document.getElementById("edit_harga").value = btn.dataset.harga;
        document.getElementById("edit_stok").value = btn.dataset.stok;
        document.getElementById("edit_badge").value = btn.dataset.badge;
        document.getElementById("edit_status").value = btn.dataset.status;
        document.getElementById("edit_deskripsi").value = btn.dataset.deskripsi;

        document.getElementById("preview_gambar").src =
            "../assets/img/menu/" + btn.dataset.gambar;

        const modal = new bootstrap.Modal(document.getElementById("modalEdit"));
        modal.show();

    });

    // ===========================
    // Hapus Menu
    // ===========================

    document.addEventListener("click", function (e) {

        const btn = e.target.closest(".btn-hapus");

        if (!btn) return;

        e.preventDefault();

        Swal.fire({
            title: "Hapus menu?",
            text: "Data menu beserta gambar akan dihapus.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal"
        }).then((result) => {

            if (result.isConfirmed) {

                window.location = btn.href;

            }

        });

    });

});
</script>