<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH. 'third_party/escpos-php-development/autoload.php';
 use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
 use Mike42\Escpos\Printer;       
class Printthermal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('mlogin');
        
	
    }

    public function index() {
    echo "hello";
    $connector = new CupsPrintConnector("STMicroelectronics_USB_Portable_Printer");
$printer = new Printer($connector);
$printer -> text("Hello World!\n");
$printer -> cut();
$printer -> close();

    /*$rn=chr(13).chr(10);
$esc=chr(27);
$cutpaper=$esc."m";
$bold_on=$esc."E1";
$bold_off=$esc."E0";
$reset=pack('n', 0x1B30);

 
//printer setup
$printer="/dev/usb/lp0";


//formating data text:
$string = "--test EAN-13 barcode wide--\n";
$string .= "\x1d\x77\x04";   # GS w 4
$string .= "\x1d\x6b\x02";   # GS k 2 
$string .= "5901234123457\x00";  # [data] 00
$string .= "-end-\n";

//cut paper at end
//$string.=$cutpaper;


//send data to USB printer
$fp=fopen($printer, 'w');
fwrite($fp,$string);
fclose($fp);


        //if ($this->session->userdata('login') == TRUE) {
          //  redirect(base_url('dashboard'));
        //}
        //$this->load->view('login');*/
    }

    

}
