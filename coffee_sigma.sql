-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2026 at 11:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee_sigma`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Administrator', 'adm', '123', '2026-07-03 06:41:33');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id`, `pesanan_id`, `menu_id`, `qty`, `harga`, `subtotal`) VALUES
(2, 9, 3, 1, 20000, 20000),
(3, 10, 3, 2, 20000, 40000),
(4, 11, 3, 1, 20000, 20000),
(5, 12, 3, 1, 20000, 20000),
(6, 13, 3, 1, 20000, 20000),
(7, 14, 3, 1, 20000, 20000),
(8, 15, 3, 1, 20000, 20000),
(9, 16, 3, 1, 20000, 20000),
(10, 17, 3, 1, 20000, 20000),
(11, 18, 3, 1, 20000, 20000),
(12, 19, 3, 1, 20000, 20000),
(13, 20, 7, 1, 17000, 17000),
(14, 20, 16, 1, 20000, 20000),
(15, 20, 17, 1, 23000, 23000),
(16, 20, 6, 1, 15000, 15000),
(17, 21, 8, 1, 20000, 20000),
(18, 21, 12, 1, 13000, 13000),
(19, 22, 19, 1, 21000, 21000),
(20, 22, 11, 1, 20000, 20000),
(21, 23, 7, 1, 17000, 17000),
(22, 23, 16, 1, 20000, 20000),
(23, 24, 4, 1, 15000, 15000),
(24, 25, 8, 1, 20000, 20000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Coffee'),
(3, 'Snacks & Food'),
(4, 'Matcha');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `stok` int(11) DEFAULT 100,
  `badge` enum('none','Best Seller','New','Signature') DEFAULT 'none',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `kategori_id`, `nama_menu`, `deskripsi`, `harga`, `gambar`, `stok`, `badge`, `status`) VALUES
