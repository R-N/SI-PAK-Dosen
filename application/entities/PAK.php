<?php


class PAK{
     const PAK_EDIT = 1;
     const PAK_BARU = 2;
     const PAK_NILAI = 3;
     const PAK_SIDANG = 4;
     const PAK_TOLAK_NILAI =5;
     const PAK_TOLAK_SIDANG = 6;
     const PAK_SELESAI = 7;
    
    public $id;
    public $idDosen;
    public $dosen;
    public $idSubrumpun;
    public $subrumpun;
    public $idPenilai1 = null;
    public $idPenilai2 = null;
    public $penilai1 = null;
    public $penilai2 = null;
    public $idPenilaiSubmit = null;
    public $tanggalDiajukan = null;
    public $tanggalStatus;
    public $idStatus;
    public $status;
    public $idJabatanAwal;
    public $idJabatanTujuan;
    public $jabatanAwal;
    public $jabatanTujuan;
    public $urlSK;
    public $nilaiAwal;
    public $nilaiAkhir;
    public $kreditAwal;
    public $kreditAkhir;
    public $kreditDibutuhkan;
    
     
    public function __construct() {
        
    }
    
    public static function statusToString($idStatus){
        switch($idStatus){
            case PAK::PAK_EDIT: return "Belum disubmit";
            case PAK::PAK_BARU: return "Baru";
            case PAK::PAK_NILAI: return "Menunggu penilaian";
            case PAK::PAK_SIDANG: return "Menunggu sidang";
            case PAK::PAK_TOLAK_NILAI: return "Ditolak (nilai kurang)";
            case PAK::PAK_TOLAK_SIDANG: return "Ditolak (dalam sidang)";
            case PAK::PAK_SELESAI: return "Diterima";
            default: throw new Exception("Invalid status: " . $idStatus);
        }
    }
    
    public function setStatus($idStatus){
        $this->idStatus = $idStatus;
        $this->status = PAK::statusToString($idStatus);
    }
    
    public function getDataSimpeg(){
    }
    
