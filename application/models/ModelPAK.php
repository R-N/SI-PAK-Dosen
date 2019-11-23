<?php 

require_once(ENTITIES_DIR  . "PAK.php");
require_once(ENTITIES_DIR  . "EntriPAKDosen.php");
require_once(ENTITIES_DIR  . "EntriPAKPenilai.php");
require_once(ENTITIES_DIR  . "EntriPAKAdmin.php");
require_once(ENTITIES_DIR  . "EntriPAKBaru.php");

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelPAK extends CI_Model {
	function tentukanPenilai($idPAK, $nomor, $idPenilai){
	}
	function fetchPAKBaru($search="", $page=1, $limit=20){
		$search = escape($search);
		$offset = $limit * ($page-1);
		$searchSelect = "";
		$data = array();
		if($search != ""){
			$searchSelect = 
				", (
					CASE WHEN D.`NAMA` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN SR.`SUBRUMPUN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN JA.`JABATAN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN P.`TANGGAL_STATUS` LIKE '%{$search}%' THEN 1 ELSE 0 END
				) AS rank";
		}
		$sql = "
			SELECT 
				P.`ID_PAK`,
				D.`NAMA` AS `PEMOHON`,
				P.`TANGGAL_STATUS`,
				SR.`SUBRUMPUN`,
				P.`ID_STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				JA.`JABATAN` AS `JABATAN_AWAL`, 
				P.`ID_PENILAI_1`,
				P.`ID_PENILAI_2`,
				P1.`NAMA` AS `PENILAI_1`,
				P2.`NAMA` AS `PENILAI_2`,
				(
					CASE WHEN P.`ID_PENILAI_1` IS NOT NULL THEN 1 ELSE 0 END
					+ CASE WHEN P.`ID_PENILAI_2` IS NOT NULL THEN 1 ELSE 0 END
				) AS rank2
				{$searchSelect}
			FROM JABATAN JA, `USER` D, SUBRUMPUN SR, PAK P 
				LEFT JOIN `USER` P1 ON P.`ID_PENILAI_1`=P1.`ID_USER`
				LEFT JOIN `USER` P2 ON P.`ID_PENILAI_2`=P2.`ID_USER` 
			WHERE D.`ID_USER`=P.`ID_PEMOHON`
				AND P.`ID_SUBRUMPUN`=SR.`ID_SUBRUMPUN`
				AND P.`ID_STATUS_PAK`=?
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`";
		array_push($data, PAK::PAK_BARU);
		if($search != ""){
			$sql = "
				SELECT *
				FROM ({$sql}) RAW
				WHERE RAW.rank > 0
				ORDER BY RAW.rank DESC, RAW.rank2 DESC, RAW.tanggal_status DESC";
		}else{
			$sql = $sql . " 
			ORDER BY P.`TANGGAL_STATUS` DESC";
		}
		$sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
		$query = $this->db->query($sql, $data);
		if($query->num_rows() == 0) return array();
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriPAKBaru();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function fetchPAKSidang($search="", $page=1, $limit=20){
		$search = escape($search);
		$offset = $limit * ($page-1);
		$searchSelect = "";
		$data = array();
		if($search != ""){
			$searchSelect = 
				", (
					CASE WHEN D.`NAMA` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN SR.`SUBRUMPUN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN JA.`JABATAN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN P.`TANGGAL_STATUS` LIKE '%{$search}%' THEN 1 ELSE 0 END
				) AS rank";
		}
		$sql = "
			SELECT 
				P.`ID_PAK`,
				D.`NAMA` AS `PEMOHON`,
				P.`TANGGAL_STATUS`,
				SR.`SUBRUMPUN`,
				P.`ID_STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				JA.`JABATAN` AS `JABATAN_AWAL`
				{$searchSelect}
			FROM JABATAN JA, `USER` D, SUBRUMPUN SR, PAK P 
			WHERE D.`ID_USER`=P.`ID_PEMOHON`
				AND P.`ID_SUBRUMPUN`=SR.`ID_SUBRUMPUN`
				AND P.`ID_STATUS_PAK`=?
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`";
		array_push($data, PAK::PAK_SIDANG);
		if($search != ""){
			$sql = "
				SELECT *
				FROM ({$sql}) RAW
				WHERE RAW.rank > 0
				ORDER BY RAW.rank DESC, RAW.tanggal_status DESC";
		}else{
			$sql = $sql . " 
			ORDER BY P.`TANGGAL_STATUS` DESC";
		}
		$sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
		$query = $this->db->query($sql, $data);
		if($query->num_rows() == 0) return array();
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriPAKAdmin();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function fetchPAKDosen($idDosen, $search="", $page=1, $limit=20){
		$search = escape($search);
		$offset = $limit * ($page-1);
		$searchSelect = "";
		$data = array();
		if($search != ""){
			$searchSelect = 
				", (
					CASE WHEN JA.`JABATAN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN JT.`JABATAN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN P.`TANGGAL_STATUS` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN SP.`STATUS_PAK` LIKE '%{$search}%' THEN 1 ELSE 0 END
				) AS rank";
		}
		$sql = "
			SELECT 
				P.`ID_PAK`,
				P.`TANGGAL_DIAJUKAN`,
				P.`TANGGAL_STATUS`,
				P.`ID_STATUS_PAK`,
				SP.`STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				P.`ID_JABATAN_TUJUAN`,
				JA.`JABATAN` AS `JABATAN_AWAL`,
				JT.`JABATAN` AS `JABATAN_TUJUAN`
				{$searchSelect}
			FROM JABATAN JA, JABATAN JT, STATUS_PAK SP, PAK P 
			WHERE P.`ID_PEMOHON`=?
				AND P.`ID_STATUS_PAK`=SP.`ID_STATUS_PAK`
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
				AND P.`ID_JABATAN_TUJUAN`=JT.`ID_JABATAN`";
		array_push($data, $idDosen);
		if($search != ""){
			$sql = "
				SELECT *
				FROM ({$sql}) RAW
				WHERE RAW.rank > 0
				ORDER BY RAW.rank DESC, RAW.tanggal_status DESC";
		}else{
			$sql = $sql . " 
			ORDER BY P.`TANGGAL_STATUS` DESC";
		}
		$sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
		$query = $this->db->query($sql, $data);
		if($query->num_rows() == 0) return array();
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriPAKDosen();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function fetchPAKPenilai($idPenilai, $search="", $page=1, $limit=20){
		$search = escape($search);
		$offset = $limit * ($page-1);
		$searchSelect = "";
		$data = array();
		if($search != ""){
			$searchSelect = 
				", (
					CASE WHEN D.`NAMA` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN SR.`SUBRUMPUN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN JA.`JABATAN` LIKE '%{$search}%' THEN 1 ELSE 0 END
					+ CASE WHEN P.`TANGGAL_STATUS` LIKE '%{$search}%' THEN 1 ELSE 0 END
				) AS rank";
		}
		$sql = "
			SELECT 
				P.`ID_PAK`,
				D.`NAMA` AS `PEMOHON`,
				P.`TANGGAL_STATUS`,
				SR.`SUBRUMPUN`,
				P.`ID_STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				JA.`JABATAN` AS `JABATAN_AWAL`
				{$searchSelect}
			FROM JABATAN JA, `USER` D, SUBRUMPUN SR, PAK P 
			WHERE (P.`ID_PENILAI_1`=? OR P.`ID_PENILAI_2`=?)
				AND D.`ID_USER`=P.`ID_PEMOHON`
				AND P.`ID_SUBRUMPUN`=SR.`ID_SUBRUMPUN`
				AND P.`ID_STATUS_PAK`=?
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`";
		array_push($data, $idPenilai, $idPenilai, PAK::PAK_NILAI);
		if($search != ""){
			$sql = "
				SELECT *
				FROM ({$sql}) RAW
				WHERE RAW.rank > 0
				ORDER BY RAW.rank DESC, RAW.tanggal_status DESC";
		}else{
			$sql = $sql . " 
			ORDER BY P.`TANGGAL_STATUS` DESC";
		}
		$sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
		$query = $this->db->query($sql, $data);
		if($query->num_rows() == 0) return array();
		$results = $query->result();
		$len = count($results);
		$ret = array();
		for($i = 0; $i < $len; ++$i){
			$entry = new EntriPAKPenilai();
			$entry->read($results[$i]);
			$entry->no = $i+1;
			array_push($ret, $entry);
		}
		return $ret;
	}
	function submitPenilaiPAK($idPAK){
		
	}
	function getPenilai($idPAK){//?
	}
	function inputHasilSidangPAK($idPAK, $setuju, $urlSK){
	}
	function submitPAK($idPAK){
	}
	function submitPenilaianPAK($idPAK, $nomor){
	}
	function getPAKAdmin($idPAK){
		$sql = 
			"SELECT 
				P.`ID_PAK`,
				P.`ID_PEMOHON`,
				D.`NAMA` AS `PEMOHON`,
				P.`ID_SUBRUMPUN`,
				SR.`SUBRUMPUN`,
				P.`ID_PENILAI_1`,
				P.`ID_PENILAI_2`,
				P1.`NAMA` AS `PENILAI_1`,
				P2.`NAMA` AS `PENILAI_2`,
				P.`TANGGAL_DIAJUKAN`,
				P.`TANGGAL_STATUS`,
				P.`ID_STATUS_PAK`,
				SP.`STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				P.`ID_JABATAN_TUJUAN`,
				JA.`JABATAN` AS `JABATAN_AWAL`,
				JT.`JABATAN` AS `JABATAN_TUJUAN`,
				P.`URL_SK`
			FROM JABATAN JA, JABATAN JT, `USER` D, SUBRUMPUN SR, STATUS_PAK SP, PAK P 
				LEFT JOIN `USER` P1 ON P.`ID_PENILAI_1`=P1.`ID_USER`
				LEFT JOIN `USER` P2 ON P.`ID_PENILAI_2`=P2.`ID_USER` 
			WHERE id_pak=?
				AND P.`ID_STATUS_PAK`=SP.`ID_STATUS_PAK`
				AND P.`ID_PEMOHON`=D.`ID_USER`
				AND P.`ID_SUBRUMPUN`=SR.`ID_SUBRUMPUN`
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
				AND P.`ID_JABATAN_TUJUAN`=JT.`ID_JABATAN`;";
		$query = $this->db->query($sql, array($idPAK));
		if($query->num_rows() == 0) return null;
		$result = $query->row();
		if(!isset($result) || $result == null) return null;
		$pak = new PAK();
		$pak->read($result);
		return $pak;
	}
	function getPAK($idPAK){
		$sql = 
			"SELECT 
				P.`ID_PAK`,
				P.`ID_PEMOHON`,
				D.`NAMA` AS `PEMOHON`,
				P.`TANGGAL_DIAJUKAN`,
				P.`TANGGAL_STATUS`,
				P.`ID_STATUS_PAK`,
				SP.`STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				P.`ID_JABATAN_TUJUAN`,
				JA.`JABATAN` AS `JABATAN_AWAL`,
				JT.`JABATAN` AS `JABATAN_TUJUAN`,
				P.`URL_SK`
			FROM JABATAN JA, JABATAN JT, `USER` D, STATUS_PAK SP, PAK P 
			WHERE id_pak=?
				AND P.`ID_STATUS_PAK`=SP.`ID_STATUS_PAK`
				AND P.`ID_PEMOHON`=D.`ID_USER`
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
				AND P.`ID_JABATAN_TUJUAN`=JT.`ID_JABATAN`;";
		$query = $this->db->query($sql, array($idPAK));
		if($query->num_rows() == 0) return null;
		$result = $query->row();
		if(!isset($result) || $result == null) return null;
		$pak = new PAK();
		$pak->read($result);
		return $pak;
	}
	function simpanPAK($pak, $itemPenilaian){
	}
	function simpanPenilaian($penilaian){
	}
	
}