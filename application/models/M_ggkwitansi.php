<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_ggkwitansi extends CI_Model {

  public function getGagalAll($tgl1,$tgl2){
    $tahun= substr($tgl2,0,4);
    $bulan= substr($tgl2,5,2);
    $hari= substr($tgl2,8,2);
    $day = $hari+1;
    $tgl2 = $tahun."-".$bulan."-".$day;
    $this->db->select('SUM(jumlah) as jmlh,a.noslip,b.NM_PROGRAM as nm_program,c.jml as jumlah');
    $this->db->from('report_tagih a');
    $this->db->join('program b','b.PROG = a.prog','left');
    $this->db->join('keu_j c','c.noslip = a.noslip and c.prog = a.prog','left');
    $this->db->where("batal = '1'");
    $this->db->where("tanggal>='".$tgl1."' and tanggal<'".$tgl2."'");
    $this->db->where("c.tgl_setor >= '".$tgl1."'");
    $this->db->where("c.tgl_setor < '".$tgl2."'");
    $this->db->group_by('a.noslip,a.prog');
    return $this->db->get()->result();
  }

  public function getGagal($kodej,$tgl1,$tgl2){
    $tahun= substr($tgl2,0,4);
    $bulan= substr($tgl2,5,2);
    $hari= substr($tgl2,8,2);
    $day = $hari+1;
    $tgl2 = $tahun."-".$bulan."-".$day;
    $this->db->select('SUM(jumlah) as jmlh,a.noslip,b.NM_PROGRAM as nm_program,c.jml as jumlah');
    $this->db->from('report_tagih a');
    $this->db->join('program b','b.PROG = a.prog','left');
    $this->db->join('keu_j c','c.noslip = a.noslip and c.prog = a.prog','left');
    $this->db->where("batal = '1'");
    $this->db->where("kodej = '".$kodej."'");
    $this->db->where("tanggal>='".$tgl1."' and tanggal<'".$tgl2."'");
    $this->db->where("c.tgl_setor >= '".$tgl1."'");
    $this->db->where("c.tgl_setor < '".$tgl2."'");
    $this->db->group_by('a.noslip,a.prog');
    return $this->db->get()->result();
  }

  public function getValidasi($noslip){
    $this->db->select('kodej,jumlah,tanggal,batal,program.NM_PROGRAM as prog,donatur.nama as nama,donatur.kwsn as kawasan,donatur.almktr as alamat');
    $this->db->from('report_tagih');
    $this->db->join('donatur','report_tagih.noid = donatur.noid','left');
    $this->db->join('program','report_tagih.prog = program.PROG','left');
    $this->db->where("noslip = '".$noslip."'");
    $this->db->group_by('report_id');
    return $this->db->get()->result();
  }

  }
 ?>
