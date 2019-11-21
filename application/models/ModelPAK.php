<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use SIPAK\Entities\PAK;

class ModelPAK extends CI_Model {
	function $tentukanPenilai($idPAK, $nomor, $idPenilai){
	}
	function fetchPAK($search="", $status=null, $page=1, $limit=20){
	}
	function fetchPAKDosen($idDosen, $search="", $page=1, $limit=20){
	}
	function fetchPAKPenilai($idPenilai, $search="", $page=1, $limit=20){
	}
	function submitPenilaiPAK($idPAK){
	}
	function getPenilai($idPAK){//?
	}
	function inputHasilSidangPAK($idPAK, $setuju, $urlSK){
	}
	function submitPAK($idPAK){
	}
	function submitPenilaianPAK($idPAK, $nomor){
	}
	function getPAK($idPAK){
		
	}
	function simpanPAK($pak, $itemPenilaian){
	}
	function simpanPenilaian($penilaian){
	}
	
}