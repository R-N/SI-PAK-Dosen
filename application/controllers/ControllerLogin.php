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
		$response = array();
		if(isLoggedIn()){
			$response['result'] = "FAIL";
			$response['errorMessage'] = "Anda sudah terlogin";
			return $response;
		}
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		
		$this->load->model('ModelAkun');
		
		$result = $this->ModelAkun->login($username, $password);
		if($result['result'] == "OK"){
			$_SESSION['idUser'] = $result['id_user'];
			$_SESSION['nama'] = $result['nama'];
			$_SESSION['role'] = $result['role'];
			$response['result'] = "OK";
		}else{
			$response['result'] = "FAIL";
			$response['errorMessage'] = $result['errorMessage'];
		}
		
		echo json_encode($response);
	}
	
	public function logout(){
		unset(
			$_SESSION['idUser'],
			$_SESSION['nama'],
			$_SESSION['role']
		);
		redirect(base_url());
	}
}
