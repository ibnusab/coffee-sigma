<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../config/koneksi.php");

include("template/header.php");
include("template/sidebar.php");

$tanggal = $_GET['tanggal'] ?? '';
$bulan   = $_GET['bulan'] ?? '';
$tahun   = $_GET['tahun'] ?? '';

$where = "WHERE status='Selesai'";

if($tanggal!=""){
    $where .= " AND DATE(created_at)='$tanggal'";
}

if($bulan!=""){
    $where .= " AND MONTH(created_at)='$bulan'";
}

if($tahun!=""){
    $where .= " AND YEAR(created_at)='$tahun'";
}

/* ==========================
   STATISTIK
========================== */

$totalKategori = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM kategori")
);

$totalMenu = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM menu")
);

// Total pesanan sesuai filter
$queryTotalPesanan = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM pesanan
$where
");

$totalPesanan = mysqli_fetch_assoc($queryTotalPesanan)['total'];


// Pesanan selesai sesuai filter
$queryTotalSelesai = mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM pesanan
$where
");

$totalSelesai = mysqli_fetch_assoc($queryTotalSelesai)['total'];

$queryPendapatan = mysqli_query($conn,"
SELECT SUM(total) AS total
FROM pesanan
$where
") or die(mysqli_error($conn));

$totalPendapatan = mysqli_fetch_assoc($queryPendapatan);

$pendapatan = $totalPendapatan['total'] ?? 0;

/* ==========================
   DATA GRAFIK
========================== */
$label=[];
$data=[];

if($tanggal!=""){

    $queryGrafik=mysqli_query($conn,"
    SELECT
        HOUR(created_at) jam,
        SUM(total) total
    FROM pesanan
    $where
    GROUP BY HOUR(created_at)
    ORDER BY HOUR(created_at)
    ");

    while($r=mysqli_fetch_assoc($queryGrafik)){
        $label[]=sprintf("%02d:00",$r['jam']);
        $data[]=$r['total'];
    }

}elseif($bulan!=""){

    $queryGrafik=mysqli_query($conn,"
    SELECT
        DAY(created_at) hari,
        SUM(total) total
    FROM pesanan
    $where
    GROUP BY DAY(created_at)
    ORDER BY DAY(created_at)
    ");

    while($r=mysqli_fetch_assoc($queryGrafik)){
        $label[]=$r['hari'];
        $data[]=$r['total'];
    }

}elseif($tahun!=""){

    $namaBulan=[
        1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",
        5=>"Mei",6=>"Jun",7=>"Jul",8=>"Agu",
        9=>"Sep",10=>"Okt",11=>"Nov",12=>"Des"
    ];

    $queryGrafik=mysqli_query($conn,"
    SELECT
        MONTH(created_at) bulan,
        SUM(total) total
    FROM pesanan
    $where
    GROUP BY MONTH(created_at)
    ORDER BY MONTH(created_at)
    ");

    while($r=mysqli_fetch_assoc($queryGrafik)){
        $label[]=$namaBulan[$r['bulan']];
        $data[]=$r['total'];
    }

}else{

    $queryGrafik=mysqli_query($conn,"
    SELECT
        DATE(created_at) tanggal,
        SUM(total) total
    FROM pesanan
    $where
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at)
    ");

    while($r=mysqli_fetch_assoc($queryGrafik)){
        $label[]=date("d M",strtotime($r['tanggal']));
        $data[]=$r['total'];
    }

}


?>

<div>

<section class="content-header">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h2 class="fw-bold">

<i class="fas fa-home text-primary"></i>

Dashboard Admin

</h2>

</div>

</div>

</section>

<div class="content-wrapper">

<div class="container-fluid">

<div class="row">

    <!-- Kategori -->

    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card shadow border-0 bg-primary text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <h6>Total Kategori</h6>

                        <h2 class="fw-bold">

                            <?= number_format($totalKategori); ?>

                        </h2>

                    </div>

                    <i class="fas fa-list fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Menu -->

    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card shadow border-0 bg-success text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <h6>Total Menu</h6>

                        <h2 class="fw-bold">

                            <?= number_format($totalMenu); ?>

                        </h2>

                    </div>

                    <i class="fas fa-mug-hot fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Pesanan -->

    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card shadow border-0 bg-warning text-dark">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <h6>Total Pesanan</h6>

                        <h2 class="fw-bold">

                            <?= number_format($totalPesanan); ?>

                        </h2>

                    </div>

                    <i class="fas fa-shopping-cart fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Pendapatan -->

    <div class="col-lg-3 col-md-6 mb-4">

        <div class="card shadow border-0 bg-danger text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <h6>Total Pendapatan</h6>

                        <h4 class="fw-bold">

                            Rp <?= number_format($pendapatan,0,",","."); ?>

                        </h4>

                    </div>

                    <i class="fas fa-wallet fa-3x opacity-50"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- ========================= -->

<!-- ========================= -->
<!-- RINGKASAN SISTEM -->
<!-- ========================= -->

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-white">
        <h5 class="mb-0">Ringkasan Sistem</h5>
    </div>

    <div class="card-body">

        <div class="row">

            <!-- Ringkasan -->
            <div class="col-md-6">

                <table class="table table-bordered">

                    <tr>
                        <th>Total Kategori</th>
                        <td><?= $totalKategori; ?></td>
                    </tr>

                    <tr>
                        <th>Total Menu</th>
                        <td><?= $totalMenu; ?></td>
                    </tr>

                    <tr>
                        <th>Total Pesanan</th>
                        <td><?= $totalPesanan; ?></td>
                    </tr>

                    <tr>
                        <th>Pesanan Selesai</th>
                        <td><?= $totalSelesai; ?></td>
                    </tr>

                    <tr>
                        <th>Total Pendapatan</th>
                        <td>
                            <strong>
                                Rp <?= number_format($pendapatan,0,",","."); ?>
                            </strong>
                        </td>
                    </tr>

                </table>

            </div>

            <!-- Logo -->
            <div class="col-md-6 text-center">

                <i class="fas fa-coffee text-primary" style="font-size:140px;"></i>

                <h4 class="mt-3">
                    Coffee Sigma Admin Panel
                </h4>

                <p class="text-muted">
                    Kelola kategori, menu, pesanan, dan laporan penjualan melalui dashboard ini.
                </p>

            </div>

        </div>

    </div>

</div>

<!-- ========================= -->
<!-- GRAFIK PENDAPATAN -->
<!-- ========================= -->

<!-- ========================= -->
<!-- GRAFIK PENDAPATAN -->
<!-- ========================= -->

<div class="card shadow border-0 mb-4">

    <div class="card-header bg-white">
        <h5 class="mb-0">
            Grafik Pendapatan
        </h5>
    </div>

    <div class="card-body">

        <!-- FILTER -->
        <form method="GET" class="mb-4">

            <div class="row">

                <div class="col-md-3">
                    <label class="form-label">Tanggal</label>
                    <input
                        type="date"
                        name="tanggal"
                        class="form-control"
                        value="<?= $tanggal; ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Bulan</label>

                    <select
                        name="bulan"
                        class="form-select">

                        <option value="">Semua</option>

                        <?php
                        for($i=1;$i<=12;$i++){
                        ?>

                        <option
                            value="<?= $i; ?>"
                            <?= ($bulan==$i) ? 'selected' : ''; ?>>

                            <?= date("F", mktime(0,0,0,$i,1)); ?>

                        </option>

                        <?php } ?>

                    </select>
                </div>

                <div class="col-md-3">

                    <label class="form-label">Tahun</label>

                    <select
                        name="tahun"
                        class="form-select">

                        <option value="">Semua</option>

                        <?php

                        $query = mysqli_query($conn,"
                        SELECT DISTINCT YEAR(created_at) AS tahun
                        FROM pesanan
                        ORDER BY tahun DESC
                        ");

                        while($t = mysqli_fetch_assoc($query)){
                        ?>

                        <option
                            value="<?= $t['tahun']; ?>"
                            <?= ($tahun==$t['tahun']) ? 'selected' : ''; ?>>

                            <?= $t['tahun']; ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="col-md-3 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-danger me-2">

                        <i class="fas fa-filter"></i>
                        Filter

                    </button>

                    <a
                        href="dashboard.php"
                        class="btn btn-secondary">

                        <i class="fas fa-sync-alt"></i>
                        Reset

                    </a>

                </div>

            </div>

        </form>

        <!-- CHART -->
        <div style="height:380px;">
            <canvas id="chartPendapatan"></canvas>
        </div>

    </div>

</div>

</div>



</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('chartPendapatan'),{

    type:'line',

    data:{

        labels: <?= json_encode($label); ?>,

        datasets:[{

            label:'Pendapatan',

            data: <?= json_encode($data); ?>,

            borderColor:'#6F4E37',

            backgroundColor:'rgba(111,78,55,0.15)',

            borderWidth:3,

            fill:true,

            tension:.4,

            pointRadius:4

        }]

    },

    options:{

        responsive:true,

        maintainAspectRatio:false,

        plugins:{
            legend:{
                display:false
            }
        },

        scales:{
            y:{
                beginAtZero:true,
                ticks:{
                    callback:function(value){
                        return 'Rp '+value.toLocaleString('id-ID');
                    }
                }
            }
        }

    }

});

</script>

<?php
include("template/footer.php");
?>