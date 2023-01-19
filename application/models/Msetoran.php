<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Msetoran extends CI_Model {

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

    public function getSetoran($kodej,$tanggal1,$tanggal2) {
        $grupby=array("noslip","prog");
        $where="date(tgl_setor) >= '".$tanggal1."' and date(tgl_setor) <= '".$tanggal2."'";
        $this->db->select('noslip , tgl_setor, bank.NM_BANK as nama_bank,bank.REC as rek,sum(jml) as jumlah,prog');
        $this->db->from('keu_j');
        $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->where('entr_pegawai',$kodej);
        $this->db->where($where);
        // $this->db->where('validasi = ""');
        $this->db->group_by('keu_j.noslip');
        $query = $this->db->get();
        return $query->result();

    }

    public function getProgram($kodej,$tanggal1,$tanggal2){
     return  $this->db->query("SELECT keu_j.prog,sum(keu_j.jml) as jumlah, sum(case when keu_j.validasi = 'y' then keu_j.jml else 0 end) as keuangan,sum(case when keu_j.validasi = 'n' then keu_j.jml else 0 end) as belum, program.NM_PROGRAM as program, entr_pegawai FROM keu_j JOIN program on keu_j.prog = program.PROG WHERE entr_pegawai = '".$kodej."' and date(tgl_setor) >= '".$tanggal1."' and date(tgl_setor) <= '".$tanggal2."' and keu_j.validasi in ('y', 'n') GROUP BY keu_j.prog;")->result();
    }
    public function getKwitansi($prog) {
        $post = $this->input->post();
        $tanggal = explode(" - ", $post['tgl']);
        $this->db->select('sum(case when batal = 1 then jumlah else 0 end) as kwitansi');
        $this->db->from('report_tagih');
        $this->db->where('vou_id = 0');
        $this->db->where('tanggal >= "'.$tanggal[0].' 00:00:00"');
        $this->db->where('tanggal <= "'.$tanggal[1].' 23:59:59"');
        $this->db->where('kodej', $post['jungut']);
        $this->db->where('prog', $prog);
        $this->db->group_by('report_tagih.prog');
        return $this->db->get()->result();
    }

    public function getPtgs() {
        $post = $this->input->post();
        $this->db->select('name,kodej');
        $this->db->from('sec_users');
        $this->db->where(["kodej" => $post["jungut"]]);
        $query = $this->db->get();
        return $query->row();
    }

    public function getUser($id){
        $this->db->select('*');
        $this->db->from('sec_users');
        $this->db->where(["kodej" => $id]);
        $query = $this->db->get();
        return $query->row();
    }

}
