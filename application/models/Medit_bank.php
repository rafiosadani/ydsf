<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Medit_bank extends CI_Model {

    public function getBank(){
        $this->db->select('*');
        $this->db->from('bank');
        return $this->db->get()->result();
    }

    public function getDataSlip($noslip){
        $this->db->select('entr_pegawai,tgl_setor,bank.NM_BANK as bank,keu_j.bank as id_bank,noslip,SUM(jml) as jml');
        $this->db->from('keu_j');
        $this->db->join('bank','bank.BANK = keu_j.bank');
        $this->db->where('noslip', $noslip);
        $this->db->group_by('entr_pegawai,tgl_setor,noslip,bank');
        return $this->db->get()->result();
    }

    public function updateBank($where){
        $object = array(
            'bank'        => $this->input->post('bank'),
        );
        return $this->db->update('keu_j', $object, $where);
    }

}


/* End of file Mdonatur.php */
?>