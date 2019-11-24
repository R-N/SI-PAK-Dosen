<?php


class BatasKategori{
	public $idJabatan;
	public $idKategori;
	public $kategori;
	public $maksimal;
	public $minimal;
    public function __construct() {
		
    }
	public function read($queryResult){
		if(isset($queryResult->ID_JABATAN)) $this->idJabatan = $queryResult->ID_JABATAN;
		if(isset($queryResult->ID_KATEGORI)) $this->idKategori = $queryResult->ID_KATEGORI;
		if(isset($queryResult->KATEGORI)) $this->kategori = $queryResult->KATEGORI;
		if(isset($queryResult->MAKSIMAL)) $this->maksimal = $queryResult->MAKSIMAL;
		if(isset($queryResult->MINIMAL)) $this->minimal = $queryResult->MINIMAL;
	}
}
?>