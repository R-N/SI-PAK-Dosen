<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelPenilai extends CI_Model {

	function fetchPenilai($search, $page=1, $limit=20){
		//TODO limit prone to injection
		$offset = $limit * ($page-1);
		$sql = "SELECT u.nama, sr.subrumpun, j.jabatan, u.status_user, pl.asal_instansi FROM user u, penilai_luar pl, jabatan j, subrumpun sr WHERE u.id_user=pl.id_user AND pl.id_jabatan=j.id_jabatan AND pl.id_subrumpun=sr.id_subrumpun LIMIT {$limit} OFFSET {$offset}";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$len = count($result);
		for($i = 0; $i < $len; ++$i){
			$result[$i]["no"] = ++$offset;
		}
		return $result;
	}
	
	function fetchPenilaiPAK($idSubrumpun, $jabatan){
	}
	
	function suspend($idPenilai, $keterangan){
	}
	function activate($idPenilai){
	}
}