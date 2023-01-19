<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mdonatur extends CI_Model {

    public function getDonatur($limit,$offset) {
        $this->db->select('count(autoid) as tt_data,donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status,donaturbaru.jupen, donaturbaru.alamat,donaturbaru.almktr, donaturbaru.telphp, donaturbaru.autoid, kawasan.kodejgt');
        $this->db->from('donaturbaru');
        // $this->db->join('donatur_item', 'autoid = donatur_item.noid');
        // $this->db->join('program', 'donatur_item.prog = program.PROG');
        $this->db->join('kawasan', 'donaturbaru.kwsn = kawasan.kwsn');
        $this->db->order_by('donaturbaru.lastupdate','desc');
        $this->db->group_by('autoid');
        if ($offset != 'nol') {
          $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    
    public function getDonaturCab($limit,$offset) {
        $this->db->select('count(autoid) as tt_data,donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat,donaturbaru.almktr, donaturbaru.telphp,donaturbaru.autoid, kawasan.kodejgt');
        $this->db->from('donaturbaru');
        // $this->db->join('donatur_item', 'autoid = donatur_item.noid');
        // $this->db->join('program', 'donatur_item.prog = program.PROG');
        $this->db->join('kawasan', 'donaturbaru.kwsn = kawasan.kwsn');
        $this->db->join('sec_users', 'kawasan.kodejgt = sec_users.kodej');
        $this->db->where('sec_users.idcabang', $this->session->userdata('idcab'));
        $this->db->order_by('donaturbaru.lastupdate','desc');
        $this->db->group_by('autoid');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function getDonaturGrup($limit,$offset) {
        $this->db->select('count(autoid) as tt_data,donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat,donaturbaru.almktr, donaturbaru.telphp,donaturbaru.autoid, kawasan.kodejgt');
        $this->db->from('donaturbaru');
        // $this->db->join('donatur_item', 'autoid = donatur_item.noid');
        // $this->db->join('program', 'donatur_item.prog = program.PROG');
        $this->db->join('kawasan', 'donaturbaru.kwsn = kawasan.kwsn');
        $this->db->join('sec_users', 'kawasan.kodejgt = sec_users.kodej');
        $this->db->where('sec_users.group_id', $this->session->userdata('idgrup'));
        $this->db->order_by('donaturbaru.lastupdate','desc');
        $this->db->group_by('autoid');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function getDonaturUser($limit,$offset) {
        $this->db->select('count(autoid) as tt_data,donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat,donaturbaru.telphp, donaturbaru.autoid, kawasan.kodejgt');
        $this->db->from('donaturbaru');
        // $this->db->join('donatur_item', 'autoid = donatur_item.noid');
        // $this->db->join('program', 'donatur_item.prog = program.PROG');
        $this->db->join('kawasan', 'donaturbaru.kwsn = kawasan.kwsn');
        $this->db->where('kawasan.kodejgt', $this->session->userdata('ses_kodej'));
        $this->db->order_by('donaturbaru.lastupdate','desc');
        $this->db->group_by('autoid');
        $this->db->limit($limit, $offset);
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
        $this->db->from('kawasan');
        $this->db->where('nm_kawasan != ""');
        $this->db->order_by('kwsn', 'DESC');
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }

    public function getKawasanCab($limit,$offset)
    {
        $this->db->select('kwsn,nm_kawasan,alamat,kodejgt');
        $this->db->from('kawasan');
        $this->db->join('sec_users', 'kawasan.kodejgt = sec_users.kodej');
        $this->db->where('idcabang', $this->session->userdata('idcab'));
        $this->db->where('nm_kawasan != ""');
        $this->db->order_by('kwsn', 'DESC');
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }

    public function getKawasanGrup($limit,$offset)
    {
        $this->db->select('kwsn,nm_kawasan,alamat,kodejgt');
        $this->db->from('kawasan');
        $this->db->join('sec_users', 'kawasan.kodejgt = sec_users.kodej');
        $this->db->where('group_id', $this->session->userdata('idgrup'));
        $this->db->where('nm_kawasan != ""');
        $this->db->where('alamat != ""');
        $this->db->order_by('kwsn', 'DESC');
        $this->db->limit($limit,$offset);
        return $this->db->get()->result();
    }

    public function keyDonatur($keyword) {
        $this->db->select('donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat, program.NM_PROGRAM, donatur_item.besar, kawasan.kodejgt');
        $this->db->from('donaturbaru');
        $this->db->join('donatur_item', 'autoid = donatur_item.noid', 'INNER');
        $this->db->join('program', 'donatur_item.prog = program.PROG', 'INNER');
        $this->db->join('kawasan', 'donaturbaru.kwsn = kawasan.kwsn', 'INNER');
        $this->db->like('donaturbaru.kwsn', $keyword['kwsn']);
        $this->db->like('donaturbaru.status', $keyword['status']);
        $this->db->like('donaturbaru.noid', $keyword['noid']);
        $this->db->like('donaturbaru.nama', $keyword['nama']);
        $this->db->like('donaturbaru.alamat', $keyword['alamat']);
        $this->db->like('program.NM_PROGRAM', $keyword['program']);
        $this->db->like('kawasan.kodejgt', $keyword['petugas']);
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
        $this->db->from('kawasan');
        $this->db->like('kwsn', $keyword['kwsn']);
        $this->db->like('nm_kawasan', $keyword['nama']);
        $this->db->like('alamat', $keyword['alamat']);
        return $this->db->get()->result();
    }

    public function getKodeKwsn($keyword) {
        $this->db->select('kwsn');
        $this->db->from('kawasan');
        $this->db->like('kwsn', $keyword);
        $this->db->limit(10);
        return $this->db->get()->result();
    }

}

/* End of file Mdonatur.php */
