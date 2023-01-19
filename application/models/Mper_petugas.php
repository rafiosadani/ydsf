<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Mper_petugas extends CI_Model {

        public function getCabang() {
            $this->db->select('*');
            $this->db->from('cabang');
            $this->db->order_by('id_cab','ASC');
            return $this->db->get()->result();
        }
        
        public function getCabangCab() {
            $this->db->select('*');
            $this->db->from('cabang');
            $this->db->where('id_cab', $this->session->userdata('idcab'));
            $this->db->order_by('id_cab','ASC');
            return $this->db->get()->result();
        }
    
        public function getCabangGrup() {
            $this->db->select('*');
            $this->db->from('cabang');
            $this->db->where('id_group', $this->session->userdata('idgrup'));
            $this->db->order_by('id_cab','ASC');
            return $this->db->get()->result();
        }

        public function getAll() {
            $this->db->select('*');
            $this->db->from('sec_users');
            $this->db->where('kodej > 0');
            $this->db->where("lapangan = 'A'");
            $query = $this->db->get();
            return $query->result();
        }

        public function getAllTwo($idcabang) {
            $this->db->select('*');
            $this->db->from('sec_users');
            $this->db->where('kodej > 0');
            $this->db->where("lapangan = 'A'");
            $this->db->where(["idcabang" => $idcabang]);
            $query = $this->db->get();
            return $query->result();
        }

        public function rekapPerPetugas($bulan,$tahun,$idcabang){
            $this->db->select('sec_users.name as nama , prestasi_kwsn.KODEJ as kodej ,sum(T_DNT) as T_DNT,sum(T_DNS) as T_DNS,sum(H_DNT) as H_DNT,sum(H_DNS) as H_DNS,sum(G_DNT) as G_DNT,sum(G_DNS) as G_DNS,sum(L_DNT) as L_DNT,sum(L_DNS) as L_DNS,sum(TT_DNT) as TT_DNT,sum(TT_DNS) as TT_DNS ');
            $this->db->from('prestasi_kwsn');
            $this->db->join('sec_users','prestasi_kwsn.KODEJ = sec_users.kodej');
            // $this->db->where('prestasi_kwsn.KODEJ', $kodej);
            $this->db->where('sec_users.idcabang', $idcabang);
            $this->db->where('BLN', $bulan);
            $this->db->where('THN', $tahun);
            $this->db->group_by('prestasi_kwsn.KODEJ');
            $query = $this->db->get();
            return $query->result();   
        }

        public function rekapPerPetugasJungut($kodej,$bulan,$tahun,$idcabang){
            $this->db->select('sec_users.name as nama , prestasi_kwsn.KODEJ as kodej ,sum(T_DNT) as T_DNT,sum(T_DNS) as T_DNS,sum(H_DNT) as H_DNT,sum(H_DNS) as H_DNS,sum(G_DNT) as G_DNT,sum(G_DNS) as G_DNS,sum(L_DNT) as L_DNT,sum(L_DNS) as L_DNS,sum(TT_DNT) as TT_DNT,sum(TT_DNS) as TT_DNS ');
            $this->db->from('prestasi_kwsn');
            $this->db->join('sec_users','prestasi_kwsn.KODEJ = sec_users.kodej');
            $this->db->where('prestasi_kwsn.KODEJ', $kodej);
            $this->db->where('sec_users.idcabang', $idcabang);
            $this->db->where('BLN', $bulan);
            $this->db->where('THN', $tahun);
            $this->db->group_by('prestasi_kwsn.KODEJ');
            $query = $this->db->get();
            return $query->result();   
        }

        public function rekapPerPetugasAll($bulan,$tahun){
            $this->db->select('sec_users.name as nama , prestasi_kwsn.KODEJ as kodej ,sum(T_DNT) as T_DNT,sum(T_DNS) as T_DNS,sum(H_DNT) as H_DNT,sum(H_DNS) as H_DNS,sum(G_DNT) as G_DNT,sum(G_DNS) as G_DNS,sum(L_DNT) as L_DNT,sum(L_DNS) as L_DNS,sum(TT_DNT) as TT_DNT,sum(TT_DNS) as TT_DNS ');
            $this->db->from('prestasi_kwsn');
            $this->db->join('sec_users','prestasi_kwsn.KODEJ = sec_users.kodej');
            // $this->db->where('sec_users.idcabang', $idcabang);
            $this->db->where('BLN', $bulan);
            $this->db->where('THN', $tahun);
            $this->db->group_by('prestasi_kwsn.KODEJ');
            $query = $this->db->get();
            return $query->result();   
        }

        public function getPetugasAll($idcabang){
            $this->db->select('name ,cabang.nm_cabang as nama_cabang ');
            $this->db->from('sec_users');
            $this->db->join('cabang','sec_users.idcabang = cabang.id_cab');
            $this->db->where('sec_users.idcabang',$idcabang);
            $query=$this->db->get();
            return $query->row();
        }

        public function getPetugas($jungut,$idcabang){
            $this->db->select('name , kodej ,cabang.nm_cabang as nama_cabang ');
            $this->db->from('sec_users');
            $this->db->join('cabang','sec_users.idcabang = cabang.id_cab');
            $this->db->where('kodej',$jungut);
            $this->db->where('sec_users.idcabang',$idcabang);
            $query=$this->db->get();
            return $query->row();
        }
}

/* End of file Mper_petugas.php */
