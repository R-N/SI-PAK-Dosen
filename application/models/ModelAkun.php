<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ENTITIES_DIR  . "User.php");
require_once(ENTITIES_DIR  . "Penilai.php");
require_once(ENTITIES_DIR  . "Dosen.php");
require_once(ENTITIES_DIR  . "Jabatan.php");
class ModelAkun extends CI_Model {

	function login($username, $password){
 
		//TODO password is plain
		$sql = "SELECT u.id_user, role, nama, status_user, keterangan FROM user u, login_info li WHERE username=? AND password=? AND li.id_user=u.id_user";
		$query = $this->db->query($sql, array($username, $password));
		$result = $query->row_array();
		if (isset($result))
		{
			$result['result'] = 'OK';
		}else{
			$result = array();
			$result['result'] = 'FAIL';
			$result['errorMessage'] = 'Username atau password salah';
		}
		return $result;
	}
  
	function getPilihanSubrumpun(){
		$sql = "SELECT id_subrumpun, subrumpun FROM subrumpun;";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
	}
	
	function getPilihanJabatan(){
		$sql = "SELECT id_jabatan, jabatan FROM jabatan;";
		$query = $this->db->query($sql);
		$result = $query->result();
		return $result;
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
		$user = $this->getUser($idUser);
		$dosen = new Dosen();
		$dosen->read($user);
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