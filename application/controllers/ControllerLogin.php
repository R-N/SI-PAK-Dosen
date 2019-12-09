<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerLogin extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanLogin(){
		if(isAdmin()){
			redirect(base_url() . "admin");
		}else if (isDosen()){
			redirect(base_url() . "dosen");
		}else if (isPenilai()){
			redirect(base_url() . "penilai");
		}else{
			$this->load->view('umum/Login.html');
		}
	}
	 
	public function index()
	{
		$this->halamanLogin();
	}
	
	public function login(){
		$response = new stdClass();
		if(isLoggedIn()){
			$response->result = "FAIL";
			$response->errorMessage = "Anda sudah terlogin";
			echo json_encode($response);
			return;
		}
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		
		$this->load->model('ModelAkun');
		$this->load->model('KonektorSimpeg');
		
		$result = $this->ModelAkun->login($username, $password);
		if($result->result != "OK"){
			$result = $this->KonektorSimpeg->login($username, $password);
			if($result->result == "OK"){
				$result1 = $this->ModelAkun->getUserPegawai($result->id_pegawai);
				if($result1->result != "OK"){
					$result = $this->ModelAkun->insertUserPegawai($result);
				}else{
					$result = $result1;
				}
			}
		}
		if($result->status_user != 1){
			echo json_encode(array(
				"result"=>"FAIL",
				"errorMessage"=>"Akun Anda telah disuspend karena: " . $result->keterangan
			));
			return;
		}
		if($result->result == "OK"){
			$_SESSION['idUser'] = $result->id_user;
			$_SESSION['nama'] = $result->nama;
			$_SESSION['role'] = $result->role;
			if(isset($result->id_pegawai)){
				$_SESSION['idPegawai'] = $result->id_pegawai;
			}else{
				$_SESSION['idPegawai'] = null;
			}
			$response->result = "OK";
		}else{
			$response->result = "FAIL";
			$response->errorMessage = $result->errorMessage;
		}
		
		echo json_encode($response);
	}
	
	public function logout(){
		unset(
			$_SESSION['idUser'],
			$_SESSION['nama'],
			$_SESSION['role'],
			$_SESSION['idPegawai']
		);
		redirect(base_url());
	}
}
