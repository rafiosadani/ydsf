<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit_bank extends CI_Controller {
 
    public function __construct() {
        parent::__construct();
        $this->load->model('medit_bank');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if($this->input->get('slip')){
            $data['search'] = $this->medit_bank->getDataSlip($this->input->get('slip'));
        }else{
            $data['search'] = $this->medit_bank->getDataSlip($this->input->post('noslip'));
        }
        $data['bank'] = $this->medit_bank->getBank();
        $this->load->view('edit_bank', $data);
    }


    public function bank(){
        $noslip = $this->input->post('noslip');
        $where = array('noslip' => $noslip);
        $this->medit_bank->updateBank($where);
        redirect(base_url('front-office/edit-slip-bank?slip='.$noslip));
    }
}