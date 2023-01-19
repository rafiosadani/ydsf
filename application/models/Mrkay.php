<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mrkay extends CI_Model {

    public function rkay($bulan,$cabang,$pintu) {
        $select = "nm_rkay,rkay_1,rkay_2,
            sum(case when bulan = '".$bulan."' then perolehan2019 else 0 end) as per20191, 
            sum(case when bulan = '".$bulan."' then perolehan2018 else 0 end) as per20181,
            sum(case when bulan = '".$bulan."' then rkay2019 else 0 end) as rkay20191,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20192, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as per20182,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay20192,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20193, 
            sum(perolehan2018) as per20183,
            sum(rkay2019) as rkay20193";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_cab', $cabang);
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->order_by('rkay_2', 'desc');
        $this->db->order_by('rkay_1', 'asc');
        $this->db->group_by('rkay_1,nm_rkay,id_rkay');
        return $this->db->get()->result();
    }

    public function rkayAll($bulan,$pintu) {
        $select = "nm_rkay,rkay_1,rkay_2,
            sum(case when bulan = '".$bulan."' then perolehan2019 else 0 end) as per20191, 
            sum(case when bulan = '".$bulan."' then perolehan2018 else 0 end) as per20181,
            sum(case when bulan = '".$bulan."' then rkay2019 else 0 end) as rkay20191,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20192, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as per20182,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay20192,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20193, 
            sum(perolehan2018) as per20183,
            sum(rkay2019) as rkay20193";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->order_by('rkay_2', 'desc');
        $this->db->order_by('rkay_1', 'asc');
        $this->db->group_by('rkay_1,nm_rkay,id_rkay');
        return $this->db->get()->result();
    }   

    public function getPintu() {
        return $this->db->get('pintu_rtn')->result();
    }

    public function rkay2($bulan,$cabang) {
        $select = "nm_rkay,rkay_1,rkay_2,
            sum(case when bulan = '".$bulan."' then perolehan2019 else 0 end) as per20191, 
            sum(case when bulan = '".$bulan."' then perolehan2018 else 0 end) as per20181,
            sum(case when bulan = '".$bulan."' then rkay2019 else 0 end) as rkay20191,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20192, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as per20182,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay20192,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20193,
            sum(perolehan2018) as per20183,
            sum(rkay2019) as rkay20193";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_cab', $cabang);
        $this->db->order_by('rkay_2', 'desc');
        $this->db->order_by('rkay_1', 'asc');
        $this->db->group_by('rkay_1,nm_rkay,id_rkay');
        return $this->db->get()->result();
    }

    public function rkayAll2($bulan) {
        $select = "nm_rkay,rkay_1,rkay_2,
            sum(case when bulan = '".$bulan."' then perolehan2019 else 0 end) as per20191, 
            sum(case when bulan = '".$bulan."' then perolehan2018 else 0 end) as per20181,
            sum(case when bulan = '".$bulan."' then rkay2019 else 0 end) as rkay20191,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20192, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as per20182,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay20192,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20193,
            sum(perolehan2018) as per20183,
            sum(rkay2019) as rkay20193";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->order_by('rkay_2', 'desc');
        $this->db->order_by('rkay_1', 'asc');
        $this->db->group_by('rkay_1,nm_rkay,id_rkay');
        return $this->db->get()->result();
    }
    
    public function rkayGrup($bulan,$pintu) {
        $select = "nm_rkay,rkay_1,rkay_2,
            sum(case when bulan = '".$bulan."' then perolehan2019 else 0 end) as per20191, 
            sum(case when bulan = '".$bulan."' then perolehan2018 else 0 end) as per20181,
            sum(case when bulan = '".$bulan."' then rkay2019 else 0 end) as rkay20191,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20192, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as per20182,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay20192,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20193, 
            sum(perolehan2018) as per20183,
            sum(rkay2019) as rkay20193";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->order_by('rkay_2', 'desc');
        $this->db->order_by('rkay_1', 'asc');
        $this->db->group_by('rkay_1,nm_rkay,id_rkay');
        return $this->db->get()->result();
    }
    
    public function rkayGrupAll($bulan) {
        $select = "nm_rkay,rkay_1,rkay_2,
            sum(case when bulan = '".$bulan."' then perolehan2019 else 0 end) as per20191, 
            sum(case when bulan = '".$bulan."' then perolehan2018 else 0 end) as per20181,
            sum(case when bulan = '".$bulan."' then rkay2019 else 0 end) as rkay20191,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20192, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as per20182,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay20192,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as per20193, 
            sum(perolehan2018) as per20183,
            sum(rkay2019) as rkay20193";
        $this->db->select($select);
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->from('vw_rky_jd19');
        $this->db->order_by('rkay_2', 'desc');
        $this->db->order_by('rkay_1', 'asc');
        $this->db->group_by('rkay_1,nm_rkay,id_rkay');
        return $this->db->get()->result();
    }

    public function getCabGrup() {
        $this->db->select('*');
        $this->db->from('cabanggroup');
        $this->db->join('cabang', 'cabanggroup.id_group = cabang.id_group');
        return $this->db->get()->result();
    }

    public function perbandingan($bulan,$cabang,$pintu) {
        $select = "sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay2019, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as perolehan2019,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as perolehan2018";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_cab', $cabang);
        $this->db->where('id_pintu_rtn', $pintu);
        return $this->db->get()->result();
    }

    public function perbandingan2($bulan,$cabang) {
        $select = "sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay2019, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as perolehan2019,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as perolehan2018";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_cab', $cabang);
        return $this->db->get()->result();
    }
 
    public function perolehan($bulan,$cabang,$pintu) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_cab', $cabang);
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->where('bulan >= "1"');
        $this->db->where('bulan <= "'.$bulan.'"');
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function perolehan2($bulan,$cabang) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_cab', $cabang);
        $this->db->where('bulan >= "1"');
        $this->db->where('bulan <= "'.$bulan.'"');
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function perbandinganAll($bulan,$pintu) {
        $select = "sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay2019, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as perolehan2019,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as perolehan2018";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_pintu_rtn', $pintu);
        return $this->db->get()->result();
    }

    public function perbandinganAll2($bulan) {
        $select = "sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay2019, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as perolehan2019,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as perolehan2018";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        return $this->db->get()->result();
    }

    public function perolehanAll($bulan,$pintu) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->where('bulan >= "1"');
        $this->db->where('bulan <= "'.$bulan.'"');
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function perolehanAll2($bulan) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan >= "1"');
        $this->db->where('bulan <= "'.$bulan.'"');
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function perbandinganGrup($bulan,$pintu) {
        $select = "sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay2019, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as perolehan2019,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as perolehan2018";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->where('id_pintu_rtn', $pintu);
        return $this->db->get()->result();
    }

    public function perbandinganGrup2($bulan) {
        $select = "sum(case when bulan >= '1' and bulan <= '".$bulan."' then rkay2019 else 0 end) as rkay2019, 
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2019 else 0 end) as perolehan2019,
            sum(case when bulan >= '1' and bulan <= '".$bulan."' then perolehan2018 else 0 end) as perolehan2018";
        $this->db->select($select);
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        return $this->db->get()->result();
    }

    public function perolehanGrup($bulan,$pintu) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->where('bulan >= "1"');
        $this->db->where('bulan <= "'.$bulan.'"');
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function perolehanGrup2($bulan) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->where('bulan >= "1"');
        $this->db->where('bulan <= "'.$bulan.'"');
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function kumulatifAll($bulan,$pintu) {
        $this->db->select('bulan,sum(rkay2019) as rkay2019,sum(perolehan2019) as per2019, sum(perolehan2018) as per2018');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_pintu_rtn', $pintu);
        return $this->db->get()->row();
    }

    public function kumulatifAll2($bulan) {
        $this->db->select('bulan,sum(rkay2019) as rkay2019,sum(perolehan2019) as per2019, sum(perolehan2018) as per2018');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        return $this->db->get()->row();
    }

    public function kumulatif($bulan,$cabang,$pintu) {
        $this->db->select('bulan,sum(rkay2019) as rkay2019,sum(perolehan2019) as per2019, sum(perolehan2018) as per2018');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_cab', $cabang);
        $this->db->where('id_pintu_rtn', $pintu);
        return $this->db->get()->row();
    }

    public function kumulatif2($bulan,$cabang) {
        $this->db->select('bulan,sum(rkay2019) as rkay2019,sum(perolehan2019) as per2019, sum(perolehan2018) as per2018');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_cab', $cabang);
        return $this->db->get()->row();
    }

    public function kumulatifGrup($bulan,$pintu) {
        $this->db->select('bulan,sum(rkay2019) as rkay2019,sum(perolehan2019) as per2019, sum(perolehan2018) as per2018');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        return $this->db->get()->row();
    }

    public function kumulatifGrup2($bulan) {
        $this->db->select('bulan,sum(rkay2019) as rkay2019,sum(perolehan2019) as per2019, sum(perolehan2018) as per2018');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        return $this->db->get()->row();
    }

    public function month($bulan,$cabang,$pintu) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_cab', $cabang);
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function month2($bulan,$cabang) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_cab', $cabang);
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function monthAll($bulan,$pintu) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function monthAll2($bulan) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function monthGrup($bulan,$pintu) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_pintu_rtn', $pintu);
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

    public function monthGrup2($bulan) {
        $this->db->select('sum(perolehan2019) as total, rkay_2');
        $this->db->from('vw_rky_jd19');
        $this->db->where('bulan', $bulan);
        $this->db->where('id_group', $this->session->userdata('idgrup'));
        $this->db->group_by('rkay_2');
        return $this->db->get()->result();
    }

}

/* End of file Mrkay.php */
