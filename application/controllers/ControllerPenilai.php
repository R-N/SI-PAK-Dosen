<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(ENTITIES_DIR  . "PAK.php");

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
		$this->load->model("ModelAkun");
		$this->load->model("ModelPAK");
		$this->load->model("ModelItemPenilaian");
		
		$idPenilai = $_SESSION["idUser"];
		
		$pak = $this->ModelPAK->getPAK($idPAK);
		if(!$pak || $pak->idStatus != 3 
			|| $pak->idPenilaiSubmit == $idPenilai){
			
			show_404();
			return;
		}
		
		if($idPenilai == $pak->idPenilai1){
			$nomorPenilai = 1;
		}else if($idPenilai == $pak->idPenilai2){
			$nomorPenilai = 2;
		}else{
			show_404();
			return;
		}
		
		$items = $this->ModelItemPenilaian->fetchItemPenilaianNilai($pak->id, $nomorPenilai);
		$dosen = $this->ModelAkun->getDosen($pak->idDosen);
		$jabatanTujuan = $this->ModelAkun->getJabatan($pak->idJabatanTujuan);
		$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($pak->idJabatanTujuan);
		
			
		$kekuranganKredit = max(0, $jabatanTujuan->kreditMinimal - $pak->kreditMinimal);
		
		foreach($batasKategori as $batas){
			$batas->setKreditDibutuhkan($kekuranganKredit);
		}
		$data = array(
			"pak" => $pak,
			"items" => $items,
			"batasKategori" => $batasKategori,
			"nomorPenilai" => $nomorPenilai
		);
		$this->load->view("penilai/MenilaiPAK.html", $data);
	}
	
	public function simpanPenilaian(){
		if(!isPenilai()){
			redirect(base_url());
			return;
		}
		$penilaian = json_decode(json_encode($this->input->post("penilaian")));
		
		$idPenilai = $_SESSION["idUser"];
		$this->load->model("ModelPAK");
		
		$pak = $this->ModelPAK->getPAK($penilaian->idPAK);
		if(!$pak || $pak->idStatus != 3 
			|| $pak->idPenilaiSubmit == $idPenilai){
			
			show_404();
			return;
		}
		
		$result = $this->_simpanPenilaian($penilaian, $pak);
		
		if($result) echo json_encode($result);
		
	}
	
	function _simpanPenilaian($penilaian, $pak){
		$idPenilai = $_SESSION["idUser"];
		
		$this->load->model("ModelItemPenilaian");
		
		if($idPenilai == $pak->idPenilai1){
			$nomorPenilai = 1;
		}else if($idPenilai == $pak->idPenilai2){
			$nomorPenilai = 2;
		}else{
			show_404();
			return;
		}
		
		$itemsLama = $this->ModelItemPenilaian->fetchItemPenilaianNilaiDict($pak->id, $nomorPenilai);
		
		foreach($penilaian->items as $item){
			$itemLama = $itemsLama[$item->idItem];
			if(!$itemLama){
				return array(
					"result"=>"FAIL",
					"errorMessage"=>"Item tidak ditemukan: " . $itemLama->KEGIATAN
				);
			}
			if(!$item->nilai && $item->nilai != 0){
				$item->nilai = null;
			}
			if(!($item->nilai >= 0)){
				return array(
					"result"=>"FAIL",
					"errorMessage"=>"Nilai invalid untuk item: " . $itemLama->KEGIATAN
				);
			}
			if($item->nilai > $itemLama->NILAI_AWAL){
				return array(
					"result"=>"FAIL",
					"errorMessage"=>"Nilai invalid untuk item: " . $itemLama->KEGIATAN
				);
			}
		}
		
		foreach($penilaian->items as $item){
			$resulti = $this->ModelItemPenilaian->simpanPenilaian($item->idItem, $item->nilai, $nomorPenilai);
			if($resulti["result"] != "OK"){
				return $resulti;
			}
		}
		
		return array(
			"result"=>"OK"
		);
	}
	
	public function submitPenilaian(){
		if(!isPenilai()){
			redirect(base_url());
			return;
		}
		$penilaian = json_decode(json_encode($this->input->post("penilaian")));
		
		$idPenilai = $_SESSION["idUser"];
		$this->load->model("ModelPAK");
		
		$pak = $this->ModelPAK->getPAK($penilaian->idPAK);
		if(!$pak || $pak->idStatus != 3 
			|| $pak->idPenilaiSubmit == $idPenilai){
			
			show_404();
			return;
		}
		
		$result = $this->_simpanPenilaian($penilaian, $pak);
		
		if($result && $result["result"] != "OK"){
			echo json_encode($result);
			return;
		}
		
		$this->load->model("ModelAkun");
		$this->load->model("ModelItemPenilaian");
		if($pak->idPenilaiSubmit > 0){
			$dosen = $this->ModelAkun->getDosen($pak->idDosen);
			$jabatanTujuan = $this->ModelAkun->getJabatan($pak->idJabatanTujuan);
			$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($pak->idJabatanTujuan);
			
			$items = $this->ModelItemPenilaian->fetchItemPenilaianAkhir($pak->id);
			
			$statusAkhir = PAK::PAK_SIDANG;
			
			$subtotals = array();
			foreach($batasKategori as $batas){
				$subtotals[$batas->idKategori] = 0;
			}
			foreach($items as $item){
				$idKategori = $item->idKategori;
				$subtotals[$idKategori] += $item->nilaiAkhir();
			}
			$totals = array();
			$total = 0;
			$totalSubtotal = 0;
			foreach($batasKategori as $batas){
				$idKategori = $batas->idKategori;
				$subtotal = $subtotals[$idKategori];
				$totalSubtotal += $subtotal;
				if($batas->minimalAbs > 0 && $subtotal < $batas->minimalAbs){
					$statusAkhir = PAK::PAK_TOLAK_NILAI;
					break;
				}
				if($batas->maksimalAbs > 0 && $subtotal > $batas->maksimalAbs){
					$subtotal = $batas->maksimalAbs;
				}
				$totals[$idKategori] = $subtotal;
				$total += $subtotal;
			}
			
			if($total + $pak->kreditMinimal < $jabatanTujuan->kreditMinimal){
				$statusAkhir = PAK::PAK_TOLAK_NILAI;
			}
			
			$result = $this->ModelPAK->SubmitPenilaianPAK($pak->id, $statusAkhir, $total);
			
			//TODO submit
		}else{
			$result = $this->ModelPAK->submitPenilaian1PAK($penilaian->idPAK, $idPenilai);
			
		}
		
		if($result["result"] == "OK"){
			$result["redirect"] = base_url() . "penilai";
		}
		
		echo json_encode($result);
	}
	
	public function fetchItemPenilaian($idPAK){
	}
	 
	public function index()
	{
		redirect(base_url() . "penilai/pak");
	}
}