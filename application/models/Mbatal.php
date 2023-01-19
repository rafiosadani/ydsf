<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mbatal extends CI_Model{

public function getAll() { 
        $this->db->select('kodej,name');
        $this->db->from('sec_users');
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $query = $this->db->get();
        return $query->result();
    }
    public function getGrub($id) {
        $this->db->select('kodej,name');
        $this->db->from('sec_users');
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $this->db->where("group_id = '$id'");
        $query = $this->db->get();
        return $query->result();
    }

// public function getKawasan(){
//     $where = array(
//         'kodej' => $this->input->get('kodej')
//     );
//        $data = $this->db->get_where('*', $where )->result();
//        return json_encode($data);
// }
public function search($kodej,$kwsn){
    $tgl=$this->input->post('tgl');
    $tgl1= substr($tgl,0,10);
    $tgl2= substr($tgl,13,10);
    $query = $this->db->query("select a.report_id,a.noid,b.nama,b.kwsn,b.almktr,a.tanggal,a.validasi,c.NM_PROGRAM,jumlah,a.prog from report_tagih a left join donatur b on a.noid=b.noid left join program c on a.prog=c.PROG
    where noslip!=0 and id=0 and batal IS NULL  and a.kodej ='$kodej' and kwsn='$kwsn'  and a.prog!='' 
    and (a.tanggal like '$tgl1%' OR a.tanggal like '$tgl2%' OR  (a.tanggal >= '$tgl1' and a.tanggal <='$tgl2'))  and a.jumlah <> '0' order by b.nama asc");
    return $query->result();
}

// public function banyak_data($kodej,$kwsn){
//     $where = "report_tagih.kodej = '$kodej' AND kawasan.kwsn='$kwsn' AND batal is NULL AND month(report_tagih.tanggal) = month(now()) AND year(report_tagih.tanggal) = year(now())";
//     $this->db->select('*');
//     $this->db->from('report_tagih');
//     $this->db->join('sec_users','report_tagih.kodej = sec_users.kodej','left');
//     $this->db->join('program','report_tagih.prog = program.PROG','left');
//     $this->db->join('kawasan','report_tagih.kodej = kawasan.kodejgt','left');
//     $this->db->join('donatur','report_tagih.noid = donatur.noid','left');
//     $this->db->where($where);
//     $hasil=$this->db->get()->num_rows();
//     return $hasil;
// }

public function hapus($id){
$this->db->query("UPDATE report_tagih set batal='1' where report_id = '$id' "); 
}
}
