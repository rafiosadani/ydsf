<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Harian extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('mprogram');
        $this->load->model('mpage');
        $this->load->library('form_validation');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('superadmin') == TRUE) {
            $data['report'] = $this->mpage->getAll();
        } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
            $data['report'] = $this->mpage->getAllTwo($this->session->userdata('idcab'));
        } else if ($this->session->userdata('admin_grup') == TRUE) {
            $data['report'] = $this->mpage->getAllFour($this->session->userdata('idgrup'));
        } else {
            $data['report'] = $this->mpage->getAllThree($this->session->userdata('ses_kodej'));
        }
        $this->load->view('harian', $data);
    }

    public function cetakRekap() {
        if ($this->input->post('cetak')) {
            $tanggal = explode(" - ", $this->input->post('date'));
            $data['date'] = array(
                'tanggal1' => $tanggal[0],
                'tanggal2' => $tanggal[1]
            );
            if ($this->input->post('kodej') == '-') {
                if ($this->session->userdata('superadmin') == TRUE) {
                    $data['count'] = $this->mprogram->getCountAll();
                    $data['rekap'] = $this->mprogram->getAll();
                } else if ($this->session->userdata('admin_grup') == TRUE) {
                    $data['count'] = $this->mprogram->getCountGrup();
                    $data['rekap'] = $this->mprogram->getGrup();
                }
            } else {
                $data['count'] = $this->mprogram->getCount($this->input->post('kodej'));
                $data['rekap'] = $this->mprogram->getHarian($this->input->post('kodej'));
            }
            $this->load->view('rekap_harian', $data);
        } else {
            $tanggal = explode(" - ", $this->input->post('date'));
            if ($this->input->post('kodej') == '-') {
                if ($this->session->userdata('superadmin') == TRUE) {
                    $data['count'] = $this->mprogram->getCountAll();
                    $data['rekap'] = $this->mprogram->getAll();
                } else if ($this->session->userdata('admin_grup') == TRUE) {
                    $data['count'] = $this->mprogram->getCountGrup();
                    $data['rekap'] = $this->mprogram->getGrup();
                }
            } else {
                $data['count'] = $this->mprogram->getCount($this->input->post('kodej'));
                $data['rekap'] = $this->mprogram->getHarian($this->input->post('kodej'));
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

            $sheet->setCellValue('A1', 'REKAP HARIAN TOTAL PER JUNGUT')
                ->mergeCells('A1:M1')->getStyle('A1')
                ->getAlignment()->setHorizontal('center');
            $sheet->setCellValue('A2', "PERIODE : ".date('d-m-Y', strtotime($tanggal[0]))." s/d ".date('d-m-Y', strtotime($tanggal[1])).$nbsp.$nbsp.$nbsp."TANGGAL CETAK : ".date('d-m-Y h:i'))
                ->mergeCells('A2:M2')->getStyle('A2')
                ->getAlignment()->setHorizontal('center');

            $sheet->setCellValue('A4', 'No.')
                ->mergeCells('A4:A5')->getStyle('A4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('B4', 'Jungut')
                ->mergeCells('B4:B5')->getStyle('B4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('C4', 'Nama')
                ->mergeCells('C4:D5')->getStyle('C4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('E4', 'Target')
                ->mergeCells('E4:F4')->getStyle('E4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('E5', 'Donatur')
                ->getStyle('E5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('F5', 'Donasi')
                ->getStyle('F5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('G4', 'Tot Perolehan')
                ->mergeCells('G4:H4')->getStyle('G4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('G5', 'Donatur')
                ->getStyle('G5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('H5', 'Donasi')
                ->getStyle('H5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('I4', 'Rata-Rata')
                ->mergeCells('I4:J4')->getStyle('I4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('I5', 'Donatur')
                ->getStyle('I5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('J5', 'Donasi')
                ->getStyle('J5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('K4', 'Rata2')
                ->mergeCells('K4:K5')->getStyle('K4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('L4', 'Keuangan')
                ->mergeCells('L4:M4')->getStyle('L4')
                ->getAlignment()->setVertical('center')
                ->setHorizontal('center');
            $sheet->setCellValue('L5', 'Setor')
                ->getStyle('L5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('M5', 'Blm Setor')
                ->getStyle('M5')->getAlignment()
                ->setVertical('center')->setHorizontal('center');

            $row = 6;
            $sum1 = $sum2 = $sum3 = $sum4 = $sum5 = $sum6 = $sum7 = $sum8 = $sum9 = 0;
            foreach ($data['rekap'] as $key => $rekap) {
                $sum1 += $rekap->t_dnt;
                $sum2 += $rekap->t_dns;
                $sum3 += $rekap->h_dnt;
                $sum4 += $rekap->h_dns;
                $sum5 += round(100*($rekap->h_dnt/$rekap->t_dnt) / $data['count']->total ,2);
                $sum6 += round(100*($rekap->h_dns/$rekap->t_dns) / $data['count']->total ,2);
                $sum8 += $rekap->keu_y;
                $sum9 += $rekap->keu_n;
                
                $sheet->setCellValue('A'.$row, $key+1)
                    ->getStyle('A'.$row)->getAlignment()
                    ->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('B'.$row, $rekap->kodej)
                    ->getStyle('B'.$row)->getAlignment()
                    ->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('C'.$row, $rekap->name)
                    ->mergeCells('C'.$row.":D".$row)
                    ->getStyle('C'.$row)->getAlignment()
                    ->setVertical('center')->setHorizontal('center');
                $sheet->setCellValue('E'.$row, number_format($rekap->t_dnt,0,'.',','))
                    ->getStyle('E'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('F'.$row, number_format($rekap->t_dns,0,'.',','))
                    ->getStyle('F'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('G'.$row, number_format($rekap->h_dnt,0,'.',','))
                    ->getStyle('G'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('H'.$row, number_format($rekap->h_dns,0,'.',','))
                    ->getStyle('H'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('I'.$row, round(100*($rekap->h_dnt/$rekap->t_dnt),2)."%")
                    ->getStyle('I'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('J'.$row, round(100*($rekap->h_dns/$rekap->t_dns),2)."%")
                    ->getStyle('J'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('K'.$row, (((round(100*($rekap->h_dnt/$rekap->t_dnt),2))+(round(100*($rekap->h_dns/$rekap->t_dns),2))) / 2)."%")
                    ->getStyle('K'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('L'.$row, number_format($rekap->keu_y,0,'.',','))
                    ->getStyle('L'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $sheet->setCellValue('M'.$row, number_format($rekap->keu_n,0,'.',','))
                    ->getStyle('M'.$row)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                $row++;
            }

            $sum7 += (($sum5)+($sum6)) / 2;

            $sheet->setCellValue('A'.$row, "JUMLAH")
                ->mergeCells('A'.$row.":D".$row)
                ->getStyle('A'.$row)->getAlignment()
                ->setVertical('center')->setHorizontal('center');
            $sheet->setCellValue('E'.$row, number_format($sum1,0,'.',','))
                ->getStyle('E'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('F'.$row, number_format($sum2,0,'.',','))
                ->getStyle('F'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('G'.$row, number_format($sum3,0,'.',','))
                ->getStyle('G'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('H'.$row, number_format($sum4,0,'.',','))
                ->getStyle('H'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('I'.$row, $sum5."%")
                ->getStyle('I'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('J'.$row, $sum6."%")
                ->getStyle('J'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('K'.$row, $sum7."%")
                ->getStyle('K'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('L'.$row, number_format($sum8,0,'.',','))
                ->getStyle('L'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->setCellValue('M'.$row, number_format($sum9,0,'.',','))
                ->getStyle('M'.$row)->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

            $sheet->getStyle('A4:M'.$row)->applyFromArray($styleArray);

            $writer = new Xlsx($spreadsheet);
            $filename = 'rekap_harian_jgt';
            
            // download file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }
    }

}

/* End of file Harian.php */
