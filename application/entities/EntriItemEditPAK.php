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
        
        if(isset($queryResult->TAHUN)) $this->tahun = $queryResult->TAHUN;
        if(isset($queryResult->SEMESTER)) $this->semester = $queryResult->SEMESTER;
        if(isset($queryResult->UNIT)) $this->unit = $queryResult->UNIT;
        if(isset($queryResult->ID_JENIS_BATAS)) $this->idJenisBatas = $queryResult->ID_JENIS_BATAS;
        if(isset($queryResult->BATAS)) $this->batas = $queryResult->BATAS;
        if(isset($queryResult->JENIS_BATAS)) $this->jenisBatas = $queryResult->JENIS_BATAS;
        if(isset($queryResult->MAX_KREDIT)) $this->kreditPerItem = $queryResult->MAX_KREDIT;
        if(isset($queryResult->KETERANGAN)) $this->keterangan = $queryResult->KETERANGAN;

        if(isset($queryResult->tahun)) $this->tahun = $queryResult->tahun;
        if(isset($queryResult->semester)) $this->semester = $queryResult->semester;
        if(isset($queryResult->unit)) $this->unit = $queryResult->unit;
        if(isset($queryResult->id_jenis_batas)) $this->idJenisBatas = $queryResult->id_jenis_batas;
        if(isset($queryResult->batas)) $this->batas = $queryResult->batas;
        if(isset($queryResult->jenis_batas)) $this->jenisBatas = $queryResult->jenis_batas;
        if(isset($queryResult->max_kredit)) $this->kreditPerItem = $queryResult->max_kredit;
        if(isset($queryResult->keterangan)) $this->keterangan = $queryResult->keterangan;
        
        if($this->nilai && $this->kreditPerItem){
            $this->jumlah = $this->nilai/$this->kreditPerItem;
            //echo "jumlah {$this->nilai}/{$this->batas}={$this->jumlah}";
        }
        return $this;
    }
}
?>