<?php


class EntriPAKDosen{
	public $idPAK;
	public $tanggalDiajukan = null;
	public $tanggalStatus;
	public $idStatus;
	public $status;
	public $idJabatanAwal;
	public $idJabatanTujuan;
	public $jabatanAwal;
	public $jabatanTujuan;
	public $no;
	
    public function __construct() {
		
    }
	public function setStatus($idStatus){
		$this->idStatus = $idStatus;
		$this->status = PAK::statusToString($idStatus);
	}
	
	public function read($queryResult){
		if(isset($queryResult->ID_PAK)) $this->idPAK = $queryResult->ID_PAK;
		if(isset($queryResult->TANGGAL_DIAJUKAN)) $this->tanggalDiajukan = $queryResult->TANGGAL_DIAJUKAN;
		if(isset($queryResult->TANGGAL_STATUS)) $this->tanggalStatus = $queryResult->TANGGAL_STATUS;
		if(isset($queryResult->STATUS_PAK)) $this->status =$queryResult->STATUS_PAK;
		if(isset($queryResult->ID_STATUS_PAK)) $this->setStatus($queryResult->ID_STATUS_PAK);
		if(isset($queryResult->ID_JABATAN_AWAL)) $this->idJabatanAwal = $queryResult->ID_JABATAN_AWAL;
		if(isset($queryResult->ID_JABATAN_TUJUAN)) $this->idJabatanTujuan = $queryResult->ID_JABATAN_TUJUAN;
		if(isset($queryResult->JABATAN_AWAL)) $this->jabatanAwal = $queryResult->JABATAN_AWAL;
		if(isset($queryResult->JABATAN_TUJUAN)) $this->jabatanTujuan = $queryResult->JABATAN_TUJUAN;
		return $this;
	}
}

?>