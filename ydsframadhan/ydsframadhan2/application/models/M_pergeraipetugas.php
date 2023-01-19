<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_pergeraipetugas extends CI_Model {
    function get_ramadhan($tglmulai='', $tglakhir='', $cabang=''){
        $where='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.=" and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        if($cabang!=''){
            $where.=" and s.idcabang='$cabang'";
        }
        $query = $this->db->query("select nm_gerai, name, sum(jml) as jml
                    from gerai g
                    left join sec_users s on (s.id_gerai=p.id_gerai)
                    left join keu_j k on (k.entr_pegawai=s.kodej)
                    join program p on (p.PROG=k.prog and id_vent=1)
                    where validasi='y' $where 
                    group by nm_gerai, name
                    order by nm_gerai");
        //echo $this->db->last_query();
        $result=$query->result();
        $ramadhan=array();
        $i=1;
        $temp='';
        foreach ($result as $row){
            if($temp!=$row->nm_gerai){
                $temp=$row->nm_gerai;
                $i=1;
            }
            $ramadhan[$row->nm_gerai]['jumlah']=$i;
            $ramadhan[$row->nm_gerai]['petugas'][$row->name]=$row->jml;
            $i++;
        }   
        return $ramadhan;
    }
}

?>