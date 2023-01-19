<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pergeraipetugas extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('login')){
            $this->session->sess_destroy();
            redirect(base_url());
            die();
        }
    }
    
    function index() {
        $this->load->library('template');
        $this->load->library('formbuilder');
        $this->load->helper('form');
        $this->load->model('m_cabang');
        
        if ($this->session->userdata('superadmin') == TRUE) {
            $a_cabang = array('' => '--SEMUA CABANG--') + $this->m_cabang->get_combo();
        }else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('ptgs_admin_cabang') == TRUE) {
            $a_cabang = $this->m_cabang->get_comboCabangCab($this->session->userdata('idcabang'));
        }else if ($this->session->userdata('ptgs_admin_grup') == TRUE) {
            $a_cabang = array('' => '--SEMUA CABANG--') + $this->m_cabang->get_comboCabangGrup($this->session->userdata('grub_id'));           
        }

        $a_format = array('html'=>'HTML', 'excel'=>'EXCEL');
        $data['formdata'][] = array('id' => 'idcabang', 'label' => 'Cabang :', 'type' => 'dropdown',  'options' => $a_cabang);
        $data['formdata'][] = array('id' => 'jenislaporan', 'label' => 'Format :', 'type' => 'dropdown',  'options' => $a_format);
        $data['formdata'][] = array('id' => 'submit', 'type' => 'submit', 'label' => 'Tampilkan', 'class' => 'pull-right');

        $data['customjs'] = '';
        $data['datavalue'] = null;
        $data['forpage']['namahalaman'] = 'Laporan Pergerai / Petugas';
        $data['forpage']['post-controller'] = 'pergeraipetugas/tampil';
        
        $this->template->load('default', 'include/form-data', $data);
    }
    
    function tampil(){
        if($this->input->post()){
            $this->load->library('template');
            $this->load->model('m_pergeraipetugas');
            $this->load->model('m_gerai');
            $this->load->model('m_cabang');
            $this->load->model('m_hari');
            
            $data['a_gerai']=$this->m_gerai->get_combo();
            $data['a_cabang']=$this->m_cabang->get_combo();
            
            $data['hari_ramadhan']=$this->m_hari->get_tgl_ramadhan();
            
            $min_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MIN');
            $max_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MAX');
            
            $data['ramadhan_sekarang']= $this->m_pergeraipetugas->get_ramadhan($min_sekarang, $max_sekarang,$this->input->post('idcabang'));
            //print_r($data['ramadhan_sekarang']);
            $this->template->load('laporan', 'v_pergeraipetugas', $data);
        }else{
            echo 'Anda belum memilih filter';
        }
    }
    

}
