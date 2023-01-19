<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mlogin extends CI_Model {

    private $table = "sec_users";
    private $tableTwo = "cabang";

    public function checkAuth($where) {
        return $this->db->get_where($this->table, $where);
    }

    public function getAll() {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join($this->tableTwo, 'cabang.id_cab=sec_users.idcabang');
        $query = $this->db->get();
        return $query->result();
    }

}

/* End of file Mlogin.php */