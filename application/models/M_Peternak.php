<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 28/08/2018
 * Time: 9:09
 */
class M_Peternak extends CI_Model
{
    var $table = "peternak";

    function getPeternakById($id){
        $this->db->from($this->table);
        $this->db->where('idPeternak',$id);
        $query = $this->db->get();

        return $query;
    }

    function simpanPeternak($data){
        $this->db->insert($this->table,$data);
    }

    function listPeternak(){
        $data = $this->db->get($this->table);
        return $data;
    }


}