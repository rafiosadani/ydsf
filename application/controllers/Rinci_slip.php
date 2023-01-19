<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load library phpspreadsheet
require('./phpSpreadSheet/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// End load library phpspreadsheet

class Rinci_slip extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mrinci_slip');
        $this->load->model('mslip_bank');
        if ($this->session->userdata('login') != TRUE) {
            redirect(base_url());
        }
    }

    public function index() {
        if ($this->session->userdata('admin') == TRUE) {
            if ($this->session->userdata('superadmin') == TRUE) {
                $data['jungut'] = $this->Mrinci_slip->getAll();
            } else if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE) {
                $idCabang = $this->session->userdata('idcab');
                $data['jungut'] = $this->Mrinci_slip->getJgtCabang($idCabang);
            } else if ($this->session->userdata('admin_grup') == TRUE) {
                $idGrup = $this->session->userdata('idgrup');
                $data['jungut'] = $this->Mrinci_slip->getJgtGrup($idGrup);
            }
            $this->load->view('rinci_bank',$data);
        } else {
            $idUser = $this->session->userdata('usrid');
            $data['jungut'] = $this->mslip_bank->getJgtUser($idUser);
            $this->load->view('rinci_bank',$data);
      }
        
    }

    public function perRinciBank() {
        $post = $this->input->post();
        $tgl = explode(' - ', $post['tgl']);
        if ($post['tgl'] == '') {
            $data['date'] = array (
                'date_himp1' => '',
                'date_himp2' => '',
            );
        } else {
            $data['date'] = array (
                'date_himp1' => $tgl[0],
                'date_himp2' => $tgl[1]
            );
        }
        
        if ($this->input->post('btncetak')) {
                $data['perBankJgtY'] = $this->Mrinci_slip->perBankJgtY($post['jungut']);
                $data['perBankJgtT'] = $this->Mrinci_slip->perBankJgtT($post['jungut']);
                $data['petugas'] = $this->Mrinci_slip->getPtgs();
                // print_r($data['perBankJgtY']);
                $this->load->view('rekap_rinci_bank', $data);
        } else {
            $data['perBankJgtY'] = $this->Mrinci_slip->perBankJgtY($post['jungut']);
            $data['perBankJgtT'] = $this->Mrinci_slip->perBankJgtT($post['jungut']);
            $data['petugas'] = $this->Mrinci_slip->getPtgs();

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

            $sheet->setCellValue('A4','No')
            ->getStyle('A4')->getAlignment()->setVertical('center')->setWrapText(true);
            ;
            $sheet->setCellValue('B4','Entry Pegawai')
            ->getStyle('B4')->getAlignment()->setVertical('center')->setWrapText(true);
            ;
            $sheet->setCellValue('C4','Noslip')
            ->mergeCells('C4:D4');
            $sheet->setCellValue('E4','Nama Bank')
            ->mergeCells('E4:F4');
            $sheet->setCellValue('G4','Nomer Rekening')
            ->mergeCells('G4:H4');
            $sheet->setCellValue('I4','Jumlah');
            $sheet->setCellValue('J4','Infaq');
            $sheet->setCellValue('K4','Pena');
            $sheet->setCellValue('L4','Zakat');
            $sheet->setCellValue('M4','RCY');
            $sheet->setCellValue('N4','CGQ');
            $sheet->setCellValue('O4','Lain-lain');
            
            $row= 5;
            foreach($data['perBankJgtT'] as $no => $tidak){
            $sheet->setCellValue('A'.$row,$no+1);
            $sheet->setCellValue('B'.$row,$tidak->entr_pegawai);
            $sheet->setCellValue('C'.$row,$tidak->noslip)
            ->mergeCells('C'.$row.':D'.$row);
            
            $sheet->setCellValue('E'.$row,$tidak->NM_BANK)
            ->mergeCells('E'.$row.':F'.$row);
            
            $sheet->setCellValue('G'.$row,$tidak->REC)
            ->mergeCells('G'.$row.':H'.$row);
            
            $sheet->setCellValue('I'.$row,number_format($tidak->total,0,'.',','));
            $sheet->setCellValue('J'.$row,number_format($tidak->infaq,0,'.',','));
            $sheet->setCellValue('K'.$row,number_format($tidak->pena,0,'.',','));
            $sheet->setCellValue('L'.$row,number_format($tidak->zakat,0,'.',','));
            $sheet->setCellValue('M'.$row,number_format($tidak->RCY,0,'.',','));
            $sheet->setCellValue('N'.$row,number_format($tidak->CGQ,0,'.',','));
            $sheet->setCellValue('O'.$row,number_format($tidak->dll,0,'.',','));
                $row++;
            }
            $rows = intval(count($data['perBankJgtT']));
            $row = $rows+5;
            $sheet->setCellValue('A'.$row,'BELUM TERVALIDASI')
            ->mergeCells('A'.$row.':O'.$row);
            $rows=count($data['perBankJgtT']);
            $row = intval($rows)+6;
            $sheet->setCellValue('A'.$row,'Total')
            ->mergeCells('A'.$row.':H'.$row);
            $tot=0;
            foreach($data['perBankJgtT'] as $belum){
                $tot +=$belum->total;
            }
            $sheet->setCellValue('I'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtT'] as $belum){
                $tot +=$belum->infaq;
            }
            $sheet->setCellValue('J'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtT'] as $belum){
                $tot +=$belum->pena;
            }
            $sheet->setCellValue('K'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtT'] as $belum){
                $tot +=$belum->zakat;
            }
            $sheet->setCellValue('L'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtT'] as $belum){
                $tot +=$belum->RCY;
            }
            $sheet->setCellValue('M'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtT'] as $belum){
                $tot +=$belum->CGQ;
            }
            $sheet->setCellValue('N'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtT'] as $belum){
                $tot +=$belum->dll;
            }
            $sheet->setCellValue('O'.$row,number_format($tot,0,'.',','));

            $row1=$row+1;
            $sheet->setCellValue('A'.$row1,'SUDAH TERVALIDASI')
            ->mergeCells('A'.$row1.':K'.$row1);
            $rows=count($data['perBankJgtT']);
            $row = intval($rows)+8;
            foreach($data['perBankJgtY'] as $no => $tidak){
            $sheet->setCellValue('A'.$row,$no+1);
            $sheet->setCellValue('B'.$row,$tidak->entr_pegawai);
            $sheet->setCellValue('C'.$row,$tidak->noslip)
            ->mergeCells('C'.$row.':D'.$row);
            $sheet->setCellValue('E'.$row,$tidak->NM_BANK)
            ->mergeCells('E'.$row.':F'.$row);
            $sheet->setCellValue('G'.$row,$tidak->REC)
            ->mergeCells('G'.$row.':H'.$row);
            $sheet->setCellValue('I'.$row,number_format($tidak->total,0,'.',','));
            $sheet->setCellValue('J'.$row,number_format($tidak->infaq,0,'.',','));
            $sheet->setCellValue('K'.$row,number_format($tidak->pena,0,'.',','));
            $sheet->setCellValue('L'.$row,number_format($tidak->zakat,0,'.',','));
            $sheet->setCellValue('M'.$row,number_format($tidak->RCY,0,'.',','));
            $sheet->setCellValue('N'.$row,number_format($tidak->CGQ,0,'.',','));
            $sheet->setCellValue('O'.$row,number_format($tidak->dll,0,'.',','));
                $row++;
                }
                $rows1 = intval(count($data['perBankJgtT']));
                $rows2 = intval(count($data['perBankJgtY']));
                $row = $rows1 + $rows2 + 8;
            $sheet->setCellValue('A'.$row,'Total')
            ->mergeCells('A'.$row.':H'.$row);
            $tot=0;
            foreach($data['perBankJgtY'] as $belum){
                $tot +=$belum->total;
            }
            $sheet->setCellValue('I'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtY'] as $belum){
                $tot +=$belum->infaq;
            }
            $sheet->setCellValue('J'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtY'] as $belum){
                $tot +=$belum->pena;
            }
            $sheet->setCellValue('K'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtY'] as $belum){
                $tot +=$belum->zakat;
            }
            $sheet->setCellValue('L'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtY'] as $belum){
                $tot +=$belum->RCY;
            }
            $sheet->setCellValue('M'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtY'] as $belum){
                $tot +=$belum->CGQ;
            }
            $sheet->setCellValue('N'.$row,number_format($tot,0,'.',','));
            $tot=0;
            foreach($data['perBankJgtY'] as $belum){
                $tot +=$belum->dll;
            }
            $sheet->setCellValue('O'.$row,number_format($tot,0,'.',','));
            $sheet->getStyle('A4:O'.$row)->applyFromArray($styleArray);

            $writer = new Xlsx($spreadsheet);
            $filename = 'rekap_rinci_slip_bank';
            
            // download file
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        }
    }

}

/* End of file Program.php */
