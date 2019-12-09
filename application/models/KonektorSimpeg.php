<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KonektorSimpeg extends CI_Model {
	public function login($nip, $password){
		
		$obj = null;
		if ($nip=="admin" && $password == "admin"){
			$obj = $this->dummyAdmin();
		}else if($nip == "dosen" && $password == "dosen"){
			$obj = $this->dummyDosen();
		}else{
			$obj = $this->getPegawai($nip);
			if(!$obj){
				$ret = new stdClass();
				$ret->result = "FAIL";
				$ret->errorMessage = "Username atau password salah";
				return $ret;
			}
		}
		
		$obj->result = "OK";
		$obj->role = jastrukToRole($obj->id_jastruk);
		
		return $obj;
		
	}
	
	public function getPegawai($nip){
		
		if($nip == 1){
			$obj = $this->dummyAdmin();
		}else if ($nip == 2){
			$obj = $this->dummyDosen();
		}else{
			//$raw = file_get_contents('http://lecturer.uinsby.ac.id/home/getDataPAK/'.$nip);
			//$arr = print_r_reverse($raw)[0];
			
			if ($nip == "198702082014032003"){
				$arr = json_decode("
					[
						{
							\"id_tipe\": 2,
							\"id_jastruk\": 947,
							\"nama\": \"Nita Yalina, S.Kom., M.MT\",
							\"id_pangkat\": 11,
							\"nama_golongan\": \"IIIc\",
							\"id_jafung\": 2,
							\"nama_jafung\": \"Lektor\",
							\"email\": \"nitayalina@uinsby.ac.id\",
							\"nama_rumpun\": \"SAINS\",
							\"nama_rumpun_sub\": \"Komputer\",
							\"nama_bidang\": \"Teknik Informatika\"
						}
					]
				");
			}else{
				$arr = array();
			}
		
			if(count($arr) == 0){
				return null;
			}else{
				$obj = $arr[0];
			}
		}
		
		$obj->nip = $nip;
		
		$this->initDosen($obj);
		
		$obj->id_pegawai = $nip;
		return $obj;
	}
	
	public function dummyAdmin(){
		$obj = new stdClass();
		$obj->id_jastruk = 123;
		$obj->id_pegawai = "1";
		$obj->nama = "Admin";
		$obj->asalInstansi = "UINSA";
		$obj->nip = 1;
		return $obj;
	}
	
	public function dummyDosen(){
		$obj = new stdClass();
		$obj->id_pangkat = 10;
		$obj->id_jastruk = 947;
		$obj->id_pegawai = "2";
		$obj->id_rumpun_sub = 110;
		$obj->nama = "Dosen";
		$obj->asalInstansi = "UINSA";
		$obj->nip = 2;
		return $obj;
	}
	
	public function initPegawai($dosen){
		if(!isset($dosen->id_pegawai) || !$dosen->id_pegawai) $dosen->id_pegawai = "198702082014032003";
		if(!isset($dosen->role) || !$dosen->role) $dosen->role = jastrukToRole($dosen->id_jastruk);
		$dosen->asalInstansi = "UINSA";
		return $dosen;
	}
	public function initDosen($dosen){
		$dosen = $this->initPegawai($dosen);
		if($dosen->role != 3) return $dosen;
		if(!isset($dosen->id_rumpun_sub) || !$dosen->id_rumpun_sub) $dosen->id_rumpun_sub = 110;
		$this->load->model("ModelAkun");
		if(isset($dosen->id_rumpun_sub) && $dosen->id_rumpun_sub) $dosen->nama_rumpun_sub = $this->ModelAkun->subrumpunDict[$dosen->id_rumpun_sub];
		if(isset($dosen->id_pangkat) && $dosen->id_pangkat) $dosen->nama_jabatan = $this->ModelAkun->jabatanDict[$dosen->id_pangkat-9];
		return $dosen;
	}
	
	public function fetchDosen(){
		//$raw = file_get_contents('http://lecturer.uinsby.ac.id/home/getDataPAK/0');
		//$dosens = print_r_reverse($raw)[0];
		$dosens = array();
		
		array_push($dosens, $this->dummyDosen());
		
		$this->load->model("ModelAkun");
		$idUserDict = $this->ModelAkun->fetchIdUserPegawaiDict();
		$len = count($dosens);
		
		for($i = 0; $i < $len; ++$i){
			$dosen = $dosens[$i];
			$this->initDosen($dosen);
			$idPegawai = $dosen->id_pegawai;
			if (array_key_exists($idPegawai, $idUserDict)){
				$dosen->id_user = $idUserDict[$idPegawai];
			}else{
				$dosen->id_user = null;
			}
			$dosens[$i] = $dosen;
		}
		return $dosens;
	}
	
	public function getDosen($idPegawai){
		if ($idPegawai == 2){
			return $this->initDosen($this->dummyDosen());
		}else{
			$dosen = $this->getPegawai($idPegawai);
			if(!$dosen){
				$ret = new stdClass();
				$ret->result = "FAIL";
				$ret->errorMessage = "NIP tidak ditemukan";
				return $ret;
			}else if ($dosen->role != 3){
				$ret = new stdClass();
				$ret->result = "FAIL";
				$ret->errorMessage = "NIP bukan milik dosen";
				return $ret;
			}else{
				$this->initDosen($dosen);
				$dosen ->result = "OK";
				return $dosen;
			}
		}
	}
	
}
?>