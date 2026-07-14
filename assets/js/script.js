/* ===========================================
   COFFEE SIGMA
=========================================== */

document.addEventListener("DOMContentLoaded", function () {
  // =======================================
  // FILTER KATEGORI
  // =======================================

  const kategoriBtn = document.querySelectorAll(".nav-link[data-id]");
  const menuCard = document.querySelectorAll(".menu-item");

  function filterKategori(id) {
    menuCard.forEach((card) => {
      if (id === "all" || card.dataset.kategori === id) {
        card.style.display = "";
      } else {
        card.style.display = "none";
      }
    });
  }

  kategoriBtn.forEach((btn) => {
    btn.addEventListener("click", function () {
      kategoriBtn.forEach((item) => item.classList.remove("active"));

      this.classList.add("active");

      filterKategori(this.dataset.id);
    });
  });

  // Jalankan otomatis saat pertama kali halaman dibuka
  const aktif = document.querySelector(".nav-link.active");

  if (aktif) {
    filterKategori(aktif.dataset.id);
  }
  // ===========================
  // Tampilkan cart saat refresh
  // ===========================

  updateCart();
});

/* ===========================================
   KERANJANG
=========================================== */

let cart = JSON.parse(localStorage.getItem("cart")) || [];

/* ===========================================
   SIMPAN CART
=========================================== */

function simpanCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

/* ===========================================
   TAMBAH KE KERANJANG
=========================================== */

document.addEventListener("click", function (e) {
  const btn = e.target.closest(".btn-add");

  if (!btn) return;

  const id = btn.dataset.id;
  const nama = btn.dataset.nama;
  const harga = parseInt(btn.dataset.harga);

  let item = cart.find((x) => x.id == id);

  if (item) {
    item.qty++;
  } else {
    cart.push({
      id: id,
      nama: nama,
      harga: harga,
      qty: 1,
    });
  }

  simpanCart();
  updateCart();
});

/* ===========================================
   TAMBAH PRODUK
=========================================== */

/* ===========================================
   PLUS
=========================================== */

function tambahQty(id) {
  let item = cart.find((x) => x.id == id);

  if (!item) return;

  item.qty++;

  simpanCart();
  updateCart();
}

/* ===========================================
   MINUS
=========================================== */

function kurangQty(id) {
  let item = cart.find((x) => x.id == id);

  if (!item) return;

  item.qty--;

  if (item.qty <= 0) {
    cart = cart.filter((x) => x.id != id);
  }

  simpanCart();
  updateCart();
}

/* ===========================================
   UPDATE CART
=========================================== */

function updateCart() {
  let body = document.getElementById("cartBody");

  if (!body) return;

  body.innerHTML = "";

  if (cart.length === 0) {
    body.innerHTML = `
      <div class="text-center text-secondary">
          Belum ada pesanan.
      </div>
  `;

    document.getElementById("subtotal").innerHTML = "Rp 0";
    document.getElementById("layanan").innerHTML = "Rp 0";
    document.getElementById("total").innerHTML = "Rp 0";
    document.getElementById("badge-cart").innerHTML = "0";

    const btn = document.querySelector(".btn-pesan");

    if (btn) {
      btn.disabled = true;
    }

    return;
  }

  let subtotal = 0;

  cart.forEach((item) => {
    subtotal += item.harga * item.qty;

    body.innerHTML += `

        <div class="cart-item border rounded-3 p-3 mb-3 shadow-sm">

            <div class="d-flex justify-content-between">

                <div>

                    <strong>${item.nama}</strong>

                    <br>

                    Rp ${formatRupiah(item.harga)}

                </div>

                <div>

                    <button class="btn btn-sm btn-warning"
                    onclick="kurangQty(${item.id})">-</button>

                    <span class="mx-2">

                        ${item.qty}

                    </span>

                    <button class="btn btn-sm btn-warning"
                    onclick="tambahQty(${item.id})">+</button>

                </div>

            </div>

        </div>

        `;
  });

  let layanan = cart.length > 0 ? 2000 : 0;

  let total = subtotal + layanan;

  document.getElementById("subtotal").innerHTML =
    "Rp " + formatRupiah(subtotal);

  document.getElementById("layanan").innerHTML = "Rp " + formatRupiah(layanan);

  document.getElementById("total").innerHTML = "Rp " + formatRupiah(total);

  document.getElementById("badge-cart").innerHTML = totalItem();

  const btn = document.querySelector(".btn-pesan");

  if (btn) {
    btn.disabled = false;
  }
}

/* ===========================================
   TOTAL ITEM
=========================================== */

function totalItem() {
  let total = 0;

  cart.forEach((item) => {
    total += item.qty;
  });

  return total;
}

/* ===========================================
   FORMAT RUPIAH
=========================================== */

function formatRupiah(angka) {
  return angka.toLocaleString("id-ID");
}

/* ===========================================
   MENUJU HALAMAN CHECKOUT
=========================================== */

function menujuCheckout() {
  if (cart.length === 0) {
    alert("Keranjang masih kosong!");

    return;
  }

  // simpan cart terbaru
  simpanCart();

  // pindah halaman
  window.location.href = "checkout.php";
}
