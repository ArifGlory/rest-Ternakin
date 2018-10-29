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
    var $table_detail = "detail_investasi";
    var $table_gambar = "tbl_gambar";

    function listProyek(){
        $array = array('status' => 1, 'status' => 3);
        $this->db->where($array);
        $data = $this->db->get($this->table);
        return $data;
    }

    function listProyekSelesai(){
        $array = array('status' => 4);
        $this->db->where($array);
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

    function getJmlInvestorProyek($id){
        $this->db->from($this->table_detail);
        $this->db->distinct();
        $this->db->select('idInvestor');
        $this->db->where('id_proyek',$id);
        $query = $this->db->get();
        return $query;
    }

    function getInvestorProyek($idProyek){
        $this->db->from($this->table_detail);
        $this->db->distinct();
        $this->db->where('id_proyek',$idProyek);
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

    function updateSaldoProyek($saldoUpdate,$idProyek){
        $dataUbahSaldo = array(
          'saldo_proyek'=>$saldoUpdate
        );
        $this->db->where('id_proyek',$idProyek);
        $this->db->update($this->table,$dataUbahSaldo);
        return $this->db->affected_rows();
    }

    function updateStatusProyek($idProyek,$status){
        $dataUbahStatus = array(
            'status'=>$status
        );
        $this->db->where('id_proyek',$idProyek);
        $this->db->update($this->table,$dataUbahStatus);
        return $this->db->affected_rows();
    }

    function updateJmlInvestorProyek($jmlUpdate,$idProyek){
        $dataUbah = array(
            'jml_investor'=>$jmlUpdate
        );
        $this->db->where('id_proyek',$idProyek);
        $this->db->update($this->table,$dataUbah);
        return $this->db->affected_rows();
    }

    function updateKeuntunganProyek($idProyek,$keuntungan){
        $dataKeuntungan = array(
          'keuntungan'=>$keuntungan
        );

        $this->db->where('id_proyek',$idProyek);
        $this->db->update($this->table,$dataKeuntungan);
        return $this->db->affected_rows();
    }
}