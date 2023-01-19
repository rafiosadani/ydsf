<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Validasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mvalidasi');
        $this->load->model('mpage');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
            if ($this->session->userdata('superadmin')== TRUE) {
                $data['jungut'] = $this->mpage->getAll();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                $data['jungut'] = $this->mpage->getAllTwo($this->session->userdata('idcab'));
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                $data['jungut'] = $this->mpage->getAllFour($this->session->userdata('idgrup'));
            }else {
                $data['jungut'] = $this->mpage->getPerJungut($this->session->userdata('ses_kodej'));
            }
            $this->load->view('validasi', $data);
        }



    public function getData() {
        $tgl = explode(' - ', $this->input->get('date'));
        // $this->session->set_userdata('tgl', $this->input->get('date'));
        $this->session->set_userdata('kodej', $this->input->get('kodej'));
        $data = $this->mvalidasi->getValidasi($this->input->get('kodej'), $tgl[0],$tgl[1]);
        echo json_encode($data);
    }

    public function cetakRekap($noslip = null) {
        //if ($this->session->userdata('admin') == TRUE) {
            if (!isset($noslip)) redirect(base_url('report/validasi'));
			$where = array(
				"noslip" => $noslip
            );
            $data['rekap'] = $this->mvalidasi->getPerData($noslip);
            $data['data'] = array(
                'kodej' => $this->session->userdata('kodej'),
                'noslip' => $noslip,
            );
			$this->load->view('rekap_validasi', $data);
        //} else {
        //    redirect(base_url());
        //}
    }

}

/* End of file Validasi.php */
