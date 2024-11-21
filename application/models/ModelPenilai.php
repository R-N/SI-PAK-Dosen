<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ENTITIES_DIR  . "EntriPenilaiPAK.php");

class ModelPenilai extends CI_Model {

    function fetchPenilai(){
        $sql = "
            SELECT 
                U.id_user, 
                U.nama, 
                PL.id_subrumpun, 
                SR.subrumpun, 
                PL.id_jabatan, 
                J.jabatan, 
                U.status_user, 
                PL.asal_instansi 
            FROM 
                user U, 
                penilai_luar PL, 
                jabatan J, 
                subrumpun SR 
            WHERE 
                U.id_user=PL.id_user 
                AND PL.id_jabatan=J.id_jabatan 
                AND PL.id_subrumpun=SR.id_subrumpun 
            ORDER BY status_user DESC
        ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $len = count($result);
        for($i = 0; $i < $len; ++$i){
            $result[$i]["no"] = $i+1;
        }
        return $result;
    }
    /*
    function fetchPenilai($search, $page=1, $limit=20){
        //TODO limit prone to injection
        $offset = $limit * ($page-1);
        $sql = "
            SELECT 
                U.id_user, 
                U.nama, 
                PL.id_subrumpun, 
                SR.subrumpun, 
                PL.id_jabatan, 
                J.jabatan, 
                U.status_user, 
                PL.asal_instansi 
            FROM 
                user U, 
                penilai_luar PL, 
                jabatan J, 
                subrumpun SR 
            WHERE 
                U.id_user=PL.id_user 
                AND PL.id_jabatan=J.id_jabatan 
                AND PL.id_subrumpun=SR.id_subrumpun 
            LIMIT {$limit} OFFSET {$offset}";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $len = count($result);
        for($i = 0; $i < $len; ++$i){
            $result[$i]["no"] = ++$offset;
        }
        return $result;
    }*/
    
    function fetchPenilaiPAK(){
        $sql = "
            SELECT 
                U.id_user, 
                U.nama, 
                PL.id_subrumpun, 
                SR.subrumpun, 
                PL.id_jabatan, 
                J.jabatan, 
                PL.asal_instansi 
            FROM 
                user U, 
                penilai_luar PL, 
                jabatan J, 
                subrumpun SR 
            WHERE 
                U.id_user=PL.id_user 
                AND PL.id_jabatan=J.id_jabatan 
                AND PL.id_subrumpun=SR.id_subrumpun 
                AND U.status_user=1
        ";
        $query = $this->db->query($sql);
        $result = $query->result();
        $result2 = array();
        $no = 0;
        foreach($result as $res){
            $penilai = (new EntriPenilaiPAK())->read($res);
            $penilai->role = 1;
            $penilai->no = ++$no;
            array_push($result2, $penilai);
        }
        $this->load->model("KonektorSimpeg");
        $result = $this->KonektorSimpeg->fetchDosen();
        foreach($result as $res){
            $penilai = (new EntriPenilaiPAK())->read($res);
            $penilai->role = 3;
            $penilai->no = ++$no;
            array_push($result2, $penilai);
        }
        return $result2;
    }
    
    function suspend($idPenilai, $keterangan){
        
    }
    function activate($idPenilai){
    }
}