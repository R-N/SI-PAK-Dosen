<?php


class EntriPAKBaru extends EntriPAKAdmin{
	public $idPenilai1;
	public $penilai1;
	public $idPenilai2;
	public $penilai2;
	
    public function __construct() {
		
    }
	
	public function read($queryResult){
		parent::read($queryResult);
		if(isset($queryResult->ID_PENILAI_1)) $this->idPenilai1 = $queryResult->ID_PENILAI_1;
		if(isset($queryResult->ID_PENILAI_2)) $this->idPenilai2 = $queryResult->ID_PENILAI_2;
		if(isset($queryResult->PENILAI_1)) $this->penilai1 = $queryResult->PENILAI_1;
		if(isset($queryResult->PENILAI_2)) $this->penilai2 = $queryResult->PENILAI_2;
		return $this;
	}
}

?>