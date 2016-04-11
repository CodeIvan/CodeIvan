-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2016 at 09:38 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` int(10) NOT NULL,
  `nm_category` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id_category`, `nm_category`) VALUES
(1, 'makanan'),
(2, 'minuman');

-- --------------------------------------------------------

--
-- Table structure for table `details`
--

CREATE TABLE IF NOT EXISTS `details` (
  `no_trans` varchar(20) NOT NULL,
  `id_menu` int(10) NOT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details`
--

INSERT INTO `details` (`no_trans`, `id_menu`, `qty`) VALUES
('20160322234408', 3, 2),
('20160322234408', 5, 3),
('20160323202352', 5, 1),
('20160323202352', 7, 3),
('20160326193237', 5, 2),
('20160326193237', 1, 1),
('20160328180642', 1, 2),
('20160328180642', 7, 2),
('20160330124632', 6, 4),
('20160330124632', 7, 2),
('20160401001106', 5, 3),
('20160401001106', 3, 2),
('20160401162650', 1, 2),
('20160401162650', 5, 1),
('20160402222843', 5, 2),
('20160402222843', 4, 5),
('20160404003517', 6, 2),
('20160404003517', 7, 2),
('20160404003748', 5, 1),
('20160404010530', 3, 2),
('20160407224114', 11, 4),
('20160407224114', 18, 3),
('20160407224114', 13, 2),
('20160408131112', 9, 5),
('20160408131112', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id_menu` int(10) NOT NULL,
  `nm_menu` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `id_category` int(10) NOT NULL,
  `stock` int(10) NOT NULL,
  `price` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id_menu`, `nm_menu`, `image`, `id_category`, `stock`, `price`) VALUES
(1, 'Nasi Goreng Telor', 'Nasgor.jpeg', 1, 5, 8000),
(3, 'Sate Ayam Manis', 'sate-manis.jpg', 1, 36, 9000),
(4, 'Rawon Sedap', 'rawon.Jpeg', 1, 14, 7000),
(5, 'Es Jeruk Manis', 'esjeruk.jpg', 2, 11, 4000),
(6, 'Soto Ayam Kampung', 'soto ayam.jpg', 1, 3, 9000),
(7, 'Es Kelapa Muda', 'EsKelapaMuda.jpg', 2, 3, 6000),
(8, 'Es Susu', 'susu.png', 2, 23, 5000),
(9, 'Ayam Goreng Spesial', 'ayam.jpg', 1, 50, 12000),
(10, 'Capjhae Enak', 'japchae2.jpg', 1, 17, 9500),
(11, 'Jus Buah Naga', 'buah naga2.jpg', 2, 28, 7000),
(12, 'Jus Nanas', 'Resep-Jus-Nanas-Murni-Ala-Hurom-Slow-Juicer.jpg', 2, 21, 6500),
(13, 'Nasi Kucing', 'nasikucing.jpg', 1, 43, 9500),
(14, 'Telor Mata Sapi', 'telormatasapi.jpg', 1, 13, 5000),
(15, 'Udang Special 4 U', '011.jpg', 1, 24, 8500),
(16, 'Spaghetti', 'spagheti.jpg', 1, 24, 7500),
(17, 'Sari Kedelai', 'sarikedelai.jpg', 2, 31, 6000),
(18, 'Jus Durian', 'B60TBM5CAAAY_LJ.jpg', 2, 42, 10000),
(19, 'Es Serut', 'lengyin4.jpg', 2, 22, 4000),
(20, 'Es Buah', 'es-buah.jpg', 2, 33, 5000),
(21, 'es krim mangga', 'eskrimmangga.jpg', 2, 56, 6000);

-- --------------------------------------------------------

--
-- Stand-in structure for view `q_menu`
--
CREATE TABLE IF NOT EXISTS `q_menu` (
`id_menu` int(10)
,`nm_menu` varchar(50)
,`image` varchar(255)
,`nm_category` varchar(20)
,`stock` int(10)
,`price` int(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `id_table` int(10) NOT NULL,
  `no_table` int(10) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id_table`, `no_table`, `status`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1),
