<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Donatur extends CI_Controller {

    public $keyword;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model('M_donatur');
        $this->load->model('mdonatur');
        $this->load->model('Mbatal');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function batalSetor() { 
        if ($this->session->userdata('superadmin') == TRUE) {
            $data['jungut']=$this->Mbatal->getAll();
            $kodej=$this->input->post('kodej');
            $kawasan=$this->input->post('kawasan');
            $data['hasil']=$this->Mbatal->search($kodej,$kawasan);
            $this->session->set_userdata('jungut',$kodej);
            $this->session->set_userdata('kawasan',$kawasan);
            $this->load->view('batal_setor',$data);
        }elseif($this->session->userdata('admin_grup')==TRUE){
            $grub=$this->session->userdata('idgrup');
            $data['jungut']=$this->Mbatal->getGrub($grub);
            $kodej=$this->input->post('kodej');
            $kawasan=$this->input->post('kawasan');
            $data['hasil']=$this->Mbatal->search($kodej,$kawasan);
            $this->session->set_userdata('jungut',$kodej);
            $this->session->set_userdata('kawasan',$kawasan);
            $this->load->view('batal_setor',$data);
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

    public function hapusSetor(){

        if($this->input->post('report_id')){
            $ids = $this->input->post('report_id');
            foreach($ids as $id){
                $this->Mbatal->hapus($id);
            }
        }

    }

    public function getAutoComplete() {
        if (isset($_GET['term'])) {
            $result = $this->mdonatur->getKodeKwsn($_GET['term']);
             if (count($result) > 0) {
                foreach ($result as $row)
                $arr_result[] = array(
                  'label'			=> $row->kwsn,
                );
                echo json_encode($arr_result);
             }
        }
    }

    public function donatur()
    {
        if ($this->session->userdata('login') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE) {
                $kodej = "select name,kodej from sec_users where kodej > 0 and lapangan = 'A' and active = 'Y' order by idcabang asc";
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $kodej = "select name,kodej from sec_users where kodej > 0 and lapangan = 'A' and active = 'Y' and idcabang = ".$this->session->userdata('idcab')." order by idcabang asc";
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $kodej = "select name,kodej from sec_users where kodej > 0 and lapangan = 'A' and active = 'Y' and group_id = ".$this->session->userdata('idgrup')." order by idcabang asc";
            } else {
                $kodej = "select name,kodej from sec_users where lapangan = 'A' and active = 'Y' and kodej = ".$this->session->userdata('ses_kodej')." order by idcabang asc";
            }
            $program = "SELECT PROG, NM_PROGRAM FROM program WHERE status = 'A'";
            $data['petugas']=$this->M_donatur->query($kodej);
            $data['prog'] = $this->M_donatur->query($program);
            $data['prov']    = $this->M_donatur->query("SELECT * FROM master_prop");
            if ($this->session->userdata('superadmin') == TRUE) {
                $set = $this->db->query("select COUNT(noid) as jumlah FROM donaturbaru")->row();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $set = $this->db->query("select COUNT(noid) as jumlah FROM donaturbaru join kawasan on donaturbaru.kwsn = kawasan.kwsn join sec_users on kawasan.kodejgt = sec_users.kodej where idcabang = ".$this->session->userdata('idcab'))->row();
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $set = $this->db->query("select COUNT(noid) as jumlah FROM donaturbaru join kawasan on donaturbaru.kwsn = kawasan.kwsn join sec_users on kawasan.kodejgt = sec_users.kodej where group_id = ".$this->session->userdata('idgrup'))->row();
            } else {
                $set = $this->db->query("select COUNT(noid) as jumlah FROM donaturbaru join kawasan on donaturbaru.kwsn = kawasan.kwsn where kodejgt = ".$this->session->userdata('ses_kodej'))->row();
            }
            $config['base_url'] = base_url().'data/donatur/';
            $config['total_rows'] = intval($set->jumlah);
            $config['query_string_segment'] = 'start';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            $from = $this->uri->segment(3);
            $config['per_page'] = 10;
            $this->pagination->initialize($config);
            // $result = $this->db->get('donaturbaru', $config['per_page'], $from)->result();
            if ($this->session->userdata('superadmin') == TRUE ) {
                $data['donatur'] = $this->mdonatur->getDonatur($config['per_page'], $from);
                $data['tot_donatur'] = $set->jumlah;
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $data['donatur'] = $this->mdonatur->getDonaturCab($config['per_page'], $from);
                $data['tot_donatur'] = $set->jumlah;
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $data['donatur'] = $this->mdonatur->getDonaturGrup($config['per_page'], $from);
                $data['tot_donatur'] = $set->jumlah;
            } else {
                $data['donatur'] = $this->mdonatur->getDonaturUser($config['per_page'], $from);
                $data['tot_donatur'] = $set->jumlah;
            }

            $data['keyword'] = '1';
            $this->load->view('donatur', $data);
            // echo "<pre>";
            // print_r($data['program']);
            // echo "</pre>";return;
        } else {
            redirect(base_url('dashboard'));
        }
    }


    public function koordinator()
    {
        if ($this->session->userdata('admin') == TRUE) {
            $set = $this->db->query("select COUNT(idkoordinator) as jumlah FROM koordinator")->row();
            $config['base_url'] = base_url().'data/koordinator/';
            $config['total_rows'] = intval($set->jumlah);
            $config['query_string_segment'] = 'start';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            $from = $this->uri->segment(3);
            $config['per_page'] = 10;
            $this->pagination->initialize($config);
            $data['koor'] = $this->mdonatur->getKoor($config['per_page'], $from);
            $this->load->view('koordinator', $data);
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function kawasan()
    {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE ) {
                $set = $this->db->query("select COUNT(kwsn) as jumlah FROM kawasan")->row();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $set = $this->db->query("select COUNT(kwsn) as jumlah FROM kawasan join sec_users on kawasan.kodejgt = sec_users.kodej where idcabang = ".$this->session->userdata('idcab'))->row();
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $set = $this->db->query("select COUNT(kwsn) as jumlah FROM kawasan join sec_users on kawasan.kodejgt = sec_users.kodej where group_id = ".$this->session->userdata('idgrup'))->row();
            }
            $config['base_url'] = base_url().'data/kawasan/';
            $config['total_rows'] = intval($set->jumlah);
            $config['query_string_segment'] = 'start';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            $from = $this->uri->segment(3);
            $config['per_page'] = 10;
            $this->pagination->initialize($config);
            if ($this->session->userdata('superadmin') == TRUE ) {
                $data['kawasan'] = $this->mdonatur->getKawasan($config['per_page'], $from);
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $data['kawasan'] = $this->mdonatur->getKawasanCab($config['per_page'], $from);
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $data['kawasan'] = $this->mdonatur->getKawasanGrup($config['per_page'], $from);
            }
            $this->load->view('kawasan', $data);
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function addDonatur($value='')
    {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->input->post('nama') == NULL || $this->input->post('nama') == "") {
                $data['ket_ap'] = $this->M_donatur->query("select * from ket_ap");
                $data['jungut'] = $this->M_donatur->query("select KODEJ,NAMA from jungut");
                $data['program'] = $this->M_donatur->query("select PROG,NM_PROGRAM from program");
                $data['carabayar'] = $this->M_donatur->query("select * from cara_byr");
                $data['waktu_tagih'] = $this->M_donatur->query("select * from waktu_penagihan");
                $data['info'] = $this->M_donatur->query("select * from info");
                $data['gaji'] = $this->M_donatur->query("select * from gaji order by GAJI ASC");
                $data['hobi']      = $this->M_donatur->query("select * from hobby order by hobby ASC");
                $data['kerja']  = $this->M_donatur->query("select * from pekerjaan order by PEKERJAAN ASC");
                $data['jabatan']    = $this->M_donatur->query("select * from jabatan order by jabatan ASC");
                $data['pend'] = $this->M_donatur->query("select * from pendidikan order by PENDIDIKAN ASC");
                $data['prov']  = $this->M_donatur->query("select * from master_prop");
                $this->load->view('add_donatur',$data);
            } else {
                $this->M_donatur->deletePenyesuai();
                $this->M_donatur->insertPenyesuai();
                $last_id = $this->db->query("select autoid from donaturbaru ORDER BY autoid DESC limit 1")->row();
                $this->M_donatur->insertDonatur($last_id->autoid);
                $this->M_donatur->insertDonaturItem($last_id->autoid);
                $this->M_donatur->deletePenyesuai();
                redirect(base_url('data/donatur'));
                // echo "<pre>";
                // print_r(json_decode($this->input->post('donaturItem')));
                // echo "</pre>";return;
            }
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function addKoor($value='')
    {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->input->post('nama') == NULL || $this->input->post('nama') == "") {
                $data['hobby']      = $this->M_donatur->query("select * from hobby order by hobby ASC");
                $data['pekerjaan']  = $this->M_donatur->query("select * from pekerjaan order by PEKERJAAN ASC");
                $data['jabatan']    = $this->M_donatur->query("select * from jabatan order by jabatan ASC");
                $data['pendidikan'] = $this->M_donatur->query("select * from pendidikan order by PENDIDIKAN ASC");
                $this->load->view('add_koordinator', $data);
            } else {
                $this->M_donatur->insertKoor();
                redirect(base_url('data/koordinator'));
            }
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function addKawasan($value='')
    {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->input->post('nama') == NULL || $this->input->post('nama') == "") {
                $data['prov']    = $this->M_donatur->query("select * from master_prop");
                $data['jnsktr']  = $this->M_donatur->query("select * from jnsktr");
                $this->load->view('add_kawasan',$data);
            } else {
                $this->M_donatur->insertKawasan();
                redirect(base_url('data/kawasan'));
            }
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function getKota()
    {
        $where = array(
            'PROP' => $this->input->get('prov')
        );
        $data = $this->db->get_where('master_kab', $where)->result();
        echo json_encode($data);
    }

    public function getKec()
    {
       $where = array(
        'PROP' => substr($this->input->get('kabkot'),0,2),
        'KAB' => substr($this->input->get('kabkot'),2,2)
    );
       $data = $this->db->get_where('master_kec', $where )->result();
       echo json_encode($data);
    }


    public function getDesa()
    {
    $where = array(
        'PROP' => substr($this->input->get('kec'),0,2),
        'KAB' => substr($this->input->get('kec'),2,2),
        'KEC' => substr($this->input->get('kec'),4,3)
    );
    $data = $this->db->get_where('master_desa', $where )->result();
    echo json_encode($data);
    }

    public function getJungut() {
        $where = array(
            'KODEJ' => $this->input->get('kodej')
        );
        $data = $this->db->get_where('jungut', $where )->result();
        echo json_encode($data);
    }

    public function getKwsn()
    {
        $where = array(
            'kwsn' => $this->input->get('kwsn')
        );
        $data = $this->db->get_where('kawasan', $where )->row();
        echo json_encode($data);
    }

    public function editDonatur($id=null)
    {
        if ($this->session->userdata('login') == TRUE) {
            if (!isset($id)) redirect('data/donatur');
            $where = array('autoid' => $id);
            $where_donaturIt = array('noid' => $id);
            if ($this->input->post('nama') == NULL || $this->input->post('nama') == "") {
                $data['ket_ap'] = $this->M_donatur->query("select * from ket_ap");
                $data['jungut'] = $this->M_donatur->query("select KODEJ,NAMA from jungut");
                $data['program'] = $this->M_donatur->query("select PROG,NM_PROGRAM from program");
                $data['carabayar'] = $this->M_donatur->query("select * from cara_byr");
                $data['waktu_tagih'] = $this->M_donatur->query("select * from waktu_penagihan");
                $data['info'] = $this->M_donatur->query("select * from info");
                $data['gaji'] = $this->M_donatur->query("select * from gaji order by GAJI ASC");
                $data['hobi']      = $this->M_donatur->query("select * from hobby order by hobby ASC");
                $data['kerja']  = $this->M_donatur->query("select * from pekerjaan order by PEKERJAAN ASC");
                $data['jabatan']    = $this->M_donatur->query("select * from jabatan order by jabatan ASC");
                $data['pend'] = $this->M_donatur->query("select * from pendidikan order by PENDIDIKAN ASC");
                $data['data']    = $this->M_donatur->getRow("donaturbaru",$where);
                $data['donatur_item'] = $this->M_donatur->donaturItem($where_donaturIt);
                $data['prov']    = $this->M_donatur->query("select * from master_prop");
                // echo "<pre>";
                // print_r($data['donatur_item']);
                // echo "</pre>";return;
                $this->load->view('edit donatur',$data);
            } else {
                $this->M_donatur->editDonatur($where);
                //$this->M_donatur->editDonaturItem($where_donaturIt);

                $this->M_donatur->editDonaturItem($id);
                if(count(json_encode( $this->input->post('deleteItem') ))>0&&json_encode( $this->input->post('deleteItem') )!="\"\"")
					$this->M_donatur->deleteDonaturItem();
                redirect(base_url('data/donatur'));
            }
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function editKoor($id=null)
    {
        if ($this->session->userdata('admin') == TRUE) {
            if (!isset($id)) redirect('data/koordinator');
            $where = array('idkoordinator' => $id);
            if ($this->input->post('nama') == NULL || $this->input->post('nama') == "") {
                $data['hobby']      = $this->M_donatur->query("select * from hobby order by hobby ASC");
                $data['pekerjaan']  = $this->M_donatur->query("select * from pekerjaan order by PEKERJAAN ASC");
                $data['jabatan']    = $this->M_donatur->query("select * from jabatan order by jabatan ASC");
                $data['pendidikan'] = $this->M_donatur->query("select * from pendidikan order by PENDIDIKAN ASC");

                $data['data']    = $this->M_donatur->getRow("koordinator",$where);
                $this->load->view('edit_koordinator', $data);
            } else {
                $this->M_donatur->editKoor($where);
                redirect(base_url('data/koordinator'));
            }
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function editKawasan($id=null)
    {
        if ($this->session->userdata('admin') == TRUE) {
            $where = array('kwsn' => $id);
            if (!isset($id)) redirect('data/kawasan');
            if ($this->input->post('nama') == NULL || $this->input->post('nama') == "") {
                $data['prov']    = $this->M_donatur->query("select * from master_prop");
                $data['jnsktr']  = $this->M_donatur->query("select * from jnsktr");
                $data['data']    = $this->M_donatur->getRow("kawasan",$where);
                $data['jungut']  = $this->M_donatur->getRow('jungut', array('KODEJ' => $data['data']->kodejgt));
                $this->load->view('edit_kawasan',$data);
            } else {
                $this->M_donatur->editKawasan($where);
                redirect(base_url('data/kawasan'));
            }
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function excelDonatur(){
      if ($this->session->userdata('superadmin') == TRUE) {
          if($this->session->userdata('keyword') != ""){
          $tampil = $this->M_donatur->keyDonaturExcel($this->session->userdata('keyword'))['result'];
          }else{
          $tampil = $this->mdonatur->getDonaturExcel();
          }
      } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
          if($this->session->userdata('keyword') != ""){
              $tampil = $this->M_donatur->keyDonaturGrupExcel($this->session->userdata('keyword'))['result'];
          }else{
              $tampil = $this->mdonatur->getDonaturGrupExcel();
          }
      }

      $nbsp = "\xc2\xa0";
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();
      $styleArray = array(
          'borders' => array(
              'allBorders' => array(
                  'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                  'color' => array('argb' => '000000'),
              ),
          ),
      );

      $sheet->setCellValue('A1','DATA DONATUR')
      ->mergeCells('A1:N2')->getStyle('A1')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('A2','')
      ->mergeCells('A2:N2')->getStyle('A2')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('A3','TANGGAL MASUK')
      ->getStyle('A3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('B3','KODE PROZIS')
      ->getStyle('B3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('C3','NID')
      ->getStyle('C3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('D3','NAMA DONATUR')
      ->mergeCells('D3:E3')->getStyle('D3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('F3','ALAMAT')
      ->mergeCells('F3:G3')->getStyle('F3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('H3','HANDPHONE')
      ->mergeCells('H3:I3')->getStyle('H3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('J3','KAWASAN')
      ->getStyle('J3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('K3','A/P/T')
      ->getStyle('K3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('L3','DONASI')
      ->getStyle('L3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
      $sheet->setCellValue('M3','RUMAH/KANTOR')
      ->mergeCells('M3:N3')->getStyle('M3')->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);

      $row=4;
      foreach ($tampil as $no => $tampil) {
        $sheet->setCellValue('A'.$row,$tampil->tglm)
        ->getStyle('A'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('B'.$row,$tampil->kdprozis)
        ->getStyle('B'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('C'.$row,$tampil->noid)
        ->getStyle('C'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('D'.$row,$tampil->nama)
        ->mergeCells('D'.$row.':E'.$row)->getStyle('D'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('F'.$row,$tampil->alamat)
        ->mergeCells('F'.$row.':G'.$row)->getStyle('F'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('H'.$row,$tampil->nohp)
        ->mergeCells('H'.$row.':I'.$row)->getStyle('H'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('J'.$row,$tampil->kwsn)
        ->getStyle('J'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('K'.$row,$tampil->status)
        ->getStyle('K'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('L'.$row,number_format($tampil->donasi,0,',',','))
        ->getStyle('L'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);
        $sheet->setCellValue('M'.$row,$tampil->nama_kawasan)
        ->mergeCells('M'.$row.':N'.$row)->getStyle('M'.$row)->getAlignment()->setVertical('center')->setHorizontal('center')->setWrapText(true);


        $row++;
      }
      $rows = $row-1;
      $sheet->getStyle('A3:N'.$rows)->applyFromArray($styleArray);

      $writer = new Xlsx($spreadsheet);
      $filename = 'Data_donatur';

      // download file
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
      header('Cache-Control: max-age=0');
      $writer->save('php://output');


    }


    public function searchDonatur() {
        if ($this->session->userdata('login') == TRUE) {
            if ($this->session->userdata('keyword') == NULL) {
                $array = array(
                        'keyword' => array(
                            'kwsn' => $this->input->post('kwsn'),
                            'status' => $this->input->post('status'),
                            'tgl1' => substr($this->input->post('tgl'),0,10),
                            'tgl2' => substr($this->input->post('tgl'),13,10),
                            'noid' => $this->input->post('noid'),
                            'nama' => $this->input->post('nama'),
                            'alamat' => $this->input->post('alamat'),
                            'prov' => $this->input->post('prov'),
                            'kota' => $this->input->post('kota'),
                            'kec' => $this->input->post('kec'),
                            'desa' => $this->input->post('desa'),
                            'program' => $this->input->post('program'),
                            'petugas' => $this->input->post('kodej')
                        )
                    );
                $this->session->set_userdata($array);
            } else {
                if ($this->input->post()) {
                    if ($this->session->userdata('keyword')['kwsn'] != $this->input->post('kwsn') ||
                    $this->session->userdata('keyword')['status'] != $this->input->post('status') ||
                    $this->session->userdata('keyword')['tgl1'] != substr($this->input->post('tgl'),0,10) ||
                    $this->session->userdata('keyword')['tgl2'] != substr($this->input->post('tgl'),13,10) ||
                    $this->session->userdata('keyword')['noid'] != $this->input->post('noid') ||
                    $this->session->userdata('keyword')['nama'] != $this->input->post('nama') ||
                    $this->session->userdata('keyword')['alamat'] != $this->input->post('alamat') ||
                    $this->session->userdata('keyword')['prov'] != $this->input->post('prov') ||
                    $this->session->userdata('keyword')['kota'] != $this->input->post('kota') ||
                    $this->session->userdata('keyword')['kec'] != $this->input->post('kec') ||
                    $this->session->userdata('keyword')['desa'] != $this->input->post('desa') ||
                    $this->session->userdata('keyword')['program'] != $this->input->post('program') ||
                    $this->session->userdata('keyword')['petugas'] != $this->input->post('kodej')) {
                    $array = array(
                        'keyword' => array(
                            'kwsn' => $this->input->post('kwsn'),
                            'status' => $this->input->post('status'),
                            'tgl1' => substr($this->input->post('tgl'),0,10),
                            'tgl2' => substr($this->input->post('tgl'),13,10),
                            'noid' => $this->input->post('noid'),
                            'nama' => $this->input->post('nama'),
                            'alamat' => $this->input->post('alamat'),
                            'prov' => $this->input->post('prov'),
                            'kota' => $this->input->post('kota'),
                            'kec' => $this->input->post('kec'),
                            'desa' => $this->input->post('desa'),
                            'program' => $this->input->post('program'),
                            'petugas' => $this->input->post('kodej')
                        )
                    );
                    $this->session->set_userdata($array);
                }
                }
            }
            $config['base_url']         = base_url().'donatur/searchDonatur/';
            if ($this->session->userdata('superadmin') == TRUE) {
                $config['total_rows']       = $this->M_donatur->keyDonatur($this->session->userdata('keyword'),0)['num'];
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $config['total_rows']       = $this->M_donatur->keyDonaturCab($this->session->userdata('keyword'),0)['num'];
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $config['total_rows']       = $this->M_donatur->keyDonaturGrup($this->session->userdata('keyword'),0)['num'];
            } else {
                $config['total_rows']       = $this->M_donatur->keyDonaturUser($this->session->userdata('keyword'),0)['num'];
            }
            $config['query_string_segment'] = 'start';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            $from = $this->uri->segment(3);
            $config['per_page'] = 10;
            $this->pagination->initialize($config);
            if ($this->session->userdata('superadmin') == TRUE) {
                $data['donatur'] = $this->M_donatur->keyDonatur($this->session->userdata('keyword'),$from)['result'];
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $data['donatur'] = $this->M_donatur->keyDonaturCab($this->session->userdata('keyword'),$from)['result'];
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $data['donatur'] = $this->M_donatur->keyDonaturGrup($this->session->userdata('keyword'),$from)['result'];
            } else {
                $data['donatur'] = $this->M_donatur->keyDonaturUser($this->session->userdata('keyword'),$from)['result'];
            }
            $program = "SELECT PROG, NM_PROGRAM FROM program WHERE status = 'A'";
            if ($this->session->userdata('superadmin') == TRUE) {
                $kodej = "select name,kodej from sec_users where kodej > 0 and lapangan = 'A' and active = 'Y' order by idcabang asc";
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $kodej = "select name,kodej from sec_users where kodej > 0 and lapangan = 'A' and active = 'Y' and idcabang = ".$this->session->userdata('idcab')." order by idcabang asc";
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $kodej = "select name,kodej from sec_users where kodej > 0 and lapangan = 'A' and active = 'Y' and group_id = ".$this->session->userdata('idgrup')." order by idcabang asc";
            } else {
                $kodej = "select name,kodej from sec_users where lapangan = 'A' and active = 'Y' and kodej = ".$this->session->userdata('ses_kodej')." order by idcabang asc";
            }
            $data['petugas']=$this->M_donatur->query($kodej);
            $data['prog'] = $this->M_donatur->query($program);
            $data['prov']    = $this->M_donatur->query("SELECT * FROM master_prop");
            $data['tot_donatur']=$config['total_rows'];
            $data['keyword'] = '0';
            $this->load->view('donatur', $data);
            // echo json_encode($this->M_donatur->keyDonatur($keyword)['result']);
        } else {
            redirect(base_url('dashboard'));
        }
    }

    public function searchKoor() {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('keyword') == NULL) {
                $array = array(
                        'keyword' => array(
                            'nama' => $this->input->post('nama'),
                            'alamat' => $this->input->post('alamat'),
                            'handphone' => $this->input->post('hp')
                        )
                    );
                $this->session->set_userdata($array);

            } else {
                if ($this->input->post()) {
                    if ($this->session->userdata('keyword')['nama'] != $this->input->post('nama') ||
                    $this->session->userdata('keyword')['alamat'] != $this->input->post('alamat') ||
                    $this->session->userdata('keyword')['handphone'] != $this->input->post('hp')) {
                    $array = array(
                        'keyword' => array(
                            'nama' => $this->input->post('nama'),
                            'alamat' => $this->input->post('alamat'),
                            'handphone' => $this->input->post('hp')
                        )
                    );
                    $this->session->set_userdata($array);
                    }
                }
            }
            $config['base_url']         = base_url().'donatur/searchKoor/';
            $config['total_rows']       = $this->M_donatur->keyKoor($this->session->userdata('keyword'),0)['num'];
            $config['query_string_segment'] = 'start';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            $from = $this->uri->segment(3);
            $config['per_page'] = 10;
            $this->pagination->initialize($config);
            $data['koor'] = $this->M_donatur->keyKoor($this->session->userdata('keyword'),$from)['result'];
            $this->load->view('koordinator', $data);
        } else {
            redirect(base_url('dashboard'));
        }

    }

    public function searchKwsn() {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('keyword') == NULL) {
                $array = array(
                        'keyword' => array(
                            'kwsn' => $this->input->post('kwsn'),
                            'nama' => $this->input->post('nama'),
                            'alamat' => $this->input->post('alamat')
                        )
                    );
                $this->session->set_userdata($array);

            } else {
                if ($this->input->post()) {
                    if ($this->session->userdata('keyword')['kwsn'] != $this->input->post('kwsn') ||
                    $this->session->userdata('keyword')['nama'] != $this->input->post('nama') ||
                    $this->session->userdata('keyword')['alamat'] != $this->input->post('alamat')) {
                        $array = array(
                            'keyword' => array(
                                'kwsn' => $this->input->post('kwsn'),
                                'nama' => $this->input->post('nama'),
                                'alamat' => $this->input->post('alamat')
                            )
                        );
                    $this->session->set_userdata($array);
                    }
                }
            }
            $config['base_url']         = base_url().'donatur/searchKwsn/';
            if ($this->session->userdata('superadmin') == TRUE ) {
                $config['total_rows']       = $this->M_donatur->keyKwsn($this->session->userdata('keyword'),0)['num'];
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $config['total_rows']       = $this->M_donatur->keyKwsnCab($this->session->userdata('keyword'),0)['num'];
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $config['total_rows']       = $this->M_donatur->keyKwsnGrup($this->session->userdata('keyword'),0)['num'];
            }
            $config['query_string_segment'] = 'start';
            $config['first_link']       = 'First';
            $config['last_link']        = 'Last';
            $config['next_link']        = 'Next';
            $config['prev_link']        = 'Prev';
            $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
            $config['full_tag_close']   = '</ul></nav></div>';
            $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
            $config['num_tag_close']    = '</span></li>';
            $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
            $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
            $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
            $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['prev_tagl_close']  = '</span>Next</li>';
            $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
            $config['first_tagl_close'] = '</span></li>';
            $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
            $config['last_tagl_close']  = '</span></li>';
            $from = $this->uri->segment(3);
            $config['per_page'] = 10;
            $this->pagination->initialize($config);
            if ($this->session->userdata('superadmin') == TRUE ) {
                $data['kawasan'] = $this->M_donatur->keyKwsn($this->session->userdata('keyword'),$from)['result'];
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE ) {
                $data['kawasan'] = $this->M_donatur->keyKwsnCab($this->session->userdata('keyword'),$from)['result'];
            } else if ($this->session->userdata('admin_grup') == TRUE ) {
                $data['kawasan'] = $this->M_donatur->keyKwsnGrup($this->session->userdata('keyword'),$from)['result'];
            }
            $this->load->view('kawasan', $data);
        } else {
            redirect(base_url('dashboard'));
        }
    }


    function mainan() {
        $set = $this->db->query("select COUNT(noid) as jumlah FROM donaturbaru")->row();
        $config['base_url'] = base_url().'donatur/mainan/';
        $config['total_rows'] = intval($set->jumlah);
        $config['query_string_segment'] = 'start';

        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        $from = $this->uri->segment(3);
        $config['per_page'] = 10;
        $this->load->library('pagination', $config);
        $result = $this->db->get('donaturbaru', $config['per_page'], $from)->result();
        // $this->datatables->join('kategori', 'barang_kategori_id=kategori_id');
        // $this->datatables->add_column('view', '<a href="javascript:void(0);" class="edit_record btn btn-info btn-xs" data-kode="$1" data-nama="$2" data-harga="$3" data-kategori="$4">Edit</a>  <a href="javascript:void(0);" class="hapus_record btn btn-danger btn-xs" data-kode="$1">Hapus</a>','barang_kode,barang_nama,barang_harga,kategori_id,kategori_nama');
        // header('Content-Type: application/json');
        // $this->db->select('nama,noid,alamat');
        // $data['user'] = $this->db->query('select donaturbaru.kwsn, donaturbaru.noid, donaturbaru.nama, donaturbaru.status, donaturbaru.alamat, program.NM_PROGRAM, donatur_item.besar, kawasan.kodejgt from donaturbaru join donatur_item on autoid = donatur_item.noid join program on donatur_item.prog = program.PROG join kawasan on donaturbaru.kwsn = kawasan.kwsn ORDER BY donaturbaru.lastupdate limit '.$config['per_page'].' offset '. $from)->result();
        $data['user'] = $this->mdonatur->getDonatur($config['per_page'], $from);
        // echo "<pre>";
        // print_r($data['user']);
        // echo "</pre>";return;
        $this->load->view('untitled', $data);
        // echo json_encode($this->db->get('donaturbaru', $config['per_page'], $from)->result());
    }
}

/* End of file  */
/* Location: ./application/controllers/ */
