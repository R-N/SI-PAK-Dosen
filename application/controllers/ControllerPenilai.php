<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerPenilai extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanBerandaPenilai(){
		$this->load->view('penilai/PenilaianPAK.html');
	}
	
	public function halamanPenilaianPAK($idPAK){
		$this->load->view("penilai/MenilaiPAK.html");
	}
	
	public function simpanPenilaian($penilaian){
	}
	
	public function submitPenilaian($idPAK){
	}
	
	public function fetchItemPenilaian($idPAK){
	}
	 
	public function index()
	{
		redirect(base_url() . "penilai/pak");
	}
}