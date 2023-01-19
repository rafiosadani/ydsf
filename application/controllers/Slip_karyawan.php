<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpSpreadSheet/vendor/autoload.php');



class Slip_karyawan extends CI_Controller {
    

    public function __construct() {
        parent::__construct();
        $this->load->model('mslipkaryawan');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        $data['tahun'] = array();
        for($tahun = 2014; $tahun <= date('Y');$tahun++){
            $data['tahun'][] = [
               "tahun" => $tahun
            ];
        }
        if ($this->session->userdata('level') == '0') {            
                $data['slip'] = $this->mslipkaryawan->getSlip();
                $data['karyawan'] = $this->mslipkaryawan->getKaryawanAll();
                $this->load->view('slip_karyawan', $data);
        } else {
            $data['slip'] = $this->mslipkaryawan->getSlip();
            $data['karyawan'] = $this->mslipkaryawan->getDataUser();
            $this->load->view('slip_karyawan', $data);
        }
    }

    public function cetakSlip(){
        $tahun=$this->input->post('tahun');
        $slip=$this->input->post('slip'); 
        $bulan=$this->input->post('bulan');
        $karyawan=$this->input->post('karyawan');
        $bulans="";
        if($bulan == '1'){
            $bulans='Januari';
        }elseif($bulan == '2'){
            $bulans='Februari';
        }elseif($bulan == '3'){
            $bulans='Maret';
        }elseif($bulan == '4'){
            $bulans='April';
        }elseif($bulan == '5'){
            $bulans='Mei';
        }elseif($bulan == '6'){
            $bulans='Juni';
        }elseif($bulan == '7'){
            $bulans='Juli';
        }elseif($bulan == '8'){
            $bulans='Agustus';
        }elseif($bulan == '9'){
            $bulans='September';
        }elseif($bulan == '10'){
            $bulans='Oktober';
        }elseif($bulan == '11'){
            $bulans='November';
        }elseif($bulan == '12'){
            $bulans='Desember';
        }
        $data['bulan']=$bulans;
        $data['tahun']=$tahun;
        $data['datakaryawan']=$this->mslipkaryawan->getData($bulan,$tahun,$slip,$karyawan)->row();
        $data['datagroupkaryawan']=$this->mslipkaryawan->getData($bulan,$tahun,$slip,$karyawan)->result();
        // $data['datadetailkaryawan']=$this->mslipkaryawan->getDetail($bulan,$tahun,$slip,$karyawan);
        $this->load->view('rekap_slipkaryawan',$data);
    }


}

/* End of file Per_petugas.php */
