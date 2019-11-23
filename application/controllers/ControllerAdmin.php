<?php


defined('BASEPATH') OR exit('No direct script access allowed');


class ControllerAdmin extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanPAKBaru(){
		if(!isAdmin()){
			redirect(base_url());
			return;
		}
		$this->load->model("ModelPAK");
		$args = array(
			"search" => $this->input->get("search")?: '',
			"page" => $this->input->get("page")?: 1,
			"limit" => $this->input->get("limit")?: 10
		);
		$entries = $this->ModelPAK->fetchPAKBaru($args["search"], $args["page"], $args["limit"]);
		$data = array("entries"=>$entries);
		$this->load->view('admin/PAKBaru.html', $data);
	}
	
	public function halamanPreviewDraftSK(){
		if(!isAdmin()){
			redirect(base_url());
			return;
		}
	}
	
	public function halamanPAKMenungguSidang(){
		if(!isAdmin()){
			redirect(base_url());
			return;
		}
		$this->load->model("ModelPAK");
		$args = array(
			"search" => $this->input->get("search")?: '',
			"page" => $this->input->get("page")?: 1,
			"limit" => $this->input->get("limit")?: 10
		);
		$entries = $this->ModelPAK->fetchPAKSidang($args["search"], $args["page"], $args["limit"]);
		$data = array("entries"=>$entries);
		$this->load->view("admin/PAKSidang.html", $data);
	}
	
	public function halamanDaftarPenilai(){
		if(!isAdmin()){
			redirect(base_url());
			return;
		}
		$this->load->model("ModelPenilai");
		$args = array(
			"search" => $this->input->get("search")?: '',
			"page" => $this->input->get("page")?: 1,
			"limit" => $this->input->get("limit")?: 10
		);
		$entries = $this->ModelPenilai->fetchPenilai($args["search"], $args["page"], $args["limit"]);
		$data = array("entries"=>$entries);
		$this->load->view("admin/KelolaPenilai.html", $data);
	}
	
	public function halamanFormPenilaiLuar(){
		if(!isAdmin()){
			redirect(base_url());
			return;
		}
		$this->load->model("ModelAkun");
		$pilihanSubrumpun = $this->ModelAkun->getPilihanSubrumpun();
		$pilihanJabatan = $this->ModelAkun->getPilihanJabatan();
		$this->load->view("admin/DaftarkanPenilai.html", array(
			"pilihanJabatan" => $pilihanJabatan,
			"pilihanSubrumpun" => $pilihanSubrumpun
		));
	}
	
	public function daftarkanPenilaiLuar(){
		$this->load->model("ModelAkun");
		$data = $this->input->post();
		$result = $this->ModelAkun->daftarkanPenilaiLuar($data);
		if($result["result"] == "OK"){
			$result["redirect"] = base_url() . "admin/penilai";
		}
		echo json_encode($result);
	}
	
	public function suspendPenilai($idPenilai, $alasan){
	}
	public function activatePenilai($idPenilai){
	}
	public function fetchPenilaiPAK($idPAK){
	}
	public function inputHasilSidang($idPAK, $setuju, $urlSK){
	}
	public function pilihPenilai($idPAK, $nomor, $idPenilai){
	}
	public function submitPenilai($idPAK){
	}
	public function index()
	{
		redirect(base_url() . "admin/baru");
	}
}