/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     10/25/2019 8:33:24 AM                        */
/*==============================================================*/


alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_BATAS_UNT_JABATAN;

alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_MEMILIKI_KATEGORI;

alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI1_PAK;

alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI__UNSURPEN;

alter table LOGININFO 
   drop foreign key FK_LOGININF_RELATIONS_USER;

alter table PAK 
   drop foreign key FK_PAK_MENILAI_1_USER;

alter table PAK 
   drop foreign key FK_PAK_MENILAI_2_USER;

alter table PAK 
   drop foreign key FK_PAK_PAK_UNTUK_JABATAN;

alter table PAK 
   drop foreign key FK_PAK_RELATIONS_USER;

alter table PAK 
   drop foreign key FK_PAK_RELATIONS_JABATAN;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_ADALAH_USER;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMILIKI__JABATAN;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMILIKI__SUBRUMPU;

alter table UNSURPENILAIAN 
   drop foreign key FK_UNSURPEN_MEMILIKI__KATEGORI;


alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_MEMILIKI_KATEGORI;

alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_BATAS_UNT_JABATAN;

drop table if exists BATASKATEGORI;


alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI1_PAK;

alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI__UNSURPEN;

drop table if exists ITEMPENILAIAN;

drop table if exists JABATAN;

drop table if exists KATEGORIPENILAIAN;


alter table LOGININFO 
   drop foreign key FK_LOGININF_RELATIONS_USER;

drop table if exists LOGININFO;


alter table PAK 
   drop foreign key FK_PAK_MENILAI_1_USER;

alter table PAK 
   drop foreign key FK_PAK_MENILAI_2_USER;

alter table PAK 
   drop foreign key FK_PAK_PAK_UNTUK_JABATAN;

alter table PAK 
   drop foreign key FK_PAK_RELATIONS_USER;

alter table PAK 
   drop foreign key FK_PAK_RELATIONS_JABATAN;

drop table if exists PAK;


alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMILIKI__JABATAN;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMILIKI__SUBRUMPU;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_ADALAH_USER;

drop table if exists PENILAILUAR;

drop table if exists SUBRUMPUNILMU;


alter table UNSURPENILAIAN 
   drop foreign key FK_UNSURPEN_MEMILIKI__KATEGORI;

drop table if exists UNSURPENILAIAN;

drop table if exists USER;

/*==============================================================*/
/* Table: BATASKATEGORI                                         */
/*==============================================================*/
create table BATASKATEGORI
(
   ID_JABATAN           int not null  comment '',
   ID_KATEGORI          int not null  comment '',
   MINIMAL              int not null  comment '',
   MAKSIMAL             int not null  comment '',
   primary key (ID_JABATAN, ID_KATEGORI)
);

/*==============================================================*/
/* Table: ITEMPENILAIAN                                         */
/*==============================================================*/
create table ITEMPENILAIAN
(
   ID_ITEM              int(11) not null auto_increment  comment '',
   ID_PAK               int not null  comment '',
   ID_UNSUR             int not null  comment '',
   NILAI_AWAL           int  comment '',
   NILAI_1              int  comment '',
   NILAI_2              int  comment '',
   URL_DOKUMEN          varchar(100)  comment '',
   TAHUN                int  comment '',
   SEMESTER             tinyint  comment '',
   primary key (ID_ITEM)
);

/*==============================================================*/
/* Table: JABATAN                                               */
/*==============================================================*/
create table JABATAN
(
   ID_JABATAN           int(11) not null auto_increment  comment '',
   KREDIT               int not null  comment '',
   JABATAN              varchar(15) not null  comment '',
   GOLONGAN             varchar(5) not null  comment '',
   primary key (ID_JABATAN)
);

/*==============================================================*/
/* Table: KATEGORIPENILAIAN                                     */
/*==============================================================*/
create table KATEGORIPENILAIAN
(
   ID_KATEGORI          int(11) not null auto_increment  comment '',
   NAMA                 varchar(50)  comment '',
   primary key (ID_KATEGORI)
);

/*==============================================================*/
/* Table: LOGININFO                                             */
/*==============================================================*/
create table LOGININFO
(
   ID_USER              int not null  comment '',
   USERNAME             varchar(25) not null  comment '',
   PASSWORD             varchar(25) not null  comment '',
   primary key (ID_USER)
);

/*==============================================================*/
/* Table: PAK                                                   */
/*==============================================================*/
create table PAK
(
   ID_PAK               int(11) not null auto_increment  comment '',
   ID_PENILAI_1         int  comment '',
   ID_PENILAI_2         int  comment '',
   ID_JABATAN_TUJUAN    int not null  comment '',
   ID_PEMOHON           int not null  comment '',
   ID_JABATAN_AWAL      int not null  comment '',
   STATUS_PAK           int not null  comment '',
   TANGGAL_STATUS       date not null  comment '',
   TANGGAL_DIAJUKAN     date  comment '',
   URL_SK               varchar(100)  comment '',
   primary key (ID_PAK)
);

