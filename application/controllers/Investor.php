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
        $this->load->model('M_Proyek');
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
        $topup = $this->M_Investor->getTopUpById($idTopup)->result();
        $saldoInvestor = $investor[0]->saldo_wallet;
        $emailInvestor = $investor[0]->email;
        $namaInvestor = $investor[0]->namaInvestor;
        $saldoNow = $saldoInvestor + $saldoTopup;

        $result = $this->M_Investor->terimaValidasiTopup($idTopup,$idInvestor,$saldoNow);
        if ($result) {
            $this->response($data['idProyek'], 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }

        //kriim notifikasi Email.
        /*
        $data['namaInvestor'] = $namaInvestor;

        $notif = $this->load->view('invoice_new',$topup,TRUE);

        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "tapiskuy3@gmail.com";
        $config['smtp_pass'] = "qwerty12345.";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $this->email->initialize($config);

        $from_email = "tapiskuy3@gmail.com";
        $emailInvestor= 'arifglory46@gmail.com' ;

        $this->email->from($from_email,"Admin Ternak.in");
        $this->email->to($emailInvestor);
        $this->email->subject('Verifikasi Topup');
        $this->email->message($notif);
        $this->email->send();
        $this->load->view('invoice_new',$topup);

        */
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

    function prosesSimpanInvestasi_post(){
        $data = $this->input->post();
        $idProyek = $data['id_proyek'];
        $idInvestor = $data['idInvestor'];
        $proyek = $this->M_Proyek->getProyekById($idProyek)->result();
        $investor = $this->M_Investor->getInvestorById($idInvestor)->result();

        $saldoProyek = (int) $proyek[0]->saldo_proyek;;
        $jmlInvest = (int) $data['jml_invest'];
        $saldoUpdate = $saldoProyek + $jmlInvest;

        $jmlInvestorProyek = (int) $proyek[0]->jml_investor;
        $jmlInvestorProyek = $jmlInvestorProyek + 1;

        $saldoInvestor = (int) $investor[0]->saldo_wallet;
        $saldoInvestorUpdate = $saldoInvestor - $jmlInvest;

        //update saldo proyek
        $this->M_Proyek->updateSaldoProyek($saldoUpdate,$idProyek);

        //update jml investor proyek
        $this->M_Proyek->updateJmlInvestorProyek($jmlInvestorProyek,$idProyek);

        //update pengurangan saldo investor
        $this->M_Investor->updateSaldoInvestor($saldoInvestorUpdate,$idInvestor);

        //simpan detail investasi
        $this->M_Investor->simpanDetailInvestasi($data);
        $this->response( 200);
    }

}