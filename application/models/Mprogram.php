<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mprogram extends CI_Model {

    private $tableProg = "program";
    private $tableKerja = "pekerjaan";
    private $tableJbt = "jabatan";
    private $tableHobi = "hobby";
    private $tablePend = "pendidikan";
    // private $tableKeuj = "keu_j";

    public function getCabang() {
        $this->db->select('*');
        $this->db->from('cabang');
        $this->db->order_by('id_cab','ASC');
        return $this->db->get()->result();
    }
    
    public function getCabangCab() {
        $this->db->select('*');
        $this->db->from('cabang');
        $this->db->where('id_cab', $this->session->userdata('idcab'));
        $this->db->order_by('id_cab','ASC');
        return $this->db->get()->result();
    }

    public function getCabangGrup() {
        $this->db->select('*');
        $this->db->from('cabang');
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->order_by('id_cab','ASC');
        return $this->db->get()->result();
    }

    public function getCabangUser() {
        $this->db->select('*');
        $this->db->from('cabang');
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->where('id_cab', $this->session->userdata('idcab'));
        $this->db->order_by('id_cab','ASC');
        return $this->db->get()->result();
    }

    public function perProgramAll($select) {
        $post = $this->input->post();
        $tglhimp = explode(' - ', $post['tglhimp']);
        $tglval = explode(' - ', $post['tglval']);
        if ($post['tglhimp'] == '' && $post['tglval'] == '') {
            $date_himp1 = '';
            $date_himp2 = '';
            $date_val1 = '';
            $date_val2 = '';
        } else if ($post['tglhimp'] == '') {
            $date_himp1 = '';
            $date_himp2 = '';
            $date_val1 = $tglval[0];
            $date_val2 = $tglval[1];
        } else if ($post['tglval'] == '') {
            $date_himp1 = $tglhimp[0].' 00:00:00';
            $date_himp2 = $tglhimp[1].' 23:59:59';
            $date_val1 = '';
            $date_val2 = '';
        } else {
            $date_himp1 = $tglhimp[0].' 00:00:00';
            $date_himp2 = $tglhimp[1].' 23:59:59';
            $date_val1 = $tglval[0];
            $date_val2 = $tglval[1];
        }
        $tanggal = "(tgl_setor like '".$date_himp1."%' or (date(tgl_setor) >= '".$date_himp1."' and date(tgl_setor) <= '".$date_himp2."')) and (tgl_val like '".$date_val1."%' or (date(tgl_val) >= '".$date_val1."' and date(tgl_val) <= '".$date_val2."'))";
        $this->db->select($select);
        $this->db->from('keu_j');
        $this->db->join('sec_users', 'keu_j.entr_pegawai = sec_users.kodej', 'left');
        $this->db->join('program', 'keu_j.prog = program.PROG', 'left');
        $this->db->where("validasi = 'y'");
        $this->db->where($tanggal);
        // $this->db->where("date(tgl_setor) >= '".$date_himp1."'");
        // $this->db->where("date(tgl_setor) <= '".$date_himp2."'");
        // $this->db->where("date(tgl_val) >= '".$date_val1."'");
        // $this->db->where("date(tgl_val) <= '".$date_val2."'");
        $this->db->group_by('keu_j.prog');
        return $this->db->get()->result();
    } 

    public function perProgramGrupAll($select) {
        $post = $this->input->post();
        $tglhimp = explode(' - ', $post['tglhimp']);
        $tglval = explode(' - ', $post['tglval']);
        if ($post['tglhimp'] == '' && $post['tglval'] == '') {
            $date_himp1 = '';
            $date_himp2 = '';
            $date_val1 = '';
            $date_val2 = '';
        } else if ($post['tglhimp'] == '') {
            $date_himp1 = '';
            $date_himp2 = '';
            $date_val1 = $tglval[0];
            $date_val2 = $tglval[1];
        } else if ($post['tglval'] == '') {
            $date_himp1 = $tglhimp[0].' 00:00:00';
            $date_himp2 = $tglhimp[1].' 23:59:59';
            $date_val1 = '';
            $date_val2 = '';
        } else {
            $date_himp1 = $tglhimp[0].' 00:00:00';
            $date_himp2 = $tglhimp[1].' 23:59:59';
            $date_val1 = $tglval[0];
            $date_val2 = $tglval[1];
        }
        $tanggal = "(tgl_setor like '".$date_himp1."%' or (date(tgl_setor) >= '".$date_himp1."' and date(tgl_setor) <= '".$date_himp2."')) and (tgl_val like '".$date_val1."%' or (date(tgl_val) >= '".$date_val1."' and date(tgl_val) <= '".$date_val2."'))";
        $this->db->select($select);
        $this->db->from('keu_j');
        $this->db->join('sec_users', 'keu_j.entr_pegawai = sec_users.kodej', 'left');
        $this->db->join('program', 'keu_j.prog = program.PROG', 'left');
        $this->db->where("validasi = 'y'");
        $this->db->where('sec_users.group_id',$this->session->userdata('idgrup'));
        $this->db->where($tanggal);
        // $this->db->where("date(tgl_setor) >= '".$date_himp1."'");
        // $this->db->where("date(tgl_setor) <= '".$date_himp2."'");
        // $this->db->where("date(tgl_val) >= '".$date_val1."'");
        // $this->db->where("date(tgl_val) <= '".$date_val2."'");
        $this->db->group_by('keu_j.prog');
        return $this->db->get()->result();
    } 

    public function perProgramCab($idcabang) {
        $post = $this->input->post();
        $tglhimp = explode(' - ', $post['tglhimp']);
        $tglval = explode(' - ', $post['tglval']);
        if ($post['tglhimp'] == '' && $post['tglval'] == '') {
            $date_himp1 = '';
            $date_himp2 = '';
            $date_val1 = '';
            $date_val2 = '';
        } else if ($post['tglhimp'] == '') {
            $date_himp1 = '';
            $date_himp2 = '';
            $date_val1 = $tglval[0];
            $date_val2 = $tglval[1];
        } else if ($post['tglval'] == '') {
            $date_himp1 = $tglhimp[0].' 00:00:00';
            $date_himp2 = $tglhimp[1].' 23:59:59';
            $date_val1 = '';
            $date_val2 = '';
        } else {
            $date_himp1 = $tglhimp[0].' 00:00:00';
            $date_himp2 = $tglhimp[1].' 23:59:59';
            $date_val1 = $tglval[0];
            $date_val2 = $tglval[1];
        }

        $tanggal = "(tgl_setor like '".$date_himp1."%' or (date(tgl_setor) >= '".$date_himp1."' and date(tgl_setor) <= '".$date_himp2."')) and (tgl_val like '".$date_val1."%' or (date(tgl_val) >= '".$date_val1."' and date(tgl_val) <= '".$date_val2."'))";
        $this->db->select("keu_j.prog as prog,nm_cabang as cabang, NM_PROGRAM as program, SUM(case when name not like 'KANTOR%' then keu_j.jml else 0 end) as jungut,
            SUM(case when name like 'KANTOR%' then keu_j.jml else 0 end) as kantor,
            SUM(keu_j.jml) as total");
        $this->db->from('keu_j');
        $this->db->join('sec_users', 'keu_j.entr_pegawai = sec_users.kodej', 'left');
        $this->db->join('program', 'keu_j.prog = program.PROG', 'left');
        $this->db->join('cabang', 'sec_users.idcabang = cabang.id_cab', 'left');
        $this->db->where('validasi = "y"');
        $this->db->where($tanggal);
        // $this->db->where("date(tgl_setor) >= '".$date_himp1."'");
        // $this->db->where("date(tgl_setor) <= '".$date_himp2."'");
        // $this->db->where("date(tgl_val) >= '".$date_val1."'");
        // $this->db->where("date(tgl_val) <= '".$date_val2."'");
        $this->db->where("idcabang", $idcabang);
        $this->db->group_by('keu_j.prog');
        return $this->db->get()->result();
    }

    

    public function getProgram() {
        return $this->db->get($this->tableProg)->result();
    }

    public function getKet() {
        return $this->db->get('ket_ap')->result();
    }

    public function getKerja() {
        $this->db->from($this->tableKerja);
        $this->db->order_by("PEKERJAAN","ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getJabatan() {
        $this->db->from($this->tableJbt);
        $this->db->order_by("jabatan","ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getHobi() {
        $this->db->from($this->tableHobi);
        $this->db->order_by("hobby","ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getPend() {
        $this->db->from($this->tablePend);
        $this->db->order_by("PENDIDIKAN","ASC");
        $query = $this->db->get();
        return $query->result();
    }

    public function getJumlah($tanggal1,$tanggal2) {
        $post = $this->input->post();
        return $this->db->query("SELECT keu_j.prog,sum(keu_j.jml) as jumlah, sum(case when keu_j.validasi = 'y' then keu_j.jml else 0 end) as keuangan,sum(case when keu_j.validasi = 'n' then keu_j.jml else 0 end) as belum, program.NM_PROGRAM as program, entr_pegawai FROM keu_j JOIN program on keu_j.prog = program.PROG WHERE entr_pegawai = ".$post['kodej']." and date(tgl_setor) >= '".$tanggal1."' and date(tgl_setor) <= '".$tanggal2."' and keu_j.validasi in ('y', 'n') GROUP BY keu_j.prog;
        ")->result();
    }

    public function getKwitansi($prog) {
        $post = $this->input->post();
        $tanggal = explode(" - ", $post['date']);
        $this->db->select('sum(case when batal = 1 then jumlah else 0 end) as kwitansi');
        $this->db->from('report_tagih');
        $this->db->where('vou_id = 0');
        $this->db->where('tanggal >= "'.$tanggal[0].' 00:00:00"');
        $this->db->where('tanggal <= "'.$tanggal[1].' 23:59:59"');
        $this->db->where('kodej', $post['kodej']);
        $this->db->where('prog', $prog);
        $this->db->group_by('report_tagih.prog');
        return $this->db->get()->result();
    }

    public function getHarian($kodej) {
        $this->db->select('*');
        $this->db->from('vw_harian_gabung');
        $this->db->where('kodej', $kodej);
        return $this->db->get()->result();
    }

    public function getCount($kodej) {
        $this->db->select('COUNT(*) as total');
        $this->db->from('vw_harian_gabung');
        $this->db->where('kodej', $kodej);
        return $this->db->get()->row();
    }

    public function getAll() {
        $this->db->select('*');
        $this->db->from('vw_harian_gabung');
        return $this->db->get()->result();
    }

    public function getCountAll() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('vw_harian_gabung');
        return $this->db->get()->row();
    }
    
    public function getGrup() {
        $this->db->select('*');
        $this->db->from('vw_harian_gabung');
        $this->db->where('group_id', $this->session->userdata('idgrup'));
        return $this->db->get()->result();
    }

    public function getCountGrup() {
        $this->db->select('COUNT(*) as total');
        $this->db->from('vw_harian_gabung');
        $this->db->where('group_id', $this->session->userdata('idgrup'));
        return $this->db->get()->row();
    }
    // SELECT sum(keu_j.jml) as jumlah, sum(case when keu_j.validasi = 'y' then keu_j.jml else 0 end) as keuangan,sum(case when keu_j.validasi = 'n' then keu_j.jml else 0 end) as belum, program.NM_PROGRAM as program, entr_pegawai,if(kwitansi IS NULL,0,1) as kwitansi FROM keu_j JOIN program on keu_j.prog = program.PROG left join report_tagih on (keu_j.entr_pegawai = report_tagih.kodej and keu_j.tgl_setor = report_tagih.tanggal) WHERE entr_pegawai = 0151 and date(tgl_setor) >= '2018-12-01' and date(tgl_setor) <= '2018-12-31' and keu_j.validasi in ('y', 'n') GROUP BY keu_j.prog;
// SELECT sum(keu_j.jml) as jumlah, sum(case when keu_j.validasi = 'y' then keu_j.jml else 0 end) as keuangan,sum(case when keu_j.validasi = 'n' then keu_j.jml else 0 end) as belum, program.NM_PROGRAM as program, entr_pegawai FROM keu_j JOIN program on keu_j.prog = program.PROG WHERE entr_pegawai = ".$post['kodej']." and date(tgl_setor) >= '".$tanggal1."' and date(tgl_setor) <= '".$tanggal2."' and keu_j.validasi in ('y', 'n') GROUP BY keu_j.prog

}

/* End of file Mprogram.php */

// SELECT sum(keu_j.jml) as jumlah, sum(case when keu_j.validasi = 'y' then keu_j.jml end) as keuangan,sum(case when keu_j.validasi = 'n' then keu_j.jml end) as belum, program.NM_PROGRAM as program, entr_pegawai FROM keu_j JOIN program on keu_j.prog = program.PROG WHERE entr_pegawai = 0116 and date(tgl_setor) >= '2018-11-01' and date(tgl_setor) <= '2018-11-30' and keu_j.validasi in ('y', 'n') GROUP BY keu_j.prog;       