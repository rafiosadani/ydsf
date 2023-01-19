<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporantunai extends CI_Controller {

	public function __construct(){
        parent::__construct();        
        $this->load->model('mlaporantunai');
        $this->load->library('form_validation');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

	public function index() {
		if ($this->session->userdata('superadmin') == TRUE) {
            $data['report'] = $this->mlaporantunai->getAll();
            $this->load->view('report_tunai', $data);
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
            $idcabang = $this->session->userdata('idcab');
            $data['report_dua'] = $this->mlaporantunai->getAllTwo($idcabang);
            $this->load->view('report_tunai', $data);
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $idgrup = $this->session->userdata('idgrup');
            $data['report_tiga'] = $this->mlaporantunai->getAllTree($idgrup);
            $this->load->view('report_tunai', $data);
        } else {
            $kodej = $this->session->userdata('ses_kodej');
            $data['report_jungut'] = $this->mlaporantunai->getPerJungut($kodej);
            $this->load->view('report_tunai', $data);
        }
	}

	public function cetakRekap() {
		$tanggal = explode(" - ", $this->input->post('date'));
        $data['date'] = array(
            'tanggal1' => $tanggal[0],
            'tanggal2' => $tanggal[1]
        );
        $data['count'] = $this->mlaporantunai->getCount();
        $data['prl'] = $this->mlaporantunai->getPrltot($tanggal[0], $tanggal[1]);
        // $data['jumlah'] = $this->mlaporantunai->getJumlah($tanggal[0], $tanggal[1]);
        $data['ptgs'] = $this->mlaporantunai->getPtgs();
        $this->load->view('rekap_tunai', $data);
	}

}