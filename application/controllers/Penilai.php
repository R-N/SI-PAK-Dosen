<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penilai extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanBerandaPenilai(){
		$this->load->view('penilai/PenilaianPAK.html');
	}
	
	public function halamanPenilaianPAK($idPAK){
		$this->load->view("penilai/MenilaiPAK.html");
	}
	 
	public function index()
	{
		redirect(base_url() . "penilai/pak");
	}
}