/*==============================================================*/
/* Table: PENILAILUAR                                           */
/*==============================================================*/
create table PENILAILUAR
(
   ID_USER              int not null  comment '',
   ID_JABATAN           int not null  comment '',
   ID_SUB_RUMPUN        int not null  comment '',
   NIP                  varchar(50) not null  comment '',
   EMAIL                varchar(50) not null  comment '',
   TELEPON              varchar(15) not null  comment '',
   ASAL_INSTANSI        varchar(100) not null  comment '',
   primary key (ID_USER)
);

/*==============================================================*/
/* Table: SUBRUMPUNILMU                                         */
/*==============================================================*/
create table SUBRUMPUNILMU
(
   ID_SUB_RUMPUN        int(11) not null auto_increment  comment '',
   RUMPUN               varchar(25) not null  comment '',
   SUB_RUMPUN           varchar(25) not null  comment '',
   primary key (ID_SUB_RUMPUN)
);

/*==============================================================*/
/* Table: UNSURPENILAIAN                                        */
/*==============================================================*/
create table UNSURPENILAIAN
(
   ID_UNSUR             int(11) not null auto_increment  comment '',
   ID_KATEGORI          int not null  comment '',
   NAMA                 varchar(50)  comment '',
   BATAS                int  comment '',
   JENIS_BATAS_UNSUR    int  comment '',
   MAX_KREDIT           int  comment '',
   BUKTI                varchar(50)  comment '',
   primary key (ID_UNSUR)
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   ID_USER              int(11) not null auto_increment  comment '',
   ROLE                 int not null  comment '',
   STATUS_USER          int not null  comment '',
   NAMA                 varchar(50)  comment '',
   ID_PEGAWAI           int  comment '',
   ANGKA_KREDIT         int  comment '',
   KETERANGAN           varchar(100)  comment '',
   primary key (ID_USER),
   unique key AK_IDENTIFIER_2 (ID_PEGAWAI)
);

alter table BATASKATEGORI add constraint FK_BATASKAT_BATAS_UNT_JABATAN foreign key (ID_JABATAN)
      references JABATAN (ID_JABATAN) on delete restrict on update restrict;

alter table BATASKATEGORI add constraint FK_BATASKAT_MEMILIKI_KATEGORI foreign key (ID_KATEGORI)
      references KATEGORIPENILAIAN (ID_KATEGORI) on delete restrict on update restrict;

alter table ITEMPENILAIAN add constraint FK_ITEMPENI_MEMILIKI1_PAK foreign key (ID_PAK)
      references PAK (ID_PAK) on delete restrict on update restrict;

alter table ITEMPENILAIAN add constraint FK_ITEMPENI_MEMILIKI__UNSURPEN foreign key (ID_UNSUR)
      references UNSURPENILAIAN (ID_UNSUR) on delete restrict on update restrict;

alter table LOGININFO add constraint FK_LOGININF_RELATIONS_USER foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_MENILAI_1_USER foreign key (ID_PENILAI_1)
      references USER (ID_USER) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_MENILAI_2_USER foreign key (ID_PENILAI_2)
      references USER (ID_USER) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_PAK_UNTUK_JABATAN foreign key (ID_JABATAN_TUJUAN)
      references JABATAN (ID_JABATAN) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_RELATIONS_USER foreign key (ID_PEMOHON)
      references USER (ID_USER) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_RELATIONS_JABATAN foreign key (ID_JABATAN_AWAL)
      references JABATAN (ID_JABATAN) on delete restrict on update restrict;

alter table PENILAILUAR add constraint FK_PENILAIL_ADALAH_USER foreign key (ID_USER)
      references USER (ID_USER) on delete restrict on update restrict;

alter table PENILAILUAR add constraint FK_PENILAIL_MEMILIKI__JABATAN foreign key (ID_JABATAN)
      references JABATAN (ID_JABATAN) on delete restrict on update restrict;

alter table PENILAILUAR add constraint FK_PENILAIL_MEMILIKI__SUBRUMPU foreign key (ID_SUB_RUMPUN)
      references SUBRUMPUNILMU (ID_SUB_RUMPUN) on delete restrict on update restrict;

alter table UNSURPENILAIAN add constraint FK_UNSURPEN_MEMILIKI__KATEGORI foreign key (ID_KATEGORI)
      references KATEGORIPENILAIAN (ID_KATEGORI) on delete restrict on update restrict;

