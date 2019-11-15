<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanLogin(){
		if(isset($_SESSION['role'])){
			$role = $_SESSION['role'];
			if($role == 1){
				redirect(base_url() . "penilai");
			}else if($role == 3){
				redirect(base_url() . "dosen");
			}else if($role == 4){
				redirect(base_url() . "admin");
			}
		}
		$this->load->view('umum/Login.html');
	}
	 
	public function index()
	{
		$this->halamanLogin();
	}
	
	public function login(){
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		
		$this->load->model('ModelAkun');
		
		$result = $this->ModelAkun->login($username, $password);
		$response = array();
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
