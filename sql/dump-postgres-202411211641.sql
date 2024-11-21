--
-- PostgreSQL database dump
--

-- Dumped from database version 14.5
-- Dumped by pg_dump version 17.0

-- Started on 2024-11-21 16:41:35

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 15 (class 2615 OID 29182)
-- Name: si_pak_dosen; Type: SCHEMA; Schema: -; Owner: -
--

CREATE SCHEMA si_pak_dosen;


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 457 (class 1259 OID 29183)
-- Name: batas_kategori; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.batas_kategori (
    id_jabatan integer NOT NULL,
    id_kategori integer NOT NULL,
    minimal integer,
    min_type integer,
    maksimal integer,
    max_type integer
);


--
-- TOC entry 459 (class 1259 OID 29187)
-- Name: item_penilaian; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.item_penilaian (
    id_item integer NOT NULL,
    id_pak integer NOT NULL,
    id_unsur integer NOT NULL,
    nilai_awal double precision,
    nilai_1 double precision,
    nilai_2 double precision,
    url_dokumen character varying(100),
    tahun integer,
    semester smallint
);


--
-- TOC entry 458 (class 1259 OID 29186)
-- Name: item_penilaian_id_item_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.item_penilaian_id_item_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3989 (class 0 OID 0)
-- Dependencies: 458
-- Name: item_penilaian_id_item_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.item_penilaian_id_item_seq OWNED BY si_pak_dosen.item_penilaian.id_item;


--
-- TOC entry 461 (class 1259 OID 29192)
-- Name: jabatan; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.jabatan (
    id_jabatan integer NOT NULL,
    kredit integer NOT NULL,
    jabatan character varying(18) NOT NULL
);


--
-- TOC entry 460 (class 1259 OID 29191)
-- Name: jabatan_id_jabatan_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.jabatan_id_jabatan_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3990 (class 0 OID 0)
-- Dependencies: 460
-- Name: jabatan_id_jabatan_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.jabatan_id_jabatan_seq OWNED BY si_pak_dosen.jabatan.id_jabatan;


--
-- TOC entry 463 (class 1259 OID 29197)
-- Name: jenis_batas; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.jenis_batas (
    id_jenis_batas integer NOT NULL,
    jenis_batas character varying(192) NOT NULL
);


--
-- TOC entry 462 (class 1259 OID 29196)
-- Name: jenis_batas_id_jenis_batas_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.jenis_batas_id_jenis_batas_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3991 (class 0 OID 0)
-- Dependencies: 462
-- Name: jenis_batas_id_jenis_batas_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.jenis_batas_id_jenis_batas_seq OWNED BY si_pak_dosen.jenis_batas.id_jenis_batas;


--
-- TOC entry 465 (class 1259 OID 29202)
-- Name: kategori_penilaian; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.kategori_penilaian (
    id_kategori integer NOT NULL,
    kategori character varying(10) NOT NULL
);


--
-- TOC entry 464 (class 1259 OID 29201)
-- Name: kategori_penilaian_id_kategori_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.kategori_penilaian_id_kategori_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3992 (class 0 OID 0)
-- Dependencies: 464
-- Name: kategori_penilaian_id_kategori_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.kategori_penilaian_id_kategori_seq OWNED BY si_pak_dosen.kategori_penilaian.id_kategori;


--
-- TOC entry 466 (class 1259 OID 29206)
-- Name: login_info; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.login_info (
    id_user integer NOT NULL,
    username character varying(25) NOT NULL,
    password character varying(25) NOT NULL
);


--
-- TOC entry 468 (class 1259 OID 29210)
-- Name: pak; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.pak (
    id_pak integer NOT NULL,
    id_penilai_1 integer,
    id_penilai_2 integer,
    id_jabatan_tujuan integer NOT NULL,
    id_pemohon integer NOT NULL,
    id_jabatan_awal integer NOT NULL,
    id_status_pak integer NOT NULL,
    tanggal_status date NOT NULL,
    tanggal_diajukan date,
    url_sk character varying(100),
    id_subrumpun integer NOT NULL,
    id_penilai_submit integer,
    nilai_awal double precision,
    nilai_akhir double precision,
    kredit_awal double precision NOT NULL,
    kredit_akhir double precision
);


--
-- TOC entry 467 (class 1259 OID 29209)
-- Name: pak_id_pak_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.pak_id_pak_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3993 (class 0 OID 0)
-- Dependencies: 467
-- Name: pak_id_pak_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.pak_id_pak_seq OWNED BY si_pak_dosen.pak.id_pak;


--
-- TOC entry 469 (class 1259 OID 29214)
-- Name: penilai_luar; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.penilai_luar (
    id_user integer NOT NULL,
    id_jabatan integer NOT NULL,
    id_subrumpun integer NOT NULL,
    nip character varying(50) NOT NULL,
    email character varying(50) NOT NULL,
    telepon character varying(15) NOT NULL,
    asal_instansi character varying(100) NOT NULL
);


--
-- TOC entry 470 (class 1259 OID 29217)
-- Name: status_pak; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.status_pak (
    id_status_pak integer NOT NULL,
    status_pak character varying(25) NOT NULL
);


--
-- TOC entry 472 (class 1259 OID 29221)
-- Name: subrumpun; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.subrumpun (
    id_subrumpun integer NOT NULL,
    id_rumpun integer NOT NULL,
    subrumpun character varying(32) NOT NULL
);


--
-- TOC entry 471 (class 1259 OID 29220)
-- Name: subrumpun_id_subrumpun_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.subrumpun_id_subrumpun_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3994 (class 0 OID 0)
-- Dependencies: 471
-- Name: subrumpun_id_subrumpun_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.subrumpun_id_subrumpun_seq OWNED BY si_pak_dosen.subrumpun.id_subrumpun;


--
-- TOC entry 474 (class 1259 OID 29226)
-- Name: unsur_penilaian; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen.unsur_penilaian (
    id_unsur integer NOT NULL,
    id_kategori integer NOT NULL,
    kegiatan character varying(512) NOT NULL,
    batas integer,
    unit character varying(16),
    id_jenis_batas integer,
    max_kredit integer NOT NULL,
    bukti character varying(128),
    keterangan character varying(255)
);


--
-- TOC entry 473 (class 1259 OID 29225)
-- Name: unsur_penilaian_id_unsur_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.unsur_penilaian_id_unsur_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3995 (class 0 OID 0)
-- Dependencies: 473
-- Name: unsur_penilaian_id_unsur_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.unsur_penilaian_id_unsur_seq OWNED BY si_pak_dosen.unsur_penilaian.id_unsur;


--
-- TOC entry 476 (class 1259 OID 29233)
-- Name: user; Type: TABLE; Schema: si_pak_dosen; Owner: -
--

CREATE TABLE si_pak_dosen."user" (
    id_user integer NOT NULL,
    role integer NOT NULL,
    status_user integer NOT NULL,
    nama character varying(50),
    id_pegawai character varying(18),
    keterangan character varying(100)
);


--
-- TOC entry 475 (class 1259 OID 29232)
-- Name: user_id_user_seq; Type: SEQUENCE; Schema: si_pak_dosen; Owner: -
--

CREATE SEQUENCE si_pak_dosen.user_id_user_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 3996 (class 0 OID 0)
-- Dependencies: 475
-- Name: user_id_user_seq; Type: SEQUENCE OWNED BY; Schema: si_pak_dosen; Owner: -
--

ALTER SEQUENCE si_pak_dosen.user_id_user_seq OWNED BY si_pak_dosen."user".id_user;


--
-- TOC entry 3755 (class 2604 OID 29190)
-- Name: item_penilaian id_item; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.item_penilaian ALTER COLUMN id_item SET DEFAULT nextval('si_pak_dosen.item_penilaian_id_item_seq'::regclass);


