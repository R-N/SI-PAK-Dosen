<?php


class PAK{
	 const PAK_EDIT = 1;
	 const PAK_BARU = 2;
	 const PAK_NILAI = 3;
	 const PAK_SIDANG = 4;
	 const PAK_SELESAI = 11;
	 const PAK_TOLAK_NILAI =21;
	 const PAK_TOLAK_SIDANG = 22;
	
	public $id;
	public $idDosen;
	public $dosen;
	public $idSubrumpun;
	public $subrumpun;
	public $idPenilai1 = null;
	public $idPenilai2 = null;
	public $penilai1 = null;
	public $penilai2 = null;
	public $tanggalDiajukan = null;
	public $tanggalStatus;
	public $idStatus;
	public $status;
	public $idJabatanAwal;
	public $idJabatanTujuan;
	public $jabatanAwal;
	public $jabatanTujuan;
	public $urlSK;
	
	 
    public function __construct() {
		
    }
	
	public static function statusToString($idStatus){
		switch($idStatus){
			case PAK::PAK_EDIT: return "Belum disubmit";
			case PAK::PAK_BARU: return "Baru";
			case PAK::PAK_NILAI: return "Menunggu penilaian";
			case PAK::PAK_SIDANG: return "Menunggu sidang";
			case PAK::PAK_TOLAK_NILAI: return "Ditolak (nilai kurang)";
			case PAK::PAK_TOLAK_SIDANG: return "Ditolak (dalam sidang)";
			default: throw new Exception("Invalid status: " . $idStatus);
		}
	}
	
	public function setStatus($idStatus){
		$this->idStatus = $idStatus;
		$this->status = PAK::statusToString($idStatus);
	}
	
	public function getDataSimpeg(){
	}
	
	public function read($queryResult){
		if(isset($queryResult->ID_PAK)) $this->id = $queryResult->ID_PAK;
		if(isset($queryResult->ID_PEMOHON)) $this->idDosen = $queryResult->ID_PEMOHON;
		if(isset($queryResult->PEMOHON)) $this->dosen = $queryResult->PEMOHON;
		if(isset($queryResult->ID_SUBRUMPUN)) $this->idSubrumpun = $queryResult->ID_SUBRUMPUN;
		if(isset($queryResult->SUBRUMPUN)) $this->subrumpun = $queryResult->SUBRUMPUN;
		if(isset($queryResult->ID_PENILAI_1)) $this->idPenilai1 = $queryResult->ID_PENILAI_1;
		if(isset($queryResult->ID_PENILAI_2)) $this->idPenilai2 = $queryResult->ID_PENILAI_2;
		if(isset($queryResult->PENILAI_1)) $this->penilai1 = $queryResult->PENILAI_1;
		if(isset($queryResult->PENILAI_2)) $this->penilai2 = $queryResult->PENILAI_2;
		if(isset($queryResult->TANGGAL_DIAJUKAN)) $this->tanggalDiajukan = $queryResult->TANGGAL_DIAJUKAN;
		if(isset($queryResult->TANGGAL_STATUS)) $this->tanggalStatus = $queryResult->TANGGAL_STATUS;
		if(isset($queryResult->STATUS_PAK)) $this->status =$queryResult->STATUS_PAK;
		if(isset($queryResult->ID_STATUS_PAK)) $this->setStatus($queryResult->ID_STATUS_PAK);
		if(isset($queryResult->ID_JABATAN_AWAL)) $this->idJabatanAwal = $queryResult->ID_JABATAN_AWAL;
		if(isset($queryResult->ID_JABATAN_TUJUAN)) $this->idJabatanTujuan = $queryResult->ID_JABATAN_TUJUAN;
		if(isset($queryResult->JABATAN_AWAL)) $this->jabatanAwal = $queryResult->JABATAN_AWAL;
		if(isset($queryResult->JABATAN_TUJUAN)) $this->jabatanTujuan = $queryResult->JABATAN_TUJUAN;
		if(isset($queryResult->URL_SK)) $this->urlSK = $queryResult->URL_SK;
		return $this;
	}
}

?>