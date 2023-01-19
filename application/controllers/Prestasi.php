<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Prestasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mprestasi');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('admin') == TRUE) {
          if ($this->session->userdata('superadmin') == TRUE) {
              $data['jungut'] = $this->mprestasi->getAll();
          } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
              $idCabang = $this->session->userdata('idcab');
              $data['jungut'] = $this->mprestasi->getJgtCabang($idCabang);
          } else if ($this->session->userdata('admin_grup') == TRUE) {
              $idGrup = $this->session->userdata('idgrup');
              $data['jungut'] = $this->mprestasi->getJgtGrup($idGrup);
          }
            $this->load->view('prestasi',$data);
        } else {
            redirect(base_url());
        }
    }

    public function cetakRekap() {


      if ($this->input->post('btncetak')) {
        $jungut = $this->input->post('jungut');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $data['prestasi'] = $this->mprestasi->getPrst($jungut,$tahun,$bulan);
        $data['tahun'] = $tahun;
        $data['jungut'] = $jungut;
        if ($bulan == '01') {
          $data['nm_bulan'] = "JANUARI";
        }elseif ($bulan == '02') {
          $data['nm_bulan'] = "FEBRUARI";
        }elseif ($bulan == '03') {
          $data['nm_bulan'] = "MARET";
        }elseif ($bulan == '04') {
          $data['nm_bulan'] = "APRIL";
        }elseif ($bulan == '05') {
          $data['nm_bulan'] = "MEI";
        }elseif ($bulan == '06') {
          $data['nm_bulan'] = "JUNI";
        }elseif ($bulan == '07') {
          $data['nm_bulan'] = "JULI";
        }elseif ($bulan == '08') {
          $data['nm_bulan'] = "AGUSTUS";
        }elseif ($bulan == '09') {
          $data['nm_bulan'] = "SEPTEMBER";
        }elseif ($bulan == '10') {
          $data['nm_bulan'] = "OKTOBER";
        }elseif ($bulan == '11') {
          $data['nm_bulan'] = "NOVEMBER";
        }elseif ($bulan == '12') {
          $data['nm_bulan'] ="DESEMBER";
        }
        $this->load->view('rekap_prestasi', $data);
      }else {
        $jungut = $this->input->post('jungut');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $data['prestasi'] = $this->mprestasi->getPrst($jungut,$tahun,$bulan);
        $data['tahun'] = $tahun;
        $data['jungut'] = $jungut;
        if ($bulan == '01') {
          $data['nm_bulan'] = "JANUARI";
        }elseif ($bulan == '02') {
          $data['nm_bulan'] = "FEBRUARI";
        }elseif ($bulan == '03') {
          $data['nm_bulan'] = "MARET";
        }elseif ($bulan == '04') {
          $data['nm_bulan'] = "APRIL";
        }elseif ($bulan == '05') {
          $data['nm_bulan'] = "MEI";
        }elseif ($bulan == '06') {
          $data['nm_bulan'] = "JUNI";
        }elseif ($bulan == '07') {
          $data['nm_bulan'] = "JULI";
        }elseif ($bulan == '08') {
          $data['nm_bulan'] = "AGUSTUS";
        }elseif ($bulan == '09') {
          $data['nm_bulan'] = "SEPTEMBER";
        }elseif ($bulan == '10') {
          $data['nm_bulan'] = "OKTOBER";
        }elseif ($bulan == '11') {
          $data['nm_bulan'] = "NOVEMBER";
        }elseif ($bulan == '12') {
          $data['nm_bulan'] ="DESEMBER";
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
        ->mergeCells('A1:Q1')->getStyle('A1')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A2','REKAP PRESTASI TOTAL PER JUNGUT ')
        ->mergeCells('A2:Q2')->getStyle('A2')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A3','KODE JUNGUT : '.$jungut.'     PERIODE : '.$data['nm_bulan'].' '.$tahun.'     TANGGAL CETAK : '.$tanggal_cetak)
        ->mergeCells('A3:Q3')->getStyle('A3')
        ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('A4','')
        ->mergeCells('A4:Q4')->getStyle('A4')
        ->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('A5','NO.')
          ->mergeCells('A5:A6')->getStyle('A5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('center');
        $sheet->setCellValue('B5','KAWASAN')
          ->mergeCells('B5:B6')->getStyle('B5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('center');
        $sheet->setCellValue('C5','TARGET')
          ->mergeCells('C5:D5')->getStyle('C5')
          ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('E5','RK')
          ->mergeCells('E5:E6')->getStyle('E5')
          ->getAlignment()->setVertical('center')
          ->setHorizontal('center');
        $sheet->setCellValue('F5','HASIL')
          ->mergeCells('F5:G5')->getStyle('F5')
          ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('H5','GAGAL')
          ->mergeCells('H5:I5')->getStyle('H5')
          ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('J5','DONATUR BARU')
          ->mergeCells('J5:K5')->getStyle('J5')
          ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('L5','LEBIH')
          ->mergeCells('L5:M5')->getStyle('L5')
          ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('N5','TOTAL')
          ->mergeCells('N5:O5')->getStyle('N5')
          ->getAlignment()->setHorizontal('center');
        $sheet->setCellValue('P5','%')
          ->mergeCells('P5:Q5')->getStyle('P5')
          ->getAlignment()->setHorizontal('center');

        $sheet->setCellValue('C6','DONATUR');
        $sheet->setCellValue('D6','DONASI');
        $sheet->setCellValue('F6','DONATUR');
        $sheet->setCellValue('G6','DONASI');
        $sheet->setCellValue('H6','DONATUR');
        $sheet->setCellValue('I6','DONASI');
        $sheet->setCellValue('J6','DONATUR');
        $sheet->setCellValue('K6','DONASI');
        $sheet->setCellValue('L6','DONATUR');
        $sheet->setCellValue('M6','DONASI');
        $sheet->setCellValue('N6','DONATUR');
        $sheet->setCellValue('O6','DONASI');
        $sheet->setCellValue('P6','DONATUR');
        $sheet->setCellValue('Q6','DONASI');

        $row=7;
        foreach ($data['prestasi'] as $no => $tampil) {
        $sheet->setCellValue('A'.$row,$no+1)
        ->getStyle('A'.$row)
        ->getAlignment()->setHorizontal('left');
        $sheet->setCellValue('B'.$row,' '.$tampil->KWSN);
        $sheet->setCellValue('C'.$row,$tampil->t_dnt);
        $sheet->setCellValue('D'.$row,number_format($tampil->t_dns,0,'.',','))->getStyle('D'.$row)
        ->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('E'.$row,$tampil->RK);
        $sheet->setCellValue('F'.$row,$tampil->h_dnt);
        $sheet->setCellValue('G'.$row,number_format($tampil->h_dns,0,'.',','))->getStyle('G'.$row)
        ->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('H'.$row,$tampil->g_dnt);
        $sheet->setCellValue('I'.$row,number_format($tampil->g_dns,0,'.',','))->getStyle('I'.$row)
        ->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('J'.$row,$tampil->b_dnt);
        $sheet->setCellValue('K'.$row,number_format($tampil->b_dns,0,'.',','))->getStyle('K'.$row)
        ->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('L'.$row,$tampil->l_dnt);
        $sheet->setCellValue('M'.$row,number_format($tampil->l_dns,0,'.',','))->getStyle('M'.$row)
        ->getAlignment()->setHorizontal('right');
        $sheet->setCellValue('N'.$row,$tampil->tt_dnt);
        $sheet->setCellValue('O'.$row,number_format($tampil->tt_dns,0,'.',','))->getStyle('O'.$row)
        ->getAlignment()->setHorizontal('right');
        $target=0;$total=0;
        $target +=$tampil->t_dnt;
        $total +=$tampil->tt_dnt;
        $sheet->setCellValue('P'.$row,number_format(intval($total) / intval($target)*100,2,',',','))->getStyle('P'.$row)
        ->getAlignment()->setHorizontal('right');
        $target=0;$total=0;
        $target +=$tampil->t_dns;
        $total +=$tampil->tt_dns;
        $sheet->setCellValue('Q'.$row,number_format(intval($total) / intval($target)*100,2 ,',',','))->getStyle('Q'.$row)
        ->getAlignment()->setHorizontal('right');
        $row++;
        }
        $rows = intval(count($data['prestasi']));
        $row= $rows+7;

        $sheet->setCellValue('A'.$row,'JUMLAH')
        ->mergeCells('A'.$row.':B'.$row)->getStyle('A'.$row)
        ->getAlignment()->setHorizontal('center');

        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->t_dnt;
        }
        $sheet->setCellValue('C'.$row,$tot);
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->h_dnt;
        }
        $sheet->setCellValue('F'.$row,$tot);
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->g_dnt;
        }
        $sheet->setCellValue('H'.$row,$tot);
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->b_dnt;
        }
        $sheet->setCellValue('J'.$row,$tot);
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->l_dnt;
        }
        $sheet->setCellValue('L'.$row,$tot);
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->tt_dnt;
        }
        $sheet->setCellValue('N'.$row,$tot);
        $target=0;$total=0;
        foreach($data['prestasi'] as $tampil){
          $target +=$tampil->t_dnt;
          $total +=$tampil->tt_dnt;
        }
        if ($target == '0') {
        $sheet->setCellValue('P'.$row,' 0');
        }else {
          $sheet->setCellValue('P'.$row,number_format(intval($total)/intval($target)*100,2,',',','))->getStyle('P'.$row)
          ->getAlignment()->setHorizontal('right');
        }

        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->t_dns;
        }
        $sheet->setCellValue('D'.$row,number_format($tot,0,'.',','))->getStyle('D'.$row)
        ->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->h_dns;
        }
        $sheet->setCellValue('G'.$row,number_format($tot,0,'.',','))->getStyle('G'.$row)
        ->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->g_dns;
        }
        $sheet->setCellValue('I'.$row,number_format($tot,0,'.',','))->getStyle('I'.$row)
        ->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->b_dns;
        }
        $sheet->setCellValue('K'.$row,number_format($tot,0,'.',','))->getStyle('K'.$row)
        ->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->l_dns;
        }
        $sheet->setCellValue('M'.$row,number_format($tot,0,'.',','))->getStyle('M'.$row)
        ->getAlignment()->setHorizontal('right');
        $tot=0;
        foreach($data['prestasi'] as $tampil){
          $tot +=$tampil->tt_dns;
        }
        $sheet->setCellValue('O'.$row,number_format($tot,0,'.',','))->getStyle('O'.$row)
        ->getAlignment()->setHorizontal('right');
        $target=0;$total=0;
        foreach($data['prestasi'] as $tampil){
          $target +=$tampil->t_dns;
          $total +=$tampil->tt_dns;
        }
        if ($target == '0') {
        $sheet->setCellValue('Q'.$row,' 0');
        }else {
          $sheet->setCellValue('Q'.$row,number_format(intval($total)/intval($target)*100,2,',',','))->getStyle('Q'.$row)
          ->getAlignment()->setHorizontal('right');
        }

        $sheet->getStyle('A5:Q'.$row)->applyFromArray($styleArray);
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap_prestasi_per_kawasan';

        // download file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');


      }

    }


}

/* End of file Prestasi.php */