--
-- TOC entry 3756 (class 2604 OID 29195)
-- Name: jabatan id_jabatan; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.jabatan ALTER COLUMN id_jabatan SET DEFAULT nextval('si_pak_dosen.jabatan_id_jabatan_seq'::regclass);


--
-- TOC entry 3757 (class 2604 OID 29200)
-- Name: jenis_batas id_jenis_batas; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.jenis_batas ALTER COLUMN id_jenis_batas SET DEFAULT nextval('si_pak_dosen.jenis_batas_id_jenis_batas_seq'::regclass);


--
-- TOC entry 3758 (class 2604 OID 29205)
-- Name: kategori_penilaian id_kategori; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.kategori_penilaian ALTER COLUMN id_kategori SET DEFAULT nextval('si_pak_dosen.kategori_penilaian_id_kategori_seq'::regclass);


--
-- TOC entry 3759 (class 2604 OID 29213)
-- Name: pak id_pak; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak ALTER COLUMN id_pak SET DEFAULT nextval('si_pak_dosen.pak_id_pak_seq'::regclass);


--
-- TOC entry 3760 (class 2604 OID 29224)
-- Name: subrumpun id_subrumpun; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.subrumpun ALTER COLUMN id_subrumpun SET DEFAULT nextval('si_pak_dosen.subrumpun_id_subrumpun_seq'::regclass);


--
-- TOC entry 3761 (class 2604 OID 29229)
-- Name: unsur_penilaian id_unsur; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.unsur_penilaian ALTER COLUMN id_unsur SET DEFAULT nextval('si_pak_dosen.unsur_penilaian_id_unsur_seq'::regclass);


--
-- TOC entry 3762 (class 2604 OID 29236)
-- Name: user id_user; Type: DEFAULT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen."user" ALTER COLUMN id_user SET DEFAULT nextval('si_pak_dosen.user_id_user_seq'::regclass);


--
-- TOC entry 3964 (class 0 OID 29183)
-- Dependencies: 457
-- Data for Name: batas_kategori; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--

