/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     10/22/2019 9:50:08 PM                        */
/*==============================================================*/


alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_BATAS_UNT_JABATAN;

alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_MEMILIKI_KATEGORI;

alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI1_PAK;

alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI__UNSURPEN;

alter table PAK 
   drop foreign key FK_PAK_DINILAI_PENILAI;

alter table PAK 
   drop foreign key FK_PAK_DINILAI_O_PENILAI;

alter table PAK 
   drop foreign key FK_PAK_PAK_UNTUK_JABATAN;

alter table PENILAI 
   drop foreign key FK_PENILAI_ADALAH_PENILAIL;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMILIKI__JABATAN;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMPUNYAI_AKUN;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_RELATIONS_SUBRUMPU;

alter table UNSURPENILAIAN 
   drop foreign key FK_UNSURPEN_MEMILIKI__KATEGORI;

drop table if exists AKUN;


alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_BATAS_UNT_JABATAN;

alter table BATASKATEGORI 
   drop foreign key FK_BATASKAT_MEMILIKI_KATEGORI;

drop table if exists BATASKATEGORI;


alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI1_PAK;

alter table ITEMPENILAIAN 
   drop foreign key FK_ITEMPENI_MEMILIKI__UNSURPEN;

drop table if exists ITEMPENILAIAN;

drop table if exists JABATAN;

drop table if exists KATEGORIPENILAIAN;


alter table PAK 
   drop foreign key FK_PAK_DINILAI_O_PENILAI;

alter table PAK 
   drop foreign key FK_PAK_DINILAI_PENILAI;

alter table PAK 
   drop foreign key FK_PAK_PAK_UNTUK_JABATAN;

drop table if exists PAK;


alter table PENILAI 
   drop foreign key FK_PENILAI_ADALAH_PENILAIL;

drop table if exists PENILAI;


alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_RELATIONS_SUBRUMPU;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMPUNYAI_AKUN;

alter table PENILAILUAR 
   drop foreign key FK_PENILAIL_MEMILIKI__JABATAN;

drop table if exists PENILAILUAR;

drop table if exists SUBRUMPUNILMU;


alter table UNSURPENILAIAN 
   drop foreign key FK_UNSURPEN_MEMILIKI__KATEGORI;

drop table if exists UNSURPENILAIAN;

/*==============================================================*/
/* Table: AKUN                                                  */
/*==============================================================*/
create table AKUN
(
   IDAKUN               int(11) not null auto_increment  comment '',
   ROLE                 int not null  comment '',
   USERNAME             varchar(25) not null  comment '',
   PASSWORD             varchar(25) not null  comment '',
   primary key (IDAKUN)
);

/*==============================================================*/
/* Table: BATASKATEGORI                                         */
/*==============================================================*/
create table BATASKATEGORI
(
   IDJABATAN            int not null  comment '',
   IDKATEGORI           int not null  comment '',
   MINIMAL              int not null  comment '',
   MAKSIMAL             int not null  comment '',
   primary key (IDJABATAN, IDKATEGORI)
);

/*==============================================================*/
/* Table: ITEMPENILAIAN                                         */
/*==============================================================*/
create table ITEMPENILAIAN
(
   IDITEM               int(11) not null auto_increment  comment '',
   IDPAK                int not null  comment '',
   IDUNSUR              int not null  comment '',
   NILAIAWAL            int  comment '',
   NILAI1               int  comment '',
   NILAI2               int  comment '',
   URLDOKUMEN           varchar(100)  comment '',
   primary key (IDITEM)
);

/*==============================================================*/
/* Table: JABATAN                                               */
/*==============================================================*/
create table JABATAN
(
   IDJABATAN            int(11) not null auto_increment  comment '',
   KREDIT               int not null  comment '',
   JABATAN              varchar(15) not null  comment '',
   GOLONGAN             varchar(5) not null  comment '',
   primary key (IDJABATAN)
);

/*==============================================================*/
/* Table: KATEGORIPENILAIAN                                     */
/*==============================================================*/
create table KATEGORIPENILAIAN
(
   IDKATEGORI           int(11) not null auto_increment  comment '',
   NAMA                 varchar(50)  comment '',
   primary key (IDKATEGORI)
);

/*==============================================================*/
/* Table: PAK                                                   */
/*==============================================================*/
create table PAK
(
   IDPAK                int(11) not null auto_increment  comment '',
   IDPENILAI1           int  comment '',
   IDPENILAI2           int  comment '',
   IDJABATAN            int  comment '',
   IDDOSEN              int not null  comment '',
   STATUS               int not null  comment '',
   TANGGALSTATUS        date not null  comment '',
   TANGGALDIAJUKAN      date  comment '',
   URLSK                varchar(100)  comment '',
   primary key (IDPAK)
);

