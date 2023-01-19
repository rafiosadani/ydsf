<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>YDSF | Himpunan</title>
	<style>
		table thead th {
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
	<div class="dashboard" id="dashboard">
		<div class="row">
	        <div class="col-md-12">
              	<div class="box-header with-border">
               		<div class="container">
               			<h1 class="box-title" style="font-size: 32px; margin-top: 11px; margin-bottom: 11px;"><b>Laporan Harian</b></h1>
               		</div>
                </div>
              	<div class="box-body" style="height:auto; font-size: 17px;" id="kotak">
              		<div class="col-md-6" id="bungkus">
						<table class="table table-bordered" id="mainTable">
							<thead>
								<tr align="center">
									<th class="col" style="text-align: center;">No</th>
									<th class="col" style="text-align: center;">Nama</th>
									<th class="col" style="text-align: center;">Target</th>
									<th class="col" style="text-align: center;">Perolehan</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; ?>
							<?php foreach($laporanHarian as $tampil) : ?>
							<tr> 
								<td align="center"><?= $i++; ?></td>
								<td><?= $tampil->Nama; ?></td>
								<td align="center"><?= number_format($tampil->Target,0,',',','); ?></td>
								<td align="center"><?= number_format($tampil->Hasil,0,',',','); ?></td>
							</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
              		</div> 	
	        	</div>
	    	</div>
		</div>
	</div>
<script type="text/javascript">
$(document).ready(function() {
    var $mainTable = $("#mainTable");
    var rowTable = document.getElementById('mainTable').getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
    var splitBy = 16;
    var rows = $mainTable.find("tr").slice(splitBy);

    if (rowTable < splitBy) {
		$('#bungkus').removeClass('col-md-6');
		$('#bungkus').toggleClass('col-md-12');
	} else {
		var $secondTable = $("#kotak").append('<div class="col-md-6" id="batas2"><table class="table table-bordered" id="secondTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Target</th><th class="col" style="text-align: center;">Perolehan</th></tr></thead><tbody></tbody></table></div>');
		$secondTable.find("tbody").append(rows);
		$mainTable.find("tr").slice(splitBy).remove();
	}
    refresh();
});

function refresh()
{
    setTimeout(function()
    {
        $('#dashboard').load('<?php echo base_url('page/display_lot_table5');?>');
        // refresh();
    }, 30000);
}
</script>
</body>
</html>