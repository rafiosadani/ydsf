<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdonasi extends CI_Model {

    public function getDonatur() {
    	$this->db->select('donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat, donaturbaru.almktr,donaturbaru.autoid, kawasanbaru.kodejgt');
        $this->db->from('donaturbaru');
        $this->db->like('donaturbaru.noid', $this->input->post('search'));
        $this->db->or_like('donaturbaru.nama', $this->input->post('search'));
        $this->db->join('kawasanbaru', 'donaturbaru.kwsn = kawasanbaru.kwsn');
        $this->db->order_by('donaturbaru.lastupdate','desc');
        $this->db->limit(10,0);
        return $this->db->get()->result();
    }
    public function getDonaturById($id) {
    	$this->db->select('donaturbaru.noid, donaturbaru.nama,donaturbaru.alamat,donaturbaru.almktr');
        $this->db->from('donaturbaru');
        $this->db->where('noid', $id);
        return $this->db->get()->result();
    }
    public function getProgram() {
    	$this->db->select('PROG,NM_PROGRAM');
        $this->db->from('program');
        $this->db->where('KELOMPOK', $this->input->post('kelompok'));
        $this->db->order_by('PROG','asc');
        return $this->db->get()->result();
    }
    public function getProgramById($prog) {
    	$this->db->select('PROG,NM_PROGRAM');
        $this->db->from('program');
        $this->db->where('PROG', $prog);
        return $this->db->get()->result();
    }
    public function getJupenById($id) {
    	$this->db->from('sec_users');
        $this->db->where('usrid', $id);
        return $this->db->get()->result();
    }
 
 	public function insertDonasi($data){
        $id=$this->db->insert("report_sementara", $data);
		return $id;

    }
    public function updateValidasi($data){
//		$data = array('laporan' => 'y');
//		$this->db->where('report_id', $id);
//		$this->db->update('report_sementara', $data);
		$this->db->update_batch('report_sementara' , $data , 'report_id' );

		return $data;

    }
    
    public function getDonasi($id) {
    	$this->db->select('report_sementara.*,donaturbaru.*,program.*,sec_users.*,kawasan.*');
        $this->db->from('report_sementara');
        $this->db->join('donaturbaru', 'donaturbaru.noid =report_sementara.report_noid','LEFT');
        $this->db->join('program', 'program.PROG =report_sementara.report_prog','LEFT');
        $this->db->join('sec_users', 'sec_users.kodej =report_sementara.report_jupen','LEFT');
        $this->db->join('kawasan', 'kawasan.kwsn =donaturbaru.kwsn','LEFT');
        $this->db->where('report_jupen', $id);
        $this->db->where('laporan', 'n');
        $this->db->order_by('report_sementara.report_id','desc');
        return $this->db->get()->result();
    }

    public function getQurban($id) {
    	$this->db->select('report_sementara.*,donaturbaru.*');
        $this->db->from('report_sementara');
        $this->db->join('program', 'program.PROG =report_sementara.report_prog','LEFT');
        $this->db->join('donaturbaru', 'donaturbaru.noid =report_sementara.report_noid','LEFT');
        $this->db->where('report_id', $id);
        $this->db->where('id_vent', 2);
        $this->db->order_by('report_sementara.report_id','desc');
        return $this->db->get()->result();
    }
    public function getValidasi($group) {
    	$this->db->select('report_sementara.*,donaturbaru.*,program.*,a.name AS petugas,b.name AS jupen');
        $this->db->from('report_sementara');
        $this->db->join('donaturbaru', 'donaturbaru.noid =report_sementara.report_noid','LEFT');
        $this->db->join('kawasanbaru', 'donaturbaru.kwsn = kawasanbaru.kwsn','LEFT');
        $this->db->join('sec_users b', 'b.kodej =kawasanbaru.kodejgt','LEFT');
        $this->db->join('program', 'program.PROG =report_sementara.report_prog','LEFT');
        $this->db->join('sec_users a', 'a.kodej =report_sementara.report_jupen','LEFT');
        $this->db->where('a.group_id', $group);
        $this->db->where('laporan', 'n');
        $this->db->order_by('report_sementara.report_id','desc');
        return $this->db->get()->result();
    }

    public function getValidasiById($id) {
    	$this->db->from('report_sementara');
        $this->db->where('report_id', $id);
        return $this->db->get()->result();
    }
    public function getValidasiBySlip($noslip) {
    	$this->db->select('report_prog,report_jupen,SUM(report_nominal) AS total');
        $this->db->from('report_sementara');
        $this->db->where('noslip', $noslip);
        $this->db->group_by('report_prog');
        $this->db->order_by('report_prog');
        return $this->db->get()->result();
    }
    public function insertReport($data){
        $id=$this->db->insert_batch("report_tagih", $data);
		return $id;

    }
    public function insertQurban($data){
        $id=$this->db->insert_batch("dnt_qurban", $data);
		return $id;

    }
    public function insertKeu($data){
        $id=$this->db->insert("keu_j", $data);
		return $id;

    }
    
    
    
    public function getDonaturItem($obj){
        // $where = array('donatur_item.noid' => $obj);
        $this->db->select('program.NM_PROGRAM, donatur_item.besar, donatur_item.keterangan');
        $this->db->from('donatur_item');
        $this->db->join('program', 'donatur_item.prog = program.PROG');
        $this->db->where('donatur_item.noid', $obj);
        return $this->db->get()->result();
    }

    public function getKoor($limit,$offset) {
        $this->db->select('idkoordinator, nama, alamat, handphone, jupen');
        $this->db->from('koordinator');
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }
    
    public function getKawasan($limit,$offset)
    {
        $this->db->select('kwsn,nm_kawasan,alamat,kodejgt');
        $this->db->from('kawasanbaru');
        $this->db->where('nm_kawasan != ""');
        $this->db->where('alamat != ""');
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }

    public function keyDonatur($keyword) {
        $this->db->select('donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat, program.NM_PROGRAM, donatur_item.besar, kawasanbaru.kodejgt');
        $this->db->from('donaturbaru');
        $this->db->join('donatur_item', 'autoid = donatur_item.noid', 'INNER');
        $this->db->join('program', 'donatur_item.prog = program.PROG', 'INNER');
        $this->db->join('kawasanbaru', 'donaturbaru.kwsn = kawasanbaru.kwsn', 'INNER');
        $this->db->like('donaturbaru.kwsn', $keyword['kwsn']);
        $this->db->like('donaturbaru.status', $keyword['status']);
        $this->db->like('donaturbaru.noid', $keyword['noid']);
        $this->db->like('donaturbaru.nama', $keyword['nama']);
        $this->db->like('donaturbaru.alamat', $keyword['alamat']);
        $this->db->like('program.NM_PROGRAM', $keyword['program']);
        $this->db->like('kawasanbaru.kodejgt', $keyword['petugas']);
        return $this->db->get()->result();
    }

    public function keyKoor($keyword) {
        $this->db->select('*');
        $this->db->from('koordinator');
        $this->db->like('nama', $keyword['nama']);
        $this->db->like('alamat', $keyword['alamat']);
        $this->db->like('handphone', $keyword['handphone']);
        return $this->db->get()->result();
    }

    public function keyKwsn($keyword) {
        $this->db->select('kwsn, nm_kawasan, alamat, kodejgt');
        $this->db->from('kawasanbaru');
        $tpublichis->db->like('kwsn', $keyword['kwsn']);
        $this->db->like('nm_kawasan', $keyword['nama']);
        $this->db->like('alamat', $keyword['alamat']);
        return $this->db->get()->result();
    }

     function getKodeKwsn($keyword) {
        $this->db->select('kwsn');
        $this->db->from('kawasanbaru');
        $this->db->like('kwsn', $keyword);
        $this->db->limit(10);
        return $this->db->get()->result();
    }

    // 
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
}




