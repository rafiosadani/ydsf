<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mperbulan extends CI_Model {

  public function getCabang() {
      $this->db->select('*');
      $this->db->from('cabang');
      $this->db->order_by('id_cab','ASC');
      return $this->db->get()->result();
  }

  public function getCabangCab() {
      $this->db->select('*');
      $this->db->from('cabang');
      $this->db->where('id_cab', $this->session->userdata('idcab'));
      $this->db->order_by('id_cab','ASC');
      return $this->db->get()->result();
  }

  public function getCabangGrup() {
      $this->db->select('*');
      $this->db->from('cabang');
      $this->db->where('id_group', $this->session->userdata('idgrup'));
      $this->db->order_by('id_cab','ASC');
      return $this->db->get()->result();
  }

  public function getProgram(){
      $this->db->select('PROG,NM_PROGRAM');
      $this->db->from('program');
      $this->db->group_by('PROG');
      return $this->db->get()->result();
  }

  public function allPrognCab($tahun){
      $this->db->select('BLN,SUM(T_DNT) AS T_DNT,SUM(T_DNS) AS T_DNS,SUM(TT_DNT-L_DNT) AS H_DNT,SUM(TT_DNS) AS H_DNS');
      $this->db->from('prestasi_kwsn');
      $this->db->where("THN = '".$tahun."'");
      $this->db->group_by('BLN');
      return $this->db->get()->result();
  }

  public function allCabntProg($tahun,$program){
      $this->db->select('BLN,SUM(T_DNT) AS T_DNT,SUM(T_DNS) AS T_DNS,SUM(TT_DNT-L_DNT) AS H_DNT,SUM(TT_DNS) AS H_DNS');
      $this->db->from('prestasi_kwsn');
      $this->db->where("THN = '".$tahun."'");
      $this->db->where("KODETS = '".$program."'");
      $this->db->group_by('BLN');
      return $this->db->get()->result();
  }

  public function allProgntCab($tahun,$wilayah){
    $this->db->select('BLN,SUM(T_DNT) AS T_DNT,SUM(T_DNS) AS T_DNS,SUM(TT_DNT-L_DNT) AS H_DNT,SUM(TT_DNS) AS H_DNS');
    $this->db->from('prestasi_kwsn');
    $this->db->where("THN = '".$tahun."'");
    $this->db->where("DEP = '".$wilayah."'");
    $this->db->group_by('BLN');
    return $this->db->get()->result();
  }

  public function prognCab($tahun,$wilayah,$program){
    $this->db->select('BLN,SUM(T_DNT) AS T_DNT,SUM(T_DNS) AS T_DNS,SUM(TT_DNT) AS H_DNT,SUM(L_DNT) AS L_DNT,SUM(TT_DNS) AS H_DNS');
    $this->db->from('prestasi_kwsn');
    $this->db->where("THN = '".$tahun."'");
    $this->db->where("DEP = '".$wilayah."'");
    $this->db->where("KODETS = '".$program."'");
    $this->db->group_by('BLN');
    return $this->db->get()->result();
  }
}
 ?>
