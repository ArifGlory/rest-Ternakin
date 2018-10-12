<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 22/08/2018
 * Time: 16:52
 */
class M_Proyek extends CI_Model
{
    var $table = "proyek";
    var $table_detail = "detail_proyek";
    var $table_gambar = "tbl_gambar";

    function listProyek(){
        $this->db->where('status',1);
        $data = $this->db->get($this->table);
        return $data;
    }

    function listWaiting(){
        $this->db->where('status',0);
        $data = $this->db->get($this->table);
        return $data;
    }

    function getProyekById($id){
        $this->db->from($this->table);
        $this->db->where('id_proyek',$id);
        $query = $this->db->get();

        return $query;
    }

    function getProyekByPeternak($idPeternak){
        $this->db->from($this->table);
        $this->db->where('idPeternak',$idPeternak);
        $query = $this->db->get();

        return $query;
    }

    function getProyekByInvestor($idInvestor){
        $this->db->from($this->table_detail);
        $this->db->where('idInvestor',$idInvestor);
        $query = $this->db->get();

        return $query;
    }

    function getListProyekById($idProyek){

    }

    function simpanGambarProyek($data){
        $this->db->insert($this->table_gambar,$data);
    }

    function simpanProyek($data){
        $this->db->insert($this->table,$data);
    }

    function getImgProyekById($id){
        $this->db->from($this->table_gambar);
        $this->db->where('id_proyek',$id);
        $query = $this->db->get();

        return $query;
    }

    function getImgProyekUtamaById($id){
        $this->db->where('id_proyek',$id);
        $this->db->group_by('id_proyek');
        $query = $this->db->get($this->table_gambar);
        return $query;
    }

        function getAllImgUtama(){
        $this->db->group_by('id_proyek');
        $query = $this->db->get($this->table_gambar);
        return $query;
    }

    function terimaValidasiProyek($idProyek){
        $dataUbah = array(
            'status'=>1
        );
        $this->db->where('id_proyek',$idProyek);
        $this->db->update($this->table,$dataUbah);
        return $this->db->affected_rows();
    }

    function tolakValidasiProyek($idProyek){
        $this->db->where('id_proyek',$idProyek);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
}