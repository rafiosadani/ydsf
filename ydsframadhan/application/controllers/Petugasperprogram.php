<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Petugasperprogram extends CI_Controller {

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
        $this->load->model('m_user');
        
        $ptgs='';
        $p='';
        //if($this->session->userdata('idpusat')!=0)
            //$cabang=$this->session->userdata('idpusat');
        
        if($this->session->userdata('superadmin')){
            $a_petugas = $this->m_user->get_petugas($ptgs,$p);
        }elseif ($this->session->userdata('ptgs_admin_cabang')) {
            $ptgs= $this->session->userdata('idcabang');
            $a_petugas = $this->m_user->get_petugasCabang($ptgs,$p);
        }elseif ($this->session->userdata('ptgs_admin_grup')) {
            $a_petugas = $this->m_user->get_petugasGrup($ptgs,$p);
        }
        
        
        $a_format = array('html'=>'HTML', 'excel'=>'EXCEL');
        $data['formdata'][] = array('id' => 'idpetugas', 'label' => 'petugas :', 'type' => 'dropdown',  'options' => $a_petugas);
        $data['formdata'][] = array('id' => 'jenislaporan', 'label' => 'Format :', 'type' => 'dropdown',  'options' => $a_format);
        $data['formdata'][] = array('id' => 'submit', 'type' => 'submit', 'label' => 'Tampilkan', 'class' => 'pull-right');

        $data['customjs'] = '';
        $data['datavalue'] = null;
        $data['forpage']['namahalaman'] = 'Laporan Per Petugas Per Program';
        $data['forpage']['post-controller'] = 'petugasperprogram/tampil';
        
        $this->template->load('default', 'include/form-data', $data);
    }
    
    function tampil(){
        if($this->input->post()){
            $this->load->library('template');
            $this->load->model('m_petugasperprogram');
            $this->load->model('m_user');
            $this->load->model('m_hari');
            
            $cabang='';
            if($this->session->userdata('idcabang')!=0)
                $cabang=$this->session->userdata('idcabang');
            $data['a_petugas']=$this->m_user->get_petugas($cabang);
            
            $min_kemarin=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MIN');
            $max_kemarin=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MAX');
            $data['thn_kemarin']=$this->m_hari->get_tahun_ramadhan('tgl_sekarang');
            
            $data['ramadhan_kemarin']= $this->m_petugasperprogram->get_ramadhan($min_kemarin, $max_kemarin,$this->input->post('idpetugas'));
            $this->template->load('laporan', 'v_petugasperprogram', $data);
        }else{
            echo 'Anda belum memilih filter';
        }
    }
    

}
