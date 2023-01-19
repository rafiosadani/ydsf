<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gagal_kwitansi extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->model('m_ggkwitansi');
      $this->load->model('mpage');
      if ($this->session->userdata('login') != TRUE) {
          redirect(base_url());
      }
  }

  public function index() {
      if ($this->session->userdata('admin') == TRUE) {
          if ($this->session->userdata('superadmin') == TRUE) {
              $data['jungut'] = $this->mpage->getAll();
          } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
              $data['jungut'] = $this->mpage->getAllTwo($this->session->userdata('idcab'));
          } else if ($this->session->userdata('admin_grup') == TRUE) {
              $data['jungut'] = $this->mpage->getAllFour($this->session->userdata('idgrup'));
          }
          $this->load->view('gagal_kwitansi', $data);
      } else {
          redirect(base_url());
      }
  }

  public function validasiGagal(){
    if ($this->session->userdata('admin') == TRUE) {
      //parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
      $noslip = $_GET['noslip'];
      $data['ggKwitansi'] = $this->m_ggkwitansi->getValidasi($noslip);
      $this->load->view('rekap_validasi_gagal_kwitansi', $data);
    }else {
      redirect(base_url());
    }
  }


  public function cetakRekap(){
    if ($this->session->userdata('admin') == TRUE) {
      //parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
      $jungut = $_GET['jungut'];
      if ($jungut == '-') {
      $tgl = explode(' - ', $this->input->get('tgl'));
      $data['ggKwitansi'] = $this->m_ggkwitansi->getGagalAll($tgl[0],$tgl[1]);
      $this->load->view('rekap_gagal_kwitansi', $data);
      } else {
      $jungut = $_GET['jungut'];
      $tgl = explode(' - ', $this->input->get('tgl'));
      $data['ggKwitansi'] = $this->m_ggkwitansi->getGagal($jungut,$tgl[0],$tgl[1]);
      $this->load->view('rekap_gagal_kwitansi', $data);
      }
    }else {
      redirect(base_url());
    }
}

  public function getData() {
      $tgl = explode(' - ', $this->input->get('date'));
      // $this->session->set_userdata('tgl', $this->input->get('date'));
      $this->session->set_userdata('kodej', $this->input->get('kodej'));
      if ($this->input->get('kodej') == '-') {
          $data = $this->m_ggkwitansi->getGagalAll($tgl[0],$tgl[1]);
      } else {
          list($jungut,$nm_jungut) = explode('|', $this->input->get('kodej'));
          $data = $this->m_ggkwitansi->getGagal($jungut, $tgl[0],$tgl[1]);
      }
      echo json_encode($data);
  }
}
 ?>
