<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Valkasir extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mvalkasir');
        $this->load->model('mpage');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('superadmin')== TRUE) {
            $data['jungut'] = $this->mpage->getAll();
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
            $data['jungut'] = $this->mpage->getAllTwo($this->session->userdata('idcab'));
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['jungut'] = $this->mpage->getAllFour($this->session->userdata('idgrup'));
        } else {
            $data['jungut'] = $this->mpage->getPerJungut($this->session->userdata('ses_kodej'));
        }
        $data['BANK'] = $this->mvalkasir->getBank();
        $this->load->view('validasi_kasir', $data);
    }

    public function getData() {
        $tgl = explode(' - ', $this->input->get('date'));
        // $this->session->set_userdata('tgl', $this->input->get('date'));
        $this->session->set_userdata('kodej', $this->input->get('kodej'));
        $data = $this->mvalkasir->getValidasi($this->input->get('kodej'), $tgl[0],$tgl[1]);
        echo json_encode($data);
    }

    public function getDataReload() {
        $tgl = explode(' - ', $this->input->get('date'));
        // $this->session->set_userdata('tgl', $this->input->get('date'));
        $this->session->set_userdata('kodej', $this->input->get('kodej'));
        $data = $this->mvalkasir->getValidasiReload($this->input->get('kodej'), $tgl[0],$tgl[1]);
        echo json_encode($data);
    }

    public function getAction(){
        $data = $this->mvalkasir->getAction($this->input->get('id'));
        echo json_encode($data);
    }

    public function getActionTwo() {
        $data = $this->mvalkasir->getActionTwo($this->input->get('id'));
        echo json_encode($data);
    }

    public function updateVal() {
        if($this->input->post('bank')==""){

        } else {
        $where = array(
            "noslip" => $this->input->post('noslip')
        );

        $object = array(
            "bank" => $this->input->post('bank'),
            "ket" => $this->input->post('ket'),
            "no_kasir" => $this->input->post('noksr'),
            "tgl_val" => date('Y-m-d'),
            "idusr_v" => $this->session->userdata('usrid'),
            "validasi" => 'y'
        );
        
        $qrbn = $this->mvalkasir->getDntQrbn($this->input->post('noslip'));
        foreach ($qrbn as $value) {
            $date = date_create($value->tanggal);
            $dnt = array(
                "noid" => $value->noid,
                "nama" => strtoupper($value->nama),
                "almktr" => strtoupper($value->almktr),
                "telphp" => $value->telphp,
                "kwsn" => $value->kwsn,
                "kodej" => $value->kodej,
                "tanggal" => $date->format('Y-m-d'),
                "prog" => $value->prog, 
                "noslip" => $value->noslip,
                "jumlah" => $value->jumlah,
                "report_id" => $value->report_id,
                "ket" => $value->ket
            );
            $this->mvalkasir->addDntQrbn($dnt);  
        } 
        
        $data = $this->mvalkasir->addVal($object, $where);
        echo json_encode($data);
        //redirect(base_url("front-office/validasi-kasir2?jgt=$this->input->post('kodej')&&date=$this->input->post('kodej')"));
        }
    }

    public function cetakKasir($noslip) {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('hak') == '0' || $this->session->userdata('hak') == '3' ) {
                $data['data'] = array(
                    "title" => "BUKTI SETORAN ZIS",
                    "subtitle" => "",
                    "cek" => 0
                );
                $data['petugas'] = $this->mvalkasir->getPetugas($noslip);
                $data['petugas2'] = $this->mvalkasir->getPetugas2($noslip);
                $data['jumlah'] = $this->mvalkasir->getJml($noslip);
                $this->load->view('rekap_validasi_kasir', $data); 
            }
        } else {
            redirect(base_url());
        }
    }

    public function cetakBatal($noslip) {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('hak') == '0' || $this->session->userdata('hak') == '3') {
                $data['data'] = array(
                    "title" => "BUKTI SETORAN ZIS",
                    "subtitle" => "Setelah Terkoreksi",
                    "cek" => 1
                );
                $data['petugas'] = $this->mvalkasir->getPetugas($noslip);
                $data['petugas2'] = $this->mvalkasir->getPetugas2($noslip);
                $data['jumlah'] = $this->mvalkasir->getJml($noslip);
                $this->load->view('rekap_validasi_kasir', $data); 
            }
        } else {
            redirect(base_url());
        }
    }

    public function cetakKlaim($noslip) {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('hak') == '0' || $this->session->userdata('hak') == '3') {
                $data['data'] = array(
                    "title" => "BUKTI KLAIM ZIS",
                    "subtitle" => "",
                    "cek" => 1
                );
                $data['petugas'] = $this->mvalkasir->getPetugas($noslip);
                $data['petugas2'] = $this->mvalkasir->getPetugas2($noslip);
                $data['jumlah'] = $this->mvalkasir->getJml($noslip);
                $this->load->view('rekap_validasi_kasir', $data); 
            }
        } else {
            redirect(base_url());
        }
    }
}

?>