<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_pintujungut extends CI_Model {
    function get_ramadhan($tglmulai='', $tglakhir='', $pilihcabang,$waktu='sekarang'){
        $where='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.="and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        if($this->session->userdata('superadmin') != TRUE && $this->session->userdata('ptgs_admin_cabang') == TRUE){
            $cabang = $this->session->userdata('idcabang');
            $where.=" and u.idcabang='$cabang'";
        }elseif($this->session->userdata('ptgs_admin_grup') == TRUE){
            $group = $this->session->userdata('grub_id');
            $where.=" and u.group_id='$group'";
        }
        if($pilihcabang!=''){
            $where.=" and u.idcabang='$pilihcabang'";
        }
        if($waktu=='sekarang')
        $query = $this->db->query("select entr_pegawai, sum(jml) jml
                                    from keu_j k
                                    join program p on (p.PROG=k.prog and id_vent=1)
                                    join sec_users u on (k.entr_pegawai=u.kodej)
                                    where  validasi='y' and id_pintu='2' $where
                                    group by login, name");
        else
        $query = $this->db->query("select entr_pegawai, sum(jml) jml
                                    from keu_rmdh k
                                    join program p on (p.PROG=k.prog and id_vent=1)
                                    join sec_users u on (k.entr_pegawai=u.kodej and k.id_pintu='2')
                                    where  1=1  $where
                                    group by login, name");
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $ramadhan=array();
        foreach ($result as $row){
            $ramadhan[$row->entr_pegawai]=$row->jml;
        }   
        return $ramadhan;
    }
}

?>