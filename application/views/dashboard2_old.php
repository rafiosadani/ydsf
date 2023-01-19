<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>YDSF | Himpunan</title>
  <?php $this->load->view('partials/head'); ?>
</head>
<body>
<div class="dashboard" id="dashboard">
	<div class="row">
		<div class="col-md-12">
			<div class="box-header with-border">
				<div class="container">
           			<h1 class="box-title" style="font-size: 32px; margin-top: 11px; margin-bottom: 11px;">
           				<b>
           					<?php if($this->session->userdata('idcab') == 0) : ?>
           					Grafik Presentase Harian YDSF
           					<?php else : ?>
           					Grafik Presentase Harian YDSF <?php foreach($cabang as $value) {echo ucwords(strtolower($value->Cabang));} ?>
           					<?php endif; ?>
           				</b>
           			</h1>
           		</div>
            </div>
            <div class="box-body with-border" style="height: auto; font-size: 25px;">
            	<script src="https://code.highcharts.com/highcharts.js"></script>
				<script src="https://code.highcharts.com/modules/exporting.js"></script>
				<script src="https://code.highcharts.com/modules/export-data.js"></script>

				<div id="presharian" style="min-width: 310px; height: 667px; margin: 0 auto"></div>
				
				<script>
					Highcharts.chart('presharian', {
				    chart: {
				        type: 'column',
				    },
				    title: {
				    	text: 'YSDF',
				    	style: {
				    		color:'white',
				    	},
				    	margin: 30,
				   //  	style: {
				   //  		fontWeight: 'bold',
						 //    fontSize: '30px'
					  //   },
				 		// <?php if($this->session->userdata('idcab') == 0) : ?>
				 		// 	text: 'YDSF',
				 		// <?php else : ?>
				 		// 	text: 'YDSF <?php foreach($cabang as $value) {echo $value->Cabang;} ?>',
				 		// <?php endif; ?>
				 	
				    },
				    xAxis: {
				        categories: [<?php foreach($targetJungut as $value) {echo "'".$value->Nama."',";} ?>],
				        crosshair: true,
					    labels: {
					      useHTML: true,
					      style: {
					        color: 'black',
					      }
					    }
				    },
				    yAxis: {
				        title: {
				            text: 'JUMLAH'
				        }
				    },
				    legend: {
				    	verticalAlign: 'top',
				    	align: 'center',
				    	floating: 'true',
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
				    tooltip: {
				        headerFormat: '<span style="font-size:12px; font-weight: bold;">{point.key}</span><table>',
				        pointFormat: '<tr><td style="color:{series.color};padding:0;"><span style="font-weight:bold;">{series.name} : </span></td>' +
				            '<td style="padding:0"><b> Rp. {point.y:,.0f}</b></td></tr>',
				        footerFormat: '</table>',
				        shared: true,
				        useHTML: true
				    },
				    plotOptions: {
				        column: {
				            pointPadding: 0.2,
				            borderWidth: 0
				        }
				    },
				    series: [
				    {
				        name: 'TARGET',
				        color: 'blue',
				        data: [<?php foreach($targetJungut as $tampil) {echo $tampil->Target.',';} ?>],
				    }, {
				        name: 'HASIL',
				        color: 'green',
				        data: [<?php foreach($targetJungut as $tampil) {if($tampil->Hasil == NULL || $tampil->Hasil == '') {echo 0 . ",";} else {echo $tampil->Hasil.',';} } ?>],
				    },
				    ]
				});
				</script>
            </div>
		</div>
	</div>
</div>
<?php $this->load->view('partials/js'); ?>
<script>
$(document).ready(function()
{
    refresh();
});

function refresh()
{
    setTimeout(function()
    {
        $('#dashboard').load('<?php echo base_url('page/display_lot_table');?>');
        // refresh();
    }, 30000);
}
</script>
</body>
</html>