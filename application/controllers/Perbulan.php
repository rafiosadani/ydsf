<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Perbulan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('mperbulan');
    if ($this->session->userdata('login') != TRUE) {
        redirect(base_url());
    }
  }

  public function index(){
    if ($this->session->userdata('admin') == TRUE) {
        if ($this->session->userdata('superadmin') == TRUE) {
            $data['cabang'] = $this->mperbulan->getCabang();
            $data['prog'] = $this->mperbulan->getProgram();
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
            $data['cabang'] = $this->mperbulan->getCabangCab();
            $data['prog'] = $this->mperbulan->getProgram();
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['cabang'] = $this->mperbulan->getCabangGrup();
            $data['prog'] = $this->mperbulan->getProgram();
        }
        $this->load->view('per_bulan', $data);
    } else {
        redirect(base_url());
    }
}

    public function cetakRekap() {
      $tahun = $this->input->post('tahun');
      $post = $this->input->post();
      if ($this->input->post('btncetak')) {
        if ($post['cabang'] == '-' && $post['program'] == '--') {
          $data['perBln'] = $this->mperbulan->allPrognCab($tahun);
          $data['tahun'] = $tahun;
          $data['wilayah'] = "SEMUA WILAYAH";
          $data['program'] = "SEMUA PROGRAM";
          $this->load->view('rekap_perbulan', $data);
        }elseif ($post['cabang'] == '-' && $post['program'] !== '--') {
          list($program,$nm_program) = explode('|', $_POST['program']);
          $data['perBln'] = $this->mperbulan->allCabntProg($tahun,$program);
          $data['tahun'] = $tahun;
          $data['wilayah'] = "SEMUA WILAYAH";
          $data['program'] = $nm_program;
          $this->load->view('rekap_perbulan', $data);
        }elseif ( $post['program'] == '--' && $post['cabang'] !== '-') {
          list($wilayah,$nm_wilayah) = explode('|', $_POST['cabang']);
          $data['perBln'] = $this->mperbulan->allProgntCab($tahun,$wilayah);
          $data['tahun'] = $tahun;
          $data['wilayah'] = $nm_wilayah;
          $data['program'] = "SEMUA PROGRAM";
          $this->load->view('rekap_perbulan', $data);
        }else{
          list($wilayah,$nm_wilayah) = explode('|', $_POST['cabang']);
          list($program,$nm_program) = explode('|', $_POST['program']);
          $data['perBln'] = $this->mperbulan->prognCab($tahun,$wilayah,$program);
          $data['tahun'] = $tahun;
          $data['wilayah'] = $nm_wilayah;
          $data['program'] = $nm_program;
          $this->load->view('rekap_perbulan', $data);
        }
      }else {
        if ($post['cabang'] == '-' && $post['program'] == '--') {
          $data['perBln'] = $this->mperbulan->allPrognCab($tahun);
          $data['tahun'] = $tahun;
          $data['wilayah'] = "SEMUA WILAYAH";
          $data['program'] = "SEMUA PROGRAM";
        }elseif ($post['cabang'] == '-' && $post['program'] !== '--') {
          list($program,$nm_program) = explode('|', $_POST['program']);
          $data['perBln'] = $this->mperbulan->allCabntProg($tahun,$program);
          $data['tahun'] = $tahun;
          $data['wilayah'] = "SEMUA WILAYAH";
          $data['program'] = $nm_program;
        }elseif ( $post['program'] == '--' && $post['cabang'] !== '-') {
          list($wilayah,$nm_wilayah) = explode('|', $_POST['cabang']);
          $data['perBln'] = $this->mperbulan->allProgntCab($tahun,$wilayah);
          $data['tahun'] = $tahun;
          $data['wilayah'] = $nm_wilayah;
          $data['program'] = "SEMUA PROGRAM";
        }else{
          list($wilayah,$nm_wilayah) = explode('|', $_POST['cabang']);
          list($program,$nm_program) = explode('|', $_POST['program']);
          $data['perBln'] = $this->mperbulan->prognCab($tahun,$wilayah,$program);
          $data['tahun'] = $tahun;
          $data['wilayah'] = $nm_wilayah;
          $data['program'] = $nm_program;
        }

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
        ->mergeCells('A1:I1')->getStyle('A1')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A2','REKAP LAPORAN PER BULAN')
        ->mergeCells('A2:I2')->getStyle('A2')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A3','WILAYAH : '.$data['wilayah'].'     PROGRAM : '.$data['program'].'     PERIODE : '.$data['tahun'])
        ->mergeCells('A3:I3')->getStyle('A3')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A4','TANGGAL CETAK : '.$tanggal_cetak)
        ->mergeCells('A4:I4')->getStyle('A4')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A5','')
        ->mergeCells('A5:I5')->getStyle('A5')
        ->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('A6','BULAN')
          ->mergeCells('A6:A7')->getStyle('A6')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('center');
        $sheet->setCellValue('B6','TARGET')
          ->mergeCells('B6:D6')->getStyle('B6')
          ->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('E6','Perolehan')
          ->mergeCells('E6:G6')->getStyle('E6')
          ->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('H6','%')
          ->mergeCells('H6:I6')->getStyle('H6')
          ->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('B7','DONATUR')
          ->getStyle('B7')->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('C7','DONASI')
          ->mergeCells('C7:D7')->getStyle('C7')
          ->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('E7','DONATUR')
          ->getStyle('E7')->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('F7','DONASI')
          ->mergeCells('F7:G7')->getStyle('F7')
          ->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('H7','DONATUR')
          ->getStyle('H7')->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('I7','DONASI');

        $row=8;
        foreach ($data['perBln'] as $tampil) {
        $sheet->setCellValue('A'.$row,$tampil->BLN)
        ->getStyle('A'.$row)
        ->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('B'.$row,number_format($tampil->T_DNT,0,'.',','))
        ->getStyle('B'.$row)->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('C'.$row,number_format($tampil->T_DNS,0,'.',','))
        ->mergeCells('C'.$row.':D'.$row)->getStyle('C'.$row)->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('E'.$row,number_format($tampil->H_DNT,0,'.',','))
        ->getStyle('E'.$row)->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('F'.$row,number_format($tampil->H_DNS,0,'.',','))
        ->mergeCells('F'.$row.':G'.$row)->getStyle('F'.$row)->getAlignment()->setHorizontal('right');
        $target=0;$total=0;
        $target +=$tampil->T_DNT;
        $total +=$tampil->H_DNT;
        $sheet->setCellValue('H'.$row,number_format(intval($total) / intval($target)*100,2,'.','.'));
        $target=0;$total=0;
        $target +=$tampil->T_DNS;
        $total +=$tampil->H_DNS;
        $sheet->setCellValue('I'.$row,number_format(intval($total) / intval($target)*100,2,'.','.'));
        $row++;
      }
        $rows = intval(count($data['perBln']));
        $row= $rows+8;

        $sheet->setCellValue('A'.$row,'JUMLAH');

        $tot=0;
        foreach($data['perBln'] as $tampil){
          $tot +=$tampil->T_DNT;
        }
        $sheet->setCellValue('B'.$row,number_format($tot,0,'.',','))
        ->getStyle('B'.$row)->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['perBln'] as $tampil){
          $tot +=$tampil->T_DNS;
        }
        $sheet->setCellValue('C'.$row,number_format($tot,0,'.',','))
        ->mergeCells('C'.$row.':D'.$row)->getStyle('C'.$row)->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['perBln'] as $tampil){
          $tot +=$tampil->H_DNT;
        }
        $sheet->setCellValue('E'.$row,number_format($tot,0,'.',','))->getStyle('E'.$row)->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['perBln'] as $tampil){
          $tot +=$tampil->H_DNS;
        }
        $sheet->setCellValue('F'.$row,number_format($tot,0,'.',','))
        ->mergeCells('F'.$row.':G'.$row)->getStyle('F'.$row)->getAlignment()->setHorizontal('right');

        $target=0;$total=0;
        foreach($data['perBln'] as $tampil){
          $target +=$tampil->T_DNT;
          $total +=$tampil->H_DNT;
        }
        $sheet->setCellValue('H'.$row,number_format(intval($total)/intval($target)*100,2,'.','.'));
        $target=0;$total=0;
        foreach($data['perBln'] as $tampil){
          $target +=$tampil->T_DNS;
          $total +=$tampil->H_DNS;
        }
        $sheet->setCellValue('I'.$row,number_format(intval($total)/intval($target)*100,2,'.','.'));

        $sheet->getStyle('A6:I'.$row)->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_laporan_perbulan';


        // download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');





      }
    }
}
 ?>
