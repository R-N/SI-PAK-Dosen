<?php

require_once(ENTITIES_DIR  . "User.php");
require_once(ENTITIES_DIR  . "EntriItemEditPAK.php");

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
		$this->load->model("ModelAkun");
		$this->load->model("ModelPAK");
		$this->load->model("ModelItemPenilaian");
		$dosen = $this->ModelAkun->getDosen($_SESSION["idUser"]);
		$unsurs = $this->ModelItemPenilaian->fetchUnsurPenilaian();
		
		$emptyItem = new EntriItemEditPAK();
		if($idPAK){
			$pak = $this->ModelPAK->getPAK($idPAK);
			$items = $this->ModelItemPenilaian->fetchItemPenilaianEdit($_SESSION["idUser"]);
			$jabatanTujuan = $this->ModelAkun->getJabatan($pak->idJabatanTujuan);
			$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($pak->idJabatanAwal);
		}else{
			$pak = null;
			$items = array();
			$jabatanTujuan = $this->ModelAkun->getJabatan($dosen->idJabatan+1);
			$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($dosen->idJabatan);
		}
		$data = array(
			"dosen" => $dosen,
			"jabatanTujuan" => $jabatanTujuan,
			"pak" => $pak,
			"items" => $items,
			"emptyItem" => $emptyItem,
			"unsurs"=>$unsurs,
			"batasKategori" => $batasKategori
		);
		$this->load->view("dosen/EditPAK.html", $data);
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