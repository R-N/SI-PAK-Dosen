<?php 

require_once(ENTITIES_DIR  . "PAK.php");
require_once(ENTITIES_DIR  . "EntriPAKDosen.php");
require_once(ENTITIES_DIR  . "EntriPAKPenilai.php");
require_once(ENTITIES_DIR  . "EntriPAKAdmin.php");
require_once(ENTITIES_DIR  . "EntriPAKBaru.php");

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelPAK extends CI_Model {
	function tentukanPenilai($idPAK, $nomor, $idPenilai){
		$nomor = escape($nomor);
		$nomor = $nomor == 1 ? 1 : 2;
		$nomorSatunya = $nomor == 1 ? 2 : 1;
		$sql = "UPDATE PAK SET ID_PENILAI_{$nomor}=? WHERE ID_PAK=? AND ID_PEMOHON<>? AND (ID_PENILAI_{$nomorSatunya} IS NULL OR ID_PENILAI_{$nomorSatunya}<>?)";
		$query = $this->db->query($sql, array($idPenilai, $idPAK, $idPenilai, $idPenilai));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal memilih penilai: " . $this->db->error()["message"]
			);
		}
		$id = $this->db->insert_id();
		return array(
			"result"=>"OK",
			"idPAK"=>$idPAK,
			"idPenilai"=>$idPenilai,
			"idUser"=>$idPenilai,
			"nomor"=>$nomor
		);
	}
	function fetchPAKBaru(){
		$data = array();
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
			FROM JABATAN JA, `USER` D, SUBRUMPUN SR, PAK P 
				LEFT JOIN `USER` P1 ON P.`ID_PENILAI_1`=P1.`ID_USER`
				LEFT JOIN `USER` P2 ON P.`ID_PENILAI_2`=P2.`ID_USER` 
			WHERE D.`ID_USER`=P.`ID_PEMOHON`
				AND P.`ID_SUBRUMPUN`=SR.`ID_SUBRUMPUN`
				AND P.`ID_STATUS_PAK`=?
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
			ORDER BY P.`TANGGAL_STATUS` ASC";
		array_push($data, PAK::PAK_BARU);
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
	function fetchPAKSidang(){
		$data = array();
		$sql = "
			SELECT 
				P.`ID_PAK`,
				D.`NAMA` AS `PEMOHON`,
				P.`TANGGAL_STATUS`,
				SR.`SUBRUMPUN`,
				P.`ID_STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				JA.`JABATAN` AS `JABATAN_AWAL`
			FROM JABATAN JA, `USER` D, SUBRUMPUN SR, PAK P 
			WHERE D.`ID_USER`=P.`ID_PEMOHON`
				AND P.`ID_SUBRUMPUN`=SR.`ID_SUBRUMPUN`
				AND P.`ID_STATUS_PAK`=?
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
			ORDER BY P.`TANGGAL_STATUS` ASC";
		array_push($data, PAK::PAK_SIDANG);
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
	function fetchPAKDosen($idDosen){
		$data = array();
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
			FROM JABATAN JA, JABATAN JT, STATUS_PAK SP, PAK P 
			WHERE P.`ID_PEMOHON`=?
				AND P.`ID_STATUS_PAK`=SP.`ID_STATUS_PAK`
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
				AND P.`ID_JABATAN_TUJUAN`=JT.`ID_JABATAN`
			ORDER BY P.tanggal_status DESC";
		array_push($data, $idDosen);
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
	function fetchPAKPenilai($idPenilai){
		$data = array();
		$sql = "
			SELECT 
				P.`ID_PAK`,
				D.`NAMA` AS `PEMOHON`,
				P.`TANGGAL_STATUS`,
				SR.`SUBRUMPUN`,
				P.`ID_STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				JA.`JABATAN` AS `JABATAN_AWAL`
			FROM JABATAN JA, `USER` D, SUBRUMPUN SR, PAK P 
			WHERE (P.`ID_PENILAI_1`=? OR P.`ID_PENILAI_2`=?)
				AND D.`ID_USER`=P.`ID_PEMOHON`
				AND P.`ID_SUBRUMPUN`=SR.`ID_SUBRUMPUN`
				AND P.`ID_STATUS_PAK`=?
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
				AND (P.`ID_PENILAI_SUBMIT` IS NULL OR NOT(P.`ID_PENILAI_SUBMIT` = ?)) 
			ORDER BY P.`TANGGAL_STATUS` ASC";
		array_push($data, $idPenilai, $idPenilai, PAK::PAK_NILAI, $idPenilai);
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
	
	/*
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
				AND P.`ID_JABATAN_AWAL`=JA.`ID_JABATAN`
				AND (P.`ID_PENILAI_SUBMIT` IS NULL OR NOT(P.`ID_PENILAI_SUBMIT` = ?))";
		array_push($data, $idPenilai, $idPenilai, PAK::PAK_NILAI, $idPenilai);
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
	*/
	function submitPenilaiPAK($idPAK){
		$sql = "UPDATE PAK SET ID_STATUS_PAK=3, TANGGAL_STATUS=NOW() WHERE ID_PAK=? AND ID_STATUS_PAK=2";
		$query = $this->db->query($sql, array($idPAK));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"PAK tidak ditemukan atau tidak bisa disubmit"
			);
		}
		$id = $this->db->insert_id();
		return array(
			"result"=>"OK"
		);
	}
	function submitPenilaianPAK($idPAK, $idStatus, $nilaiAkhir){
		$sql = "UPDATE PAK SET ID_STATUS_PAK=?, NILAI_AKHIR=?, TANGGAL_STATUS=NOW() WHERE ID_PAK=? AND ID_STATUS_PAK=? AND ID_PENILAI_SUBMIT > 0";
		$query = $this->db->query($sql, array($idStatus, $nilaiAkhir, $idPAK, PAK::PAK_NILAI));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"PAK tidak ditemukan atau tidak bisa disubmit"
			);
		}
		$id = $this->db->insert_id();
		return array(
			"result"=>"OK"
		);
	}
	function submitPenilaian1PAK($idPAK, $idPenilai){
		$sql = "UPDATE PAK SET ID_PENILAI_SUBMIT=? WHERE ID_PAK=? AND ID_STATUS_PAK=? AND (ID_PENILAI_SUBMIT IS NULL OR ID_PENILAI_SUBMIT = 0)";
		$query = $this->db->query($sql, array($idPenilai, $idPAK, PAK::PAK_NILAI));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"PAK tidak ditemukan atau tidak bisa disubmit"
			);
		}
		$id = $this->db->insert_id();
		return array(
			"result"=>"OK"
		);
	}
	
	function getPAK($idPAK){
		$sql = 
			"SELECT 
				P.`ID_PAK`,
				P.`ID_PEMOHON`,
				D.`NAMA` AS `PEMOHON`,
				P.`ID_SUBRUMPUN`,
				SR.`SUBRUMPUN`,
				P.`NILAI_AWAL`,
				P.`NILAI_AKHIR`,
				P.`KREDIT_AWAL`,
				P.`KREDIT_AKHIR`,
				P.`ID_PENILAI_1`,
				P.`ID_PENILAI_2`,
				P1.`NAMA` AS `PENILAI_1`,
				P2.`NAMA` AS `PENILAI_2`,
				P.`ID_PENILAI_SUBMIT`,
				P.`TANGGAL_DIAJUKAN`,
				P.`TANGGAL_STATUS`,
				P.`ID_STATUS_PAK`,
				SP.`STATUS_PAK`,
				P.`ID_JABATAN_AWAL`,
				P.`ID_JABATAN_TUJUAN`,
				JA.`JABATAN` AS `JABATAN_AWAL`,
				JT.`JABATAN` AS `JABATAN_TUJUAN`,
				JT.`KREDIT` AS `KREDIT_MINIMAL`,
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
	/*
	function getPAK($idPAK){
		$sql = 
			"SELECT 
				P.`ID_PAK`,
				P.`ID_PEMOHON`,
				D.`NAMA` AS `PEMOHON`,
				P.`TANGGAL_DIAJUKAN`,
				P.`TANGGAL_STATUS`,
				P.`ID_STATUS_PAK`,
				P.`NILAI_AWAL`,
				P.`NILAI_AKHIR`,
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
	*/
	function getPAKAktif($idDosen){
		$sql = "SELECT ID_PAK, ID_STATUS_PAK FROM PAK WHERE ID_PEMOHON=? AND ID_STATUS_PAK<=?";
		$data = array($idDosen, PAK::PAK_SIDANG);
		
		$query = $this->db->query($sql, $data);
		if($query->num_rows() == 0) return null;
		return $query->row();
	}
	
	function getKreditTerakhir($idDosen){
		$sql = "SELECT KREDIT_AKHIR FROM PAK WHERE ID_PEMOHON=? AND ID_STATUS_PAK=? ORDER BY TANGGAL_STATUS DESC LIMIT 1";
		$data = array($idDosen, PAK::PAK_SELESAI);
		
		$query = $this->db->query($sql, $data);
		if($query->num_rows() == 0) return null;
		return $query->row()->KREDIT_AKHIR;
	}
	
	function tambahPAK($pak){
		$sql = "INSERT INTO PAK(ID_PEMOHON, ID_SUBRUMPUN, ID_JABATAN_AWAL, ID_JABATAN_TUJUAN, ID_STATUS_PAK, TANGGAL_STATUS, KREDIT_AWAL) VALUES(?, ?, ?, ?, ?, NOW(), ?);";
		$query = $this->db->query($sql, array($pak->idDosen, $pak->idSubrumpun, $pak->idJabatanAwal, $pak->idJabatanTujuan, PAK::PAK_EDIT, $pak->kreditAwal));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal membuat PAK: " . $this->db->error()["message"]
			);
		}
		$id = $this->db->insert_id();
		return array(
			"result"=>"OK",
			"idPAK"=>$id
		);
	}
	
	function submitPAK($idPAK, $nilai){
		
		$sql = "UPDATE PAK SET ID_STATUS_PAK=2, NILAI_AWAL=?, TANGGAL_DIAJUKAN=NOW(), TANGGAL_STATUS=NOW() WHERE ID_PAK=?";
		$query = $this->db->query($sql, array($nilai, $idPAK));
		$result = $this->db->affected_rows() > 0;
		if(!$query && !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal submit PAK: " . $this->db->error()["message"]
			);
		}
		return array(
			"result"=>"OK"
		);
	}
	function inputHasilSidangPAK($idPAK, $setuju, $urlSK){
		if($setuju){
			$statusPAK = PAK::PAK_SELESAI;
		}else{
			$statusPAK = PAK::PAK_TOLAK_SIDANG;
		}
		
		$sql = "
			UPDATE PAK SET 
				ID_STATUS_PAK=?, 
				URL_SK=?,
				KREDIT_AKHIR = (
					CASE WHEN ID_STATUS_PAK=? THEN KREDIT_AWAL+NILAI_AKHIR ELSE KREDIT_AWAL END
				)
			WHERE ID_PAK=? 
				AND ID_STATUS_PAK=?";
		$query = $this->db->query($sql, array($statusPAK, $urlSK, PAK::PAK_SELESAI, $idPAK, PAK::PAK_SIDANG));
		$result = $this->db->affected_rows() > 0;
		if(!$query && !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"PAK tidak ditemukan"
			);
		}
		return array(
			"result"=>"OK"
		);
	}
	
	function simpanPAK($pak){
		$sql = "UPDATE PAK SET KREDIT_AWAL=? WHERE ID_PAK=? AND ID_STATUS_PAK=?";
		$query = $this->db->query($sql, array($pak->kreditAwal, $pak->id, PAK::PAK_EDIT));
		$result = $this->db->affected_rows() > 0;
		if(!$query && !$result){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal simpan PAK: " . $this->db->error()["message"]
			);
		}
		return array(
			"result"=>"OK"
		);
	}
}