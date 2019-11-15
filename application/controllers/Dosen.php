<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanBerandaDosen(){
		$this->load->view('dosen/PengajuanPAK.html');
	}
	
	public function halamanPreviewDraftDokumen($idItem){
	}
	
	public function halamanEditPAK($idPAK=""){
		$this->load->view("dosen/EditPAK.html");
	}
	 
	public function index()
	{
		redirect(base_url() . "dosen/pak");
	}
}