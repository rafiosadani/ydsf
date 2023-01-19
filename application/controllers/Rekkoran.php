<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Rekkoran extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model('mrekkoran');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
    	if ($this->session->userdata('admin') == TRUE) {
            if($this->input->post('nama_file')){
                $path_to_file = './import/import_rekkoran.csv';
                $config['upload_path']          = './import/';
                $config['allowed_types']        = 'csv';
                $config['file_name']            = 'import_rekkoran';
                $config['overwrite']			= true;

                
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('berkas')){
                    $this->session->set_flashdata('flash3','( .csv )');
                    redirect(base_url('front-office/rek-koran'));
                }else{
                    $this->upload->data("file_name");
                    $data['bank'] = $this->mrekkoran->getBank();
			    	$data['program'] = $this->mrekkoran->getProgram(); 
			    	$this->load->view('rekkoran', $data);
                }
            }else{
                $data['bank'] = $this->mrekkoran->getBank();
		    	$data['program'] = $this->mrekkoran->getProgram(); 
		    	$this->load->view('rekkoran', $data);
            }
        } else {
            redirect(base_url());
        }
    }

    public function insert() {
    	if($this->input->post('isi') == "                    ") {
            $this->session->set_flashdata('flash2', 'Mengimport');
            redirect(base_url('front-office/rek-koran'));
        } elseif($this->input->post('isi')=="") {
            $this->session->set_flashdata('flash2', 'Mengimport');
            redirect(base_url('front-office/rek-koran'));
        } else {
            $arr_isi = explode("\r\n", $this->input->post('isi'));
            $jum_baris = count($arr_isi);
            $jum_baris = $jum_baris-1;

            for($i=0; $i<$jum_baris; $i++) {
            $daftardata = $arr_isi[$i];
            $daftarisi = explode(",", $daftardata);
            
            $tgl_bank = $daftarisi[0];
            $tgl_very = $daftarisi[1];
            $uraian = $daftarisi[2];
            $bank = $this->input->post('bank');
            $prog = $this->input->post('program');
            $debet = $daftarisi[3];
            $kredit = $daftarisi[4];

            $this->mrekkoran->insertData($tgl_bank, $tgl_very, $uraian, $bank, $prog, $debet, $kredit);
            }
            $this->session->set_flashdata('flash', 'Dijalankan');
            redirect(base_url('front-office/rek-koran'));
        }
    }
}