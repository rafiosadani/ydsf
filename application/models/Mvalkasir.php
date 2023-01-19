<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvalkasir extends CI_Model {

    public function getValidasi($kodej,$tgl1,$tgl2) {
        // $tgl = explode(' - ', $date);
        $this->db->select('entr_pegawai,noslip,if(no_kasir is null,"",no_kasir) as no_kasir,tgl_setor,if(NM_BANK is null,"",NM_BANK) as bank,sum(jml) as jumlah,(case when validasi = "y" then "Sudah" else "Belum" end) as validasi,if(ket is null, "", ket) as ket');
        $this->db->from('keu_j');
        $this->db->join('bank', 'keu_j.bank = bank.BANK','LEFT');
        $this->db->where('entr_pegawai', $kodej);
        $this->db->where("tgl_setor >= '".$tgl1."'");
        $this->db->where("tgl_setor <= '".$tgl2."'");
        $this->db->order_by('validasi', 'ASC');
        $this->db->group_by('noslip');
        return $this->db->get()->result(); 
    }

    public function getValidasiReload($kodej,$tgl1,$tgl2) {
        $this->db->select('entr_pegawai,noslip,if(no_kasir is null,"",no_kasir) as no_kasir,tgl_setor,if(NM_BANK is null,"",NM_BANK) as bank,sum(jml) as jumlah,(case when validasi = "y" then "Sudah" else "Belum" end) as validasi,if(ket is null, "", ket) as ket');
        $this->db->from('keu_j');
        $this->db->join('bank', 'keu_j.bank = bank.BANK','LEFT');
        $this->db->where('entr_pegawai', $kodej);
        $this->db->where("tgl_setor >= '".$tgl1."'");
        $this->db->where("tgl_setor <= '".$tgl2."'");
        $this->db->order_by('validasi', 'ASC');
        $this->db->order_by('tgl_val', 'DESC');
        $this->db->group_by('noslip');
        return $this->db->get()->result(); 
    }

    public function getAction($noslip){
        $this->db->select('batal, noslip');
        $this->db->from('report_tagih');
        $this->db->where('noslip',$noslip);
        $this->db->order_by('batal', 'DESC');
        $this->db->group_by('batal');
        $this->db->limit(1);
        return $this->db->get()->result();    
    }

    public function getActionTwo($noslip) {
        $this->db->select('noslip');
        $this->db->from('report_sementara');
        $this->db->where('noslip', $noslip);
        return $this->db->get()->result();
    }

    public function getValidasiAll($tgl1,$tgl2) {
        // $tgl = explode(' - ', $date);
        $this->db->select('entr_pegawai,no_kasir,noslip,tgl_setor,bank,sum(jml) as jumlah,(case when validasi = "y" then "Sudah" else "Belum" end) as validasi,ket');
        $this->db->from('keu_j');
        $this->db->where("tgl_setor >= '".$tgl1."'");
        $this->db->where("tgl_setor <= '".$tgl2."'");
        $this->db->group_by('noslip');
        return $this->db->get()->result();
    }

    public function checkKwitansi($noslip) {
        $this->db->select('count(*) as cek');
        $this->db->from('report_tagih');
        $this->db->where('noslip', $noslip);
        $this->db->where('batal = 1');
        return $this->db->get()->result();
    }

    public function getBank() {
        $this->db->select('*');
        $this->db->from('bank');
        return $this->db->get()->result();
    }

    public function addVal($object,$where) {
        $this->db->update('keu_j', $object, $where);
    }

    public function getPetugas($noslip) {
        $this->db->select('entr_pegawai,noslip,no_kasir,NM_BANK,rec,name,tgl_setor,ket,keu_j.idusr_v');
        $this->db->from('keu_j');
        $this->db->join('sec_users', 'kodej = entr_pegawai');
        $this->db->join('bank', 'keu_j.bank = bank.BANK');
        $this->db->where('noslip', $noslip);
        return $this->db->get()->row();
    }

    public function getPetugas2($noslip) {
        $this->db->select('name,keu_j.idusr_v');
        $this->db->from('keu_j');
        $this->db->join('sec_users', 'usrid = idusr_v');
        $this->db->where('noslip', $noslip);
        return $this->db->get()->row();
    }

    public function getJml($noslip) {
        $this->db->select('keu_j.prog,NM_PROGRAM,sum(jml) as jumlah,noslip');
        $this->db->from('keu_j');
        $this->db->join('program', 'keu_j.prog = program.PROG');
        $this->db->where('noslip', $noslip);
        $this->db->group_by('keu_j.prog');
        return $this->db->get()->result();
    }

    public function getKwitansi($prog,$noslip) {
        $this->db->select('prog,sum(jumlah) as kwitansi');
        $this->db->from('report_tagih');
        $this->db->where('noslip', $noslip);
        $this->db->where('prog', $prog);
        $this->db->where('batal = 1');
        return $this->db->get()->result();
    }

    public function getDntQrbn($noslip) {
        $this->db->select('report_tagih.noid, donatur.nama, donatur.almktr, donatur.telphp, donatur.kwsn, report_tagih.kodej, report_tagih.tanggal, report_tagih.prog, report_tagih.noslip, report_tagih.jumlah, report_tagih.report_id, donatur.ket');
        $this->db->from('report_tagih');
        $this->db->join('donatur', 'report_tagih.noid = donatur.noid', 'left');
        $this->db->join('program', 'report_tagih.prog = program.PROG', 'left');
        $this->db->where('report_tagih.noslip', $noslip);
        $this->db->where('program.id_vent = 2');
        return $this->db->get()->result();
    }

    public function addDntQrbn($object) {
        $this->db->insert('dnt_qurban', $object);
    }

}

/* End of file Mvalkasir.php */
