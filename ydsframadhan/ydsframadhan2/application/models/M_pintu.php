<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_pintu extends CI_Model {
    
    function get_pintu(){
        $this->db->select('id_pintu, nm_pintu');
        $query = $this->db->get('pintu');
        $result=$query->result();
        
        $pintu=array();
        foreach ($result as $row)
        {
             $pintu[$row->id_pintu]=$row->nm_pintu;
        }
        return $pintu;
    }
}

?>