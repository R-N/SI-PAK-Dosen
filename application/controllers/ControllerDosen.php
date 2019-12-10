<?php

require_once(ENTITIES_DIR  . "PAK.php");
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
		$idDosen = $_SESSION['idUser'];
		$entries = $this->ModelPAK->fetchPAKDosen($idDosen);
		
		$pakAktif = $this->ModelPAK->getPAKAktif($idDosen);
		
		$data = array(
			"entries"=>$entries,
			"canCreatePAK"=>($pakAktif==null)
		);
		$this->load->view('dosen/PengajuanPAK.html', $data);
	}
	
	public function halamanPAK($idPAK){
		redirect(base_url()."pak/".$idPAK);
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
		$idDosen = $_SESSION["idUser"];
		$dosen = $this->ModelAkun->getDosen($idDosen);
		$unsurs = $this->ModelItemPenilaian->fetchUnsurPenilaian();
		
		$emptyItem = new EntriItemEditPAK();
		if($idPAK){
			$pak = $this->ModelPAK->getPAK($idPAK);
			if(!$pak || $pak->idDosen != $idDosen || $pak->idStatus > 1){
				show_404();
				return;
			}
			$items = $this->ModelItemPenilaian->fetchItemPenilaianEdit($pak->id);
			$jabatanTujuan = $this->ModelAkun->getJabatan($pak->idJabatanTujuan);
			$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($pak->idJabatanTujuan);
			
			$kreditAwal = $this->ModelPAK->getKreditTerakhir($dosen->idUser);
			$pak->canEditKredit = $kreditAwal == null;
		}else{
			$pakAktif = $this->ModelPAK->getPAKAktif($idDosen);
			if($pakAktif){
				
				if($pakAktif->ID_STATUS_PAK==1){
					redirect(base_url()."pak/{$pakAktif->ID_PAK}/edit");
				}else{
					redirect(base_url()."pak/{$pakAktif->ID_PAK}");
				}
				return;
			}
			$pak = new PAK();
			$items = array();
			$jabatanTujuan = $this->ModelAkun->getJabatan($dosen->idJabatan+1);
			$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($dosen->idJabatan+1);
			
			$this->initPAK($pak, $dosen, $jabatanTujuan);
		}
		$kekuranganKredit = max(0, $jabatanTujuan->kreditMinimal - $pak->kreditAwal);
		foreach($batasKategori as $batas){
			$batas->setKreditDibutuhkan($kekuranganKredit);
		}
		$data = array(
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
	
	public function simpanPAK(){
		if(!isDosen()){
			redirect(base_url());
			return;
		}
		$pakBaru = json_decode(json_encode($this->input->post("pak")));
		
		$this->load->model("ModelAkun");
		$this->load->model("ModelPAK");
		$this->load->model("ModelItemPenilaian");
		$idDosen = $_SESSION["idUser"];
		$dosen = $this->ModelAkun->getDosen($idDosen);
		$unsurs = $this->ModelItemPenilaian->fetchUnsurPenilaian();
		
		$emptyItem = new EntriItemEditPAK();
		if(isset($pakBaru->id) && $pakBaru->id){
			$pak = $this->ModelPAK->getPAK($pakBaru->id);
			if(!$pak || $pak->idDosen != $idDosen){
				return array(
					"result"=>"FAIL",
					"errorMessage"=>"PAK tidak ditemukan"
				);
			}
			$items = $this->ModelItemPenilaian->fetchItemPenilaianEdit($pak->id);
			$jabatanTujuan = $this->ModelAkun->getJabatan($pak->idJabatanTujuan);
		}else{
			$pak = null;
			$items = array();
			$jabatanTujuan = $this->ModelAkun->getJabatan($dosen->idJabatan+1);
		}
		
		$itemsBaru = array();
		
		if(isset($pakBaru->items)){
			$itemsBaru = $pakBaru->items;
		}
		
		
		$unsurDict = array();
		foreach($unsurs as $unsur){
			$unsurDict[$unsur->id] = $unsur;
		}
		
		if(isset($pakBaru->id) && $pakBaru->id){
			$pakBaru = (new PAK())->read($pak)->read($pakBaru);
		}else{
			$pakBaru = (new PAK())->read($pakBaru);
			$this->initPAK($pakBaru, $dosen, $jabatanTujuan);
		}
		
		$result = $this->_simpanPAK($pakBaru, $itemsBaru, $unsurDict, $items);
		if($result){
			echo json_encode($result);
			return;
		}
	}
	
	function initPAK($pak, $dosen, $jabatanTujuan){
		$pak->idDosen = $dosen->idUser;
		$pak->dosen = $dosen->nama;
		$pak->idSubrumpun = $dosen->idSubrumpun;
		$pak->subrumpun = $dosen->subrumpun;
		$pak->idJabatanAwal = $dosen->idJabatan;
		$pak->idJabatanTujuan = $jabatanTujuan->id;
		$pak->jabatanAwal = $dosen->jabatan;
		$pak->jabatanTujuan = $jabatanTujuan->jabatan;
		$pak->kreditMinimal = $jabatanTujuan->kreditMinimal;
		$kreditAwal = $this->ModelPAK->getKreditTerakhir($dosen->idUser);
		if($kreditAwal == null){
			$kreditAwal = $pak->kreditAwal;
		}
		if($kreditAwal != null){
			$pak->canEditKredit = false;
			$pak->kreditAwal = $kreditAwal;
		}else{
			$pak->canEditKredit = true;
		}
	}
	
	function _simpanPAK($pakBaru, $itemsBaru, $unsurDict, $items){
		$idDosen = $_SESSION["idUser"];
		
		$invalid = $this->validateItems($itemsBaru, $unsurDict);
		
		if($invalid){
			return $invalid;
		}
		
		if($pakBaru->kreditAwal == null || $pakBaru->kreditAwal == ""){
			return array(
				"result"=>"FAIL",
				"errorMessage"=>"Anda harus mengisi kredit sebelumnya"
			);
		}
		
		$this->db->trans_start();
		
		if(!isset($pakBaru->id) || !$pakBaru->id){
			if($this->ModelPAK->getPAKAktif($idDosen)){
				return array(
					"result"=>"FAIL",
					"errorMessage"=>"Anda sudah memiliki PAK aktif"
				);
			}
			$result = $this->ModelPAK->tambahPAK($pakBaru);
			if($result['result'] != "OK"){
				return $result;
			}else{
				$pakBaru->id = $result["idPAK"];
			}
		}else{
			$kreditAwal = $this->ModelPAK->getKreditTerakhir($idDosen);
			if(!$kreditAwal){
				$result = $this->ModelPAK->simpanPAK($pakBaru);
				if($result['result'] != "OK"){
					return $result;
				}
			}
		}
		
		$existing = array();
		foreach($itemsBaru as $itemBaru){
			$itemBaru->idPAK = $pakBaru->id;
			if($itemBaru->idItem){
				array_push($existing, $itemBaru->idItem);
				$resulti = $this->ModelItemPenilaian->simpanItemPenilaian($itemBaru);
			}else{
				$resulti = $this->ModelItemPenilaian->tambahItemPenilaian($itemBaru);
			}
			if($resulti['result'] != "OK"){
				return $resulti;
			}
		}
		
		foreach($items as $itemLama){
			if(!in_array($itemLama->idItem, $existing)){
				$resulti = $this->ModelItemPenilaian->hapusItemPenilaian($itemLama->idItem);
			}
			if($resulti['result'] != "OK"){
				return $resulti;
			}
		}
		$this->db->trans_complete();
		return array(
			"result"=>"OK",
			"idPAK" =>$pakBaru->id,
			"redirect"=>base_url()."pak/{$pakBaru->id}/edit"
		);
	}
	
	function validateItems($items, $unsurs){
		$duplicate = array();
		foreach($items as $itemBaru){
			$idUnsur = $itemBaru->idUnsur;
			$unsur = $unsurs[$idUnsur];
			$idJenisBatas = $unsur->idJenisBatas;
			if($unsur->batas && ($unsur->batas*$unsur->kreditPerItem) < $itemBaru->nilai){
				return array(
					"result"=>"FAIL",
					"errorTitle"=>"Invalid Item",
					"errorMessage"=>"Ada item melebihi batas:<br>".$this->itemToString($itemBaru, $unsur)
				);
			}
			if($itemBaru->nilai < 0){
				return array(
					"result"=>"FAIL",
					"errorTitle"=>"Invalid Item",
					"errorMessage"=>"Ada item yang bernilai negatif:<br>".$this->itemToString($itemBaru, $unsur)
				);
			}
			if(!$idJenisBatas || $idJenisBatas >= 3){
				if(array_key_exists($idUnsur, $duplicate)){
					return dupError($itemBaru, $unsur);
				}
				$duplicate[$idUnsur] = null;
			}else if ($idJenisBatas == 1 || $idJenisBatas == 2){
				$tahun = $itemBaru->tahun;
				if(array_key_exists($idUnsur, $duplicate) && array_key_exists($tahun, $duplicate[$idUnsur])){
					if($idJenisBatas==1){
						$semester = $itemBaru->semester;
						if(array_key_exists($semester, $duplicate[$idUnsur][$tahun])){
							return dupError($itemBaru, $unsur);
						}
					}else{
						return dupError($itemBaru, $unsur);
					}
				}
				
			}
			if(!array_key_exists($idUnsur, $duplicate)){
				if($idJenisBatas == 1 || $idJenisBatas == 2){
					$duplicate[$idUnsur] = array();
				}else{
					$duplicate[$idUnsur] = null;
				}
			}
			
			if($idJenisBatas == 1 || $idJenisBatas == 2){
				$tahun = $itemBaru->tahun;
				if(!array_key_exists($tahun, $duplicate[$idUnsur])){
					if($idJenisBatas == 1){
						$duplicate[$idUnsur][$tahun] = array();
					}else{
						$duplicate[$idUnsur][$tahun] = null;
					}
				}
				
				if($idJenisBatas == 1){
					$semester = $itemBaru->semester;
					if(!array_key_exists($semester, $duplicate[$idUnsur][$tahun])){
						$duplicate[$idUnsur][$tahun][$semester] = null;
					}
				}
			}else{
				$duplicate[$idUnsur] = null;
			}
			
		}
		return null;
	}
	
	function dupError($item, $unsur){
		return array(
			"result"=>"FAIL",
			"errorTitle"=>"Invalid Item",
			"errorMessage"=>"Item duplikat:<br>".$this->itemToString($item, $unsur)
		);
	}
	
	function itemToString($item, $unsur){
		return $unsur->kegiatan.
			($item->tahun?
				"({$item->tahun}".
					($item->semester?
						", ".($item->semester==1?"Ganjil":"Genap").")"
					:
						")"
					)
			:
				""
			);
	}
	
	
	public function submitPAK(){
		if(!isDosen()){
			redirect(base_url());
			return;
		}
		$pakBaru = json_decode(json_encode($this->input->post("pak")));
		
		$this->load->model("ModelAkun");
		$this->load->model("ModelPAK");
		$this->load->model("ModelItemPenilaian");
		$idDosen = $_SESSION["idUser"];
		$dosen = $this->ModelAkun->getDosen($idDosen);
		$unsurs = $this->ModelItemPenilaian->fetchUnsurPenilaian();
		
		$emptyItem = new EntriItemEditPAK();
		if(isset($pakBaru->id) && $pakBaru->id){
			$pak = $this->ModelPAK->getPAK($pakBaru->id);
			if(!$pak || $pak->idDosen != $idDosen){
				return array(
					"result"=>"FAIL",
					"errorMessage"=>"PAK tidak ditemukan"
				);
			}
			$items = $this->ModelItemPenilaian->fetchItemPenilaianEdit($pak->id);
			$jabatanTujuan = $this->ModelAkun->getJabatan($pak->idJabatanTujuan);
			$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($pak->idJabatanTujuan);
		}else{
			$pak = null;
			$items = array();
			$jabatanTujuan = $this->ModelAkun->getJabatan($dosen->idJabatan+1);
			$batasKategori = $this->ModelItemPenilaian->fetchBatasKategori($dosen->idJabatan+1);
		}
		
		$itemsBaru = array();
		
		if(isset($pakBaru->items)){
			$itemsBaru = $pakBaru->items;
		}
		
		$unsurDict = array();
		foreach($unsurs as $unsur){
			$unsurDict[$unsur->id] = $unsur;
		}
		
		if(isset($pakBaru->id) && $pakBaru->id){
			$pakBaru = (new PAK())->read($pak)->read($pakBaru);
		}else{
			$pakBaru = (new PAK())->read($pakBaru);
			$this->initPAK($pakBaru, $dosen, $jabatanTujuan);
		}
		
		$kekuranganKredit = max(0, $jabatanTujuan->kreditMinimal - $pakBaru->kreditAwal);
		foreach($batasKategori as $batas){
			$batas->setKreditDibutuhkan($kekuranganKredit);
		}
		$result = $this->_simpanPAK($pakBaru, $itemsBaru, $unsurDict, $items, $dosen);
		if($result && $result['result'] != "OK"){
			echo json_encode($result);
			return;
		}
		
		$nilaiKategori = hitungNilaiKategori($itemsBaru, $batasKategori, $unsurDict);
		
		foreach($batasKategori as $batas){
			$subtotal = $nilaiKategori["subtotals"][$batas->idKategori];
			if($batas->minimalAbs > 0 && $subtotal < $batas->minimalAbs){
				return array(
					'result'=>'FAIL',
					'errorMessage'=>'Batas minimal kategori ' . $idKategori . ' belum terpenuhi'
				);
			}
		}
		
		$total = $nilaiKategori['total'];
		
		if($total+$pakBaru->kreditAwal < $jabatanTujuan->kreditMinimal){
			echo json_encode(array(
				'result' => 'FAIL',
				'errorMessage'=>'Nilai Anda belum mencukupi: '
			));
			return;
		};
		
		
		$result1 = $this->ModelPAK->submitPAK($pakBaru->id, $total);
		if($result1['result'] != "OK"){
			echo json_encode($result1);
			return;
		}
		
		$result['nilai'] = $total;
		$result['redirect'] = base_url() . 'pak/' . $pakBaru->id;
		echo json_encode($result);
		return;
	}
	
}