<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ENTITIES_DIR  . "User.php");
require_once(ENTITIES_DIR  . "Penilai.php");
require_once(ENTITIES_DIR  . "Dosen.php");
require_once(ENTITIES_DIR  . "Jabatan.php");
class ModelAkun extends CI_Model {
	public $jabatanDict;
	public $subrumpunDict;

    public function __construct() {
        parent::__construct();
		$this->jabatanDict = $this->getJabatanDict();
		$this->subrumpunDict = $this->getSubrumpunDict();
    }
	function login($username, $password){
 
		//TODO password is plain
		$sql = "SELECT u.id_user, u.id_pegawai, role, nama, status_user, keterangan FROM user u, login_info li WHERE username=? AND password=? AND li.id_user=u.id_user";
		$query = $this->db->query($sql, array($username, $password));
		$result = $query->row();
		if (isset($result) && $result)
		{
			$result->result = 'OK';
		}else{
			$result = new stdClass();
			$result->result = 'FAIL';
			$result->errorMessage = 'Username atau password salah';
		}
		return $result;
	}
	
	function getIdPegawai($idUser){
		$sql = "SELECT u.id_pegawai FROM user u WHERE u.id_user=?";
		$query = $this->db->query($sql, array($idUser));
		$result = $query->row();
		if (isset($result) && $result)
		{
			return $result->id_pegawai;
		}else{
			return null;
		}
	}
	function getIdUserPegawai($idPegawai){
		$sql = "SELECT u.id_user FROM user u WHERE u.id_pegawai=?";
		$query = $this->db->query($sql, array($idPegawai));
		$result = $query->row_array();
		if (isset($result))
		{
			return $result['id_user'];
		}else{
			return null;
		}
	}
	function fetchIdUserPegawaiDict(){
		$sql = "SELECT id_pegawai, id_user FROM user WHERE id_pegawai IS NOT NULL AND id_pegawai > 0";
		$query = $this->db->query($sql);
		$results = $query->result_array();
		$dict = array();
		foreach($results as $result){
			$dict[$result["id_pegawai"]] = $result["id_user"];
		}
		return $dict;
	}
	
	function getUserPegawai($idPegawai){
		$sql = "SELECT id_user, id_pegawai, role, nama, status_user, keterangan FROM `user` U WHERE id_pegawai=?";
		$query = $this->db->query($sql, array($idPegawai));
		$result = $query->row();
		if (isset($result))
		{
			$result->result = 'OK';
		}else{
			$result = new stdClass();
			$result->result = 'FAIL';
			$result->errorMessage = 'User tidak ditemmukan';
		}
		return $result;
	}
	
	function insertUserPegawai($pegawai){
		$sql = "INSERT INTO USER(ID_PEGAWAI, ROLE, NAMA, STATUS_USER) VALUES(?, ?, ?, 1)";
		$role = $pegawai->role;//TODO
		$angkaKredit = null;
		if($role == 3){
			$angkaKredit = 150;
		}
		$query = $this->db->query($sql, array($pegawai->id_pegawai, $role, $pegawai->nama));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			$result = new stdClass();
			$result->result = 'FAIL';
			$result->errorMessage = "Gagal menambahkan user: " . $this->db->error()["message"];
		}
		$pegawai->id_user = $this->db->insert_id();
		return $pegawai;
	}
	
	function getPilihanSubrumpun(){
		$sql = "SELECT id_subrumpun, subrumpun FROM subrumpun;";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	function getSubrumpunDict(){
		$subrumpuns = $this->getPilihanSubrumpun();
		$subrumpunDict = array();
		foreach($subrumpuns as $subrumpun){
			$subrumpunDict[$subrumpun->id_subrumpun] = $subrumpun->subrumpun;
		}
		return $subrumpunDict;
	}
	
	function getPilihanJabatan(){
		$sql = "SELECT id_jabatan, jabatan FROM jabatan;";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	
	function getJabatanDict(){
		$jabatans = $this->getPilihanJabatan();
		$jabatanDict = array();
		foreach($jabatans as $jabatan){
			$jabatanDict[$jabatan->id_jabatan] = $jabatan->jabatan;
		}
		return $jabatanDict;
	}
		
	public function daftarkanPenilaiLuar($penilaiLuar){
		$this->db->trans_begin();
		$sql = "INSERT INTO user(role, status_user, nama) VALUES(?,?,?);";
		$query = $this->db->query($sql, array(1, 1, $penilaiLuar["nama"]));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			$this->db->trans_rollback();
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal menambahkan user: " . $this->db->error()["message"]
			);
		}
		$id = $this->db->insert_id();
		$sql = "INSERT INTO login_info(id_user, username, password) VALUES(?,?,?);";
		$query = $this->db->query($sql, array($id, $penilaiLuar["nip"], $penilaiLuar["password"]));
		$result = $this->db->affected_rows() > 0;
		if(!$query || !$result){
			$this->db->trans_rollback();
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal menambahkan login info: " . $this->db->error()["message"]
			);
		}
		$sql = "INSERT INTO penilai_luar(id_user, id_jabatan, id_subrumpun, nip, email, telepon, asal_instansi) VALUES (?,?,?,?,?,?,?)";
		$query = $this->db->query($sql, array(
			$id,
			$penilaiLuar["idJabatan"],
			$penilaiLuar["idSubrumpun"],
			$penilaiLuar["nip"],
			$penilaiLuar["email"],
			$penilaiLuar["telepon"],
			$penilaiLuar["asalInstansi"]
		));
		$result = $result && $this->db->affected_rows() > 0;
		if(!$query || !$result){
			$this->db->trans_rollback();
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Gagal menambahkan penilai luar: " . $this->db->error()["message"]
			);
		}else{
			$this->db->trans_complete();
			return array("result"=>"OK");
		}
	}
	
	public function getUser($idUser){
		$sql = "SELECT * FROM `user` WHERE ID_USER=?";
		$query = $this->db->query($sql, array($idUser));
		$result = $query->row();
		$user = new User();
		$user->read($result);
		return $user;
	}
	
	public function getPenilaiLuar($idUser, $user){
		$sql = "SELECT * FROM `penilai_luar` WHERE ID_USER=?";
		$query = $this->db->query($sql, array($idUser));
		$result = $query->row();
		$penilai = new Penilai();
		if($user) $penilai->read($user);
		$penilai->read($result);
		return $penilai;
	}
	public function getPenilai($idUser){
		$user = $this->getUser($idUser);
		if($user->idPegawai){
			$penilai = null; //TODO
		}else{
			$penilai = $getPenilaiLuar($idUser, $user);
		}
		return $penilai;
	}
	public function getDosen($idUser){
		$this->load->model("KonektorSimpeg");
		$user = $this->getUser($idUser);
		$dosen = new Dosen();
		$dosen->read($user);
		$doseni = $this->KonektorSimpeg->getDosen($dosen->idPegawai);
		$dosen->read($doseni);
		$dosen->subrumpun = $this->subrumpunDict[$dosen->idSubrumpun];
		$dosen->jabatan = $this->jabatanDict[$dosen->idJabatan];
		//TODO
		return $dosen;
	}
	
	public function getJabatan($idJabatan){
		$sql = "SELECT * FROM `jabatan` WHERE ID_JABATAN=?";
		$query = $this->db->query($sql, array($idJabatan));
		$result = $query->row();
		$jabatan = new Jabatan();
		$jabatan->read($result);
		return $jabatan;
	}
	
}