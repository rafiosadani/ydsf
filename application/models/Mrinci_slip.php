<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mrinci_slip extends CI_Model {

    public function getAll() {
        $this->db->select('kodej,name');
        $this->db->from('sec_users');
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $query = $this->db->get();
        return $query->result();
    }

    public function getJgtCabang($idcabang) {
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
    
    public function perBankJgtY($jungut){
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
        $this->db->select('entr_pegawai,NM_BANK,noslip,REC,prog,sum(jml) as total,sum(case when prog = 0001 then jml else 0 end) as infaq,sum(case when prog = 0002 then jml else 0 end) as pena,sum(case when prog = 0003 then jml else 0 end) as zakat,sum(case when prog = 0004 then jml else 0 end) as RCY,sum(case when prog = 0005 then jml else 0 end) as CGQ,sum(case when prog > 0005 then jml else 0 end) as dll');
        $this->db->from('keu_j');
        $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->where("entr_pegawai = '".$jungut."'");
        $this->db->where("validasi = 'y'");
        $this->db->where($where);
        $this->db->group_by('noslip');
        $query = $this->db->get();
        return $query->result();
    }

    public function perBankJgtT($jungut){
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
        $this->db->select('entr_pegawai,NM_BANK,noslip,REC,prog,sum(jml) as total,sum(case when prog = 0001 then jml else 0 end) as infaq,sum(case when prog = 0002 then jml else 0 end) as pena,sum(case when prog = 0003 then jml else 0 end) as zakat,sum(case when prog = 0004 then jml else 0 end) as RCY,sum(case when prog = 0005 then jml else 0 end) as CGQ,sum(case when prog > 0005 then jml else 0 end) as dll');
        $this->db->from('keu_j');
        $this->db->join('bank','keu_j.bank = bank.BANK','left');
        $this->db->where("entr_pegawai = $jungut");
        $this->db->where("validasi = 'n'");
        $this->db->where($where);
        $this->db->group_by('noslip');
        $query = $this->db->get();
        return $query->result();
    }

    public function getPtgs() {
        $post = $this->input->post();
        $this->db->select('name,kodej');
        $this->db->from('sec_users');
        $this->db->where(["kodej" => $post["jungut"]]);
        $query = $this->db->get();
        return $query->row();
    }

}

/* End of file Mprogram.php */

// SELECT sum(keu_j.jml) as jumlah, sum(case when keu_j.validasi = 'y' then keu_j.jml end) as keuangan,sum(case when keu_j.validasi = 'n' then keu_j.jml end) as belum, program.NM_PROGRAM as program, entr_pegawai FROM keu_j JOIN program on keu_j.prog = program.PROG WHERE entr_pegawai = 0116 and date(tgl_setor) >= '2018-11-01' and date(tgl_setor) <= '2018-11-30' and keu_j.validasi in ('y', 'n') GROUP BY keu_j.prog;       