<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mpage extends CI_Model
{
    private $table = "sec_users";
    private $table_prl = "vw_prl_tot";
    private $table_report = "report_tagih";
    public $usrid;
    public $login;
    public $pswd;
    public $name;
    public $email;
    public $active;
    public $activation_code;
    public $priv_admin;
    public $idcabang;
    public $idpusat;
    public $group_id;
    public $kodej;
    public $kodep;
    public $level;
    public $tbh_akun;
    public $id_pintu;
    public $id_gerai;
    public $hak;
    public $sal_kodej;
    public $nip;
    public $lapangan;

    public function cekCabang()
    {
        return $this->db->get("cabang")->result();
    }

    public function getCount()
    {
        $post = $this->input->post();
        $this->db->select('COUNT(*) as total');
        $this->db->from($this->table_prl);
        $this->db->where(["kodej" => $post["kodej"]]);
        $query = $this->db->get();
        return $query->row();
    }

    public function getAll()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $query = $this->db->get();
        return $query->result();
    }

    public function getPtgs()
    {
        $post = $this->input->post();
        $this->db->select('name,kodej');
        $this->db->from($this->table);
        $this->db->where(["kodej" => $post["kodej"]]);
        $query = $this->db->get();
        return $query->row();
    }

    public function getPrltot()
    {
        $post = $this->input->post();
        return $this->db->get_where($this->table_prl, ["kodej" => $post["kodej"]])->result();
        // $this->db->select('*');
        // $this->db->from($this->table_report);
        // $this->db->join($this->table_prl, 'report_tagih.kodej=vw_prl_tot.kodej');
        // $this->db->where(["report_tagih.kodej" => $post["kodej"]]);
        // $this->db->where("date(report_tagih.tanggal) >= '".$tanggal1."%'");
        // $this->db->where("date(report_tagih.tanggal) <= '".$tanggal2."%'");
        // $query = $this->db->get();
        // return $query->result();
    }

    public function getAllTwo($idcabang)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $this->db->where(["idcabang" => $idcabang]);
        $query = $this->db->get();
        return $query->result();
    }


    public function getAllThree($kodej)
    {
        return $this->db->get_where($this->table, ["kodej" => $kodej])->row();
    }

    public function getAllFour($idgrup)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $this->db->where(["group_id" => $idgrup]);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPerJungut($kodej)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('kodej > 0');
        $this->db->where("lapangan = 'A'");
        $this->db->where(["kodej" => $kodej]);
        $query = $this->db->get();
        return $query->result();
    }


    public function getUsrid()
    {
        $this->db->select('usrid');
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUserById($id)
    {
        return $this->db->get_where($this->table, ["usrid" => $id])->row();
    }

    public function addUser()
    {
        $post = $this->input->post();
        $this->usrid = $post["usrid"];
        $this->login = $post["username"];
        $this->pswd = $post["password"];
        $this->name = $post["name"];
        $this->email = $post["email"];
        $this->active = $post["active"];
        $this->activation_code = $post["activcode"];
        $this->priv_admin = $post["privadmin"];
        $this->idcabang = $post["idcabang"];
        $this->idpusat = $post["idpusat"];
        $this->group_id = $post["idgroup"];
        $this->kodej = $post["kodej"];
        $this->kodep = $post["kodep"];
        $this->level = $post["level"];
        $this->tbh_akun = $post["tbh_akun"];
        $this->id_pintu = $post["idpintu"];
        $this->id_gerai = $post["idgerai"];
        $this->hak = $post["hak"];
        $this->sal_kodej = $post["salkodej"];
        $this->nip = $post["nip"];
        $this->lapangan = $post["lapangan"];
        $this->db->insert($this->table, $this);
    }

    public function updateUser()
    {
        $post = $this->input->post();
        $this->usrid = $post["usrid"];
        $this->login = $post["username"];
        $this->pswd = $post["password"];
        $this->name = $post["name"];
        $this->email = $post["email"];
        $this->active = $post["active"];
        $this->activation_code = $post["activcode"];
        $this->priv_admin = $post["privadmin"];
        $this->idcabang = $post["idcabang"];
        $this->idpusat = $post["idpusat"];
        $this->group_id = $post["idgroup"];
        $this->kodej = $post["kodej"];
        $this->kodep = $post["kodep"];
        $this->level = $post["level"];
        $this->tbh_akun = $post["tbh_akun"];
        $this->id_pintu = $post["idpintu"];
        $this->id_gerai = $post["idgerai"];
        $this->hak = $post["hak"];
        $this->sal_kodej = $post["salkodej"];
        $this->nip = $post["nip"];
        $this->lapangan = $post["lapangan"];
        $this->db->update($this->table, $this, array("usrid" => $post["usrid"]));
    }

    public function deleteUser($id)
    {
        return $this->db->delete($this->table, array("usrid" => $id));
    }
    public function Target()
    {
        $where = " month(now()) = Bulan AND year(now()) = tahun ";
        $this->db->select('sum(infaq) as Total  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function Tertagih()
    {
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) ";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function Keuangan()
    {
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) AND validasi='y'";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifUmur20()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) < '20' AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur20AllTime()
    {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("tgllahir != '0000-00-00' AND year(now())-year(tgllahir) < '20' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur2030()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '20' AND year(now())-year(donaturbaru.tgllahir) < 30 AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur2030AllTime()
    {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("tgllahir != '0000-00-00' AND year(now())-year(tgllahir) >= '20' AND year(now())-year(tgllahir) < 30 AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }



    public function aktifUmur3040()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '30' AND year(now())-year(donaturbaru.tgllahir) < 40 AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur3040AllTime()
    {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("tgllahir != '0000-00-00' AND year(now())-year(tgllahir) >= '30' AND year(now())-year(tgllahir) < 40 AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur4050()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '40' AND year(now())-year(donaturbaru.tgllahir) < 50 AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur4050AllTime()
    {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("tgllahir != '0000-00-00' AND year(now())-year(tgllahir) >= '40' AND year(now())-year(tgllahir) < 50 AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur50()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '50' AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur50AllTime()
    {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("tgllahir != '0000-00-00' AND year(now())-year(tgllahir) >= '50' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function unknownAktifUmur()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND donaturbaru.tgllahir = '0000-00-00' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function unknownAktifUmurAllTime()
    {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("tgllahir = '0000-00-00' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifKelaminL()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.sex = 'l' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifKelaminLAllTime() {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("sex = 'l' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifKelaminP()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.sex = 'p' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifKelaminPAllTime() {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("sex = 'p' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function unknownAktifKelamin()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.sex = '' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function unknownAktifKelaminAllTime() {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("sex = '' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifYesTelp()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.telphp != '' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifYesTelpAllTime() {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("telphp != '' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifNoTelp()
    {
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.telphp = '' AND donaturbaru.status = 'A'";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifNoTelpAllTime() {
        $this->db->select('count(noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->where("telphp = '' AND status = 'A'");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifSetor20()
    {
        $where = "infaq < '20000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A'";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor20AllTime() {
        $where = "infaq < '20000' AND donaturbaru.status = 'A'";
        $this->db->select('count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru','tagihandonatur.noid_new = donaturbaru.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;  
    }

    public function aktifSetor2030()
    {
        $where = "infaq >= '20000' AND infaq < '30000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A'";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor2030AllTime() {
        $where = "infaq >= '20000' AND infaq < '30000' AND donaturbaru.status = 'A'";
        $this->db->select('count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru','tagihandonatur.noid_new = donaturbaru.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor3050()
    {
        $where = "infaq >= '30000' AND infaq < '50000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A'";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor3050AllTime() {
        $where = "infaq >= '30000' AND infaq < '50000' AND donaturbaru.status = 'A'";
        $this->db->select('count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru','tagihandonatur.noid_new = donaturbaru.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor50100()
    {
        $where = "infaq >= '50000' AND infaq <= '100000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A'";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor50100AllTime() {
        $where = "infaq >= '50000' AND infaq <= '100000' AND donaturbaru.status = 'A'";
        $this->db->select('count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru','tagihandonatur.noid_new = donaturbaru.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor100()
    {
        $where = "infaq > '100000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A'";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor100AllTime() {
        $where = "infaq > '100000' AND donaturbaru.status = 'A'";
        $this->db->select('count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru','tagihandonatur.noid_new = donaturbaru.noid','left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function TargetCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = " month(now()) = Bulan AND year(now()) = tahun AND sec_users.idcabang = $idcabang";
        $this->db->select('sum(infaq) as Total');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function TertagihCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) AND sec_users.idcabang=$idcabang ";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'keu_j.entr_pegawai=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function KeuanganCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) AND validasi='y' AND sec_users.idcabang=$idcabang ";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'keu_j.entr_pegawai=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifUmur20Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) < '20' AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total, sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur20CabangAllTime() {
        $idcabang = $this->session->userdata('idcab');

        $this->db->select('count(donaturbaru.noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej');
        $this->db->where("donaturbaru.tgllahir != '0000-00-00' AND year(now())-year(donaturbaru.tgllahir) < '20' AND status = 'A' AND sec_users.idcabang = $idcabang");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur2030Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '20' AND year(now())-year(donaturbaru.tgllahir) < '30' AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total, sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur2030CabangAllTime() {
        $idcabang = $this->session->userdata('idcab');

        $this->db->select('count(donaturbaru.noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej');
        $this->db->where("donaturbaru.tgllahir != '0000-00-00' AND year(now())-year(donaturbaru.tgllahir) >= '20' AND year(now())-year(donaturbaru.tgllahir) < '30' AND status = 'A' AND sec_users.idcabang = $idcabang");
        $hasil = $this->db->get();
        return $hasil->result();
    }



    public function aktifUmur3040Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '30' AND year(now())-year(donaturbaru.tgllahir) < '40' AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total, sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur3040CabangAllTime() {
        $idcabang = $this->session->userdata('idcab');

        $this->db->select('count(donaturbaru.noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej');
        $this->db->where("donaturbaru.tgllahir != '0000-00-00' AND year(now())-year(donaturbaru.tgllahir) >= '30' AND year(now())-year(donaturbaru.tgllahir) < '40' AND status = 'A' AND sec_users.idcabang = $idcabang");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur4050Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '40' AND year(now())-year(donaturbaru.tgllahir) < '50' AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total, sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur4050CabangAllTime() {
        $idcabang = $this->session->userdata('idcab');

        $this->db->select('count(donaturbaru.noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej');
        $this->db->where("donaturbaru.tgllahir != '0000-00-00' AND year(now())-year(donaturbaru.tgllahir) >= '40' AND year(now())-year(donaturbaru.tgllahir) < '50' AND status = 'A' AND sec_users.idcabang = $idcabang");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur50Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donaturbaru.tgllahir) >= '50' AND donaturbaru.tgllahir != '0000-00-00' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total, sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur50CabangAllTime() {
        $idcabang = $this->session->userdata('idcab');

        $this->db->select('count(donaturbaru.noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej');
        $this->db->where("donaturbaru.tgllahir != '0000-00-00' AND year(now())-year(donaturbaru.tgllahir) >= '50' AND status = 'A' AND sec_users.idcabang = $idcabang");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function unknownAktifUmurCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND donaturbaru.tgllahir = '0000-00-00' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total, sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id = donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function unknownAktifUmurCabangAllTime() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('count(donaturbaru.noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej');
        $this->db->where("donaturbaru.tgllahir = '0000-00-00' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifKelaminLCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.sex = 'l' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifKelaminLCabangAllTime() {
        $idcabang = $this->session->userdata('idcab');
        $query = "select count(donaturbaru.noid) as Total FROM donaturbaru JOIN sec_users ON donaturbaru.jupen = sec_users.sal_kodej WHERE donaturbaru.tgllahir != '0000-00-00' AND year(now())-year(tgllahir) < '20' AND status = 'A' AND sec_users.idcabang = 4";
        $this->db->select('count(donaturbaru.noid) as Total');
        $this->db->from('donaturbaru');
        $this->db->join('sec_users', 'donaturbaru.jupen = sec_users.kodej', 'left');
        $this->db->where("sex = 'l' AND status = 'A' AND sec_users.idcabang = $idcabang");
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifKelaminPCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.sex = 'p' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifKelaminPCabangAllTime() {
        // masih belum 
    }

    public function unknownAktifKelaminCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.sex = '' AND donaturbaru.status = 'A' AND sec_users.idcabang = $idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej = sec_users.kodej', 'left');
        // $this->db->join('donatur','tagihandonatur.id=donatur.autoid','left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifYesTelpCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.telphp != '' AND donaturbaru.status = 'A' AND sec_users.idcabang=$idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total, sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifNoTelpCabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donaturbaru.telphp = '' AND donaturbaru.status = 'A' AND sec_users.idcabang=$idcabang";
        $this->db->select('count(distinct tagihandonatur.noid_new) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor20Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "infaq < '20000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A' AND sec_users.idcabang=$idcabang";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor2030Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "infaq >= '20000' AND infaq < '30000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A' AND sec_users.idcabang=$idcabang";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor3050Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "infaq >= '30000' AND infaq < '50000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A' AND sec_users.idcabang=$idcabang";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor50100Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "infaq >= '50000' AND infaq <= '100000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A' AND sec_users.idcabang=$idcabang";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifSetor100Cabang()
    {
        $idcabang = $this->session->userdata('idcab');
        $where = "infaq > '100000' AND month(now()) = Bulan AND year(now()) = tahun AND donaturbaru.status = 'A' AND sec_users.idcabang=$idcabang";
        $this->db->select('sum(infaq) as Total,count(distinct noid_new) as Orang');
        $this->db->from('tagihandonatur');
        $this->db->join('donaturbaru', 'tagihandonatur.noid_new = donaturbaru.noid', 'left');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function TargetGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = " month(now()) = Bulan AND year(now()) = tahun AND sec_users.group_id= $idgroup";
        $this->db->select('sum(infaq) as Total  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function TertagihGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) AND sec_users.group_id=$idgroup";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'keu_j.entr_pegawai=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function KeuanganGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) AND validasi='y' AND sec_users.group_id=$idgroup";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'keu_j.entr_pegawai=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifUmur20Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donatur.tgllahir) < '20' AND donatur.tgllahir != '0000-00-00' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur2030Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '20' AND year(now())-year(donatur.tgllahir) <30 AND donatur.tgllahir != '0000-00-00' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }



    public function aktifUmur3040Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '30' AND year(now())-year(donatur.tgllahir) <40 AND donatur.tgllahir != '0000-00-00' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifUmur4050Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '40' AND year(now())-year(donatur.tgllahir) <50 AND donatur.tgllahir != '0000-00-00' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifUmur50Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '50' AND donatur.tgllahir != '0000-00-00' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function unknownAktifUmurGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND donatur.tgllahir  = '0000-00-00' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifKelaminLGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '50' AND donatur.sex = 'l' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifKelaminPGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donatur.sex = 'p' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function unknownAktifKelaminGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND donatur.sex = '' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifYesTelpGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donatur.telphp != '' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifNoTelpGroup()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donatur.telphp = '' AND sec_users.group_id=$idgroup";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor20Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "infaq < '20000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.group_id=$idgroup";
        $this->db->select('sum(infaq) as Total,count(infaq) as Orang  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor2030Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "infaq >= '20000' AND infaq < '30000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.group_id= $idgroup";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor3050Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "infaq >= '30000' AND infaq < '50000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.group_id=$idgroup";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor50100Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "infaq >= '50000' AND infaq <= '100000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.group_id=$idgroup";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor100Group()
    {
        $idgroup = $this->session->userdata('idgrup');
        $where = "infaq > '100000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.group_id=$idgroup";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function TargetUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = " month(now()) = Bulan AND year(now()) = tahun AND sec_users.kodej=$iduser";
        $this->db->select('sum(infaq) as Total  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function TertagihUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) AND sec_users.kodej=$iduser";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'keu_j.entr_pegawai=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function KeuanganUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "month(now())=month(tgl_setor) and year(now())=year(tgl_setor) AND validasi='y' AND sec_users.kodej=$iduser";
        $this->db->select('sum(jml) as Total  ');
        $this->db->from('keu_j');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'keu_j.entr_pegawai=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifUmur20User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND year(now())-year(donatur.tgllahir) < '20' AND donatur.tgllahir != '0000-00-00' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get();
        return $hasil->result();
    }

    public function aktifUmur2030User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '20' AND year(now())-year(donatur.tgllahir) <30 AND donatur.tgllahir != '0000-00-00' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total,sum(tagihandonatur.infaq) as Infaq');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }



    public function aktifUmur3040User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '30' AND year(now())-year(donatur.tgllahir) <40 AND donatur.tgllahir != '0000-00-00' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifUmur4050User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '40' AND year(now())-year(donatur.tgllahir) <50 AND donatur.tgllahir != '0000-00-00' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifUmur50User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '50' AND donatur.tgllahir != '0000-00-00' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function unknownAktifUmurUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND donatur.tgllahir  = '0000-00-00' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function aktifKelaminLUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND year(now())-year(donatur.tgllahir) >= '50' AND donatur.sex = 'l' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifKelaminPUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donatur.sex = 'p' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function unknownAktifKelaminUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun AND donatur.sex = '' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifYesTelpUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donatur.telphp != '' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifNoTelpUser()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "tagihandonatur.infaq != '0' AND month(now()) = tagihandonatur.Bulan AND year(now()) = tagihandonatur.tahun  AND donatur.telphp = '' AND sec_users.kodej=$iduser";
        $this->db->select('count(tagihandonatur.infaq) as Total ,sum(tagihandonatur.infaq) as Infaq ');
        $this->db->from('tagihandonatur');
        $this->db->join('donatur', 'tagihandonatur.noid_new = donatur.noid', 'left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor20User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "infaq < '20000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.kodej=$iduser";
        $this->db->select('sum(infaq) as Total,count(infaq) as Orang  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor2030User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "infaq >= '20000' AND infaq < '30000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.kodej= $iduser";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor3050User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "infaq >= '30000' AND infaq < '50000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.kodej=$iduser";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor50100User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "infaq >= '50000' AND infaq <= '100000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.kodej=$iduser";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang  ');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
    public function aktifSetor100User()
    {
        $iduser = $this->session->userdata('ses_kodej');
        $where = "infaq > '100000' AND month(now()) = Bulan AND year(now()) = tahun AND sec_users.kodej=$iduser";
        $this->db->select('sum(infaq) as Total, count(infaq) as Orang');
        $this->db->from('tagihandonatur');
        // $this->db->join('donatur','tagihandonatur.noid_new = donatur.noid','left');
        $this->db->join('sec_users', 'tagihandonatur.kodej=sec_users.kodej', 'left');
        $this->db->where($where);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function targetJungut() {
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function targetJungutCabang() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.idcabang = $idcabang");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function targetJungutGroup() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function presentaseJungut() {
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function presentaseJungutCabang() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.idcabang = $idcabang");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function presentaseJungutGroup() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function presentaseJungutv2() {
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $this->db->limit(30);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function presentaseJungutCabangv2() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.idcabang = $idcabang");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $this->db->limit(30);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function presentaseJungutGroupv2() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.name as Nama, vw_harian_gabung.h_dns as Hasil');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $this->db->limit(30);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function JungutSetahun() {
        $this->db->select('vw_dasbot_persentase.*, sec_users.name as Nama');
        $this->db->from('vw_dasbot_persentase');
        $this->db->join('sec_users', 'vw_dasbot_persentase.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        $this->db->order_by('vw_dasbot_persentase.persen_rata2', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function JungutSetahunCabang() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_dasbot_persentase.*, sec_users.name as Nama');
        $this->db->from('vw_dasbot_persentase');
        $this->db->join('sec_users', 'vw_dasbot_persentase.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.idcabang = $idcabang");
        $this->db->order_by('vw_dasbot_persentase.persen_rata2', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function JungutSetahunGroup() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_dasbot_persentase.*, sec_users.name as Nama');
        $this->db->from('vw_dasbot_persentase');
        $this->db->join('sec_users', 'vw_dasbot_persentase.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        $this->db->order_by('vw_dasbot_persentase.persen_rata2', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function grafikJungutSetahun() {
        $this->db->select('vw_dasbot_persentase.persen_rata2 as RataRata, sec_users.name as Nama');
        $this->db->from('vw_dasbot_persentase');
        $this->db->join('sec_users', 'vw_dasbot_persentase.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        $this->db->order_by('vw_dasbot_persentase.persen_rata2', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function grafikJungutSetahunCabang() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_dasbot_persentase.persen_rata2 as RataRata, sec_users.name as Nama');
        $this->db->from('vw_dasbot_persentase');
        $this->db->join('sec_users', 'vw_dasbot_persentase.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.idcabang = $idcabang");
        $this->db->order_by('vw_dasbot_persentase.persen_rata2', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function grafikJungutSetahunGroup() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_dasbot_persentase.persen_rata2 as RataRata, sec_users.name as Nama');
        $this->db->from('vw_dasbot_persentase');
        $this->db->join('sec_users', 'vw_dasbot_persentase.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        $this->db->order_by('vw_dasbot_persentase.persen_rata2', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function daftarNamaCabang() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('nm_cabang as Cabang');
        $this->db->from('cabang');
        $this->db->where("id_cab = $idcabang");
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function donaturMasukKeluar() {
        $this->db->select('vw_dasbt_gabung.*, sec_users.name as Nama');
        $this->db->from('vw_dasbt_gabung');
        $this->db->join('sec_users', 'vw_dasbt_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function donaturMasukKeluarCabang() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_dasbt_gabung.*, sec_users.name as Nama');
        $this->db->from('vw_dasbt_gabung');
        $this->db->join('sec_users', 'vw_dasbt_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND vw_dasbt_gabung.idcabang = $idcabang");
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function donaturMasukKeluarGroup() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_dasbt_gabung.*, sec_users.name as Nama');
        $this->db->from('vw_dasbt_gabung');
        $this->db->join('sec_users', 'vw_dasbt_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function laporanHarian() {
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.h_dns as Hasil, sec_users.name as Nama');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function laporanHarianCabang() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.h_dns as Hasil, sec_users.name as Nama');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.idcabang = $idcabang");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function laporanHarianGroup() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.h_dns as Hasil, sec_users.name as Nama');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function laporanHarianv2() {
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.h_dns as Hasil, sec_users.name as Nama');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2'");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $this->db->limit(30);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function laporanHarianCabangv2() {
        $idcabang = $this->session->userdata('idcab');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.h_dns as Hasil, sec_users.name as Nama');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.idcabang = $idcabang");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $this->db->limit(30);
        $hasil = $this->db->get()->result();
        return $hasil;
    }

    public function laporanHarianGroupv2() {
        $idgroup = $this->session->userdata('idgrup');
        $this->db->select('vw_harian_gabung.t_dns as Target, vw_harian_gabung.h_dns as Hasil, sec_users.name as Nama');
        $this->db->from('vw_harian_gabung');
        $this->db->join('sec_users', 'vw_harian_gabung.kodej = sec_users.kodej');
        $this->db->where("sec_users.id_pintu = '2' AND sec_users.group_id = $idgroup");
        // $this->db->order_by('vw_harian_gabung.h_dns', 'DESC');
        $this->db->limit(30);
        $hasil = $this->db->get()->result();
        return $hasil;
    }
}
/* End of file Mpage.php */
