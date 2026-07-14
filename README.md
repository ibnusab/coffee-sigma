# ☕ Coffee Sigma

<p align="center">
  <img src="assets/logo.png" alt="Coffee Sigma Logo" width="150">
</p>

<p align="center">
  <b>Website Pemesanan Kopi Berbasis PHP Native & MySQL</b>
</p>

---

## 📖 Tentang Project

Coffee Sigma adalah website pemesanan kopi yang dikembangkan menggunakan **PHP Native**, **MySQL**, **Bootstrap**, dan **JavaScript**.

Aplikasi ini memiliki dua sisi utama:

- 👨‍💼 **Admin Dashboard**
- 👤 **Customer Website**

Admin dapat mengelola produk, pesanan, kategori, serta memantau aktivitas penjualan, sedangkan customer dapat melihat menu dan melakukan pemesanan secara online.

---

# ✨ Fitur

## 👨‍💼 Admin

- Dashboard
- Login Admin
- CRUD Menu
- CRUD Kategori
- Kelola Pesanan
- Update Status Pesanan
- Laporan Penjualan
- Upload Gambar Menu

## 👤 Customer

- Home
- Daftar Menu
- Detail Produk
- Keranjang Belanja
- Checkout
- Riwayat Pesanan

---

# 🛠️ Teknologi

- PHP Native
- MySQL
- phpMyAdmin
- XAMPP
- Bootstrap 5
- HTML5
- CSS3
- JavaScript
- Composer

---

# 📂 Struktur Folder

```text
coffee-sigma/
│
├── admin/
├── assets/
├── config/
├── customer/
├── vendor/
├── composer.json
├── composer.lock
├── index.php
└── README.md
```

---

# ⚙️ Persyaratan

- PHP 8+
- MySQL
- XAMPP
- Composer

---

# 🚀 Cara Menjalankan Project

### 1. Clone Repository

```bash
git clone https://github.com/ibnusab452-blip/coffee-sigma.git
```

---

### 2. Pindahkan Project

Salin project ke folder:

```
xampp/htdocs/
```

---

### 3. Import Database

1. Jalankan Apache dan MySQL pada XAMPP.
2. Buka phpMyAdmin.
3. Buat database:

```
coffee_sigma
```

4. Import file SQL yang tersedia.

---

### 4. Konfigurasi Database

Sesuaikan file konfigurasi pada folder:

```
config/
```

Contoh:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "coffee_sigma";
```

---

### 5. Jalankan Project

Buka browser:

```
http://localhost/coffee-sigma/
```

---

# 📸 Tampilan

Tambahkan screenshot aplikasi pada folder berikut:

```
assets/screenshots/
```

Contoh:

- Home
- Login
- Dashboard
- Menu
- Checkout
- Pesanan

---

# 👨‍💻 Developer

**Ibnu Sabrian**

Mahasiswa Sistem Informasi

STMIK Widya Utama

GitHub

https://github.com/ibnusab452-blip

---

# 📜 License

Project ini dibuat untuk keperluan pembelajaran, tugas kuliah, dan pengembangan portofolio.

---

⭐ Jangan lupa berikan Star apabila repository ini bermanfaat.