/*==============================================================*/
/* Table: PENILAI                                               */
/*==============================================================*/
create table PENILAI
(
   IDPENILAI            int(11) not null auto_increment  comment '',
   IDAKUN               int  comment '',
   JENISPENILAI         tinyint not null  comment '',
   IDDOSEN              int  comment '',
   primary key (IDPENILAI)
);

/*==============================================================*/
/* Table: PENILAILUAR                                           */
/*==============================================================*/
create table PENILAILUAR
(
   IDAKUN               int not null  comment '',
   IDJABATAN            int not null  comment '',
   IDSUBRUMPUN          int not null  comment '',
   NIP                  varchar(50) not null  comment '',
   NAMA                 varchar(50) not null  comment '',
   EMAIL                varchar(50) not null  comment '',
   TELEPON              varchar(15) not null  comment '',
   ASALINSTANSI         varchar(100) not null  comment '',
   primary key (IDAKUN)
);

/*==============================================================*/
/* Table: SUBRUMPUNILMU                                         */
/*==============================================================*/
create table SUBRUMPUNILMU
(
   IDSUBRUMPUN          int(11) not null auto_increment  comment '',
   RUMPUN               varchar(25) not null  comment '',
   SUBRUMPUN            varchar(25) not null  comment '',
   primary key (IDSUBRUMPUN)
);

/*==============================================================*/
/* Table: UNSURPENILAIAN                                        */
/*==============================================================*/
create table UNSURPENILAIAN
(
   IDUNSUR              int(11) not null auto_increment  comment '',
   IDKATEGORI           int not null  comment '',
   NAMA                 varchar(50)  comment '',
   BATAS                int  comment '',
   JENISBATASUNSUR      int  comment '',
   MAXKREDIT            int  comment '',
   BUKTI                varchar(50)  comment '',
   primary key (IDUNSUR)
);

alter table BATASKATEGORI add constraint FK_BATASKAT_BATAS_UNT_JABATAN foreign key (IDJABATAN)
      references JABATAN (IDJABATAN) on delete restrict on update restrict;

alter table BATASKATEGORI add constraint FK_BATASKAT_MEMILIKI_KATEGORI foreign key (IDKATEGORI)
      references KATEGORIPENILAIAN (IDKATEGORI) on delete restrict on update restrict;

alter table ITEMPENILAIAN add constraint FK_ITEMPENI_MEMILIKI1_PAK foreign key (IDPAK)
      references PAK (IDPAK) on delete restrict on update restrict;

alter table ITEMPENILAIAN add constraint FK_ITEMPENI_MEMILIKI__UNSURPEN foreign key (IDUNSUR)
      references UNSURPENILAIAN (IDUNSUR) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_DINILAI_PENILAI foreign key (IDPENILAI2)
      references PENILAI (IDPENILAI) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_DINILAI_O_PENILAI foreign key (IDPENILAI1)
      references PENILAI (IDPENILAI) on delete restrict on update restrict;

alter table PAK add constraint FK_PAK_PAK_UNTUK_JABATAN foreign key (IDJABATAN)
      references JABATAN (IDJABATAN) on delete restrict on update restrict;

alter table PENILAI add constraint FK_PENILAI_ADALAH_PENILAIL foreign key (IDAKUN)
      references PENILAILUAR (IDAKUN) on delete restrict on update restrict;

alter table PENILAILUAR add constraint FK_PENILAIL_MEMILIKI__JABATAN foreign key (IDJABATAN)
      references JABATAN (IDJABATAN) on delete restrict on update restrict;

alter table PENILAILUAR add constraint FK_PENILAIL_MEMPUNYAI_AKUN foreign key (IDAKUN)
      references AKUN (IDAKUN) on delete restrict on update restrict;

alter table PENILAILUAR add constraint FK_PENILAIL_RELATIONS_SUBRUMPU foreign key (IDSUBRUMPUN)
      references SUBRUMPUNILMU (IDSUBRUMPUN) on delete restrict on update restrict;

alter table UNSURPENILAIAN add constraint FK_UNSURPEN_MEMILIKI__KATEGORI foreign key (IDKATEGORI)
      references KATEGORIPENILAIAN (IDKATEGORI) on delete restrict on update restrict;

