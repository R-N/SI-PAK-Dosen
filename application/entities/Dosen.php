<?php

require_once(ENTITIES_DIR  . "Penilai.php");

class Dosen extends Penilai{
	public $kreditKumulatif;
	public $kreditDibutuhkan;
	
    public function __construct() {
		
    }
	public function read($queryResult){
		parent::read($queryResult);
		if(isset($queryResult->ANGKA_KREDIT)) $this->kreditKumulatif = $queryResult->ANGKA_KREDIT;
		if(isset($queryResult->KREDIT_DIBUTUHKAN)) $this->kreditDibutuhkan = $queryResult->KREDIT_DIBUTUHKAN;
		return $this;
	}
}
?>