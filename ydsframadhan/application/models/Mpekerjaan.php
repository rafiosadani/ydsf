<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Mpekerjaan extends CI_Model {

	private $table = "pekerjaan";
 
	public function getPekerjaan(){
		$this->db->select('*');
		$this->db->from('pekerjaan');
		return $this->db->get()->result();
	}
  
	public function Lastid(){
		$this->db->select('*');
		$this->db->from('pekerjaan');
		$this->db->order_by('PEKERJAAN',desc);
		$this->db->limit('1');
		return $this->db->get()->result();
	}
	
	public function insertPekerjaan(){
		$object = array(
			'PEKERJAAN'        => $this->input->post('pekerjaan'),
			'NM_PEKERJAAN'        => $this->input->post('nama_pekerjaan'),
		);
		$this->db->insert('pekerjaan', $object);
	}

	public function editPekerjaan($where){
		$object = array(
			'PEKERJAAN'        => $this->input->post('pekerjaan'),
			'NM_PEKERJAAN'        => $this->input->post('nama_pekerjaan'),
		);
		return $this->db->update('pekerjaan', $object, $where);
	}

	public function deletePekerjaan($pekerjaan){
		return $this->db->delete($this->table, array("PEKERJAAN"=> $pekerjaan));
	}

	public function pekerjaan($pekerjaan){
		$this->db->select('*');
		$this->db->from('pekerjaan');
		$this->db->where('PEKERJAAN',$pekerjaan);
		return $this->db->get()->result();

	}

}

 ?>
