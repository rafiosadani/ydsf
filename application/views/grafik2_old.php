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
               			<h1 class="box-title" style="font-size: 32px; margin-top: 11px; margin-bottom: 11px;"><b>Presentase Harian</b></h1>
               		</div>
                </div>
              	<div class="box-body" style="height:auto; font-size: 17px;" id="kotak">
              		<div class="col-md-6" id="bungkus">
						<table class="table table-bordered" id="mainTable">
							<thead>
								<tr align="center">
									<th class="col" style="text-align: center;">No</th>
									<th class="col" style="text-align: center;">Nama</th>
									<th class="col" style="text-align: center;">Presentase (%)</th>
								</tr>
							</thead>
							<tbody>
							<?php $i = 1; ?>
							<?php foreach($presJungut as $tampil) : ?>
							<tr> 
								<td align="center"><?= $i++; ?></td>
								<td><?= $tampil->Nama; ?></td>
								<td align="center"><?= round(100*($tampil->Hasil/$tampil->Target),2)."%" ?></td>
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
    var splitBy = 19;
    var rows = $mainTable.find("tr").slice(splitBy);

    if(rowTable > 72) {
    	$('#bungkus').removeClass('col-md-6');
		$('#bungkus').toggleClass('col-md-3');

		$('#kotak').css('font-size', '12px');

		var splitBy2 = Math.ceil(rowTable / 4);
		var rows1 = $mainTable.find("tr").slice(splitBy2);

 		var $secondTable = $("#kotak").append('<div class="col-md-3" id="batas2"><table class="table table-bordered" id="secondTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $secondTable.find("tbody").append(rows1);
	    $mainTable.find("tr").slice(splitBy2).remove();

	    var secondTable = $('#secondTable');
	    var rows2 = secondTable.find("tr").slice(splitBy2);
	    var $treeTable = $("#kotak").append('<div class="col-md-3"><table class="table table-bordered" id="treeTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $treeTable.find("tbody").append(rows2);
	    secondTable.find("tr").slice(splitBy2).remove();
	    $mainTable.find("tr").slice(splitBy2).remove();

	    var treeTable = $('#treeTable');
	    var rows3 = treeTable.find("tr").slice(splitBy2);
	    var $fourTable = $("#kotak").append('<div class="col-md-3"><table class="table table-bordered" id="fourTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $fourTable.find("tbody").append(rows3);
	    $mainTable.find("tr").slice(splitBy2).remove();
	    secondTable.find("tr").slice(splitBy2).remove();
	    treeTable.find("tr").slice(splitBy2).remove();

    } else if(rowTable > 54) { 
 		$('#bungkus').removeClass('col-md-6');
		$('#bungkus').toggleClass('col-md-3');

		$('#kotak').css('font-size', '12px');

 		var $secondTable = $("#kotak").append('<div class="col-md-3" id="batas2"><table class="table table-bordered" id="secondTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $secondTable.find("tbody").append(rows);
	    $mainTable.find("tr").slice(splitBy).remove();

	    var secondTable = $('#secondTable');
	    var rows2 = secondTable.find("tr").slice(splitBy);
	    var $treeTable = $("#kotak").append('<div class="col-md-3"><table class="table table-bordered" id="treeTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $treeTable.find("tbody").append(rows2);
	    secondTable.find("tr").slice(splitBy).remove();
	    $mainTable.find("tr").slice(splitBy).remove();

	    var treeTable = $('#treeTable');
	    var rows3 = treeTable.find("tr").slice(splitBy);
	    var $fourTable = $("#kotak").append('<div class="col-md-3"><table class="table table-bordered" id="fourTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $fourTable.find("tbody").append(rows3);
	    $mainTable.find("tr").slice(splitBy).remove();
	    secondTable.find("tr").slice(splitBy).remove();
	    treeTable.find("tr").slice(splitBy).remove();

 	}else if(rowTable > 36) {
 		$('#bungkus').removeClass('col-md-6');
		$('#bungkus').toggleClass('col-md-4');

		$('#kotak').css('font-size', '13px');

 		var $secondTable = $("#kotak").append('<div class="col-md-4" id="batas2"><table class="table table-bordered" id="secondTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $secondTable.find("tbody").append(rows);
	    $mainTable.find("tr").slice(splitBy).remove();

	    var secondTable = $('#secondTable');
	    var rows2 = secondTable.find("tr").slice(splitBy);
	    var $treeTable = $("#kotak").append('<div class="col-md-4" id="batas2"><table class="table table-bordered" id="treeTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $treeTable.find("tbody").append(rows2);
	    // secondTable.find("tr").slice(splitBy).remove();
	    secondTable.find("tr").slice(splitBy).remove();
	    $mainTable.find("tr").slice(splitBy).remove();

 	} else if(rowTable > splitBy) {
 		$('#kotak').css('font-size', '13px');
		var $secondTable = $("#kotak").append('<div class="col-md-6" id="batas2"><table class="table table-bordered" id="secondTable"><thead><tr align="center"><th class="col" style="text-align: center;">No</th><th class="col" style="text-align: center;">Nama</th><th class="col" style="text-align: center;">Presentase (%)</th></tr></thead><tbody></tbody></table></div>');
	    $secondTable.find("tbody").append(rows);
	    $mainTable.find("tr").slice(splitBy).remove();
	    
	} else {
		$('#bungkus').removeClass('col-md-6');
		$('#bungkus').toggleClass('col-md-12');
	}
    refresh();
});

function refresh()
{
    setTimeout(function()
    {
        $('#dashboard').load('<?php echo base_url('page/display_lot_table2');?>');
        // refresh();
    }, 30000);
}
</script>
</body>
</html>