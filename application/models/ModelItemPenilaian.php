<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(ENTITIES_DIR  . "EntriItemPAK.php");
require_once(ENTITIES_DIR  . "EntriItemEditPAK.php");
require_once(ENTITIES_DIR  . "EntriItemDetailPAK.php");
require_once(ENTITIES_DIR  . "EntriItemNilaiPAK.php");
require_once(ENTITIES_DIR  . "EntriItemNilaiAkhirPAK.php");
require_once(ENTITIES_DIR  . "UnsurPenilaian.php");
require_once(ENTITIES_DIR  . "BatasKategori.php");

class ModelItemPenilaian extends CI_Model {
    function fetchBatasKategori($idJabatan){
        $sql = "
            SELECT * 
            FROM batas_kategori B, kategori_penilaian K 
            WHERE 
                B.ID_KATEGORI=K.ID_KATEGORI 
                AND B.ID_JABATAN=? ORDER BY B.ID_KATEGORI
        ";
        $data = array($idJabatan);
        
        $query = $this->db->query($sql, $data);
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new BatasKategori();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchUnsurPenilaian(){
        $sql = "
            SELECT * 
            FROM 
                kategori_penilaian K, 
                unsur_penilaian U 
                LEFT JOIN jenis_batas JB 
                    ON U.id_jenis_batas=JB.id_jenis_batas  
            WHERE U.id_kategori=K.id_kategori  
            ORDER BY U.id_kategori ASC, U.id_unsur ASC
        ";
        
        $query = $this->db->query($sql);
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new UnsurPenilaian();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchItemPenilaianEdit($idPAK){
        $sql = "
        SELECT 
            I.id_item, 
            I.id_pak, 
            I.id_unsur, 
            U.kegiatan, 
            U.id_kategori,
            K.kategori,
            I.url_dokumen,
            I.nilai_awal AS nilai,
            I.tahun,
            I.semester,
            U.batas,
            U.unit,
            U.id_jenis_batas,
            JB.jenis_batas,
            U.max_kredit,
            U.keterangan,
            U.bukti
        FROM kategori_penilaian K, item_penilaian I, unsur_penilaian U LEFT JOIN jenis_batas JB ON U.id_jenis_batas=JB.id_jenis_batas
        WHERE I.id_pak=?
            AND I.id_unsur=U.id_unsur
            AND U.id_kategori=K.id_kategori
        ORDER BY U.id_kategori ASC, I.id_unsur ASC, I.id_item ASC";
        $data = array($idPAK);
        $query = $this->db->query($sql, $data);
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriItemEditPAK();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function fetchItemPenilaianNilai($idPAK, $nomorPenilai){
        $sql = "
        SELECT 
            I.id_item, 
            I.id_pak, 
            I.id_unsur, 
            (CASE 
                WHEN tahun IS NULL OR tahun=0 THEN U.kegiatan
                WHEN semester IS NULL OR semester=0 THEN CONCAT(U.kegiatan, ' (', I.tahun, ')')
                ELSE CONCAT(U.kegiatan, ' (', I.tahun, ', ',
                    CASE WHEN I.semester=1 THEN 'semester ganjil' ELSE 'semester genap' END,
                ')')
            END) AS kegiatan,
            U.id_kategori,
            K.kategori,
            I.url_dokumen,
            I.nilai_awal,
            I.nilai_{$nomorPenilai} AS nilai_penilai,
            U.bukti
        FROM item_penilaian I, unsur_penilaian U, kategori_penilaian K
        WHERE I.id_pak=?
            AND I.id_unsur=U.id_unsur
            AND U.id_kategori=K.id_kategori
        ORDER BY U.id_kategori ASC, I.id_unsur ASC, I.id_item ASC";
        $data = array($idPAK);
        $query = $this->db->query($sql, $data);
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriItemNilaiPAK();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    
    function fetchItemPenilaianNilaiDict($idPAK, $nomorPenilai){
        $sql = "
        SELECT 
            I.id_item, 
            I.id_unsur, 
            (CASE 
                WHEN tahun IS NULL OR tahun=0 THEN U.kegiatan
                WHEN semester IS NULL OR semester=0 THEN CONCAT(U.kegiatan, ' (', I.tahun, ')')
                ELSE CONCAT(U.kegiatan, ' (', I.tahun, ', ',
                    CASE WHEN I.semester=1 THEN 'semester ganjil' ELSE 'semester genap' END,
                ')')
            END) AS kegiatan, 
            I.nilai_awal
        FROM item_penilaian I, unsur_penilaian U
        WHERE I.id_pak=?
            AND I.id_unsur=U.id_unsur
        ORDER BY U.id_kategori ASC, I.id_unsur ASC, I.id_item ASC";
        $data = array($idPAK);
        $query = $this->db->query($sql, $data);
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $item = $results[$i];
            $item->no = $i+1;
            $ret[$item->id_item] = $item;
        }
        return $ret;
    }
    function fetchItemPenilaian($idPAK, $nomorPenilai = null){
        $sql = "
        SELECT 
            I.id_item, 
            I.id_pak, 
            I.id_unsur, 
            (CASE 
                WHEN tahun IS NULL OR tahun=0 THEN U.kegiatan
                WHEN semester IS NULL OR semester=0 THEN CONCAT(U.kegiatan, ' (', I.tahun, ')')
                ELSE CONCAT(U.kegiatan, ' (', I.tahun, ', ',
                    CASE WHEN I.semester=1 THEN 'semester ganjil' ELSE 'semester genap' END,
                ')')
            END) AS kegiatan,
            U.id_kategori,
            K.kategori,
            I.url_dokumen,";
        if($nomorPenilai){
            $sql = $sql . "nilai_{$nomorPenilai} AS nilai,";
        }else{
            $sql = $sql . "
            (CASE WHEN P.id_status_pak>3
                THEN (I.nilai_1+I.nilai_2)*0.5
                ELSE I.nilai_awal
            END ) AS nilai,";
        }
        $sql = $sql . "
            U.bukti
        FROM pak P, item_penilaian I, unsur_penilaian U, kategori_penilaian K
        WHERE I.id_pak=?
            AND P.id_pak=I.id_pak
            AND I.id_unsur=U.id_unsur
            AND U.id_kategori=K.id_kategori
        ORDER BY U.id_kategori ASC, I.id_unsur ASC, I.id_item ASC";
        $data = array($idPAK);
        $query = $this->db->query($sql, $data);
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriItemDetailPAK();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    function getItemPenilaian($idItem){
    }
    function tambahItemPenilaian($item){
        if($item->tahun == null){
            $sql = "
                INSERT INTO item_penilaian(
                    id_pak, id_unsur, nilai_awal, url_dokumen
                ) VALUES(?, ?, ? ,?)
            ";
            $query = $this->db->query($sql, array($item->idPAK, $item->idUnsur, $item->nilai, $item->urlDokumen));
        }else if ($item->semester == null){
            $sql = "
                INSERT INTO item_penilaian(
                    id_pak, id_unsur, nilai_awal, url_dokumen, tahun
                ) VALUES(?, ?, ? ,? ,?)
            ";
            $query = $this->db->query($sql, array($item->idPAK, $item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun));
        }else{
            $sql = "
                INSERT INTO item_penilaian(
                    id_pak, id_unsur, nilai_awal, url_dokumen, tahun, semester
                ) VALUES(?, ?, ? ,? ,?, ?)
            ";
            $query = $this->db->query($sql, array($item->idPAK, $item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun, $item->semester));
        }
        $result = $this->db->affected_rows() > 0;
        if(!$query && !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal menambahkan item: " . $this->db->error()["message"]
            );
        }
        $item->idItem = $this->db->insert_id();
        return array(
            "result"=>"OK"
        );
    }
    function simpanItemPenilaian($item){
        if($item->tahun == null){
            $sql = "
                UPDATE item_penilaian 
                SET id_unsur=?, nilai_awal=?, url_dokumen=? 
                WHERE id_item=?
            ";
            $query = $this->db->query($sql, array($item->idUnsur, $item->nilai, $item->urlDokumen, $item->idItem));
        }else if ($item->semester == null){
            $sql = "
                UPDATE item_penilaian 
                SET id_unsur=?, nilai_awal=?, url_dokumen=?, tahun=? 
                WHERE id_item=?
            ";
            $query = $this->db->query($sql, array($item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun, $item->idItem));
        }else{
            $sql = "
                UPDATE item_penilaian 
                SET id_unsur=?, nilai_awal=?, url_dokumen=?, tahun=?, semester=? 
                WHERE id_item=?
            ";
            $query = $this->db->query($sql, array($item->idUnsur, $item->nilai, $item->urlDokumen, $item->tahun, $item->semester, $item->idItem));
        }
        $result = $this->db->affected_rows() > 0;
        if(!$query && !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal menyimpan item: " . $this->db->error()["message"]
            );
        }
        return array(
            "result"=>"OK"
        );
    }
    function hapusItemPenilaian($idItem){
        $sql = "DELETE FROM item_penilaian WHERE id_item=?";
        $query = $this->db->query($sql, array($idItem));
        $result = $this->db->affected_rows() > 0;
        if(!$query && !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal menghapus item: " . $this->db->error()["message"]
            );
        }
        return array(
            "result"=>"OK"
        );
    }
    
    function simpanPenilaian($idItem, $nilai, $nomorPenilai){
        if($nilai == NULL) {
            $sql = "UPDATE item_penilaian SET nilai_{$nomorPenilai}=NULL WHERE id_item=?";
            $query = $this->db->query($sql, array($idItem));
        }else{
            $sql = "UPDATE item_penilaian SET nilai_{$nomorPenilai}=? WHERE id_item=?";
            $query = $this->db->query($sql, array($nilai, $idItem));
        }
        $result = $this->db->affected_rows() > 0;
        if(!$query && !$result){
            return array(
                "result"=>"FAIL",
                "errorMessage"=>"Gagal menyimpan nilai: " . $this->db->error()["message"]
            );
        }
        return array(
            "result"=>"OK"
        );
    }
    
    function fetchItemPenilaianAkhir($idPAK){
        $sql = "
        SELECT 
            I.id_item, 
            U.id_kategori,
            I.url_dokumen,
            I.nilai_awal,
            I.nilai_1,
            I.nilai_2
        FROM item_penilaian I, unsur_penilaian U
        WHERE I.id_pak=?
            AND I.id_unsur=U.id_unsur
        ORDER BY I.id_unsur ASC";
        $data = array($idPAK);
        $query = $this->db->query($sql, $data);
        $results = $query->result();
        $len = count($results);
        $ret = array();
        for($i = 0; $i < $len; ++$i){
            $entry = new EntriItemNilaiAkhirPAK();
            $entry->read($results[$i]);
            $entry->no = $i+1;
            array_push($ret, $entry);
        }
        return $ret;
    }
    
}
?>