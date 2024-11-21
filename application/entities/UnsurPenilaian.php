<?php


class UnsurPenilaian{
    public $id;
    public $idKategori;
    public $kategori;
    public $kegiatan;
    public $bukti;
    public $batas;
    public $idJenisBatas;
    public $jenisBatas;
    public $unit;
    public $kreditPerItem;
    public function __construct() {
        
    }
    
    public function read($queryResult){
        
        if(isset($queryResult->ID_UNSUR)) $this->id = $queryResult->ID_UNSUR;
        if(isset($queryResult->ID_KATEGORI)) $this->idKategori = $queryResult->ID_KATEGORI;
        if(isset($queryResult->KATEGORI)) $this->kategori = $queryResult->KATEGORI;
        if(isset($queryResult->KEGIATAN)) $this->kegiatan = $queryResult->KEGIATAN;
        if(isset($queryResult->BUKTI)) $this->bukti = $queryResult->BUKTI;
        if(isset($queryResult->BATAS)) $this->batas = $queryResult->BATAS;
        if(isset($queryResult->ID_JENIS_BATAS)) $this->idJenisBatas = $queryResult->ID_JENIS_BATAS;
        if(isset($queryResult->JENIS_BATAS)) $this->jenisBatas = $queryResult->JENIS_BATAS;
        if(isset($queryResult->UNIT)) $this->unit = $queryResult->UNIT;
        if(isset($queryResult->MAX_KREDIT)) $this->kreditPerItem = $queryResult->MAX_KREDIT;
        
        if(isset($queryResult->id_unsur)) $this->id = $queryResult->id_unsur;
        if(isset($queryResult->id_kategori)) $this->idKategori = $queryResult->id_kategori;
        if(isset($queryResult->kategori)) $this->kategori = $queryResult->kategori;
        if(isset($queryResult->kegiatan)) $this->kegiatan = $queryResult->kegiatan;
        if(isset($queryResult->bukti)) $this->bukti = $queryResult->bukti;
        if(isset($queryResult->batas)) $this->batas = $queryResult->batas;
        if(isset($queryResult->id_jenis_batas)) $this->idJenisBatas = $queryResult->id_jenis_batas;
        if(isset($queryResult->jenis_batas)) $this->jenisBatas = $queryResult->jenis_batas;
        if(isset($queryResult->unit)) $this->unit = $queryResult->unit;
        if(isset($queryResult->max_kredit)) $this->kreditPerItem = $queryResult->max_kredit;
    }
    
}
?>