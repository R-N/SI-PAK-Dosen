<?php

require_once(ENTITIES_DIR  . "User.php");

defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerDosen extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanBerandaDosen(){
		if(!isDosen()){
			redirect(base_url());
			return;
		}
		$this->load->model("ModelPAK");
		$args = array(
			"search" => $this->input->get("search")?: '',
			"page" => $this->input->get("page")?: 1,
			"limit" => $this->input->get("limit")?: 10
		);
		$args["idDosen"] = $_SESSION['idUser'];
		$entries = $this->ModelPAK->fetchPAKDosen($args["idDosen"], $args["search"], $args["page"], $args["limit"]);
		$data = array("entries"=>$entries);
		$this->load->view('dosen/PengajuanPAK.html', $data);
	}
	
	public function halamanPreviewDraftDokumen($idItem){
		if(!isDosen()){
			redirect(base_url());
			return;
		}
	}
	
	public function halamanEditPAK($idPAK=""){
		if(!isDosen()){
			redirect(base_url());
			return;
		}
		$this->load->view("dosen/EditPAK.html");
	}
	 
	public function index()
	{
		if(!isDosen()){
			redirect(base_url());
			return;
		}
		redirect(base_url() . "dosen/pak");
	}
	
	public function simpanPAK($pak, $item){
	}
	public function submitPAK($idPAK){
	}
}