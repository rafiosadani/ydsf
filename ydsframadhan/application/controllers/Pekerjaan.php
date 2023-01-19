<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pekerjaan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mpekerjaan');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE) {
                $data['pekerjaan'] = $this->mpekerjaan->getPekerjaan();
                $this->load->view('pekerjaan',$data);
            }
        } else {
            redirect(base_url());
        }
	}
	
	public function baru(){
		if ($this->session->userdata('admin') == TRUE) {
			if ($this->session->userdata('superadmin') == TRUE) {
				if ($this->input->post('pekerjaan') && $this->input->post('nama_pekerjaan')) {
                    $this->mpekerjaan->insertPekerjaan();
                    redirect(base_url('setup/pekerjaan'));
				}else{
					$data['lastid'] = $this->mpekerjaan->Lastid();
					$this->load->view('add_pekerjaan',$data);
				}
			}
		}else{
			redirect(base_url());
		}
    }

    public function edit($pekerjaan=null){
        if ($this->session->userdata('admin') == TRUE) {
			if ($this->session->userdata('superadmin') == TRUE) {
                $where = array('PEKERJAAN' => $this->input->post('pekerjaan'));
				if ($this->input->post('pekerjaan') && $this->input->post('nama_pekerjaan')) {
                    $this->mpekerjaan->editPekerjaan($where);
                    redirect(base_url('setup/pekerjaan'));
				}else{
					$data['pekerjaan'] = $this->mpekerjaan->pekerjaan($pekerjaan);
					$this->load->view('edit_pekerjaan',$data);
				}
			}
		}else{
			redirect(base_url());
		}
    }

    public function deletePekerjaan($pekerjaan = null) {
        if (!isset($pekerjaan)) show_404();

        if ($this->mpekerjaan->deletePekerjaan($pekerjaan)) {
            redirect(base_url('setup/pekerjaan'));
        }
    }

}
 ?>
