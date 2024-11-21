<?php


class EntriItemNilaiAkhirPAK {
    public $idItem;
    public $idKategori;
    private $nilai1;
    private $nilai2;
    private $nilaiAwal;
    
    public function __construct() {
        
    }
    
    public function read($queryResult){
        
        if(isset($queryResult->ID_ITEM)) $this->idItem = $queryResult->ID_ITEM;
        if(isset($queryResult->ID_KATEGORI)) $this->idKategori = $queryResult->ID_KATEGORI;
        if(isset($queryResult->NILAI_AWAL)) $this->nilaiAwal = $queryResult->NILAI_AWAL;
        if(isset($queryResult->NILAI_1)) $this->nilai1 = $queryResult->NILAI_1;
        if(isset($queryResult->NILAI_2)) $this->nilai2 = $queryResult->NILAI_2;

        if(isset($queryResult->id_item)) $this->idItem = $queryResult->id_item;
        if(isset($queryResult->id_kategori)) $this->idKategori = $queryResult->id_kategori;
        if(isset($queryResult->nilai_awal)) $this->nilaiAwal = $queryResult->nilai_awal;
        if(isset($queryResult->nilai_1)) $this->nilai1 = $queryResult->nilai_1;
        if(isset($queryResult->nilai_2)) $this->nilai2 = $queryResult->nilai_2;
        
        return $this;
    }
    
    public function nilaiAkhir(){
        return 0.5*($this->nilai1+$this->nilai2);
    }
}
?>