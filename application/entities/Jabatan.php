<?php


class Jabatan{
    public $id;
    public $jabatan;
    public $kreditMinimal;
    public function __construct() {
        
    }
    
    public function read($queryResult){
        
        if(isset($queryResult->ID_JABATAN)) $this->id = $queryResult->ID_JABATAN;
        if(isset($queryResult->JABATAN)) $this->jabatan = $queryResult->JABATAN;
        if(isset($queryResult->KREDIT)) $this->kreditMinimal = $queryResult->KREDIT;
        
        if(isset($queryResult->id_jabatan)) $this->id = $queryResult->id_jabatan;
        if(isset($queryResult->jabatan)) $this->jabatan = $queryResult->jabatan;
        if(isset($queryResult->kredit)) $this->kreditMinimal = $queryResult->kredit;
    }
}

?>