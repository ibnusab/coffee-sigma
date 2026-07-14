<?php
// customer/checkout.php
?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - Coffee Sigma</title>
     <link rel="icon" type="image/png" href="../assets/img/logo.png">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">

    <style>
        body {

            background: #1f140d;

            color: #fff;

            min-height: 100vh;

        }

        .checkout-card {

            background: #2a1b12;

            border: 1px solid rgba(255, 193, 7, .15);

            border-radius: 20px;

            padding: 25px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .35);

        }

        .form-control,
        .form-select {

            background: #3a281d;

            border: 1px solid #5d4333;

            color: #fff;

        }

        .form-control:focus,
        .form-select:focus {

            background: #3a281d;

            color: #fff;

            border-color: #ffc107;

            box-shadow: none;

        }

        .form-control::placeholder {

            color: #bbb;

        }

        .summary-item {

            background: #3a281d;

            border-radius: 15px;

            padding: 12px 15px;

            margin-bottom: 12px;

        }

        .summary-item:last-child {

            margin-bottom: 0;

        }

        .total-box {

            border-top: 1px dashed rgba(255,255,255,.2);

            margin-top: 15px;

            padding-top: 15px;

        }

        .btn-warning {

            font-weight: 600;

        }

        .meja-group{

            display:none;

        }

        .payment-card{

            border:1px solid rgba(255,255,255,.15);

            border-radius:15px;

            padding:15px;

            margin-bottom:12px;

            cursor:pointer;

            transition:.25s;

        }

        .payment-card:hover{

            border-color:#ffc107;

        }

        .payment-card.active{

            border:2px solid #ffc107;

            background:#3a281d;

        }

        @media(max-width:768px){

            .checkout-card{

                padding:18px;

            }

        }
    </style>

</head>

<body>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                <i class="fa-solid fa-mug-hot text-warning"></i>

                Checkout Pesanan

            </h3>

            <small class="text-secondary">

                Coffee Sigma

            </small>

        </div>

        <a href="index.php" class="btn btn-outline-warning">

            <i class="fa-solid fa-arrow-left"></i>

            Kembali

        </a>

    </div>

    <div class="row g-4">

        <!-- ============================= -->
        <!-- FORM -->
        <!-- ============================= -->

        <div class="col-lg-7">

            <div class="checkout-card">

                <h5 class="mb-4">

                    Data Pemesan

                </h5>

                <form id="checkoutForm">

                    <div class="mb-3">

                        <label class="form-label">

                            Nama Pelanggan

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="nama"
                            placeholder="Masukkan nama">

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Tipe Pesanan

                        </label>

                        <select
                            class="form-select"
                            id="tipe">

                            <option value="Dine In">

                                Dine In

                            </option>

                            <option value="Takeaway">

                                Takeaway

                            </option>

                        </select>

                    </div>

                    <div class="mb-3 meja-group" id="mejaGroup">

    <label class="form-label">
        Nomor Meja
    </label>

    <select class="form-select" id="nomor_meja">
        <option value="">-- Pilih Nomor Meja --</option>

        <optgroup label="Area A">
            <option value="A1">Meja A1</option>
            <option value="A2">Meja A2</option>
            <option value="A3">Meja A3</option>
            <option value="A4">Meja A4</option>
            <option value="A5">Meja A5</option>
        </optgroup>

        <optgroup label="Area B">
            <option value="B1">Meja B1</option>
            <option value="B2">Meja B2</option>
            <option value="B3">Meja B3</option>
            <option value="B4">Meja B4</option>
            <option value="B5">Meja B5</option>
        </optgroup>

        <optgroup label="Outdoor">
            <option value="O1">Outdoor 1</option>
            <option value="O2">Outdoor 2</option>
            <option value="O3">Outdoor 3</option>
            <option value="O4">Outdoor 4</option>
        </optgroup>
    </select>

</div>

                    <div class="mb-3">

                        <label class="form-label">

                            Catatan

                        </label>

                        <textarea
                            id="catatan"
                            rows="4"
                            class="form-control"
                            placeholder="Contoh: tanpa gula, kurang es..."></textarea>

                    </div>

                    <hr class="border-secondary">

                    <h5 class="mb-3">

                        Metode Pembayaran

                    </h5>

                    <div class="payment-card active"
                        data-metode="Tunai">

                        <input
                            class="form-check-input me-2"
                            type="radio"
                            checked
                            name="payment">

                        <i class="fa-solid fa-money-bill-wave text-warning"></i>

                        Tunai

                    </div>

                    <div class="payment-card"
                        data-metode="Transfer Bank">

                        <input
                            class="form-check-input me-2"
                            type="radio"
                            name="payment">

                        <i class="fa-solid fa-building-columns text-warning"></i>

                        Transfer Bank

                    </div>

                    <div class="payment-card"
                        data-metode="QRIS">

                        <input
                            class="form-check-input me-2"
                            type="radio"
                            name="payment">

                        <i class="fa-solid fa-qrcode text-warning"></i>

                        QRIS

                    </div>

                    <button
                        type="submit"
                        class="btn btn-warning w-100 py-3 mt-4">

                        <i class="fa-solid fa-check"></i>

                        Buat Pesanan

                    </button>

                </form>

            </div>

        </div>

        <!-- ============================= -->
        <!-- RINGKASAN -->
        <!-- ============================= -->

        <div class="col-lg-5">

            <div class="checkout-card">

                <h5 class="mb-4">

                    Ringkasan Pesanan

                </h5>

                <div id="listPesanan">

                    <!-- otomatis dari JS -->

                </div>

                <div class="total-box">

                    <div class="d-flex justify-content-between mb-2">

                        <span>Subtotal</span>

                        <strong id="subtotal">

                            Rp 0

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-2">

                        <span>Biaya Layanan</span>

                        <strong id="layanan">

                            Rp 5.000

                        </strong>

                    </div>

                    <hr class="border-secondary">

                    <div class="d-flex justify-content-between">

                        <h5>Total</h5>

                        <h4 class="text-warning"
                            id="total">

                            Rp 0

                        </h4>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* ==========================================
   COFFEE SIGMA - CHECKOUT
