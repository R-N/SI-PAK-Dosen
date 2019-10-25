<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanLogin(){
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
		
		$response = $this->ModelAkun->login($username, $password);
		
		echo json_encode($response);
	}
}
