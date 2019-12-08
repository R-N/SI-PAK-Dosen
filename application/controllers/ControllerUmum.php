<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ControllerUmum extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanPAK($idPAK){
		if(!isLoggedIn()){
			redirect(base_url());
			return;
		}
		
			
		$this->load->model("ModelAkun");
		$this->load->model("ModelPAK");
		$this->load->model("ModelItemPenilaian");
		
		$idUser = $_SESSION["idUser"];
		
		$pak = $this->ModelPAK->getPAK($idPAK);
		if(!$pak || $pak->idStatus == 1){
			show_404();
			return;
		}
		if(!(isAdmin() && ($pak->idStatus==2 || $pak->idStatus==4))
			&& $idUser != $pak->idDosen
			&& !($pak->idStatus == 3 && ($idUser == $pak->idPenilai1 || $idUser == $pak->idPenilai2) && $idUser != $pak->idPenilaiSubmit)){
			show_404();
			return;
		}
		$items = $this->ModelItemPenilaian->fetchItemPenilaian($pak->id);
		$dosen = $this->ModelAkun->getDosen($pak->idDosen);
		$jabatanTujuan = $this->ModelAkun->getJabatan($pak->idJabatanTujuan);
		$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($pak->idJabatanTujuan);
		
			
		$kekuranganKredit = max(0, $jabatanTujuan->kreditMinimal - $pak->kreditAwal);
		foreach($batasKategori as $batas){
			$batas->setKreditDibutuhkan($kekuranganKredit);
		}
		$nilaiKategori = hitungNilaiKategori($items, $batasKategori);
		$data = array(
			"pak" => $pak,
			"items" => $items,
			"batasKategori" => $batasKategori,
			"subtotals"=>$nilaiKategori['subtotals'],
			"subtotal"=>$nilaiKategori['subtotal'],
			"totals"=>$nilaiKategori['totals'],
			"total"=>$nilaiKategori['total']
		);
		if(isAdmin()){
			$this->load->model("ModelPenilai");
			$data["penilais"] = $this->ModelPenilai->fetchPenilaiPAK();
		}
		$this->load->view('umum/DetailPAK.html', $data);
	}
	public function halamanPreviewDokumen($idItem){
	}
	
	public function halamanPreviewSK($idPAK){
	}
	
	public function halamanProfil($idUser){
	}
	 
}