     function read($queryResult){
        
        if(isset($queryResult->ID_PAK)) $this->id = $queryResult->ID_PAK;
        if(isset($queryResult->ID_PEMOHON)) $this->idDosen = $queryResult->ID_PEMOHON;
        if(isset($queryResult->PEMOHON)) $this->dosen = $queryResult->PEMOHON;
        if(isset($queryResult->ID_SUBRUMPUN)) $this->idSubrumpun = $queryResult->ID_SUBRUMPUN;
        if(isset($queryResult->SUBRUMPUN)) $this->subrumpun = $queryResult->SUBRUMPUN;
        if(isset($queryResult->ID_PENILAI_1)) $this->idPenilai1 = $queryResult->ID_PENILAI_1;
        if(isset($queryResult->ID_PENILAI_2)) $this->idPenilai2 = $queryResult->ID_PENILAI_2;
        if(isset($queryResult->PENILAI_1)) $this->penilai1 = $queryResult->PENILAI_1;
        if(isset($queryResult->PENILAI_2)) $this->penilai2 = $queryResult->PENILAI_2;
        if(isset($queryResult->ID_PENILAI_SUBMIT)) $this->idPenilaiSubmit = $queryResult->ID_PENILAI_SUBMIT;
        if(isset($queryResult->TANGGAL_DIAJUKAN)) $this->tanggalDiajukan = $queryResult->TANGGAL_DIAJUKAN;
        if(isset($queryResult->TANGGAL_STATUS)) $this->tanggalStatus = $queryResult->TANGGAL_STATUS;
        if(isset($queryResult->STATUS_PAK)) $this->status =$queryResult->STATUS_PAK;
        if(isset($queryResult->ID_STATUS_PAK)) $this->setStatus($queryResult->ID_STATUS_PAK);
        if(isset($queryResult->ID_JABATAN_AWAL)) $this->idJabatanAwal = $queryResult->ID_JABATAN_AWAL;
        if(isset($queryResult->ID_JABATAN_TUJUAN)) $this->idJabatanTujuan = $queryResult->ID_JABATAN_TUJUAN;
        if(isset($queryResult->JABATAN_AWAL)) $this->jabatanAwal = $queryResult->JABATAN_AWAL;
        if(isset($queryResult->JABATAN_TUJUAN)) $this->jabatanTujuan = $queryResult->JABATAN_TUJUAN;
        if(isset($queryResult->URL_SK)) $this->urlSK = $queryResult->URL_SK;
        if(isset($queryResult->NILAI_AWAL)) $this->nilaiAwal = $queryResult->NILAI_AWAL;
        if(isset($queryResult->NILAI_AKHIR)) $this->nilaiAkhir = $queryResult->NILAI_AKHIR;
        if(isset($queryResult->KREDIT_AWAL)) $this->kreditAwal = $queryResult->KREDIT_AWAL;
        if(isset($queryResult->KREDIT_AKHIR)) $this->kreditAkhir = $queryResult->KREDIT_AKHIR;
        if(isset($queryResult->KREDIT_MINIMAL)) $this->kreditMinimal = $queryResult->KREDIT_MINIMAL;
        
        if(isset($queryResult->id_pak)) $this->id = $queryResult->id_pak;
        if(isset($queryResult->id_pemohon)) $this->idDosen = $queryResult->id_pemohon;
        if(isset($queryResult->pemohon)) $this->dosen = $queryResult->pemohon;
        if(isset($queryResult->id_subrumpun)) $this->idSubrumpun = $queryResult->id_subrumpun;
        if(isset($queryResult->subrumpun)) $this->subrumpun = $queryResult->subrumpun;
        if(isset($queryResult->id_penilai_1)) $this->idPenilai1 = $queryResult->id_penilai_1;
        if(isset($queryResult->id_penilai_2)) $this->idPenilai2 = $queryResult->id_penilai_2;
        if(isset($queryResult->penilai_1)) $this->penilai1 = $queryResult->penilai_1;
        if(isset($queryResult->penilai_2)) $this->penilai2 = $queryResult->penilai_2;
        if(isset($queryResult->id_penilai_submit)) $this->idPenilaiSubmit = $queryResult->id_penilai_submit;
        if(isset($queryResult->tanggal_diajukan)) $this->tanggalDiajukan = $queryResult->tanggal_diajukan;
        if(isset($queryResult->tanggal_status)) $this->tanggalStatus = $queryResult->tanggal_status;
        if(isset($queryResult->status_pak)) $this->status =$queryResult->status_pak;
        if(isset($queryResult->id_status_pak)) $this->setStatus($queryResult->id_status_pak);
        if(isset($queryResult->id_jabatan_awal)) $this->idJabatanAwal = $queryResult->id_jabatan_awal;
        if(isset($queryResult->id_jabatan_tujuan)) $this->idJabatanTujuan = $queryResult->id_jabatan_tujuan;
        if(isset($queryResult->jabatan_awal)) $this->jabatanAwal = $queryResult->jabatan_awal;
        if(isset($queryResult->jabatan_tujuan)) $this->jabatanTujuan = $queryResult->jabatan_tujuan;
        if(isset($queryResult->url_sk)) $this->urlSK = $queryResult->URl_SK;
        if(isset($queryResult->nilai_awal)) $this->nilaiAwal = $queryResult->nilai_awal;
        if(isset($queryResult->nilai_akhir)) $this->nilaiAkhir = $queryResult->nilai_akhir;
        if(isset($queryResult->kredit_awal)) $this->kreditAwal = $queryResult->kredit_awal;
        if(isset($queryResult->kredit_akhir)) $this->kreditAkhir = $queryResult->kredit_akhir;
        if(isset($queryResult->kredit_minimal)) $this->kreditMinimal = $queryResult->kredit_minimal;
        
        if(isset($queryResult->id)) $this->id = $queryResult->id;
        if(isset($queryResult->idDosen)) $this->idDosen = $queryResult->idDosen;
        if(isset($queryResult->dosen)) $this->dosen = $queryResult->dosen;
        if(isset($queryResult->idSubrumpun)) $this->idSubrumpun = $queryResult->idSubrumpun;
        if(isset($queryResult->subrumpun)) $this->subrumpun = $queryResult->subrumpun;
        if(isset($queryResult->idPenilai1)) $this->idPenilai1 = $queryResult->idPenilai1;
        if(isset($queryResult->idPenilai2)) $this->idPenilai2 = $queryResult->idPenilai2;
        if(isset($queryResult->penilai1)) $this->penilai1 = $queryResult->penilai1;
        if(isset($queryResult->penilai2)) $this->penilai2 = $queryResult->penilai2;
        if(isset($queryResult->idPenilaiSubmit)) $this->idPenilaiSubmit = $queryResult->idPenilaiSubmit;
        if(isset($queryResult->tanggalDiajukan)) $this->tanggalDiajukan = $queryResult->tanggalDiajukan;
        if(isset($queryResult->tanggalStatus)) $this->tanggalStatus = $queryResult->tanggalStatus;
        if(isset($queryResult->idStatus)) $this->idStatus = $queryResult->idStatus;
        if(isset($queryResult->status)) $this->status = $queryResult->status;
        if(isset($queryResult->idJabatanAwal)) $this->idJabatanAwal = $queryResult->idJabatanAwal;
        if(isset($queryResult->idJabatanTujuan)) $this->idJabatanTujuan = $queryResult->idJabatanTujuan;
        if(isset($queryResult->jabatanAwal)) $this->jabatanAwal = $queryResult->jabatanAwal;
        if(isset($queryResult->jabatanTujuan)) $this->jabatanTujuan = $queryResult->jabatanTujuan;
        if(isset($queryResult->urlSK)) $this->urlSK = $queryResult->urlSK;
        if(isset($queryResult->nilaiAwal)) $this->nilaiAwal = $queryResult->nilaiAwal;
        if(isset($queryResult->nilaiAkhir)) $this->nilaiAkhir = $queryResult->nilaiAkhir;
        if(isset($queryResult->kreditAwal)) $this->kreditAwal = $queryResult->kreditAwal;
        if(isset($queryResult->kreditAkhir)) $this->kreditAkhir = $queryResult->kreditAkhir;
        if(isset($queryResult->kreditMinimal)) $this->kreditMinimal = $queryResult->kreditMinimal;
        return $this;
    }
    
}

?>