<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mbank extends CI_Model {

    public function getBank() {
        return $this->db->get("bank")->result();
    }

    public function perBankAll($idbank) {
        $post = $this->input->post();
        $tglhimp = explode(' - ', $post['tglhimp']);
        $tglval = explode(' - ', $post['tglval']);
        $cabang = $this->mprogram->getCabang();
        $y = count($cabang);
        $select = "";
        for ($x = 0;$x < $y; $x++) {
            $select .= "SUM(case when name not like 'KANTOR%' and idcabang = ".$cabang[$x]->id_cab." then keu_j.jml else 0 end) as ".$cabang[$x]->cabang."_jungut,
            SUM(case when name like 'KANTOR%' and idcabang = ".$cabang[$x]->id_cab." then keu_j.jml else 0 end) as ".$cabang[$x]->cabang."_kantor,";
        }
        $query = "keu_j.prog as prog, NM_PROGRAM as program,".$select." SUM(keu_j.jml) as total";
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
        $this->db->select($query);
        $this->db->from('keu_j');
        $this->db->join('sec_users', 'keu_j.entr_pegawai = sec_users.kodej', 'left');
        $this->db->join('program', 'keu_j.prog = program.PROG', 'left');
        $this->db->where("validasi = 'y'");
        $this->db->where($tanggal);
        $this->db->where('keu_j.bank', $idbank);
        // $this->db->where("date(tgl_setor) >= '".$date_himp1."'");
        // $this->db->where("date(tgl_setor) <= '".$date_himp2."'");
        // $this->db->where("date(tgl_val) >= '".$date_val1."'");
        // $this->db->where("date(tgl_val) <= '".$date_val2."'");
        $this->db->group_by('keu_j.prog');
        return $this->db->get()->result();
    } 

    public function perBankCab($idbank,$idcabang) {
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
        $this->db->where("keu_j.bank", $idbank);
        // $this->db->where("date(tgl_setor) >= '".$date_himp1."'");
        // $this->db->where("date(tgl_setor) <= '".$date_himp2."'");
        // $this->db->where("date(tgl_val) >= '".$date_val1."'");
        // $this->db->where("date(tgl_val) <= '".$date_val2."'");
        $this->db->where("idcabang", $idcabang);
        $this->db->group_by('keu_j.prog');
        return $this->db->get()->result();
    }

}

/* End of file Mbank.php */
