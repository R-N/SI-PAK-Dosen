/*
SQLyog Ultimate v13.1.1 (64 bit)
MySQL - 10.1.34-MariaDB : Database - sipak
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`si-pak-dosen` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `si-pak-dosen`;

/*Table structure for table `batas_kategori` */

CREATE TABLE `batas_kategori` (
  `ID_JABATAN` int(11) NOT NULL,
  `ID_KATEGORI` int(11) NOT NULL,
  `MINIMAL` int(11) DEFAULT NULL,
  `MIN_TYPE` int(1) DEFAULT NULL,
  `MAKSIMAL` int(11) DEFAULT NULL,
  `MAX_TYPE` int(1) DEFAULT NULL,
  PRIMARY KEY (`ID_JABATAN`,`ID_KATEGORI`),
  KEY `FK_BATASKAT_MEMILIKI_KATEGORI` (`ID_KATEGORI`),
  CONSTRAINT `FK_BATASKAT_BATAS_UNT_JABATAN` FOREIGN KEY (`ID_JABATAN`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_BATASKAT_MEMILIKI_KATEGORI` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategori_penilaian` (`ID_KATEGORI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `batas_kategori` */

insert  into `batas_kategori`(`ID_JABATAN`,`ID_KATEGORI`,`MINIMAL`,`MIN_TYPE`,`MAKSIMAL`,`MAX_TYPE`) values 
(1,1,NULL,NULL,NULL,NULL),
(1,2,55,1,NULL,NULL),
(1,3,25,1,NULL,NULL),
(1,4,1,0,10,1),
(1,5,NULL,NULL,10,1),
(2,1,NULL,NULL,NULL,NULL),
(2,2,45,1,NULL,NULL),
(2,3,35,1,NULL,NULL),
(2,4,1,0,10,1),
(2,5,NULL,NULL,10,1),
(3,1,NULL,NULL,NULL,NULL),
(3,2,45,1,NULL,NULL),
(3,3,35,1,NULL,NULL),
(3,4,1,0,10,1),
(3,5,NULL,NULL,10,1),
(4,1,NULL,NULL,NULL,NULL),
(4,2,40,1,NULL,NULL),
(4,3,40,1,NULL,NULL),
(4,4,1,0,10,1),
(4,5,NULL,NULL,10,1),
(5,1,NULL,NULL,NULL,NULL),
(5,2,40,1,NULL,NULL),
(5,3,40,1,NULL,NULL),
(5,4,1,0,10,1),
(5,5,NULL,NULL,10,1),
(6,1,NULL,NULL,NULL,NULL),
(6,2,40,1,NULL,NULL),
(6,3,40,1,NULL,NULL),
(6,4,1,0,10,1),
(6,5,NULL,NULL,10,1),
(7,1,NULL,NULL,NULL,NULL),
(7,2,35,1,NULL,NULL),
(7,3,45,1,NULL,NULL),
(7,4,1,0,10,1),
(7,5,NULL,NULL,10,1),
(8,1,NULL,NULL,NULL,NULL),
(8,2,35,1,NULL,NULL),
(8,3,45,1,NULL,NULL),
(8,4,1,0,10,1),
(8,5,NULL,NULL,10,1);

/*Table structure for table `item_penilaian` */

CREATE TABLE `item_penilaian` (
  `ID_ITEM` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PAK` int(11) NOT NULL,
  `ID_UNSUR` int(11) NOT NULL,
  `NILAI_AWAL` double DEFAULT NULL,
  `NILAI_1` double DEFAULT NULL,
  `NILAI_2` double DEFAULT NULL,
  `URL_DOKUMEN` varchar(100) DEFAULT NULL,
  `TAHUN` int(11) DEFAULT NULL,
  `SEMESTER` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`ID_ITEM`),
  KEY `FK_ITEMPENI_MEMILIKI1_PAK` (`ID_PAK`),
  KEY `FK_ITEMPENI_MEMILIKI__UNSURPEN` (`ID_UNSUR`),
  CONSTRAINT `FK_ITEMPENI_MEMILIKI1_PAK` FOREIGN KEY (`ID_PAK`) REFERENCES `pak` (`ID_PAK`),
  CONSTRAINT `FK_ITEMPENI_MEMILIKI__UNSURPEN` FOREIGN KEY (`ID_UNSUR`) REFERENCES `unsur_penilaian` (`ID_UNSUR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `item_penilaian` */

/*Table structure for table `jabatan` */

CREATE TABLE `jabatan` (
  `ID_JABATAN` int(11) NOT NULL AUTO_INCREMENT,
  `KREDIT` int(11) NOT NULL,
  `JABATAN` varchar(18) NOT NULL,
  PRIMARY KEY (`ID_JABATAN`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `jabatan` */

insert  into `jabatan`(`ID_JABATAN`,`KREDIT`,`JABATAN`) values 
(1,150,'Asisten Ahli III/b'),
(2,200,'Lektor III/c'),
(3,300,'Lektor III/d'),
(4,400,'Lektor Kepala IV/a'),
(5,550,'Lektor Kepala IV/b'),
(6,700,'Lektor Kepala IV/c'),
(7,850,'Profesor IV/d'),
(8,1050,'Profesor IV/e');

/*Table structure for table `jenis_batas` */

CREATE TABLE `jenis_batas` (
  `ID_JENIS_BATAS` int(11) NOT NULL AUTO_INCREMENT,
  `JENIS_BATAS` varchar(192) NOT NULL,
  PRIMARY KEY (`ID_JENIS_BATAS`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `jenis_batas` */

insert  into `jenis_batas`(`ID_JENIS_BATAS`,`JENIS_BATAS`) values 
(1,'per semester'),
(2,'per tahun'),
(3,'per periode penilaian'),
(4,'total angka kredit unsur penelitian yang diperlukan untuk pengusulan ke Lektor Kepala dan Profesor '),
(5,'total angka kredit unsur penelitian yang diperlukan untuk pengusulan ke Lektor Kepala dan Profesor  (untuk karya ilmiah butir; 2.a.4; 2.b.2; 2.c.2; dan 2.d.2)'),
(6,'total angka kredit unsur penelitian untuk pengajuan ke semua jenjang (untuk karya ilmiah butir 2.e dan 3)');

/*Table structure for table `kategori_penilaian` */

CREATE TABLE `kategori_penilaian` (
  `ID_KATEGORI` int(11) NOT NULL AUTO_INCREMENT,
  `KATEGORI` varchar(10) NOT NULL,
  PRIMARY KEY (`ID_KATEGORI`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `kategori_penilaian` */

insert  into `kategori_penilaian`(`ID_KATEGORI`,`KATEGORI`) values 
(1,'Pendidikan'),
(2,'Pengajaran'),
(3,'Penelitian'),
(4,'Pengabdian'),
(5,'Penunjang');

/*Table structure for table `login_info` */

CREATE TABLE `login_info` (
  `ID_USER` int(11) NOT NULL,
  `USERNAME` varchar(25) NOT NULL,
  `PASSWORD` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_USER`),
  UNIQUE KEY `UNIQUE_USERNAME` (`USERNAME`),
  CONSTRAINT `FK_LOGININF_RELATIONS_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `login_info` */

/*Table structure for table `pak` */

CREATE TABLE `pak` (
  `ID_PAK` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PENILAI_1` int(11) DEFAULT NULL,
  `ID_PENILAI_2` int(11) DEFAULT NULL,
  `ID_JABATAN_TUJUAN` int(11) NOT NULL,
  `ID_PEMOHON` int(11) NOT NULL,
  `ID_JABATAN_AWAL` int(11) NOT NULL,
  `ID_STATUS_PAK` int(11) NOT NULL,
  `TANGGAL_STATUS` date NOT NULL,
  `TANGGAL_DIAJUKAN` date DEFAULT NULL,
  `URL_SK` varchar(100) DEFAULT NULL,
  `ID_SUBRUMPUN` int(11) NOT NULL,
  `ID_PENILAI_SUBMIT` int(11) DEFAULT NULL,
  `NILAI_AWAL` double DEFAULT NULL,
  `NILAI_AKHIR` double DEFAULT NULL,
  `KREDIT_AWAL` double NOT NULL,
  `KREDIT_AKHIR` double DEFAULT NULL,
  PRIMARY KEY (`ID_PAK`),
  KEY `FK_PAK_MENILAI_1_USER` (`ID_PENILAI_1`),
  KEY `FK_PAK_MENILAI_2_USER` (`ID_PENILAI_2`),
  KEY `FK_PAK_PAK_UNTUK_JABATAN` (`ID_JABATAN_TUJUAN`),
  KEY `FK_PAK_RELATIONS_USER` (`ID_PEMOHON`),
  KEY `FK_PAK_RELATIONS_JABATAN` (`ID_JABATAN_AWAL`),
  KEY `FK_PAK_SUBRUMPUN` (`ID_SUBRUMPUN`),
  KEY `FK_STATUS_PAK` (`ID_STATUS_PAK`),
  KEY `FK_PENILAI_SUBMIT` (`ID_PENILAI_SUBMIT`),
  CONSTRAINT `FK_PAK_MENILAI_1_USER` FOREIGN KEY (`ID_PENILAI_1`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_PAK_MENILAI_2_USER` FOREIGN KEY (`ID_PENILAI_2`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_PAK_PAK_UNTUK_JABATAN` FOREIGN KEY (`ID_JABATAN_TUJUAN`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_PAK_RELATIONS_JABATAN` FOREIGN KEY (`ID_JABATAN_AWAL`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_PAK_RELATIONS_USER` FOREIGN KEY (`ID_PEMOHON`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_PAK_SUBRUMPUN` FOREIGN KEY (`ID_SUBRUMPUN`) REFERENCES `subrumpun` (`ID_SUBRUMPUN`),
  CONSTRAINT `FK_PENILAI_SUBMIT` FOREIGN KEY (`ID_PENILAI_SUBMIT`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_STATUS_PAK` FOREIGN KEY (`ID_STATUS_PAK`) REFERENCES `status_pak` (`id_status_pak`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pak` */

/*Table structure for table `penilai_luar` */

CREATE TABLE `penilai_luar` (
  `ID_USER` int(11) NOT NULL,
  `ID_JABATAN` int(11) NOT NULL,
  `ID_SUBRUMPUN` int(11) NOT NULL,
  `NIP` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `TELEPON` varchar(15) NOT NULL,
  `ASAL_INSTANSI` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_USER`),
  KEY `FK_PENILAIL_MEMILIKI__JABATAN` (`ID_JABATAN`),
  KEY `FK_PENILAIL_MEMILIKI__SUBRUMPU` (`ID_SUBRUMPUN`),
  CONSTRAINT `FK_PENILAIL_ADALAH_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_PENILAIL_MEMILIKI__JABATAN` FOREIGN KEY (`ID_JABATAN`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_PENILAIL_MEMILIKI__SUBRUMPU` FOREIGN KEY (`ID_SUBRUMPUN`) REFERENCES `subrumpun` (`ID_SUBRUMPUN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penilai_luar` */

/*Table structure for table `status_pak` */

CREATE TABLE `status_pak` (
  `ID_STATUS_PAK` int(11) NOT NULL,
  `STATUS_PAK` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_STATUS_PAK`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `status_pak` */

insert  into `status_pak`(`ID_STATUS_PAK`,`STATUS_PAK`) values 
(1,'Belum disubmit'),
(2,'Baru'),
(3,'Menunggu penilai'),
(4,'Menunggu sidang'),
(5,'Ditolak (nilai kurang)'),
(6,'Ditolak (dalam sidang)'),
(7,'Diterima');

/*Table structure for table `subrumpun` */

CREATE TABLE `subrumpun` (
  `ID_SUBRUMPUN` int(3) NOT NULL AUTO_INCREMENT,
  `ID_RUMPUN` int(3) NOT NULL,
  `SUBRUMPUN` varchar(32) NOT NULL,
  PRIMARY KEY (`ID_SUBRUMPUN`)
) ENGINE=InnoDB AUTO_INCREMENT=841 DEFAULT CHARSET=latin1;

/*Data for the table `subrumpun` */

insert  into `subrumpun`(`ID_SUBRUMPUN`,`ID_RUMPUN`,`SUBRUMPUN`) values 
(110,100,'Ushuluddin'),
(120,100,'Syariah'),
(130,100,'Adab'),
(140,100,'Dakwah'),
(150,100,'Tarbiyah'),
(220,200,'Bahasa'),
(310,300,'Pendidikan'),
(330,300,'Ekonomi'),
(340,300,'Psikologi'),
(350,300,'Komunikasi'),
(380,300,'Sosiologi'),
(410,300,'Politik'),
(420,300,'Perpustakaan'),
(430,300,'Hukum'),
(510,500,'Biologi'),
(520,500,'Fisika'),
(530,500,'Matematika'),
(540,500,'Kimia'),
(550,500,'Farmasi'),
(560,500,'Ilmu Kedokteran'),
(570,500,'Pertanian'),
(580,500,'Peternakan'),
(640,500,'Komputer'),
(810,800,'Teknik'),
(830,800,'Arsitektur'),
(840,800,'Teknik Perencanaan Tata Kota');

/*Table structure for table `unsur_penilaian` */

CREATE TABLE `unsur_penilaian` (
  `ID_UNSUR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_KATEGORI` int(11) NOT NULL,
  `KEGIATAN` varchar(512) NOT NULL,
  `BATAS` int(11) DEFAULT NULL,
  `UNIT` varchar(16) DEFAULT NULL,
  `ID_JENIS_BATAS` int(11) DEFAULT NULL,
  `MAX_KREDIT` int(11) NOT NULL,
  `BUKTI` varchar(128) DEFAULT NULL,
  `KETERANGAN` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID_UNSUR`),
  KEY `FK_UNSURPEN_MEMILIKI__KATEGORI` (`ID_KATEGORI`),
  KEY `FK_BATAS` (`ID_JENIS_BATAS`),
  CONSTRAINT `FK_BATAS` FOREIGN KEY (`ID_JENIS_BATAS`) REFERENCES `jenis_batas` (`ID_JENIS_BATAS`),
  CONSTRAINT `FK_UNSURPEN_MEMILIKI__KATEGORI` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategori_penilaian` (`ID_KATEGORI`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;

/*Data for the table `unsur_penilaian` */

insert  into `unsur_penilaian`(`ID_UNSUR`,`ID_KATEGORI`,`KEGIATAN`,`BATAS`,`UNIT`,`ID_JENIS_BATAS`,`MAX_KREDIT`,`BUKTI`,`KETERANGAN`) values 
(1,1,'Mengikuti pendidikan formal dan memperoleh gelar/sebutan/ijazah : Doktor / sederajat',1,NULL,3,200,'Bukti tugas/izin belajar dan pindai ijazah asli',NULL),
(2,1,'Mengikuti pendidikan formal dan memperoleh gelar/sebutan/ijazah : Magister/sederajat',1,NULL,3,150,'Bukti tugas/izin belajar dan pindai ijazah asli',NULL),
(3,1,'Mengikuti diklat prajabatan golongan III',1,NULL,3,3,'Bukti tugas/izin belajar dan pindai ijazah asli',NULL),
(4,2,'Melaksanakan perkuliahan/tutorial/\nperkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/\nteknologi pengajaran dan praktik lapangan (setiap semester) : Asisten Ahli untuk :  beban mengajar 10 sks pertama',5,NULL,1,1,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(5,2,'Melaksanakan perkuliahan/tutorial/\nperkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/\nteknologi pengajaran dan praktik lapangan (setiap semester) : Asisten Ahli untuk :  beban mengajar 2 sks berikutnya',0,NULL,1,0,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(6,2,'Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan (setiap semester) : Lektor/Lektor Kepala/Profesor untuk : beban mengajar 10 sks pertama',10,NULL,1,1,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(7,2,'Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan (setiap semester) : Lektor/Lektor Kepala/Profesor untuk : beban mengajar 2 sks berikutnya',1,NULL,1,1,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(8,2,'Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pengajaran untuk peserta pendidikan dokter melalui tindakan medik spesialistik',11,NULL,1,4,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(9,2,'Melaksanakan perkuliahan/tutorial/\nperkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/\nteknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pengajaran Konsultasi spesialis kepada peserta pendidikan dokter',11,NULL,1,2,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(10,2,'Melaksanakan perkuliahan/tutorial/\nperkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/\nteknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pemeriksaan luar dengan pembimbingan terhadap peserta pendidikan dokter',11,NULL,1,2,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(11,2,'Melaksanakan perkuliahan/tutorial/\nperkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/\nteknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pemeriksaan dalam dengan pembimbingan terhadap peserta pendidikan dokter',11,NULL,1,3,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(12,2,'Melaksanakan perkuliahan/tutorial/\nperkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/\nteknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Menjadi saksi ahli dengan pembimbingan terhadap peserta pendidikan dokter',11,NULL,1,1,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(13,2,'Membimbing seminar mahasiswa (setiap semester)',NULL,NULL,NULL,1,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(14,2,'Membimbing KKN, Praktik Kerja Nyata, Praktik Kerja Lapangan (setiap semester)',NULL,NULL,NULL,1,'Pindai SK penugasan asli dan bukti kinerja',NULL),
(15,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) : Disertasi',4,'lulusan',1,8,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(16,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) : Tesis',6,'Lulusan',1,3,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(17,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) : Skripsi',8,'Lulusan',1,1,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(18,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) :  Laporan akhir studi',10,'Lulusan',1,1,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(19,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Disertasi',4,'Lulusan',1,6,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(20,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Tesis',6,'Lulusan',1,2,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(21,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Skripsi',8,'Lulusan',1,1,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(22,2,'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Laporan akhir studi',10,'Lulusan',1,1,'Pindai lembar pengesahan dan bukti kinerja',NULL),
(23,2,'Bertugas sebagai penguji pada ujian akhir/Profesi* (setiap mahasiswa) : Ketua Penguji',4,'Lulusan',1,1,'Pindai SK penugasan, bukti kinerja dan undangan',NULL),
(24,2,'Bertugas sebagai penguji pada ujian akhir/Profesi* (setiap mahasiswa) : Anggota Penguji',8,'Lulusan',1,1,'Pindai SK penugasan, bukti kinerja dan undangan',NULL),
(25,2,'Membina kegiatan mahasiswa di bidang akademik dan kemahasiswaan, termasuk dalam kegiatan ini adalah membimbing mahasiswa menghasilkan produk saintifik (setiap semester)',2,'Kegiatan',1,2,'Pindai SK penugasan, dan bukti kinerja',NULL),
(26,2,'Mengembangkan program kuliah yang mempunyai nilai kebaharuan metode atau substansi (setiap produk)',1,'Mata Kuliah',1,2,'File produk',NULL),
(27,2,'Mengembangkan bahan pengajaran/ bahan kuliah yang mempunyai nilai kebaharuan (setiap produk) : Buku ajar',1,'buku',2,20,'File produk',NULL),
(28,2,'Mengembangkan bahan pengajaran/ bahan kuliah yang mempunyai nilai kebaharuan (setiap produk), : Diktat,Modul, Petunjuk praktikum, Model, Alat bantu, Audio visual, Naskah tutorial, Job sheet praktikum terkait dengan mata kuliah yang diampu',1,'Produk',1,5,'File produk',NULL),
(29,2,'Menyampaikan orasi ilmiah di tingkat perguruan tinggi',2,'Orasi',1,5,'File produk',NULL),
(30,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Rektor',1,'Jabatan',1,6,'Pindai SK Jabatan',NULL),
(31,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Wakil rektor/dekan/direktur program pasca sarjana/ketua lembaga',1,'Jabatan',1,5,'Pindai SK Jabatan',NULL),
(32,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Ketua sekolah tinggi/pembantu dekan/asisten direktur program pasca sarjana/direktur politeknik/kepala LLDikti',1,'Jabatan',1,4,'Pindai SK Jabatan',NULL),
(33,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Pembantu ketua sekolah tinggi/pembantu direktur politeknik',1,'Jabatan',1,4,'Pindai SK Jabatan',NULL),
(34,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Direktur akademi',1,'Jabatan',1,4,'Pindai SK Jabatan',NULL),
(35,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Pembantu direktur politeknik, ketua jurusan/ bagian pada universitas/ institut/sekolah tinggi',1,'Jabatan',1,3,'Pindai SK Jabatan',NULL),
(36,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Pembantu direktur akademi/ketua jurusan/ketua prodi pada universitas /politeknik/akademi, sekretaris jurusan/bagian pada universitas /institut/sekolah tinggi',1,'Jabatan',1,3,'Pindai SK Jabatan',NULL),
(37,2,'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Sekretaris jurusan pada politeknik/akademi dan kepala laboratorium (bengkel) universitas/institut/sekolah tinggi/politeknik/akademi',1,'Jabatan',1,3,'Pindai SK Jabatan',NULL),
(38,2,'Membimbing dosen yang mempunyai jabatan akademik lebih rendah setiap semester (bagi dosen Lektor Kepala ke atas) : Pembimbing pencangkokan',1,'Orang',NULL,2,'Pindai SK Penugasan, dan bukti kinerja',NULL),
(39,2,'Membimbing dosen yang mempunyai jabatan akademik lebih rendah setiap semester (bagi dosen Lektor Kepala ke atas) : Reguler',1,'Orang',NULL,1,'Pindai SK Penugasan, dan bukti kinerja',NULL),
(40,2,'Melaksanakan kegiatan detasering dan pencangkokan di luar institusi tempat bekerja setiap semester (bagi dosen Lektor kepala ke atas) : Detasering',1,'Orang',NULL,5,'Pindai SK Penugasan, dan bukti kinerja',NULL),
(41,2,'Melaksanakan kegiatan detasering dan pencangkokan di luar institusi tempat bekerja setiap semester (bagi dosen Lektor kepala ke atas) : Pencangkokan',1,'Orang',NULL,4,'Pindai SK Penugasan, dan bukti kinerja',NULL),
(42,2,'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya lebih dari 960 jam',NULL,NULL,NULL,15,'Pindai sertifikat asli',NULL),
(43,2,'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 641- 960 jam',NULL,NULL,NULL,9,'Pindai sertifikat asli',NULL),
(44,2,'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 481- 640 jam',NULL,NULL,NULL,6,'Pindai sertifikat asli',NULL),
(45,2,'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 161- 480 jam',NULL,NULL,NULL,3,'Pindai sertifikat asli',NULL),
(46,2,'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 81- 160 jam',NULL,NULL,NULL,2,'Pindai sertifikat asli',NULL),
(47,2,'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 30 - 80 jam',NULL,NULL,NULL,1,'Pindai sertifikat asli',NULL),
(48,2,'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 10 - 30 jam',NULL,NULL,NULL,1,'Pindai sertifikat asli',NULL),
(49,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan dalam bentuk buku : Buku referensi',1,'Buku',2,40,'Pindai halaman sampul, dan bukti kinerja',NULL),
(50,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan dalam bentuk buku : Monograf',1,'Buku',2,20,'Pindai halaman sampul dan bukti kinerja',NULL),
(51,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran dalam buku yang dipublikasikan dan berisi berbagai tulisan dari berbagai penulis (book chapter) : Internasional',1,'Buku',2,15,'Pindai halaman sampul, daftar isi dan bukti kinerja',NULL),
(52,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran dalam buku yang dipublikasikan dan berisi berbagai tulisan dari berbagai penulis (book chapter) : Nasional',1,'Buku',2,10,'Pindai halaman sampul, daftar isi dan bukti kinerja',NULL),
(53,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan : Jurnal internasional bereputasi (terindeks pada database internasional bereputasi dan berfaktor dampak)',NULL,NULL,NULL,40,'Pindai halaman sampul, daftar isi, dewan redaksi/redaksi pelaksana dan bukti kinerja','Penjelasan Butir 12.2 Untuk pemenuhan persyaratan khusus'),
(54,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan : Jurnal internasional terindeks pada basis data internasional bereputasi',NULL,NULL,NULL,30,'Pindai halaman sampul, daftar isi,dewan redaksi/redaksi pelaksana dan bukti kinerja','Penjelasan Butir 12.1 Untuk pemenuhan persyaratan khusus'),
(55,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan : Jurnal internasional terindeks pada basis data internasional di luar kategori 2)',NULL,NULL,NULL,20,'Pindai halaman sampul, daftar isi, redaksi pelaksana dan bukti kinerja','Termasuk jurnal terindeks di Web of Science Clarivate Analytics Kelompok Emerging Sources Citation Index (ESCI)'),
(56,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :   Jurnal Nasional terakreditasi Dikti',NULL,NULL,NULL,25,'Pindai halaman sampul, daftar isi, dewan redaksi/redaksi pelaksana  dan bukti kinerja',NULL),
(57,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal nasional terakreditasi Kemenristekdikti peringkat 1 dan 2',NULL,NULL,NULL,25,'Pindai halaman sampul, daftar isi, dewan redaksi/redaksi pelaksana  dan bukti kinerja',NULL),
(58,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal Nasional berbahasa\nInggris atau bahasa resmi (PBB) terindeks pada basis data yang diakui Kemenristekdikti, contohnya: CABI atau Index Copernicus International (ICI).',NULL,NULL,NULL,20,'Pindai halaman sampul, dewan\nredaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja',NULL),
(59,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :   Jurnal nasional terakreditasi peringkat 3 dan 4',NULL,NULL,NULL,20,'Pindai halaman sampul, dewan\nredaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja',NULL),
(60,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal Nasional berbahasa Indonesia terindeks pada basis data yang diakui Kemenristekdikti, contohnya : akreditasi peringkat 5 dan 6',NULL,NULL,NULL,15,'Pindai halaman sampul, dewan\nredaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja',NULL),
(61,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal Nasional',25,'%',4,10,'Pindai halaman sampul, dewan\nredaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja',NULL),
(62,3,'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal ilmiah yang ditulis dalam Bahasa Resmi PBB namun tidak memenuhi syarat-syarat sebagai jurnal ilmiah internasional',NULL,NULL,NULL,10,'Pindai halaman sampul, dewan\nredaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja',NULL),
(63,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Internasional terindeks pada Scimagojr dan Scopus',NULL,NULL,NULL,30,'Pindai halaman sampul, Panitia pelaksana, Panitia pengarah, daftar isi dan bukti kinerja',NULL),
(64,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Internasional terindeks pada SCOPUS, IEEE Explore, SPIE',NULL,NULL,NULL,25,'Pindai halaman sampul, Panitia pelaksana, Panitia pengarah, daftar isi dan bukti kinerja',NULL),
(65,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Internasional',NULL,NULL,NULL,15,'Pindai halaman sampul, Panitia pelaksana, Panitia pengarah, daftar isi dan bukti kinerja',NULL),
(66,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Nasional',NULL,NULL,NULL,10,'Pindai halaman sampul, Panitia Pelaksana, Panitia pengarah, daftar isi dan bukti kinerja',NULL),
(67,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam bentuk poster dan dimuat dalam prosiding yang dipublikasikan: Internasional',NULL,NULL,NULL,10,'Pindai poster, Panitia Pelaksana, Panitia Pengarah daftar isi dan buku panduan',NULL),
(68,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam bentuk poster dan dimuat dalam prosiding yang dipublikasikan : Nasional',NULL,NULL,NULL,5,'Pindai poster, Panitia Pelaksana, Panitia pengarah, daftar isi dan bukun panduan',NULL),
(69,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam seminar/simposium/ lokakarya, tetapi tidak dimuat dalam prosiding yang dipublikasikan : Internasional',NULL,NULL,NULL,5,'Pindai bukti kehadiran atau sertifikat dan bukti kinerja, Panitia',NULL),
(70,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam seminar/simposium/ lokakarya, tetapi tidak dimuat dalam prosiding yang dipublikasikan : Nasional',NULL,NULL,NULL,3,'Pindai bukti kehadiran atau sertifikat dan bukti kinerja',NULL),
(71,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Hasil penelitian/pemikiran yang tidak disajikan dalam seminar/simposium/ lokakarya, tetapi dimuat dalam prosiding : Internasional',NULL,NULL,NULL,10,'Pindai halaman sampul, daftar isi makalah, dan bukti kinerja',NULL),
(72,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Hasil penelitian/pemikiran yang tidak disajikan dalam seminar/simposium/ lokakarya, tetapi dimuat dalam prosiding : Nasional',NULL,NULL,NULL,5,'Pindai halaman sampul, daftar isi makalah, dan bukti kinerja',NULL),
(73,3,'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Hasil penelitian/pemikiran yang disajikan dalam koran/majalah populer/umum',5,'%',6,1,'Pindai halaman sampul dan bukti kinerja',NULL),
(74,3,'Hasil penelitian atau pemikiran atau kerjasama industri yang tidak dipublikasikan (tersimpan dalam perpustakaan) yang dilakukan secara melembaga',5,'%',6,2,'Pindai halaman sampul, daftar isi, lembar pengesahan dan bukti kinerja',NULL),
(75,3,'Menerjemahkan/menyadur buku ilmiah yang diterbitkan (ber ISBN)',NULL,NULL,NULL,15,'Pindai halaman sampul dan bukti kinerja yang dapat diakses oleh asesor',NULL),
(76,3,'Mengedit/menyunting karya ilmiah dalam bentuk buku yang diterbitkan (ber ISBN)',NULL,NULL,NULL,10,'Pindai halaman sampul dan bukti kinerja yang dapat diakses oleh asesor',NULL),
(77,3,'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Internasional yang sudah diimplementasikan di industri (paling sedikit diakui oleh 4 Negara)',NULL,NULL,NULL,60,'Pindai bukti kinerja dan sertifikat paten',NULL),
(78,3,'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Internasional (paling sedikit diakui oleh 4 Negara)',NULL,NULL,NULL,50,'Pindai bukti kinerja dan sertifikat paten',NULL),
(79,3,'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Nasional (yang sudah diimplementasikan di industri)',NULL,NULL,NULL,40,'Pindai bukti kinerja dan sertifikat paten',NULL),
(80,3,'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Nasional',NULL,NULL,NULL,30,'Pindai bukti kinerja dan sertifikat paten',NULL),
(81,3,'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Nasional, dalam bentuk paten sederhana yang telah memiliki sertifikat dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham;',NULL,NULL,NULL,20,'Pindai bukti kinerja dan sertifikat paten',NULL),
(82,3,'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Karya ciptaan, desain industri, indikasi geografis yang telah memiliki sertifikat dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham; Karya cipta berupa buku yang telah mendapatkan sertifikat karya cipta dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham maka karya cipta tersebut hanya dapat diajukan salah satu sebagai bukti melaksanakan penelitian atau pendidikan.',2,'Karya',1,15,'Pindai bukti kinerja dan sertifikat dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham',NULL),
(83,3,'Membuat rancangan dan karya teknologi yang tidak dipatenkan; rancangan dan karya seni monumental yang tidak terdaftar di HaKI tetapi telah dipresentasikan pada forum yang teragenda : Tingkat Internasional',NULL,NULL,NULL,20,'Pindai bukti kinerja, peer review internasional  sesuai bidang ilmu',NULL),
(84,3,'Membuat rancangan dan karya teknologi yang tidak dipatenkan; rancangan dan karya seni monumental yang tidak terdaftar di HaKI tetapi telah dipresentasikan pada forum yang teragenda : Tingkat Nasional',NULL,NULL,NULL,15,'Pindai bukti kinerja, peer review sesuai bidang ilmu',NULL),
(85,3,'Membuat rancangan dan karya teknologi yang tidak dipatenkan; rancangan dan karya seni monumental yang tidak terdaftar di HaKI tetapi telah dipresentasikan pada forum yang teragenda : Tingkat Lokal',NULL,NULL,NULL,10,'Pindai bukti kinerja, peer review sesuai bidang ilmu',NULL),
(86,3,'Pelaksanaan penelitian karya seni sebagai komposer/penulis naskah/sutradara/perancang/pencipta/pengubah/kameramen/animator/kurator/editor audio visual internasional',NULL,'Karya',NULL,20,NULL,NULL),
(87,3,'Pelaksanaan penelitian karya seni sebagai komposer/penulis naskah/sutradara/perancang/pencipta/pengubah/kameramen/animator/kurator/editor audio visual nasional',NULL,'Karya',NULL,15,NULL,NULL),
(88,3,'Pelaksanaan penelitian karya seni sebagai komposer/penulis naskah/sutradara/perancang/pencipta/pengubah/kameramen/animator/kurator/editor audio visual lokal',NULL,'Karya',NULL,10,NULL,NULL),
(89,3,'Pelaksanaan penelitian kayra seni Sebagai Penata Arstistik/Penata Musik/Penata Rias/PenataBusana/Penata Tari/Penata Lampu/Penata Suara/Penata Panggung/Ilustrator Foto/Kunduktor Internasional',NULL,'Pentas',NULL,10,NULL,NULL),
(90,3,'Pelaksanaan penelitian kayra seni Sebagai Penata Arstistik/Penata Musik/Penata Rias/Penata Busana/Penata Tari/Penata Lampu/Penata Suara/Penata Panggung/Ilustrator Foto/Kunduktor nasional',NULL,'Pentas',NULL,6,NULL,NULL),
(91,3,'Pelaksanaan penelitian kayra seni Sebagai Penata Arstistik/Penata Musik/Penata Rias/PenataBusana/Penata Tari/Penata Lampu/Penata Suara/Penata Panggung/Ilustrator Foto/Kunduktor lokal',NULL,'Pentas',NULL,3,NULL,NULL),
(92,3,'Pelaksanaan penelitian karya seni Sebagai Pemusik/Pengrawit/Penari/Dalang/Pemeran/Pengarah Acara Televisi/Pelaksana Perancangan/Pendisplay Pameran/Pembuat Foto Dokumentasi/Pewarta Foto/Pembawa Acara/Reporter/Redaktur Pelaksana Internasional',NULL,'Sajian',NULL,6,NULL,NULL),
(93,3,'Pelaksanaan penelitian karya seni Sebagai Pemusik/Pengrawit/Penari/Dalang/Pemeran/Pengarah Acara Televisi/Pelaksana Perancangan/Pendisplay Pameran/Pembuat Foto Dokumentasi/Pewarta Foto/Pembawa Acara/Reporter/Redaktur Pelaksana nasional',NULL,'Sajian',NULL,4,NULL,NULL),
(94,3,'Pelaksanaan penelitian karya seni Sebagai Pemusik/Pengrawit/Penari/Dalang/Pemeran/Pengarah Acara Televisi/Pelaksana Perancangan/ Pendisplay Pameran/Pembuat Foto Dokumentasi/Pewarta Foto/Pembawa Acara/Reporter/Redaktur Pelaksana lokal',NULL,'Sajian',NULL,2,NULL,NULL),
(95,3,'Pelaksanaan penelitian karya seni Sebagai Penulis Naskah Drama/Novel Internasional',NULL,'Karya',NULL,20,NULL,NULL),
(96,3,'Pelaksanaan penelitian karya seni Sebagai Penulis Naskah Drama/Novel nasional',NULL,'Karya',NULL,15,NULL,NULL),
(97,3,'Pelaksanaan penelitian karya seni Sebagai Penulis Naskah Drama/Novel lokal',NULL,'Karya',NULL,10,NULL,NULL),
(98,3,'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Internasional',NULL,'Karya',NULL,20,NULL,NULL),
(99,3,'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Nasional',NULL,'Karya',NULL,15,NULL,NULL),
(100,3,'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Internasional',NULL,'Karya',NULL,10,NULL,NULL),
(101,3,'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Puisi Internasional',NULL,'Karya',NULL,20,NULL,NULL),
(102,3,'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Nasional',NULL,'Karya',NULL,15,NULL,NULL),
(103,3,'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Lokal',NULL,'Karya',NULL,10,NULL,NULL),
(104,4,'Menduduki jabatan pimpinan pada lembaga pemerintahan/pejabat negara yang harus dibebaskan dari jabatan organiknya tiap semester.',NULL,NULL,NULL,6,NULL,NULL),
(105,4,'Melaksanakan pengembangan hasil pendidikan, dan penelitian yang dapat dimanfaatkan oleh masyarakat/ industry setiap program.',NULL,NULL,NULL,3,NULL,NULL),
(106,4,'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Dalam satu semester atau lebih :  Tingkat Internasional tiap program',NULL,NULL,NULL,4,NULL,NULL),
(107,4,'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Dalam satu semester atau lebih :  Tingkat Nasional, tiap program',NULL,NULL,NULL,3,NULL,NULL),
(108,4,'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Dalam satu semester atau lebih :  Tingkat Lokal, tiap program',NULL,NULL,NULL,2,NULL,NULL),
(109,4,'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Tingkat Internasional tiap program',NULL,NULL,NULL,3,NULL,NULL),
(110,4,'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Tingkat Nasional, tiap program',NULL,NULL,NULL,2,NULL,NULL),
(111,4,'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Tingkat Lokal, tiap program',NULL,NULL,NULL,1,NULL,NULL),
(112,4,'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Insidental, tiap kegiatan/program',NULL,NULL,NULL,1,NULL,NULL),
(113,4,'Memberi pelayanan kepada masyarakat atau kegiatan lain yang menunjang pelaksanaan tugas pemerintahan dan pembangunan : Berdasarkan bidang keahlian, tiap program',NULL,NULL,NULL,2,NULL,NULL),
(114,4,'Memberi pelayanan kepada masyarakat atau kegiatan lain yang menunjang pelaksanaan tugas pemerintahan dan pembangunan :  Berdasarkan penugasan lembaga terguruan tinggi, tiap program',NULL,NULL,NULL,1,NULL,NULL),
(115,4,'Memberi pelayanan kepada masyarakat atau kegiatan lain yang menunjang pelaksanaan tugas pemerintahan dan pembangunan :  Berdasarkan fungsi/jabatan tiap program',NULL,NULL,NULL,1,NULL,NULL),
(116,4,'Membuat/menulis karya pengabdian pada masyarakat yang tidak dipublikasikan,tiap karya',NULL,NULL,NULL,3,NULL,NULL),
(117,4,'Hasil kegiatan pengabdian kepada masyarakat yang dipublikasikan di sebuah berkala/jurnal pengabdian kepada masyarakat atau teknologi tepat guna, merupakan diseminasi dari luaran program kegiatan pengabdian kepada masyarakat, tiap karya',NULL,NULL,NULL,5,NULL,NULL),
(118,4,'Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun)* : Editor/dewan penyunting/dewan redaksi jurnal ilmiah internasional (Diakui satu jurnal)',NULL,NULL,NULL,1,NULL,NULL),
(119,4,'Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun)* :  Editor/dewan penyunting/dewan redaksi jurnal ilmiah nasional (Diakui satu jurnal)',NULL,NULL,NULL,1,NULL,NULL),
(120,5,'Menjadi anggota dalam suatu Panitia/Badan pada Perguruan Tinggi  sebagai Ketua/Wakil Ketua merangkap Anggota, tiap tahun',NULL,NULL,NULL,3,NULL,NULL),
(121,5,'Menjadi anggota dalam suatu Panitia/Badan pada Perguruan Tinggi sebagai Anggota, tiap tahun',NULL,NULL,NULL,2,NULL,NULL),
(122,5,'Menjadi anggota panitia/badan pada lembaga pemerintah  panitia pusat, sebagai Ketua/Wakil Ketua, tiap kepanitiaan',NULL,NULL,NULL,3,NULL,NULL),
(123,5,'Menjadi anggota panitia/badan pada lembaga pemerintah  panitia pusat, sebagai Anggota, tiap kepanitiaan',NULL,NULL,NULL,2,NULL,NULL),
(124,5,'Menjadi anggota panitia/badan pada lembaga pemerintah panitia daerah, sebagai Ketua/Wakil Ketua, tiap kepanitiaan',NULL,NULL,NULL,2,NULL,NULL),
(125,5,'Menjadi anggota panitia/badan pada lembaga pemerintah panitia daerah, sebagai Anggota, tiap kepanitiaan',NULL,NULL,NULL,1,NULL,NULL),
(126,5,'Menjadi anggota organisasi profesi Tingkat Internasional, sebagai :  Pengurus, tiap periode jabatan pengurus merangkap anggota',NULL,NULL,NULL,2,NULL,NULL),
(127,5,'Menjadi anggota organisasi profesi Tingkat Internasional, sebagai :  Anggota atas permintaan, tiap periode jabatan',NULL,NULL,NULL,1,NULL,NULL),
(128,5,'Menjadi anggota organisasi profesi Tingkat Internasional, sebagai : Anggota, tiap periode jabatan',NULL,NULL,NULL,1,NULL,NULL),
(129,5,'Menjadi anggota organisasi profesi Tingkat Nasional, sebagai :  Pengurus, tiap periode jabatan',NULL,NULL,NULL,2,NULL,NULL),
(130,5,'Menjadi anggota organisasi profesi Tingkat Nasional, sebagai : Anggota, atas permintaan, tiap periode jabatan',NULL,NULL,NULL,1,NULL,NULL),
(131,5,'Menjadi anggota organisasi profesi Tingkat Nasional, sebagai : Anggota, tiap periode jabatan',NULL,NULL,NULL,1,NULL,NULL),
(132,5,'Mewakili Perguruan Tinggi/Lembaga Pemerintah duduk dalam Panitia Antar Lembaga, tiap kepanitiaan',NULL,NULL,NULL,1,NULL,NULL),
(133,5,'Menjadi anggota delegasi Nasional ke pertemuan Internasional Sebagai Ketua delegasi, tiap kegiatan',NULL,NULL,NULL,3,NULL,NULL),
(134,5,'Menjadi anggota delegasi Nasional ke pertemuan Internasional Sebagai Anggota, tiap kegiatan',NULL,NULL,NULL,2,NULL,NULL),
(135,5,'Berperan serta aktif dalam pertemuan ilmiah tingkat Internasional/Nasional/Regional sebagai : Ketua, tiap kegiatan',NULL,NULL,NULL,3,NULL,NULL),
(136,5,'Berperan serta aktif dalam pertemuan ilmiah Tingkat Internasional/Nasional/Regional sebagai : Anggota/peserta, tiap kegiatan',NULL,NULL,NULL,2,NULL,NULL),
(137,5,'Berperan serta aktif dalam pertemuan ilmiah Di lingkungan Perguruan Tinggi sebagai :  Ketua, tiap kegiatan',NULL,NULL,NULL,2,NULL,NULL),
(138,5,'Berperan serta aktif dalam pertemuan ilmiah Di lingkungan Perguruan Tinggi sebagai :  Anggota/peserta, tiap kegiatan',NULL,NULL,NULL,1,NULL,NULL),
(139,5,'Mendapat tanda jasa/penghargaan : Penghargaan/tanda jasa Satya lencana 30 tahun',NULL,NULL,NULL,3,NULL,NULL),
(140,5,'Mendapat tanda jasa/penghargaan : Penghargaan/tanda jasa Satya lencana 20 tahun',NULL,NULL,NULL,2,NULL,NULL),
(141,5,'Mendapat tanda jasa/penghargaan : Penghargaan/tanda jasa Satya lencana 10 tahun',NULL,NULL,NULL,1,NULL,NULL),
(142,5,'Mendapat tanda jasa/penghargaan : Tingkat Internasional, tiap tanda jasa/penghargaan',NULL,NULL,NULL,5,NULL,NULL),
(143,5,'Mendapat tanda jasa/penghargaan : Tingkat Nasional, tiap tanda jasa/penghargaan',NULL,NULL,NULL,3,NULL,NULL),
(144,5,'Mendapat tanda jasa/penghargaan :  Tingkat Daerah/Lokal, tiap tanda jasa/penghargaan',NULL,NULL,NULL,1,NULL,NULL),
(145,5,'Menulis buku pelajaran SLTA ke bawah yang diterbitkan dan diedarkan secara nasional :  Buku SMTA atau setingkat, tiap buku',NULL,NULL,NULL,5,NULL,NULL),
(146,5,'Menulis buku pelajaran SLTA ke bawah yang diterbitkan dan diedarkan secara nasional :  Buku SMTP atau setingkat, tiap buku',NULL,NULL,NULL,5,NULL,NULL),
(147,5,'Menulis buku pelajaran SLTA ke bawah yang diterbitkan dan diedarkan secara nasional :   Buku SD atau setingkat, tiap buku',NULL,NULL,NULL,5,NULL,NULL),
(148,5,'Mempunyai prestasi di bidang olahraga/ Humaniora : Tingkat Internasional, tiap piagam/medali',NULL,NULL,NULL,5,NULL,NULL),
(149,5,'Mempunyai prestasi di bidang olahraga/ Humaniora : Tingkat Nasional, tiap piagam/medali',NULL,NULL,NULL,3,NULL,NULL),
(150,5,'Mempunyai prestasi di bidang olahraga/ Humaniora : Tingkat Daerah/Lokal, tiap piagam/medali',NULL,NULL,NULL,1,NULL,NULL),
(151,5,'Keanggotaan dalam tim penilai jabatan akademik dosen',NULL,NULL,NULL,1,NULL,NULL);

/*Table structure for table `user` */

CREATE TABLE `user` (
  `ID_USER` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE` int(11) NOT NULL,
  `STATUS_USER` int(11) NOT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `ID_PEGAWAI` varchar(18) DEFAULT NULL,
  `KETERANGAN` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_USER`),
  UNIQUE KEY `AK_IDENTIFIER_2` (`ID_PEGAWAI`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
