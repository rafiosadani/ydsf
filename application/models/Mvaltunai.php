<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvaltunai extends CI_Model {
	public function getAll() {
		$this->db->select('sec_users.*');
		$this->db->from('sec_users');
		$this->db->where("sec_users.kodej > '0' AND sec_users.lapangan = 'A'");
		$hasil = $this->db->get()->result();
		return $hasil;
	}

	public function getAllTwo($idcabang) {
		$this->db->select('sec_users.*');
		$this->db->from('sec_users');
		$this->db->where("sec_users.kodej > '0' AND sec_users.lapangan = 'A' AND sec_users.idcabang = $idcabang");
		$hasil = $this->db->get()->result();
		return $hasil;
	}

	public function getAllTree($idgrup) {
		$this->db->select('sec_users.*');
		$this->db->from('sec_users');
		$this->db->where("sec_users.kodej > '0' AND sec_users.lapangan = 'A' AND sec_users.group_id = $idgrup");
		$hasil = $this->db->get()->result();
		return $hasil;
	}

	public function getPerJungut($kodej) {
		$this->db->select('sec_users.*');
		$this->db->from('sec_users');
		$this->db->where("sec_users.kodej > '0' AND sec_users.lapangan = 'A' AND sec_users.kodej = $kodej");
		$hasil = $this->db->get()->result();
		return $hasil;
	}

	public function getValidasi($kodej,$tgl1,$tgl2) {
        $this->db->select("noslip, entr_pegawai, sum(jml) as nominal,sec_users.name,(case when keu_j.val_tunai is NULL then 'Belum' else 'Sudah' end) as validasi");
        $this->db->from('keu_j');
      	$this->db->join('sec_users', 'sec_users.kodej = keu_j.entr_pegawai');
        $this->db->where('entr_pegawai', $kodej);
        $this->db->where("tgl_setor >= '".$tgl1."'");
        $this->db->where("tgl_setor <= '".$tgl2."'");
        $this->db->where("keu_j.bank = '0001' AND keu_j.validasi = 'y'");
        $this->db->order_by('keu_j.val_tunai', 'ASC');
        $this->db->group_by('noslip');
        return $this->db->get()->result(); 
    }

    public function getValidasiReload($kodej, $tgl1, $tgl2) {
    	$this->db->select("noslip, entr_pegawai, sum(jml) as nominal,sec_users.name,(case when keu_j.val_tunai is NULL then 'Belum' else 'Sudah' end) as validasi");
        $this->db->from('keu_j');
      	$this->db->join('sec_users', 'sec_users.kodej = keu_j.entr_pegawai');
        $this->db->where('entr_pegawai', $kodej);
        $this->db->where("tgl_setor >= '".$tgl1."'");
        $this->db->where("tgl_setor <= '".$tgl2."'");
        $this->db->where("keu_j.bank = '0001' AND keu_j.validasi = 'y'");
        $this->db->order_by('keu_j.val_tunai', 'ASC');
        $this->db->order_by('tgl_val', 'DESC');
        $this->db->group_by('noslip');
        return $this->db->get()->result();
    }

    public function updateVal($object, $where) {
    	$this->db->update('keu_j', $object, $where);
    }

    public function addKeuTunai($data) {
    	$this->db->insert('keu_tunai', $data);
    }

    public function getPetugas($noslip) {
    	$this->db->select('noslip, name, keu_tunai.tgl_val, keu_tunai.kodej, keu_tunai.val_tunai, id_tunai');
    	$this->db->from('keu_j');
    	$this->db->join('sec_users', 'keu_j.entr_pegawai = sec_users.kodej');
    	$this->db->join('keu_tunai', 'keu_j.val_tunai = keu_tunai.val_tunai');
    	$this->db->where("keu_j.noslip = $noslip");
    	return $this->db->get()->row();
    }

    public function getPetugas2($noslip) {
    	$this->db->select('name, idusr_v');
    	$this->db->from('keu_j');
    	$this->db->join('sec_users', 'keu_j.idusr_v = sec_users.usrid');
    	$this->db->where("noslip = $noslip");
    	return $this->db->get()->row();
    }

    public function getJumlah($noslip) {
    	$this->db->select('keu_j.prog, NM_PROGRAM, sum(jml) as jumlah, noslip');
    	$this->db->from('keu_j');
    	$this->db->join('program', 'keu_j.prog = program.PROG');
    	$this->db->where("noslip = $noslip");
    	$this->db->group_by('keu_j.prog');
    	return $this->db->get()->result();
    }
}