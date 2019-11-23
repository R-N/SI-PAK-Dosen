<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerPenilai extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanBerandaPenilai(){
		if(!isPenilai()){
			redirect(base_url());
			return;
		}
		$this->load->model("ModelPAK");
		$args = array(
			"search" => $this->input->get("search")?: '',
			"page" => $this->input->get("page")?: 1,
			"limit" => $this->input->get("limit")?: 10
		);
		$args["idPenilai"] = $_SESSION['idUser'];
		$entries = $this->ModelPAK->fetchPAKPenilai($args["idPenilai"], $args["search"], $args["page"], $args["limit"]);
		$data = array("entries"=>$entries);
		$this->load->view('penilai/PenilaianPAK.html', $data);
	}
	
	public function halamanPenilaianPAK($idPAK){
		if(!isPenilai()){
			redirect(base_url());
			return;
		}
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