<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mangsuran extends CI_Model {

    public function getKaryawanAll(){
        $this->db->select('NAMA as nama,NIP as nip');
        $this->db->from('u_karyawan');
        $query=$this->db->get();
        return $query->result();
    }

    public function getAngsuran(){
        $this->db->select('*');
        $this->db->from('u_bvrbl');
        $this->db->where('angsuran = "1"');
        return $this->db->get()->result();
    }

    public function getKaryawanGrup(){
        $this->db->select('u_karyawan.NAMA as nama,u_karyawan.NIP as nip');
        $this->db->from('u_karyawan');
        $this->db->join('sec_users','u_karyawan.NIP = sec_users.nip');
        $this->db->where('sec_users.group_id',$this->session->userdata('idgrup'));
        $query=$this->db->get();
        return $query->result();
    }

    public function getKaryawanCabang(){
        $this->db->select('u_karyawan.NAMA as nama,u_karyawan.NIP as nip');
        $this->db->from('u_karyawan');
        $this->db->join('sec_users','u_karyawan.NIP = sec_users.nip');
        $this->db->where('sec_users.group_id',$this->session->userdata('idcab'));
        $query=$this->db->get();
        return $query->result();
    }

    public function getDataUser(){
        $this->db->select('u_karyawan.NAMA as nama,u_karyawan.NIP as nip');
        $this->db->from('u_karyawan');
        $this->db->join('sec_users','u_karyawan.NIP = sec_users.nip');
        $this->db->where('sec_users.usrid',$this->session->userdata('usrid'));
        $query=$this->db->get();
        return $query->result();
    }


    public function getData($angsuran,$karyawan,$tahun){
        $this->db->select('*');
        $this->db->from('vw_kry_angs');
        $this->db->where('tahun',$tahun);
        $this->db->where('id_vrb',$angsuran);
        $this->db->where('nip',$karyawan);
        // $this->db->group_by('id_vrb_group');
        $query=$this->db->get();
        return $query->result();
    }
}

/* End of file Mvalkasir.php */
