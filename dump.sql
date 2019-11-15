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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sipak` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `sipak`;

/*Table structure for table `bataskategori` */

DROP TABLE IF EXISTS `bataskategori`;

CREATE TABLE `bataskategori` (
  `ID_JABATAN` int(11) NOT NULL,
  `ID_KATEGORI` int(11) NOT NULL,
  `MINIMAL` int(11) NOT NULL,
  `MAKSIMAL` int(11) NOT NULL,
  PRIMARY KEY (`ID_JABATAN`,`ID_KATEGORI`),
  KEY `FK_BATASKAT_MEMILIKI_KATEGORI` (`ID_KATEGORI`),
  CONSTRAINT `FK_BATASKAT_BATAS_UNT_JABATAN` FOREIGN KEY (`ID_JABATAN`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_BATASKAT_MEMILIKI_KATEGORI` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategoripenilaian` (`ID_KATEGORI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `bataskategori` */

/*Table structure for table `itempenilaian` */

DROP TABLE IF EXISTS `itempenilaian`;

CREATE TABLE `itempenilaian` (
  `ID_ITEM` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PAK` int(11) NOT NULL,
  `ID_UNSUR` int(11) NOT NULL,
  `NILAI_AWAL` int(11) DEFAULT NULL,
  `NILAI_1` int(11) DEFAULT NULL,
  `NILAI_2` int(11) DEFAULT NULL,
  `URL_DOKUMEN` varchar(100) DEFAULT NULL,
  `TAHUN` int(11) DEFAULT NULL,
  `SEMESTER` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`ID_ITEM`),
  KEY `FK_ITEMPENI_MEMILIKI1_PAK` (`ID_PAK`),
  KEY `FK_ITEMPENI_MEMILIKI__UNSURPEN` (`ID_UNSUR`),
  CONSTRAINT `FK_ITEMPENI_MEMILIKI1_PAK` FOREIGN KEY (`ID_PAK`) REFERENCES `pak` (`ID_PAK`),
  CONSTRAINT `FK_ITEMPENI_MEMILIKI__UNSURPEN` FOREIGN KEY (`ID_UNSUR`) REFERENCES `unsurpenilaian` (`ID_UNSUR`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `itempenilaian` */

/*Table structure for table `jabatan` */

DROP TABLE IF EXISTS `jabatan`;

CREATE TABLE `jabatan` (
  `ID_JABATAN` int(11) NOT NULL AUTO_INCREMENT,
  `KREDIT` int(11) NOT NULL,
  `JABATAN` varchar(15) NOT NULL,
  `GOLONGAN` varchar(5) NOT NULL,
  PRIMARY KEY (`ID_JABATAN`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `jabatan` */

insert  into `jabatan`(`ID_JABATAN`,`KREDIT`,`JABATAN`,`GOLONGAN`) values 
(1,150,'Asisten Ahli','III/b'),
(2,200,'Lektor','III/c'),
(3,300,'Lektor','III/d'),
(4,400,'Lektor Kepala','IV/a'),
(5,550,'Lektor Kepala','IV/b'),
(6,700,'Lektor Kepala','IV/c'),
(7,850,'Profesor','IV/d'),
(8,1050,'Profesor','IV/e');

/*Table structure for table `kategoripenilaian` */

DROP TABLE IF EXISTS `kategoripenilaian`;

CREATE TABLE `kategoripenilaian` (
  `ID_KATEGORI` int(11) NOT NULL AUTO_INCREMENT,
  `NAMA` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_KATEGORI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `kategoripenilaian` */

/*Table structure for table `logininfo` */

DROP TABLE IF EXISTS `logininfo`;

CREATE TABLE `logininfo` (
  `ID_USER` int(11) NOT NULL,
  `USERNAME` varchar(25) NOT NULL,
  `PASSWORD` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_USER`),
  CONSTRAINT `FK_LOGININF_RELATIONS_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `logininfo` */

insert  into `logininfo`(`ID_USER`,`USERNAME`,`PASSWORD`) values 
(1,'admin','admin'),
(2,'penilai','penilai'),
(3,'dosen','dosen');

/*Table structure for table `pak` */

DROP TABLE IF EXISTS `pak`;

CREATE TABLE `pak` (
  `ID_PAK` int(11) NOT NULL AUTO_INCREMENT,
  `ID_PENILAI_1` int(11) DEFAULT NULL,
  `ID_PENILAI_2` int(11) DEFAULT NULL,
  `ID_JABATAN_TUJUAN` int(11) NOT NULL,
  `ID_PEMOHON` int(11) NOT NULL,
  `ID_JABATAN_AWAL` int(11) NOT NULL,
  `STATUS_PAK` int(11) NOT NULL,
  `TANGGAL_STATUS` date NOT NULL,
  `TANGGAL_DIAJUKAN` date DEFAULT NULL,
  `URL_SK` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_PAK`),
  KEY `FK_PAK_MENILAI_1_USER` (`ID_PENILAI_1`),
  KEY `FK_PAK_MENILAI_2_USER` (`ID_PENILAI_2`),
  KEY `FK_PAK_PAK_UNTUK_JABATAN` (`ID_JABATAN_TUJUAN`),
  KEY `FK_PAK_RELATIONS_USER` (`ID_PEMOHON`),
  KEY `FK_PAK_RELATIONS_JABATAN` (`ID_JABATAN_AWAL`),
  CONSTRAINT `FK_PAK_MENILAI_1_USER` FOREIGN KEY (`ID_PENILAI_1`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_PAK_MENILAI_2_USER` FOREIGN KEY (`ID_PENILAI_2`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_PAK_PAK_UNTUK_JABATAN` FOREIGN KEY (`ID_JABATAN_TUJUAN`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_PAK_RELATIONS_JABATAN` FOREIGN KEY (`ID_JABATAN_AWAL`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_PAK_RELATIONS_USER` FOREIGN KEY (`ID_PEMOHON`) REFERENCES `user` (`ID_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `pak` */

/*Table structure for table `penilailuar` */

DROP TABLE IF EXISTS `penilailuar`;

CREATE TABLE `penilailuar` (
  `ID_USER` int(11) NOT NULL,
  `ID_JABATAN` int(11) NOT NULL,
  `ID_SUB_RUMPUN` int(11) NOT NULL,
  `NIP` varchar(50) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `TELEPON` varchar(15) NOT NULL,
  `ASAL_INSTANSI` varchar(100) NOT NULL,
  PRIMARY KEY (`ID_USER`),
  KEY `FK_PENILAIL_MEMILIKI__JABATAN` (`ID_JABATAN`),
  KEY `FK_PENILAIL_MEMILIKI__SUBRUMPU` (`ID_SUB_RUMPUN`),
  CONSTRAINT `FK_PENILAIL_ADALAH_USER` FOREIGN KEY (`ID_USER`) REFERENCES `user` (`ID_USER`),
  CONSTRAINT `FK_PENILAIL_MEMILIKI__JABATAN` FOREIGN KEY (`ID_JABATAN`) REFERENCES `jabatan` (`ID_JABATAN`),
  CONSTRAINT `FK_PENILAIL_MEMILIKI__SUBRUMPU` FOREIGN KEY (`ID_SUB_RUMPUN`) REFERENCES `subrumpunilmu` (`ID_SUB_RUMPUN`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `penilailuar` */

/*Table structure for table `subrumpunilmu` */

DROP TABLE IF EXISTS `subrumpunilmu`;

CREATE TABLE `subrumpunilmu` (
  `ID_SUB_RUMPUN` int(11) NOT NULL AUTO_INCREMENT,
  `RUMPUN` varchar(25) NOT NULL,
  `SUB_RUMPUN` varchar(25) NOT NULL,
  PRIMARY KEY (`ID_SUB_RUMPUN`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `subrumpunilmu` */

insert  into `subrumpunilmu`(`ID_SUB_RUMPUN`,`RUMPUN`,`SUB_RUMPUN`) values 
(1,'MIPA','IPA'),
(2,'MIPA','Matematika'),
(4,'Teknik','Ilmu Keteknikan Industri'),
(5,'Teknik','Teknik Elektro dan Inform'),
(6,'Ekonomi','Ilmu Ekonomi'),
(7,'Ekonomi','Ilmu Manajemen'),
(8,'Seni, Desain, dan Media','Media');

/*Table structure for table `unsurpenilaian` */

DROP TABLE IF EXISTS `unsurpenilaian`;

CREATE TABLE `unsurpenilaian` (
  `ID_UNSUR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_KATEGORI` int(11) NOT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `BATAS` int(11) DEFAULT NULL,
  `JENIS_BATAS_UNSUR` int(11) DEFAULT NULL,
  `MAX_KREDIT` int(11) DEFAULT NULL,
  `BUKTI` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_UNSUR`),
  KEY `FK_UNSURPEN_MEMILIKI__KATEGORI` (`ID_KATEGORI`),
  CONSTRAINT `FK_UNSURPEN_MEMILIKI__KATEGORI` FOREIGN KEY (`ID_KATEGORI`) REFERENCES `kategoripenilaian` (`ID_KATEGORI`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `unsurpenilaian` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `ID_USER` int(11) NOT NULL AUTO_INCREMENT,
  `ROLE` int(11) NOT NULL,
  `STATUS_USER` int(11) NOT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `ID_PEGAWAI` int(11) DEFAULT NULL,
  `ANGKA_KREDIT` int(11) DEFAULT NULL,
  `KETERANGAN` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_USER`),
  UNIQUE KEY `AK_IDENTIFIER_2` (`ID_PEGAWAI`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`ID_USER`,`ROLE`,`STATUS_USER`,`NAMA`,`ID_PEGAWAI`,`ANGKA_KREDIT`,`KETERANGAN`) values 
(1,4,1,'Admin',NULL,NULL,NULL),
(2,1,1,'Penilai Luar',NULL,NULL,NULL),
(3,3,1,'Dosen',NULL,250,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
