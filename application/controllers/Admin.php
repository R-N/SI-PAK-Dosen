<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanPAKBaru(){
		$this->load->view('admin/PAKBaru.html');
	}
	
	public function halamanPreviewDraftSK(){
	}
	
	public function halamanPAKMenungguSidang(){
		$this->load->view("admin/PAKSidang.html");
	}
	
	public function halamanDaftarPenilai(){
		$this->load->view("admin/KelolaPenilai.html");
	}
	
	public function halamanFormPenilaiLuar(){
		$this->load->view("admin/DaftarkanPenilai.html");
	}
	 
	public function index()
	{
		redirect(base_url() . "admin/baru");
	}
}