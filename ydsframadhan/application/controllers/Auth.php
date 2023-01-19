<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function login() {
        $this->load->library('formbuilder');
        $this->load->library('form_validation');
        $this->load->helper('form');
        //$this->template->load('default', 'login', null);

//        $form_config=array('default_input_type' => 'form_input',
//        'default_input_container_class' => 'form-group',
//        'bootstrap_required_input_class' => 'form-control',
//        'default_dropdown_class' => 'valid',
//        'default_control_label_class' => 'col-sm-4 control-label',
//        'default_no_label_class' => 'col-sm-offset-2',
//        'default_form_control_class' => 'col-sm-12',
//        'default_form_class' => 'form-horizontal col-sm-12',
//        'default_button_classes' => 'btn btn-primary',
//        'default_date_post_addon' => '', // For instance '<span class="input-group-btn"><button class="btn default" type="button"><i class="glyphicon glyphicon-calendar"></i></button></span>'
//        'default_date_format' => 'Y-m-d',
//        'default_date_today_if_not_set' => FALSE,
//        'default_datepicker_class' => '', // For instance 'date-picker'
//        'empty_value_html' => '<div class="form-control" style="border:none;"></div>',
//        'use_testing_value' => true);
//        $this->formbuilder->init($form_config);
        
        $data['formdata'][] = array('id' => 'username', 'label' => 'Username :', 'validation' => 'trim|required|min_length[5]|max_length[100]|strip_tags', 'class' => 'validate');
        $data['formdata'][] = array('id' => 'password', 'type' => 'password', 'label' => 'Password :', 'validation' => 'trim|required|min_length[5]|max_length[100]|strip_tags');
        $data['forpage']['post-controller'] = "";

        if ($this->input->post()) {
            $this->load->library('valid');
            $hasilcek=$this->valid->cek_form($data['formdata']);
            
            if ($hasilcek['status']) {
                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $where = array(
                    'login' => $username,
                    'pswd' => $password,
                    'active'=>'Y'
                );

                $this->load->model('m_user');
                $datauser = $this->m_user->cek_login($where);

                if (!$datauser) {
                    $this->session->set_flashdata('error', 'Login gagal, cek username dan password!');
                } else {
                    //$data = $datauser->row_array();
                    if ($datauser['active'] == 'Y') {
                        if($datauser['priv_admin'] == 'Y') {
                            $data_session = array(
                                'name' => $datauser['name'],
                                'login' => $datauser['login'],
                                'priv_admin' => $datauser['priv_admin'],
                                'email' => $datauser['email'],
                                'idcabang' => $datauser['idcabang'],
                                'idpusat' => $datauser['idpusat'],
                                'kodej' => $datauser['kodej'],
                                'kodep' => $datauser['kodep'],
                                'id_pintu' => $datauser['id_pintu'],                        
                                'id_gerai' => $datauser['id_gerai'],
                            );
                            $this->session->set_userdata($data_session);
                            if($datauser['priv_group'] == 'Y' && $datauser['idcabang'] == '0' && $datauser['group_id'] == '0') {
                                $this->session->set_userdata('superadmin', TRUE);
                            }else {
                                $this->session->set_userdata('ptgs_admin_cabang', TRUE);
                            }
                            redirect(base_url('home'));
                            die(); 
                        }else if($datauser['priv_admin'] != 'Y' && $datauser['priv_group'] == 'Y') {
                            $data_session = array(
                                'name' => $datauser['name'],
                                'login' => $datauser['login'],
                                'priv_admin' => $datauser['priv_admin'],
                                'email' => $datauser['email'],
                                'idcabang' => $datauser['idcabang'],
                                'idpusat' => $datauser['idpusat'],
                                'kodej' => $datauser['kodej'],
                                'kodep' => $datauser['kodep'],
                                'id_pintu' => $datauser['id_pintu'],                        
                                'id_gerai' => $datauser['id_gerai'],
                                'grub_id' => $datauser['group_id'],
                            );
                            $this->session->set_userdata($data_session);
                            $this->session->set_userdata('ptgs_admin_grup', TRUE);
                            redirect(base_url('home'));
                            die();
                        }else{
                            $this->load->view('login', $data);
                        }
                    
                }
                    
                }
            } else {
                $data['formdata'] = $hasilcek['form'];
            }
        } else {
            if ($this->session->userdata('priv_admin')) {
                redirect(base_url('home'));
                die();
            }
        }
//print_r($data);
        $this->load->view('login', $data);
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }


}
