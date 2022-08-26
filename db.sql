-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 24 Agu 2022 pada 08.23
-- Versi server: 10.5.16-MariaDB-cll-lve
-- Versi PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u1592470_srikandi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('271ffc6980300822e43e3048410af69e', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661263271, ''),
('7d24cc68cf28e94cf298cfdc517d9897', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661263271, ''),
('9ed0ba09d80300d6a3d70603a51bff1e', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661261467, ''),
('48b46f5d58daf04e3fe2baf2c2da4e7d', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661261467, ''),
('e72628a9bcfa7fc12bf12974dfd579b0', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661261467, ''),
('c0a290abb327b39904c692de6ff5f7b2', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661261467, ''),
('ba0782a2b1fca5e783b6a0fee8c1ed00', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661257870, ''),
('bb54c14ea29b6d7bc60363beacd8495f', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661257870, ''),
('872d15834e713c906ce19d852eaaf5a1', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661259671, ''),
('0bfa51dbd5390a19fbe9a3dca2e7e8db', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661259671, ''),
('06114f329a14021257bdcb50aac7a7b9', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661259671, ''),
('12035407b3da8bb4d3d927d6ddbb1f72', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661259671, ''),
('95e11b1bfb28574b1c24deb6244a2d42', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661252466, ''),
('b7bba480aa4db7205cee914a8d71eed3', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661252466, ''),
('bc8bbad769708d0c7cce92f3e63b6f87', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661252467, ''),
('e616703cb3f31a9b3913b760c40eba02', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661252467, ''),
('62ddb952ba3978b37883657712634186', '125.167.56.43', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0', 1661252609, ''),
('423dabbe6c483dbaa35ca9e37f9beab2', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661257870, ''),
('206b9b96ca2c0b9dcda864ee94417ce1', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661257870, ''),
('87cd733de8dc31b6225fec93211f3281', '2001:448a:10e0:5a8b:1981:5160:a6f0:9dbf', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 1661255648, 'a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";}'),
('07763bbbcd5837d70778d7ac88ff7ccc', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661254271, ''),
('446ff2498c37c93b38869e0e8dca50c0', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661254271, ''),
('21694db29123a1ad033a07f04d961727', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661254271, ''),
('8bc6f5c1232190ddbd085e5a508506db', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661254271, ''),
('759b988339aaa8c8aeb6fd1e8eb427d0', '125.167.56.201', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:102.0) Gecko/20100101 Firefox/102.0', 1661254595, 'a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";}'),
('27007880f8484c3985a2c81d7ecdb9a0', '2001:448a:10e0:5a8b:1981:5160:a6f0:9dbf', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36 Edg', 1661256082, 'a:4:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:1:\"1\";s:5:\"level\";s:6:\"member\";}'),
('6d0e445c4583e6e5bfe18f7ccc7b086a', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661263271, ''),
('bff469ae06a38961206bb64b31e01f80', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661263271, ''),
('2abdbf3a90863a8eb46aed446b3982a5', '2001:448a:10e0:5a8b:8c0c:98ce:961:71b5', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:102.0) Gecko/20100101 Firefox/102.0', 1661264085, 'a:5:{s:9:\"user_data\";s:0:\"\";s:5:\"login\";b:1;s:6:\"u_name\";s:5:\"admin\";s:5:\"level\";s:5:\"admin\";s:16:\"flash:old:import\";s:5:\"BATAL\";}'),
('d60af1132f4880c85d0cca0728eaf09e', '2001:448a:10e0:5a8b:109c:aa45:3ae2:5c0b', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.5112.102 Safari/537.36 Edg', 1661264721, ''),
('fbab41f6dbefd4a2d27ec202819cae6f', '2001:448a:10e0:5a8b:109c:aa45:3ae2:5c0b', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/104.0.0.0 Safari/537.36', 1661264726, ''),
('2f0721d25bf90c3d95ebe42b9245ab92', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661265073, ''),
('726928a86d939dd177a2f165010eec4d', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661265073, ''),
('cd4c87b904941b2f14e9b970ca4ca74d', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661265073, ''),
('514febc50b8a863403c27dd15305819a', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661265073, ''),
('2317dbdc7bb54d953446ff22d60abad0', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661256068, ''),
('f3e36beb5f45bf1caff245780deac57b', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661256068, ''),
('1a99c4bdf3088b14d603f0ac155f89fd', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661256068, ''),
('a6075b92c85692424928e249bfb0ab52', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661256068, ''),
('3a894262e472c2523aed7eca88c6b2da', '2001:448a:10e0:5a8b:8c0c:98ce:961:71b5', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:102.0) Gecko/20100101 Firefox/102.0', 1661266135, ''),
('c511f08f26181a5bdcb34d11c1ce9127', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661274125, ''),
('d3f1b0edba1109b9f2f8654de346fbe7', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661274125, ''),
('537c54deeb86142e0ee658eb5ce004bd', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661275872, ''),
('ce882f04284b5d9d2974c0d2d9a40fb5', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661275872, ''),
('3d300c65a985e27049f4994ba196425e', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661277667, ''),
('80c7d4f9e06b21718b862b5c8c0688de', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661277667, ''),
('b235f41bc07946ed4243be2809c12c1e', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661279487, ''),
('c72b6cb48b84c72cb0621542073d1b42', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661279487, ''),
('a77cc750a2d48f863b11e37799e8a8a6', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661281272, ''),
('121ffcce888307c3367014c4089d142a', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661281272, ''),
('0f7e17db0cf5c50730abbbdcea119027', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661283068, ''),
('1c2b648e45c04bc8cdc8d4a42cb55b86', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661283068, ''),
('2ed2cf0391e8614d55355a2d16b48705', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661284869, ''),
('8f69e7f94b136e38e3f25465aab5c534', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661284869, ''),
('82c68d92d000cea66cb9af337a2f0df0', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661286737, ''),
('1840890b41907cdebe53a5fa4a13dde9', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661286737, ''),
('7b7d1019795b0c33bf28e50d2ad221ef', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661288468, ''),
('b16476688dd4f76bb2c2542bdaef91ea', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661288468, ''),
('31d84928aeddd73d350f787c547c5263', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661290269, ''),
('4405ca22498f51b6c2036032204d2197', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661290269, ''),
('ec3ad0745149450c3289f118174fbc3f', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661292070, ''),
('2329720e27c3de2b830beb89264f0bf2', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661292070, ''),
('71dc250dab25e2afe4c8ecec2b85ea04', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661293868, ''),
('5eacf41f46022c5340ab5e106c14b48c', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661293868, ''),
('79ca23cf36eb229ec2e3e3a4e2e9be46', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661295669, ''),
('ff71fd33da8dc39e76b977246c380dda', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661295669, ''),
('7a832de6eb30a09792dd92c43e475818', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661297468, ''),
('4cdeaa962cef821d658f74384dc26eab', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661297468, ''),
('ca11863f8e13bff12fb9da78880b47c2', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661299270, ''),
('35f98bbd251a6218fd5d58f946cbb9f2', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661299270, ''),
('15782e03b942d3597be0e9966fa9cb51', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661301071, ''),
('fb544d57b01caf831532761c17be8e01', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661301071, ''),
('f3efb79631c551daf187b36a22be0bd7', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661302868, ''),
('72be8bf8750a30cd9762408f86f9b5e1', '2a02:4780:3:2:13::83', 'Go-http-client/1.1', 1661302868, ''),
('8a1677f50c48e5cd1a00885e2934924c', '182.3.68.160', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:102.0) Gecko/20100101 Firefox/102.0', 1661303571, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jns_akun`
--

CREATE TABLE `jns_akun` (
  `id` bigint(20) NOT NULL,
  `kd_aktiva` varchar(5) DEFAULT NULL,
  `jns_trans` varchar(50) NOT NULL,
  `akun` enum('Aktiva','Pasiva') DEFAULT NULL,
  `laba_rugi` enum('','PENDAPATAN','BIAYA') NOT NULL DEFAULT '',
  `pemasukan` enum('Y','N') DEFAULT NULL,
  `pengeluaran` enum('Y','N') DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `jns_akun`
--

INSERT INTO `jns_akun` (`id`, `kd_aktiva`, `jns_trans`, `akun`, `laba_rugi`, `pemasukan`, `pengeluaran`, `aktif`) VALUES
(5, 'A4', 'Piutang Usaha', 'Aktiva', '', 'Y', 'Y', 'Y'),
(6, 'A5', 'Piutang Karyawan', 'Aktiva', '', 'N', 'Y', 'N'),
(7, 'A6', 'Pinjaman Anggota', 'Aktiva', '', NULL, NULL, 'Y'),
(8, 'A7', 'Piutang Anggota', 'Aktiva', '', 'Y', 'Y', 'N'),
(9, 'A8', 'Persediaan Barang', 'Aktiva', '', 'N', 'Y', 'Y'),
(10, 'A9', 'Biaya Dibayar Dimuka', 'Aktiva', '', 'N', 'Y', 'Y'),
(11, 'A10', 'Perlengkapan Usaha', 'Aktiva', '', 'N', 'Y', 'Y'),
(17, 'C', 'Aktiva Tetap Berwujud', 'Aktiva', '', NULL, NULL, 'Y'),
(18, 'C1', 'Peralatan Kantor', 'Aktiva', '', 'N', 'Y', 'Y'),
(19, 'C2', 'Inventaris Kendaraan', 'Aktiva', '', 'N', 'Y', 'Y'),
(20, 'C3', 'Mesin', 'Aktiva', '', 'N', 'Y', 'Y'),
(21, 'C4', 'Aktiva Tetap Lainnya', 'Aktiva', '', 'Y', 'N', 'Y'),
(26, 'E', 'Modal Pribadi', 'Aktiva', '', NULL, NULL, 'N'),
(27, 'E1', 'Prive', 'Pasiva', '', 'Y', 'Y', 'N'),
(28, 'F', 'Utang', 'Pasiva', '', NULL, NULL, 'Y'),
(29, 'F1', 'Utang Usaha', 'Pasiva', '', 'Y', 'Y', 'Y'),
(31, 'K3', 'Pembelian Barang', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(32, 'F4', 'Simpanan Sukarela', 'Pasiva', '', 'Y', 'Y', 'Y'),
(33, 'F5', 'Utang Pajak', 'Pasiva', '', 'Y', 'Y', 'Y'),
(36, 'H', 'Utang Jangka Panjang', 'Pasiva', '', NULL, NULL, 'Y'),
(37, 'H1', 'Utang Bank', 'Pasiva', '', 'Y', 'Y', 'Y'),
(38, 'H2', 'Obligasi', 'Pasiva', '', 'Y', 'Y', 'N'),
(39, 'I', 'Modal', 'Pasiva', '', NULL, NULL, 'Y'),
(40, 'I1', 'Simpanan Pokok', 'Pasiva', '', 'Y', 'Y', 'Y'),
(41, 'I2', 'Simpanan Wajib', 'Pasiva', '', 'Y', 'Y', 'Y'),
(42, 'I3', 'Modal Awal', 'Pasiva', '', 'Y', 'Y', 'Y'),
(43, 'I4', 'Modal Penyertaan', 'Pasiva', '', 'Y', 'Y', 'N'),
(44, 'I5', 'Modal Sumbangan', 'Pasiva', '', 'Y', 'Y', 'Y'),
(45, 'I6', 'Modal Cadangan', 'Pasiva', '', 'Y', 'Y', 'Y'),
(47, 'J', 'Pendapatan', 'Pasiva', 'PENDAPATAN', 'Y', 'N', 'Y'),
(48, 'J1', 'Pembayaran Angsuran', 'Pasiva', '', NULL, NULL, 'Y'),
(49, 'J2', 'Pendapatan Lainnya', 'Pasiva', 'PENDAPATAN', 'Y', 'N', 'Y'),
(50, 'K', 'Beban', 'Aktiva', '', NULL, NULL, 'Y'),
(52, 'K2', 'Beban Gaji Karyawan', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(53, 'K3', 'Biaya Listrik dan Air', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(54, 'K4', 'Biaya Transportasi', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(60, 'K10', 'Biaya Lainnya', 'Aktiva', 'BIAYA', 'N', 'Y', 'Y'),
(110, 'TRF', 'Transfer Antar Kas', NULL, '', NULL, NULL, 'N'),
(111, 'A11', 'Permisalan', 'Aktiva', '', 'Y', 'Y', 'Y'),
(112, 'J3', 'Penjualan', 'Pasiva', 'PENDAPATAN', 'Y', 'N', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jns_angsuran`
--

CREATE TABLE `jns_angsuran` (
  `id` bigint(20) NOT NULL,
  `ket` int(11) NOT NULL,
  `aktif` enum('Y','T','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `jns_angsuran`
--

INSERT INTO `jns_angsuran` (`id`, `ket`, `aktif`) VALUES
(1, 1, 'Y'),
(2, 2, 'Y'),
(3, 3, 'Y'),
(11, 4, 'Y'),
(13, 5, 'Y'),
(14, 6, 'Y'),
(15, 7, 'Y'),
(16, 8, 'Y'),
(17, 9, 'Y'),
(18, 10, 'Y'),
(19, 11, 'Y'),
(20, 12, 'Y'),
(21, 13, 'T'),
(22, 14, 'Y'),
(23, 15, 'Y'),
(24, 16, 'Y'),
(25, 17, 'Y'),
(26, 18, 'Y'),
(27, 19, 'Y'),
(28, 20, 'Y'),
(29, 21, 'Y'),
(30, 22, 'Y'),
(31, 23, 'Y'),
(32, 24, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jns_simpan`
--

CREATE TABLE `jns_simpan` (
  `id` int(11) NOT NULL,
  `jns_simpan` varchar(30) NOT NULL,
  `jumlah` double NOT NULL,
  `tampil` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `jns_simpan`
--

INSERT INTO `jns_simpan` (`id`, `jns_simpan`, `jumlah`, `tampil`) VALUES
(32, 'Simpanan Sukarela', 0, 'Y'),
(40, 'Simpanan Pokok', 100000, 'Y'),
(41, 'Simpanan Wajib', 50000, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nama_kas_tbl`
--

CREATE TABLE `nama_kas_tbl` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(225) CHARACTER SET latin1 NOT NULL,
  `aktif` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_simpan` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_penarikan` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_pinjaman` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_bayar` enum('Y','T') CHARACTER SET latin1 NOT NULL,
  `tmpl_pemasukan` enum('Y','T') NOT NULL,
  `tmpl_pengeluaran` enum('Y','T') NOT NULL,
  `tmpl_transfer` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `nama_kas_tbl`
--

INSERT INTO `nama_kas_tbl` (`id`, `nama`, `aktif`, `tmpl_simpan`, `tmpl_penarikan`, `tmpl_pinjaman`, `tmpl_bayar`, `tmpl_pemasukan`, `tmpl_pengeluaran`, `tmpl_transfer`) VALUES
(1, 'Kas Simpanan', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(2, 'Kas Besar', 'Y', 'T', 'Y', 'Y', 'T', 'Y', 'Y', 'Y'),
(4, 'Kas Pinjaman', 'Y', '', '', 'Y', 'Y', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_kerja` varchar(5) NOT NULL,
  `jenis_kerja` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_kerja`, `jenis_kerja`) VALUES
('3', 'Karyawan Organik'),
('4', 'Karyawan Non-Organik'),
('98', 'Pensiunan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suku_bunga`
--

CREATE TABLE `suku_bunga` (
  `id` int(11) NOT NULL,
  `opsi_key` varchar(20) NOT NULL,
  `opsi_val` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `suku_bunga`
--

INSERT INTO `suku_bunga` (`id`, `opsi_key`, `opsi_val`) VALUES
(1, 'bg_tab', '0'),
(2, 'bg_pinjam', '1'),
(3, 'biaya_adm', ''),
(4, 'denda', ''),
(5, 'denda_hari', '28'),
(6, 'dana_cadangan', '25'),
(7, 'jasa_anggota', '25'),
(8, 'dana_pengurus', '10'),
(9, 'dana_karyawan', '5'),
(10, 'dana_pend', '5'),
(11, 'dana_sosial', '5'),
(12, 'jasa_usaha', '70'),
(13, 'jasa_modal', '30'),
(14, 'pjk_pph', '2'),
(15, 'pinjaman_bunga_tipe', 'B');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_anggota`
--

CREATE TABLE `tbl_anggota` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 NOT NULL,
  `identitas` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tmp_lahir` varchar(225) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `status` varchar(30) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` text CHARACTER SET latin1 NOT NULL,
  `kota` varchar(255) NOT NULL,
  `notelp` varchar(12) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `pass_word` varchar(225) NOT NULL,
  `file_pic` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id` bigint(20) NOT NULL,
  `nm_barang` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `jml_brg` int(11) NOT NULL,
  `ket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id`, `nm_barang`, `type`, `merk`, `harga`, `jml_brg`, `ket`) VALUES
(4, 'Pinjaman Dana', 'Uang', '-', 0, 1005, ''),
(8, 'KULKAS', 'ELEKTRONIK', 'SHARP', 3000000, 0, 'KREDIT KULKAS'),
(9, 'meja', '30', 'jati', 50000000, 0, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengajuan`
--

CREATE TABLE `tbl_pengajuan` (
  `id` bigint(20) NOT NULL,
  `no_ajuan` int(11) NOT NULL,
  `ajuan_id` varchar(255) NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `tgl_input` datetime NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `lama_ags` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `tgl_cair` date NOT NULL,
  `tgl_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pinjaman_d`
--

CREATE TABLE `tbl_pinjaman_d` (
  `id` bigint(20) NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `pinjam_id` bigint(20) NOT NULL,
  `angsuran_ke` bigint(20) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `denda_rp` int(11) NOT NULL,
  `terlambat` int(11) NOT NULL,
  `ket_bayar` enum('Angsuran','Pelunasan','Bayar Denda') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pinjaman_h`
--

CREATE TABLE `tbl_pinjaman_h` (
  `id` bigint(20) NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `barang_id` bigint(20) NOT NULL,
  `lama_angsuran` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `bunga` float(10,2) NOT NULL,
  `biaya_adm` int(11) NOT NULL,
  `lunas` enum('Belum','Lunas') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `jns_trans` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `contoh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` bigint(20) NOT NULL,
  `opsi_key` varchar(255) NOT NULL,
  `opsi_val` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `opsi_key`, `opsi_val`) VALUES
(1, 'nama_lembaga', 'SRIKANDI'),
(2, 'nama_ketua', 'SRIKANDI'),
(3, 'hp_ketua', '081271310334'),
(4, 'alamat', 'Simpang 3 Sipin'),
(5, 'telepon', '0741-000000'),
(6, 'kota', 'Kota Jambi'),
(7, 'email', 'support@kobatech.id'),
(8, 'web', 'kobatech.id');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_trans_kas`
--

CREATE TABLE `tbl_trans_kas` (
  `id` bigint(20) NOT NULL,
  `tgl_catat` datetime NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Pemasukan','Pengeluaran','Transfer') NOT NULL,
  `dari_kas_id` bigint(20) DEFAULT NULL,
  `untuk_kas_id` bigint(20) DEFAULT NULL,
  `jns_trans` bigint(20) DEFAULT NULL,
  `dk` enum('D','K') DEFAULT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_trans_sp`
--

CREATE TABLE `tbl_trans_sp` (
  `id` bigint(20) NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `anggota_id` bigint(20) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Setoran','Penarikan') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint(20) NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `nama_penyetor` varchar(255) NOT NULL,
  `no_identitas` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` bigint(20) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `pass_word` varchar(255) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `level` enum('admin','operator','pinjaman') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `u_name`, `pass_word`, `aktif`, `level`) VALUES
(1, 'Briel', '435b56165ba00b6becf937e5a6a554bd8f65164b', 'Y', 'admin'),
(4, 'user', 'e22b7d59cb35d199ab7e54ed0f2ef58f5da5347b', 'Y', 'operator'),
(5, 'pinjaman', 'efd2770f6782f7218be595baf2fc16bc7cf45143', 'Y', 'pinjaman'),
(9, 'admin', '224bec3dd08832bc6a69873f15a50df406045f40', 'Y', 'admin'),
(10, 'fahrul', '71591d8e6808e1cdda305d86ae5fbea1857780c0', 'Y', 'admin');

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_hitung_pinjaman`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_hitung_pinjaman` (
`id` bigint(20)
,`tgl_pinjam` datetime
,`anggota_id` bigint(20)
,`lama_angsuran` bigint(20)
,`jumlah` int(11)
,`bunga` float(10,2)
,`biaya_adm` int(11)
,`lunas` enum('Belum','Lunas')
,`dk` enum('D','K')
,`kas_id` bigint(20)
,`user_name` varchar(255)
,`pokok_angsuran` decimal(14,4)
,`bunga_pinjaman` double(17,0)
,`ags_per_bulan` double(17,0)
,`tempo` datetime /* mariadb-5.3 */
,`tagihan` double(17,0)
,`keterangan` varchar(255)
,`barang_id` bigint(20)
,`bln_sudah_angsur` bigint(20)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_hitung_pinjaman_old`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_hitung_pinjaman_old` (
`id` bigint(20)
,`tgl_pinjam` datetime
,`anggota_id` bigint(20)
,`lama_angsuran` bigint(20)
,`jumlah` int(11)
,`bunga` float(10,2)
,`biaya_adm` int(11)
,`lunas` enum('Belum','Lunas')
,`dk` enum('D','K')
,`kas_id` bigint(20)
,`user_name` varchar(255)
,`pokok_angsuran` decimal(14,4)
,`bunga_pinjaman` double(17,0)
,`ags_per_bulan` double(17,0)
,`tempo` datetime /* mariadb-5.3 */
,`tagihan` double(17,0)
,`keterangan` varchar(255)
,`barang_id` bigint(20)
,`bln_sudah_angsur` bigint(20)
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_transaksi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_transaksi` (
`tbl` varchar(1)
,`id` bigint(20)
,`tgl` datetime
,`kredit` int(11)
,`debet` int(1)
,`dari_kas` bigint(20)
,`untuk_kas` binary(0)
,`transaksi` bigint(20)
,`ket` varchar(255)
,`user` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_hitung_pinjaman`
--
DROP TABLE IF EXISTS `v_hitung_pinjaman`;

CREATE VIEW `v_hitung_pinjaman`  AS SELECT `tbl_pinjaman_h`.`id` AS `id`, `tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`, `tbl_pinjaman_h`.`anggota_id` AS `anggota_id`, `tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`, `tbl_pinjaman_h`.`jumlah` AS `jumlah`, `tbl_pinjaman_h`.`bunga` AS `bunga`, `tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`, `tbl_pinjaman_h`.`lunas` AS `lunas`, `tbl_pinjaman_h`.`dk` AS `dk`, `tbl_pinjaman_h`.`kas_id` AS `kas_id`, `tbl_pinjaman_h`.`user_name` AS `user_name`, `tbl_pinjaman_h`.`jumlah`/ `tbl_pinjaman_h`.`lama_angsuran` AS `pokok_angsuran`, round(ceiling(`tbl_pinjaman_h`.`jumlah` * `tbl_pinjaman_h`.`bunga` / 100),0) AS `bunga_pinjaman`, round(ceiling((`tbl_pinjaman_h`.`jumlah` * `tbl_pinjaman_h`.`bunga` / 100 + `tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` + `tbl_pinjaman_h`.`biaya_adm`) * 100 / 100),0) AS `ags_per_bulan`, `tbl_pinjaman_h`.`tgl_pinjam`+ interval `tbl_pinjaman_h`.`lama_angsuran` month AS `tempo`, round(ceiling((`tbl_pinjaman_h`.`jumlah` * `tbl_pinjaman_h`.`bunga` / 100 + `tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` + `tbl_pinjaman_h`.`biaya_adm`) * 100 / 100),0) * `tbl_pinjaman_h`.`lama_angsuran` AS `tagihan`, `tbl_pinjaman_h`.`keterangan` AS `keterangan`, `tbl_pinjaman_h`.`barang_id` AS `barang_id`, ifnull(max(`tbl_pinjaman_d`.`angsuran_ke`),0) AS `bln_sudah_angsur` FROM (`tbl_pinjaman_h` left join `tbl_pinjaman_d` on(`tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id`)) GROUP BY `tbl_pinjaman_h`.`id` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_hitung_pinjaman_old`
--
DROP TABLE IF EXISTS `v_hitung_pinjaman_old`;

CREATE VIEW `v_hitung_pinjaman_old`  AS SELECT `tbl_pinjaman_h`.`id` AS `id`, `tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`, `tbl_pinjaman_h`.`anggota_id` AS `anggota_id`, `tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`, `tbl_pinjaman_h`.`jumlah` AS `jumlah`, `tbl_pinjaman_h`.`bunga` AS `bunga`, `tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`, `tbl_pinjaman_h`.`lunas` AS `lunas`, `tbl_pinjaman_h`.`dk` AS `dk`, `tbl_pinjaman_h`.`kas_id` AS `kas_id`, `tbl_pinjaman_h`.`user_name` AS `user_name`, `tbl_pinjaman_h`.`jumlah`/ `tbl_pinjaman_h`.`lama_angsuran` AS `pokok_angsuran`, round(ceiling(`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` * `tbl_pinjaman_h`.`bunga` / 100),-2) AS `bunga_pinjaman`, round(ceiling((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` * `tbl_pinjaman_h`.`bunga` / 100 + `tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` + `tbl_pinjaman_h`.`biaya_adm`) * 100 / 100),-2) AS `ags_per_bulan`, `tbl_pinjaman_h`.`tgl_pinjam`+ interval `tbl_pinjaman_h`.`lama_angsuran` month AS `tempo`, round(ceiling((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` * `tbl_pinjaman_h`.`bunga` / 100 + `tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran` + `tbl_pinjaman_h`.`biaya_adm`) * 100 / 100),-2) * `tbl_pinjaman_h`.`lama_angsuran` AS `tagihan`, `tbl_pinjaman_h`.`keterangan` AS `keterangan`, `tbl_pinjaman_h`.`barang_id` AS `barang_id`, ifnull(max(`tbl_pinjaman_d`.`angsuran_ke`),0) AS `bln_sudah_angsur` FROM (`tbl_pinjaman_h` left join `tbl_pinjaman_d` on(`tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id`)) GROUP BY `tbl_pinjaman_h`.`id` ;

-- --------------------------------------------------------

--
-- Struktur untuk view `v_transaksi`
--
DROP TABLE IF EXISTS `v_transaksi`;

CREATE VIEW `v_transaksi` AS select 'A' AS `tbl`,`tbl_pinjaman_h`.`id` AS `id`,`tbl_pinjaman_h`.`tgl_pinjam` AS `tgl`,`tbl_pinjaman_h`.`jumlah` AS `kredit`,0 AS `debet`,`tbl_pinjaman_h`.`kas_id` AS `dari_kas`,NULL AS `untuk_kas`,`tbl_pinjaman_h`.`jns_trans` AS `transaksi`,`tbl_pinjaman_h`.`keterangan` AS `ket`,`tbl_pinjaman_h`.`user_name` AS `user` from `tbl_pinjaman_h` union select 'B' AS `tbl`,`tbl_pinjaman_d`.`id` AS `id`,`tbl_pinjaman_d`.`tgl_bayar` AS `tgl`,0 AS `kredit`,`tbl_pinjaman_d`.`jumlah_bayar` AS `debet`,NULL AS `dari_kas`,`tbl_pinjaman_d`.`kas_id` AS `untuk_kas`,`tbl_pinjaman_d`.`jns_trans` AS `transaksi`,`tbl_pinjaman_d`.`keterangan` AS `ket`,`tbl_pinjaman_d`.`user_name` AS `user` from `tbl_pinjaman_d` union select 'C' AS `tbl`,`tbl_trans_sp`.`id` AS `id`,`tbl_trans_sp`.`tgl_transaksi` AS `tgl`,if((`tbl_trans_sp`.`dk` = 'K'),`tbl_trans_sp`.`jumlah`,0) AS `kredit`,if((`tbl_trans_sp`.`dk` = 'D'),`tbl_trans_sp`.`jumlah`,0) AS `debet`,if((`tbl_trans_sp`.`dk` = 'K'),`tbl_trans_sp`.`kas_id`,NULL) AS `dari_kas`,if((`tbl_trans_sp`.`dk` = 'D'),`tbl_trans_sp`.`kas_id`,NULL) AS `untuk_kas`,`tbl_trans_sp`.`jenis_id` AS `transaksi`,`tbl_trans_sp`.`keterangan` AS `ket`,`tbl_trans_sp`.`user_name` AS `user` from `tbl_trans_sp` union select 'D' AS `tbl`,`tbl_trans_kas`.`id` AS `id`,`tbl_trans_kas`.`tgl_catat` AS `tgl`,if((`tbl_trans_kas`.`dk` = 'K'),`tbl_trans_kas`.`jumlah`,if((`tbl_trans_kas`.`dk` is null),`tbl_trans_kas`.`jumlah`,0)) AS `kredit`,if((`tbl_trans_kas`.`dk` = 'D'),`tbl_trans_kas`.`jumlah`,if((`tbl_trans_kas`.`dk` is null),`tbl_trans_kas`.`jumlah`,0)) AS `debet`,`tbl_trans_kas`.`dari_kas_id` AS `dari_kas`,`tbl_trans_kas`.`untuk_kas_id` AS `untuk_kas`,`tbl_trans_kas`.`jns_trans` AS `transaksi`,`tbl_trans_kas`.`keterangan` AS `ket`,`tbl_trans_kas`.`user_name` AS `user` from `tbl_trans_kas` order by `tgl`

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `jns_akun`
--
ALTER TABLE `jns_akun`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jns_angsuran`
--
ALTER TABLE `jns_angsuran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jns_simpan`
--
ALTER TABLE `jns_simpan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nama_kas_tbl`
--
ALTER TABLE `nama_kas_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_kerja`);

--
-- Indeks untuk tabel `suku_bunga`
--
ALTER TABLE `suku_bunga`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jns_akun`
--
ALTER TABLE `jns_akun`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT untuk tabel `jns_angsuran`
--
ALTER TABLE `jns_angsuran`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `jns_simpan`
--
ALTER TABLE `jns_simpan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `nama_kas_tbl`
--
ALTER TABLE `nama_kas_tbl`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `suku_bunga`
--
ALTER TABLE `suku_bunga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
