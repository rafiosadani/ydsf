'<!DOCTYPE html>
	<html style="margin: 0; padding: 0;">
	<head>
	<title>Report</title>
	</head>
	<body style="margin: 0; padding: 0; background: url(template_email_ydsf.jpeg); background-repeat: no-repeat ; background-size: cover; min-height:1400px; width: auto;">
	<div style="padding: 0 5%; padding-top: 15%; padding-bottom: 15%;height:auto; width: auto;">
	<table style="border-collapse: collapse; max-width: 1600px; width: auto; margin: auto auto;" cellpadding="3" cellspacing="2">
	<tbody>
	<tr>
		<td><b>No id</b></td>
		<td>: </td>
		<td id="data"><b>'.$fetch['noid'].'</b></td>
	</tr>
	<tr>
		<td><b>Nama</b></td>
		<td>: </td>
		<td id="data"><b>'.$fetch['nama'].'</b></td>
	</tr>
	<tr>
		<td><b>Alamat</b></td>
		<td>: </td>
		<td id="data"><b>'.$fetch['alamat'].'</b></td>
	</tr>
	<tr>
		<td><b>Tempat Lahir</b></td>
		<td>: </td>
		<td id="data"><b>'.$fetch['tmplahir'].'</b></td>
	</tr>
	<tr>
		<td><b>Tgl Lahir</b></td>
		<td>: </td>
		<td id="data"><b>'.date("d-m-Y", strtotime($fetch['tgllahir'])).'</b></td>
	</tr>
	<tr>
		<td><b>Jenis Kelamin</b></td>
		<td>: </td>
		<td id="data"><b>'.$jk[$fetch['sex']].'</b></td>
	</tr>
	<tr>
		<td><b>No Telepon</b></td>
		<td>: </td>
		<td id="data"><b>'.$fetch['tlphp'].'</b></td>
	</tr>
	<tr>
		<td><b>Alamat Kantor</b></td>
		<td>: </td>
		<td id="data"><b>'.$fetch['almktr'].'</b></td>
	</tr>
	<tr>
		<td><b>Email</b></td>
		<td>: </td>
		<td id="data"><b>'.$fetch['email'].'</b></td>
	</tr>
	</tbody>
	</table>
	</div>
	<!-- <hr> -->
	<div style="width: 94.5%; height: auto; padding-top:0% ; margin-left: 23%">
	<table border="1" cellspacing="3" cellpadding="5" style=" border-collapse: collapse; width: 50%; max-width: 700px; min-width: 50%; margin: auto auto; min-height: 100% !important; text-align: center;">
	<thead>
	<tr>
		<th class="th">No Reff</th>
		<th class="th">Tanggal</th>
		<th class="th">Program</th>
		<th class="th">Jumlah</th>

	</tr>
	</thead>
	<tbody id="tbody">';
	foreach ($result as $key => $value) {
		$mailContent .= 
		'<tr>
		<td class="td">'.$value['report_id'].'</td>
		<td class="td">'.date("d-m-Y", strtotime(substr($value['tanggal'], 0,10))).'</td>
		<td class="td">'.$value['NM_PROGRAM'].'</td>
		<td class="td">'.'Rp ' . number_format($value['jumlah'], '2', ',', '.').'</td>

		</tr>';
	}
	$mailContent .=	
	'</tbody>
	</table>
	</div>
	<div style="width: 94.5%; height: auto; top: 50% ; margin-left: 47%">
	<h2>TOTAL : '.'Rp ' . number_format($jumlah['total'], '2', ',', '.').'</h2>
	</div>
	</body>
	</html>'