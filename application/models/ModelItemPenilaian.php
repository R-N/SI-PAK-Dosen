<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(ENTITIES_DIR  . "EntriItemPAK.php");
require_once(ENTITIES_DIR  . "EntriItemEditPAK.php");
require_once(ENTITIES_DIR  . "UnsurPenilaian.php");
require_once(ENTITIES_DIR  . "BatasKategori.php");

class ModelItemPenilaian extends CI_Model {
	function fetchBatasKategori($idJabatan){
		$sql = "SELECT * FROM batas_kategori B, kategori_penilaian K WHERE B.ID_KATEGORI=K.ID_KATEGORI AND B.ID_JABATAN=? ORDER BY B.ID_KATEGORI";
		$data = array($idJabatan);
		
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new BatasKategori();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function fetchUnsurPenilaian(){
		$sql = "SELECT * FROM unsur_penilaian U, kategori_penilaian K, jenis_batas JB WHERE U.ID_KATEGORI=K.ID_KATEGORI AND U.ID_JENIS_BATAS=JB.ID_JENIS_BATAS ORDER BY K.ID_KATEGORI, U.ID_UNSUR";
		
		$query = $this->db->query($sql);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new UnsurPenilaian();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function fetchItemPenilaianEdit($idPAK){
		$sql = "
		SELECT 
			I.ID_ITEM, 
			I.ID_PAK, 
			I.ID_UNSUR, 
			U.KEGIATAN, 
			I.ID_KATEGORI,
			K.KATEGORI,
			I.URL_DOKUMEN,
			I.NILAI_AWAL AS NILAI,
			I.TAHUN,
			I.SEMESTER,
			U.BATAS,
			U.UNIT,
			U.ID_JENIS_BATAS,
			JB.JENIS_BATAS,
			U.MAX_KREDIT,
			U.KETERANGAN,
			U.BUKTI
		FROM ITEM_PENILAIAN I, UNSUR_PENILAIAN U, KATEGORI_PENILAIAN K, JENIS_BATAS JB
		WHERE I.ID_PAK=?
			AND I.ID_UNSUR=U.ID_UNSUR
			AND U.ID_KATEGORI=K.ID_KATEGORI
			AND U.ID_JENIS_BATAS=JB.ID_JENIS_BATAS
		OREDER BY U.ID KATEGORI ASC, I.ID_UNSUR ASC";
		$data = array($idPAK);
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriItemPAK();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function fetchItemPenilaianNilai($idPAK){
	}
	function fetchItemPenilaian($idPAK){
		$sql = "
		SELECT 
			I.ID_ITEM, 
			I.ID_PAK, 
			I.ID_UNSUR, 
			(CASE 
				WHEN TAHUN IS NULL THEN U.KEGIATAN
				WHEN SEMESTER IS NULL THEN CONCAT(U.KEGIATAN, ' (', I.TAHUN, ')')
				ELSE CONCAT(U.KEGIATAN, ' (', I.TAHUN,
					CASE WHEN I.SEMESTER=1 THEN 'semester ganjil' ELSE 'semester genap' END,
				')')
			END) AS KEGIATAN,
			I.ID_KATEGORI,
			K.KATEGORI,
			I.URL_DOKUMEN,
			(CASE WHEN NILAI_1 IS NOT NULL AND NILAI_2 IS NOT NULL 
				THEN (NILAI_1+NILAI_2)*0.5
				ELSE NILAI_AWAL
			END ) AS NILAI,
			U.BUKTI
		FROM ITEM_PENILAIAN I, UNSUR_PENILAIAN U, KATEGORI_PENILAIAN K
		WHERE I.ID_PAK=?
			AND I.ID_UNSUR=U.ID_UNSUR
			AND U.ID_KATEGORI=K.ID_KATEGORI
		OREDER BY U.ID KATEGORI ASC, I.ID_UNSUR ASC";
		$data = array($idPAK);
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriItemPAK();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function getItemPenilaian($idItem){
	}
	function simpanItemPenilaian($item){
	}
	function hapusItemPenilaian($idItem){
	}
}
?>