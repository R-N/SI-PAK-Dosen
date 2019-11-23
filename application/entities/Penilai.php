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
		
		if(isset($queryResult->idSubrumpun)) $this->idSubrumpun = $queryResult->idSubrumpun;
		if(isset($queryResult->subrumpun)) $this->subrumpun = $queryResult->subrumpun;
		if(isset($queryResult->idJabatan)) $this->idJabatan = $queryResult->idJabatan;
		if(isset($queryResult->jabatan)) $this->jabatan = $queryResult->jabatan;
		
		return $this;
	}
}

?>