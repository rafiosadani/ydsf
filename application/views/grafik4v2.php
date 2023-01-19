<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>YDSF | Himpunan</title>
	<style>
		.messagewindow {    
			overflow: auto;
			position: relative;
			height: 100vh;
			width: 100%; 
		}

		table thead th {
			background-color: #508abb;
			color: #FFFFFF;
		}

		.khusus {
			background-color: #508abb;
			color: #FFFFFF;
		}

		table tbody tr:nth-child(even) td {
			background-color: #fbfde0;
		}

		table tbody tr:nth-child(odd) td {
			background-color: #e6f6ff;
		}
	</style>
</head>
<body>
	<div class="messagewindow" id="messagewindow">
		<div class="dashboard" id="dashboard">
			<div class="row">
		        <div class="col-md-12">
	              	<div class="box-header with-border">
	               		<div class="container">
	               			<h1 class="box-title" style="font-size: 32px; margin-top: 11px; margin-bottom: 11px;"><b>Donatur Masuk dan Keluar dalam Setahun</b></h1>
	               		</div>
	              	</div>
	              	<div class="box-body" style="height:auto; font-size: 20px;" id="kotak">
	              		<div class="col-md-12">
						<table class="table table-bordered">
							<thead>
							<tr align="center">
								<th class="col" rowspan="2" style="line-height: 72px; text-align: center;">No</th>
								<th class="col" rowspan="2" style="line-height: 72px; text-align: center;">Nama</th>
								<th class="col" colspan="2" align="center" style="text-align: center;">Masuk</th>
								<th class="col" colspan="2" style="text-align: center;">Keluar</th>
								<th class="col" colspan="2" style="text-align: center;">+/-</th>
							</tr>
							<tr>
								<td align="center" class="khusus"><b>Donatur</b></td>
								<td align="center" class="khusus"><b>Donasi</b></td>
								<td align="center" class="khusus"><b>Donatur</b></td>
								<td align="center" class="khusus"><b>Donasi</b></td>
								<td align="center" class="khusus"><b>Donatur</b></td>
								<td align="center" class="khusus"><b>Donasi</b></td>
							</tr>
							</thead>
							<tbody>
							<?php $no = 1; ?>
							<?php foreach($masukKeluar as $tampil) : ?>
							<tr>
								<td align="center"><?= $no++; ?></td>
								<td><?= $tampil->Nama; ?></td>
								<td align="center"><?= $tampil->jmldnt_br; ?></td>
								<td align="center"><?= number_format($tampil->jmldns_br,0,',',','); ?></td>
								<td align="center"><?= $tampil->jmldnt_klr; ?></td>
								<td align="center"><?= number_format($tampil->jmldns_klr,0,',',','); ?></td>
								<td align="center"><?= $tampil->jmldnt_br - $tampil->jmldnt_klr; ?></td>
								<td align="center"><?= number_format(($tampil->jmldns_br - $tampil->jmldns_klr),0,',',','); ?></td>
							</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
	              	</div> 	
	            </div>
		    </div>
		</div>
	</div>
<script>
$(document).ready(function()
{
	$('#messagewindow').animate({
        scrollTop: $('#messagewindow')[0].scrollHeight
    }, 15000);

    $('#messagewindow').animate({
    	scrollTop:0
    }, 12500);

    refresh();
});

function refresh()
{
    setTimeout(function()
    {
        $('#dashboard').load('<?php echo base_url('page/display_lot_table4');?>');
        // refresh();
    }, 30000);
}
</script>
</body>
</html>