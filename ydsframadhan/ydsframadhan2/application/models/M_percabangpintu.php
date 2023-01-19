<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_percabangpintu extends CI_Model {
    function get_ramadhan($tglmulai='', $tglakhir='', $cabang=''){
        $where='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.="and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        if($cabang!=''){
            $where.=" and u.idcabang='$cabang'";
        }
        $query = $this->db->query("select id_pintu, sum(jml) as jml
                                    from keu_j k
                                    join program p on (p.PROG=k.prog and id_vent=1)
                                    join sec_users u on (k.entr_pegawai=u.kodej)
                                    where validasi='y' $where
                                    group by id_pintu");
        
        $result=$query->result();
        $ramadhan=array();
        foreach ($result as $row){
            $ramadhan[$row->id_pintu]=$row->jml;
        }   
        return $ramadhan;
    }
}

?>