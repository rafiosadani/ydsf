<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_user extends CI_Model {

    private $table = "sec_users";
    public $tableid = "login";

    
    function get_one($kolom,$id){
        $this->db->select($kolom);
        $this->db->limit(1);
        $this->db->where($this->tableid, $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
    function cek_login($datawhere){
        $this->db->select('login, name, email, priv_admin, idcabang, idpusat, kodej, kodep, id_pintu, id_gerai');
        $this->db->from($this->table);
        $this->db->where($datawhere);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_petugas($idcabang=''){
        $this->db->select('kodej, name');
        
        if($idcabang!='')
            $this->db->where('idcabang',$idcabang);
        
        $this->db->where('kodej<>','null');
        
        $query = $this->db->get($this->table);
        $result=$query->result();
        
        $petugas=array();
        foreach ($result as $row)
        {
             $petugas[$row->kodej]=$row->name;
        }
        return $petugas;
    }
}

?>