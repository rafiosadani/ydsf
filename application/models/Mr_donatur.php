<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mr_donatur extends CI_Model {


  public function getNoidCabangGroup($kodej){
    $this->db->select('noid');
    $this->db->from('donaturbaru');
    $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej');
    $this->db->where('jupen', $kodej);
    return $this->db->get()->result();
  }

  public function getDatadata($noid,$tgl1,$tgl2){
    $this->db->select('a.noid, a.tanggal, a.jumlah, b.NM_PROGRAM');
    $this->db->from('history_tagihan a');
    $this->db->join('program b', 'a.prog = b.PROG');
    $this->db->where('a.noid', $noid);
    $this->db->where("a.tanggal>='".$tgl1."' and a.tanggal<='".$tgl2."'");
    return $this->db->get()->result();
  }

  public function getIdentitas($noid){
    $this->db->select('*');
    $this->db->from('donaturbaru');
    $this->db->where('noid', $noid);
    $this->db->limit('1');
    return $this->db->get()->result();
  }

}
 ?>
