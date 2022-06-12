use admin_stockit;
DROP TABLE IF EXISTS barang;

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
  `nama_barang` varchar(50) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=latin1;

INSERT INTO barang VALUES("1","Perpanjangan USB 5 M (1)","pcs","0","0");
INSERT INTO barang VALUES("2","Perpanjangan USB 1 M (1)","pcs","0","0");
INSERT INTO barang VALUES("3","Kabel Pararel (1)","pcs","0","0");
INSERT INTO barang VALUES("4","Baterai CMOS (3)","pcs","0","0");
INSERT INTO barang VALUES("5","CD Blank reWrite (0)","pcs","0","0");
INSERT INTO barang VALUES("6","DVD Blank reWrite (0)","pcs","0","0");
INSERT INTO barang VALUES("7","Spray WD 40 (0)","botol","0","0");
INSERT INTO barang VALUES("8","Spray Silicon (0)","botol","0","0");
INSERT INTO barang VALUES("9","Kabel UTP (1)","Meter","0","0");
INSERT INTO barang VALUES("10","BAREL  RJ45 (2)","pcs","0","0");
INSERT INTO barang VALUES("11","PCI Card Ethernet (Gigabit) (1)","pcs","0","0");
INSERT INTO barang VALUES("12","Konektor RJ-45 (10)","pcs","0","0");
INSERT INTO barang VALUES("13","Fan CPU + Heatsink LGA 1155 (1)","pcs","0","0");
INSERT INTO barang VALUES("14","Hardisk 500 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("15","Hardisk 250 GB (0)","pcs","0","0");
INSERT INTO barang VALUES("16","Hardisk 160 GB (0)","pcs","0","0");
INSERT INTO barang VALUES("17","SSD 240 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("18","Autocutter Printer Barcode Toshiba BSX-4T (1)","pcs","0","0");
INSERT INTO barang VALUES("19","PRINT HEAD LX-310 (1)","pcs","0","0");
INSERT INTO barang VALUES("20","PRINT HEAD LX-300 (1)","pcs","0","0");
INSERT INTO barang VALUES("21","GEAR RIBON CATRIDGE LX-310 (1)","pcs","0","0");
INSERT INTO barang VALUES("22","TRACKTOR LX-310 (1)","pcs","0","0");
INSERT INTO barang VALUES("23","TRACKTOR LX-300 (1)","pcs","0","0");
INSERT INTO barang VALUES("24","GEAR","pcs","0","0");
INSERT INTO barang VALUES("25","KABEL PRINT HEAD LX-310 (1)","pcs","0","0");
INSERT INTO barang VALUES("26","Power Supply (2)","pcs","0","0");
INSERT INTO barang VALUES("27","RAM DDR3 1 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("28","RAM DDR3 2 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("29","RAM DDR2 512 MB (1)","pcs","0","0");
INSERT INTO barang VALUES("30","RAM DDR2 1 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("31","RAM DDR3 8 GB (0)","pcs","0","0");
INSERT INTO barang VALUES("32","RAM DDR3 4 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("46","KABEL DATA SCANER BARCODE (2)","pcs","0","0");
INSERT INTO barang VALUES("34","RAM So-DIMM 1 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("35","Pita printer LX Series (5)","pcs","0","0");
INSERT INTO barang VALUES("36","Baterai Scaner Wireless QBT New (2)","pcs","0","0");
INSERT INTO barang VALUES("37","Tinta hitam (1)","botol","0","0");
INSERT INTO barang VALUES("38","Tinta Cyan (1)","botol","0","0");
INSERT INTO barang VALUES("39","Tinta Magenta (1)","botol","0","0");
INSERT INTO barang VALUES("40","Tinta Yellow (1)","botol","0","0");
INSERT INTO barang VALUES("41","Tinta Toner (1)","botol","0","0");
INSERT INTO barang VALUES("42","KABEL PRINT HEAD LX-300 (1)","pcs","0","0");
INSERT INTO barang VALUES("43","RAM So Dimm 2 GB","pcs","0","0");
INSERT INTO barang VALUES("44","RAM So Dimm DDR3 1 Gb (1)","pcs","0","0");
INSERT INTO barang VALUES("45","RAM DDR 1 GB (1)","pcs","0","0");
INSERT INTO barang VALUES("47","Kabel Data Scanner","pcs","1","1");
INSERT INTO barang VALUES("48","PRINT HEAD LQ 310 (1)","unit","1","1");
INSERT INTO barang VALUES("49","USB WIFI TP-LINK TL-WN722N (2)","pcs","0","0");
INSERT INTO barang VALUES("50","WIFI PCI EXPRESS CARD 1x TL-WN781D","pcs","0","0");
INSERT INTO barang VALUES("51","WIFI PCI CARD TL-WN751ND (1)","pcs","0","0");
INSERT INTO barang VALUES("52","ETHERNET PCI EXPRESS (1)","pcs","0","0");
INSERT INTO barang VALUES("53","PRINT HEAD EPSON L SERIES (2)","pcs","0","0");



DROP TABLE IF EXISTS gudang;

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL AUTO_INCREMENT,
  `kode_gudang` varchar(20) NOT NULL,
  `nama_gudang` varchar(30) NOT NULL,
  PRIMARY KEY (`id_gudang`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO gudang VALUES("1","EDP","EDP");



DROP TABLE IF EXISTS posisi;

CREATE TABLE `posisi` (
  `id_posisi` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  PRIMARY KEY (`id_posisi`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

INSERT INTO posisi VALUES("26","13","1","1");
INSERT INTO posisi VALUES("27","32","1","8");
INSERT INTO posisi VALUES("28","34","1","2");
INSERT INTO posisi VALUES("29","43","1","1");
INSERT INTO posisi VALUES("30","44","1","1");
INSERT INTO posisi VALUES("31","27","1","15");
INSERT INTO posisi VALUES("32","29","1","3");
INSERT INTO posisi VALUES("33","30","1","2");
INSERT INTO posisi VALUES("34","45","1","2");
INSERT INTO posisi VALUES("35","46","1","1");
INSERT INTO posisi VALUES("36","48","1","3");
INSERT INTO posisi VALUES("37","49","1","6");
INSERT INTO posisi VALUES("38","50","1","5");
INSERT INTO posisi VALUES("39","51","1","2");
INSERT INTO posisi VALUES("40","52","1","1");
INSERT INTO posisi VALUES("41","53","1","3");



DROP TABLE IF EXISTS request;

CREATE TABLE `request` (
  `id_request` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_request` date NOT NULL,
  `username` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id_request`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS satuan;

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(10) NOT NULL,
  PRIMARY KEY (`id_satuan`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO satuan VALUES("1","pcs");
INSERT INTO satuan VALUES("2","kodi");
INSERT INTO satuan VALUES("3","lusin");
INSERT INTO satuan VALUES("4","unit");
INSERT INTO satuan VALUES("5","pack");
INSERT INTO satuan VALUES("6","kantong");
INSERT INTO satuan VALUES("7","kotak");
INSERT INTO satuan VALUES("8","bungkus");
INSERT INTO satuan VALUES("11","biji");
INSERT INTO satuan VALUES("10","lembar");
INSERT INTO satuan VALUES("13","botol");
INSERT INTO satuan VALUES("14","dus");
INSERT INTO satuan VALUES("15","Meter");



DROP TABLE IF EXISTS todo;

CREATE TABLE `todo` (
  `todo_id` int(11) NOT NULL AUTO_INCREMENT,
  `todo_name` varchar(100) NOT NULL,
  `mark` varchar(3) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`todo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS transaksi;

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_transaksi` date NOT NULL,
  `jenis_transaksi` varchar(6) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `no_do` varchar(50) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS user;

CREATE TABLE `user` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `level` varchar(20) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO user VALUES("admin","e10adc3949ba59abbe56e057f20f883e","resya.admin@idm.com","administrator");



