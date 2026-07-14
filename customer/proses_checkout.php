<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header("Content-Type: application/json");

include "../config/koneksi.php";

/* ======================================================
   AMBIL DATA JSON
====================================================== */

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {

    echo json_encode([
        "status" => "error",
        "message" => "Data JSON tidak valid."
    ]);

    exit;
}

/* ======================================================
   AMBIL DATA
====================================================== */

$nama = mysqli_real_escape_string(
    $conn,
    trim($data['nama_pelanggan'] ?? "")
);

$tipe = mysqli_real_escape_string(
    $conn,
    trim($data['tipe_pesanan'] ?? "")
);

$nomor_meja = mysqli_real_escape_string(
    $conn,
    trim($data['nomor_meja'] ?? "")
);

$catatan = mysqli_real_escape_string(
    $conn,
    trim($data['catatan'] ?? "")
);

$metode = mysqli_real_escape_string(
    $conn,
    trim($data['metode_pembayaran'] ?? "")
);

$cart = $data['cart'] ?? [];

/* ======================================================
   VALIDASI
====================================================== */

if ($nama == "") {

    echo json_encode([
        "status" => "error",
        "message" => "Nama pelanggan wajib diisi."
    ]);

    exit;
}

if ($tipe == "") {

    echo json_encode([
        "status" => "error",
        "message" => "Tipe pesanan belum dipilih."
    ]);

    exit;
}

if ($metode == "") {

    echo json_encode([
        "status" => "error",
        "message" => "Metode pembayaran belum dipilih."
    ]);

    exit;
}

if (empty($cart)) {

    echo json_encode([
        "status" => "error",
        "message" => "Keranjang masih kosong."
    ]);

    exit;
}

if ($tipe == "Takeaway") {

    $nomor_meja = "";

} else {

    if ($nomor_meja == "") {

        echo json_encode([
            "status" => "error",
            "message" => "Nomor meja wajib diisi."
        ]);

        exit;
    }

}

/* ======================================================
   HITUNG TOTAL
====================================================== */

$subtotal = 0;

foreach ($cart as $item) {

    $subtotal += ((int)$item['harga']) * ((int)$item['qty']);

}

$biaya_layanan = 2000;

$total = $subtotal + $biaya_layanan;

/* ======================================================
   BUAT KODE PESANAN
====================================================== */

$kode_pesanan =
    "ORD-" .
    date("YmdHis") .
    rand(100,999);

/* ======================================================
   TRANSAKSI DATABASE
====================================================== */
$created_at = date("Y-m-d H:i:s");

mysqli_begin_transaction($conn);

try {

    /* ==================================================
       INSERT PESANAN
    ================================================== */

    $insert = mysqli_query($conn, "

        INSERT INTO pesanan(

            kode_pesanan,
            nama_pelanggan,
            tipe_pesanan,
            nomor_meja,
            catatan,
            metode_pembayaran,
            status_pembayaran,
            subtotal,
            biaya_layanan,
            total,
            status,
            created_at

        )

        VALUES(

            '$kode_pesanan',
            '$nama',
            '$tipe',
            '$nomor_meja',
            '$catatan',
            '$metode',
            'Belum Bayar',
            '$subtotal',
            '$biaya_layanan',
            '$total',
            'Pending',
'$created_at'

        )

    ");

    if (!$insert) {

        throw new Exception(mysqli_error($conn));

    }

    $pesanan_id = mysqli_insert_id($conn);

    /* ==================================================
       SIMPAN DETAIL
    ================================================== */

    foreach ($cart as $item) {

        $menu_id = (int)$item['id'];

        $qty = (int)$item['qty'];

        /* ==========================================
           CEK MENU
        ========================================== */

        $cek = mysqli_query($conn, "

            SELECT
                nama_menu,
                harga,
                stok
            FROM menu
            WHERE id='$menu_id'
            LIMIT 1

        ");

        if (!$cek || mysqli_num_rows($cek) == 0) {

            throw new Exception("Menu tidak ditemukan.");

        }

        $menu = mysqli_fetch_assoc($cek);

        if ($menu['stok'] < $qty) {

            throw new Exception(
                "Stok ".$menu['nama_menu']." tidak mencukupi."
            );

        }

        $harga = $menu['harga'];

        $sub = $harga * $qty;

        /* ==========================================
           INSERT DETAIL
        ========================================== */

        $detail = mysqli_query($conn, "

            INSERT INTO detail_pesanan(

                pesanan_id,
                menu_id,
                qty,
                harga,
                subtotal

            )

            VALUES(

                '$pesanan_id',
                '$menu_id',
                '$qty',
                '$harga',
                '$sub'

            )

        ");

        if (!$detail) {

            throw new Exception(mysqli_error($conn));

        }

        /* ==========================================
           UPDATE STOK
        ========================================== */

        $update = mysqli_query($conn, "

            UPDATE menu

            SET stok = stok - $qty

            WHERE id='$menu_id'

        ");

        if (!$update) {

            throw new Exception(mysqli_error($conn));

        }

    }

    /* ==================================================
       COMMIT
    ================================================== */

    mysqli_commit($conn);

// Ambil lagi data yang baru saja disimpan
$cekPesanan = mysqli_query($conn, "
    SELECT *
    FROM pesanan
    WHERE id = '$pesanan_id'
");

$dataPesanan = mysqli_fetch_assoc($cekPesanan);

echo json_encode([

    "status" => "success",

    "message" => "Pesanan berhasil dibuat.",

    // kode yang dibuat PHP
    "kode_pesanan" => $kode_pesanan,

    // kode yang benar-benar tersimpan di database
    "kode_database" => $dataPesanan['kode_pesanan'],

    "pesanan_id" => $pesanan_id,

    "subtotal" => $subtotal,

    "biaya_layanan" => $biaya_layanan,

    "total" => $total

]);

exit;

} catch (Exception $e) {

    mysqli_rollback($conn);

    echo json_encode([

        "status" => "error",

        "message" => $e->getMessage()

    ]);

}