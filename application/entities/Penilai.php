<?php

require_once(ENTITIES_DIR  . "User.php");

class Penilai extends User{
	public $idSubrumpun;
	public $subrumpun;
	public $idJabatan = 1;
	public $jabatan;
	
    public function __construct() {
		
    }
	
	
	public function read($queryResult){
		parent::read($queryResult);
		
		if(isset($queryResult->ID_SUBRUMPUN)) $this->idSubrumpun = $queryResult->ID_SUBRUMPUN;
		if(isset($queryResult->SUBRUMPUN)) $this->subrumpun = $queryResult->SUBRUMPUN;
		if(isset($queryResult->ID_JABATAN)) $this->idJabatan = $queryResult->ID_JABATAN;
		if(isset($queryResult->JABATAN)) $this->jabatan = $queryResult->JABATAN;
		
		if(isset($queryResult->id_subrumpun)) $this->idSubrumpun = $queryResult->id_subrumpun;
		if(isset($queryResult->subrumpun)) $this->subrumpun = $queryResult->subrumpun;
		if(isset($queryResult->id_jabatan)) $this->idJabatan = $queryResult->id_jabatan;
		if(isset($queryResult->jabatan)) $this->jabatan = $queryResult->jabatan;
		
		if(isset($queryResult->id_rumpun_sub)) $this->idSubrumpun = $queryResult->id_rumpun_sub;
		if(isset($queryResult->nama_rumpun_sub)) $this->subrumpun = $queryResult->nama_rumpun_sub;
		if(isset($queryResult->id_pangkat)) $this->idJabatan = $queryResult->id_pangkat-9;
		if(isset($queryResult->nama_jabatan)) $this->jabatan = $queryResult->nama_jabatan;
		
		if(is_array($queryResult)){
			if(isset($queryResult["ID_SUBRUMPUN"])) $this->idSubrumpun = $queryResult["ID_SUBRUMPUN"];
			if(isset($queryResult["SUBRUMPUN"])) $this->subrumpun = $queryResult["SUBRUMPUN"];
			if(isset($queryResult["ID_JABATAN"])) $this->idJabatan = $queryResult["ID_JABATAN"];
			if(isset($queryResult["JABATAN"])) $this->jabatan = $queryResult["JABATAN"];
			
			if(isset($queryResult["id_subrumpun"])) $this->idSubrumpun = $queryResult["id_subrumpun"];
			if(isset($queryResult["subrumpun"])) $this->subrumpun = $queryResult["subrumpun"];
			if(isset($queryResult["id_jabatan"])) $this->idJabatan = $queryResult["id_jabatan"];
			if(isset($queryResult["jabatan"])) $this->jabatan = $queryResult["jabatan"];
		}
		
		if(isset($queryResult->idSubrumpun)) $this->idSubrumpun = $queryResult->idSubrumpun;
		if(isset($queryResult->subrumpun)) $this->subrumpun = $queryResult->subrumpun;
		if(isset($queryResult->idJabatan)) $this->idJabatan = $queryResult->idJabatan;
		if(isset($queryResult->jabatan)) $this->jabatan = $queryResult->jabatan;
		
		return $this;
	}
}

?>