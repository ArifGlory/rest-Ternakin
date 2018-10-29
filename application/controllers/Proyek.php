<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 22/08/2018
 * Time: 17:02
 */

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Proyek extends REST_Controller
{
    var $gallerypath;
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('form_validation','pagination','session'));
        $this->load->model('M_Proyek');
        $this->load->model('M_Investor');
    }

    function jmlListProyek_get(){
        $jumlah_data = $this->M_Proyek->listProyek()->num_rows();
        $this->response($jumlah_data, 200);
    }

    function listProyek_get(){
        $proyek = $this->M_Proyek->listProyek()->result();
        $this->response($proyek, 200);
    }

    function listProyekSelesai_get(){
        $proyek = $this->M_Proyek->listProyekSelesai()->result();
        $this->response($proyek, 200);
    }

    function detailProyek_get($id){
        $proyek = $this->M_Proyek->getProyekById($id)->result();
        $this->response($proyek, 200);
    }

    function getJmlInvestor_get($id){
        $jmlInvestor = $this->M_Proyek->getJmlInvestorProyek($id)->num_rows();
        $this->response($jmlInvestor, 200);
    }

    function getProyekPeternak_get($idPeternak){
        $proyek = $this->M_Proyek->getProyekByPeternak($idPeternak)->result();
        $this->response($proyek, 200);
    }


    function getProyekInvestor_get($idInvestor){
        $proyek = $this->M_Proyek->getProyekByInvestor($idInvestor)->result();
        $this->response($proyek, 200);
    }

    function getListProyekById_get($idProyek){
        $proyek = $this->M_Proyek->getListProyekById($idProyek)->result();
        $this->response($proyek, 200);
    }

    function listWaiting_get(){
        $waiting = $this->M_Proyek->listWaiting()->result();
        $this->response($waiting, 200);
    }

    function prosesSimpanGambar_post(){
        $data = $this->input->post();
        $this->M_Proyek->simpanGambarProyek($data);
        $this->response($data, 200);
    }

    function prosesSimpanProyek_post(){
        $data = $this->input->post();
        $this->M_Proyek->simpanProyek($data);
        $this->response($data, 200);
    }

    function getImgProyekByID_get($id){
        $data =  $this->M_Proyek->getImgProyekById($id)->result();
        $this->response($data, 200);
    }

    function getImgUtamaProyekByID_get($id){
        $data =  $this->M_Proyek->getImgProyekUtamaById($id)->result();
        $this->response($data, 200);
    }

    function getAllImgUtama_get(){
        $data =  $this->M_Proyek->getAllImgUtama()->result();
        $this->response($data, 200);
    }

    function terimaVerifikasi_post(){
        $data = $this->input->post();
        print_r($data['idProyek']);


        $result = $this->M_Proyek->terimaValidasiProyek($data['idProyek']);
        if ($result) {
            $this->response($data['idProyek'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        $this->response( 200);

    }

    function tolakVerifikasi_post(){
        $data = $this->input->post();
        $result = $this->M_Proyek->tolakValidasiProyek($data['idProyek']);
        if ($result) {
            $this->response($data['idProyek'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        $this->response( 200);
    }

    function ubahStatusProyek_post(){
        $data = $this->input->post();
        $status = $data['status'];
        $idProyek = $data['idProyek'];

        $result = $this->M_Proyek->updateStatusProyek($idProyek,$status);
        if ($result) {
            $this->response($data['idProyek'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        $this->response( 200);
    }

    function proyekBerakhir_post(){
        $data = $this->input->post();
        $keuntungan = $data['keuntungan'];
        $keuntungan = (int) $keuntungan;
        $idProyek = $data['idProyek'];
        $jatahAllInvestor = 60/100 * $keuntungan;

        //----------- ubahkeuntunganProyek
        $this->M_Proyek->updateKeuntunganProyek($idProyek,$keuntungan);


        $investor = $this->M_Proyek->getInvestorProyek($idProyek)->result();
        $proyek = $this->M_Proyek->getProyekById($idProyek)->result();
        foreach ($proyek as $c){
            $targetDana = $c->target_dana;
        }

        //-------------- bagikanReturnofInvestment ke Investor
        $jmlInvest = 0;
        foreach ($investor as $b) {
            $persentaseKeikutsertaan = ($b->jml_invest / $targetDana) * 100;
            print_r("Persentase Keikutsertaan : ");
            print_r($persentaseKeikutsertaan);
            print_r("% | dan jatahInvestorIni : ");
            $returnInvestor = $persentaseKeikutsertaan * $jatahAllInvestor / 100;
            print_r($returnInvestor);
            print_r("\n ");

            //update Return Invest
            $this->M_Investor->updateReturnInvest($b->idDetailInvestasi,$returnInvestor);

            //update saldo wallet Investor
            $investorPerson = $this->M_Investor->getInvestorById($b->idInvestor)->result();
            foreach ($investorPerson as $c){
                $saldoInvestor = $c->saldo_wallet;
            }
            $saldoUpdate = $saldoInvestor + $returnInvestor;
            $this->M_Investor->updateSaldoInvestor($saldoUpdate,$b->idInvestor);
            print_r("Saldo Update : ");
            print_r($saldoUpdate);
            print_r("\n ");
            print_r("\n ");



            $jmlInvest = $jmlInvest + $b->jml_invest;
        }
        print_r("\n ");
        print_r("Total Investasi : ");
        print_r($jmlInvest);


        //------------ update status ke proyek berakhir
        $status = 4;
        $this->M_Proyek->updateStatusProyek($idProyek,$status);

        $this->response( 200);
    }

}