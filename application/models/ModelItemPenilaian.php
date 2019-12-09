<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(ENTITIES_DIR  . "EntriItemPAK.php");
require_once(ENTITIES_DIR  . "EntriItemEditPAK.php");
require_once(ENTITIES_DIR  . "EntriItemDetailPAK.php");
require_once(ENTITIES_DIR  . "EntriItemNilaiPAK.php");
require_once(ENTITIES_DIR  . "EntriItemNilaiAkhirPAK.php");
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
		$sql = "SELECT * FROM kategori_penilaian K, unsur_penilaian U LEFT JOIN jenis_batas JB ON U.ID_JENIS_BATAS=JB.ID_JENIS_BATAS  WHERE U.ID_KATEGORI=K.ID_KATEGORI  ORDER BY U.ID_KATEGORI ASC, U.ID_UNSUR ASC";
		
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
			U.ID_KATEGORI,
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
		FROM KATEGORI_PENILAIAN K, ITEM_PENILAIAN I, UNSUR_PENILAIAN U LEFT JOIN JENIS_BATAS JB ON U.ID_JENIS_BATAS=JB.ID_JENIS_BATAS
		WHERE I.ID_PAK=?
			AND I.ID_UNSUR=U.ID_UNSUR
			AND U.ID_KATEGORI=K.ID_KATEGORI
		ORDER BY U.ID_KATEGORI ASC, I.ID_UNSUR ASC, I.ID_ITEM ASC";
		$data = array($idPAK);
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriItemEditPAK();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function fetchItemPenilaianNilai($idPAK, $nomorPenilai){
		$sql = "
		SELECT 
			I.ID_ITEM, 
			I.ID_PAK, 
			I.ID_UNSUR, 
			(CASE 
				WHEN TAHUN IS NULL OR TAHUN=0 THEN U.KEGIATAN
				WHEN SEMESTER IS NULL OR SEMESTER=0 THEN CONCAT(U.KEGIATAN, ' (', I.TAHUN, ')')
				ELSE CONCAT(U.KEGIATAN, ' (', I.TAHUN, ', ',
					CASE WHEN I.SEMESTER=1 THEN 'semester ganjil' ELSE 'semester genap' END,
				')')
			END) AS KEGIATAN,
			U.ID_KATEGORI,
			K.KATEGORI,
			I.URL_DOKUMEN,
			I.NILAI_AWAL,
			I.NILAI_{$nomorPenilai} AS NILAI_PENILAI,
			U.BUKTI
		FROM ITEM_PENILAIAN I, UNSUR_PENILAIAN U, KATEGORI_PENILAIAN K
		WHERE I.ID_PAK=?
			AND I.ID_UNSUR=U.ID_UNSUR
			AND U.ID_KATEGORI=K.ID_KATEGORI
		ORDER BY U.ID_KATEGORI ASC, I.ID_UNSUR ASC, I.ID_ITEM ASC";
		$data = array($idPAK);
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriItemNilaiPAK();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	
	function fetchItemPenilaianNilaiDict($idPAK, $nomorPenilai){
		$sql = "
		SELECT 
			I.ID_ITEM, 
			I.ID_UNSUR, 
			(CASE 
				WHEN TAHUN IS NULL OR TAHUN=0 THEN U.KEGIATAN
				WHEN SEMESTER IS NULL OR SEMESTER=0 THEN CONCAT(U.KEGIATAN, ' (', I.TAHUN, ')')
				ELSE CONCAT(U.KEGIATAN, ' (', I.TAHUN, ', ',
					CASE WHEN I.SEMESTER=1 THEN 'semester ganjil' ELSE 'semester genap' END,
				')')
			END) AS KEGIATAN, 
			I.NILAI_AWAL
		FROM ITEM_PENILAIAN I, UNSUR_PENILAIAN U
		WHERE I.ID_PAK=?
			AND I.ID_UNSUR=U.ID_UNSUR
		ORDER BY U.ID_KATEGORI ASC, I.ID_UNSUR ASC, I.ID_ITEM ASC";
		$data = array($idPAK);
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$item = $results[$i];
			$item->no = $i+1;
			$ret[$item->ID_ITEM] = $item;
		}
		return $ret;
	}
	function fetchItemPenilaian($idPAK){
		$sql = "
		SELECT 
			I.ID_ITEM, 
			I.ID_PAK, 
			I.ID_UNSUR, 
			(CASE 
				WHEN TAHUN IS NULL OR TAHUN=0 THEN U.KEGIATAN
				WHEN SEMESTER IS NULL OR SEMESTER=0 THEN CONCAT(U.KEGIATAN, ' (', I.TAHUN, ')')
				ELSE CONCAT(U.KEGIATAN, ' (', I.TAHUN, ', ',
					CASE WHEN I.SEMESTER=1 THEN 'semester ganjil' ELSE 'semester genap' END,
				')')
			END) AS KEGIATAN,
			U.ID_KATEGORI,
			K.KATEGORI,
			I.URL_DOKUMEN,
			(CASE WHEN P.ID_STATUS_PAK>3
				THEN (I.NILAI_1+I.NILAI_2)*0.5
				ELSE I.NILAI_AWAL
			END ) AS NILAI,
			U.BUKTI
		FROM PAK P, ITEM_PENILAIAN I, UNSUR_PENILAIAN U, KATEGORI_PENILAIAN K
		WHERE I.ID_PAK=?
			AND P.ID_PAK=I.ID_PAK
			AND I.ID_UNSUR=U.ID_UNSUR
			AND U.ID_KATEGORI=K.ID_KATEGORI
		ORDER BY U.ID_KATEGORI ASC, I.ID_UNSUR ASC, I.ID_ITEM ASC";
		$data = array($idPAK);
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriItemDetailPAK();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function getItemPenilaian($idItem){
	}
	function tambahItemPenilaian($item){
		if($item->tahun == null){
			$sql = "INSERT INTO ITEM_PENILAIAN(ID_PAK, ID_UNSUR, NILAI_AWAL, URL_DOKUMEN) VALUES(?, ?, ? ,?)";
			$query = $this->db->query($sql, array($item->idPAK, $item->idUnsur, $item->nilai, $item->urlDokumen));
		}else if ($item->semester == null){
			$sql = "INSERT INTO ITEM_PENILAIAN(ID_PAK, ID_UNSUR, NILAI_AWAL, URL_DOKUMEN, TAHUN) VALUES(?, ?, ? ,? ,?)";
			$query = $this->db->query($sql, array($item->idPAK, $item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun));
		}else{
			$sql = "INSERT INTO ITEM_PENILAIAN(ID_PAK, ID_UNSUR, NILAI_AWAL, URL_DOKUMEN, TAHUN, SEMESTER) VALUES(?, ?, ? ,? ,?, ?)";
			$query = $this->db->query($sql, array($item->idPAK, $item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun, $item->semester));
		}
		$result = $this->db->affected_rows() > 0;
		if(!$query && !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal menambahkan item: " . $this->db->error()["message"]
			);
		}
		$item->idItem = $this->db->insert_id();
		return array(
			"result"=>"OK"
		);
	}
	function simpanItemPenilaian($item){
		if($item->tahun == null){
			$sql = "UPDATE ITEM_PENILAIAN SET ID_UNSUR=?, NILAI_AWAL=?, URL_DOKUMEN=? WHERE ID_ITEM=?";
			$query = $this->db->query($sql, array($item->idUnsur, $item->nilai, $item->urlDokumen, $item->idItem));
		}else if ($item->semester == null){
			$sql = "UPDATE ITEM_PENILAIAN SET ID_UNSUR=?, NILAI_AWAL=?, URL_DOKUMEN=?, TAHUN=? WHERE ID_ITEM=?";
			$query = $this->db->query($sql, array($item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun, $item->idItem));
		}else{
			$sql = "UPDATE ITEM_PENILAIAN SET ID_UNSUR=?, NILAI_AWAL=?, URL_DOKUMEN=?, TAHUN=?, SEMESTER=? WHERE ID_ITEM=?";
			$query = $this->db->query($sql, array($item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun, $item->semester, $item->idItem));
		}
		$result = $this->db->affected_rows() > 0;
		if(!$query && !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal menyimpan item: " . $this->db->error()["message"]
			);
		}
		return array(
			"result"=>"OK"
		);
	}
	function hapusItemPenilaian($idItem){
		$sql = "DELETE FROM ITEM_PENILAIAN WHERE ID_ITEM=?";
		$query = $this->db->query($sql, array($idItem));
		$result = $this->db->affected_rows() > 0;
		if(!$query && !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal menghapus item: " . $this->db->error()["message"]
			);
		}
		return array(
			"result"=>"OK"
		);
	}
	
	function simpanPenilaian($idItem, $nilai, $nomorPenilai){
		if($nilai == NULL) {
			$sql = "UPDATE ITEM_PENILAIAN SET NILAI_{$nomorPenilai}=NULL WHERE ID_ITEM=?";
			$query = $this->db->query($sql, array($idItem));
		}else{
			$sql = "UPDATE ITEM_PENILAIAN SET NILAI_{$nomorPenilai}=? WHERE ID_ITEM=?";
			$query = $this->db->query($sql, array($nilai, $idItem));
		}
		$result = $this->db->affected_rows() > 0;
		if(!$query && !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal menyimpan nilai: " . $this->db->error()["message"]
			);
		}
		return array(
			"result"=>"OK"
		);
	}
	
	function fetchItemPenilaianAkhir($idPAK){
		$sql = "
		SELECT 
			I.ID_ITEM, 
			U.ID_KATEGORI,
			I.URL_DOKUMEN,
			I.NILAI_AWAL,
			I.NILAI_1,
			I.NILAI_2
		FROM ITEM_PENILAIAN I, UNSUR_PENILAIAN U
		WHERE I.ID_PAK=?
			AND I.ID_UNSUR=U.ID_UNSUR
		ORDER BY I.ID_UNSUR ASC";
		$data = array($idPAK);
		$query = $this->db->query($sql, $data);
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriItemNilaiAkhirPAK();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	
}
?>