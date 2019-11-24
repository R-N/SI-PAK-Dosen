<?php


class EntriItemDetailPAK extends EntriItemPAK{
	public $idItem;
	public $idPAK;
	public $idUnsur;
	public $kegiatan;
	public $idKategori;
	public $kategori;
	public $urlDokumen;
	public $nilai;
	public $bukti;
	
    public function __construct() {
		
    }
	
	public function read($queryResult){
		if(isset($queryResult->ID_ITEM)) $this->idItem = $queryResult->ID_ITEM;
		if(isset($queryResult->ID_PAK)) $this->idPAK = $queryResult->ID_PAK;
		if(isset($queryResult->ID_UNSUR)) $this->idUnsur = $queryResult->ID_UNSUR;
		if(isset($queryResult->KEGIATAN)) $this->kegiatan = $queryResult->KEGIATAN;
		if(isset($queryResult->ID_KATEGORI)) $this->idKategori = $queryResult->ID_KATEGORI;
		if(isset($queryResult->KATEGORI)) $this->kategori = $queryResult->KATEGORI;
		if(isset($queryResult->URL_DOKUMEN)) $this->urlDokumen = $queryResult->URL_DOKUMEN;
		if(isset($queryResult->NILAI)) $this->nilai = $queryResult->NILAI;
		if(isset($queryResult->BUKTI)) $this->bukti = $queryResult->BUKTI;
	}
}
?>