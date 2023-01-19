<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_hari extends CI_Model {
    
    function get_tgl_ramadhan(){
        $this->db->select('hari, tgl_sekarang, tgl_kemarin');
        $query = $this->db->get('rmd_hari');
        $this->db->where("tgl_sekarang <>", '0000-00-00');
        $this->db->or_where("tgl_kemarin <>", '0000-00-00');
        $result=$query->result();
        //echo $this->db->last_query();
        $tgl_ramadhan=array();
        foreach ($result as $row)
        {
             $tgl_ramadhan[$row->hari]['tgl_sekarang']=$row->tgl_sekarang;
             $tgl_ramadhan[$row->hari]['tgl_kemarin']=$row->tgl_kemarin;
        }
        return $tgl_ramadhan;
    }
    
    function get_hari_ramadhan($kolom, $jenis){
        $this->db->select("$jenis($kolom) as tgl");
        $this->db->where("$kolom <>", '0000-00-00');
        $query = $this->db->get('rmd_hari');
        $result=$query->row();
        return $result->tgl;
    }
    
    function get_tahun_ramadhan($kolom){
        $this->db->select(" YEAR(MIN($kolom)) as tgl");
        $this->db->where("$kolom <>", '0000-00-00');
        $query = $this->db->get('rmd_hari');
        $result=$query->row();
        return $result->tgl;
    }
}

?>