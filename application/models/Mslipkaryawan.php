<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mslipkaryawan extends CI_Model {

    public function getKaryawanAll(){
        $this->db->select('NAMA as nama,NIP as nip');
        $this->db->from('u_karyawan');
        $query=$this->db->get();
        return $query->result();
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

    public function getSlip(){
        $this->db->select('*');
        $this->db->from('u_bvrggrop');
        $query=$this->db->get();
        return $query->result();
    }

    public function getData($bulan,$tahun,$slip,$karyawan){
        $this->db->select('nip, NAMA,kantor,status,Bagian,sum(case when nilai = -1 then -1 * jumlah else jumlah end) as jumlah,nm_Group,nm_ggroup,nomer,id_vrb_group,bulan,tahun,id_ggroup');
        $this->db->from('vw_kryg');
        $this->db->where('bulan',$bulan);
        $this->db->where('tahun',$tahun);
        $this->db->where('id_ggroup',$slip);
        $this->db->where('nip',$karyawan);
        $this->db->group_by('id_vrb_group');
        $query=$this->db->get();
        return $query;
    }

    public function getDetail($id,$bulan,$tahun,$slip,$karyawan){
        $this->db->select('case when id_vrb_group = "'.$id.'" then nm_uraian end as nm_uraian,case when id_vrb_group = "'.$id.'" and nilai = -1 then -1 * jumlah else jumlah end as jumlah_uraian',FALSE);
        $this->db->from('vw_kryg');
        $this->db->where('bulan',$bulan);
        $this->db->where('tahun',$tahun);
        $this->db->where('id_ggroup',$slip);
        $this->db->where('nip',$karyawan);
        $this->db->having('nm_uraian is not null');
        $query=$this->db->get();
        return $query->result();
    }
}

/* End of file Mvalkasir.php */
