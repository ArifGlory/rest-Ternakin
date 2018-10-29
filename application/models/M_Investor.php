<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 03/10/2018
 * Time: 14:55
 */
class M_Investor extends CI_Model
{
    var $table = "investor";
    var $tbl_topup = "tbl_topup";
    var $tbl_detail_invest = "detail_investasi";

    function getInvestorById($id){
        $this->db->from($this->table);
        $this->db->where('idInvestor',$id);
        $query = $this->db->get();

        return $query;
    }

    function simpanInvestor($data){
        $this->db->insert($this->table,$data);
    }

    function simpanDetailInvestasi($data){
        $this->db->insert($this->tbl_detail_invest,$data);
    }

    function listInvestor(){
        $data = $this->db->get($this->table);
        return $data;
    }

    function simpanTopUp($data){
        $this->db->insert($this->tbl_topup,$data);
    }

    function getWalletByInvestor($id){
        $this->db->from($this->tbl_topup);
        $this->db->where('idInvestor',$id);
        $query = $this->db->get();

        return $query;
    }

    function getTopUpById($id){
        $this->db->from($this->tbl_topup);
        $this->db->where('idTopup',$id);
        $query = $this->db->get();

        return $query;
    }

    function updateBuktiTransfer($namaFile,$idTopup){
        $dataUbah = array(
            'foto_bukti'=>$namaFile
        );
        $this->db->where("idTopup",$idTopup);
        $this->db->update($this->tbl_topup,$dataUbah);
        return $this->db->affected_rows();

    }

    function listUnVerifiedTopupAdmin(){
        $this->db->where('status',0);
        $data = $this->db->get($this->tbl_topup);
        return $data;
    }

    function listVerifiedTopupAdmin(){
        $this->db->where('status',1);
        $data = $this->db->get($this->tbl_topup);
        return $data;
    }

    function terimaValidasiTopup($idTopup,$idInvestor,$saldoTopup){
        $dataUbah = array(
            'status'=>1
        );

        $dataUbahSaldo = array(
            'saldo_wallet'=>$saldoTopup
        );

        //ubah status Topup menjadi aktif
        $this->db->where('idTopup',$idTopup);
        $this->db->update($this->tbl_topup,$dataUbah);

        //ubah saldo Investor
        $this->db->where('idInvestor',$idInvestor);
        $this->db->update($this->table,$dataUbahSaldo);

        return $this->db->affected_rows();
    }

    function tolakValidasiTopup($idTopup){

        $dataUbah = array(
            'status'=>2
        );

        $this->db->where('idTopup',$idTopup);
        $this->db->update($this->tbl_topup,$dataUbah);
        return $this->db->affected_rows();
    }

    function updateSaldoInvestor($saldoUpdate,$idInvestor){
        $dataUbahSaldo = array(
            'saldo_wallet'=>$saldoUpdate
        );

        //ubah saldo Investor
        $this->db->where('idInvestor',$idInvestor);
        $this->db->update($this->table,$dataUbahSaldo);

        return $this->db->affected_rows();
    }

    function updateReturnInvest($idDetailInvest,$returnInvest){
        $dataUbahRoI = array(
          'returnInvest'=>$returnInvest
        );

        //ubah return Invest Investor
        $this->db->where('idDetailInvestasi',$idDetailInvest);
        $this->db->update($this->tbl_detail_invest,$dataUbahRoI);

        return $this->db->affected_rows();
    }

}