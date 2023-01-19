<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Kwsn_nol extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mkwsn_nol');
        $this->load->model('mpage');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('superadmin') == TRUE) {
            $data['jungut'] = $this->mpage->getAll();
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
            $idcabang = $this->session->userdata('idcab');
            $data['jungut'] = $this->mpage->getAllTwo($idcabang);
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $idgrup = $this->session->userdata('idgrup');
            $data['jungut'] = $this->mpage->getAllFour($idgrup);
        } else {
            $kodej = $this->session->userdata('ses_kodej');
            $data['jungut'] = $this->mpage->getAllThree($kodej);
        }
        $this->load->view('kawasan_nol', $data);
    }

    public function getData() {
      if ($this->session->userdata('admin') == TRUE) {
        $tgl = explode(' - ', $this->input->get('date'));
        // $this->session->set_userdata('tgl', $this->input->get('date'));
        $this->session->set_userdata('kodej', $this->input->get('kodej'));
        list($jungut,$nm_jungut) = explode('|', $this->input->get('kodej'));
        $data = $this->mkwsn_nol->getKawasanNol($jungut, $tgl[0],$tgl[1]);
        echo json_encode($data);
      }else {
        redirect(base_url());
      }
    }

    public function cetakRekap(){
      if ($this->session->userdata('admin') == TRUE) {
        $jungut = $_GET['jungut'];
        $tgl = explode(' - ', $this->input->get('tgl'));
        $data['kwsnNol'] = $this->mkwsn_nol->getKawasanNol($jungut,$tgl[0],$tgl[1]);
        $this->load->view('rekap_kawasan_nol', $data);
      }else {
        redirect(base_url());
      }
    }

    public function dataExcel(){
      if ($this->session->userdata('admin') == TRUE) {
        $jungut = $_GET['jungut'];
        $tgl = explode(' - ', $this->input->get('tgl'));
        $data['kwsnNol'] = $this->mkwsn_nol->getKawasanNol($jungut,$tgl[0],$tgl[1]);
        $tgl1 = $tgl[0]; $tgl2 = $tgl[1];
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_cetak = date("Y-m-d h:i:s");
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

        $ra = array();
        for ($r = "A", $e = "L";$r <= $e ;$r++) {
            $ra[] = [$r];
        }
        $sheet->setCellValue('A1','')
        ->mergeCells('A1:L1')->getStyle('A1')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A2','REKAP KAWASAN KURANG TARGET ')
        ->mergeCells('A2:L2')->getStyle('A2')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A3','KODE JUNGUT : '.$jungut.'     PERIODE : '.$tgl1.' S/D '.$tgl2.'     TANGGAL CETAK : '.$tanggal_cetak)
        ->mergeCells('A3:L3')->getStyle('A3')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A4','')
        ->mergeCells('A4:L4')->getStyle('A4')
        ->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('A5','NO.')
          ->mergeCells('A5:A6')->getStyle('A5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('left');
        $sheet->setCellValue('B5','Kawasan')
          ->mergeCells('B5:C6')->getStyle('B5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('left');
        $sheet->setCellValue('D5','Nama Kawasan')
          ->mergeCells('D5:H6')->getStyle('D5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('left');
        $sheet->setCellValue('I5','Gagal Tagih')
          ->mergeCells('I5:K5')->getStyle('I5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('left');
        $sheet->setCellValue('L5','RK')
          ->mergeCells('L5:L6')->getStyle('L5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('left');

        $sheet->setCellValue('I6','Donatur');
        $sheet->setCellValue('J6','Donasi')
          ->mergeCells('J6:K6')->getStyle('J6')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('left');

        $row=7;
        foreach ($data['kwsnNol'] as $no => $tampil) {
          $sheet->setCellValue('A'.$row,$no+1)
          ->getStyle('A'.$row)
          ->getAlignment()->setHorizontal('left');
          $sheet->setCellValue('B'.$row,$tampil->kwsn.'/'.$tampil->kwsn_lm)
            ->mergeCells('B'.$row.':C'.$row)->getStyle('B'.$row)
            ->getAlignment()->setVertical('center')
            ->setHorizontal('left');
          $sheet->setCellValue('D'.$row,$tampil->ins_pk)
            ->mergeCells('D'.$row.':H'.$row)->getStyle('D'.$row)
            ->getAlignment()->setVertical('center')
            ->setHorizontal('left');
          $sheet->setCellValue('I'.$row,$tampil->noid);
          $sheet->setCellValue('J'.$row,number_format($tampil->infaq,0,'.',','))
            ->mergeCells('J'.$row.':K'.$row)->getStyle('J'.$row)
            ->getAlignment()->setHorizontal('right');
          $sheet->setCellValue('L'.$row,$tampil->rk);

          $row++;
        }
        $rows = intval(count($data['kwsnNol']));
        $row= $rows+7;

        $sheet->setCellValue('A'.$row,'TOTAL')
        ->mergeCells('A'.$row.':H'.$row)->getStyle('A'.$row)
        ->getAlignment()->setHorizontal('center');

        $tot=0;
        foreach($data['kwsnNol'] as $tampil){
          $tot +=$tampil->noid;
        }
        $sheet->setCellValue('I'.$row,number_format($tot,0,'.',','))->getStyle('I'.$row)
        ->getAlignment()->setHorizontal('right');

        $tot=0;
        foreach($data['kwsnNol'] as $tampil){
          $tot +=$tampil->infaq;
        }
        $sheet->setCellValue('J'.$row,number_format($tot,0,'.',','))
        ->mergeCells('J'.$row.':K'.$row)->getStyle('J'.$row)
        ->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('L'.$row,'');

        $sheet->getStyle('A5:L'.$row)->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_kawasan_kurang_target';

        // download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');$sheet->getStyle('A5:L'.$row)->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_kawasan_nol';

        // download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
      }else {
        redirect(base_url());
      }
    }

    public function dataKwsn(){
      if ($this->session->userdata('admin') == TRUE) {
        //parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
        list($jungut,$nm_jungut) = explode('|', $this->input->get('kodej'));
        $tgl = explode(' - ', $this->input->get('tgl'));
        $kwsn = $_GET['kwsn'];
        $data['kwsn_Nol'] = $this->mkwsn_nol->getDataDonatur($jungut,$tgl[0],$tgl[1],$kwsn);
        $this->load->view('rekap_data_kawasan_nol', $data);
      }else {
        redirect(base_url());
      }
    }
  }
 ?>
