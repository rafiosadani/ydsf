<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mlogin');
    }

    public function index() {
        if ($this->session->userdata('login') == TRUE) {
            redirect(base_url('dashboard'));
        }
        $this->load->view('login');
    }

    public function login() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $where = array(
            'login' => $username,
            'pswd' => $password
        );

        $check = $this->mlogin->checkAuth($where);
        if ($check->num_rows() > 0 ) {
            $data = $check->row_array();
            if ($data['active'] == 'Y') {
                if($data['priv_admin'] == 'Y') { 
                    $this->session->set_userdata('login', TRUE);
                    $this->session->set_userdata('admin', TRUE);
                    $this->session->set_userdata('admin_cabang', TRUE);
                    $this->session->set_userdata('idcab', $data['idcabang']);
                    $this->session->set_userdata('username', $data['login']);
                    $this->session->set_userdata('idgrup', $data['group_id']);
                    $this->session->set_userdata('usrid' , $data['usrid']);
                    $this->session->set_userdata('ses_name', $data['name']);
                    $this->session->set_userdata('level', $data['level']);
                    $this->session->set_userdata('ses_email', $data['email']);
                    $this->session->set_userdata('ses_kodej', $data['kodej']);
                    $this->session->set_userdata('hak', $data['hak']);
                    if($data['priv_group'] == 'Y') {
                        if ($data['idcabang'] == '0' && $data['group_id'] == '0') {
                            $this->session->set_userdata('superadmin', TRUE);
                            $this->session->set_userdata('level', $data['level']);
			   $this->session->set_userdata('hak', $data['hak']);
                        }
                    }
                    redirect(base_url('dashboard'));
                } else if($data['priv_admin'] != 'Y' && $data['priv_group'] == 'Y') {
                    $this->session->set_userdata('login', TRUE);
                    $this->session->set_userdata('admin', TRUE);
                    $this->session->set_userdata('admin_grup', TRUE);
                    $this->session->set_userdata('idcab', $data['idcabang']);
                    $this->session->set_userdata('username', $data['login']);
                    $this->session->set_userdata('idgrup', $data['group_id']);
                    $this->session->set_userdata('usrid' , $data['usrid']);
                    $this->session->set_userdata('ses_name', $data['name']);
                    $this->session->set_userdata('level', $data['level']);
                    $this->session->set_userdata('ses_email', $data['email']);
                    $this->session->set_userdata('ses_kodej', $data['kodej']);
                    $this->session->set_userdata('hak', $data['hak']);
                    redirect(base_url('dashboard'));
                } else {
					$this->session->set_userdata('hak', $data['hak']);
                    $this->session->set_userdata('login', TRUE);
                    $this->session->set_userdata('idcab', $data['idcabang']);
                    $this->session->set_userdata('username', $data['login']);
                    $this->session->set_userdata('idgrup', $data['group_id']);
                    $this->session->set_userdata('usrid' , $data['usrid']);
                    $this->session->set_userdata('level', $data['level']);
                    $this->session->set_userdata('ses_name', $data['name']);
                    $this->session->set_userdata('ses_email', $data['email']); 
                    $this->session->set_userdata('ses_kodej', $data['kodej']);
                    // $this->session->set_userdata('hak', $data['hak']);
                    // if ($data['idcabang'] == '0') {
                    //     $this->session->set_userdata('superadmin', TRUE);
                    // }
                    redirect(base_url('dashboard'));
                }
            } else {
                $this->session->set_flashdata('denied', 'akun anda tidak aktif');
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('error', 'username atau password salah');
            redirect(base_url());
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }

}
