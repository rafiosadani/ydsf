<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_program extends CI_Model {
    
    function get_ramadhan($tglmulai='', $tglakhir='', $cabang=''){
        $where="";
        $join='';
        if($tglmulai!='' && $tglakhir!=''){
            $where.=" and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        if($cabang!=''){
            $join=" join sec_users u on (k.entr_pegawai=u.kodej)";
            $where.=" and u.idcabang='$cabang'";
        }
        $query = $this->db->query("select k.prog, 
                    SUM(CASE When bank='0001' Then jml Else 0 End ) as jmltunai,
                    SUM(CASE When bank<>'0001' Then jml Else 0 End ) as jmlbank
                    from keu_j k
                    join program p on (p.PROG=k.prog and id_vent=1)
                    $join
                    where validasi='y' $where
                    group by prog
                    order by prog");
        //echo $this->db->last_query();
        $result=$query->result();
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