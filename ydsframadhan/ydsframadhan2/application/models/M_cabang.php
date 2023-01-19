<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_cabang extends CI_Model {

    private $table = "cabang";
    public $tableid = "id_cab";

    function update($data, $id) {
        $this->db->where($this->tableid, $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->affected_rows();
    }

    function delete($id) {
        $this->db->where($this->tableid, $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }
    
    function get_one($kolom,$id){
        $this->db->select($kolom);
        $this->db->limit(1);
        $this->db->where($this->tableid, $id);
        $query = $this->db->get($this->table);
        return $query->row_array();
    }
    
    function get_combo($id_cabang='') {
        $this->db->select('id_cab, nm_cabang');
        $this->db->from($this->table);
        
        if($id_cabang!=''){
            $this->db->where('id_cab', $id_cabang);
        }
        
        $query = $this->db->get();
        //echo $this->db->last_query();
        
        $result = $query->result();
        
        $a_combo=array();
        foreach ($result as $row)
        {
             $a_combo[$row->id_cab]=$row->nm_cabang;
        }
        return $a_combo;
    }
    

}

?>