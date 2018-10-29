<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 28/08/2018
 * Time: 9:10
 */
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Peternak extends REST_Controller
{
    var $gallerypath;
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->library(array('form_validation','pagination','session'));
        $this->load->model('M_Peternak');
        $this->load->model('M_Proyek');
    }


    function detailPeternak_get($id){
        $proyek = $this->M_Peternak->getPeternakById($id)->result();
        $this->response($proyek, 200);
    }

    function getInvestorDiProyek_get($idProyek){
        $investor = $this->M_Proyek->getInvestorProyek($idProyek)->result();
        $this->response($investor, 200);
    }

}