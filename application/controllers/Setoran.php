<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Setoran extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('msetoran');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        
          if ($this->session->userdata('superadmin') == TRUE) {
              $data['jungut'] = $this->msetoran->getAll();
          } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
              $idCabang = $this->session->userdata('idcab');
              $data['jungut'] = $this->msetoran->getJgtCabang($idCabang);
          } else if ($this->session->userdata('admin_grup') == TRUE) {
              $idGrup = $this->session->userdata('idgrup');
              $data['jungut'] = $this->msetoran->getJgtGrup($idGrup);
          } else{
            $id = $this->session->userdata('ses_kodej');
            $data['jungut'] = $this->msetoran->getUser($id);
        }
            $this->load->view('setoran',$data);
    }

    public function rekapSetoran(){
        $kodej=$this->input->post('jungut');
        $tanggal = explode(" - ", $this->input->post('tgl'));
        if($this->input->post('tgl') != ""){
        $data['date'] = array(
            'tanggal1' => $tanggal[0],
            'tanggal2' => $tanggal[1]
        );
        }else{
            $data['date'] = array(
                'tanggal1' => '0000-00-00',
                'tanggal2' => '0000-00-00'
            );  
        }
        $data['setoran']=$this->msetoran->getSetoran($kodej,$data['date']['tanggal1'],$data['date']['tanggal2']);
        $data['program']=$this->msetoran->getProgram($kodej,$data['date']['tanggal1'],$data['date']['tanggal2']);
        $data['petugas']=$this->msetoran->getPtgs();
        $this->load->view('rekap_setoran',$data);
    }

}