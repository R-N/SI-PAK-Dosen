<?php

class User{
	const PENILAI = 1;
	const DOSEN = 3;
	const ADMIN = 4;
	
	public $id;
	public $role;
	public $idPegawai;
	public $status;
    public function __construct() {
		
    }
    
}
?>