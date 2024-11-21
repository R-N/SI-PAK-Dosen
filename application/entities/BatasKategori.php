<?php


class BatasKategori{
    public $idJabatan;
    public $idKategori;
    public $kategori;
    public $maksimal;
    public $minimal;
    public $minType;
    public $maxType;
    public $maksimalAbs;
    public $minimalAbs;
    public function __construct() {
        
    }
    public function read($queryResult){
        if(isset($queryResult->ID_JABATAN)) $this->idJabatan = $queryResult->ID_JABATAN;
        if(isset($queryResult->ID_KATEGORI)) $this->idKategori = $queryResult->ID_KATEGORI;
        if(isset($queryResult->KATEGORI)) $this->kategori = $queryResult->KATEGORI;
        if(isset($queryResult->MAKSIMAL)) $this->maksimal = $queryResult->MAKSIMAL;
        if(isset($queryResult->MINIMAL)) $this->minimal = $queryResult->MINIMAL;
        if(isset($queryResult->MIN_TYPE)) $this->minType = $queryResult->MIN_TYPE;
        if(isset($queryResult->MAX_TYPE)) $this->maxType = $queryResult->MAX_TYPE;
        if(isset($this->minType) && $this->minType == 0) $this->minimalAbs = $this->minimal;
        if(isset($this->maxType) && $this->maxType == 0) $this->maksimalAbs = $this->maksimal;
        
        if(isset($queryResult->id_jabatan)) $this->idJabatan = $queryResult->id_jabatan;
        if(isset($queryResult->id_kategori)) $this->idKategori = $queryResult->id_kategori;
        if(isset($queryResult->kategori)) $this->kategori = $queryResult->kategori;
        if(isset($queryResult->maksimal)) $this->maksimal = $queryResult->maksimal;
        if(isset($queryResult->minimal)) $this->minimal = $queryResult->minimal;
        if(isset($queryResult->min_type)) $this->minType = $queryResult->min_type;
        if(isset($queryResult->max_type)) $this->maxType = $queryResult->max_type;
        if(isset($this->minType) && $this->minType == 0) $this->minimalAbs = $this->minimal;
        if(isset($this->maxType) && $this->maxType == 0) $this->maksimalAbs = $this->maksimal;
    }
    
    public function setKreditDibutuhkan($kredit){
        if(isset($this->minType)){
            if($this->minType == 0) $this->minimalAbs = $this->minimal;
            else if ($this->minType == 1) $this->minimalAbs = $this->minimal * $kredit / 100.0;
        }
        if(isset($this->maxType)){
            if($this->maxType == 0) $this->maksimalAbs = $this->maksimal;
            else if ($this->maxType == 1) $this->maksimalAbs = $this->maksimal * $kredit / 100.0;
        }
    }
}
?>