<?php


class EntriPenilaiPAK {
	public $idUser;
	public $role;
	public $idPegawai;
	public $nama;
	public $idSubrumpun;
	public $subrumpun;
	public $idJabatan;
	public $jabatan;
	public $asalInstansi;
	public $no;
	
    public function __construct() {
		
    }
	
	public function read($queryResult){
		if(isset($queryResult->ID_USER)) $this->idUser = $queryResult->ID_USER;
		if(isset($queryResult->ID_PEGAWAI)) $this->idPegawai = $queryResult->ID_PEGAWAI;
		if(isset($queryResult->NAMA)) $this->nama = $queryResult->NAMA;
		if(isset($queryResult->ID_SUBRUMPUN)) $this->idSubrumpun = $queryResult->ID_SUBRUMPUN;
		if(isset($queryResult->SUBRUMPUN)) $this->subrumpun = $queryResult->SUBRUMPUN;
		if(isset($queryResult->ID_JABATAN)) $this->idJabatan = $queryResult->ID_JABATAN;
		if(isset($queryResult->JABATAN)) $this->jabatan = $queryResult->JABATAN;
		if(isset($queryResult->ASAL_INSTANSI)) $this->asalInstansi = $queryResult->ASAL_INSTANSI;
		
		if(is_array($queryResult)){
			if(isset($queryResult["ID_USER"])) $this->idUser = $queryResult["ID_USER"];
			if(isset($queryResult["ID_PEGAWAI"])) $this->idPegawai = $queryResult["ID_PEGAWAI"];
			if(isset($queryResult["NAMA"])) $this->nama = $queryResult["NAMA"];
			if(isset($queryResult["ID_SUBRUMPUN"])) $this->idSubrumpun = $queryResult["ID_SUBRUMPUN"];
			if(isset($queryResult["SUBRUMPUN"])) $this->subrumpun = $queryResult["SUBRUMPUN"];
			if(isset($queryResult["ID_JABATAN"])) $this->idJabatan = $queryResult["ID_JABATAN"];
			if(isset($queryResult["JABATAN"])) $this->jabatan = $queryResult["JABATAN"];
			if(isset($queryResult["ASAL_INSTANSI"])) $this->asalInstansi = $queryResult["ASAL_INSTANSI"];
			
			if(isset($queryResult["id_user"])) $this->idUser = $queryResult["id_user"];
			if(isset($queryResult["id_pegawai"])) $this->idPegawai = $queryResult["id_pegawai"];
			if(isset($queryResult["nama"])) $this->nama = $queryResult["nama"];
			if(isset($queryResult["id_subrumpun"])) $this->idSubrumpun = $queryResult["id_subrumpun"];
			if(isset($queryResult["subrumpun"])) $this->subrumpun = $queryResult["subrumpun"];
			if(isset($queryResult["id_jabatan"])) $this->idJabatan = $queryResult["id_jabatan"];
			if(isset($queryResult["jabatan"])) $this->jabatan = $queryResult["jabatan"];
			if(isset($queryResult["asal_instansi"])) $this->asalInstansi = $queryResult["asal_instansi"];
		}
		
		if(isset($this->idPegawai) && $this->idPegawai){
			$this->asalInstansi = "UINSA";
		}
		return $this;
	}
	
	function setRole($role){
		$this->role = $role;
		return $this;
	}
}
?>