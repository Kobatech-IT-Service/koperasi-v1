-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 20 Agu 2022 pada 14.13
-- Versi server: 8.0.30
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
-- Database: `binainsa_kopkar`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `ci_sessions`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jns_akun`
--

CREATE TABLE `jns_akun` (
  `id` bigint NOT NULL,
  `kd_aktiva` varchar(5) DEFAULT NULL,
  `jns_trans` varchar(50) NOT NULL,
  `akun` enum('Aktiva','Pasiva') DEFAULT NULL,
  `laba_rugi` enum('','PENDAPATAN','BIAYA') NOT NULL DEFAULT '',
  `pemasukan` enum('Y','N') DEFAULT NULL,
  `pengeluaran` enum('Y','N') DEFAULT NULL,
  `aktif` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
(31, 'K3', 'Pengeluaran Lainnya', 'Aktiva', '', 'N', 'Y', 'N'),
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
(111, 'A11', 'Permisalan', 'Aktiva', '', 'Y', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jns_angsuran`
--

CREATE TABLE `jns_angsuran` (
  `id` bigint NOT NULL,
  `ket` int NOT NULL,
  `aktif` enum('Y','T','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `jns_angsuran`
--

-- INSERT INTO `jns_angsuran` (`id`, `ket`, `aktif`) VALUES
-- (1, 1, 'Y'),
-- (2, 2, 'Y'),
-- (3, 3, 'Y'),
-- (4, 4, 'Y'),
-- (5, 5, 'Y'),
-- (6, 6, 'Y'),
-- (7, 7, 'Y'),
-- (8, 8, 'Y');
-- (9, 9, 'Y');
-- (10, 10, 'Y');
-- (11, 11, 'Y');
-- (12, 12, 'Y');
-- (13, 13, 'Y');
-- (14, 14, 'Y');
-- (15, 15, 'Y');
-- (16, 16, 'Y');
-- (17, 17, 'Y');
-- (18, 18, 'Y');
-- (19, 19, 'Y');
-- (20, 20, 'Y');
-- (21, 21, 'Y');
-- (22, 22, 'Y');
-- (23, 23, 'Y');
-- (24, 24, 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jns_simpan`
--

CREATE TABLE `jns_simpan` (
  `id` int NOT NULL,
  `jns_simpan` varchar(30) NOT NULL,
  `jumlah` double NOT NULL,
  `tampil` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  `id` bigint NOT NULL,
  `nama` varchar(225) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `aktif` enum('Y','T') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tmpl_simpan` enum('Y','T') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tmpl_penarikan` enum('Y','T') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tmpl_pinjaman` enum('Y','T') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tmpl_bayar` enum('Y','T') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tmpl_pemasukan` enum('Y','T') NOT NULL,
  `tmpl_pengeluaran` enum('Y','T') NOT NULL,
  `tmpl_transfer` enum('Y','T') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `nama_kas_tbl`
--

INSERT INTO `nama_kas_tbl` (`id`, `nama`, `aktif`, `tmpl_simpan`, `tmpl_penarikan`, `tmpl_pinjaman`, `tmpl_bayar`, `tmpl_pemasukan`, `tmpl_pengeluaran`, `tmpl_transfer`) VALUES
(1, 'Kas Simpanan', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y'),
(2, 'Kas Besar', 'Y', 'T', 'Y', 'Y', 'T', 'Y', 'Y', 'Y'),
(3, 'Bank BNI', 'Y', 'T', 'T', 'T', 'T', 'Y', 'Y', 'Y'),
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
('3', 'Karyawan Tetap'),
('4', 'Karyawan Kontrak'),
('98', 'Pensiunan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `suku_bunga`
--

CREATE TABLE `suku_bunga` (
  `id` int NOT NULL,
  `opsi_key` varchar(20) NOT NULL,
  `opsi_val` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  `id` bigint NOT NULL,
  `nama` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `identitas` varchar(255) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `tmp_lahir` varchar(225) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `status` varchar(30) NOT NULL,
  `agama` varchar(30) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `pekerjaan` varchar(30) NOT NULL,
  `alamat` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kota` varchar(255) NOT NULL,
  `notelp` varchar(12) NOT NULL,
  `tgl_daftar` date NOT NULL,
  `jabatan_id` int NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `pass_word` varchar(225) NOT NULL,
  `file_pic` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Struktur dari tabel `tbl_barang`
--

CREATE TABLE `tbl_barang` (
  `id` bigint NOT NULL,
  `nm_barang` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `merk` varchar(50) NOT NULL,
  `harga` double NOT NULL,
  `jml_brg` int NOT NULL,
  `ket` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tbl_barang`
--

INSERT INTO `tbl_barang` (`id`, `nm_barang`, `type`, `merk`, `harga`, `jml_brg`, `ket`) VALUES
(4, 'Pinjaman Dana', 'Uang', '-', 10000000, 5, ''),
(6, 'UMUM', '', '', 0, 0, ''),
(7, 'Pinjaman Hari Raya', 'Dana', '', 0, 1, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pengajuan`
--

CREATE TABLE `tbl_pengajuan` (
  `id` bigint NOT NULL,
  `no_ajuan` int NOT NULL,
  `ajuan_id` varchar(255) NOT NULL,
  `anggota_id` bigint NOT NULL,
  `tgl_input` datetime NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `nominal` bigint NOT NULL,
  `lama_ags` int NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `status` tinyint NOT NULL,
  `alasan` varchar(255) NOT NULL,
  `tgl_cair` date NOT NULL,
  `tgl_update` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_pinjaman_d`
--

CREATE TABLE `tbl_pinjaman_d` (
  `id` bigint NOT NULL,
  `tgl_bayar` datetime NOT NULL,
  `pinjam_id` bigint NOT NULL,
  `angsuran_ke` bigint NOT NULL,
  `jumlah_bayar` int NOT NULL,
  `denda_rp` int NOT NULL,
  `terlambat` int NOT NULL,
  `ket_bayar` enum('Angsuran','Pelunasan','Bayar Denda') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint NOT NULL,
  `jns_trans` bigint NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


--
-- Struktur dari tabel `tbl_pinjaman_h`
--

CREATE TABLE `tbl_pinjaman_h` (
  `id` bigint NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `anggota_id` bigint NOT NULL,
  `barang_id` bigint NOT NULL,
  `lama_angsuran` bigint NOT NULL,
  `jumlah` int NOT NULL,
  `bunga` float(10,2) NOT NULL,
  `biaya_adm` int NOT NULL,
  `lunas` enum('Belum','Lunas') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint NOT NULL,
  `jns_trans` bigint NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `contoh` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_setting`
--

CREATE TABLE `tbl_setting` (
  `id` bigint NOT NULL,
  `opsi_key` varchar(255) NOT NULL,
  `opsi_val` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data untuk tabel `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `opsi_key`, `opsi_val`) VALUES
(1, 'nama_lembaga', 'KOPERASI KOBATECH'),
(2, 'nama_ketua', 'KOBATECH'),
(3, 'hp_ketua', '081234567890'),
(4, 'alamat', 'SIMPANG 3 SIPIN'),
(5, 'telepon', '0741-000000'),
(6, 'kota', 'KOTA JAMBI'),
(7, 'email', 'support@kobatech.id'),
(8, 'web', 'kobatech.id');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_trans_kas`
--

CREATE TABLE `tbl_trans_kas` (
  `id` bigint NOT NULL,
  `tgl_catat` datetime NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Pemasukan','Pengeluaran','Transfer') NOT NULL,
  `dari_kas_id` bigint DEFAULT NULL,
  `untuk_kas_id` bigint DEFAULT NULL,
  `jns_trans` bigint DEFAULT NULL,
  `dk` enum('D','K') DEFAULT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_trans_sp`
--

CREATE TABLE `tbl_trans_sp` (
  `id` bigint NOT NULL,
  `tgl_transaksi` datetime NOT NULL,
  `anggota_id` bigint NOT NULL,
  `jenis_id` int NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `akun` enum('Setoran','Penarikan') NOT NULL,
  `dk` enum('D','K') NOT NULL,
  `kas_id` bigint NOT NULL,
  `update_data` datetime NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `nama_penyetor` varchar(255) NOT NULL,
  `no_identitas` varchar(20) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


--
-- Struktur dari tabel `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` bigint NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `pass_word` varchar(255) NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `level` enum('admin','operator','pinjaman') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
`id` bigint
,`tgl_pinjam` datetime
,`anggota_id` bigint
,`lama_angsuran` bigint
,`jumlah` int
,`bunga` float(10,2)
,`biaya_adm` int
,`lunas` enum('Belum','Lunas')
,`dk` enum('D','K')
,`kas_id` bigint
,`user_name` varchar(255)
,`pokok_angsuran` decimal(14,4)
,`bunga_pinjaman` double
,`ags_per_bulan` double
,`tempo` datetime
,`tagihan` double
,`keterangan` varchar(255)
,`barang_id` bigint
,`bln_sudah_angsur` bigint
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_hitung_pinjaman_old`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_hitung_pinjaman_old` (
`id` bigint
,`tgl_pinjam` datetime
,`anggota_id` bigint
,`lama_angsuran` bigint
,`jumlah` int
,`bunga` float(10,2)
,`biaya_adm` int
,`lunas` enum('Belum','Lunas')
,`dk` enum('D','K')
,`kas_id` bigint
,`user_name` varchar(255)
,`pokok_angsuran` decimal(14,4)
,`bunga_pinjaman` double
,`ags_per_bulan` double
,`tempo` datetime
,`tagihan` double
,`keterangan` varchar(255)
,`barang_id` bigint
,`bln_sudah_angsur` bigint
);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_transaksi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_transaksi` (
`tbl` varchar(1)
,`id` bigint
,`tgl` datetime
,`kredit` double
,`debet` double
,`dari_kas` bigint
,`untuk_kas` bigint
,`transaksi` bigint
,`ket` varchar(255)
,`user` varchar(255)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_hitung_pinjaman`
--
DROP TABLE IF EXISTS `v_hitung_pinjaman`;

CREATE VIEW `v_hitung_pinjaman` AS select `tbl_pinjaman_h`.`id` AS `id`,`tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`,`tbl_pinjaman_h`.`anggota_id` AS `anggota_id`,`tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`,`tbl_pinjaman_h`.`jumlah` AS `jumlah`,`tbl_pinjaman_h`.`bunga` AS `bunga`,`tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`,`tbl_pinjaman_h`.`lunas` AS `lunas`,`tbl_pinjaman_h`.`dk` AS `dk`,`tbl_pinjaman_h`.`kas_id` AS `kas_id`,`tbl_pinjaman_h`.`user_name` AS `user_name`,(`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) AS `pokok_angsuran`,round(ceiling(((`tbl_pinjaman_h`.`jumlah` * `tbl_pinjaman_h`.`bunga`) / 100)),0) AS `bunga_pinjaman`,round(ceiling(((((((`tbl_pinjaman_h`.`jumlah` * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) AS `ags_per_bulan`,(`tbl_pinjaman_h`.`tgl_pinjam` + interval `tbl_pinjaman_h`.`lama_angsuran` month) AS `tempo`,(round(ceiling(((((((`tbl_pinjaman_h`.`jumlah` * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),0) * `tbl_pinjaman_h`.`lama_angsuran`) AS `tagihan`,`tbl_pinjaman_h`.`keterangan` AS `keterangan`,`tbl_pinjaman_h`.`barang_id` AS `barang_id`,ifnull(max(`tbl_pinjaman_d`.`angsuran_ke`),0) AS `bln_sudah_angsur` from (`tbl_pinjaman_h` left join `tbl_pinjaman_d` on((`tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id`))) group by `tbl_pinjaman_h`.`id`

-- --------------------------------------------------------

--
-- Struktur untuk view `v_hitung_pinjaman_old`
--
DROP TABLE IF EXISTS `v_hitung_pinjaman_old`;

CREATE VIEW `v_hitung_pinjaman_old`  AS SELECT `tbl_pinjaman_h`.`id` AS `id`, `tbl_pinjaman_h`.`tgl_pinjam` AS `tgl_pinjam`, `tbl_pinjaman_h`.`anggota_id` AS `anggota_id`, `tbl_pinjaman_h`.`lama_angsuran` AS `lama_angsuran`, `tbl_pinjaman_h`.`jumlah` AS `jumlah`, `tbl_pinjaman_h`.`bunga` AS `bunga`, `tbl_pinjaman_h`.`biaya_adm` AS `biaya_adm`, `tbl_pinjaman_h`.`lunas` AS `lunas`, `tbl_pinjaman_h`.`dk` AS `dk`, `tbl_pinjaman_h`.`kas_id` AS `kas_id`, `tbl_pinjaman_h`.`user_name` AS `user_name`, (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) AS `pokok_angsuran`, round(ceiling((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100)),-(2)) AS `bunga_pinjaman`, round(ceiling((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),-(2)) AS `ags_per_bulan`, (`tbl_pinjaman_h`.`tgl_pinjam` + interval `tbl_pinjaman_h`.`lama_angsuran` month) AS `tempo`, (round(ceiling((((((((`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`) * `tbl_pinjaman_h`.`bunga`) / 100) + (`tbl_pinjaman_h`.`jumlah` / `tbl_pinjaman_h`.`lama_angsuran`)) + `tbl_pinjaman_h`.`biaya_adm`) * 100) / 100)),-(2)) * `tbl_pinjaman_h`.`lama_angsuran`) AS `tagihan`, `tbl_pinjaman_h`.`keterangan` AS `keterangan`, `tbl_pinjaman_h`.`barang_id` AS `barang_id`, ifnull(max(`tbl_pinjaman_d`.`angsuran_ke`),0) AS `bln_sudah_angsur` FROM (`tbl_pinjaman_h` left join `tbl_pinjaman_d` on((`tbl_pinjaman_h`.`id` = `tbl_pinjaman_d`.`pinjam_id`))) GROUP BY `tbl_pinjaman_h`.`id` ;

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
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT untuk tabel `jns_angsuran`
--
ALTER TABLE `jns_angsuran`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `jns_simpan`
--
ALTER TABLE `jns_simpan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT untuk tabel `nama_kas_tbl`
--
ALTER TABLE `nama_kas_tbl`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `suku_bunga`
--
ALTER TABLE `suku_bunga`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `tbl_anggota`
--
ALTER TABLE `tbl_anggota`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT untuk tabel `tbl_barang`
--
ALTER TABLE `tbl_barang`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_pengajuan`
--
ALTER TABLE `tbl_pengajuan`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_pinjaman_d`
--
ALTER TABLE `tbl_pinjaman_d`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tbl_pinjaman_h`
--
ALTER TABLE `tbl_pinjaman_h`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `tbl_trans_kas`
--
ALTER TABLE `tbl_trans_kas`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2666;

--
-- AUTO_INCREMENT untuk tabel `tbl_trans_sp`
--
ALTER TABLE `tbl_trans_sp`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3040;

--
-- AUTO_INCREMENT untuk tabel `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
