<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mrkay_ramadhan extends CI_Model {

	public function getPintu(){
		$this->db->select('*');
		$this->db->from('pintu');
		return $this->db->get()->result();
	}

	public function getDataAll(){
		$this->db->select('a.id_cab as id_cab,b.nm_cabang as nm_cabang, sum(jml_rkay) as rkay_rmd, sum(jjml_kmrn) as rmd_thn_llu, sum(jjml_jln) as rmd_thn_ini');
		$this->db->from('vw_rmd_gabung a');
		$this->db->join('cabang b','a.id_cab = b.id_cab');
		if ($this->session->userdata('superadmin') == TRUE) {
                
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                $this->db->where('a.id_cab', $this->session->userdata('idcab'));
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                $this->db->where('a.id_group', $this->session->userdata('idgrup'));
            }
		$this->db->group_by('a.id_cab');
		return $this->db->get()->result();
	}

	public function getData($pintu){
		$this->db->select('a.id_cab as id_cab,b.nm_cabang as nm_cabang, sum(jml_rkay) as rkay_rmd, sum(jjml_kmrn) as rmd_thn_llu, sum(jjml_jln) as rmd_thn_ini');
		$this->db->from('vw_rmd_gabung a');
		$this->db->join('cabang b','a.id_cab = b.id_cab');
		if ($this->session->userdata('superadmin') == TRUE) {
                
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                $this->db->where('a.id_cab', $this->session->userdata('idcab'));
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                $this->db->where('a.id_group', $this->session->userdata('idgrup'));
            }
		$this->db->where('a.id_pintu', $pintu);
		$this->db->group_by('a.id_cab');
		return $this->db->get()->result();
	}

	public function getThn(){
		$this->db->select('*');
		$this->db->from('rmd_tgl');
		return $this->db->get()->result();
	}

	public function cabang(){
		$this->db->select('*');
		$this->db->from('cabang');
		return $this->db->get()->result();
	}
}
?>
