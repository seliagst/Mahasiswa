-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2026 at 05:31 AM
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
-- Database: `mahasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `usia` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `alamat`, `tanggal_lahir`, `gender`, `usia`) VALUES
('K352034', 'Hepa Arum', 'dvthesidyw', '2004-07-09', 'Perempuan', 22),
('K3522001', 'Ahmad ', 'Sukoharjo', '2003-06-23', 'Laki-laki', 23),
('K3522005', 'Cahya Nirin', 'dfufws', '2004-06-07', 'Perempuan', 22),
('K3522010', 'Febri', 'Kartasura', '2005-07-09', 'Perempuan', 20),
('K3522012', 'Defriansyah Aji', 'gysderdiysdsy', '2004-07-09', 'Laki-laki', 22),
('K3522015', 'Dimas Anggara', 'paris ', '2003-07-09', 'Laki-laki', 23),
('K3522019', 'Doni Setiawan', 'Pakem', '2004-12-09', 'Laki-laki', 22),
('K3522035', 'Firda', 'shdhegdye', '2006-07-09', 'Perempuan', 20),
('K3522054', 'Muhammad Fahri', 'Kuwakur', '2005-11-02', 'Laki-laki', 21),
('K3522056', 'Maranatha Nur', 'Gemolong\r\n', '2004-01-02', 'Perempuan', 22),
('K3522070', 'Risnawati', 'fdfteiysydf', '2004-06-07', 'Perempuan', 22),
('K3522072', 'Sasa', 'shgdsdyew', '2005-07-23', 'Perempuan', 21),
('K3522075', 'Riska Aisyah', 'dyegfwueywi', '2003-07-09', 'Perempuan', 23),
('K3522076', 'Seli Agustina', 'Pati', '2004-08-23', 'Perempuan', 22),
('K3522078', 'Septian Dwi', 'dgyefyetwhd', '2004-09-07', 'Laki-laki', 22),
('K3522084', 'Zaza Humairah', 'gatuat', '2004-07-09', 'Perempuan', 22);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
