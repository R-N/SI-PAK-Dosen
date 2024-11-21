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

        if(isset($queryResult->id_pak)) $this->idPAK = $queryResult->id_pak;
        if(isset($queryResult->tanggal_diajukan)) $this->tanggalDiajukan = $queryResult->tanggal_diajukan;
        if(isset($queryResult->tanggal_status)) $this->tanggalStatus = $queryResult->tanggal_status;
        if(isset($queryResult->status_pak)) $this->status =$queryResult->status_pak;
        if(isset($queryResult->id_status_pak)) $this->setStatus($queryResult->id_status_pak);
        if(isset($queryResult->id_jabatan_awal)) $this->idJabatanAwal = $queryResult->id_jabatan_awal;
        if(isset($queryResult->id_jabatan_tujuan)) $this->idJabatanTujuan = $queryResult->id_jabatan_tujuan;
        if(isset($queryResult->jabatan_awal)) $this->jabatanAwal = $queryResult->jabatan_awal;
        if(isset($queryResult->jabatan_tujuan)) $this->jabatanTujuan = $queryResult->jabatan_tujuan;
        
        return $this;
    }
}

?>