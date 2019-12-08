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
		$this->load->model("ModelPenilai");
		$args = array(
			"search" => $this->input->get("search")?: '',
			"page" => $this->input->get("page")?: 1,
			"limit" => $this->input->get("limit")?: 10
		);
		$entries = $this->ModelPAK->fetchPAKBaru($args["search"], $args["page"], $args["limit"]);
		$data = array(
			"entries"=>$entries,
			"penilais" => $this->ModelPenilai->fetchPenilaiPAK()
		);
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
	
	public function tentukanPenilai(){
		if(!isAdmin()){
			redirect(base_url());
			return;
		}
		$idPAK = $this->input->post("idPAK");
		$nomor = $this->input->post("nomor");
		$idUser = $this->input->post("idUser") ? : null;
		$idPegawai = $this->input->post("idPegawai") ? : null;
		
		
		$this->load->model("ModelPAK");
		$pak = $this->ModelPAK->getPAK($idPAK);
		
		if($pak->idStatus != 2){
			show_404();
			return;
		}
		if(!$idUser){
			$this->load->model("KonektorSimpeg");
			$pegawai = $this->KonektorSimpeg->getDosen($idPegawai);
			$this->load->model("ModelAkun");
			$user = $this->ModelAkun->getUserPegawai($idPegawai);
			if($user->result != "OK"){
				$user = $this->ModelAkun->insertUserPegawai($pegawai);
			}
			$idUser = $user->id_user;
		}
		if($pak->idDosen == $idUser){
			echo json_encode(array(
				'result'=>"FAIL",
				'errorMessage'=>"Pemohon tidak boleh menjadi penilai PAK-nya sendiri."
			));
			return;
		}
		if(($nomor==1&&$pak->idPenilai2==$idUser)
			|| $nomor==2 && $pak->idPenilai1==$idUser){
			echo json_encode(array(
				'result'=>"FAIL",
				'errorMessage'=>"Penilai tidak boleh sama."
			));
			return;
		}
		$result = $this->ModelPAK->tentukanPenilai($idPAK, $nomor, $idUser);
		
		echo json_encode($result);
	}
	public function submitPenilaiPAK(){
		if(!isAdmin()){
			redirect(base_url());
			return;
		}
		$idPAK = $this->input->post("idPAK");
		$this->load->model("ModelPAK");
		$pak = $this->ModelPAK->getPAK($idPAK);
		if(!$pak || $pak->idStatus != 2){
			echo json_encode(array(
				"result"=>"FAIL",
				"errorMessage"=>"PAK tidak ditemukan"
			));
			return;
		}
		if(!$pak->idPenilai1 || !$pak->idPenilai2){
			echo json_encode(array(
				"result"=>"FAIL",
				"errorMessage"=>"PAK belum memiliki dua penilai"
			));
			return;
		}
		if($pak->idDosen == $pak->idPenilai1 || $pak->idDosen == $pak->idPenilai1){
			echo json_encode(array(
				"result"=>"FAIL",
				"errorMessage"=>"Pemohon tidak boleh menjadi penilai"
			));
			return;
		}
		$result = $this->ModelPAK->submitPenilaiPAK($idPAK);
		echo json_encode($result);
	}
	public function index()
	{
		redirect(base_url() . "admin/baru");
	}
	public function suspendPenilai($idPenilai, $alasan){
		if(!isAdmin()){
			show_404();
			return;
		}
	}
	public function activatePenilai($idPenilai){
		if(!isAdmin()){
			show_404();
			return;
		}
	}
	public function inputHasilSidang(){
		if(!isAdmin()){
			show_404();
			return;
		}
		
		$idPAK = $this->input->post("idPAK");
		$urlSK = $this->input->post("urlSK");
		$setuju = json_decode($this->input->post("setuju"));
		
		if(!validateUrl($urlSK)){
			echo json_encode(array(
				"result"=>"FAIL",
				"errorMessage"=>"Invalid URL SK: " . $urlSK
			));
			return;
		}
		
		if($setuju){
			echo "SETUJU " . $setuju;
		}
		
		$this->load->model("ModelPAK");
		
		$result = $this->ModelPAK->inputHasilSidangPAK($idPAK, $setuju, $urlSK);
		
		if($result["result"] == "OK"){
			$result["redirect"] = base_url()."admin/sidang";
		}
		
		echo json_encode($result);
	}
}