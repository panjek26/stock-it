-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 11, 2017 at 05:44 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `estock2`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(50) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `satuan`, `harga_beli`, `harga_jual`) VALUES
(21, 'Samsung Galaxy Note 3', 'unit', 0, 0),
(20, 'Sony Xperia E Dual', 'unit', 0, 0),
(19, 'Sony Xperia M', 'unit', 0, 0),
(18, 'Sony Xperia ZR', 'unit', 0, 0),
(17, 'Sony Xperia M2', 'unit', 0, 0),
(22, 'Samsung Galaxy Note 10.1', 'unit', 0, 0),
(24, 'Nokia Lumia 920', 'unit', 0, 0),
(25, 'Apple iPhone 4S', 'unit', 5500000, 6250000),
(26, 'Apple iPhone 5S', 'unit', 0, 0),
(27, 'BlackBerry Z10', 'unit', 0, 0),
(28, 'BlackBerry Z30', 'unit', 0, 0),
(29, '4G USB MODEM BOLT', 'unit', 0, 0),
(30, '4G MIFI MODEM BOLT', 'unit', 350000, 400000),
(31, 'Power Bank Philips 7800 mAh', 'unit', 0, 0),
(32, 'Speaker System Z103', 'unit', 0, 0),
(33, 'Speaker System Z110', 'unit', 0, 0),
(45, 'sample 1', 'biji', 2500, 2700);

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE IF NOT EXISTS `gudang` (
  `id_gudang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_gudang` varchar(20) NOT NULL,
  `nama_gudang` varchar(30) NOT NULL,
  PRIMARY KEY (`id_gudang`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `kode_gudang`, `nama_gudang`) VALUES
(1, 'gudang-pusat', 'Gudang Pusat'),
(2, 'gudang-cab1', 'Gudang Cabang 1'),
(3, 'gudang-cab2', 'Gudang Cabang 2');

-- --------------------------------------------------------

--
-- Table structure for table `posisi`
--

CREATE TABLE IF NOT EXISTS `posisi` (
  `id_posisi` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  PRIMARY KEY (`id_posisi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `posisi`
--

INSERT INTO `posisi` (`id_posisi`, `id_barang`, `id_gudang`, `stok`) VALUES
(11, 30, 2, 5),
(10, 18, 2, 6),
(9, 27, 1, 5),
(8, 25, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id_request` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_request` date NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_request`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id_request`, `tgl_request`, `username`, `status`, `keterangan`) VALUES
(1, '2015-03-15', 'vito', 'rejected', 'belum ada'),
(2, '2015-03-16', 'zaki', 'approved', 'hp: 35\r\nbb: 32\r\nClosed\r\n======');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE IF NOT EXISTS `satuan` (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(10) NOT NULL,
  PRIMARY KEY (`id_satuan`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `nama_satuan`) VALUES
(1, 'pcs'),
(2, 'kodi'),
(3, 'lusin'),
(4, 'unit'),
(5, 'pack'),
(6, 'kantong'),
(7, 'kotak'),
(8, 'bungkus'),
(11, 'biji'),
(10, 'lembar'),
(12, 'tes');

-- --------------------------------------------------------

--
-- Table structure for table `todo`
--

CREATE TABLE IF NOT EXISTS `todo` (
  `todo_id` int(11) NOT NULL AUTO_INCREMENT,
  `todo_name` varchar(100) NOT NULL,
  `mark` varchar(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`todo_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `todo`
--

INSERT INTO `todo` (`todo_id`, `todo_name`, `mark`) VALUES
(17, 'Pesanan Galaxy Note 10.1 ke denpasar, kirim besok pagi', 'no'),
(16, 'tagihan handphone dari distributor samsung, jatuh tempo tgl 05-01-2014', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_transaksi` date NOT NULL,
  `jenis_transaksi` varchar(6) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `no_do` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `tgl_transaksi`, `jenis_transaksi`, `id_barang`, `id_gudang`, `no_do`, `jumlah`, `keterangan`) VALUES
(46, '2015-01-02', 'Keluar', 29, 0, '', 3, ''),
(45, '2015-01-02', 'Keluar', 27, 0, '', 1, ''),
(44, '2015-01-02', 'Keluar', 17, 0, '', 1, ''),
(43, '2015-01-02', 'Keluar', 25, 0, '', 1, ''),
(42, '2015-01-02', 'Masuk', 34, 0, '', 30, ''),
(41, '2015-01-02', 'Masuk', 33, 0, '', 5, ''),
(40, '2015-01-02', 'Masuk', 32, 0, '', 25, ''),
(39, '2015-01-02', 'Masuk', 18, 0, '', 20, ''),
(38, '2015-01-02', 'Masuk', 17, 0, '', 15, ''),
(37, '2015-01-02', 'Masuk', 19, 0, '', 10, ''),
(36, '2015-01-02', 'Masuk', 20, 0, '', 2, ''),
(35, '2015-01-02', 'Masuk', 21, 0, '', 19, ''),
(34, '2015-01-02', 'Masuk', 22, 0, '', 25, ''),
(33, '2015-01-02', 'Masuk', 31, 0, '', 75, ''),
(32, '2015-01-02', 'Masuk', 24, 0, '', 21, ''),
(31, '2015-01-02', 'Masuk', 23, 0, '', 13, ''),
(30, '2015-01-02', 'Masuk', 28, 0, '', 27, ''),
(29, '2015-01-02', 'Masuk', 27, 0, '', 17, ''),
(28, '2015-01-02', 'Masuk', 26, 0, '', 15, ''),
(27, '2015-01-02', 'Masuk', 25, 0, '', 12, ''),
(26, '2015-01-02', 'Masuk', 29, 0, '', 50, ''),
(25, '2015-01-02', 'Masuk', 30, 0, '', 21, ''),
(47, '2015-01-13', 'Keluar', 30, 0, '', 2, ''),
(48, '2015-01-13', 'Keluar', 30, 0, '', 1, 'Modal 1000'),
(49, '2015-01-14', 'Masuk', 30, 0, '', 1, ''),
(50, '2015-01-14', 'Keluar', 30, 0, '', 10, ''),
(51, '2015-03-14', 'Masuk', 0, 1, '', 77, ''),
(52, '2015-03-14', 'Masuk', 0, 1, '', 77, ''),
(53, '2015-03-14', 'Masuk', 0, 1, '', 77, ''),
(54, '2015-03-14', 'Masuk', 0, 1, '', 77, ''),
(55, '2015-03-14', 'Masuk', 0, 1, '', 19, ''),
(56, '2015-03-14', 'Masuk', 0, 1, '', 1, ''),
(57, '2015-03-14', 'Masuk', 0, 1, '', 7, ''),
(58, '2015-03-14', 'Masuk', 32, 1, '', 12, ''),
(59, '2015-03-14', 'Masuk', 30, 1, '', 89, ''),
(60, '2015-03-14', 'Masuk', 18, 1, '', 11, ''),
(61, '2015-03-14', 'Masuk', 27, 1, '', 17, ''),
(62, '2015-03-14', 'Masuk', 27, 1, '', 1, ''),
(63, '2015-03-15', 'Masuk', 25, 1, '', 7, ''),
(64, '2015-03-15', 'Masuk', 25, 1, '', 3, ''),
(65, '2015-03-15', 'Masuk', 27, 1, '', 5, 'sip'),
(66, '2015-03-15', 'Masuk', 18, 2, '', 9, 'ok dari cabang'),
(67, '2015-03-15', 'Keluar', 25, 1, '', 6, 'dibatalkan'),
(68, '2015-03-23', 'Masuk', 30, 2, '45/9865/DSA/096', 5, 'sip'),
(69, '2015-03-23', 'Keluar', 18, 2, 'TEST/003/9832', 3, 'dese');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `level`) VALUES
('demo', 'e10adc3949ba59abbe56e057f20f883e', 'demo@namadomain.com', 'administrator'),
('admin', '137e7f082963485317ec11718d8b53fe', 'admin@namadomain.com', 'administrator'),
('user1', '96e79218965eb72c92a549dd5a330112', 'user1@namadomain.com', 'report'),
('user2', '96e79218965eb72c92a549dd5a330112', 'user2@namadomain.com', 'gudang-pusat'),
('user3', '96e79218965eb72c92a549dd5a330112', 'user3@namadomain.com', 'gudang-cab1'),
('webmaster', '5c3f7bca6982c77df23223b34bdca2e4', 'webmaster@mobista.click', 'administrator');
