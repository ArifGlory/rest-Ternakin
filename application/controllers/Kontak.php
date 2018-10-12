<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 29/07/2018
 * Time: 22:09
 */

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Kontak extends REST_Controller
{
    function __construct($config = 'rest') {
        parent::__construct($config);
        $this->load->database();
    }

    //Menampilkan data kontak
    function index_get() {
        $id = $this->get('id');

        if ($id == '' || $id == NULL) {
            $kontak = $this->db->get('telepon')->result();

            if ($kontak){
                $this->response($kontak,200);
            }else{
                $this->response([
                    'status' => FALSE,
                    'message' => 'No data kontak were found'
                ], REST_Controller::HTTP_NOT_FOUND);
            }


        }

        // Find and return a single record for a particular user.

        $id = (int) $id;
        if ($id <= 0)
        {
            // Invalid id, set the response and exit.
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }
        // Get the user from the array, using the id as key for retrieval.
        // Usually a model is to be used for this.

        $detilKontak = NULL;

        if (!empty($kontak)){

            foreach ($kontak as $key => $value){

                if (isset($value['id']) && $value['id'] == $id){
                    $detilKontak = $value;
                }

            }
        }

        if (!empty($detilKontak)){
            $this->set_response($detilKontak,REST_Controller::HTTP_OK);
        }else{
            $this->response([
                'status' => FALSE,
                'message' => 'No data kontak were found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        /*else {
            $this->db->where('id', $id);
            $kontak = $this->db->get('telepon')->result();
        }
        $this->response($kontak, 200);*/


    }

    function contacts_get() {
        $this->load->model('M_Kontak');
        $id = $this->uri->segment(3);
        $kontak = $this->M_Kontak->getKontakById($id);
        //echo json_encode($kontak);
        $this->response($kontak, 200);

    }

    //Mengirim atau menambah data kontak baru
    function index_post()
    {
        $data = array(
            'id' => $this->post('id'),
            'nama' => $this->post('nama'),
            'nomor' => $this->post('nomor'));
        $insert = $this->db->insert('telepon', $data);
        if ($insert) {
            $this->response($data, 200);
        } else {
            $this->response(array('status' => 'fail', 502));
        }
    }

}