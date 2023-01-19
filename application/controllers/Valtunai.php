<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Valtunai extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('mvaltunai');
        $this->load->model('mpage');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

	public function index() {
		if ($this->session->userdata('superadmin')== TRUE) {
            $data['jungut'] = $this->mvaltunai->getAll();;
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
            $data['jungut'] = $this->mvaltunai->getAllTwo($this->session->userdata('idcab'));
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['jungut'] = $this->mvaltunai->getAllTree($this->session->userdata('idgrup'));
        } else {
            $data['jungut'] = $this->mvaltunai->getPerJungut($this->session->userdata('ses_kodej'));
        }

		$this->load->view('validasi_tunai', $data);
	}

	public function getData() {
		$tgl = explode(' - ', $this->input->get('date'));
		$this->session->set_userdata('kodej',  $this->input->get('kodej'));
		$data = $this->mvaltunai->getValidasi($this->input->get('kodej'), $tgl[0], $tgl[1]);
		echo json_encode($data);
	}

	public function getDataReload() {
		$tgl = explode(' - ', $this->input->get('date'));
		$this->session->set_userdata('kodej',  $this->input->get('kodej'));
		$data = $this->mvaltunai->getValidasiReload($this->input->get('kodej'), $tgl[0], $tgl[1]);
		echo json_encode($data);
	}

	public function updateValInsert() {
		$tahun = date('Y');
		$bulan = date('m');
		$tanggal = date('d');
		$jam = date('H');
		$menit = date('i');
		$detik = date('s');
		$val_tunai = 'T'.$tahun.$bulan.$tanggal.$jam.$menit.$detik;

		$where = [
			"noslip" => $this->input->post('noslip')
		];

		$object = [
			"tgl_val" => date('Y-m-d'),
			"val_tunai" => $val_tunai
		];

		$this->mvaltunai->updateVal($object, $where);

		$databaru = [
			"nominal" => $this->input->post('nominal'),
			"usrid" => $this->session->userdata('usrid'),
			"idcabang" => $this->session->userdata('idcab'),
			"tgl_val" => date('Y-m-d'),
			"val_tunai" => $val_tunai,
			"kodej" => $this->input->post('kodej')
		];

		$data = $this->mvaltunai->addKeuTunai($databaru);
		echo json_encode($data);
	}

	public function cetakTunai($noslip) {
		if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('hak') == '0' || $this->session->userdata('hak') == '3' ) {
                $data['data'] = array(
                    "title" => "BUKTI SETORAN TUNAI",
                    "subtitle" => "",
                );
                $data['petugas'] = $this->mvaltunai->getPetugas($noslip);
                $data['petugas2'] = $this->mvaltunai->getPetugas2($noslip);
                $data['jumlah'] = $this->mvaltunai->getJumlah($noslip);
                $this->load->view('rekap_validasi_tunai', $data); 
            }
        } else {
            redirect(base_url());
        }
	}
}