<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Slipbank extends CI_Controller{

    public function __construct(){
      parent:: __construct();
      $this->load->model('mslip_bank');
      $this->load->model('mpage');
      if ($this->session->userdata('login') != TRUE) {
        redirect(base_url());
      }
    }

    public function index(){
      if ($this->session->userdata('admin') == TRUE) {
          if ($this->session->userdata('superadmin') == TRUE) {
              $data['jungut'] = $this->mpage->getAll();
          } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
              $data['jungut'] = $this->mpage->getAllTwo($this->session->userdata('idcab'));
          } else if ($this->session->userdata('admin_grup') == TRUE) {
              $data['jungut'] = $this->mpage->getAllFour($this->session->userdata('idgrup'));
          } else {
              $data['jungut'] = $this->mpage->getAllThree($this->session->userdata('ses_kodej'));
        }
          $this->load->view('slip_bank',$data);
      } else {
        $idUser = $this->session->userdata('usrid');
        $data['jungut'] = $this->mslip_bank->getJgtUser($idUser);
        $this->load->view('slip_bank',$data);
      }
    }

    public function perSlip() {
      $post = $this->input->post();
      $tgl = explode(' - ', $post['tgl']);
      if ($post['tgl'] == '') {
          $data['date'] = array (
            'date_himp1' => '',
            'date_himp2' => '',
          );
      }else {
        $data['date'] = array (
          'date_himp1' => $tgl[0],
          'date_himp2' => $tgl[1]
        );
      }
 
      if ($this->input->post('btncetak')) {
        if ($post['jungut'] == '-') {
          $data['perJgt'] = $this->mslip_bank->perJgtAll();
          $this->load->view('rekap_slip_bank', $data);
        }elseif($post['jungut'] == '--'){
          $data['perJgt'] = $this->mslip_bank->perJgtGrup();
          $this->load->view('rekap_slip_bank', $data);
        }else {
          $data['perJgt'] = $this->mslip_bank->perJgt($post['jungut']);
          $this->load->view('rekap_slip_bank', $data);
        }
      }else {
        if ($post['jungut'] == '-') {
          $data['perJgt'] = $this->mslip_bank->perJgtAll();
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
          ->mergeCells('A1:S1')->getStyle('A1')
          ->getAlignment()->setHorizontal('center');
          $sheet->setCellValue('A2','REKAP TOTAL SLIP PER JUNGUT')
          ->mergeCells('A2:S2')->getStyle('A2')
          ->getAlignment()->setHorizontal('center');
          $sheet->setCellValue('A3','KODE JUNGUT : ALL     PERIODE : '.$data['date']['date_himp1']." s/d ".$data['date']['date_himp2']."     TANGGAL CETAK : ".$tanggal_cetak)
          ->mergeCells('A3:S3')->getStyle('A3')
          ->getAlignment()->setHorizontal('center');
          $sheet->setCellValue('A4','')
          ->mergeCells('A4:S4')->getStyle('A4')
          ->getAlignment()->setHorizontal('center');

          $sheet->setCellValue('A5','No');
          $sheet->setCellValue('B5',' Entry Pegawai')
          ->mergeCells('B5:E5');
          $sheet->setCellValue('F5',' Jumlah')
          ->mergeCells('F5:G5');
          $sheet->setCellValue('H5',' Infaq')
          ->mergeCells('H5:I5');
          $sheet->setCellValue('J5',' Pena Bangsa')
          ->mergeCells('J5:K5');
          $sheet->setCellValue('L5',' Zakat')
          ->mergeCells('L5:M5');
          $sheet->setCellValue('N5',' Rumah Cinta Yatim')
          ->mergeCells('N5:O5');
          $sheet->setCellValue('P5',' Cinta Guru Quran')
          ->mergeCells('P5:Q5');
          $sheet->setCellValue('R5',' Lain-lain')
          ->mergeCells('R5:S5');

          $row=6;
          foreach($data['perJgt'] as $no => $slip){
          $sheet->setCellValue('A'.$row,' '.$no+1)
          ->getStyle('A'.$row)
          ->getAlignment()->setHorizontal('left');
          $sheet->setCellValue('B'.$row,' '.$slip->entr_pegawai." - ".$slip->name)
          ->mergeCells('B'.$row.':E'.$row);
          $sheet->setCellValue('F'.$row,' '.number_format($slip->total,0,'.',','))
          ->mergeCells('F'.$row.':G'.$row);
          $sheet->setCellValue('H'.$row,' '.number_format($slip->infaq,0,'.',','))
          ->mergeCells('H'.$row.':I'.$row);
          $sheet->setCellValue('J'.$row,' '.number_format($slip->pena,0,'.',','))
          ->mergeCells('J'.$row.':K'.$row);
          $sheet->setCellValue('L'.$row,' '.number_format($slip->zakat,0,'.',','))
          ->mergeCells('L'.$row.':M'.$row);
          $sheet->setCellValue('N'.$row,' '.number_format($slip->RCY,0,'.',','))
          ->mergeCells('N'.$row.':O'.$row);
          $sheet->setCellValue('P'.$row,' '.number_format($slip->CGQ,0,'.',','))
          ->mergeCells('P'.$row.':Q'.$row);
          $sheet->setCellValue('R'.$row,' '.number_format($slip->dll,0,'.',','))
          ->mergeCells('R'.$row.':S'.$row);
          $row++;
        }
        $rows = intval(count($data['perJgt']));
        $row= $rows+6;
        $sheet->setCellValue('A'.$row,'JUMLAH')
        ->mergeCells('A'.$row.':E'.$row)->getStyle('A'.$row)
        ->getAlignment()->setHorizontal('center');
        //
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->total;
        }
        $sheet->setCellValue('F'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('F'.$row.':G'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->infaq;
        }
        $sheet->setCellValue('H'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('H'.$row.':I'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->pena;
        }
        $sheet->setCellValue('J'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('J'.$row.':K'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->zakat;
        }
        $sheet->setCellValue('L'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('l'.$row.':M'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->RCY;
        }
        $sheet->setCellValue('N'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('N'.$row.':O'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->CGQ;
        }
        $sheet->setCellValue('P'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('P'.$row.':Q'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->dll;
        }
        $sheet->setCellValue('N'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('N'.$row.':O'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->CGQ;
        }
        $sheet->setCellValue('P'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('P'.$row.':Q'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->dll;
        }
        $sheet->setCellValue('R'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('R'.$row.':S'.$row);
        $sheet->getStyle('A5:S'.$row)->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_slip_bank';

        // download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');


        }else {
          $data['perJgt'] = $this->mslip_bank->perJgt($post['jungut']);
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
          foreach($data['perJgt'] as $slip){
          $sheet->setCellValue('A1','')
          ->mergeCells('A1:S1')->getStyle('A1')
          ->getAlignment()->setHorizontal('center');
          $sheet->setCellValue('A2','REKAP TOTAL SLIP PER JUNGUT')
          ->mergeCells('A2:S2')->getStyle('A2')
          ->getAlignment()->setHorizontal('center');
          $sheet->setCellValue('A3','KODE JUNGUT : '.$slip->entr_pegawai.'     PERIODE : '.$data['date']['date_himp1']." s/d ".$data['date']['date_himp2']."     TANGGAL CETAK : ".$tanggal_cetak)
          ->mergeCells('A3:S3')->getStyle('A3')
          ->getAlignment()->setHorizontal('center');
          $sheet->setCellValue('A4','')
          ->mergeCells('A4:S4')->getStyle('A4')
          ->getAlignment()->setHorizontal('center');
          }
          $sheet->setCellValue('A5','No');
          $sheet->setCellValue('B5',' Entry Pegawai')
          ->mergeCells('B5:E5');
          $sheet->setCellValue('F5',' Jumlah')
          ->mergeCells('F5:G5');
          $sheet->setCellValue('H5',' Infaq')
          ->mergeCells('H5:I5');
          $sheet->setCellValue('J5',' Pena Bangsa')
          ->mergeCells('J5:K5');
          $sheet->setCellValue('L5',' Zakat')
          ->mergeCells('L5:M5');
          $sheet->setCellValue('N5',' Rumah Cinta Yatim')
          ->mergeCells('N5:O5');
          $sheet->setCellValue('P5',' Cinta Guru Quran')
          ->mergeCells('P5:Q5');
          $sheet->setCellValue('R5',' Lain-lain')
          ->mergeCells('R5:S5');

          $row=6;
          foreach($data['perJgt'] as $no => $slip){
          $sheet->setCellValue('A'.$row,' '.$no+1)
          ->getStyle('A'.$row)
          ->getAlignment()->setHorizontal('left');
          $sheet->setCellValue('B'.$row,' '.$slip->entr_pegawai." - ".$slip->name)
          ->mergeCells('B'.$row.':E'.$row);
          $sheet->setCellValue('F'.$row,' '.number_format($slip->total,0,'.',','))
          ->mergeCells('F'.$row.':G'.$row);
          $sheet->setCellValue('H'.$row,' '.number_format($slip->infaq,0,'.',','))
          ->mergeCells('H'.$row.':I'.$row);
          $sheet->setCellValue('J'.$row,' '.number_format($slip->pena,0,'.',','))
          ->mergeCells('J'.$row.':K'.$row);
          $sheet->setCellValue('L'.$row,' '.number_format($slip->zakat,0,'.',','))
          ->mergeCells('L'.$row.':M'.$row);
          $sheet->setCellValue('N'.$row,' '.number_format($slip->RCY,0,'.',','))
          ->mergeCells('N'.$row.':O'.$row);
          $sheet->setCellValue('P'.$row,' '.number_format($slip->CGQ,0,'.',','))
          ->mergeCells('P'.$row.':Q'.$row);
          $sheet->setCellValue('R'.$row,' '.number_format($slip->dll,0,'.',','))
          ->mergeCells('R'.$row.':S'.$row);
          $row++;
        }
        $rows = intval(count($data['perJgt']));
        $row= $rows+6;
        $sheet->setCellValue('A'.$row,'JUMLAH')
        ->mergeCells('A'.$row.':E'.$row)->getStyle('A'.$row)
        ->getAlignment()->setHorizontal('center');
        //
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->total;
        }
        $sheet->setCellValue('F'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('F'.$row.':G'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->infaq;
        }
        $sheet->setCellValue('H'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('H'.$row.':I'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->pena;
        }
        $sheet->setCellValue('J'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('J'.$row.':K'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->zakat;
        }
        $sheet->setCellValue('L'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('l'.$row.':M'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->RCY;
        }
        $sheet->setCellValue('N'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('N'.$row.':O'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->CGQ;
        }
        $sheet->setCellValue('P'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('P'.$row.':Q'.$row);
        $tot=0;
        foreach($data['perJgt'] as $slip){
            $tot +=$slip->dll;
        }
        $sheet->setCellValue('R'.$row,' '.number_format($tot,0,'.',','))
        ->mergeCells('R'.$row.':S'.$row);
        $sheet->getStyle('A5:S'.$row)->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_slip_bank';

        // download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        }
      }

    }
}
 ?>
