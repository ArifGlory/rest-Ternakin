<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 09/09/2018
 * Time: 12:26
 */
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;
class Login extends REST_Controller
{
    var $gallerypath;
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
        $this->load->library(array('session','encryption'));
        //$this->load->model('Model_User');
    }

    function getCheckAdmin_get($id){
        $cek = $this->db->get_where('admin',array('username'=>$id))->num_rows();
        $this->response($cek, 200);
    }

    function getDataAdmin_get($id){
        $result = $this->db->get_where('admin',array('username'=>$id))->result();
        $this->response($result, 200);
    }

    function getCheckPeternak_post(){
        $dataEmail = $this->input->post();
        $email = $dataEmail['email'];

        $cek = $this->db->get_where('peternak',array('email'=>$email))->num_rows();
        $this->response($cek, 200);
    }

    function getDataPeternak_post(){
        $dataEmail = $this->input->post();
        $email = $dataEmail['email'];

        $result = $this->db->get_where('peternak',array('email'=>$email))->result();
        $this->response($result, 200);
    }

    function getCheckInvestor_post(){
        $dataEmail = $this->input->post();
        $email = $dataEmail['email'];

        $cek = $this->db->get_where('investor',array('email'=>$email))->num_rows();
        $this->response($cek, 200);
    }

    function getDataInvestor_post(){
        $dataEmail = $this->input->post();
        $email = $dataEmail['email'];

        $result = $this->db->get_where('investor',array('email'=>$email))->result();
        $this->response($result, 200);
    }

}