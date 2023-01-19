<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Percabangpintu extends CI_Controller {

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
        
        if($this->session->userdata('idcabang')==0)
            $a_cabang = array('' => '--SEMUA CABANG--') + $this->m_cabang->get_combo();
        else
            $a_cabang = $this->m_cabang->get_combo($this->session->userdata('idcabang'));
        
        $a_format = array('html'=>'HTML', 'excel'=>'EXCEL');
        $data['formdata'][] = array('id' => 'idcabang', 'label' => 'Cabang :', 'type' => 'dropdown',  'options' => $a_cabang);
        $data['formdata'][] = array('id' => 'jenislaporan', 'label' => 'Format :', 'type' => 'dropdown',  'options' => $a_format);
        $data['formdata'][] = array('id' => 'submit', 'type' => 'submit', 'label' => 'Tampilkan', 'class' => 'pull-right');

        $data['customjs'] = '';
        $data['datavalue'] = null;
        $data['forpage']['namahalaman'] = 'Laporan Percabang / perpintu';
        $data['forpage']['post-controller'] = 'percabangpintu/tampil';
        
        $this->template->load('default', 'include/form-data', $data);
    }
    
    function tampil(){
        if($this->input->post()){
            $this->load->library('template');
            $this->load->model('m_percabangpintu');
            $this->load->model('m_cabang');
            $this->load->model('m_pintu');
            $this->load->model('m_hari');
            
            $data['a_cabang']=$this->m_cabang->get_combo();
            
            $data['a_pintu']=$this->m_pintu->get_pintu();
            
            $min_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MIN');
            $max_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MAX');
            $min_kemarin=$this->m_hari->get_hari_ramadhan('tgl_kemarin','MIN');
            $max_kemarin=$this->m_hari->get_hari_ramadhan('tgl_kemarin','MAX');
            
            $data['ramadhan_sekarang']= $this->m_percabangpintu->get_ramadhan($min_sekarang, $max_sekarang,$this->input->post('idcabang'));
            $data['ramadhan_kemarin']= $this->m_percabangpintu->get_ramadhan($min_kemarin, $max_kemarin,$this->input->post('idcabang'));
            $this->template->load('laporan', 'v_percabangpintu', $data);
        }else{
            echo 'Anda belum memilih filter';
        }
    }
    

}
