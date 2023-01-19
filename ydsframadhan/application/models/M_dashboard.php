<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_dashboard extends CI_Model {
    
    function get_perprogram($tglmulai, $tglakhir, $pilihcabang){
        $where='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.=" and tgl_setor between '$tglmulai' and '$tglakhir'";
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
        $query = $this->db->query("select p.NM_PROGRAM, sum(jml) as jml
                    from keu_j k
                    join program p on (p.PROG=k.prog and id_vent=1)
                    join sec_users u on (k.entr_pegawai=u.kodej)
                    where validasi='y' $where 
                    group by p.NM_PROGRAM");
        //echo $this->db->last_query();
        $result=$query->result_array();
        return $result;
    }
    
}

?>