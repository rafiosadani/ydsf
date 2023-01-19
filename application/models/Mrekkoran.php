<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mrekkoran extends CI_Model {

	public function getBank() {
		$this->db->select('*');
		$this->db->from('bank');
		return $this->db->get()->result();
	}

	public function getProgram() {
		$this->db->select('*');
		$this->db->from('program');
		return $this->db->get()->result();	
	}

	public function insertData($tgl_bank, $tgl_very, $uraian, $bank, $prog, $debet, $kredit) {
		$object = [
			"tgl_bank" => $tgl_bank,
			"tgl_very" => $tgl_very,
			"tglm" => date('Y-m-d H:i:s'),
			"uraian" => $uraian,
			"bank" => $bank,
			"prog" => $prog,
			"debet" => $debet,
			"kredit" => $kredit,
			"usrid" => $this->session->userdata('usrid'),
			"idcabang" => $this->session->userdata('idcab')
		];

		$this->db->insert('bank_koran', $object);
	}
}