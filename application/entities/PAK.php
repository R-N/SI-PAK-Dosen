<?php

namespace SIPAK\Entities;

class PAK{
	public const PAK_EDIT = 0;
	public const PAK_BARU = 1;
	public const PAK_NILAI = 2;
	public const PAK_SIDANG = 3;
	public const PAK_TOLAK_NILAI = 11;
	public const PAK_TOLAK_SIDANG = 12;
	
	public $id;
	public $idDosen;
	public $idPenilai1 = null;
	public $idPenilai2 = null;
	public $tanggalDiajukan = null;
	public $tanggalStatus;
	public $status;
	public $jabatanAwal;
	public $jabatanTujuan;
	public $urlSK;
	
	 
    public function __construct() {
		
    }
	
}

?>