INSERT INTO si_pak_dosen.batas_kategori VALUES (1, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (1, 2, 55, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (1, 3, 25, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (1, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (1, 5, NULL, NULL, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (2, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (2, 2, 45, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (2, 3, 35, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (2, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (2, 5, NULL, NULL, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (3, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (3, 2, 45, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (3, 3, 35, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (3, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (3, 5, NULL, NULL, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (4, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (4, 2, 40, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (4, 3, 40, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (4, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (4, 5, NULL, NULL, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (5, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (5, 2, 40, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (5, 3, 40, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (5, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (5, 5, NULL, NULL, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (6, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (6, 2, 40, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (6, 3, 40, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (6, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (6, 5, NULL, NULL, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (7, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (7, 2, 35, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (7, 3, 45, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (7, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (7, 5, NULL, NULL, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (8, 1, NULL, NULL, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (8, 2, 35, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (8, 3, 45, 1, NULL, NULL);
INSERT INTO si_pak_dosen.batas_kategori VALUES (8, 4, 1, 0, 10, 1);
INSERT INTO si_pak_dosen.batas_kategori VALUES (8, 5, NULL, NULL, 10, 1);


--
-- TOC entry 3966 (class 0 OID 29187)
-- Dependencies: 459
-- Data for Name: item_penilaian; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--



--
-- TOC entry 3968 (class 0 OID 29192)
-- Dependencies: 461
-- Data for Name: jabatan; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--

INSERT INTO si_pak_dosen.jabatan VALUES (1, 150, 'Asisten Ahli III/b');
INSERT INTO si_pak_dosen.jabatan VALUES (2, 200, 'Lektor III/c');
INSERT INTO si_pak_dosen.jabatan VALUES (3, 300, 'Lektor III/d');
INSERT INTO si_pak_dosen.jabatan VALUES (4, 400, 'Lektor Kepala IV/a');
INSERT INTO si_pak_dosen.jabatan VALUES (5, 550, 'Lektor Kepala IV/b');
INSERT INTO si_pak_dosen.jabatan VALUES (6, 700, 'Lektor Kepala IV/c');
INSERT INTO si_pak_dosen.jabatan VALUES (7, 850, 'Profesor IV/d');
INSERT INTO si_pak_dosen.jabatan VALUES (8, 1050, 'Profesor IV/e');


--
-- TOC entry 3970 (class 0 OID 29197)
-- Dependencies: 463
-- Data for Name: jenis_batas; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--

INSERT INTO si_pak_dosen.jenis_batas VALUES (1, 'per semester');
INSERT INTO si_pak_dosen.jenis_batas VALUES (2, 'per tahun');
INSERT INTO si_pak_dosen.jenis_batas VALUES (3, 'per periode penilaian');
INSERT INTO si_pak_dosen.jenis_batas VALUES (4, 'total angka kredit unsur penelitian yang diperlukan untuk pengusulan ke Lektor Kepala dan Profesor ');
INSERT INTO si_pak_dosen.jenis_batas VALUES (5, 'total angka kredit unsur penelitian yang diperlukan untuk pengusulan ke Lektor Kepala dan Profesor  (untuk karya ilmiah butir; 2.a.4; 2.b.2; 2.c.2; dan 2.d.2)');
INSERT INTO si_pak_dosen.jenis_batas VALUES (6, 'total angka kredit unsur penelitian untuk pengajuan ke semua jenjang (untuk karya ilmiah butir 2.e dan 3)');


--
-- TOC entry 3972 (class 0 OID 29202)
-- Dependencies: 465
-- Data for Name: kategori_penilaian; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--

INSERT INTO si_pak_dosen.kategori_penilaian VALUES (1, 'Pendidikan');
INSERT INTO si_pak_dosen.kategori_penilaian VALUES (2, 'Pengajaran');
INSERT INTO si_pak_dosen.kategori_penilaian VALUES (3, 'Penelitian');
INSERT INTO si_pak_dosen.kategori_penilaian VALUES (4, 'Pengabdian');
INSERT INTO si_pak_dosen.kategori_penilaian VALUES (5, 'Penunjang');


--
-- TOC entry 3973 (class 0 OID 29206)
-- Dependencies: 466
-- Data for Name: login_info; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--



--
-- TOC entry 3975 (class 0 OID 29210)
-- Dependencies: 468
-- Data for Name: pak; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--



--
-- TOC entry 3976 (class 0 OID 29214)
-- Dependencies: 469
-- Data for Name: penilai_luar; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--



--
-- TOC entry 3977 (class 0 OID 29217)
-- Dependencies: 470
-- Data for Name: status_pak; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--

INSERT INTO si_pak_dosen.status_pak VALUES (1, 'Belum disubmit');
INSERT INTO si_pak_dosen.status_pak VALUES (2, 'Baru');
INSERT INTO si_pak_dosen.status_pak VALUES (3, 'Menunggu penilai');
INSERT INTO si_pak_dosen.status_pak VALUES (4, 'Menunggu sidang');
INSERT INTO si_pak_dosen.status_pak VALUES (5, 'Ditolak (nilai kurang)');
INSERT INTO si_pak_dosen.status_pak VALUES (6, 'Ditolak (dalam sidang)');
INSERT INTO si_pak_dosen.status_pak VALUES (7, 'Diterima');


--
-- TOC entry 3979 (class 0 OID 29221)
-- Dependencies: 472
-- Data for Name: subrumpun; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--

INSERT INTO si_pak_dosen.subrumpun VALUES (110, 100, 'Ushuluddin');
INSERT INTO si_pak_dosen.subrumpun VALUES (120, 100, 'Syariah');
INSERT INTO si_pak_dosen.subrumpun VALUES (130, 100, 'Adab');
INSERT INTO si_pak_dosen.subrumpun VALUES (140, 100, 'Dakwah');
INSERT INTO si_pak_dosen.subrumpun VALUES (150, 100, 'Tarbiyah');
INSERT INTO si_pak_dosen.subrumpun VALUES (220, 200, 'Bahasa');
INSERT INTO si_pak_dosen.subrumpun VALUES (310, 300, 'Pendidikan');
INSERT INTO si_pak_dosen.subrumpun VALUES (330, 300, 'Ekonomi');
INSERT INTO si_pak_dosen.subrumpun VALUES (340, 300, 'Psikologi');
INSERT INTO si_pak_dosen.subrumpun VALUES (350, 300, 'Komunikasi');
INSERT INTO si_pak_dosen.subrumpun VALUES (380, 300, 'Sosiologi');
INSERT INTO si_pak_dosen.subrumpun VALUES (410, 300, 'Politik');
INSERT INTO si_pak_dosen.subrumpun VALUES (420, 300, 'Perpustakaan');
INSERT INTO si_pak_dosen.subrumpun VALUES (430, 300, 'Hukum');
INSERT INTO si_pak_dosen.subrumpun VALUES (510, 500, 'Biologi');
INSERT INTO si_pak_dosen.subrumpun VALUES (520, 500, 'Fisika');
INSERT INTO si_pak_dosen.subrumpun VALUES (530, 500, 'Matematika');
INSERT INTO si_pak_dosen.subrumpun VALUES (540, 500, 'Kimia');
INSERT INTO si_pak_dosen.subrumpun VALUES (550, 500, 'Farmasi');
INSERT INTO si_pak_dosen.subrumpun VALUES (560, 500, 'Ilmu Kedokteran');
INSERT INTO si_pak_dosen.subrumpun VALUES (570, 500, 'Pertanian');
INSERT INTO si_pak_dosen.subrumpun VALUES (580, 500, 'Peternakan');
INSERT INTO si_pak_dosen.subrumpun VALUES (640, 500, 'Komputer');
INSERT INTO si_pak_dosen.subrumpun VALUES (810, 800, 'Teknik');
INSERT INTO si_pak_dosen.subrumpun VALUES (830, 800, 'Arsitektur');
INSERT INTO si_pak_dosen.subrumpun VALUES (840, 800, 'Teknik Perencanaan Tata Kota');


--
-- TOC entry 3981 (class 0 OID 29226)
-- Dependencies: 474
-- Data for Name: unsur_penilaian; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--

INSERT INTO si_pak_dosen.unsur_penilaian VALUES (1, 1, 'Mengikuti pendidikan formal dan memperoleh gelar/sebutan/ijazah : Doktor / sederajat', 1, NULL, 3, 200, 'Bukti tugas/izin belajar dan pindai ijazah asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (2, 1, 'Mengikuti pendidikan formal dan memperoleh gelar/sebutan/ijazah : Magister/sederajat', 1, NULL, 3, 150, 'Bukti tugas/izin belajar dan pindai ijazah asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (3, 1, 'Mengikuti diklat prajabatan golongan III', 1, NULL, 3, 3, 'Bukti tugas/izin belajar dan pindai ijazah asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (4, 2, 'Melaksanakan perkuliahan/tutorial/
perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/
teknologi pengajaran dan praktik lapangan (setiap semester) : Asisten Ahli untuk :  beban mengajar 10 sks pertama', 5, NULL, 1, 1, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (5, 2, 'Melaksanakan perkuliahan/tutorial/
perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/
teknologi pengajaran dan praktik lapangan (setiap semester) : Asisten Ahli untuk :  beban mengajar 2 sks berikutnya', 0, NULL, 1, 0, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (6, 2, 'Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan (setiap semester) : Lektor/Lektor Kepala/Profesor untuk : beban mengajar 10 sks pertama', 10, NULL, 1, 1, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (7, 2, 'Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan (setiap semester) : Lektor/Lektor Kepala/Profesor untuk : beban mengajar 2 sks berikutnya', 1, NULL, 1, 1, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (8, 2, 'Melaksanakan perkuliahan/tutorial/perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/teknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pengajaran untuk peserta pendidikan dokter melalui tindakan medik spesialistik', 11, NULL, 1, 4, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (9, 2, 'Melaksanakan perkuliahan/tutorial/
perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/
teknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pengajaran Konsultasi spesialis kepada peserta pendidikan dokter', 11, NULL, 1, 2, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (10, 2, 'Melaksanakan perkuliahan/tutorial/
perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/
teknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pemeriksaan luar dengan pembimbingan terhadap peserta pendidikan dokter', 11, NULL, 1, 2, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (11, 2, 'Melaksanakan perkuliahan/tutorial/
perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/
teknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Melakukan pemeriksaan dalam dengan pembimbingan terhadap peserta pendidikan dokter', 11, NULL, 1, 3, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (12, 2, 'Melaksanakan perkuliahan/tutorial/
perkuliahan praktikum dan membimbing,menguji serta menyelenggarakan pendidikan di laboratorium, praktik keguruan, bengkel/studio/kebun percobaan/
teknologi pengajaran dan praktik lapangan (setiap semester) : Kegiatan pelaksanaan pendidikan untuk pendidikan dokter klinis : Menjadi saksi ahli dengan pembimbingan terhadap peserta pendidikan dokter', 11, NULL, 1, 1, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (13, 2, 'Membimbing seminar mahasiswa (setiap semester)', NULL, NULL, NULL, 1, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (14, 2, 'Membimbing KKN, Praktik Kerja Nyata, Praktik Kerja Lapangan (setiap semester)', NULL, NULL, NULL, 1, 'Pindai SK penugasan asli dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (15, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) : Disertasi', 4, 'lulusan', 1, 8, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (16, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) : Tesis', 6, 'Lulusan', 1, 3, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (17, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) : Skripsi', 8, 'Lulusan', 1, 1, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (18, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Utama per orang (setiap mahasiswa) :  Laporan akhir studi', 10, 'Lulusan', 1, 1, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (19, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Disertasi', 4, 'Lulusan', 1, 6, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (20, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Tesis', 6, 'Lulusan', 1, 2, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (21, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Skripsi', 8, 'Lulusan', 1, 1, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (22, 2, 'Membimbing dan ikut membimbing dalam menghasilkan disertasi, tesis, skripsi dan laporan akhir studi yang sesuai bidang penugasannya : Pembimbing Pendamping/ Pembantu per orang (setiap mhs) : Laporan akhir studi', 10, 'Lulusan', 1, 1, 'Pindai lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (23, 2, 'Bertugas sebagai penguji pada ujian akhir/Profesi* (setiap mahasiswa) : Ketua Penguji', 4, 'Lulusan', 1, 1, 'Pindai SK penugasan, bukti kinerja dan undangan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (24, 2, 'Bertugas sebagai penguji pada ujian akhir/Profesi* (setiap mahasiswa) : Anggota Penguji', 8, 'Lulusan', 1, 1, 'Pindai SK penugasan, bukti kinerja dan undangan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (25, 2, 'Membina kegiatan mahasiswa di bidang akademik dan kemahasiswaan, termasuk dalam kegiatan ini adalah membimbing mahasiswa menghasilkan produk saintifik (setiap semester)', 2, 'Kegiatan', 1, 2, 'Pindai SK penugasan, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (26, 2, 'Mengembangkan program kuliah yang mempunyai nilai kebaharuan metode atau substansi (setiap produk)', 1, 'Mata Kuliah', 1, 2, 'File produk', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (27, 2, 'Mengembangkan bahan pengajaran/ bahan kuliah yang mempunyai nilai kebaharuan (setiap produk) : Buku ajar', 1, 'buku', 2, 20, 'File produk', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (28, 2, 'Mengembangkan bahan pengajaran/ bahan kuliah yang mempunyai nilai kebaharuan (setiap produk), : Diktat,Modul, Petunjuk praktikum, Model, Alat bantu, Audio visual, Naskah tutorial, Job sheet praktikum terkait dengan mata kuliah yang diampu', 1, 'Produk', 1, 5, 'File produk', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (29, 2, 'Menyampaikan orasi ilmiah di tingkat perguruan tinggi', 2, 'Orasi', 1, 5, 'File produk', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (30, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Rektor', 1, 'Jabatan', 1, 6, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (31, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Wakil rektor/dekan/direktur program pasca sarjana/ketua lembaga', 1, 'Jabatan', 1, 5, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (32, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Ketua sekolah tinggi/pembantu dekan/asisten direktur program pasca sarjana/direktur politeknik/kepala LLDikti', 1, 'Jabatan', 1, 4, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (33, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Pembantu ketua sekolah tinggi/pembantu direktur politeknik', 1, 'Jabatan', 1, 4, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (34, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Direktur akademi', 1, 'Jabatan', 1, 4, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (35, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Pembantu direktur politeknik, ketua jurusan/ bagian pada universitas/ institut/sekolah tinggi', 1, 'Jabatan', 1, 3, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (36, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Pembantu direktur akademi/ketua jurusan/ketua prodi pada universitas /politeknik/akademi, sekretaris jurusan/bagian pada universitas /institut/sekolah tinggi', 1, 'Jabatan', 1, 3, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (37, 2, 'Menduduki jabatan pimpinan perguruan tinggi sesuai tugas pokok, fungsi dan kewenangan dan/atau setara (setiap semester) : Sekretaris jurusan pada politeknik/akademi dan kepala laboratorium (bengkel) universitas/institut/sekolah tinggi/politeknik/akademi', 1, 'Jabatan', 1, 3, 'Pindai SK Jabatan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (38, 2, 'Membimbing dosen yang mempunyai jabatan akademik lebih rendah setiap semester (bagi dosen Lektor Kepala ke atas) : Pembimbing pencangkokan', 1, 'Orang', NULL, 2, 'Pindai SK Penugasan, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (39, 2, 'Membimbing dosen yang mempunyai jabatan akademik lebih rendah setiap semester (bagi dosen Lektor Kepala ke atas) : Reguler', 1, 'Orang', NULL, 1, 'Pindai SK Penugasan, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (40, 2, 'Melaksanakan kegiatan detasering dan pencangkokan di luar institusi tempat bekerja setiap semester (bagi dosen Lektor kepala ke atas) : Detasering', 1, 'Orang', NULL, 5, 'Pindai SK Penugasan, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (41, 2, 'Melaksanakan kegiatan detasering dan pencangkokan di luar institusi tempat bekerja setiap semester (bagi dosen Lektor kepala ke atas) : Pencangkokan', 1, 'Orang', NULL, 4, 'Pindai SK Penugasan, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (42, 2, 'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya lebih dari 960 jam', NULL, NULL, NULL, 15, 'Pindai sertifikat asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (43, 2, 'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 641- 960 jam', NULL, NULL, NULL, 9, 'Pindai sertifikat asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (44, 2, 'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 481- 640 jam', NULL, NULL, NULL, 6, 'Pindai sertifikat asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (45, 2, 'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 161- 480 jam', NULL, NULL, NULL, 3, 'Pindai sertifikat asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (46, 2, 'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 81- 160 jam', NULL, NULL, NULL, 2, 'Pindai sertifikat asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (47, 2, 'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 30 - 80 jam', NULL, NULL, NULL, 1, 'Pindai sertifikat asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (48, 2, 'Melaksanakan pengembangan diri untuk meningkatkan kompetensi : Lamanya antara 10 - 30 jam', NULL, NULL, NULL, 1, 'Pindai sertifikat asli', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (49, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan dalam bentuk buku : Buku referensi', 1, 'Buku', 2, 40, 'Pindai halaman sampul, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (50, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan dalam bentuk buku : Monograf', 1, 'Buku', 2, 20, 'Pindai halaman sampul dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (51, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran dalam buku yang dipublikasikan dan berisi berbagai tulisan dari berbagai penulis (book chapter) : Internasional', 1, 'Buku', 2, 15, 'Pindai halaman sampul, daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (52, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran dalam buku yang dipublikasikan dan berisi berbagai tulisan dari berbagai penulis (book chapter) : Nasional', 1, 'Buku', 2, 10, 'Pindai halaman sampul, daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (53, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan : Jurnal internasional bereputasi (terindeks pada database internasional bereputasi dan berfaktor dampak)', NULL, NULL, NULL, 40, 'Pindai halaman sampul, daftar isi, dewan redaksi/redaksi pelaksana dan bukti kinerja', 'Penjelasan Butir 12.2 Untuk pemenuhan persyaratan khusus');
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (54, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan : Jurnal internasional terindeks pada basis data internasional bereputasi', NULL, NULL, NULL, 30, 'Pindai halaman sampul, daftar isi,dewan redaksi/redaksi pelaksana dan bukti kinerja', 'Penjelasan Butir 12.1 Untuk pemenuhan persyaratan khusus');
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (55, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan : Jurnal internasional terindeks pada basis data internasional di luar kategori 2)', NULL, NULL, NULL, 20, 'Pindai halaman sampul, daftar isi, redaksi pelaksana dan bukti kinerja', 'Termasuk jurnal terindeks di Web of Science Clarivate Analytics Kelompok Emerging Sources Citation Index (ESCI)');
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (56, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :   Jurnal Nasional terakreditasi Dikti', NULL, NULL, NULL, 25, 'Pindai halaman sampul, daftar isi, dewan redaksi/redaksi pelaksana  dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (57, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal nasional terakreditasi Kemenristekdikti peringkat 1 dan 2', NULL, NULL, NULL, 25, 'Pindai halaman sampul, daftar isi, dewan redaksi/redaksi pelaksana  dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (58, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal Nasional berbahasa
Inggris atau bahasa resmi (PBB) terindeks pada basis data yang diakui Kemenristekdikti, contohnya: CABI atau Index Copernicus International (ICI).', NULL, NULL, NULL, 20, 'Pindai halaman sampul, dewan
redaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (59, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :   Jurnal nasional terakreditasi peringkat 3 dan 4', NULL, NULL, NULL, 20, 'Pindai halaman sampul, dewan
redaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (60, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal Nasional berbahasa Indonesia terindeks pada basis data yang diakui Kemenristekdikti, contohnya : akreditasi peringkat 5 dan 6', NULL, NULL, NULL, 15, 'Pindai halaman sampul, dewan
redaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (61, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal Nasional', 25, '%', 4, 10, 'Pindai halaman sampul, dewan
redaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (62, 3, 'Menghasilkan karya ilmiah sesuai dengan bidang ilmunya : Hasil penelitian atau hasil pemikiran yang dipublikasikan :  Jurnal ilmiah yang ditulis dalam Bahasa Resmi PBB namun tidak memenuhi syarat-syarat sebagai jurnal ilmiah internasional', NULL, NULL, NULL, 10, 'Pindai halaman sampul, dewan
redaksi/ redaksi pelaksana ,daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (63, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Internasional terindeks pada Scimagojr dan Scopus', NULL, NULL, NULL, 30, 'Pindai halaman sampul, Panitia pelaksana, Panitia pengarah, daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (64, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Internasional terindeks pada SCOPUS, IEEE Explore, SPIE', NULL, NULL, NULL, 25, 'Pindai halaman sampul, Panitia pelaksana, Panitia pengarah, daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (65, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Internasional', NULL, NULL, NULL, 15, 'Pindai halaman sampul, Panitia pelaksana, Panitia pengarah, daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (66, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Dipresentasikan secara oral dan dimuat dalam prosiding yang dipublikasikan (ber ISSN/ISBN) : Nasional', NULL, NULL, NULL, 10, 'Pindai halaman sampul, Panitia Pelaksana, Panitia pengarah, daftar isi dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (67, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam bentuk poster dan dimuat dalam prosiding yang dipublikasikan: Internasional', NULL, NULL, NULL, 10, 'Pindai poster, Panitia Pelaksana, Panitia Pengarah daftar isi dan buku panduan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (68, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam bentuk poster dan dimuat dalam prosiding yang dipublikasikan : Nasional', NULL, NULL, NULL, 5, 'Pindai poster, Panitia Pelaksana, Panitia pengarah, daftar isi dan bukun panduan', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (69, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam seminar/simposium/ lokakarya, tetapi tidak dimuat dalam prosiding yang dipublikasikan : Internasional', NULL, NULL, NULL, 5, 'Pindai bukti kehadiran atau sertifikat dan bukti kinerja, Panitia', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (70, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Disajikan dalam seminar/simposium/ lokakarya, tetapi tidak dimuat dalam prosiding yang dipublikasikan : Nasional', NULL, NULL, NULL, 3, 'Pindai bukti kehadiran atau sertifikat dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (71, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Hasil penelitian/pemikiran yang tidak disajikan dalam seminar/simposium/ lokakarya, tetapi dimuat dalam prosiding : Internasional', NULL, NULL, NULL, 10, 'Pindai halaman sampul, daftar isi makalah, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (72, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Hasil penelitian/pemikiran yang tidak disajikan dalam seminar/simposium/ lokakarya, tetapi dimuat dalam prosiding : Nasional', NULL, NULL, NULL, 5, 'Pindai halaman sampul, daftar isi makalah, dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (73, 3, 'Hasil penelitian atau hasil pemikiran yang didesiminasikan : Hasil penelitian/pemikiran yang disajikan dalam koran/majalah populer/umum', 5, '%', 6, 1, 'Pindai halaman sampul dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (74, 3, 'Hasil penelitian atau pemikiran atau kerjasama industri yang tidak dipublikasikan (tersimpan dalam perpustakaan) yang dilakukan secara melembaga', 5, '%', 6, 2, 'Pindai halaman sampul, daftar isi, lembar pengesahan dan bukti kinerja', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (75, 3, 'Menerjemahkan/menyadur buku ilmiah yang diterbitkan (ber ISBN)', NULL, NULL, NULL, 15, 'Pindai halaman sampul dan bukti kinerja yang dapat diakses oleh asesor', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (76, 3, 'Mengedit/menyunting karya ilmiah dalam bentuk buku yang diterbitkan (ber ISBN)', NULL, NULL, NULL, 10, 'Pindai halaman sampul dan bukti kinerja yang dapat diakses oleh asesor', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (77, 3, 'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Internasional yang sudah diimplementasikan di industri (paling sedikit diakui oleh 4 Negara)', NULL, NULL, NULL, 60, 'Pindai bukti kinerja dan sertifikat paten', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (78, 3, 'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Internasional (paling sedikit diakui oleh 4 Negara)', NULL, NULL, NULL, 50, 'Pindai bukti kinerja dan sertifikat paten', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (79, 3, 'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Nasional (yang sudah diimplementasikan di industri)', NULL, NULL, NULL, 40, 'Pindai bukti kinerja dan sertifikat paten', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (80, 3, 'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Nasional', NULL, NULL, NULL, 30, 'Pindai bukti kinerja dan sertifikat paten', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (81, 3, 'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Nasional, dalam bentuk paten sederhana yang telah memiliki sertifikat dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham;', NULL, NULL, NULL, 20, 'Pindai bukti kinerja dan sertifikat paten', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (118, 4, 'Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun)* : Editor/dewan penyunting/dewan redaksi jurnal ilmiah internasional (Diakui satu jurnal)', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (119, 4, 'Berperan serta aktif dalam pengelolaan jurnal ilmiah (per tahun)* :  Editor/dewan penyunting/dewan redaksi jurnal ilmiah nasional (Diakui satu jurnal)', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (82, 3, 'Membuat rancangan dan karya teknologi yang dipatenkan atau seni yang terdaftar di HaKI secara nasional atau internasional : Karya ciptaan, desain industri, indikasi geografis yang telah memiliki sertifikat dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham; Karya cipta berupa buku yang telah mendapatkan sertifikat karya cipta dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham maka karya cipta tersebut hanya dapat diajukan salah satu sebagai bukti melaksanakan penelitian atau pendidikan.', 2, 'Karya', 1, 15, 'Pindai bukti kinerja dan sertifikat dari Direktorat Jenderal Kekayaan Intelektual, Kemenkumham', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (83, 3, 'Membuat rancangan dan karya teknologi yang tidak dipatenkan; rancangan dan karya seni monumental yang tidak terdaftar di HaKI tetapi telah dipresentasikan pada forum yang teragenda : Tingkat Internasional', NULL, NULL, NULL, 20, 'Pindai bukti kinerja, peer review internasional  sesuai bidang ilmu', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (84, 3, 'Membuat rancangan dan karya teknologi yang tidak dipatenkan; rancangan dan karya seni monumental yang tidak terdaftar di HaKI tetapi telah dipresentasikan pada forum yang teragenda : Tingkat Nasional', NULL, NULL, NULL, 15, 'Pindai bukti kinerja, peer review sesuai bidang ilmu', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (85, 3, 'Membuat rancangan dan karya teknologi yang tidak dipatenkan; rancangan dan karya seni monumental yang tidak terdaftar di HaKI tetapi telah dipresentasikan pada forum yang teragenda : Tingkat Lokal', NULL, NULL, NULL, 10, 'Pindai bukti kinerja, peer review sesuai bidang ilmu', NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (86, 3, 'Pelaksanaan penelitian karya seni sebagai komposer/penulis naskah/sutradara/perancang/pencipta/pengubah/kameramen/animator/kurator/editor audio visual internasional', NULL, 'Karya', NULL, 20, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (87, 3, 'Pelaksanaan penelitian karya seni sebagai komposer/penulis naskah/sutradara/perancang/pencipta/pengubah/kameramen/animator/kurator/editor audio visual nasional', NULL, 'Karya', NULL, 15, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (88, 3, 'Pelaksanaan penelitian karya seni sebagai komposer/penulis naskah/sutradara/perancang/pencipta/pengubah/kameramen/animator/kurator/editor audio visual lokal', NULL, 'Karya', NULL, 10, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (89, 3, 'Pelaksanaan penelitian kayra seni Sebagai Penata Arstistik/Penata Musik/Penata Rias/PenataBusana/Penata Tari/Penata Lampu/Penata Suara/Penata Panggung/Ilustrator Foto/Kunduktor Internasional', NULL, 'Pentas', NULL, 10, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (90, 3, 'Pelaksanaan penelitian kayra seni Sebagai Penata Arstistik/Penata Musik/Penata Rias/Penata Busana/Penata Tari/Penata Lampu/Penata Suara/Penata Panggung/Ilustrator Foto/Kunduktor nasional', NULL, 'Pentas', NULL, 6, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (91, 3, 'Pelaksanaan penelitian kayra seni Sebagai Penata Arstistik/Penata Musik/Penata Rias/PenataBusana/Penata Tari/Penata Lampu/Penata Suara/Penata Panggung/Ilustrator Foto/Kunduktor lokal', NULL, 'Pentas', NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (92, 3, 'Pelaksanaan penelitian karya seni Sebagai Pemusik/Pengrawit/Penari/Dalang/Pemeran/Pengarah Acara Televisi/Pelaksana Perancangan/Pendisplay Pameran/Pembuat Foto Dokumentasi/Pewarta Foto/Pembawa Acara/Reporter/Redaktur Pelaksana Internasional', NULL, 'Sajian', NULL, 6, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (93, 3, 'Pelaksanaan penelitian karya seni Sebagai Pemusik/Pengrawit/Penari/Dalang/Pemeran/Pengarah Acara Televisi/Pelaksana Perancangan/Pendisplay Pameran/Pembuat Foto Dokumentasi/Pewarta Foto/Pembawa Acara/Reporter/Redaktur Pelaksana nasional', NULL, 'Sajian', NULL, 4, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (94, 3, 'Pelaksanaan penelitian karya seni Sebagai Pemusik/Pengrawit/Penari/Dalang/Pemeran/Pengarah Acara Televisi/Pelaksana Perancangan/ Pendisplay Pameran/Pembuat Foto Dokumentasi/Pewarta Foto/Pembawa Acara/Reporter/Redaktur Pelaksana lokal', NULL, 'Sajian', NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (95, 3, 'Pelaksanaan penelitian karya seni Sebagai Penulis Naskah Drama/Novel Internasional', NULL, 'Karya', NULL, 20, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (96, 3, 'Pelaksanaan penelitian karya seni Sebagai Penulis Naskah Drama/Novel nasional', NULL, 'Karya', NULL, 15, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (97, 3, 'Pelaksanaan penelitian karya seni Sebagai Penulis Naskah Drama/Novel lokal', NULL, 'Karya', NULL, 10, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (98, 3, 'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Internasional', NULL, 'Karya', NULL, 20, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (99, 3, 'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Nasional', NULL, 'Karya', NULL, 15, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (100, 3, 'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Internasional', NULL, 'Karya', NULL, 10, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (101, 3, 'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Puisi Internasional', NULL, 'Karya', NULL, 20, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (102, 3, 'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Nasional', NULL, 'Karya', NULL, 15, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (103, 3, 'Pelaksanaan penelitian karya satra Sebagai Penulis Buku Kumpulan Cerpen Lokal', NULL, 'Karya', NULL, 10, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (104, 4, 'Menduduki jabatan pimpinan pada lembaga pemerintahan/pejabat negara yang harus dibebaskan dari jabatan organiknya tiap semester.', NULL, NULL, NULL, 6, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (105, 4, 'Melaksanakan pengembangan hasil pendidikan, dan penelitian yang dapat dimanfaatkan oleh masyarakat/ industry setiap program.', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (106, 4, 'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Dalam satu semester atau lebih :  Tingkat Internasional tiap program', NULL, NULL, NULL, 4, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (107, 4, 'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Dalam satu semester atau lebih :  Tingkat Nasional, tiap program', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (108, 4, 'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Dalam satu semester atau lebih :  Tingkat Lokal, tiap program', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (109, 4, 'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Tingkat Internasional tiap program', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (110, 4, 'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Tingkat Nasional, tiap program', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (111, 4, 'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Tingkat Lokal, tiap program', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (112, 4, 'Memberi latihan/penyuluhan/ penataran/ceramah pada masyarakat, terjadwal/terprogram : Kurang dari satu semester dan minimal satu bulan : Insidental, tiap kegiatan/program', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (113, 4, 'Memberi pelayanan kepada masyarakat atau kegiatan lain yang menunjang pelaksanaan tugas pemerintahan dan pembangunan : Berdasarkan bidang keahlian, tiap program', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (114, 4, 'Memberi pelayanan kepada masyarakat atau kegiatan lain yang menunjang pelaksanaan tugas pemerintahan dan pembangunan :  Berdasarkan penugasan lembaga terguruan tinggi, tiap program', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (115, 4, 'Memberi pelayanan kepada masyarakat atau kegiatan lain yang menunjang pelaksanaan tugas pemerintahan dan pembangunan :  Berdasarkan fungsi/jabatan tiap program', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (116, 4, 'Membuat/menulis karya pengabdian pada masyarakat yang tidak dipublikasikan,tiap karya', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (117, 4, 'Hasil kegiatan pengabdian kepada masyarakat yang dipublikasikan di sebuah berkala/jurnal pengabdian kepada masyarakat atau teknologi tepat guna, merupakan diseminasi dari luaran program kegiatan pengabdian kepada masyarakat, tiap karya', NULL, NULL, NULL, 5, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (120, 5, 'Menjadi anggota dalam suatu Panitia/Badan pada Perguruan Tinggi  sebagai Ketua/Wakil Ketua merangkap Anggota, tiap tahun', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (121, 5, 'Menjadi anggota dalam suatu Panitia/Badan pada Perguruan Tinggi sebagai Anggota, tiap tahun', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (122, 5, 'Menjadi anggota panitia/badan pada lembaga pemerintah  panitia pusat, sebagai Ketua/Wakil Ketua, tiap kepanitiaan', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (123, 5, 'Menjadi anggota panitia/badan pada lembaga pemerintah  panitia pusat, sebagai Anggota, tiap kepanitiaan', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (124, 5, 'Menjadi anggota panitia/badan pada lembaga pemerintah panitia daerah, sebagai Ketua/Wakil Ketua, tiap kepanitiaan', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (125, 5, 'Menjadi anggota panitia/badan pada lembaga pemerintah panitia daerah, sebagai Anggota, tiap kepanitiaan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (126, 5, 'Menjadi anggota organisasi profesi Tingkat Internasional, sebagai :  Pengurus, tiap periode jabatan pengurus merangkap anggota', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (127, 5, 'Menjadi anggota organisasi profesi Tingkat Internasional, sebagai :  Anggota atas permintaan, tiap periode jabatan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (128, 5, 'Menjadi anggota organisasi profesi Tingkat Internasional, sebagai : Anggota, tiap periode jabatan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (129, 5, 'Menjadi anggota organisasi profesi Tingkat Nasional, sebagai :  Pengurus, tiap periode jabatan', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (130, 5, 'Menjadi anggota organisasi profesi Tingkat Nasional, sebagai : Anggota, atas permintaan, tiap periode jabatan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (131, 5, 'Menjadi anggota organisasi profesi Tingkat Nasional, sebagai : Anggota, tiap periode jabatan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (132, 5, 'Mewakili Perguruan Tinggi/Lembaga Pemerintah duduk dalam Panitia Antar Lembaga, tiap kepanitiaan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (133, 5, 'Menjadi anggota delegasi Nasional ke pertemuan Internasional Sebagai Ketua delegasi, tiap kegiatan', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (134, 5, 'Menjadi anggota delegasi Nasional ke pertemuan Internasional Sebagai Anggota, tiap kegiatan', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (135, 5, 'Berperan serta aktif dalam pertemuan ilmiah tingkat Internasional/Nasional/Regional sebagai : Ketua, tiap kegiatan', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (136, 5, 'Berperan serta aktif dalam pertemuan ilmiah Tingkat Internasional/Nasional/Regional sebagai : Anggota/peserta, tiap kegiatan', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (137, 5, 'Berperan serta aktif dalam pertemuan ilmiah Di lingkungan Perguruan Tinggi sebagai :  Ketua, tiap kegiatan', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (138, 5, 'Berperan serta aktif dalam pertemuan ilmiah Di lingkungan Perguruan Tinggi sebagai :  Anggota/peserta, tiap kegiatan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (139, 5, 'Mendapat tanda jasa/penghargaan : Penghargaan/tanda jasa Satya lencana 30 tahun', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (140, 5, 'Mendapat tanda jasa/penghargaan : Penghargaan/tanda jasa Satya lencana 20 tahun', NULL, NULL, NULL, 2, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (141, 5, 'Mendapat tanda jasa/penghargaan : Penghargaan/tanda jasa Satya lencana 10 tahun', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (142, 5, 'Mendapat tanda jasa/penghargaan : Tingkat Internasional, tiap tanda jasa/penghargaan', NULL, NULL, NULL, 5, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (143, 5, 'Mendapat tanda jasa/penghargaan : Tingkat Nasional, tiap tanda jasa/penghargaan', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (144, 5, 'Mendapat tanda jasa/penghargaan :  Tingkat Daerah/Lokal, tiap tanda jasa/penghargaan', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (145, 5, 'Menulis buku pelajaran SLTA ke bawah yang diterbitkan dan diedarkan secara nasional :  Buku SMTA atau setingkat, tiap buku', NULL, NULL, NULL, 5, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (146, 5, 'Menulis buku pelajaran SLTA ke bawah yang diterbitkan dan diedarkan secara nasional :  Buku SMTP atau setingkat, tiap buku', NULL, NULL, NULL, 5, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (147, 5, 'Menulis buku pelajaran SLTA ke bawah yang diterbitkan dan diedarkan secara nasional :   Buku SD atau setingkat, tiap buku', NULL, NULL, NULL, 5, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (148, 5, 'Mempunyai prestasi di bidang olahraga/ Humaniora : Tingkat Internasional, tiap piagam/medali', NULL, NULL, NULL, 5, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (149, 5, 'Mempunyai prestasi di bidang olahraga/ Humaniora : Tingkat Nasional, tiap piagam/medali', NULL, NULL, NULL, 3, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (150, 5, 'Mempunyai prestasi di bidang olahraga/ Humaniora : Tingkat Daerah/Lokal, tiap piagam/medali', NULL, NULL, NULL, 1, NULL, NULL);
INSERT INTO si_pak_dosen.unsur_penilaian VALUES (151, 5, 'Keanggotaan dalam tim penilai jabatan akademik dosen', NULL, NULL, NULL, 1, NULL, NULL);


--
-- TOC entry 3983 (class 0 OID 29233)
-- Dependencies: 476
-- Data for Name: user; Type: TABLE DATA; Schema: si_pak_dosen; Owner: -
--



--
-- TOC entry 3997 (class 0 OID 0)
-- Dependencies: 458
-- Name: item_penilaian_id_item_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.item_penilaian_id_item_seq', 1, true);


--
-- TOC entry 3998 (class 0 OID 0)
-- Dependencies: 460
-- Name: jabatan_id_jabatan_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.jabatan_id_jabatan_seq', 8, true);


--
-- TOC entry 3999 (class 0 OID 0)
-- Dependencies: 462
-- Name: jenis_batas_id_jenis_batas_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.jenis_batas_id_jenis_batas_seq', 6, true);


--
-- TOC entry 4000 (class 0 OID 0)
-- Dependencies: 464
-- Name: kategori_penilaian_id_kategori_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.kategori_penilaian_id_kategori_seq', 5, true);


--
-- TOC entry 4001 (class 0 OID 0)
-- Dependencies: 467
-- Name: pak_id_pak_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.pak_id_pak_seq', 1, true);


--
-- TOC entry 4002 (class 0 OID 0)
-- Dependencies: 471
-- Name: subrumpun_id_subrumpun_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.subrumpun_id_subrumpun_seq', 840, true);


--
-- TOC entry 4003 (class 0 OID 0)
-- Dependencies: 473
-- Name: unsur_penilaian_id_unsur_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.unsur_penilaian_id_unsur_seq', 151, true);


--
-- TOC entry 4004 (class 0 OID 0)
-- Dependencies: 475
-- Name: user_id_user_seq; Type: SEQUENCE SET; Schema: si_pak_dosen; Owner: -
--

SELECT pg_catalog.setval('si_pak_dosen.user_id_user_seq', 1, true);


--
-- TOC entry 3765 (class 2606 OID 29270)
-- Name: batas_kategori idx_29183_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.batas_kategori
    ADD CONSTRAINT idx_29183_primary PRIMARY KEY (id_jabatan, id_kategori);


--
-- TOC entry 3769 (class 2606 OID 29276)
-- Name: item_penilaian idx_29187_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.item_penilaian
    ADD CONSTRAINT idx_29187_primary PRIMARY KEY (id_item);


--
-- TOC entry 3771 (class 2606 OID 29272)
-- Name: jabatan idx_29192_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.jabatan
    ADD CONSTRAINT idx_29192_primary PRIMARY KEY (id_jabatan);


--
-- TOC entry 3773 (class 2606 OID 29273)
-- Name: jenis_batas idx_29197_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.jenis_batas
    ADD CONSTRAINT idx_29197_primary PRIMARY KEY (id_jenis_batas);


--
-- TOC entry 3775 (class 2606 OID 29274)
-- Name: kategori_penilaian idx_29202_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.kategori_penilaian
    ADD CONSTRAINT idx_29202_primary PRIMARY KEY (id_kategori);


--
-- TOC entry 3777 (class 2606 OID 29277)
-- Name: login_info idx_29206_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.login_info
    ADD CONSTRAINT idx_29206_primary PRIMARY KEY (id_user);


--
-- TOC entry 3788 (class 2606 OID 29278)
-- Name: pak idx_29210_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT idx_29210_primary PRIMARY KEY (id_pak);


--
-- TOC entry 3792 (class 2606 OID 29279)
-- Name: penilai_luar idx_29214_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.penilai_luar
    ADD CONSTRAINT idx_29214_primary PRIMARY KEY (id_user);


--
-- TOC entry 3794 (class 2606 OID 29275)
-- Name: status_pak idx_29217_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.status_pak
    ADD CONSTRAINT idx_29217_primary PRIMARY KEY (id_status_pak);


--
-- TOC entry 3796 (class 2606 OID 29271)
-- Name: subrumpun idx_29221_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.subrumpun
    ADD CONSTRAINT idx_29221_primary PRIMARY KEY (id_subrumpun);


--
-- TOC entry 3800 (class 2606 OID 29269)
-- Name: unsur_penilaian idx_29226_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.unsur_penilaian
    ADD CONSTRAINT idx_29226_primary PRIMARY KEY (id_unsur);


--
-- TOC entry 3803 (class 2606 OID 29280)
-- Name: user idx_29233_primary; Type: CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen."user"
    ADD CONSTRAINT idx_29233_primary PRIMARY KEY (id_user);


--
-- TOC entry 3763 (class 1259 OID 29237)
-- Name: idx_29183_fk_bataskat_memiliki_kategori; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29183_fk_bataskat_memiliki_kategori ON si_pak_dosen.batas_kategori USING btree (id_kategori);


--
-- TOC entry 3766 (class 1259 OID 29246)
-- Name: idx_29187_fk_itempeni_memiliki1_pak; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29187_fk_itempeni_memiliki1_pak ON si_pak_dosen.item_penilaian USING btree (id_pak);


--
-- TOC entry 3767 (class 1259 OID 29250)
-- Name: idx_29187_fk_itempeni_memiliki__unsurpen; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29187_fk_itempeni_memiliki__unsurpen ON si_pak_dosen.item_penilaian USING btree (id_unsur);


--
-- TOC entry 3778 (class 1259 OID 29254)
-- Name: idx_29206_unique_username; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE UNIQUE INDEX idx_29206_unique_username ON si_pak_dosen.login_info USING btree (username);


--
-- TOC entry 3779 (class 1259 OID 29252)
-- Name: idx_29210_fk_pak_menilai_1_user; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_pak_menilai_1_user ON si_pak_dosen.pak USING btree (id_penilai_1);


--
-- TOC entry 3780 (class 1259 OID 29248)
-- Name: idx_29210_fk_pak_menilai_2_user; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_pak_menilai_2_user ON si_pak_dosen.pak USING btree (id_penilai_2);


--
-- TOC entry 3781 (class 1259 OID 29251)
-- Name: idx_29210_fk_pak_pak_untuk_jabatan; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_pak_pak_untuk_jabatan ON si_pak_dosen.pak USING btree (id_jabatan_tujuan);


--
-- TOC entry 3782 (class 1259 OID 29249)
-- Name: idx_29210_fk_pak_relations_jabatan; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_pak_relations_jabatan ON si_pak_dosen.pak USING btree (id_jabatan_awal);


--
-- TOC entry 3783 (class 1259 OID 29260)
-- Name: idx_29210_fk_pak_relations_user; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_pak_relations_user ON si_pak_dosen.pak USING btree (id_pemohon);


--
-- TOC entry 3784 (class 1259 OID 29256)
-- Name: idx_29210_fk_pak_subrumpun; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_pak_subrumpun ON si_pak_dosen.pak USING btree (id_subrumpun);


--
-- TOC entry 3785 (class 1259 OID 29257)
-- Name: idx_29210_fk_penilai_submit; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_penilai_submit ON si_pak_dosen.pak USING btree (id_penilai_submit);


--
-- TOC entry 3786 (class 1259 OID 29258)
-- Name: idx_29210_fk_status_pak; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29210_fk_status_pak ON si_pak_dosen.pak USING btree (id_status_pak);


--
-- TOC entry 3789 (class 1259 OID 29262)
-- Name: idx_29214_fk_penilail_memiliki__jabatan; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29214_fk_penilail_memiliki__jabatan ON si_pak_dosen.penilai_luar USING btree (id_jabatan);


--
-- TOC entry 3790 (class 1259 OID 29264)
-- Name: idx_29214_fk_penilail_memiliki__subrumpu; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29214_fk_penilail_memiliki__subrumpu ON si_pak_dosen.penilai_luar USING btree (id_subrumpun);


--
-- TOC entry 3797 (class 1259 OID 29240)
-- Name: idx_29226_fk_batas; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29226_fk_batas ON si_pak_dosen.unsur_penilaian USING btree (id_jenis_batas);


--
-- TOC entry 3798 (class 1259 OID 29244)
-- Name: idx_29226_fk_unsurpen_memiliki__kategori; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE INDEX idx_29226_fk_unsurpen_memiliki__kategori ON si_pak_dosen.unsur_penilaian USING btree (id_kategori);


--
-- TOC entry 3801 (class 1259 OID 29263)
-- Name: idx_29233_ak_identifier_2; Type: INDEX; Schema: si_pak_dosen; Owner: -
--

CREATE UNIQUE INDEX idx_29233_ak_identifier_2 ON si_pak_dosen."user" USING btree (id_pegawai);


--
-- TOC entry 3820 (class 2606 OID 29361)
-- Name: unsur_penilaian fk_batas; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.unsur_penilaian
    ADD CONSTRAINT fk_batas FOREIGN KEY (id_jenis_batas) REFERENCES si_pak_dosen.jenis_batas(id_jenis_batas);


--
-- TOC entry 3804 (class 2606 OID 29281)
-- Name: batas_kategori fk_bataskat_batas_unt_jabatan; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.batas_kategori
    ADD CONSTRAINT fk_bataskat_batas_unt_jabatan FOREIGN KEY (id_jabatan) REFERENCES si_pak_dosen.jabatan(id_jabatan);


--
-- TOC entry 3805 (class 2606 OID 29286)
-- Name: batas_kategori fk_bataskat_memiliki_kategori; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.batas_kategori
    ADD CONSTRAINT fk_bataskat_memiliki_kategori FOREIGN KEY (id_kategori) REFERENCES si_pak_dosen.kategori_penilaian(id_kategori);


--
-- TOC entry 3806 (class 2606 OID 29291)
-- Name: item_penilaian fk_itempeni_memiliki1_pak; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.item_penilaian
    ADD CONSTRAINT fk_itempeni_memiliki1_pak FOREIGN KEY (id_pak) REFERENCES si_pak_dosen.pak(id_pak);


--
-- TOC entry 3807 (class 2606 OID 29296)
-- Name: item_penilaian fk_itempeni_memiliki__unsurpen; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.item_penilaian
    ADD CONSTRAINT fk_itempeni_memiliki__unsurpen FOREIGN KEY (id_unsur) REFERENCES si_pak_dosen.unsur_penilaian(id_unsur);


--
-- TOC entry 3808 (class 2606 OID 29301)
-- Name: login_info fk_logininf_relations_user; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.login_info
    ADD CONSTRAINT fk_logininf_relations_user FOREIGN KEY (id_user) REFERENCES si_pak_dosen."user"(id_user);


--
-- TOC entry 3809 (class 2606 OID 29306)
-- Name: pak fk_pak_menilai_1_user; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_pak_menilai_1_user FOREIGN KEY (id_penilai_1) REFERENCES si_pak_dosen."user"(id_user);


--
-- TOC entry 3810 (class 2606 OID 29311)
-- Name: pak fk_pak_menilai_2_user; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_pak_menilai_2_user FOREIGN KEY (id_penilai_2) REFERENCES si_pak_dosen."user"(id_user);


--
-- TOC entry 3811 (class 2606 OID 29316)
-- Name: pak fk_pak_pak_untuk_jabatan; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_pak_pak_untuk_jabatan FOREIGN KEY (id_jabatan_tujuan) REFERENCES si_pak_dosen.jabatan(id_jabatan);


--
-- TOC entry 3812 (class 2606 OID 29321)
-- Name: pak fk_pak_relations_jabatan; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_pak_relations_jabatan FOREIGN KEY (id_jabatan_awal) REFERENCES si_pak_dosen.jabatan(id_jabatan);


--
-- TOC entry 3813 (class 2606 OID 29326)
-- Name: pak fk_pak_relations_user; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_pak_relations_user FOREIGN KEY (id_pemohon) REFERENCES si_pak_dosen."user"(id_user);


--
-- TOC entry 3814 (class 2606 OID 29331)
-- Name: pak fk_pak_subrumpun; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_pak_subrumpun FOREIGN KEY (id_subrumpun) REFERENCES si_pak_dosen.subrumpun(id_subrumpun);


--
-- TOC entry 3815 (class 2606 OID 29336)
-- Name: pak fk_penilai_submit; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_penilai_submit FOREIGN KEY (id_penilai_submit) REFERENCES si_pak_dosen."user"(id_user);


--
-- TOC entry 3817 (class 2606 OID 29346)
-- Name: penilai_luar fk_penilail_adalah_user; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.penilai_luar
    ADD CONSTRAINT fk_penilail_adalah_user FOREIGN KEY (id_user) REFERENCES si_pak_dosen."user"(id_user);


--
-- TOC entry 3818 (class 2606 OID 29351)
-- Name: penilai_luar fk_penilail_memiliki__jabatan; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.penilai_luar
    ADD CONSTRAINT fk_penilail_memiliki__jabatan FOREIGN KEY (id_jabatan) REFERENCES si_pak_dosen.jabatan(id_jabatan);


--
-- TOC entry 3819 (class 2606 OID 29356)
-- Name: penilai_luar fk_penilail_memiliki__subrumpu; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.penilai_luar
    ADD CONSTRAINT fk_penilail_memiliki__subrumpu FOREIGN KEY (id_subrumpun) REFERENCES si_pak_dosen.subrumpun(id_subrumpun);


--
-- TOC entry 3816 (class 2606 OID 29341)
-- Name: pak fk_status_pak; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.pak
    ADD CONSTRAINT fk_status_pak FOREIGN KEY (id_status_pak) REFERENCES si_pak_dosen.status_pak(id_status_pak);


--
-- TOC entry 3821 (class 2606 OID 29366)
-- Name: unsur_penilaian fk_unsurpen_memiliki__kategori; Type: FK CONSTRAINT; Schema: si_pak_dosen; Owner: -
--

ALTER TABLE ONLY si_pak_dosen.unsur_penilaian
    ADD CONSTRAINT fk_unsurpen_memiliki__kategori FOREIGN KEY (id_kategori) REFERENCES si_pak_dosen.kategori_penilaian(id_kategori);


-- Completed on 2024-11-21 16:41:36

--
-- PostgreSQL database dump complete
--

