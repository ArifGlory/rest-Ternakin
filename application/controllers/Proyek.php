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
    }

    function jmlListProyek_get(){
        $jumlah_data = $this->M_Proyek->listProyek()->num_rows();
        $this->response($jumlah_data, 200);
    }

    function listProyek_get(){
        $proyek = $this->M_Proyek->listProyek()->result();
        $this->response($proyek, 200);
    }

    function detailProyek_get($id){
        $proyek = $this->M_Proyek->getProyekById($id)->result();
        $this->response($proyek, 200);
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
}