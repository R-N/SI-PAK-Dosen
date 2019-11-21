<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerUmum extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanPAK($idPAK){
		$this->load->view('umum/DetailPAK.html');
	}
	public function halamanPreviewDokumen($idItem){
	}
	
	public function halamanPreviewSK($idPAK){
	}
	
	public function halamanProfil($idUser){
	}
	 
	 public function fetchItemPenilaian($idPAK){
	 }
}