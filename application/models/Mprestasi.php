<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mprestasi extends CI_Model {

  public function getAll() {
      $this->db->select('*');
      $this->db->from('sec_users');
      $this->db->where('kodej > 0');
      $this->db->where("lapangan = 'A'");
      $this->db->group_by('kodej');
      $query = $this->db->get();
      return $query->result();
  }

  public function getJgtCabang($idcabang){
    $this->db->select('*');
    $this->db->from('sec_users');
    $this->db->where('kodej > 0');
    $this->db->where("lapangan = 'A'");
    $this->db->where(["idcabang" => $idcabang]);
    $query = $this->db->get();
    return $query->result();
  }

  public function getJgtGrup($idgrup) {
      $this->db->select('*');
      $this->db->from('sec_users');
      $this->db->where('kodej > 0');
      $this->db->where("lapangan = 'A'");
      $this->db->where(["group_id" => $idgrup]);
      $query = $this->db->get();
      return $query->result();
  }

  public function getPrst($jungut,$tahun,$bulan){
    $this->db->select('KWSN,T_DNT,T_DNS,RK,H_DNT,H_DNS,G_DNT,G_DNS,L_DNT,L_DNS,TT_DNT,TT_DNS,B_DNT,B_DNS,sum(T_DNT) as t_dnt,sum(T_DNS) as t_dns,sum(H_DNT) as h_dnt,sum(H_DNS) as h_dns,sum(G_DNT) as g_dnt,sum(G_DNS) as g_dns,sum(B_DNT) as b_dnt,sum(B_DNS) as b_dns,sum(L_DNT) as l_dnt,sum(L_DNS) as l_dns,sum(TT_DNT) as tt_dnt,sum(TT_DNS) as tt_dns');
    $this->db->from('prestasi_kwsn');
    $this->db->where("KODEJ = '".$jungut."'");
    $this->db->where("THN = '".$tahun."'");
    $this->db->where("BLN = '".$bulan."'");
    $this->db->group_by('KWSN');
    $query = $this->db->get();
    return $query->result();
  }

}

/* End of file Mprestasi.php */
