<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_donatur extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mr_donatur');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
      if ($this->session->userdata('admin') == TRUE) {
        if ($this->session->userdata('superadmin') == TRUE) {
            $data['noid'] = "";
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE || $this->session->userdata('hak') == TRUE || $this->session->userdata('admin_grup') == TRUE) {
            $kodej = $this->session->userdata('ses_kodej');
            $data['noid'] = $this->mr_donatur->getNoidCabangGroup($kodej);
        }
          $this->load->view('rekap_donatur',$data);
      }
    }

}
 ?>
