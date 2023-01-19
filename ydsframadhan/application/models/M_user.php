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
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where($datawhere);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    function get_petugas($cabang,$pintu){
        $this->db->select('kodej, name');
        $this->db->where('kodej<>','null');
        if($cabang!=''){
            $this->db->where('idcabang',$cabang);
        }if($pintu!=''){
            $this->db->where('id_pintu',$pintu);
        }
        $this->db->order_by('name');
        
        $query = $this->db->get($this->table);
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $petugas=array();
        foreach ($result as $row)
        {
             $petugas[$row->kodej]=$row->name;
        }
        return $petugas;
    }

    function get_petugasCabang($cabang,$pintu){
        $this->db->select('kodej, name');
        if($cabang!=''){
            $this->db->where('idcabang',$cabang);
        }if($pintu!=''){
            $this->db->where('id_pintu',$pintu);
        }
        $this->db->where('kodej<>','null');
        $this->db->order_by('name');
        
        $query = $this->db->get($this->table);
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $petugas=array();
        foreach ($result as $row)
        {
             $petugas[$row->kodej]=$row->name;
        }
        return $petugas;
    }
 
    function get_petugasGrup($cabang='',$pintu=''){
        $idgrup = $this->session->userdata('grub_id');  
        $this->db->select('kodej, name');
        if($cabang!=''){
            $this->db->where('idcabang',$cabang);
        }if($pintu!=''){
            $this->db->where('id_pintu',$pintu);
        }
        $this->db->where('group_id',$idgrup);
        $this->db->where('kodej<>','null');
        $this->db->order_by('name');
        
        $query = $this->db->get($this->table);
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $petugas=array();
        foreach ($result as $row)
        {
             $petugas[$row->kodej]=$row->name;
        }
        return $petugas;
    }

    function get_petugasUser($kodej){
        $this->db->select('kodej, name');
        $this->db->where('kodej',$kodej);
        $this->db->where('kodej<>','null');
        $this->db->order_by('name');
        
        $query = $this->db->get($this->table);
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $petugas=array();
        foreach ($result as $row)
        {
             $petugas[$row->kodej]=$row->name;
        }
        return $petugas;
    }
}

?>