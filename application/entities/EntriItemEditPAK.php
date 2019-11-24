<?php

require_once(ENTITIES_DIR  . "EntriItemPAK.php");

class EntriItemEditPAK extends EntriItemPAK{
	public $tahun;
	public $semester;
	public $jumlah;
	public $batas;
	public $unit;
	public $idJenisBatas;
	public $jenisBatas;
	public $kreditPerItem;
	public $keterangan;
	
    public function __construct() {
		
    }
	
	public function read($queryResult){
		parent::read($queryResult);
		if($this->nilai && $this->batas){
			$this->jumlah = $this->nilai/$this->batas;
		}
		if(isset($queryResult->TAHUN)) $this->tahun = $queryResult->TAHUN;
		if(isset($queryResult->SEMESTER)) $this->semester = $queryResult->SEMESTER;
		if(isset($queryResult->UNIT)) $this->unit = $queryResult->UNIT;
		if(isset($queryResult->ID_JENIS_BATAS)) $this->idJenisBatas = $queryResult->ID_JENIS_BATAS;
		if(isset($queryResult->MAX_KREDIT)) $this->kreditPerItem = $queryResult->MAX_KREDIT;
		if(isset($queryResult->KETERANGAN)) $this->keterangan = $queryResult->KETERANGAN;
	}
}
?>