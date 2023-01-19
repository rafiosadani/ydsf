<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Slipmanual extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mslip_manual');
        $this->load->model('mpage');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE) {
                $data['bank'] = $this->mslip_manual->getBank();
                $data['jungut'] = $this->mslip_manual->getAll();
                $data['programe'] = $this->mslip_manual->getProgram();
                $data['programs'] = $this->mslip_manual->getProgram();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                $data['bank'] = $this->mslip_manual->getBank();
                $data['jungut'] = $this->mslip_manual->getAllTwo($this->session->userdata('idcab'));
                $data['programe'] = $this->mslip_manual->getProgram();
                $data['programs'] = $this->mslip_manual->getProgram();
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                $data['bank'] = $this->mslip_manual->getBank();
                $data['jungut'] = $this->mslip_manual->getAllFour($this->session->userdata('idgrup'));
                $data['programe'] = $this->mslip_manual->getProgram();
                $data['programs'] = $this->mslip_manual->getProgram();
            }
            $this->load->view('slip_manual', $data);
        } else {
            redirect(base_url());
        }
    }

    public function getData() {
        $tgl = explode(' - ', $this->input->get('date'));
        $kodej= $this->input->get('kodej');
        if($kodej == '-'){
            $query = $this->mslip_manual->getSlipAll($tgl[0],$tgl[1]);
        }else{
        // $this->session->set_userdata('tgl', $this->input->get('date'));
        $this->session->set_userdata('kodej', $this->input->get('kodej'));
        $query = $this->mslip_manual->getSlip($this->input->get('kodej'), $tgl[0],$tgl[1]);
        }
        echo json_encode($query);
    }

    public function getDataProgram() {
        $tgl = explode(' - ', $this->input->post('date'));
        $this->session->set_userdata('tgl', $this->input->post('date'));
        // $this->session->set_userdata('kodej', $this->input->get('kodej'));
        $query = $this->mslip_manual->getDataProg($this->input->post('noslip'),$tgl[0],$tgl[1]);
        echo json_encode($query);
    }

    public function insertProg(){
        $kodej= $this->input->post('kodej');
        $bank=$this->input->post('bank');
        $noslip = $this->input->post('noslip');
        $program = $this->input->post('program');
        $jumlah = $this->input->post('jumlah');
        $id_vent= $this->input->post('id_vent');
        $validasi = $this->input->post('validasi');

        // $dataProg=$this->mslip_manual->getProgSlip($noslip);

        
            // for ($x = 0, $y = count($dataProg); $x<=$y; $x++) {
                // if($dataProg[$x]['prog'] != $program){
                    // if($x == $y){
                    $data = $this->mslip_manual->insertToProg($kodej,$noslip,$program,$jumlah,$bank);
                    // }x
            //         continue;                    
            //     }
            // }


        // $data_donatur = $this->mslip_manual->getDataDonatur($noslip);
        // foreach( $data_donatur as $datas){
        //     $date=date_create($datas->tanggal);
        //     $object=array(
        //         'noid'=>$datas->noid,
        //         'nama'=>$datas->nama,
        //         'almktr'=>$datas->almktr,
        //         'telphp'=>$datas->telphp,
        //         'tanggal'=>$date->format('Y-m-d'),
        //         'kwsn'=>$datas->kwsn,
        //         'kodej'=>$datas->kodej,
        //         'prog'=>$datas->prog,
        //         'noslip'=>$datas->noslip,
        //         'jumlah'=>$datas->jumlah,
        //         'report_id'=>$datas->report_id,
        //         'ket'=>$datas->ket
        //     );
        //     $this->mslip_manual->insertToDntQ($object);
        // }
        // if( $id_vent == '2'){
        //     $data = $this->mslip_manual->insertToDntQ();
        // }
        echo json_encode($data);
    }

    public function cetakSlip($noslip){
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('hak') == '0' || $this->session->userdata('hak') == '3') {
                $data['data'] = array(
                    "title" => "BUKTI SETORAN ZIS",
                    "subtitle" => "",
                    "cek" => 0
                );
                $data['petugas'] = $this->mslip_manual->getPetugas($noslip);
                $data['petugas2'] = $this->mslip_manual->getPetugas2($noslip);
                $data['jumlah'] = $this->mslip_manual->getJml($noslip);
                $this->load->view('rekap_validasi_kasir', $data); 
            }
        } else {
            redirect(base_url());
        }
        // $this->load->view('rekap_slip_manual');
    }
    
    public function insertSlipBaru(){
        if($this->input->post('tgl_himp')==""){
            redirect(base_url());
        }elseif ($this->input->post('jungut')=="") {
            redirect(base_url());
        }elseif ($this->input->post('program')=="") {
            redirect(base_url());
        }elseif ($this->input->post('jumlah')=="") {
            redirect(base_url());
        }elseif ($this->input->post('bank')=="") {
            redirect(base_url());
        }else{
        $nokasir= $this->input->post('nokasir');
        $bank=$this->input->post('bank');
        // $noslip = $this->input->post('noslip');
        $program = $this->input->post('program');
        $jumlah = $this->input->post('jumlah');
        $id_vent= $this->input->post('id_vent');
        $keterangan = $this->input->post('keterangan');
        $jungut=$this->input->post('jungut');
        $tgl_himp=$this->input->post('tgl_himp');
        $data = $this->mslip_manual->insertToSlipbaru($nokasir,$bank,$program,$jumlah, $keterangan,$jungut,$tgl_himp);
        echo json_encode($data);
        }
    }


    // public function cetakRekap($noslip = null) {
    //     if ($this->session->userdata('admin') == TRUE) {
    //         if (!isset($noslip)) redirect(base_url('report/validasi'));
	// 		$where = array(
	// 			"noslip" => $noslip
    //         );
    //         $data['rekap'] = $this->mvalidasi->getPerData($noslip);
    //         $data['data'] = array(
    //             'kodej' => $this->session->userdata('kodej'),
    //             'noslip' => $noslip,
    //         );
	// 		$this->load->view('rekap_validasi', $data);
    //     } else {
    //         redirect(base_url());
    //     }
    // }

}

/* End of file Validasi.php */
