<?php

namespace SIPAK\Entities;

class PenilaiLuar extends Penilai{
	public $asalInstansi;
	
    public function __construct() {
		
    }
	
	public function getAsalInstansi(){
		return $asalInstansi;
	}
}
?>