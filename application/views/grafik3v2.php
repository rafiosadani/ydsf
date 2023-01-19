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

		table tbody tr:nth-child(even) td {
			background-color: #fbfde0;
		}

		table tbody tr:nth-child(odd) td {
			background-color: #e6f6ff;
		}
	</style>
</head>
<body>
	<div id="messagewindow" class="messagewindow">
		<div class="dashboard" id="dashboard">
			<div class="row">
		        <div class="col-md-12">
	              	<div class="box-header with-border">
	               		<div class="container">
	               			<h1 class="box-title" style="font-size: 32px; margin-top: 11px; margin-bottom: 11px;"><b>Presentase Jungut Setahun</b></h1>
	               		</div>
	              	</div>
	              	<div class="box-body" style="height: auto; font-size: 16px;">
	              		<div class="col-md-6">
							<table class="table table-bordered">
								<thead>
									<tr align="center">
										<th class="col" style="text-align: center; line-height: 45px;">No</th>
										<th class="col" style="text-align: center; line-height: 45px;">Nama</th>
										<th class="col" style="text-align: center;">Presentase Donatur</th>
										<th class="col" style="text-align: center;">Presentase Donasi</th>
										<th class="col" style="text-align: center;">Rata - Rata(%)</th>
									</tr>
								</thead>
								<tbody>
									<?php $no = 1; ?>
									<?php foreach($jgtSetahun as $tampil) : ?>
									<tr>
										<td style="text-align: center;"><?= $no++; ?></td>
										<td><?= $tampil->Nama; ?></td>
										<td style="text-align: center;"><?php echo round((100*$tampil->persen_dnt),2) ."%" ?></td>
										<td style="text-align: center;"><?php echo round((100*$tampil->persen_dns),2) . "%" ?></td>
										<td style="text-align: center;"><?php echo round((100*$tampil->persen_rata2),2) ."%"; ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
	              		</div> 	
						
						<div class="col-md-6">
							<?php if($this->session->userdata('idcab') == 0) : ?>
							<div id="jungutsetahun" style="min-width: 310px; max-width: 1200px; height: 1350px; margin: 0 auto"></div>
							<?php else : ?>
							<div id="jungutsetahun" style="min-width: 310px; max-width: 1200px; height: 950px; margin: 0 auto"></div>
							<?php endif; ?>
				    		<script src="https://code.highcharts.com/highcharts.js"></script>
							<script src="https://code.highcharts.com/modules/exporting.js"></script>
							<script src="https://code.highcharts.com/modules/export-data.js"></script>

							<script>
								Highcharts.chart('jungutsetahun', {
							    chart: {
							        type: 'bar',
							    },
							    title: {
							        text: '',
							        color: 'black'
							    },
							    subtitle: {
							        text: '',
							        color: 'black'
							    },
							    xAxis: {
							        categories: [<?php foreach($grafikJungutSetahun as $value) { echo "'".$value->Nama ."',"; } ?>],
							        labels: {
						                style: {
						                    color: 'black',
						                    fontWeight: 'bold',
						                    fontSize:'12px'
						                }
						            },
							        title: {
							            text: 'DAFTAR JUNGUT'
							        }
							    },
							    yAxis: {
							        title: {
							            text: 'PERSEN (%)',
							        },
							        labels: {
							            style: {
							            	align: 'center',
							            	fontSize: '14px',
							            	fontWeight: 'bold',
							            	color: 'black'	
							            }
							        }
							    },
							    tooltip: {
							    	pointFormat: 'Rata-Rata : <b>{point.y:.1f}</b> Persen (%)',
							    },
							    plotOptions: {
							        series: {
							            pointWidth: 16,
							            borderWidth: 5,
							            dataLabels: {
							                enabled: true,
							                format: '{point.y}%'
							            }
							        },
							    },
							    legend: {
							        itemStyle: {
								      fontSize: '14px',
								      color: 'black'
								    },
								    itemHoverStyle: {
								      color: '#039'
								    },
								    itemHiddenStyle: {
								      color: 'gray'
								    }
							    },
							    credits: {
							        enabled: false
							    },
							    series: [
								    {
								        name: 'Rata - Rata (%)',
								        colorByPoint: true,
								        data: [<?php foreach($grafikJungutSetahun as $value) { echo round((100*$value->RataRata),2) .","; } ?>],						        
							    	},
							    ]
							});
							</script>
			    		</div>
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
 //    setTimeout(function() {
 //    	$('#messagewindow').animate({
 //    		scrollTop:0
 //    	}, 15000); 
	// },15000); 

    refresh();
});

function refresh()
{
    setTimeout(function()
    {
        $('#dashboard').load('<?php echo base_url('page/display_lot_table3');?>');
    }, 30000);
}
</script>
</body>
</html>