<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_harian extends CI_Model {
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
        $query = $this->db->query("select tgl_setor, 
                    SUM(CASE When bank='0001' Then jml Else 0 End ) as jmltunai,
                    SUM(CASE When bank<>'0001' Then jml Else 0 End ) as jmlbank
                    from keu_j k
                    join program p on (p.PROG=k.prog and id_vent=1)
                    $join
                    where validasi='y' $where
                    group by tgl_setor
                    order by tgl_setor");
        $result=$query->result();
        $ramadhan=array();
        foreach ($result as $row){
            $ramadhan[$row->tgl_setor]['jmltunai']=$row->jmltunai;
            $ramadhan[$row->tgl_setor]['jmlbank']=$row->jmlbank;
            $ramadhan[$row->tgl_setor]['total']=($row->jmlbank+$row->jmltunai);
        }   
        return $ramadhan;
    }
    
}

?>