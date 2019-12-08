<?php

require_once(ENTITIES_DIR  . "Penilai.php");

class Dosen extends Penilai{
	
    public function __construct() {
		
    }
	public function read($queryResult){
		parent::read($queryResult);
		return $this;
	}
}
?>