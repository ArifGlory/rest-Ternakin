<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 03/10/2018
 * Time: 14:54
 */
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Investor extends REST_Controller
{
    var $gallerypath;
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('form_validation','pagination','session'));
        $this->load->model('M_Investor');
    }


    function detailInvestor_get($id){
        $proyek = $this->M_Investor->getInvestorById($id)->result();
        $this->response($proyek, 200);
    }

    function prosesSimpanTopUp_post(){
        $data = $this->input->post();
        $this->M_Investor->simpanTopUp($data);
        $this->response($data, 200);
    }

    function getWalletInvestor_get($idInvestor){
        $wallet = $this->M_Investor->getWalletByInvestor($idInvestor)->result();
        $this->response($wallet, 200);
    }

    function detailTopUp_get($idTopUp){
        $topup = $this->M_Investor->getTopUpById($idTopUp)->result();
        $this->response($topup, 200);
    }

    function prosesUpdateBukti_post(){
        $data = $this->input->post();
        $namaFile = $data['foto_bukti'];
        $idTopup = $data['idTopup'];

        $result = $this->M_Investor->updateBuktiTransfer($namaFile,$idTopup);
        if ($result) {
            $this->response($data['idTopup'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        $this->response( 200);
    }

    function listTopupUnverifyAdmin_get(){
        $topup = $this->M_Investor->listUnVerifiedTopupAdmin()->result();
        $this->response($topup, 200);
    }

    function listTopupVerifyAdmin_get(){
        $topup = $this->M_Investor->listVerifiedTopupAdmin()->result();
        $this->response($topup, 200);
    }

    function terimaTopup_post(){
        $data = $this->input->post();
        $idTopup = $data['idTopup'];
        $idInvestor = $data['idInvestor'];
        $saldoTopup = $data['saldoTopup'];

        $investor = $this->M_Investor->getInvestorById($idInvestor)->result();
        $saldoInvestor = $investor[0]->saldo_wallet;
        $saldoNow = $saldoInvestor + $saldoTopup;

        $result = $this->M_Investor->terimaValidasiTopup($idTopup,$idInvestor,$saldoNow);
        if ($result) {
            $this->response($data['idProyek'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        $this->response( 200);
    }

    function tolakTopup_post(){
        $data = $this->input->post();
        $idTopup = $data['idTopup'];

        $result = $this->M_Investor->tolakValidasiTopup($idTopup);
        if ($result) {
            $this->response($data['idProyek'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
        $this->response( 200);
    }

}