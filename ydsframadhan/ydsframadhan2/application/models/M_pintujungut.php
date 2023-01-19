<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_pintujungut extends CI_Model {
    function get_ramadhan($tglmulai='', $tglakhir='', $cabang=''){
        $where='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.="and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        if($cabang!=''){
            $where.=" and u.idcabang='$cabang'";
        }
        $query = $this->db->query("select entr_pegawai, sum(jml) jml
                                    from keu_j k
                                    join program p on (p.PROG=k.prog and id_vent=1)
                                    join sec_users u on (k.entr_pegawai=u.kodej)
                                    where  validasi='y' and id_pintu='2' $where
                                    group by login, name");
        
        $result=$query->result();
        $ramadhan=array();
        foreach ($result as $row){
            $ramadhan[$row->entr_pegawai]=$row->jml;
        }   
        return $ramadhan;
    }
}

?>