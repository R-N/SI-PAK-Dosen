<?php

class User{
	const PENILAI = 1;
	const DOSEN = 3;
	const ADMIN = 4;
	
	public $idUser;
	public $nama;
	public $role;
	public $idPegawai;
	public $status;
	public $nip;
	public $email;
	public $telepon;
	public $keterangan;
	public $asalInstansi = "UINSA";
    public function __construct() {
		
    }
    
	public function read($queryResult){
		if(isset($queryResult->ID_USER)) $this->idUser = $queryResult->ID_USER;
		if(isset($queryResult->ID_PEGAWAI)) $this->idPegawai = $queryResult->ID_PEGAWAI;
		if(isset($queryResult->NAMA)) $this->nama = $queryResult->NAMA;
		if(isset($queryResult->ROLE)) $this->role = $queryResult->ROLE;
		if(isset($queryResult->KETERANGAN)) $this->keterangan = $queryResult->KETERANGAN;
		if(isset($queryResult->STATUS_USER)) $this->status = $queryResult->STATUS_USER;
		if(isset($queryResult->NIP)) $this->nip = $queryResult->NIP;
		if(isset($queryResult->EMAIL)) $this->email = $queryResult->EMAIL;
		if(isset($queryResult->TELEPON)) $this->telepon = $queryResult->TELEPON;
		if(isset($queryResult->ASAL_INSTANSI)) $this->asalInstansi = $queryResult->ASAL_INSTANSI;
		
		if(isset($queryResult->id_user)) $this->idUser = $queryResult->id_user;
		if(isset($queryResult->id_pegawai)) $this->idPegawai = $queryResult->id_pegawai;
		if(isset($queryResult->nama)) $this->nama = $queryResult->nama;
		if(isset($queryResult->role)) $this->role = $queryResult->role;
		if(isset($queryResult->keterangan)) $this->keterangan = $queryResult->keterangan;
		if(isset($queryResult->status_user)) $this->status = $queryResult->status_user;
		if(isset($queryResult->nip)) $this->nip = $queryResult->nip;
		if(isset($queryResult->email)) $this->email = $queryResult->email;
		if(isset($queryResult->telepon)) $this->telepon = $queryResult->telepon;
		if(isset($queryResult->asal_instansi)) $this->asalInstansi = $queryResult->asal_instansi;
		
		
		if(is_array($queryResult)){
			if(isset($queryResult["ID_USER"])) $this->idUser = $queryResult["ID_USER"];
			if(isset($queryResult["ID_PEGAWAI"])) $this->idPegawai = $queryResult["ID_PEGAWAI"];
			if(isset($queryResult["NAMA"])) $this->nama = $queryResult["NAMA"];
			if(isset($queryResult["ROLE"])) $this->role = $queryResult["ROLE"];
			if(isset($queryResult["KETERANGAN"])) $this->keterangan = $queryResult["KETERANGAN"];
			if(isset($queryResult["STATUS_USER"])) $this->status = $queryResult["STATUS_USER"];
			if(isset($queryResult["NIP"])) $this->nip = $queryResult["NIP"];
			if(isset($queryResult["EMAIL"])) $this->email = $queryResult["EMAIL"];
			if(isset($queryResult["TELEPON"])) $this->telepon = $queryResult["TELEPON"];
			if(isset($queryResult["ASAL_INSTANSI"])) $this->asalInstansi = $queryResult["ASAL_INSTANSI"];
			
			if(isset($queryResult["id_user"])) $this->idUser = $queryResult["id_user"];
			if(isset($queryResult["id_pegawai"])) $this->idPegawai = $queryResult["id_pegawai"];
			if(isset($queryResult["nama"])) $this->nama = $queryResult["nama"];
			if(isset($queryResult["role"])) $this->role = $queryResult["role"];
			if(isset($queryResult["keterangan"])) $this->keterangan = $queryResult["keterangan"];
			if(isset($queryResult["status_user"])) $this->status = $queryResult["status_user"];
			if(isset($queryResult["nip"])) $this->nip = $queryResult["nip"];
			if(isset($queryResult["email"])) $this->email = $queryResult["email"];
			if(isset($queryResult["telepon"])) $this->telepon = $queryResult["telepon"];
			if(isset($queryResult["asal_instansi"])) $this->asalInstansi = $queryResult["asal_instansi"];
		}
		
		if(isset($queryResult->idUser)) $this->idUser = $queryResult->idUser;
		if(isset($queryResult->idPegawai)) $this->idPegawai = $queryResult->idPegawai;
		if(isset($queryResult->nama)) $this->nama = $queryResult->nama;
		if(isset($queryResult->role)) $this->role = $queryResult->role;
		if(isset($queryResult->keterangan)) $this->keterangan = $queryResult->keterangan;
		if(isset($queryResult->status)) $this->status = $queryResult->status;
		if(isset($queryResult->nip)) $this->nip = $queryResult->nip;
		if(isset($queryResult->email)) $this->email = $queryResult->email;
		if(isset($queryResult->telepon)) $this->telepon = $queryResult->telepon;
		if(isset($queryResult->asalInstansi)) $this->asalInstansi = $queryResult->asalInstansi;
		
		return $this;
	}
}
?>