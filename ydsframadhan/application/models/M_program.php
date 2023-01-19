<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_program extends CI_Model {
    
    function get_ramadhan($tglmulai='', $tglakhir='', $pilihcabang, $waktu='sekarang'){
        $where="";
        $join='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.=" and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        if($this->session->userdata('superadmin') != TRUE && $this->session->userdata('ptgs_admin_cabang') == TRUE){
            $cabang = $this->session->userdata('idcabang');
            $join=" join sec_users u on (k.entr_pegawai=u.kodej)";
            $where.=" and u.idcabang='$cabang'";
        }elseif($this->session->userdata('ptgs_admin_grup') == TRUE){
            $group = $this->session->userdata('grub_id');
            $join=" join sec_users u on (k.entr_pegawai=u.kodej)";
            $where.=" and u.group_id='$group'";
        }
        if($pilihcabang!=''){
            $join=" join sec_users u on (k.entr_pegawai=u.kodej)";
            $where.=" and u.idcabang='$pilihcabang'";
        }
        if($waktu=='sekarang')
        $query = $this->db->query("select k.prog, 
                    SUM(CASE When bank='0001' Then jml Else 0 End ) as jmltunai,
                    SUM(CASE When bank<>'0001' Then jml Else 0 End ) as jmlbank
                    from keu_j k
                    join program p on (p.PROG=k.prog and id_vent=1)
                    $join
                    where validasi='y' $where
                    group by prog
                    order by prog");
        else
         $query = $this->db->query("select k.prog, 
                    SUM(CASE When bank='0001' Then jml Else 0 End ) as jmltunai,
                    SUM(CASE When bank<>'0001' Then jml Else 0 End ) as jmlbank
                    from keu_rmdh k
                    join program p on (p.PROG=k.prog and id_vent=1)
                    $join
                    where 1=1 $where
                    group by prog
                    order by prog");
        //echo $this->db->last_query();
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $ramadhan=array();
        foreach ($result as $row){
            $ramadhan[$row->prog]['jmltunai']=$row->jmltunai;
            $ramadhan[$row->prog]['jmlbank']=$row->jmlbank;
            $ramadhan[$row->prog]['total']=($row->jmlbank+$row->jmltunai);
        }   
        return $ramadhan;
    }
    
    function get_program(){
        $this->db->select('PROG, NM_PROGRAM');
        $this->db->where('id_vent', '1');
        $this->db->order_by('NM_PROGRAM');
        $query = $this->db->get('program');
        $result=$query->result();
        
        $program=array();
        foreach ($result as $row)
        {
             $program[$row->PROG]=$row->NM_PROGRAM;
        }
        return $program;
    }
    
}

?>