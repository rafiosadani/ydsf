<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
     public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('login')){
            $this->session->sess_destroy();
            redirect(base_url());
            die();
        }
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
    public function index() {
        $this->load->library('template');
        $this->load->model('m_cabang');
        $this->load->model('m_dashboard');
            $this->load->model('m_hari');

        $min_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MIN');
        $max_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MAX');
        
        $data['a_cabang']= array('' => '--SEMUA CABANG--') + $this->m_cabang->get_combo();
        $data['perprogram']=$this->m_dashboard->get_perprogram($min_sekarang, $max_sekarang,$this->input->post('grafikprogram'));
        
        //print_r($data['perprogram']);
        
        $this->template->load('default', 'home', $data);
    }

}