(3, 1, 'Sigma Coffe', 'terbuat dari biji gue', 20000, '1783062673_7178.jpg', 87, 'Signature', 'aktif'),
(4, 1, 'Espresso', 'Kopi hitam murni yang disajikan dalam cangkir kecil (shot). Rasanya sangat pekat, kental, dan pahit', 15000, '1783099728_4516.jpg', 99, 'New', 'aktif'),
(5, 1, 'Americano', 'Espresso yang dicampur dengan air panas sehingga rasanya lebih ringan dan mirip kopi hitam biasa. Bisa disajikan panas maupun dingin (es).', 12000, '1783100024_1216.jpg', 100, 'Best Seller', 'aktif'),
(6, 1, 'Caramel Macchiato', 'Espresso yang diberi campuran susu dan sirup karamel manis', 15000, '1783100117_3537.jpg', 99, 'New', 'aktif'),
(7, 1, 'Mochaccino', 'Campuran espresso, susu panas, dan cokelat. Sangat cocok untuk Anda yang menyukai perpaduan rasa kopi dan cokelat yang manis.', 17000, '1783100230_9884.jpg', 98, 'New', 'aktif'),
(8, 1, 'Cold Brew', 'Kopi yang diseduh menggunakan air dingin selama belasan jam. Teksturnya sangat lembut dan tingkat keasamannya (acidity) rendah.', 20000, '1783100328_4400.jpg', 98, 'none', 'aktif'),
(9, 4, 'Matcha Latte', 'Campuran bubuk matcha, susu segar, dan es batu. Varian ini bisa dipadukan dengan pemanis seperti sirup vanilla atau madu.', 16000, '1783100574_9199.jpg', 100, 'New', 'aktif'),
(10, 4, 'Dirty Matcha', 'Kombinasi matcha latte dengan satu shot espresso, memberikan rasa yang lebih tebal dan kafein yang lebih kuat.', 17000, '1783100666_4843.jpg', 100, 'Signature', 'aktif'),
(11, 4, 'Iced Blended Matcha', 'Matcha yang diblender dengan es dan biasanya disajikan dengan tambahan whipped cream.', 20000, '1783100757_2476.jpg', 99, 'New', 'aktif'),
(12, 4, 'Pure Matcha', 'Matcha murni yang dikocok dengan air panas atau dingin tanpa campuran susu.', 13000, '1783100807_2582.jpg', 99, 'none', 'aktif'),
(13, 3, 'French Fries & Wedges', 'Kentang goreng klasik atau potongan kentang tebal.', 15000, '1783101004_6948.jpg', 100, 'Best Seller', 'aktif'),
(14, 3, 'Roti Bakar', 'Pilihan klasik dengan berbagai isian seperti selai srikaya, cokelat meses, atau keju.', 10000, '1783101095_7866.jpg', 100, 'New', 'aktif'),
(15, 3, 'Croissant', 'Kue berlapis mentega yang renyah dan cocok dipadukan dengan kopi hitam atau latte.', 13000, '1783101154_3120.jpg', 100, 'Best Seller', 'aktif'),
(16, 3, 'Brownies', 'Kue cokelat padat dan legit, sangat cocok dipadukan dengan es kopi atau Americano.', 20000, '1783101259_3880.jpg', 98, 'Signature', 'aktif'),
(17, 3, 'Sandwich & Toast', 'Roti panggang dengan isian daging, keju, dan sayuran (seperti Avocado Toast dan Club Sandwich).', 23000, '1783101390_5168.jpg', 49, 'Signature', 'aktif'),
(18, 3, 'Burger', 'Burger daging dengan lelehan keju dan selada.', 20000, '1783101481_9544.jpg', 50, 'Best Seller', 'aktif'),
(19, 3, 'Rice Bowl', 'Nasi dengan topping ayam saus teriyaki, sambal matah, atau beef bowl.', 21000, '1783101547_6551.jpg', 49, 'Signature', 'aktif'),
(20, 3, 'Pasta', 'Makanan ringan yang gurih dan padat', 22000, '1783101637_4721.jpg', 50, 'Signature', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `kode_pesanan` varchar(40) DEFAULT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `tipe_pesanan` enum('Dine In','Takeaway') NOT NULL,
  `nomor_meja` varchar(20) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `metode_pembayaran` enum('Tunai','Transfer Bank','QRIS') NOT NULL DEFAULT 'Tunai',
  `status_pembayaran` enum('Belum Bayar','Sudah Bayar') NOT NULL DEFAULT 'Belum Bayar',
  `subtotal` int(11) NOT NULL,
  `biaya_layanan` int(11) DEFAULT 5000,
  `total` int(11) NOT NULL,
  `status` enum('Pending','Diproses','Selesai','Dibatalkan') DEFAULT 'Pending',
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `kode_pesanan`, `nama_pelanggan`, `tipe_pesanan`, `nomor_meja`, `catatan`, `metode_pembayaran`, `status_pembayaran`, `subtotal`, `biaya_layanan`, `total`, `status`, `created_at`) VALUES
(9, 'ORD-2026070316082985', 'Neymar', 'Takeaway', '', 'no sugar dady', 'Transfer Bank', 'Sudah Bayar', 20000, 5000, 25000, 'Selesai', '2026-07-03 16:08:29'),
(10, 'ORD-2026070316100157', 'Pep Guardiola', 'Takeaway', '', 'es', 'Tunai', 'Sudah Bayar', 40000, 5000, 45000, 'Selesai', '2026-07-03 16:10:01'),
(11, 'ORD-2026070321141184', 'Rudi', 'Dine In', 'a4', 'oke', 'Tunai', 'Sudah Bayar', 20000, 5000, 25000, 'Selesai', '2026-07-03 21:14:11'),
(12, 'ORD-2026070321232934', 'messi', 'Dine In', 'a4', 'oke', 'Tunai', 'Sudah Bayar', 20000, 5000, 25000, 'Selesai', '2026-07-03 21:23:29'),
(13, 'ORD-2026070321304436', 'ibnu', 'Dine In', 'a4', 'oke', 'Tunai', 'Sudah Bayar', 20000, 5000, 25000, 'Selesai', '2026-07-03 21:30:44'),
(14, 'ORD-2026070321373224', 'ibnu', 'Dine In', 'a4', 'sip', 'Tunai', 'Sudah Bayar', 20000, 5000, 25000, 'Selesai', '2026-07-03 21:37:32'),
(15, 'ORD-2026070321524683', 'messi', 'Dine In', 'a4', 'ok', 'Tunai', 'Sudah Bayar', 20000, 2000, 22000, 'Selesai', '2026-07-03 21:52:46'),
(16, 'ORD-2026070321585136', 'neymar', 'Dine In', 'a4', 'oke', 'Tunai', 'Sudah Bayar', 20000, 2000, 22000, 'Selesai', '2026-07-03 21:58:51'),
(17, 'ORD-20260703220300780', 'budi', 'Dine In', 'a4', 'oke', 'Tunai', 'Sudah Bayar', 20000, 2000, 22000, 'Selesai', '2026-07-03 22:03:00'),
(18, 'ORD-20260703220658911', 'sigma', 'Dine In', 'a4', 'oke', 'Tunai', 'Sudah Bayar', 20000, 2000, 22000, 'Selesai', '2026-07-03 22:06:58'),
(19, 'ORD-20260704000728627', 'Mohamed Salah', 'Takeaway', '', 'oke', 'QRIS', 'Sudah Bayar', 20000, 2000, 22000, 'Selesai', '2026-07-04 00:07:28'),
(20, 'ORD-20260704010307828', 'sigma boy', 'Dine In', '08', 'mantap bosq', 'QRIS', 'Sudah Bayar', 75000, 2000, 77000, 'Selesai', '2026-07-04 01:03:07'),
(21, 'ORD-20260704143600857', 'Neymar', 'Takeaway', '', 'sip', 'Tunai', 'Sudah Bayar', 33000, 2000, 35000, 'Selesai', '2026-07-04 14:36:00'),
(22, 'ORD-20260704145551985', 'Pep Guardiola', 'Takeaway', '', 'sip', 'Transfer Bank', 'Sudah Bayar', 41000, 2000, 43000, 'Selesai', '2026-07-04 14:55:51'),
(23, 'ORD-20260704153250529', 'Ibnu Sabrian', 'Dine In', 'A8', 'no sugar', 'Tunai', 'Sudah Bayar', 37000, 2000, 39000, 'Selesai', '2026-07-04 15:32:50'),
(24, 'ORD-20260704182437240', 'dodo', 'Dine In', 'A2', 'tanpa gula', 'QRIS', 'Sudah Bayar', 15000, 2000, 17000, 'Selesai', '2026-07-04 18:24:37'),
(25, 'ORD-20260705144021335', 'Ibnu Sabrian', 'Takeaway', '', 'oke', 'Tunai', 'Sudah Bayar', 20000, 2000, 22000, 'Selesai', '2026-07-05 14:40:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pesanan` (`pesanan_id`),
  ADD KEY `fk_menu` (`menu_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pesanan` (`kode_pesanan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `fk_menu` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`),
  ADD CONSTRAINT `fk_pesanan` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
