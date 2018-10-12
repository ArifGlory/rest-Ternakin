<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Glory
 * Date: 01/08/2018
 * Time: 15:45
 */

class M_Kontak extends CI_Model
{

var $table = "telepon";
    function getKontakById($id){
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();

        return $query->row();
    }

}