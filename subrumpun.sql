--
-- File generated with SQLiteStudio v3.2.1 on Thu Dec 5 21:33:07 2019
--
-- Text encoding used: UTF-8
--
PRAGMA foreign_keys = off;
BEGIN TRANSACTION;

-- Table: subrumpun
CREATE TABLE subrumpun (ID_SUBRUMPUN INTEGER PRIMARY KEY NOT NULL, ID_RUMPUN INTEGER NOT NULL, SUBRUMPUN VARCHAR (25) NOT NULL);
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (110, 100, 'Ushuluddin');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (120, 100, 'Syariah');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (130, 100, 'Adab');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (140, 100, 'Dakwah');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (150, 100, 'Tarbiyah');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (220, 200, 'Bahasa');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (310, 300, 'Pendidikan');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (330, 300, 'Ekonomi');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (340, 300, 'Psikologi');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (350, 300, 'Komunikasi');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (380, 300, 'Sosiologi');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (410, 300, 'Politik');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (420, 300, 'Perpustakaan');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (430, 300, 'Hukum');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (510, 500, 'Biologi');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (520, 500, 'Fisika');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (530, 500, 'Matematika');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (540, 500, 'Kimia');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (550, 500, 'Farmasi');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (560, 500, 'Ilmu Kedokteran');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (570, 500, 'Pertanian');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (580, 500, 'Peternakan');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (640, 500, 'Komputer');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (810, 800, 'Teknik');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (830, 800, 'Arsitektur');
INSERT INTO subrumpun (ID_SUBRUMPUN, ID_RUMPUN, SUBRUMPUN) VALUES (840, 800, 'Teknik Perencanaan Tata Kota');

COMMIT TRANSACTION;
PRAGMA foreign_keys = on;
