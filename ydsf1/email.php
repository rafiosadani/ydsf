<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        console.log(sessionStorage.getItem('status'));
        if (sessionStorage.getItem('status') == null || sessionStorage.getItem('status') == '') {window.location = "<?php echo $site_url ?>";}else{}
    </script>
<?php
require 'config.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Mpdf\Mpdf; //src->class()
require __DIR__.'/vendor/autoload.php';



$array = explode(',', $_REQUEST['id']);
foreach ($array as $key => $value) {
	//get Data
    $report = $connection->prepare("SELECT * FROM config_report limit 1");
        $report->execute();
            $report_fetch = $report->fetch(PDO::FETCH_ASSOC);
            $periode = explode('~', $report_fetch['periode']);
	$stmt = $connection->prepare("SELECT nama,alamat,noid,email FROM donatur WHERE noid = ?");
		$stmt->execute([$value]);
			$fetch = $stmt->fetch(PDO::FETCH_ASSOC);
	$query = $connection->prepare("SELECT report_id,tanggal,jumlah,program.NM_PROGRAM FROM history_tagihan INNER JOIN program ON program.PROG = history_tagihan.prog WHERE noid = ? and date(tanggal) >= ? and date(tanggal) <= ? order by tanggal");
		$query->execute([$value,$periode[0].'%',$periode[1].'%']);
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
	$total = $connection->prepare("SELECT SUM(jumlah) AS total FROM history_tagihan WHERE noid = ? and date(tanggal) >= ? and date(tanggal) <= ? order by tanggal");
		$total->execute([$value,$periode[0].'%',$periode[1].'%']);
			$jumlah = $total->fetch(PDO::FETCH_ASSOC);
	// echo $base_url.'img/'.$report_fetch['image_page1'];
	// pdf
	$html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>PDF</title>
        <style>
            .table{
                font-size: 0.5em;
            }
            .paragraf{
                font-size: 0.3em;
                margin-left: 5px;
            }
            table, th, td {
                border: 0.3px solid black;
            }
        </style>
    </head>
    
    <body>
    <div style="background-image: url(';$html .='img/'.$report_fetch['image_page1']; $html .= ');
            background-repeat: no-repeat;background-size: cover;height: 1280px;width: 905px;">
            <div style="font-size: 0.8em;padding-top: 20%;padding-left: 10%">
                <p class="coba">Yth Bpk/Ibu '.$fetch['nama'].' </p>
                <p>'.$fetch['noid'].'</p>
                <p>'.$fetch['alamat'].'</p>
            </div>
        <div style="padding-right: 12%;margin-top: 19.3%;float: right;width: 300px;">
            <table  cellspacing="0" cellpadding="4" align="right" width = "90%">
                <tr>
                    <th class="table">No Reff</th>
                    <th class="table">Tanggal</th>
                    <th class="table">Program</th>
                    <th class="table">Jumlah</th>
                </tr>';
                foreach ($result as $key => $value) {
                $html .= 
                '<tr>
                    <td class="table">'.$value['report_id'].'</td>
                    <td class="table">'.date("d-m-Y", strtotime(substr($value['tanggal'], 0,10))).'</td>
                    <td class="table">'.$value['NM_PROGRAM'].'</td>
                    <td class="table">'.'Rp ' . number_format($value['jumlah'], '2', ',', '.').'</td>
                </tr>';
                } $html .= '<tr>
                    <td class="table" colspan="4" border="none">Total : '.'Rp ' . number_format($jumlah['total'], '2', ',', '.').'</td>
                </tr>
            </table>
        </div>
        <div style="float: right;width: 238px;margin-right: 20px;">
            <img src="img/'.$report_fetch['small_image'].'" alt="YDSF" width="65px" height="100px" style="float:left;">
            <p style="height:550px; overflow:hidden;font-size:x-small;" class="paragraf">'.$report_fetch['artikel'].'</p>
        </div>
    </div>
    </body>
    </html>';
    $html2 = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ydsf2</title>
    </head>
    <body>
        <div style="background-image: url(';$html2 .='img/'.$report_fetch['image_page2']; $html2 .= ');
            background-repeat: no-repeat;background-size: cover;height: 1280px;width: 905px;">
        </div>
    </body>
    </html>';
	//mail body
	$mailContent = 
			'<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>YDSF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="Framework/bootstrap.min.css">
    <style>
        .table {
            font-size: 1em;
        }
    </style>
</head>

<body style="font-size:medium">
    <h4>Laporan Hasil Donasi atas nama Bpk/Ibu '.$fetch['nama'].'</h4>
    <section style="width: 905px;background-repeat: no-repeat;background-size: cover">
        <div style="padding-left: 10%;font-size: 0.8em;">
            <p class="coba">Yth Bpk/Ibu '.$fetch['nama'].' </p>
			<p>'.$fetch['noid'].'</p>
			<p>'.$fetch['alamat'].'</p>
        </div>
        <div style="padding-right: 3.4%;;width: 455px;float: right;">';
            // <table border="1" cellspacing="0" cellpadding="5" align="right" width="100%">
            //     <tr>
            //         <th class="table">No Reff</th>
            //         <th class="table">Tanggal</th>
            //         <th class="table">Program</th>
            //         <th class="table">Jumlah</th>
            //     </tr>';
    //             foreach ($result as $key => $value) {
				// $mailContent .= 
				// '<tr>
				// 	<td class="table">'.$value['report_id'].'</td>
				// 	<td class="table">'.date("d-m-Y", strtotime(substr($value['tanggal'], 0,10))).'</td>
				// 	<td class="table">'.$value['NM_PROGRAM'].'</td>
				// 	<td class="table">'.'Rp ' . number_format($value['jumlah'], '2', ',', '.').'</td>

				// </tr>';
				// } 
                $mailContent .=
                // '<tr>
                //     <td class="table" colspan="4" border="none">Total : '.'Rp ' . number_format($jumlah['total'], '2', ',', '.').'</td>
                // </tr>
            // </table>
        '</div>
        <div style="float: left;margin-top:5%;margin-left: 20px;">
            <p class="table">'.$report_fetch['sambutan'].'</p>
        </div>
    </section>
    <script src="Framework/bootstrap.min.js"></script>
    <script src="Framework/popper.min.js"></script>
</body>

</html>';
			
	try {
		//config pdf
		$mpdf = new Mpdf();
		$mpdf->WriteHTML($html);
		$mpdf->addPage();
		$mpdf->WriteHtml($html2);
		// config mailer
		$mail = new PHPMailer(true);
		$mail->isSMTP();
		$mail->Host = 'mail.ydsf.org';
		$mail->SMTPAuth = true;
		$mail->Username = 'laporan@ydsf.org'; //email
		$mail->Password = 'laporanydsf45'; //password email
		$mail->SMTPSecure = 'tls';
		$mail->Port = 25;
		$mail->addStringAttachment($mpdf->Output('report.pdf', 'S'), 'report.pdf');
		$mail->setFrom('data@ydsf.org', 'YDSF'); //email
		$mail->addAddress('adjim80@gmail.com');
		$mail->Subject = 'Laporan Donasi';
		$mail->isHTML(true);
		// $mail->AddEmbeddedImage(dirname(__FILE__) . '/img/'.$report_fetch['image_page1'], 'ydsf');
		// $mail->AddEmbeddedImage(dirname(__FILE__) . "/img/".$report_fetch['small_image'], 'foto_dir');
		$mail->Body = $mailContent;
		$mail->send();
		echo 'Message has been sent';
        $die = $base_url.'index.php';
        header("Location: index.php?status=success_email");
        die();
	} catch (Exception $e) {
	// echo $e->errorMessage;
		echo 'Message could not be sent.';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	    echo "Sorry your message don't send";
        header("Location : index.php?status=failed");
	}
    // echo $html;

}
?>