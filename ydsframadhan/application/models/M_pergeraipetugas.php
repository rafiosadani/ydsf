<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_pergeraipetugas extends CI_Model {
    function get_ramadhan($tglmulai='', $tglakhir='', $pilihcabang=''){
        $where='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.=" and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        if($this->session->userdata('superadmin') != TRUE && $this->session->userdata('ptgs_admin_cabang') == TRUE){
            $cabang = $this->session->userdata('idcabang');
            $where.=" and s.idcabang='$cabang'";
        }elseif($this->session->userdata('ptgs_admin_grup') == TRUE){
            $group = $this->session->userdata('grub_id');
            $where.=" and s.group_id='$group'";
        }
        if($pilihcabang!=''){
            $where.=" and s.idcabang='$pilihcabang'";
        }
        $query = $this->db->query("select g.id_gerai,nm_gerai, name, sum(jml) as jml
                    from gerai g
                    left join sec_users s on (s.id_gerai=g.id_gerai)
                    left join keu_j k on (k.entr_pegawai=s.kodej)
                    join program p on (p.PROG=k.prog and id_vent=1)
                    where validasi='y' and id_pintu='3' $where 
                    group by nm_gerai, name
                    order by nm_gerai");
        //echo $this->db->last_query();
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $ramadhan=array();
        $i=1;
        $temp='';
        foreach ($result as $row){
            if($temp!=$row->id_gerai){
                $temp=$row->id_gerai;
                $i=1;
            }
            $ramadhan[$row->id_gerai]['jumlah']=$i;
            $ramadhan[$row->id_gerai]['nm_gerai']=$row->nm_gerai;
            $ramadhan[$row->id_gerai]['petugas'][$row->name]=$row->jml;
            $i++;
        }   
        return $ramadhan;
    }
}

?>