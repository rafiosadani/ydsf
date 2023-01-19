<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_donasi extends CI_Model {
    public function donasiItem($where) {
        $this->db->select('*');
        $this->db->from('donatur_item');
        $this->db->join('program','donatur_item.prog = program.PROG');
        $this->db->where($where);
        //return $this->db->get()->row();
        return $this->db->get()->result_array();
    }

    public function getRow($table,$where)
    {
        $data = $this->db->get_where($table,$where)->row();
        return $data;
    }
    public function query($query)
    {
        $data = $this->db->query($query)->result();
        return $data;
    }
    public function insertDonasi($last)
    {
        // $last_id = $this->db->query("select autoid from donaturbaru ORDER BY autoid DESC limit 1")->row();
        $object = array(
            //hidden
            'noid'          => sprintf("%010s",intval($last)+1),
            //tab1
            'status'        => $this->input->post('status'),
            'nama'          => $this->input->post('nama'),
            'tgllahir'      => date('Y-m-d' , strtotime($this->input->post('tgllahir'))),
            'tmplahir'      => $this->input->post('tmplahir'),
            'sex'           => $this->input->post('gender'),
            'kwsn'          => $this->input->post('kwsn'),
            'jupen'         => $this->input->post('jupen'),
            'alamat'        => $this->input->post('alamat'),
            'almktr'        => $this->input->post('alamatktr'),
            'tlprmh'        => $this->input->post('tlprmh'),
            'telphp'        => $this->input->post('tlphp'),
            'telphp2'       => $this->input->post('tlphp2'),
            'tlphp3'        => $this->input->post('tlphp3'),
            'tlpktr'        => $this->input->post('tlpktr'),
            'faxktr'        => $this->input->post('faxktr'),
            'jupen'         => $this->input->post('jupen'),
            //tab 2
            'email'         => $this->input->post('email'),
            'carabyr'       => $this->input->post('crbyr'),
            'rekdonatur'    => $this->input->post('rekdonatur'),
            'bank'          => $this->input->post('bank'),
            'kolektif'      => $this->input->post('kolektif'),
            'waktu_tagih'   => $this->input->post('waktu_tagih'),
            'npwp'          => $this->input->post('npwp'),
            //tab 3
            'info'          => $this->input->post('info'),
            'pekerjaan'     => $this->input->post('pekerjaan'),
            'gaji'          => $this->input->post('gaji'),
            'entri_pegawai' => $this->session->userdata('usrid'),
            'pendidikan'    => $this->input->post('pendidikan'),
            'hobby'         => $this->input->post('hobby'),
            'jabatan'       => $this->input->post('jabatan'),
            'koderk'        => $this->input->post('rk'),
            'valid'         => 'Y',
            'lastupdate'    => date('Y-m-d h:i:s'),
            'tglm'          => date('Y-m-d')
        );
        $this->db->insert('donaturbaru', $object);
        // return $last_id->autoid+1;
    }
    public function insertDonaturItem($last)
    {
        // $last_id = $this->db->query("select autoid from donaturbaru ORDER BY autoid DESC limit 1")->row();
        foreach(json_decode($this->input->post('donaturItem')) as $item) {
            if ($item[2] == NULL || !isset($item[2])) {
                 $object = array(
                    'prog' => $item[0],
                    'besar' => $item[1],
                    'entri_pegawai' => $this->session->userdata('usrid'),
                    'noid' => intval($last)+1,
                    'ap' => 'A',
                    'entri_tgl' => date('Y-m-d'),
                    // 'tglap' => date('Y-m-d'),
                );
            } else {
                $object = array(
                    'prog' => $item[0],
                    'besar' => $item[1],    
                    'keterangan' => $item[2],
                    'entri_pegawai' => $this->session->userdata('usrid'),
                    'noid' => intval($last)+1,
                    'ap' => 'A',
                    'entri_tgl' => date('Y-m-d'),
                    // 'tglap' => date('Y-m-d'),
                );
            }
            $this->db->insert('donatur_item', $object);
        }
        // echo "<pre>";
        // print_r(json_decode($this->input->post('donaturItem')));
        // echo "</pre>";return;
    }
    public function insertKoor()
    {
        $object = array(
            'nama'          => $this->input->post('nama'),
            'tempatlahir'   => $this->input->post('tmplahir'),
            'tanggallahir'  => date('Y-m-d' , strtotime($this->input->post('tgllahir'))),
            'alamat'        => $this->input->post('alamat'),
            'handphone'     => $this->input->post('hp'),
            'telp'          => $this->input->post('telp'),
            'jupen'         => $this->input->post('jupen'),
            'hobby'         => $this->input->post('hobby'),
            'pendidikan'    => $this->input->post('pendidikan'),
            'pekerjaan'     => $this->input->post('pekerjaan'),
            'jabatan'       => $this->input->post('jabatan')
        );
        $this->db->insert('koordinator', $object);
    }
    public function insertKawasan()
    {
        $last_id = $this->db->query("select kwsn from kawasanbaru ORDER BY kwsn DESC limit 1")->row();
        if ($this->input->post('grup') == NULL) {
            $idkoor = $this->input->post('koor');
            $group_instansi = '0';
        } else if ($this->input->post('koor') == NULL) {
            $idkoor = '0';
            $group_instansi = $this->input->post('grup');
        } else if ($this->input->post('koor') == NULL && $this->input->post('grup') == NULL) {
            $idkoor = '0'; 
            $group_instansi = '0';
        } else {
            $idkoor = $this->input->post('koor');
            $group_instansi = $this->input->post('grup');
        }

        $object = array(
            'kwsn'          => sprintf('%06s',intval($last_id->kwsn)+1),
            'nm_kawasan'    => strtoupper($this->input->post('nama')),
            'rk'            => strtoupper($this->input->post('rk')),
            'ins_pk'        => strtoupper($this->input->post('inspk')),
            'iddesa'        => $this->input->post('desa'),
            'intansi'      => $this->input->post('instansi'),
            'alamat'        => strtoupper($this->input->post('alamat')),
            'entri_pegawai' => $this->session->userdata('usrid'),
            'idkoordinator'=> $idkoor,
            'kodejgt'       => $this->input->post('kodej'),
            'jnsktr'      => $this->input->post('jnsktr'),
            'group_instansi'=> $group_instansi,
            'lastupdate' => date('Y-m-d h:i:s')
        );
        // return $this->db->insert('kawasan', $object);
        return $this->db->insert('kawasanbaru', $object);
    }

    public function editDonatur($where) {
        $object = array(
            //hidden
            // 'noid'          => sprintf("%010s",intval($last)+1),
            //tab1
            'status'        => $this->input->post('status'),
            'nama'          => $this->input->post('nama'),
            'tgllahir'      => date('Y-m-d' , strtotime($this->input->post('tgllahir'))),
            'tmplahir'      => $this->input->post('tmplahir'),
            'sex'           => $this->input->post('gender'),
            'kwsn'          => $this->input->post('kwsn'),
            'jupen'         => $this->input->post('jupen'),
            'alamat'        => $this->input->post('alamat'),
            'almktr'        => $this->input->post('alamatktr'),
            'tlprmh'        => $this->input->post('tlprmh'),
            'telphp'        => $this->input->post('tlphp'),
            'telphp2'       => $this->input->post('tlphp2'),
            'tlphp3'        => $this->input->post('tlphp3'),
            'tlpktr'        => $this->input->post('tlpktr'),
            'faxktr'        => $this->input->post('faxktr'),
            'jupen'         => $this->input->post('jupen'),
            //tab 2
            'email'         => $this->input->post('email'),
            'carabyr'       => $this->input->post('crbyr'),
            'rekdonatur'    => $this->input->post('rekdonatur'),
            'bank'          => $this->input->post('bank'),
            'kolektif'      => $this->input->post('kolektif'),
            'waktu_tagih'   => $this->input->post('waktu_tagih'),
            'npwp'          => $this->input->post('npwp'),
            //tab 3
            'info'          => $this->input->post('info'),
            'pekerjaan'     => $this->input->post('pekerjaan'),
            'gaji'          => $this->input->post('gaji'),
            // 'entri_pegawai' => $this->session->userdata('usrid'),
            'pendidikan'    => $this->input->post('pendidikan'),
            'hobby'         => $this->input->post('hobby'),
            'jabatan'       => $this->input->post('jabatan'),
            'koderk'        => $this->input->post('rk'),
            'valid'         => 'Y',
            'lastupdate'    => date('Y-m-d h:i:s'),
            // 'tglm'          => date('Y-m-d')
        );
        return $this->db->update('donaturbaru', $object, $where);
    }

    public function editDonaturItem($id) {
        foreach(json_decode($this->input->post('donaturItem')) as $item) {
            if($item[2] == NULL || !isset($item[2]))
                 $item[2]="";
            if ($item[3] == NULL || !isset($item[3])) {
                 
                 $object = array(
                    'prog' => $item[0],
                    'besar' => $item[1],
                    'keterangan' => $item[2],
                    'ap' => 'A',
                    'noid'=>$id,
                    'entri_pegawai' => $this->session->userdata('usrid'),
                    // 'noid' => intval($last)+1,
                     'entri_tgl' => date('Y-m-d'),
                     'tglap' => date('Y-m-d')
                );
             $this->db->insert('donatur_item', $object);   
            }
            else {
                $object = array(
                    'prog' => $item[0],
                    'besar' => $item[1],//,    
                    'keterangan' => $item[2]
                    // 'entri_pegawai' => $this->session->userdata('usrid'),
                    // 'noid' => intval($last)+1,
                    // 'ap' => 'A',
                    // 'entri_tgl' => date('Y-m-d'),
                    // 'tglap' => date('Y-m-d'),
                );
                 $where_donaturIt = array('noid' => $id,'iddonaturitem'=>$item[3]);
    
            $this->db->update('donatur_item', $object, $where_donaturIt);
            }
           
        }
    }
    public function deleteDonaturItem() {
        foreach(json_decode($this->input->post('deleteItem')) as $item) {
                 
                 $object = array('iddonaturitem'=>$item);
             $this->db->delete('donatur_item', $object);   
            
        }
    }

    public function editKawasan($where)
    {
        $object = array(
            'nm_kawasan'    => strtoupper($this->input->post('nama')),
            'rk'            => strtoupper($this->input->post('rk')),
            'ins_pk'        => strtoupper($this->input->post('inspk')),
            'iddesa'        => $this->input->post('desa'),
            'intansi'      => $this->input->post('inst'),
            'alamat'        => strtoupper($this->input->post('almt')),
            // 'entri_pegawai' => $this->session->userdata('usrid'),
            'kodejgt'       => $this->input->post('kodej'),
            'idkoordinator'=> $this->input->post('idkoor'), //not found
            'jnsktr'      => $this->input->post('jnsktr'),
            'group_instansi'=> $this->input->post('grup'),
            'lastupdate' => date('Y-m-d h:i:s')
        );
        return $this->db->update('kawasanbaru', $object, $where);
    }
    public function editKoor($where)
    {
        $object = array(
            'nama'          => $this->input->post('nama'),
            'tempatlahir'   => $this->input->post('tmplahir'),
            'tanggallahir'  => $this->input->post('tgllahir'),
            'alamat'        => $this->input->post('alamat'),
            'handphone'     => $this->input->post('hp'),
            'telp'          => $this->input->post('telp'),
            'jupen'         => $this->input->post('jupen'),
            'hobby'         => $this->input->post('hobby'),
            'pendidikan'    => $this->input->post('pendidikan'),
            'pekerjaan'     => $this->input->post('pekerjaan'),
            'jabatan'       => $this->input->post('jabatan')
        );

        // $post = $this->input->post('idkoor');
        return $this->db->update('koordinator', $object, $where);
    }
    public function keyDonatur($keyword,$offset) {
        $this->db->select('donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.autoid, donaturbaru.status, donaturbaru.alamat, program.NM_PROGRAM, donatur_item.besar, kawasanbaru.kodejgt');
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
        $clone = clone $this->db;
        $return['num']    = $clone->count_all_results();
        $this->db->limit(10,$offset);
        $return['result'] = $this->db->get()->result();
        
        return $return;
    }

    public function keyKoor($keyword,$offset) {
        $this->db->select('*');
        $this->db->from('koordinator');
        $this->db->like('nama', $keyword['nama']);
        $this->db->like('alamat', $keyword['alamat']);
        $this->db->like('handphone', $keyword['handphone']);
        $clone = clone $this->db;
        $return['num']    = $clone->count_all_results();
        $this->db->limit(10,$offset);
        $return['result'] = $this->db->get()->result();
        return $return;
    }

    public function keyKwsn($keyword,$offset) {
        $this->db->select('kwsn, nm_kawasan, alamat, kodejgt');
        $this->db->from('kawasanbaru');
        $this->db->like('kwsn', $keyword['kwsn']);
        $this->db->like('nm_kawasan', $keyword['nama']);
        $this->db->like('alamat', $keyword['alamat']);
        $clone = clone $this->db;
        $return['num']    = $clone->count_all_results();
        $this->db->limit(10,$offset);
        $return['result'] = $this->db->get()->result();
        return $return;
    }
}
// defined('BASEPATH') OR exit('No direct script access allowed');

// class Mdonatur extends CI_Model {

//     public function getDonatur() {
//         return $this->db->query("select donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat, program.NM_PROGRAM, donatur_item.besar, kawasan.kodejgt from donaturbaru join donatur_item on autoid = donatur_item.noid join program on donatur_item.prog = program.PROG join kawasan on donaturbaru.kwsn = kawasan.kwsn where donaturbaru.lastupdate like '2018-11%' ORDER BY donaturbaru.lastupdate DESC")->result();
//     }

//     public function getKoor() {
//         return $this->db->query("select idkoordinator, nama, alamat, handphone, jupen from koordinator")->result();
//     }
//     public function getKawasan()
//     {
//         return $this->db->query("select kwsn,nm_kawasan,alamat,kodejgt from kawasan where nm_kawasan is not null and nm_kawasan != '' and alamat is not null and alamat != ''")->result();
//     }

// }

/* End of file Mdonatur.php */
