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
                    'pswd' => $password
                );

                $this->load->model('m_user');
                $datauser = $this->m_user->cek_login($where);

                if (!$datauser) {
                    $this->session->set_flashdata('error', 'Login gagal, cek username dan password!');
                } else {
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
                    redirect(base_url('home'));
                    die();
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

    public function ubah_password() {
        if($this->session->userdata('tipeuser') != "A" && $this->session->userdata('tipeuser') != "P"){
            redirect(base_url());
            die();
        }
        $this->load->library('template');
        $this->load->library('formbuilder');
        $this->load->helper('form');
        $this->load->model('m_user');

        $id=$this->session->userdata('iduser');
        $data['datavalue'] = $this->m_user->get_one('id_user, namauser, username, password, email, tipeuser, status', $id);
        
        //form
        $data['formdata'][] = array('id' => 'passwordlama', 'type' => 'password', 'label' => 'Password Lama:', 'validation' => 'required|trim|callback_oldpassword_check');
        $data['formdata'][] = array('id' => 'passwordbaru', 'type' => 'password', 'label' => 'Password Baru:', 'validation' => 'required|trim|matches[password]');
        $data['formdata'][] = array('id' => 'password', 'type' => 'password', 'label' => 'Ulangi Password Baru:', 'validation' => 'required|trim|matches[passwordbaru]');
        $data['formdata'][] = array('id' => 'submit', 'type' => 'submit', 'label' => 'Simpan', 'class' => 'pull-right', );

        $data['forpage']['namahalaman'] = "Ganti Password";
        $data['forpage']['post-controller'] = "auth/ubah-password";
        $data['forpage']['list-controller'] = "";
        $data['forpage']['breadcrumb'] = array();

        //taruh di atas form supaya bisa ambil form_error
        if ($this->input->post()) {
            $this->load->library('valid');
            
            //untuk tambahan data di belakang layar
            $datacustom = array(); //user session
            //untuk menghilangkan inputan dan tidak ikut ter insert
            $exception = array('submit','passwordlama','passwordbaru');

            $result_valid = $this->valid->update($data['formdata'], 'm_user', 'edit-password', $datacustom, $exception,$data['datavalue']);

            if ($result_valid['status_proses']) {
                $this->session->set_flashdata('info', 'Berhasil merubah password!');
                redirect($data['forpage']['post-controller']);
            }else 
                $this->session->set_flashdata('error', 'Gagal merubah password!');
            
            if($result_valid['form']);

            //overide form untuk message
            $data['formdata'] = $result_valid['form'];
            $data['datavalue'] = $result_valid['datavalue'];
        }

        $this->template->load('default', 'include/form-data', $data);
    }
    
    public function oldpassword_check($old_password){
        
        if($this->session->userdata('tipeuser') != "A" && $this->session->userdata('tipeuser') != "P"){
            $this->form_validation->set_message('oldpassword_check', 'Anda tidak memiliki akses!');
            return FALSE;
        }else{
            $this->load->model('m_user');
            $id=$this->session->userdata('iduser');
            
            $old_password_hash = md5($this->config->item('salt1').$old_password.$this->config->item('salt2'));
            $old_password_db_hash = $this->m_user->get_one('password',$id)['password'];

            if($old_password_hash != $old_password_db_hash)
            {
               $this->form_validation->set_message('oldpassword_check', 'Isian "Password Lama :" Password lama tidak cocok!');
               return FALSE;
            } 
            return TRUE;
        }
     }

}
