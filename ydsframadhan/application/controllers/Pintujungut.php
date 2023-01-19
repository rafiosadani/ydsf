<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pintujungut extends CI_Controller {

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
        
        //if($this->session->userdata('idpusat')==0)
            //$a_cabang = array('' => '--SEMUA CABANG--') + $this->m_cabang->get_combo();
        //else
            //$a_cabang = $this->m_cabang->get_combo($this->session->userdata('idpusat'));

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
        $data['forpage']['namahalaman'] = 'Laporan Pintu Jungut';
        $data['forpage']['post-controller'] = 'pintujungut/tampil';
        
        $this->template->load('default', 'include/form-data', $data);
    }
    
    function tampil(){
        if($this->input->post()){
            $this->load->library('template');
            $this->load->model('m_pintujungut');
            $this->load->model('m_cabang');
            $this->load->model('m_user');
            $this->load->model('m_hari');
            
            $data['a_cabang']=$this->m_cabang->get_combo();

            if($this->session->userdata('superadmin')){
                $data['a_petugas']=$this->m_user->get_petugas($this->input->post('idcabang'),2);
            }elseif ($this->session->userdata('ptgs_admin_cabang')) {
                $data['a_petugas']=$this->m_user->get_petugasCabang($this->input->post('idcabang'),2);
            }elseif ($this->session->userdata('ptgs_admin_grup')) {
                $data['a_petugas']=$this->m_user->get_petugasGrup($this->input->post('idcabang'),2);
            }
            
            $min_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MIN');
            $max_sekarang=$this->m_hari->get_hari_ramadhan('tgl_sekarang','MAX');
            $min_kemarin=$this->m_hari->get_hari_ramadhan('tgl_kemarin','MIN');
            $max_kemarin=$this->m_hari->get_hari_ramadhan('tgl_kemarin','MAX');
            
            $data['thn_sekarang']=$this->m_hari->get_tahun_ramadhan('tgl_sekarang');
            $data['thn_kemarin']=$this->m_hari->get_tahun_ramadhan('tgl_kemarin');
            
            $data['ramadhan_sekarang']= $this->m_pintujungut->get_ramadhan($min_sekarang, $max_sekarang,$this->input->post('idcabang'),'sekarang');
            $data['ramadhan_kemarin']= $this->m_pintujungut->get_ramadhan($min_kemarin, $max_kemarin,$this->input->post('idcabang'),'kemarin');
            $this->template->load('laporan', 'v_pintujungut', $data);
        }else{
            echo 'Anda belum memilih filter';
        }
    }
    

}
