<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mlaporantunai extends CI_Model
{
	public function getAll() {
		$this->db->select('*');
		$this->db->from('sec_users');
		$this->db->where('kodej > 0');
		$this->db->where("lapangan = 'A'");
		$query = $this->db->get()->result();
		return $query;
	}

	public function getAllTwo($idcabang) {
		$this->db->select('*');
		$this->db->from('sec_users');
		$this->db->where('kodej > 0');
		$this->db->where("lapangan = 'A'");
		$this->db->where("idcabang = $idcabang");
		$query = $this->db->get()->result();
		return $query;
	}

	public function getAllTree($idgrup) {
		$this->db->select('*');
		$this->db->from('sec_users');
		$this->db->where('kodej > 0');
		$this->db->where("lapangan = 'A'");
		$this->db->where("group_id = $idgrup");
		$query = $this->db->get()->result();
		return $query;
	}

	public function getPerJungut($kodej) {
		$this->db->select('*');
		$this->db->from('sec_users');
		$this->db->where('kodej > 0');
		$this->db->where("lapangan = 'A'");
		$this->db->where("kodej = $kodej");
		$query = $this->db->get()->row();
		return $query;
	}

	public function getCount() {
		$post = $this->input->post();
		$this->db->select('count(*) as total');
		$this->db->from('keu_tunai');
		$this->db->where(["kodej" => $post["kodej"]]);
		return $this->db->get()->row();
	}

	public function getPrltot($tgl1, $tgl2) {
		$post = $this->input->post();
		$this->db->select('keu_tunai.*, name');
		$this->db->from('keu_tunai');
		$this->db->join('sec_users', 'keu_tunai.kodej = sec_users.kodej');
		$this->db->where(["keu_tunai.kodej" => $post["kodej"]]);
		$this->db->where("keu_tunai.tgl_val >= '".$tgl1."'");
		$this->db->where("keu_tunai.tgl_val <= '".$tgl2."'");
		return $this->db->get()->result();
	}

	public function getPtgs() {
		$post = $this->input->post();
		$this->db->select('name,kodej');
		$this->db->from('sec_users');
		$this->db->where(["kodej" => $post["kodej"]]);
		$query = $this->db->get()->row();
		return $query;
	}

	// public function getJumlah($tgl1, $tgl2) {
	// 	$post = $this->input->post();
	// 	$this->db->select('keu_j.prog, NM_PROGRAM, sum(jml) as jumlah, noslip, entr_pegawai');
	// 	$this->db->from('keu_j');
	// 	$this->db->join('keu_tunai', 'keu_j.entr_pegawai = keu_tunai.kodej');
	// 	$this->db->join('program', 'keu_j.prog = program.PROG');
	// 	$this->db->where(["entr_pegawai" => $post["kodej"]]);
	// 	$this->db->where("keu_tunai.tgl_val >= '".$tgl1."'");
	// 	$this->db->where("keu_tunai.tgl_val <= '".$tgl2."'");
	// 	$this->db->group_by('keu_j.prog');
	// 	return $this->db->get()->result();
	// }
}