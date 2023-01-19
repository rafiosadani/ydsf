<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_percabangpetugas extends CI_Model {
    function get_ramadhan($tglmulai='', $tglakhir='', $pilihcabang){
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
        $query = $this->db->query("select nm_pintu, name, sum(jml) as jml
                    from pintu p
                    left join sec_users s on (s.id_pintu=p.id_pintu)
                    left join keu_j k on (k.entr_pegawai=s.kodej)
                    join program pr on (pr.PROG=k.prog and id_vent=1)
                    where validasi='y' $where 
                    group by nm_pintu, name
                    order by nm_pintu");
        //echo $this->db->last_query();
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $ramadhan=array();
        $i=1;
        $temp='';
        foreach ($result as $row){
            if($temp!=$row->nm_pintu){
                $temp=$row->nm_pintu;
                $i=1;
            }
            $ramadhan[$row->nm_pintu]['jumlah']=$i;
            $ramadhan[$row->nm_pintu]['petugas'][$row->name]=$row->jml;
            $i++;
        }   
        return $ramadhan;
    }
}

?>