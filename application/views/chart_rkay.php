<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini" style="padding-top:10px">
<?php
$bulan = array(
	0 => [
		"id" => 1,
    "bulan" => "Januari",
    "nick" => "Jan"
	],
	1 => [
		"id" => 2,
    "bulan" => "Februari",
    "nick" => "Feb"
	],
	2 => [
		"id" => 3,
    "bulan" => "Maret",
    "nick" => "Mar"
	],
	3 => [
		"id" => 4,
    "bulan" => "April",
    "nick" => "Apr"
	],
	4 => [
		"id" => 5,
    "bulan" => "Mei",
    "nick" => "Mei"
	],
	5 => [
		"id" => 6,
    "bulan" => "Juni",
    "nick" => "Jun"
	],
	6 => [
		"id" => 7,
    "bulan" => "Juli",
    "nick" => "Jul"
	],
	7 => [
		"id" => 8,
    "bulan" => "Agustus",
    "nick" => "Agt"
	],
	8 => [
		"id" => 9,
    "bulan" => "September",
    "nick" => "Sep"
	],
	9 => [
		"id" => 10,
    "bulan" => "Oktober",
    "nick" => "Okt"
	],
	10 => [
		"id" => 11,
    "bulan" => "November",
    "nick" => "Nov"
	],
	11 => [
		"id" => 12,
    "bulan" => "Desember",
    "nick" => "Des"
	],
);
$bln = "";
for ($a = 0;$a < count($bulan);$a++) {
	if ($bulan[$a]['id'] == $this->input->post('bulan')) {
		$bln = $bulan[$a]['nick'];
	}
}
?>
<div class="container">
  <div class="row">

    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-body" style="height:450px">
          <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-body" style="height:450px">
          <div id="perbandingan" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
      </div>
    </div>

  </div>
  <div class="row">

    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-body" style="height:450px">
          <div id="kumulatif" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-body" style="height:450px">
          <div id="bulan-ini" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
      </div>
    </div>

  </div>
</div>
</body>
<?php $this->load->view('partials/js') ?>
<script>
// Berdasarkan Donasi Donatur

Highcharts.setOptions({
  lang: {
    thousandsSep: ','
  }
});

Highcharts.chart('container', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Persentase Perolehan 2019 Jan sd <?php echo $bln ?>'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b> : <br>{point.y:,.0f} ({point.percentage:.1f} %)',
        style: {
          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        }
      }
    }
  },
  exporting: {
    buttons: {
      contextButton: {
        menuItems: [{
          textKey: 'downloadPNG',
          onclick: function () {
              this.exportChart();
          }
        }, {
          textKey: 'downloadJPEG',
          onclick: function () {
            this.exportChart({
                type: 'image/jpeg'
            });
          }
        }, {
          textKey: 'downloadPDF',
          onclick: function () {
            this.exportChart({
                type: 'pdf'
            });
          }
        }]
      }
    }
  },
  series: [{
    name: 'rata2',
    colorByPoint: true,
    data: [
		<?php foreach($chartoleh as $data) { ?>
			{
        name: '<?php echo $data->rkay_2 ?>',
        y: <?php echo $data->total ?>,
			},
		<?php } ?>
	]
  }]
});

Highcharts.chart('perbandingan', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'Perbandingan Perolehan Jan sd <?php echo $bln ?>'
  },
  xAxis: {
    categories: [
      'data'
    ],
    crosshair: true
  },
  tooltip: {
    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
      '<td style="padding:0"><b>{point.y:,.0f}</b></td></tr>',
    footerFormat: '</table>',
    shared: true,
    useHTML: true
  },
  exporting: {
    buttons: {
      contextButton: {
        menuItems: [{
          textKey: 'downloadPNG',
          onclick: function () {
              this.exportChart();
          }
        }, {
          textKey: 'downloadJPEG',
          onclick: function () {
            this.exportChart({
                type: 'image/jpeg'
            });
          }
        }, {
          textKey: 'downloadPDF',
          onclick: function () {
            this.exportChart({
                type: 'pdf'
            });
          }
        }]
      }
    }
  },
  plotOptions: {
	series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: '{point.y:,.0f}'
      }
    },
    column: {
      pointPadding: 0.2,
      borderWidth: 0
    }
  },
  series: [
		{
      name: 'Rkay2019(a)',
      data: [<?php foreach($chartbanding as $value) { echo $value->rkay2019; } ?>]
  },
  {
      name: 'Perolehan2019(b)',
      data: [<?php foreach($chartbanding as $value) { echo $value->perolehan2019; } ?>]
  },
  {
      name: 'Perolehan2018(c)',
      data: [<?php foreach($chartbanding as $value) { echo $value->perolehan2018; } ?>]
  }
  ]
});

Highcharts.chart('kumulatif', {

title: {
  text: 'Grafik Kumulatif pebandingan perolehan dan rkay'
},

xAxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
      'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },

yAxis: {
  title: {
    text: 'Values'
  }
},
legend: {
  layout: 'vertical',
  align: 'right',
  verticalAlign: 'middle'
},
exporting: {
    buttons: {
      contextButton: {
        menuItems: [{
          textKey: 'downloadPNG',
          onclick: function () {
              this.exportChart();
          }
        }, {
          textKey: 'downloadJPEG',
          onclick: function () {
            this.exportChart({
                type: 'image/jpeg'
            });
          }
        }, {
          textKey: 'downloadPDF',
          onclick: function () {
            this.exportChart({
                type: 'pdf'
            });
          }
        }]
      }
    }
  },

series: [{
  name: 'Rkay2019',
  data: [
    <?php 
      foreach ($kumulatif as $value) {
        echo $value['rkay2019'].",";
      }
    ?>
  ]
}, {
  name: 'Perolehan2019',
  data: [
    <?php 
      foreach ($kumulatif as $value) {
        echo $value['per2019'].",";
      }
    ?>
  ]
}, {
  name: 'Perolehan2018',
  data: [
    <?php 
      foreach ($kumulatif as $value) {
        echo $value['per2018'].",";
      }
    ?>
  ]
}],

responsive: {
  rules: [{
    condition: {
      maxWidth: 500
    },
    chartOptions: {
      legend: {
        layout: 'horizontal',
        align: 'center',
        verticalAlign: 'bottom'
      }
    }
  }]
}

});

Highcharts.chart('bulan-ini', {
  chart: {
    plotBackgroundColor: null,
    plotBorderWidth: null,
    plotShadow: false,
    type: 'pie'
  },
  title: {
    text: 'Persentase Perolehan 2019 Bulan <?php echo $bln ?>'
  },
  tooltip: {
    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  plotOptions: {
    pie: {
      allowPointSelect: true,
      cursor: 'pointer',
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b> : <br>{point.y:,.0f} ({point.percentage:.1f} %)',
        style: {
          color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        }
      }
    }
  },
  exporting: {
    buttons: {
      contextButton: {
        menuItems: [{
          textKey: 'downloadPNG',
          onclick: function () {
              this.exportChart();
          }
        }, {
          textKey: 'downloadJPEG',
          onclick: function () {
            this.exportChart({
                type: 'image/jpeg'
            });
          }
        }, {
          textKey: 'downloadPDF',
          onclick: function () {
            this.exportChart({
                type: 'pdf'
            });
          }
        }]
      }
    }
  },
  series: [{
    name: 'rata2',
    colorByPoint: true,
    data: [
			<?php foreach($thismonth as $data) { ?>
        {
          name: '<?php echo $data->rkay_2 ?>',
          y: <?php echo $data->total ?>,
        },
      <?php } ?>
	]
  }]
});
</script>

</html>