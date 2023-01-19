<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Donasi extends CI_Controller {

    public $keyword;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('M_donasi');
        $this->load->model('Mdonasi');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function donasi()
    {
        //if ($this->session->userdata('admin') == TRUE) {
	  if ($this->session->userdata('login') == TRUE) {
            $kodej = "SELECT DISTINCT kodejgt from kawasanbaru ORDER by kodejgt ASC";
            $data['petugas']=$this->M_donasi->query($kodej);
            
            $this->load->view('donasi_view', $data);
        } else {
            redirect(base_url('dashboard'));
        }
    }
    public function listDonasi()
    {
    	$donasi = $this->Mdonasi->getDonasi($this->session->userdata('ses_kodej'));
    	$data=array("data"=>$donasi);
    	echo json_encode($data);
    
    }

    // cetak donasi
    public function cetakDonasi(){
        if ($this->session->userdata('superadmin') == TRUE) {
            $data['jungut']=$this->Mdonasi->getAll();
            $this->load->view('cetak_donasi',$data);
        }elseif($this->session->userdata('admin_grup')==TRUE){
            $grub=$this->session->userdata('idgrup');
            $data['jungut']=$this->Mdonasi->getGrub($grub);
            $data['hasil']=$this->Mdonasi->search($kodej,$kawasan);
            $this->load->view('cetak_donasi',$data);
        }
    }

    public function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " Belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." Puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " Ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " Ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " Juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai/1000000000) . " Milyar" . $this->penyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai/1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai,1000000000000));
        }     
        return $temp;
    }
 
    public function terbilang($nilai) {
        if($nilai < 0) {
            $hasil = "minus ". trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }           
        return $hasil;
    }

    public function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    public function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
     
        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    public function cetak() {
        if($this->input->post('cetak')) {
            $id=$this->input->post('kawasan');
            $jumlah = strlen($id);
            // var_dump($id);die;   
             // var_dump($this->session->userdata('ses_kodej'));die;
            $this->db->select('donaturbaru.nama, donaturbaru.noid, donaturbaru.almktr, kawasanbaru.rk, kawasanbaru.ins_pk, kawasanbaru.kwsn, donatur_item.besar, program.NM_PROGRAM');
            $this->db->from('kawasanbaru');
            $this->db->join('donaturbaru', 'donaturbaru.kwsn = kawasanbaru.kwsn','LEFT');
            $this->db->join('donatur_item', 'donatur_item.noid =donaturbaru.noid','LEFT');
            $this->db->join('program', 'program.PROG =donatur_item.prog','LEFT');
            if($id < 5) {
                $this->db->where('kawasanbaru.kodejgt',$id);
            } else {
                $this->db->where('kwsn_lm',$id);
            }
          
            $this->db->where('program.status', 'A');
            $tes = $this->db->get()->result();
            $data['hasil'] = $tes;
            $this->load->view('tampil_cetak_donasi',$data);
        } else {
            $id=$this->input->post('kawasan');
            $jumlah = strlen($id);
            $this->db->select('donaturbaru.nama, donaturbaru.noid, donaturbaru.almktr, kawasanbaru.rk, kawasanbaru.ins_pk, kawasanbaru.kwsn, donatur_item.besar, program.NM_PROGRAM');
            $this->db->from('kawasanbaru');
            $this->db->join('donaturbaru', 'donaturbaru.kwsn = kawasanbaru.kwsn','LEFT');
            $this->db->join('donatur_item', 'donatur_item.noid =donaturbaru.noid','LEFT');
            $this->db->join('program', 'program.PROG =donatur_item.prog','LEFT');
            if($id < 5){
                $this->db->where('kawasanbaru.kodejgt',$id);
            }else{
                $this->db->where('kwsn_lm',$id);
            }
          
            $this->db->where('program.status', 'A');
            $tes = $this->db->get()->result();

            $data['hasil'] = $tes;

            $filename = "ctk_kwtsi" . date("Hi") . ".txt";
            header('Content-type:text/plain');
            header('Content-Disposition: attachment;filename=' .$filename);
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0');
            header('Pragma: no-cache');
            header('Expires:0');
            $handles = fopen('php://output', 'w');
        
            foreach ($data['hasil'] as $value) {
                echo "\r\n";
                echo "\r\n";
                echo "\r\n";
                echo "\r\n";
                echo "          " . $value->noid . " - " . $value->NM_PROGRAM ."\r\n";
                echo "          " . $value->nama ."\r\n";
                echo "          " . $value->almktr."\r\n";
                if( $value->rk === 'R'){
                    echo "          " . "-\r\n";
                } else {
                    echo "          " . $value->ins_pk ."\r\n";
                }
                echo "          " . $value->kwsn ."\r\n";
                echo "          " . $this->tgl_indo(date('Y-m-d')) ."\r\n";
                echo "          " . $this->rupiah($value->besar) . " ( " . $this->terbilang($value->besar) . " Rupiah )". "\r\n";
                echo "\r\n";
                echo "\r\n";
                echo "\r\n";
                echo "\r\n";
            }
        }
    }

    public function getKawasanJ()
    {
        $where = array(
            'kodejgt' => $this->input->get('kodej')
        );
        $data = $this->db->get_where('kawasan', $where )->result();
        echo json_encode($data);
    }


    public function validasi()
    {
        if ($this->session->userdata('admin') == TRUE || $this->session->userdata('priv_admin') == TRUE) {
                $kodej = "SELECT DISTINCT report_jupen,name from report_sementara a left join sec_users b on a.report_jupen=b.kodej WHERE group_id='".$this->session->userdata('idgrup')."' ORDER by report_jupen ASC";
                $data['petugas']=$this->M_donasi->query($kodej);
                //var_dump($data['petugas']);
                $this->load->view('validasi_manager_view', $data);
            
    	} else {
            redirect(base_url('dashboard'));
        }
    }
    
    public function listValidasi()
    {
     	$kasir=$this->Mdonasi->getJupenById($this->session->userdata('usrid'));
    	$donasi = $this->Mdonasi->getValidasi($kasir[0]->group_id);
    	$data=array("data"=>$donasi);
    	echo json_encode($data);
    
    }
    public function addDonasi($value='')
    {
        //if ($this->session->userdata('admin') == TRUE) {
	if ($this->session->userdata('login') == TRUE) {
            $last_id = $this->db->query("select autoid from donaturbaru ORDER BY autoid DESC limit 1")->row();
            if ($this->input->post('nama') == NULL || $this->input->post('nama') == "") {
                /*$data['ket_ap'] = $this->M_donasi->query("select * from ket_ap");
                $data['program'] = $this->M_donasi->query("select PROG,NM_PROGRAM from program");
                $data['carabayar'] = $this->M_donasi->query("select * from cara_byr");
                $data['waktu_tagih'] = $this->M_donasi->query("select * from waktu_penagihan");
                $data['info'] = $this->M_donasi->query("select * from info");
                $data['gaji'] = $this->M_donasi->query("select * from gaji order by GAJI ASC");
                $data['hobi']      = $this->M_donasi->query("select * from hobby order by hobby ASC");
                $data['kerja']  = $this->M_donasi->query("select * from pekerjaan order by PEKERJAAN ASC");
                $data['jabatan']    = $this->M_donasi->query("select * from jabatan order by jabatan ASC");
                $data['pend'] = $this->M_donasi->query("select * from pendidikan order by PENDIDIKAN ASC");
                */
                $data['program'] = $this->M_donasi->query("select PROG,NM_PROGRAM from program");
                $data['jungut'] = $this->M_donasi->query("select KODEJ,NAMA from jungut");
                $this->load->view('add_donasi',$data);
            } else {
            	$data['report_noid']=$this->input->post('nama');
            	//$data['report_prog']=$this->input->post('nama_program');
                //$data['report_nominal']=intval($this->input->post('nominal'));
                //$data['report_ket']=$this->input->post('ket');
                $data['report_jupen']=$this->session->userdata('ses_kodej');
                $data['tgl_cetak']=date('Y-m-d');
                $donatur= $this->Mdonasi->getDonaturById($this->input->post('nama'));
                //$program= $this->Mdonasi->getProgramById($this->input->post('nama_program'));
                $jupen= $this->Mdonasi->getJupenById($this->session->userdata('usrid'));
                foreach(json_decode($this->input->post("donaturItem")) as $item) {
                	$data['report_prog']=$item[0];
                	$data['report_nominal']=intval($item[2]);
                	$data['report_ket']=$item[3];
                	$this->Mdonasi->insertDonasi($data); 
                }
                //$this->Mdonasi->insertDonasi($data);   
                $data['report_nama']=$donatur[0]->nama;                
                $data['report_alamat']=$donatur[0]->almktr;
                //$data['report_program']=$program[0]->NM_PROGRAM;
                $data['jupen_alm']=$jupen[0]->s_almktr;
                $data['jupen_tlpktr']=$jupen[0]->s_tlp;
                $data['jupen_nama']=$jupen[0]->name;
                $data['jupen_tlp']=$jupen[0]->s_petugas;
                $data['jupen_terima']=$jupen[0]->s_terima;
                $data['jupen_doa']=$jupen[0]->s_doa;
                $data['jupen_web']=$jupen[0]->s_web;
                //$data['donasi_item']=$this->input->post('donaturItem');
        		
                echo json_encode($data);
                
                //redirect(base_url('data/donasi'));
                // echo "<pre>";
                // print_r(json_decode($this->input->post('donaturItem')));
                // echo "</pre>";return;
            }
        } else {
            redirect(base_url('dashboard'));
        }
    }
    
    
    public function saveValidasi(){
    	$data=array();
    	$validasi=array();
    	$kwitansi="F".date('YmdHis');
    	$jupen="";
    	foreach(json_decode($this->input->post("id")) as $id) {
    		   	$row['report_id']=$id;
    		   	$row['laporan']='y';
    		   	$row['tgl_setor']=date('Y-m-d');
    		   	$row['noslip']=$kwitansi;
				$row['usr_mng']=$this->session->userdata('ses_kodej');
    		   	$data[]=$row;
    	}
    	$this->Mdonasi->updateValidasi($data);
        //$this->Mdonasi->insertReport($validasi);
        $groupbyProg=$this->Mdonasi->getValidasiBySlip($kwitansi);
        foreach($groupbyProg as $obj){
    		$rowKeu['jml']=$obj->total;
    		$rowKeu['tgl_setor']=date('Y-m-d');
    		$rowKeu['bln']=intval(date('n'));
    		$rowKeu['thn']=intval(date('Y'));
    		$rowKeu['entr_pegawai']=$obj->report_jupen;
    		$rowKeu['validasi']="n"; 
    		//$rowKeu['bank']="0001";  
    		$rowKeu['noslip']=$kwitansi;
    		//$rowKeu['idusr_v']= $this->session->userdata('usrid');	
    		//$rowKeu['tgl_val']=date('Y-m-d');
    		$rowKeu['prog']=$obj->report_prog;
    		$rowKeu['tgl_input']=date('Y-m-d H:i:s');
    		$this->Mdonasi->insertKeu($rowKeu);
    	}
    	$return=array("data"=>$validasi);
    	echo json_encode($return);
   
    }
    public function saveLaporan(){
    	$data=array();
    	$validasi=array();
    	//$kwitansi="F".date('YmdHis');
    	$jupen="";
    	foreach(json_decode($this->input->post("id")) as $id) {
    		   	$row['report_id']=$id;
    		   	$row['laporan']='y';
    		   	$row['tgl_setor']=date('Y-m-d');
    		   	//$row['noslip']=$kwitansi;
				$row['usr_mng']=$this->session->userdata('ses_kodej');
    		   	$data[]=$row;
    		   	
    	}
    	$this->Mdonasi->updateValidasi($data);
        $return=array("data"=>$validasi);
    	echo json_encode($return);
   
    }
    
    public function getDonaturAuto()
    {
    	$data = $this->Mdonasi->getDonatur();
    	$donatur=array();
    	foreach($data as $obj){
    		$donatur[]=array("value"=>$obj->noid,"label"=>$obj->noid." - ".$obj->nama." - ".$obj->almktr." - ".$obj->status);
    	}
    	echo json_encode($donatur);
    
    }
    public function getProgram()
    {
    	$data = $this->Mdonasi->getProgram();
    	$donatur="";
    	foreach($data as $obj){
    		$donatur.="<option value ='".$obj->PROG."' >".$obj->NM_PROGRAM."</option>";
    	}
    	$data=array("data"=>$donatur);
    	echo json_encode($data);
    
    }
    public function saveDonasi()
    {
    	$data = $this->Mdonasi->getProgram();
    	$donatur="";
    	foreach($data as $obj){
    		$donatur.="<option value ='".$obj->PROG."' >".$obj->NM_PROGRAM."</option>";
    	}
    	$data=array("data"=>$donatur);
    	echo json_encode($data);
    
    }
 
}

/* End of file  */
/* Location: ./application/controllers/ */
