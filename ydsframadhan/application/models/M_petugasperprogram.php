<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class m_petugasperprogram extends CI_Model {
    function get_ramadhan($tglmulai='', $tglakhir='', $petugas=''){
        $where="";
        if($tglmulai!='' && $tglakhir!=''){
            $where.=" and tgl_setor between '$tglmulai' and '$tglakhir'";
        }
        /*
        $query = $this->db->query("select p.NM_PROGRAM, 
                                    SUM(CASE When bank='0001' Then jml Else 0 End ) as jmltunai,
                                    SUM(CASE When bank<>'0001' Then jml Else 0 End ) as jmlbank
                                    from keu_j k
                                    join program p on (p.PROG=k.prog and id_vent=1)
                                    join sec_users u on (k.entr_pegawai=u.kodej)
                                    where  validasi='y' and kodej='$petugas' $where
                                    group by k.prog, p.NM_PROGRAM");
         */
        $query = $this->db->query("select p.NM_PROGRAM, 
                                    SUM(CASE When bank='0001' Then jml Else 0 End ) as jmltunai,
                                    SUM(CASE When bank<>'0001' Then jml Else 0 End ) as jmlbank
                                    from keu_j k
                                    join program p on (p.PROG=k.prog and id_vent=1)
                                    join sec_users u on (k.entr_pegawai=u.kodej)
                                    where  validasi='y' and kodej='$petugas' $where
                                    group by k.prog, p.NM_PROGRAM
                                    order by p.NM_PROGRAM");
        $result=$query->result();
        //echo $this->db->last_query().'<hr>';
        $ramadhan=array();
        $i=0;
        foreach ($result as $row){
            $ramadhan[$i]['program']=$row->NM_PROGRAM;
            $ramadhan[$i]['jmltunai']=$row->jmltunai;
            $ramadhan[$i]['jmlbank']=$row->jmlbank;
            $ramadhan[$i]['jmltotal']=($row->jmlbank+$row->jmltunai);
            $i++;
        }   
        return $ramadhan;
    }
    
}

?>