<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>



    <!-- ==========================
         SIDEBAR
    =========================== -->

    <aside class="sidebar">

        <div class="logo text-center">

            <img
                src="../assets/img/logo.png"
                alt="Coffee Sigma"
                width="75"
                class="mb-3">

            <h4>Coffee Sigma</h4>

            <small class="text-light opacity-75">
                Admin Panel
            </small>

        </div>

        <ul>

            <li>

                <a href="dashboard.php"
                   class="<?= ($currentPage == 'dashboard.php') ? 'active' : ''; ?>">

                    <i class="fa-solid fa-house"></i>

                    Dashboard

                </a>

            </li>

            <li>

                <a href="kategori.php"
                   class="<?= ($currentPage == 'kategori.php') ? 'active' : ''; ?>">

                    <i class="fa-solid fa-list"></i>

                    Kategori

                </a>

            </li>

            <li>

                <a href="menu.php"
                   class="<?= ($currentPage == 'menu.php') ? 'active' : ''; ?>">

                    <i class="fa-solid fa-mug-hot"></i>

                    Menu

                </a>

            </li>

            <li>

                <a href="pesanan.php"
                   class="<?= ($currentPage == 'pesanan.php') ? 'active' : ''; ?>">

                    <i class="fa-solid fa-cart-shopping"></i>

                    Pesanan

                </a>

            </li>

            <li>

                <a href="laporan.php"
                   class="<?= ($currentPage == 'laporan.php') ? 'active' : ''; ?>">

                    <i class="fa-solid fa-chart-column"></i>

                    Laporan

                </a>

            </li>

            <hr class="sidebar-divider">

            <li>

                <a href="logout.php"
                   onclick="return confirm('Yakin ingin logout?')">

                    <i class="fa-solid fa-right-from-bracket"></i>

                    Logout

                </a>

            </li>

        </ul>

    </aside>

    <!-- ==========================
         CONTENT
    =========================== -->

    <main class="content">