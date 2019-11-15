<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	 
    public function __construct() {
        parent::__construct();
    }
	public function halamanPAKBaru(){
		$this->load->view('admin/PAKBaru.html');
	}
	
	public function halamanPreviewDraftSK(){
	}
	
	public function halamanPAKMenungguSidang(){
		$this->load->view("admin/PAKSidang.html");
	}
	
	public function halamanDaftarPenilai(){
		$this->load->view("admin/KelolaPenilai.html");
	}
	
	public function halamanFormPenilaiLuar(){
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
	 
	public function index()
	{
		redirect(base_url() . "admin/baru");
	}
}