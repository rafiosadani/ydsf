<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require('./phpSpreadSheet/vendor/autoload.php');



class Angsuran_karyawan extends CI_Controller {
    

    public function __construct() {
        parent::__construct();
        $this->load->model('mangsuran');
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
        $data['bulan']=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        if ($this->session->userdata('level') == '0') {
                $data['angsuran'] = $this->mangsuran->getAngsuran();
                $data['karyawan'] = $this->mangsuran->getKaryawanAll();            
                $this->load->view('angsuran', $data);
        } else {
            $data['angsuran'] = $this->mangsuran->getAngsuran();
            $data['karyawan'] = $this->mangsuran->getDataUser();
            $this->load->view('angsuran', $data);
        }
    }

    public function getDatas(){
        $angsuran =  $this->input->post('angsuran');
        $karyawan =  $this->input->post('karyawan');
        $tahun =  $this->input->post('tahun');

        $query=$this->mangsuran->getData($angsuran,$karyawan,$tahun);

        echo json_encode($query);
    }
    

}

/* End of file Per_petugas.php */
