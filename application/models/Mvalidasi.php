<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mvalidasi extends CI_Model {

    public function getValidasi($kodej,$tgl1,$tgl2) {
        // $tgl = explode(' - ', $date);
        $this->db->select('entr_pegawai,noslip,tgl_setor,bank,sum(jml) as jumlah,(case when validasi = "y" then "Sudah" else "Belum" end) as validasi');
        $this->db->from('keu_j');
        $this->db->where('entr_pegawai', $kodej);
        $this->db->where("tgl_setor >= '".$tgl1."'");
        $this->db->where("tgl_setor <= '".$tgl2."'");
        $this->db->group_by('noslip');
        return $this->db->get()->result();
    }

    public function getPerData($noslip) {
        // $this->db->select('report_tagih.noid,nama,alamat,prog,kwsn,jumlah');
        // $this->db->from('report_tagih');
        // $this->db->join('donaturbaru', 'report_tagih.noid = donaturbaru.noid');
        // $this->db->where('noslip', $noslip);
        return $this->db->query("SELECT report_tagih.noid AS noid, report_tagih.kodej AS kodej, donatur.nama AS nama, donatur.almktr AS alamat, report_tagih.prog AS prog, 
        date(report_tagih.tanggal) AS tanggal, report_tagih.jumlah AS jumlah, report_tagih.kwitansi AS kwitansi, donatur.kwsn AS kwsn from (report_tagih left join donatur on((report_tagih.noid = donatur.noid)))
        where (report_tagih.noslip = '".$noslip."')")->result();
        // return $this->db->get()->result();
    }

}

/* End of file Mvalidasi.php */
