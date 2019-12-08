<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ENTITIES_DIR  . "EntriPenilaiPAK.php");

class ModelPenilai extends CI_Model {

	function fetchPenilai($search, $page=1, $limit=20){
		//TODO limit prone to injection
		$offset = $limit * ($page-1);
		$sql = "SELECT U.ID_USER, U.NAMA, PL.ID_SUBRUMPUN, SR.SUBRUMPUN, PL.ID_JABATAN, J.JABATAN, U.STATUS_USER, PL.ASAL_INSTANSI FROM `user` U, penilai_luar PL, jabatan J, subrumpun SR WHERE U.ID_USER=PL.ID_USER AND PL.ID_JABATAN=J.ID_JABATAN AND PL.ID_SUBRUMPUN=SR.ID_SUBRUMPUN LIMIT {$limit} OFFSET {$offset}";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$len = count($result);
		for($i = 0; $i < $len; ++$i){
			$result[$i]["no"] = ++$offset;
		}
		return $result;
	}
	
	function fetchPenilaiPAK(){
		$sql = "SELECT U.ID_USER, U.NAMA, PL.ID_SUBRUMPUN, SR.SUBRUMPUN, PL.ID_JABATAN, J.JABATAN, PL.ASAL_INSTANSI FROM `user` U, penilai_luar PL, jabatan J, subrumpun SR WHERE U.ID_USER=PL.ID_USER AND PL.ID_JABATAN=J.ID_JABATAN AND PL.ID_SUBRUMPUN=SR.ID_SUBRUMPUN AND U.STATUS_USER=1";
		$query = $this->db->query($sql);
		$result = $query->result();
		$result2 = array();
		$no = 0;
		foreach($result as $res){
			$penilai = (new EntriPenilaiPAK())->read($res);
			$penilai->role = 1;
			$penilai->no = ++$no;
			array_push($result2, $penilai);
		}
		$this->load->model("KonektorSimpeg");
		$result = $this->KonektorSimpeg->fetchDosen();
		foreach($result as $res){
			$penilai = (new EntriPenilaiPAK())->read($res);
			$penilai->role = 3;
			$penilai->no = ++$no;
			array_push($result2, $penilai);
		}
		return $result2;
	}
	
	function suspend($idPenilai, $keterangan){
		
	}
	function activate($idPenilai){
	}
}