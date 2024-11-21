<?php 

require_once(ENTITIES_DIR  . "PAK.php");
require_once(ENTITIES_DIR  . "EntriPAKDosen.php");
require_once(ENTITIES_DIR  . "EntriPAKPenilai.php");
require_once(ENTITIES_DIR  . "EntriPAKAdmin.php");
require_once(ENTITIES_DIR  . "EntriPAKBaru.php");

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelPAK extends CI_Model {
    function tentukanPenilai($idPAK, $nomor, $idPenilai){
        $nomor = escape($nomor);
        $nomor = $nomor == 1 ? 1 : 2;
        $nomorSatunya = $nomor == 1 ? 2 : 1;
        $sql = "
            UPDATE pak 
            SET id_penilai_{$nomor}=? 
            WHERE 
                id_pak=? 
                AND id_pemohon<>? 
                AND (
                    id_penilai_{$nomorSatunya} IS NULL 
                    OR id_penilai_{$nomorSatunya}<>?
                )
        ";
        $query = $this->db->query($sql, array($idPenilai, $idPAK, $idPenilai, $idPenilai));
        $result = $this->db->affected_rows() > 0;
        if(!$query || !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal memilih penilai: " . $this->db->error()["message"]
            );
        }
        $id = $this->db->insert_id();
        return array(
            "result"=>"OK",
            "idPAK"=>$idPAK,
            "idPenilai"=>$idPenilai,
            "idUser"=>$idPenilai,
            "nomor"=>$nomor
        );
    }
    function fetchPAKBaru(){
        $data = array();
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal, 
                P.id_penilai_1,
                P.id_penilai_2,
                P1.nama AS penilai_1,
                P2.nama AS penilai_2,
                (
                    CASE WHEN P.id_penilai_1 IS NOT NULL THEN 1 ELSE 0 END
                    + CASE WHEN P.id_penilai_2 IS NOT NULL THEN 1 ELSE 0 END
                ) AS rank2
            FROM jabatan JA, user D, subrumpun SR, pak P 
                LEFT JOIN user P1 ON P.id_penilai_1=P1.id_user
                LEFT JOIN user P2 ON P.id_penilai_2=P2.id_user 
            WHERE D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_status_pak=?
                AND P.id_jabatan_awal=JA.id_jabatan
            ORDER BY P.tanggal_status ASC, P.id_pak ASC";
        array_push($data, PAK::PAK_BARU);
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKBaru();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchPAKSidang(){
        $data = array();
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal
            FROM jabatan JA, user D, subrumpun SR, pak P 
            WHERE D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_status_pak=?
                AND P.id_jabatan_awal=JA.id_jabatan
            ORDER BY P.tanggal_status ASC, P.id_pak ASC";
        array_push($data, PAK::PAK_SIDANG);
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKAdmin();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    
    function fetchPAKAdminRiwayat(){
        $data = array();
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                SP.status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal,
                P.id_jabatan_tujuan,
                JT.jabatan AS jabatan_tujuan
            FROM jabatan JA, user D, subrumpun SR, pak P , status_pak SP, jabatan JT
            WHERE D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_status_pak>?
                AND P.id_jabatan_awal=JA.id_jabatan
                AND P.id_jabatan_tujuan=JT.id_jabatan
                AND P.id_status_pak=SP.id_status_pak
            ORDER BY P.tanggal_status DESC, P.id_pak DESC";
        array_push($data, PAK::PAK_BARU);
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKAdmin();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchPAKDosen($idDosen){
        $data = array();
        $sql = "
            SELECT 
                P.id_pak,
                P.tanggal_diajukan,
                P.tanggal_status,
                P.id_status_pak,
                SP.status_pak,
                P.id_jabatan_awal,
                P.id_jabatan_tujuan,
                JA.jabatan AS jabatan_awal,
                JT.jabatan AS jabatan_tujuan
            FROM jabatan JA, jabatan JT, status_pak SP, pak P 
            WHERE P.id_pemohon=?
                AND P.id_status_pak=SP.id_status_pak
                AND P.id_jabatan_awal=JA.id_jabatan
                AND P.id_jabatan_tujuan=JT.id_jabatan
            ORDER BY P.tanggal_status DESC, P.id_pak DESC";
        array_push($data, $idDosen);
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKDosen();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchPAKPenilai($idPenilai){
        $data = array();
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal
            FROM jabatan JA, user D, subrumpun SR, pak P 
            WHERE (P.id_penilai_1=? OR P.id_penilai_2=?)
                AND D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_status_pak=?
                AND P.id_jabatan_awal=JA.id_jabatan
                AND (P.id_penilai_submit IS NULL OR NOT(P.id_penilai_submit = ?)) 
            ORDER BY P.tanggal_status ASC, P.id_pak ASC";
        array_push($data, $idPenilai, $idPenilai, PAK::PAK_NILAI, $idPenilai);
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKPenilai();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    
    function fetchPAKPenilaiRiwayat($idPenilai){
        $data = array();
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                SP.status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal,
                P.id_jabatan_tujuan,
                JT.jabatan AS jabatan_tujuan
            FROM jabatan JA, USeR D, subrumpun SR, pak P , status_pak SP, jabatan JT
            WHERE (P.id_penilai_1=? OR P.id_penilai_2=?)
                AND D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND (P.id_status_pak>? OR P.id_penilai_submit = ?)
                AND P.id_jabatan_awal=JA.id_jabatan
                AND P.id_status_pak=SP.id_status_pak
                AND P.id_jabatan_tujuan=JT.id_jabatan
            ORDER BY P.tanggal_status DESC, P.id_pak DESC";
        array_push($data, $idPenilai, $idPenilai, PAK::PAK_NILAI, $idPenilai);
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKPenilai();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    
    /*
    function fetchPAKBaru($search="", $page=1, $limit=20){
        $search = escape($search);
        $offset = $limit * ($page-1);
        $searchSelect = "";
        $data = array();
        if($search != ""){
            $searchSelect = 
                ", (
                    CASE WHEN D.nama LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN SR.subrumpun LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN JA.jabatan LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN P.tanggal_status LIKE '%{$search}%' THEN 1 ELSE 0 END
                ) AS rank";
        }
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal, 
                P.id_penilai_1,
                P.id_penilai_2,
                P1.nama AS penilai_1,
                P2.nama AS penilai_2,
                (
                    CASE WHEN P.id_penilai_1 IS NOT NULL THEN 1 ELSE 0 END
                    + CASE WHEN P.id_penilai_2 IS NOT NULL THEN 1 ELSE 0 END
                ) AS rank2
                {$searchSelect}
            FROM jabatan JA, user D, subrumpun SR, pak P 
                LEFT JOIN user P1 ON P.id_penilai_1=P1.id_user
                LEFT JOIN user P2 ON P.id_penilai_2=P2.id_user 
            WHERE D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_status_pak=?
                AND P.id_jabatan_awal=JA.id_jabatan";
        array_push($data, PAK::PAK_BARU);
        if($search != ""){
            $sql = "
                SELECT *
                FROM ({$sql}) RAW
                WHERE RAW.rank > 0
                ORDER BY RAW.rank DESC, RAW.rank2 DESC, RAW.tanggal_status DESC";
        }else{
            $sql = $sql . " 
            ORDER BY P.tanggal_status DESC";
        }
        $sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKBaru();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchPAKSidang($search="", $page=1, $limit=20){
        $search = escape($search);
        $offset = $limit * ($page-1);
        $searchSelect = "";
        $data = array();
        if($search != ""){
            $searchSelect = 
                ", (
                    CASE WHEN D.nama LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN SR.subrumpun LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN JA.jabatan LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN P.tanggal_status LIKE '%{$search}%' THEN 1 ELSE 0 END
                ) AS rank";
        }
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal
                {$searchSelect}
            FROM jabatan JA, user D, subrumpun SR, pak P 
            WHERE D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_status_pak=?
                AND P.id_jabatan_awal=JA.id_jabatan";
        array_push($data, PAK::PAK_SIDANG);
        if($search != ""){
            $sql = "
                SELECT *
                FROM ({$sql}) RAW
                WHERE RAW.rank > 0
                ORDER BY RAW.rank DESC, RAW.tanggal_status DESC";
        }else{
            $sql = $sql . " 
            ORDER BY P.tanggal_status DESC";
        }
        $sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKAdmin();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchPAKDosen($idDosen, $search="", $page=1, $limit=20){
        $search = escape($search);
        $offset = $limit * ($page-1);
        $searchSelect = "";
        $data = array();
        if($search != ""){
            $searchSelect = 
                ", (
                    CASE WHEN JA.jabatan LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN JT.jabatan LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN P.tanggal_status LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN SP.status_pak LIKE '%{$search}%' THEN 1 ELSE 0 END
                ) AS rank";
        }
        $sql = "
            SELECT 
                P.id_pak,
                P.tanggal_diajukan,
                P.tanggal_status,
                P.id_status_pak,
                SP.status_pak,
                P.id_jabatan_awal,
                P.id_jabatan_tujuan,
                JA.jabatan AS jabatan_awal,
                JT.jabatan AS jabatan_tujuan
                {$searchSelect}
            FROM jabatan JA, jabatan JT, status_pak SP, pak P 
            WHERE P.id_pemohon=?
                AND P.id_status_pak=SP.id_status_pak
                AND P.id_jabatan_awal=JA.id_jabatan
                AND P.id_jabatan_tujuan=JT.id_jabatan";
        array_push($data, $idDosen);
        if($search != ""){
            $sql = "
                SELECT *
                FROM ({$sql}) RAW
                WHERE RAW.rank > 0
                ORDER BY RAW.rank DESC, RAW.tanggal_status DESC";
        }else{
            $sql = $sql . " 
            ORDER BY P.tanggal_status DESC";
        }
        $sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKDosen();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchPAKPenilai($idPenilai, $search="", $page=1, $limit=20){
        $search = escape($search);
        $offset = $limit * ($page-1);
        $searchSelect = "";
        $data = array();
        if($search != ""){
            $searchSelect = 
                ", (
                    CASE WHEN D.nama LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN SR.subrumpun LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN JA.jabatan LIKE '%{$search}%' THEN 1 ELSE 0 END
                    + CASE WHEN P.tanggal_status LIKE '%{$search}%' THEN 1 ELSE 0 END
                ) AS rank";
        }
        $sql = "
            SELECT 
                P.id_pak,
                D.nama AS pemohon,
                P.tanggal_status,
                SR.subrumpun,
                P.id_status_pak,
                P.id_jabatan_awal,
                JA.jabatan AS jabatan_awal
                {$searchSelect}
            FROM jabatan JA, user D, subrumpun SR, pak P 
            WHERE (P.id_penilai_1=? OR P.id_penilai_2=?)
                AND D.id_user=P.id_pemohon
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_status_pak=?
                AND P.id_jabatan_awal=JA.id_jabatan
                AND (P.id_penilai_submit IS NULL OR NOT(P.id_penilai_submit = ?))";
        array_push($data, $idPenilai, $idPenilai, PAK::PAK_NILAI, $idPenilai);
        if($search != ""){
            $sql = "
                SELECT *
                FROM ({$sql}) RAW
                WHERE RAW.rank > 0
                ORDER BY RAW.rank DESC, RAW.tanggal_status DESC";
        }else{
            $sql = $sql . " 
            ORDER BY P.tanggal_status DESC";
        }
        $sql = $sql . " LIMIT {$limit} OFFSET {$offset}";
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return array();
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriPAKPenilai();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    */
    function submitPenilaiPAK($idPAK){
        $sql = "
            UPDATE pak 
            SET id_status_pak=3, tanggal_status=NOW() 
            WHERE id_pak=? AND id_status_pak=2
        ";
        $query = $this->db->query($sql, array($idPAK));
        $result = $this->db->affected_rows() > 0;
        if(!$query || !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"PAK tidak ditemukan atau tidak bisa disubmit"
            );
        }
        $id = $this->db->insert_id();
        return array(
            "result"=>"OK"
        );
    }
    function submitPenilaianPAK($idPAK, $idStatus, $nilaiAkhir){
        $sql = "UPDATE pak SET id_status_pak=?, nilai_akhir=?, tanggal_status=NOW() WHERE id_pak=? AND id_status_pak=? AND id_penilai_submit > 0";
        $query = $this->db->query($sql, array($idStatus, $nilaiAkhir, $idPAK, PAK::PAK_NILAI));
        $result = $this->db->affected_rows() > 0;
        if(!$query || !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"PAK tidak ditemukan atau tidak bisa disubmit"
            );
        }
        $id = $this->db->insert_id();
        return array(
            "result"=>"OK"
        );
    }
    function submitPenilaian1PAK($idPAK, $idPenilai){
        $sql = "UPDATE pak SET id_penilai_submit=? WHERE id_pak=? AND id_status_pak=? AND (id_penilai_submit IS NULL OR id_penilai_submit = 0)";
        $query = $this->db->query($sql, array($idPenilai, $idPAK, PAK::PAK_NILAI));
        $result = $this->db->affected_rows() > 0;
        if(!$query || !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"PAK tidak ditemukan atau tidak bisa disubmit"
            );
        }
        $id = $this->db->insert_id();
        return array(
            "result"=>"OK"
        );
    }
    
    function getPAK($idPAK){
        $sql = 
            "SELECT 
                P.id_pak,
                P.id_pemohon,
                D.nama AS pemohon,
                P.id_subrumpun,
                SR.subrumpun,
                P.nilai_awal,
                P.nilai_akhir,
                P.kredit_awal,
                P.kredit_akhir,
                P.id_penilai_1,
                P.id_penilai_2,
                P1.nama AS penilai_1,
                P2.nama AS penilai_2,
                P.id_penilai_submit,
                P.tanggal_diajukan,
                P.tanggal_status,
                P.id_status_pak,
                SP.status_pak,
                P.id_jabatan_awal,
                P.id_jabatan_tujuan,
                JA.jabatan AS jabatan_awal,
                JT.jabatan AS jabatan_tujuan,
                JT.kredit AS kredit_minimal,
                P.url_sk
            FROM jabatan JA, jabatan JT, user D, subrumpun SR, status_pak SP, pak P 
                LEFT JOIN user P1 ON P.id_penilai_1=P1.id_user
                LEFT JOIN user P2 ON P.id_penilai_2=P2.id_user 
            WHERE id_pak=?
                AND P.id_status_pak=SP.id_status_pak
                AND P.id_pemohon=D.id_user
                AND P.id_subrumpun=SR.id_subrumpun
                AND P.id_jabatan_awal=JA.id_jabatan
                AND P.id_jabatan_tujuan=JT.id_jabatan;";
        $query = $this->db->query($sql, array($idPAK));
        if($query->num_rows() == 0) return null;
        $result = $query->row();
        if(!isset($result) || $result == null) return null;
        $pak = new PAK();
        $pak->read($result);
        return $pak;
    }
    /*
    function getPAK($idPAK){
        $sql = 
            "SELECT 
                P.id_pak,
                P.id_pemohon,
                D.nama AS pemohon,
                P.tanggal_diajukan,
                P.tanggal_status,
                P.id_status_pak,
                P.nilai_awal,
                P.nilai_akhir,
                SP.status_pak,
                P.id_jabatan_awal,
                P.id_jabatan_tujuan,
                JA.jabatan AS jabatan_awal,
                JT.jabatan AS jabatan_tujuan,
                P.url_sk
            FROM jabatan JA, jabatan JT, user D, status_pak SP, pak P 
            WHERE id_pak=?
                AND P.id_status_pak=SP.id_status_pak
                AND P.id_pemohon=D.id_user
                AND P.id_jabatan_awal=JA.id_jabatan
                AND P.id_jabatan_tujuan=JT.id_jabatan;";
        $query = $this->db->query($sql, array($idPAK));
        if($query->num_rows() == 0) return null;
        $result = $query->row();
        if(!isset($result) || $result == null) return null;
        $pak = new PAK();
        $pak->read($result);
        return $pak;
    }
    */
    function getPAKAktif($idDosen){
        $sql = "
            SELECT id_pak, id_status_pak 
            FROM pak 
            WHERE id_pemohon=? AND id_status_pak<=?
        ";
        $data = array($idDosen, PAK::PAK_SIDANG);
        
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return null;
        return $query->row();
    }
    
    function getJabatanTerakhir($idDosen){
        $sql = "
            SELECT id_jabatan_tujuan 
            FROM pak 
            WHERE 
                id_pemohon=? 
                AND id_status_pak=? 
            ORDER BY tanggal_status DESC LIMIT 1
        ";
        $data = array($idDosen, PAK::PAK_SELESAI);
        
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return null;
        return $query->row()->ID_JABATAN_TUJUAN;
    }
    
    function getKreditTerakhir($idDosen){
        $sql = "SELECT kredit_akhir FROM pak WHERE id_pemohon=? AND id_status_pak=? ORDER BY tanggal_status DESC LIMIT 1";
        $data = array($idDosen, PAK::PAK_SELESAI);
        
        $query = $this->db->query($sql, $data);
        if($query->num_rows() == 0) return null;
        return $query->row()->kredit_akhir;
    }
    
    function tambahPAK($pak){
        $sql = "INSERT INTO PAK(id_pemohon, id_subrumpun, id_jabatan_awal, id_jabatan_tujuan, id_status_pak, tanggal_status, kredit_awal) VALUES(?, ?, ?, ?, ?, NOW(), ?);";
        $query = $this->db->query($sql, array($pak->idDosen, $pak->idSubrumpun, $pak->idJabatanAwal, $pak->idJabatanTujuan, PAK::PAK_EDIT, $pak->kreditAwal));
        $result = $this->db->affected_rows() > 0;
        if(!$query || !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal membuat PAK: " . $this->db->error()["message"]
            );
        }
        $id = $this->db->insert_id();
        return array(
            "result"=>"OK",
            "idPAK"=>$id
        );
    }
    
    function submitPAK($idPAK, $nilai){
        
        $sql = "UPDATE pak SET id_status_pak=2, nilai_awal=?, tanggal_diajukan=NOW(), tanggal_status=NOW() WHERE id_pak=?";
        $query = $this->db->query($sql, array($nilai, $idPAK));
        $result = $this->db->affected_rows() > 0;
        if(!$query && !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal submit PAK: " . $this->db->error()["message"]
            );
        }
        return array(
            "result"=>"OK"
        );
    }
    function inputHasilSidangPAK($idPAK, $setuju, $urlSK){
        if($setuju){
            $statusPAK = PAK::PAK_SELESAI;
        }else{
            $statusPAK = PAK::PAK_TOLAK_SIDANG;
        }
        
        $sql = "
            UPDATE PAK SET 
                id_status_pak=?, 
                url_sk=?,
                kredit_akhir = (
                    CASE WHEN id_status_pak=? THEN kredit_awal+nilai_akhir ELSE kredit_awal END
                )
            WHERE id_pak=? 
                AND id_status_pak=?";
        $query = $this->db->query($sql, array($statusPAK, $urlSK, PAK::PAK_SELESAI, $idPAK, PAK::PAK_SIDANG));
        $result = $this->db->affected_rows() > 0;
        if(!$query && !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"PAK tidak ditemukan"
            );
        }
        return array(
            "result"=>"OK"
        );
    }
    
    function simpanPAK($pak){
        $sql = "UPDATE pak SET kredit_awal=? WHERE id_pak=? AND id_status_pak=?";
        $query = $this->db->query($sql, array($pak->kreditAwal, $pak->id, PAK::PAK_EDIT));
        $result = $this->db->affected_rows() > 0;
        if(!$query && !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal simpan PAK: " . $this->db->error()["message"]
            );
        }
        return array(
            "result"=>"OK"
        );
    }
}