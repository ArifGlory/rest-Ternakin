<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 10/09/2018
 * Time: 17:39
 */
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Akun extends REST_Controller
{
    var $gallerypath;
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('form_validation','pagination','session'));
        $this->load->model('M_Peternak');
        $this->load->model('M_Investor');
    }

    function prosesSimpanPeternak_post(){
        $data = $this->input->post();
        $this->M_Peternak->simpanPeternak($data);
        $this->response($data, 200);
    }

    function prosesSimpanInvestor_post(){
        $data = $this->input->post();
        $this->M_Investor->simpanInvestor($data);
        $this->response($data, 200);
    }

    function getJmLPeternak_get(){
        $jumlah_data = $this->M_Peternak->listPeternak()->num_rows();
        $this->response($jumlah_data, 200);
    }

    function getJmLInvestor_get(){
        $jumlah_data = $this->M_Investor->listInvestor()->num_rows();
        $this->response($jumlah_data, 200);
    }

    function detailPeternak_get($idPeternak){
        $peternak = $this->M_Peternak->getPeternakById($idPeternak)->result();
        $this->response($peternak, 200);
    }

}