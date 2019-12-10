<?php


class EntriPAKAdmin{
	public $idPAK;
	public $idPemohon;
	public $namaPemohon;
	public $tanggalStatus;
	public $idSubrumpun;
	public $subrumpun;
	public $idJabatanAwal;
	public $jabatanAwal;
	public $status;
	public $idStatus;
	public $no;
	
    public function __construct() {
		
    }
	public function setStatus($idStatus){
		$this->idStatus = $idStatus;
		$this->status = PAK::statusToString($idStatus);
	}
	
	public function read($queryResult){
		if(isset($queryResult->ID_PAK)) $this->idPAK = $queryResult->ID_PAK;
		if(isset($queryResult->ID_PEMOHON)) $this->idPemohon = $queryResult->ID_PEMOHON;
		if(isset($queryResult->PEMOHON)) $this->namaPemohon = $queryResult->PEMOHON;
		if(isset($queryResult->ID_SUBRUMPUN)) $this->idSubrumpun = $queryResult->ID_SUBRUMPUN;
		if(isset($queryResult->SUBRUMPUN)) $this->subrumpun = $queryResult->SUBRUMPUN;
		if(isset($queryResult->TANGGAL_STATUS)) $this->tanggalStatus = $queryResult->TANGGAL_STATUS;
		if(isset($queryResult->ID_STATUS_PAK)) $this->setStatus($queryResult->ID_STATUS_PAK);
		if(isset($queryResult->ID_JABATAN_AWAL)) $this->idJabatanAwal = $queryResult->ID_JABATAN_AWAL;
		if(isset($queryResult->JABATAN_AWAL)) $this->jabatanAwal = $queryResult->JABATAN_AWAL;
		return $this;
	}
}

?>