/* End of file Mdonatur.php */

/*
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdonasi extends CI_Model {

    public function getDonatur() {
    	$this->db->select('donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat, donaturbaru.autoid, kawasanbaru.kodejgt');
        $this->db->from('donaturbaru');
        $this->db->like('donaturbaru.noid', $this->input->post('search'));
        $this->db->or_like('donaturbaru.nama', $this->input->post('search'));
        // $this->db->join('donatur_item', 'autoid = donatur_item.noid');
        // $this->db->join('program', 'donatur_item.prog = program.PROG');
        $this->db->join('kawasanbaru', 'donaturbaru.kwsn = kawasanbaru.kwsn');
        $this->db->order_by('donaturbaru.lastupdate','desc');
        $this->db->limit(10,0);
        return $this->db->get()->result();
    }
    public function getProgram() {
    	$this->db->select('PROG,NM_PROGRAM');
        $this->db->from('program');
        $this->db->where('KELOMPOK', $this->input->post('kelompok'));
        $this->db->order_by('PROG','asc');
        return $this->db->get()->result();
    }
    public function getDonaturItem($obj){
        // $where = array('donatur_item.noid' => $obj);
        $this->db->select('program.NM_PROGRAM, donatur_item.besar, donatur_item.keterangan');
        $this->db->from('donatur_item');
        $this->db->join('program', 'donatur_item.prog = program.PROG');
        $this->db->where('donatur_item.noid', $obj);
        return $this->db->get()->result();
    }

    public function getKoor($limit,$offset) {
        $this->db->select('idkoordinator, nama, alamat, handphone, jupen');
        $this->db->from('koordinator');
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }
    
    public function getKawasan($limit,$offset)
    {
        $this->db->select('kwsn,nm_kawasan,alamat,kodejgt');
        $this->db->from('kawasanbaru');
        $this->db->where('nm_kawasan != ""');
        $this->db->where('alamat != ""');
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }


    public function keyDonatur($keyword) {
        $this->db->select('donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat, program.NM_PROGRAM, donatur_item.besar, kawasanbaru.kodejgt');
        $this->db->from('donaturbaru');
        $this->db->join('donatur_item', 'autoid = donatur_item.noid', 'INNER');
        $this->db->join('program', 'donatur_item.prog = program.PROG', 'INNER');
        $this->db->join('kawasanbaru', 'donaturbaru.kwsn = kawasanbaru.kwsn', 'INNER');
        $this->db->like('donaturbaru.kwsn', $keyword['kwsn']);
        $this->db->like('donaturbaru.status', $keyword['status']);
        $this->db->like('donaturbaru.noid', $keyword['noid']);
        $this->db->like('donaturbaru.nama', $keyword['nama']);
        $this->db->like('donaturbaru.alamat', $keyword['alamat']);
        $this->db->like('program.NM_PROGRAM', $keyword['program']);
        $this->db->like('kawasanbaru.kodejgt', $keyword['petugas']);
        return $this->db->get()->result();
    }

    public function keyKoor($keyword) {
        $this->db->select('*');
        $this->db->from('koordinator');
        $this->db->like('nama', $keyword['nama']);
        $this->db->like('alamat', $keyword['alamat']);
        $this->db->like('handphone', $keyword['handphone']);
        return $this->db->get()->result();
    }

    public function keyKwsn($keyword) {
        $this->db->select('kwsn, nm_kawasan, alamat, kodejgt');
        $this->db->from('kawasanbaru');
        $this->db->like('kwsn', $keyword['kwsn']);
        $this->db->like('nm_kawasan', $keyword['nama']);
        $this->db->like('alamat', $keyword['alamat']);
        return $this->db->get()->result();
    }

    public function getKodeKwsn($keyword) {
        $this->db->select('kwsn');
        $this->db->from('kawasanbaru');
        $this->db->like('kwsn', $keyword);
        $this->db->limit(10);
        return $this->db->get()->result();
    }

}
*/
/* End of file Mdonatur.php */
