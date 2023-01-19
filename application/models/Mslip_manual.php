<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mslip_manual extends CI_Model {

    public function getAll() {
        $this->db->select('*');
        $this->db->from('sec_users');
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $query = $this->db->get();
        return $query->result();
    }

    public function getAllTwo($idcabang) {
        $this->db->select('*');
        $this->db->from('sec_users');
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $this->db->where(["idcabang" => $idcabang]);
        $query = $this->db->get();
        return $query->result();
    }
    

    public function getAllThree($kodej) {
        return $this->db->get_where('sec_users',["kodej" => $kodej])->row();  
    }

    public function getProgSlip($noslip){
        $this->db->distinct();
        $this->db->select('prog');
        $this->db->from('keu_j');
        $this->db->where('noslip',$noslip);
        $query=$this->db->get();
        return $query->result_array();
    }

    public function getAllFour($idgrup) {
        $this->db->select('*');
        $this->db->from('sec_users');
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $this->db->where(["group_id" => $idgrup]);
        $query = $this->db->get();
        return $query->result();
    }

    public function getSlip($kodej,$tgl1,$tgl2) {
        // $tgl = explode(' - ', $date);
        $this->db->select('keu_j.entr_pegawai as entr_pegawai,keu_j.noslip as noslip,no_kasir,tgl_setor,keu_j.bank as bank,bank.NM_BANK as nama_bank,sum(keu_j.jml) as jumlah,(case when keu_j.validasi = "y" then "Sudah" else "Belum" end) as validasi,keu_j.ket as ket,sec_users.name as nama_jungut ');
        $this->db->from('keu_j');
        $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->join('sec_users','keu_j.entr_pegawai = sec_users.kodej');
        // $this->db->join('report_tagih','keu_j.entr_pegawai = report_tagih.kodej');
        // $this->db->join('donatur','report_tagih.noid = donatur.noid');
        $this->db->where('keu_j.entr_pegawai', $kodej);
        $this->db->where("keu_j.tgl_setor >= '".$tgl1."'");
        $this->db->where("keu_j.tgl_setor <= '".$tgl2."'");
        $this->db->like('keu_j.noslip','m');
        $this->db->group_by('keu_j.noslip');
        return $this->db->get()->result();
    }

    public function getSlipAll($tgl1,$tgl2) {
        // $tgl = explode(' - ', $date);
        $this->db->select('keu_j.entr_pegawai as entr_pegawai,keu_j.noslip as noslip,no_kasir,tgl_setor,keu_j.bank as bank,bank.NM_BANK as nama_bank,sum(keu_j.jml) as jumlah,(case when keu_j.validasi = "y" then "Sudah" else "Belum" end) as validasi,keu_j.ket as ket,sec_users.name as nama_jungut ');
        $this->db->from('keu_j');
        $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->join('sec_users','keu_j.entr_pegawai = sec_users.kodej');
        // $this->db->join('report_tagih','keu_j.entr_pegawai = report_tagih.kodej');
        // $this->db->join('donatur','report_tagih.noid = donatur.noid');
        // $this->db->where('keu_j.entr_pegawai', $kodej);
        $this->db->where("keu_j.tgl_setor >= '".$tgl1."'");
        $this->db->where("keu_j.tgl_setor <= '".$tgl2."'");
        $this->db->like('keu_j.noslip','m');
        $this->db->group_by('keu_j.noslip');
        return $this->db->get()->result();
    }

    public function getDataProg($noslip,$tgl1,$tgl2) {
        // $tgl = explode(' - ', $date);
        $this->db->select('entr_pegawai,noslip,program.NM_PROGRAM as nama_program,sum(jml) as jumlah ');
        $this->db->from('keu_j');
        $this->db->join('program','keu_j.prog = program.PROG');
        // $this->db->join('sec_users','keu_j.entr_pegawai = sec_users.kodej');
        $this->db->where('noslip', $noslip);
        $this->db->where("tgl_setor >= '".$tgl1."'");
        $this->db->where("tgl_setor <= '".$tgl2."'");
        // $this->db->like('noslip','m');
        $this->db->group_by('keu_j.prog');
        return $this->db->get()->result();
    }

    public function getProgram(){
        $this->db->select('*');
        $this->db->from('program');
        $this->db->order_by('NM_PROGRAM','ASC');
        $data=$this->db->get();
        return $data->result();
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

    public function insertToProg($kodej,$noslip,$program,$jumlah,$bank){
        $tgl_setor = date('y-m-d');
        $tanggal = date('d');
        $bulan = ltrim(date('m'),'0');
        $tahun = date('Y');
        $object = array(
            'jml' => $jumlah,
            'tgl_setor' => $tgl_setor,
            'bln'=> $bulan,
            'thn'=> $tahun,
            'entr_pegawai'=>$kodej,
            'validasi'=> 'y',
            'bank'=>$bank,
            'noslip'=>$noslip,
            'tgl_val'=>$tgl_setor,
            'prog' => $program
        );
        $this->db->insert('keu_j',$object);
    }

    public function getDataDonatur($noslip){
        $this->db->select('report_tagih.noid as noid,donaturbaru.nama as nama,donaturbaru.almktr as almktr,donaturbaru.telphp as telphp,donaturbaru.kwsn as kwsn,report_tagih.kodej as kodej,report_tagih.tanggal as tanggal,report_tagih.prog as prog,report_tagih.noslip as noslip,report_tagih.jumlah as jumlah,report_tagih.report_id as report_id,donaturbaru.ket as ket');
        $this->db->from('report_tagih');
        $this->db->join('donaturbaru','report_tagih.noid = donaturbaru.noid');
        $this->db->join('program','report_tagih.prog = program.PROG');
        $this->db->where('report_tagih.noslip',$noslip);
        $this->db->where('program.id_vent = "2" ');
        $data = $this->db->get();
        return $data->result();
    }

    public function insertToSlipbaru($nokasir,$bank,$program,$jumlah, $keterangan,$jungut,$tgl_himp){
        $tgl_setor = $tgl_himp;
        $tgl_val = date('y-m-d');
        $tanggal = date('d');
        $bulan1 = date('m');
        $tahun1 = date('Y');
        $bulan= substr($tgl_himp,5,2);
        $tahun = substr($tgl_himp,0,4);
        $jam = date('H');
        $menit=date('i');
        $detik = date('s');
        $noslip='M'.$tahun1.$bulan1.$tanggal.$jam.$menit.$detik;
        // $noslip = 
        $object = array(
            'jml' => $jumlah,
            'tgl_setor' => $tgl_setor,
            'bln'=> $bulan,
            'thn'=> $tahun,
            'entr_pegawai'=>$jungut,
            'validasi'=> 'y',
            'idusr_v' => $this->session->userdata('usrid'),
            'bank'=>$bank,
            'noslip'=>$noslip,
            'ket'=>$keterangan,
            'tgl_val'=>$tgl_val,
            'prog' => $program,
            'no_kasir'=>$nokasir
        );
        $this->db->insert('keu_j',$object);
    }

    public function insertToDntQ($object){
        $this->db->insert('dnt_qurban',$object);
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

}

/* End of file Mvalkasir.php */