(10, 10, 1),
(11, 11, 1),
(12, 12, 1),
(13, 13, 1),
(14, 14, 1),
(15, 15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `no_trans` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(25) NOT NULL,
  `no_table` int(5) NOT NULL,
  `s1` int(1) NOT NULL,
  `s2` int(1) NOT NULL,
  `gtotal` int(10) NOT NULL,
  `pay` int(10) NOT NULL,
  `refund` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`no_trans`, `date`, `name`, `no_table`, `s1`, `s2`, `gtotal`, `pay`, `refund`) VALUES
('20160322234408', '2016-03-22', 'Shopi', 1, 2, 2, 30000, 100000, 70000),
('20160323202352', '2016-03-23', 'Kevin', 5, 2, 2, 22000, 30000, 8000),
('20160326193237', '2016-03-26', 'Buyung', 3, 2, 2, 16000, 20000, 4000),
('20160328180642', '2016-03-28', 'Koko', 4, 2, 2, 28000, 30000, 2000),
('20160330124632', '2016-03-30', 'Ageng', 5, 2, 2, 48000, 100000, 52000),
('20160401001106', '2016-04-01', 'Ivan', 8, 2, 2, 30000, 30000, 0),
('20160401162650', '2016-04-01', 'Ageng', 2, 2, 2, 20000, 50000, 30000),
('20160402222843', '2016-04-02', 'dayu', 5, 2, 2, 43000, 43000, 0),
('20160404003517', '2016-04-04', 'Code', 10, 2, 2, 30000, 30000, 0),
('20160404003748', '2016-04-04', 'Abeat', 3, 2, 2, 4000, 5000, 1000),
('20160404010530', '2016-04-04', 'jh', 5, 2, 2, 18000, 20000, 2000),
('20160407224114', '2016-04-07', 'Mirul', 2, 2, 2, 77000, 100000, 23000),
('20160408131112', '2016-04-08', 'Koko', 3, 2, 2, 78000, 80000, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(10) NOT NULL,
  `nm_user` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` int(1) NOT NULL,
  `level` int(1) NOT NULL,
  `lu` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nm_user`, `username`, `password`, `gender`, `level`, `lu`) VALUES
(1, 'ivan yanuar', 'admin', '$2y$11$AKw6kY5pRc1VFXyQSbmTNusTwc/lplXFI2o4hwhog9/EsCmkeQPRS', 1, 1, '2016-03-15 18:20:38'),
(4, 'code', 'code', '$2y$11$XHD1.DsxVrcvvrii/x1HreKH9EgzmUWN8Cb3cOicwfUrizoabO/N.', 1, 2, '0000-00-00 00:00:00'),
(6, 'dewi quan in', 'dewi', '$2y$11$QSU0HDEoItmZoHus34XN1OVGuavbLM2VksLB4vVMKoecfLCKGVzuK', 2, 3, '0000-00-00 00:00:00'),
(7, 'bos', 'bos', '$2y$11$yMfn50UA5CV/EntDglXPyuB0/IZpwDNK.K6U56JPP1wGpr5xoD9ye', 2, 1, '0000-00-00 00:00:00'),
(9, 'ivan', 'ivan', '$2y$11$vg4xkklC6pmkuM9wMZh58OSqS1EQNnb93PSi5.uWntBkTbPekdErq', 1, 2, '2016-04-08 11:15:02');

-- --------------------------------------------------------

--
-- Structure for view `q_menu`
--
DROP TABLE IF EXISTS `q_menu`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `q_menu` AS select `menus`.`id_menu` AS `id_menu`,`menus`.`nm_menu` AS `nm_menu`,`menus`.`image` AS `image`,`categories`.`nm_category` AS `nm_category`,`menus`.`stock` AS `stock`,`menus`.`price` AS `price` from (`menus` join `categories` on((`categories`.`id_category` = `menus`.`id_category`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id_table`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`no_trans`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id_category` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id_table` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