========================================== */

let cart = JSON.parse(localStorage.getItem("cart")) || [];

const biayaLayanan = 5000;

const listPesanan = document.getElementById("listPesanan");
const subtotalEl = document.getElementById("subtotal");
const layananEl = document.getElementById("layanan");
const totalEl = document.getElementById("total");

const tipe = document.getElementById("tipe");
const mejaGroup = document.getElementById("mejaGroup");

let metodePembayaran = "Tunai";

/* ==========================================
   FORMAT RUPIAH
========================================== */

function rupiah(angka){

    return "Rp " + Number(angka).toLocaleString("id-ID");

}

/* ==========================================
   TAMPILKAN NOMOR MEJA
========================================== */

function updateMeja(){

    if(tipe.value === "Dine In"){

        mejaGroup.style.display = "block";

    }else{

        mejaGroup.style.display = "none";

        document.getElementById("nomor_meja").value="";

    }

}

updateMeja();

tipe.addEventListener("change",updateMeja);

/* ==========================================
   METODE PEMBAYARAN
========================================== */

document.querySelectorAll(".payment-card").forEach(card=>{

    card.addEventListener("click",function(){

        document.querySelectorAll(".payment-card").forEach(c=>{

            c.classList.remove("active");

            c.querySelector("input").checked=false;

        });

        this.classList.add("active");

        this.querySelector("input").checked=true;

        metodePembayaran=this.dataset.metode;

    });

});

/* ==========================================
   CART KOSONG
========================================== */

if(cart.length===0){

    alert("Keranjang masih kosong!");

    window.location.href="index.php";

}

/* ==========================================
   TAMPILKAN PESANAN
========================================== */

function loadCart(){

    listPesanan.innerHTML="";

    let subtotal=0;

    cart.forEach(item=>{

        let sub=item.harga*item.qty;

        subtotal+=sub;

        listPesanan.innerHTML+=`

        <div class="summary-item">

            <div class="d-flex justify-content-between">

                <div>

                    <strong>${item.nama}</strong>

                    <br>

                    <small>

                        ${rupiah(item.harga)} × ${item.qty}

                    </small>

                </div>

                <strong>

                    ${rupiah(sub)}

                </strong>

            </div>

        </div>

        `;

    });

    subtotalEl.innerHTML=rupiah(subtotal);

    layananEl.innerHTML=rupiah(biayaLayanan);

    totalEl.innerHTML=rupiah(subtotal+biayaLayanan);

}

loadCart();

/* ==========================================
   SUBMIT
========================================== */

document
.getElementById("checkoutForm")
.addEventListener("submit",function(e){

    e.preventDefault();

    const nama=document
    .getElementById("nama")
    .value
    .trim();

    const nomorMeja=document
    .getElementById("nomor_meja")
    .value
    .trim();

    const catatan=document
    .getElementById("catatan")
    .value
    .trim();

    if(nama===""){

        alert("Nama pelanggan wajib diisi.");

        return;

    }

    if(tipe.value==="Dine In" && nomorMeja===""){

        alert("Nomor meja wajib diisi.");

        return;

    }

    const btn=this.querySelector("button[type=submit]");

    btn.disabled=true;

    btn.innerHTML='<span class="spinner-border spinner-border-sm"></span> Memproses...';

    fetch("proses_checkout.php",{

        method:"POST",

        headers:{

            "Content-Type":"application/json"

        },

        body:JSON.stringify({

            nama_pelanggan:nama,

            tipe_pesanan:tipe.value,

            nomor_meja:nomorMeja,

            catatan:catatan,

            metode_pembayaran:metodePembayaran,

            cart:cart

        })

    })

    .then(res => res.json())

.then(res => {

    console.log("Response :", res);

    if (res.status === "success") {

        // hapus cart
        localStorage.removeItem("cart");

        // pastikan kode pesanan ada
        if (!res.kode_pesanan) {

            alert("Kode pesanan tidak diterima dari server.");

            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Buat Pesanan';

            return;

        }

        console.log("Kode Pesanan :", res.kode_pesanan);

        window.location.href =
            "detail_pesanan.php?kode=" +
            encodeURIComponent(res.kode_pesanan);

    } else {

        alert(res.message || "Gagal membuat pesanan.");

        btn.disabled = false;

        btn.innerHTML =
            '<i class="fa-solid fa-check"></i> Buat Pesanan';

    }

})

.catch(err => {

    console.error(err);

    alert("Terjadi kesalahan.");

    btn.disabled = false;

    btn.innerHTML =
        '<i class="fa-solid fa-check"></i> Buat Pesanan';

});
});
</script>

</body>
</html>