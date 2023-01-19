<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcentang extends CI_Model {

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

    public function getSlip($start,$length,$bulan,$tahun) {
        // $tgl = explode(' - ', $date);
        $hari = cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
        $select = "";
        for($a=1;$a<=$hari;$a++){
            $select .= 'count(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then donatur.nama end) as dnt'.$a.',format(sum(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then report_tagih.jumlah else 0 end),0) as dns'.$a.',';
        }
        $this->db->select('report_tagih.kodej as kodej,sec_users.name as nama,cabang.cabang as cabang,report_tagih.bulan as bulan,report_tagih.tahun as tahun ,'.$select.' format(sum(report_tagih.jumlah),0)as jumlah,cabang.cabang as cabang,count(donatur.nama) as tot_dnt,count(DISTINCT date(report_tagih.tanggal)) as qty');
        $this->db->from('report_tagih');

        // $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->join('sec_users','report_tagih.kodej = sec_users.kodej');
        $this->db->join('donatur','report_tagih.noid = donatur.noid');
        $this->db->join('cabang','sec_users.idcabang = cabang.id_cab');
        $this->db->join('kawasan','donatur.kwsn = kawasan.kwsn');
        // $this->db->where('keu_j.entr_pegawai', $kodej);
        $this->db->where("month(report_tagih.tanggal) = '".$bulan."' ");
        $this->db->where("report_tagih.tahun = '".$tahun."' ");
        // $this->db->like('keu_j.noslip','m');
        $this->db->group_by('report_tagih.kodej');
        $this->db->limit($length,$start);
        return $this->db->get()->result();

    }

    public function getCetakSlip($bulan,$tahun) {
        // $tgl = explode(' - ', $date);
        $hari = cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
        $select = "";
        for($a=1;$a<=$hari;$a++){
            $select .= 'count(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then donatur.nama end) as dnt'.$a.',format(sum(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then report_tagih.jumlah else 0 end),0) as dns'.$a.',';
        }
        $this->db->select('report_tagih.kodej as kodej,sec_users.name as nama,cabang.cabang as cabang,report_tagih.bulan as bulan,report_tagih.tahun as tahun ,'.$select.' format(sum(report_tagih.jumlah),0)as jumlah,cabang.cabang as cabang,count(donatur.nama) as tot_dnt,count(DISTINCT date(report_tagih.tanggal)) as qty');
        $this->db->from('report_tagih');

        // $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->join('sec_users','report_tagih.kodej = sec_users.kodej');
        $this->db->join('donatur','report_tagih.noid = donatur.noid');
        $this->db->join('cabang','sec_users.idcabang = cabang.id_cab');
        $this->db->join('kawasan','donatur.kwsn = kawasan.kwsn');
        // $this->db->where('keu_j.entr_pegawai', $kodej);
        $this->db->where("month(report_tagih.tanggal) = '".$bulan."' ");
        $this->db->where("report_tagih.tahun = '".$tahun."' ");
        // $this->db->like('keu_j.noslip','m');
        $this->db->group_by('report_tagih.kodej');
        // $this->db->limit($length,$start);
        return $this->db->get()->result();

    }

    public function searchData($search,$length,$start,$bulan,$tahun) {
        // $tgl = explode(' - ', $date);
        $hari = cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
        $select = "";
        for($a=1;$a<=$hari;$a++){
            $select .= 'count(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then donatur.nama end) as dnt'.$a.',format(sum(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then report_tagih.jumlah else 0 end),0) as dns'.$a.',';
        }
        $this->db->select('report_tagih.kodej as kodej,sec_users.name as nama,cabang.cabang as cabang,report_tagih.bulan as bulan,report_tagih.tahun as tahun ,'.$select.' format(sum(report_tagih.jumlah),0)as jumlah,cabang.cabang as cabang,count(donatur.nama) as tot_dnt,count(DISTINCT date(report_tagih.tanggal)) as qty');
        $this->db->from('report_tagih');

        // $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->join('sec_users','report_tagih.kodej = sec_users.kodej');
        $this->db->join('donatur','report_tagih.noid = donatur.noid');
        $this->db->join('cabang','sec_users.idcabang = cabang.id_cab');
        $this->db->join('kawasan','donatur.kwsn = kawasan.kwsn');
        // $this->db->where('keu_j.entr_pegawai', $kodej);
        // $this->db->or_like(array('report_tagih.kodej'=>$search,'sec_users.name' => $search));
        $this->db->where("month(report_tagih.tanggal) = '".$bulan."' ");
        $this->db->where("report_tagih.tahun = '".$tahun."' ");
        $this->db->like('sec_users.name',$search, 'both');
        // $this->db->or_like('sec_users.name',$search, 'both');
        $this->db->group_by('report_tagih.kodej');
        $this->db->limit($length,$start);
        return $this->db->get()->result();

    }

    public function jumSrc($search,$bulan,$tahun) {
        // $tgl = explode(' - ', $date);
        $hari = cal_days_in_month(CAL_GREGORIAN,$bulan, $tahun);
        $select = "";
        for($a=1;$a<=$hari;$a++){
            $select .= 'count(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then donatur.nama end) as dnt'.$a.',format(sum(case when date(report_tagih.tanggal) = "'.date('Y-m-d', mktime(0,0,0,$bulan,$a,$tahun)).'" then report_tagih.jumlah else 0 end),0) as dns'.$a.',';
        }
        $this->db->select('report_tagih.kodej as kodej,sec_users.name as nama,cabang.cabang as cabang,report_tagih.bulan as bulan,report_tagih.tahun as tahun ,'.$select.' format(sum(report_tagih.jumlah),0)as jumlah,cabang.cabang as cabang,count(donatur.nama) as qty');
        $this->db->from('report_tagih');

        // $this->db->join('bank','keu_j.bank = bank.BANK');
        $this->db->join('sec_users','report_tagih.kodej = sec_users.kodej');
        $this->db->join('donatur','report_tagih.noid = donatur.noid');
        $this->db->join('cabang','sec_users.idcabang = cabang.id_cab');
        $this->db->join('kawasan','donatur.kwsn = kawasan.kwsn');
        // $this->db->where('keu_j.entr_pegawai', $kodej);
        // $this->db->or_like(array('report_tagih.kodej'=>$search,'sec_users.name' => $search));
        $this->db->where("month(report_tagih.tanggal) = '".$bulan."' ");
        $this->db->where("report_tagih.tahun = '".$tahun."' ");
        $this->db->like('sec_users.name',$search, 'both');
        // $this->db->or_like('sec_users.name',$search, 'both');
        $this->db->group_by('report_tagih.kodej');
        // $this->db->limit($length,$start);
        return $this->db->get();

    }

    public function getDataAlls($bulan,$tahun){
        $query=$this->db->query("SELECT report_tagih.kodej as kodej,sec_users.name as nama,sec_users.idcabang as idcabang,report_tagih.bulan as bulan,report_tagih.tahun as tahun ,cabang.cabang as cabang,date(report_tagih.tanggal) as tanggal
        FROM report_tagih
        JOIN sec_users ON report_tagih.kodej = sec_users.kodej
        JOIN donatur ON report_tagih.noid = donatur.noid
        JOIN kawasan ON donatur.kwsn = kawasan.kwsn
        JOIN cabang ON sec_users.idcabang= cabang.id_cab
        WHERE sec_users.active = 'Y' and sec_users.lapangan = 'A' and report_tagih.tahun= '".$tahun."' and report_tagih.bulan = '".$bulan."'
        GROUP BY report_tagih.kodej");

        return $query;
    }

    public function getDataAll($leng,$start,$bulan,$tahun){
        $query=$this->db->query("SELECT report_tagih.kodej as kodej,sec_users.name as nama,sec_users.idcabang as idcabang,report_tagih.bulan as bulan,report_tagih.tahun as tahun ,cabang.cabang as cabang,date(report_tagih.tanggal) as tanggal, sum(report_tagih.jumlah) as tot_dns, count(donatur.nama) as tot_dnt
        FROM report_tagih
        JOIN sec_users ON report_tagih.kodej = sec_users.kodej
        JOIN donatur ON report_tagih.noid = donatur.noid
        JOIN kawasan ON donatur.kwsn = kawasan.kwsn
        JOIN cabang ON sec_users.idcabang= cabang.id_cab
        WHERE sec_users.active = 'Y' and sec_users.lapangan = 'A' and report_tagih.tahun= '".$tahun."' and report_tagih.bulan = '".$bulan."'
        GROUP BY report_tagih.kodej
        LIMIT $leng ");

        return $query;
    }

    public function getDnt($length,$kodej,$bulan,$tahun,$hari){
        $tanggal=date('Y-m-d', mktime(0,0,0,$bulan,$hari,$tahun));
        $this->db->select("count(donatur.nama) as dnt");
        $this->db->from("report_tagih");
        $this->db->join("sec_users","report_tagih.kodej = sec_users.kodej");
        $this->db->join("donatur","report_tagih.noid = donatur.noid");
        $this->db->join("kawasan","donatur.kwsn = kawasan.kwsn");
        $this->db->join("cabang","sec_users.idcabang= cabang.id_cab");
        $this->db->where("date(report_tagih.tanggal) = '".$tanggal."' ");
        $this->db->where("report_tagih.kodej = '".$kodej."' ");
        $this->db->group_by("report_tagih.kodej");
        // $this->db->limit($length);
        $query=$this->db->get();
        return $query->result();
    }

    public function getDns($leng,$kodej,$bulan,$tahun,$hari){
        $tanggal=date('Y-m-d', mktime(0,0,0,$bulan,$hari,$tahun));
        $this->db->select("sum(report_tagih.jumlah) as dns");
        $this->db->from("report_tagih");
        $this->db->join("sec_users","report_tagih.kodej = sec_users.kodej");
        $this->db->join("donatur","report_tagih.noid = donatur.noid");
        $this->db->join("kawasan","donatur.kwsn = kawasan.kwsn");
        $this->db->join("cabang","sec_users.idcabang= cabang.id_cab");
        $this->db->where("date(report_tagih.tanggal) = '".$tanggal."' ");
        $this->db->where("report_tagih.kodej = '".$kodej."' ");
        $this->db->group_by("report_tagih.kodej");
        // $this->db->limit($leng);
        $query=$this->db->get();
        return $query->result();
    }

    public function getDataPetugas($bulan,$tahun){
        $query=$this->db->query("SELECT report_tagih.kodej as kodej,sec_users.name as name,sec_users.idcabang as idcabang,report_tagih.bulan as bulan,report_tagih.tahun as tahun , sum(report_tagih.jumlah) as jumlah,cabang.cabang as cabang,date(report_tagih.tanggal) as tanggal,count(donatur.nama) as tot_dnt
        FROM report_tagih
        JOIN sec_users ON report_tagih.kodej = sec_users.kodej
        JOIN donatur ON report_tagih.noid = donatur.noid
        JOIN kawasan ON donatur.kwsn = kawasan.kwsn
        JOIN cabang ON sec_users.idcabang= cabang.id_cab
        WHERE month(report_tagih.tanggal)=$bulan and year(report_tagih.tanggal)=$tahun
        GROUP BY report_tagih.kodej");

        return $query->result();
    }

    public function getPerDay($hari,$bulan,$tahun){
        $tanggal=date('Y-m-d', mktime(0,0,0,$bulan,$hari,$tahun));
        $query=$this->db->query("SELECT sec_users.name as nama,report_tagih.tanggal as tanggal, sum(report_tagih.jumlah) as jumlah_perday,count(donatur.nama) as tot_dnt_perday
        FROM report_tagih
        JOIN sec_users ON report_tagih.kodej = sec_users.kodej
        JOIN donatur ON report_tagih.noid = donatur.noid
        JOIN kawasan ON donatur.kwsn = kawasan.kwsn
        JOIN cabang ON sec_users.idcabang= cabang.id_cab
        WHERE date(report_tagih.tanggal) = '".$tanggal."'
        GROUP BY report_tagih.kodej");

        return $query->result();
    }

    public function getPerDays($kodej,$hari,$bulan,$tahun){
        $tanggal=date('Y-m-d', mktime(0,0,0,$bulan,$hari,$tahun));
        $query=$this->db->query("SELECT sec_users.name as nama,report_tagih.tanggal as tanggal, sum(report_tagih.jumlah) as jumlah_perday,count(donatur.nama) as tot_dnt_perday
        FROM report_tagih
        JOIN sec_users ON report_tagih.kodej = sec_users.kodej
        JOIN donatur ON report_tagih.noid = donatur.noid
        JOIN kawasan ON donatur.kwsn = kawasan.kwsn
        JOIN cabang ON sec_users.idcabang= cabang.id_cab
        WHERE date(report_tagih.tanggal) = '".$tanggal."' and report_tagih.kodej = '$kodej'
        GROUP BY report_tagih.kodej");

        return $query->result();
    }

    public function getSlipAll($tgl1,$tgl2) {
        // $tgl = explode(' - ', $date);
        $this->db->select('keu_j.entr_pegawai as entr_pegawai,keu_j.noslip as noslip,no_kasir,tgl_setor,keu_j.bank as bank,bank.NM_BANK as nama_bank,sum(keu_j.jml) as jumlah,(case when keu_j.validasi = "y" then "Sudah" else "Belum" end) as validasi,keu_j.ket as ket ');
        $this->db->from('keu_j');
        $this->db->join('bank','keu_j.bank = bank.BANK');
        // $this->db->join('sec_users','keu_j.entr_pegawai = sec_users.kodej');
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
        $tanggal = date('d');
        $bulan = ltrim(date('m'),'0');
        $bulan1=date('m');
        $tahun = date('Y');
        $jam = date('H');
        $menit=date('i');
        $detik = date('s');
        $noslip='M'.$tahun.$bulan1.$tanggal.$jam.$menit.$detik;
        // $noslip = 
        $object = array(
            'jml' => $jumlah,
            'tgl_setor' => $tgl_setor,
            'bln'=> $bulan,
            'thn'=> $tahun,
            'entr_pegawai'=>$jungut,
            'validasi'=> 'y',
            'bank'=>$bank,
            'noslip'=>$noslip,
            'ket'=>$keterangan,
            'tgl_val'=>$tgl_setor,
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
