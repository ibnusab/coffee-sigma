<?php
session_start();

include "../config/koneksi.php";

$kategori = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id ASC");

$menu = mysqli_query($conn, "
SELECT menu.*, kategori.nama_kategori
FROM menu
JOIN kategori ON kategori.id = menu.kategori_id
WHERE menu.status='aktif'
ORDER BY menu.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Coffee Sigma</title>
     <link rel="icon" type="image/png" href="../assets/img/logo.png">


    <!-- Bootstrap -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fontawesome -->

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- CSS -->

    <link rel="stylesheet"
        href="../assets/css/style.css">

</head>

<body>

    <!-- ===================================== -->
    <!-- NAVBAR -->
    <!-- ===================================== -->

    <nav class="navbar navbar-expand-lg navbar-dark">

        <div class="container">

            <a class="navbar-brand d-flex align-items-center">

                <img src="../assets/img/logo.png"
                    width="60"
                    class="me-3">

                <div>

                    <h5 class="mb-0 fw-bold">

                        Coffee Sigma

                    </h5>

                    <small>

                        Order Menu

                    </small>

                </div>

            </a>

            <button
    class="btn btn-warning rounded-pill px-3 position-relative"
    data-bs-toggle="offcanvas"
    data-bs-target="#cartCanvas">

    <i class="fa-solid fa-cart-shopping"></i>

    <span class="d-none d-sm-inline ms-1">
        Keranjang
    </span>

    <span
        class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle"
        id="badge-cart">
        0
    </span>

</button>

        </div>

    </nav>

    <!-- ===================================== -->
    <!-- HERO -->
    <!-- ===================================== -->

    <section class="hero py-5">

        <div class="container">

            <div class="row align-items-center gy-5">

                <div class="col-lg-7 text-center text-lg-start">

                    <p class="text-warning fw-bold">

                        SELAMAT DATANG DI

                    </p>

                    <h1 class="fw-bold display-5">

    Coffee Sigma

</h1>

                    <p class="lead">

    Temukan minuman dan makanan pilihan kami mulai dari espresso,
    matcha hingga camilan lezat.

</p>

                    <div class="rating mt-3">

                        ⭐⭐⭐⭐⭐

                        <span>

                            4.9 · 2.3k ulasan

                        </span>

                    </div>

                </div>

                <div class="col-lg-5 text-center">

                    <img src="../assets/img/logo.png"
class="hero-logo img-fluid">

                </div>

            </div>

        </div>

    </section>

    <!-- ===================================== -->
    <!-- KATEGORI -->
    <!-- ===================================== -->

    <section class="kategori">

        <div class="container">

            <div class="nav nav-pills flex-nowrap overflow-auto kategori-scroll pb-2">

                <?php

                $active = true;

                while ($k = mysqli_fetch_assoc($kategori)) :

                ?>

                    <button
                        class="nav-link <?= $active ? 'active' : '' ?>"
                        data-id="<?= $k['id']; ?>">

                        <?= $k['nama_kategori']; ?>

                    </button>

                <?php

                    $active = false;

                endwhile;

                ?>

            </div>

        </div>

    </section>

    <!-- ===================================== -->
    <!-- MENU -->
    <!-- ===================================== -->

    <section class="py-5">

        <div class="container">

            <div class="row g-4">

                <?php while ($m = mysqli_fetch_assoc($menu)) : ?>

                    <div class="col-12 col-sm-6 col-lg-4 menu-item" data-kategori="<?= $m['kategori_id']; ?>">

                        <div class="card menu-card">

                            <img src="../assets/img/menu/<?= $m['gambar']; ?>"
                                class="card-img-top menu-img">

                            <div class="card-body">

                                <?php if ($m['badge'] != "none") : ?>

                                    <span class="badge bg-success mb-2">

                                        <?= $m['badge']; ?>

                                    </span>

                                <?php endif; ?>

                                <h5>

                                    <?= $m['nama_menu']; ?>

                                </h5>

                                <p>

                                    <?= $m['deskripsi']; ?>

                                </p>

                                <div class="d-flex justify-content-between align-items-center">

                                    <strong>

                                        Rp <?= number_format($m['harga'], 0, ',', '.'); ?>

                                    </strong>

                                    <button
class="btn btn-warning rounded-pill px-3 btn-add"
    data-id="<?= $m['id']; ?>"
    data-nama="<?= htmlspecialchars($m['nama_menu'], ENT_QUOTES); ?>"
    data-harga="<?= $m['harga']; ?>">

    <i class="fa-solid fa-plus"></i>

    Tambah

</button>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endwhile; ?>

            </div>

        </div>

    </section>

    <!-- ===================================== -->
    <!-- CART -->
    <!-- ===================================== -->

    <div
class="offcanvas offcanvas-end"
style="width:380px;"
        tabindex="-1"
        id="cartCanvas">

        <div class="offcanvas-header">

            <h4>

                Keranjang

            </h4>

            <button
                class="btn-close"
                data-bs-dismiss="offcanvas">

            </button>

        </div>

        <div class="offcanvas-body">

            <div id="cartBody">

    <div class="text-center text-secondary">

        Belum ada pesanan.

    </div>

</div>

<hr>

<div class="d-flex justify-content-between">

    <span>Subtotal</span>

    <strong id="subtotal">Rp 0</strong>

</div>

<div class="d-flex justify-content-between">

    <span>Biaya Layanan</span>

    <strong id="layanan">Rp 2.000</strong>

</div>

<hr>

<div class="d-flex justify-content-between">

    <h5>Total</h5>

    <h4 id="total">Rp 0</h4>

</div>

<button
class="btn btn-warning w-100 mt-4 btn-pesan"
onclick="menujuCheckout()">
    <i class="fa-solid fa-credit-card"></i>
    Pesan Sekarang
</button>

        </div>

    </div>



    <!-- Bootstrap -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS -->

    <script src="../assets/js/script.js"></script>

</body>

</html>