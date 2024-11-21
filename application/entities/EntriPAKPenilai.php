<?php


class EntriPAKPenilai{
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

        if(isset($queryResult->id_pak)) $this->idPAK = $queryResult->id_pak;
        if(isset($queryResult->id_pemohon)) $this->idPemohon = $queryResult->id_pemohon;
        if(isset($queryResult->pemohon)) $this->namaPemohon = $queryResult->pemohon;
        if(isset($queryResult->id_subrumpun)) $this->idSubrumpun = $queryResult->id_subrumpun;
        if(isset($queryResult->subrumpun)) $this->subrumpun = $queryResult->subrumpun;
        if(isset($queryResult->tanggal_status)) $this->tanggalStatus = $queryResult->tanggal_status;
        if(isset($queryResult->id_status_pak)) $this->setStatus($queryResult->id_status_pak);
        if(isset($queryResult->id_jabatan_awal)) $this->idJabatanAwal = $queryResult->id_jabatan_awal;
        if(isset($queryResult->jabatan_awal)) $this->jabatanAwal = $queryResult->jabatan_awal;
        
        return $this;
    }
}

?>