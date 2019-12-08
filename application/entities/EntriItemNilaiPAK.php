<?php


class EntriItemNilaiPAK extends EntriItemDetailPAK{
	public $nilaiAwal;
	public $nilaiPenilai;
	
    public function __construct() {
		
    }
	
	public function read($queryResult){
		parent::read($queryResult);
		if(isset($queryResult->NILAI_AWAL)) $this->nilai = $queryResult->NILAI_AWAL;
		if(isset($queryResult->NILAI_PENILAI)) $this->nilaiPenilai = $queryResult->NILAI_PENILAI;
		$this->nilaiAwal = $this->nilai;
		return $this;
	}
}
?>