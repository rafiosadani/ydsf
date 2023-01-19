<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mslip_bank extends CI_Model {

  public function getAll() {
      $this->db->select('*');
      $this->db->from('sec_users');
      $this->db->where('kodej > 0');
      $this->db->where("lapangan = 'A'");
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

  public function getJgtUser($idUsr) {
    $this->db->select('*');
    $this->db->from('sec_users');
    $this->db->where('kodej > 0');
    $this->db->where("lapangan = 'A'");
    $this->db->where(["usrid" => $idUsr]);
    $query = $this->db->get();
    return $query->result();
}

  public function perJgt($jungut){
    $tanggal = explode(' - ',$this->input->post('tgl'));
    if($this->input->post('tgl') != ""){
        $tgl = array(
            '1'=> $tanggal[0],
            '2'=> $tanggal[1]
        );
        }else{
            $tgl = array(
                '1'=> '0000-00-00',
                '2'=> '0000-00-00'
            );
        }
  $where="date(tgl_setor) >= '".$tgl['1']."' and date(tgl_setor) <= '".$tgl['2']."'";
  $this->db->select('sec_users.name as name, entr_pegawai,prog,sum(jml) as total,
  sum(case when prog = 0001 then jml else 0 end) as infaq,
  sum(case when prog = 0002 then jml else 0 end) as pena,
  sum(case when prog = 0003 then jml else 0 end) as zakat,
  sum(case when prog = 0004 then jml else 0 end) as RCY,
  sum(case when prog = 0005 then jml else 0 end) as CGQ,
  sum(case when prog > 0005 then jml else 0 end) as dll');
  $this->db->from('keu_j');
  $this->db->join('sec_users','keu_j.entr_pegawai = sec_users.kodej','left');
  $this->db->where("entr_pegawai = $jungut");
  $this->db->where($where);
  $query = $this->db->get();
  return $query->result();
  }

  public function perJgtAll(){
    $tanggal = explode(' - ',$this->input->post('tgl'));
    if($this->input->post('tgl') != ""){
        $tgl = array(
            '1'=> $tanggal[0],
            '2'=> $tanggal[1]
        );
        }else{
            $tgl = array(
                '1'=> '0000-00-00',
                '2'=> '0000-00-00'
            );
        }
  $where="date(tgl_setor) >= '".$tgl['1']."' and date(tgl_setor) <= '".$tgl['2']."'";
  $this->db->select('sec_users.name as name, entr_pegawai,prog,sum(jml) as total,
  sum(case when prog = 0001 then jml else 0 end) as infaq,
  sum(case when prog = 0002 then jml else 0 end) as pena,
  sum(case when prog = 0003 then jml else 0 end) as zakat,
  sum(case when prog = 0004 then jml else 0 end) as RCY,
  sum(case when prog = 0005 then jml else 0 end) as CGQ,
  sum(case when prog > 0005 then jml else 0 end) as dll');
  $this->db->from('keu_j');
  $this->db->join('sec_users','keu_j.entr_pegawai = sec_users.kodej','left');
  $this->db->where($where);
  $this->db->group_by('entr_pegawai');
  $query = $this->db->get();
  return $query->result();
  }

  public function perJgtGrup(){
    $tanggal = explode(' - ',$this->input->post('tgl'));
    if($this->input->post('tgl') != ""){
        $tgl = array(
            '1'=> $tanggal[0],
            '2'=> $tanggal[1]
        );
        }else{
            $tgl = array(
                '1'=> '0000-00-00',
                '2'=> '0000-00-00'
            );
        }
  $where="date(tgl_setor) >= '".$tgl['1']."' and date(tgl_setor) <= '".$tgl['2']."'";
  $this->db->select('sec_users.name as name, entr_pegawai,prog,sum(jml) as total,
  sum(case when prog = 0001 then jml else 0 end) as infaq,
  sum(case when prog = 0002 then jml else 0 end) as pena,
  sum(case when prog = 0003 then jml else 0 end) as zakat,
  sum(case when prog = 0004 then jml else 0 end) as RCY,
  sum(case when prog = 0005 then jml else 0 end) as CGQ,
  sum(case when prog > 0005 then jml else 0 end) as dll');
  $this->db->from('keu_j');
  $this->db->join('sec_users','keu_j.entr_pegawai = sec_users.kodej','left');
  $this->db->where($where);
  $this->db->where('sec_users.group_id', $this->session->userdata('idgrup'));
  $this->db->group_by('entr_pegawai');
  $query = $this->db->get();
  return $query->result();
  }



}
 ?>
