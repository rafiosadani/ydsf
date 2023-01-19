<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('partials/head') ?>
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php $this->load->view('partials/header') ?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php $this->load->view('partials/sidebar') ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <form class="" action="" method="get">
      <?php if ($this->input->get('show')){ ?>

      <section class="content-header">
        <h1>
          Dashboard
          <small>Control panel</small>
          <span align="right">
            <button type="submit" name="hide" id="hide" class="btn-sm btn-primary" value=" "> Hide Dashboard <span class="fa fa-angle-double-up"></span></button>
            <button class="btn-sm btn-primary"><a href="<?= base_url('page/dashboard2'); ?>" target="_blank" style="color: white; font-size: 13px;">Show Dashboard 2</a> <span class="fa fa-angle-double-right"></span></button>
          </span>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      <p></p>
      </section>



      <!-- Main content -->
      <div class="dashboard" id="dashboard">
      <section class="content">
      <div class="row">
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php foreach($target as $target){

                $angka_format = number_format($target->Total,0,",",",");
                echo $angka_format;
              } ?></h3>

              <p>Target</p>
            </div>
            <div class="icon">
              <i class="fa fa-edit"></i>
            </div>
            <a href="<?php echo base_url('report') ?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php foreach($tertagih as $tertagih){
                 $angka_format = number_format($tertagih->Total,0,",",",");
               echo $angka_format;
              } ?></h3>

              <p>Tertagih</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url('report') ?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-4">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><?php foreach($keuangan as $keuangan){
                 $angka_format = number_format($keuangan->Total,0,",",",");
               echo $angka_format;
              } ?></h3>

              <p>Keuangan</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="<?php echo base_url('report') ?>" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
      </div>
      <!-- /.row -->

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
        <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Donatur Aktif Berdasarkan Usia</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <p class="right">Tidak Terdefinisi : <?php foreach($unknownAktifUmur as $un){
                if ($un->Total == '0') {
                  foreach ($unknownAktifUmurAllTime as $tampil) {
                    echo $tampil->Total;
                  }
                } else {
                  echo ($un->Total);
                }
              } ?> </p>
            </div>
            <div class="box-body" style="height:450px">
              <div class="" id="aktifUmur" style="min-height:400px;width:auto;position:relative; ">
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        <!-- /.row (main row) -->
        </div>
        <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Donatur Aktif Berdasarkan Jenis Kelamin</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
              <p class="right">Tidak Terdefinisi : <?php foreach($unknownAktifKelamin as $un){
                if ($un->Total == '0') {
                  foreach ($unknownAktifKelaminAllTime as $tampil) {
                    echo $tampil->Total;
                  }
                } else {
                  echo ($un->Total);
                }
              } ?> </p>
            </div>
            <div class="box-body" style="height:450px">
            <div class="" id="aktifKelamin" style="height:auto;width:auto;position:relative; ">
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        <!-- /.row (main row) -->
        </div>
        </div>

        <div class="row">
        <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Jumlah Donatur Aktif Yang Punya dan Tidak Punya No Telp</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" style="height:450px">
              <div class="" id="aktifTelp" style="height:auto;width:auto;position:relative; ">
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        <!-- /.row (main row) -->
        </div>
        <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
             <h3 class="box-title">Presensentasi Berdasarkan Donasi Donatur</h3>
             <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body" style="height:450px">
            <div class="" id="donasiChart" style="height:auto;width:auto;position:relative; ">
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        <!-- /.row (main row) -->
        </div>
        </div>
        </div>

      <?php }else {?>
        <section class="content-header">
            <h1>
              Dashboard
              <small>Control panel</small>
              <span align="right">
                <button type="submit" name="show" id="show" class="btn-sm btn-primary" value=" " style="font-size: 13px;"> Show Dashboard <span class="fa fa-angle-double-down"></span></button>
                <button class="btn-sm btn-primary"><a href="<?= base_url('page/dashboard2'); ?>" target="_blank" style="color: white; font-size: 13px;">Show Dashboard 2</a> <span class="fa fa-angle-double-right"></span></button>
              </span>
            </h1>
            <ol class="breadcrumb">
              <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
          <p></p>
        </section>
      </form>
    <?php } ?>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php $this->load->view('partials/footer') ?>


  </div>
  <!-- ./wrapper -->

  <?php $this->load->view('partials/modal') ?>

  <!-- <script>
    function deleteConfirm(url) {
      $('#btn-delete').attr('href', url);
      // $('#Delete').modal();
    }
  </script> -->
</body>
<?php $this->load->view('partials/js') ?>
<!-- <script>
  $(function () {
    $('#donatur').DataTable()
  })
</script> -->
<script>
// Donatur AKtif Umur
Highcharts.chart('aktifUmur', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y} - {point.percentage:.1f}%</b><br/>Total Infaq : <b>Rp. {point.y1:,.0f}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Donatur',
        colorByPoint: true,
        data: [{
        name: '<20 Tahun',
        y: <?php foreach($aktifUmur20 as $u20) {
          if ($u20->Total=='0') {
            foreach($aktifUmur20AllTime as $u20At) {
              echo($u20At->Total);
            }
          }else {
            echo($u20->Total); 
          }
        } ?> ,
        y1: <?php foreach($aktifUmur20 as $u20) {
          if ($u20->Infaq=="") {
            echo "0";
          }else {
            echo($u20->Infaq);
          }
        } ?> ,
        color: '#FF9F7F'

      }, {
        name: '20 s/d 30 Tahun',
        y: <?php foreach($aktifUmur2030 as $u2030) {
          if ($u2030->Total=="0") {
            foreach($aktifUmur2030AllTime as $tampil) {
              echo($tampil->Total);
            }
          }else {
            echo($u2030->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifUmur2030 as $u2030) {
          if ($u2030->Infaq=="") {
            echo "0";
          }else {
            echo($u2030->Infaq);
          }
        } ?> ,
        color: '#F66BBF'
      }, {
        name: '30 s/d 40 Tahun',
        y: <?php foreach($aktifUmur3040 as $u3040) {
          if ($u3040->Total=="0") {
            foreach($aktifUmur3040AllTime as $tampil) {
              echo($tampil->Total);
            }
          }else {
            echo($u3040->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifUmur3040 as $u3040) {
          if ($u3040->Infaq=="") {
            echo "0";
          }else {
            echo($u3040->Infaq);
          }
        } ?> ,
        color: '#37A2DA'
      }, {
        name: '40 s/d 50 Tahun',
        y: <?php foreach($aktifUmur4050 as $u4050) {
          if ($u4050->Total=="0") {
            foreach($aktifUmur4050AllTime as $tampil) {
              echo($tampil->Total);
            }
          }else {
            echo($u4050->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifUmur4050 as $u4050) {
          if ($u4050->Infaq=="") {
            echo "0";
          }else {
            echo($u4050->Infaq);
          }
        } ?> ,
        color: '#67E0E3'
      }, {
        name: '>50 Tahun',
        y: <?php foreach($aktifUmur50 as $u50) {
          if ($u50->Total=="0") {
            foreach($aktifUmur50AllTime as $tampil) {
              echo($tampil->Total);
            }
          } else {
            echo($u50->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifUmur50 as $u50) {
          if ($u50->Infaq=="") {
            echo "0";
          }else {
            echo($u50->Infaq);
          }
        } ?> ,
        color: '#FFDB5C'
      }]
    }]
});

// Donatur Aktif Kelamin
Highcharts.chart('aktifKelamin', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y} - {point.percentage:.1f}%</b><br/>Total Infaq : <b>Rp. {point.y1:,.0f}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Donatur',
        colorByPoint: true,
        data: [{
        name: 'Laki - Laki',
        y: <?php foreach($aktifKelaminL as $kL) {
          if ($kL->Total=="0") {
            foreach($aktifKelaminLAllTime as $tampil) {
              echo($tampil->Total);
            }
          }else {
            echo($kL->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifKelaminL as $kL) {
          if ($kL->Infaq=="") {
            echo "0";
          }else {
            echo($kL->Infaq);
          }
        } ?> ,
        color: '#FF9F7F'
      }, {
        name: 'Perempuan',
        y: <?php foreach($aktifKelaminP as $kP) {
          if ($kP->Total=="0") {
            foreach($aktifKelaminPAllTime as $tampil) {
              echo($tampil->Total);
            }
          }else {
            echo($kP->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifKelaminP as $kP) {
          if ($kP->Infaq=="") {
            echo "0";
          }else {
            echo($kP->Infaq);
          }
        } ?> ,
        color: '#37A2DA'
      }]
    }]
});

// Aktif No Telpon
Highcharts.chart('aktifTelp', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y} - {point.percentage:.1f}%</b><br/>Total Infaq : <b>Rp. {point.y1:,.0f}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Donatur',
        colorByPoint: true,
        data: [{
        name: 'Punya Nomor Telpon',
        y: <?php foreach($aktifYesTelp as $aY) {
          if ($aY->Total=="0") {
            foreach($aktifYesTelpAllTime as $tampil) {
              echo($tampil->Total);
            }
          }else {
            echo($aY->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifYesTelp as $aY) {
          if ($aY->Infaq=="") {
            echo "0";
          }else {
            echo($aY->Infaq);
          }
        } ?> ,
        color: '#F66BBF'

      }, {
        name: 'Tidak Punya No Telpon',
        y: <?php foreach($aktifNoTelp as $aN) {
          if ($aN->Total=="0") {
            foreach($aktifNoTelpAllTime as $tampil) {
              echo($tampil->Total);
            }
          }else {
            echo($aN->Total);
          }
        } ?> ,
        y1: <?php foreach($aktifNoTelp as $aN) {
          if ($aN->Infaq=="") {
            echo "0";
          }else {
            echo($aN->Infaq);
          }
        } ?> ,
        color: '#67E0E3'
      }]
    }]
});

// Berdasarkan Donasi Donatur
Highcharts.chart('donasiChart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.y} - {point.percentage:.1f}%</b><br/>Total Infaq : <b>Rp. {point.y1:,.0f}</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true
            },
            showInLegend: true
        }
    },
    series: [{
        name: 'Donatur',
        colorByPoint: true,
        data: [{
          name: '< 20.000',
          y: <?php foreach($aktifSetor20 as $aK20) {
            if ($aK20->Orang=="0") {
              foreach($aktifSetor20AllTime as $tampil) {
                echo($tampil->Orang);
              }
            }else {
              echo($aK20->Orang);
            }
          } ?> ,
          y1: <?php foreach($aktifSetor20 as $aK20) {
            if ($aK20->Total=="") {
              echo "0";
            }else {
              echo($aK20->Total);
            }
          } ?> ,
          color: '#FF9F7F'

        }, {
          name: '20.000 s/d 29.000',
          y: <?php foreach($aktifSetor2030 as $aK2030) {
            if ($aK2030->Orang=="0") {
              foreach($aktifSetor2030AllTime as $tampil) {
                echo($tampil->Orang);
              }
            }else {
              echo($aK2030->Orang);
            }
          } ?> ,
          y1: <?php foreach($aktifSetor2030 as $aK2030) {
            if ($aK2030->Total=="") {
              echo "0";
            }else {
              echo($aK2030->Total);
            }
          } ?> ,
          color: '#F66BBF'
        }, {
          name: '30.000 s/d 49.000',
          y: <?php foreach($aktifSetor3050 as $aK3050) {
            if ($aK3050->Orang=="0") {
              foreach($aktifSetor3050AllTime as $tampil) {
                echo($tampil->Orang);
              }
            }else {
              echo($aK3050->Orang);
            }
          } ?> ,
          y1: <?php foreach($aktifSetor3050 as $aK3050) {
            if ($aK3050->Total=="") {
              echo "0";
            }else {
              echo($aK3050->Total);
            }
          } ?> ,
          color: '#37A2DA'
        }, {
          name: '50.000 s/d 100.000',
          y: <?php foreach($aktifSetor50100 as $aK50100) {
            if ($aK50100->Orang=="0") {
              foreach($aktifSetor50100AllTime as $tampil) {
                echo($tampil->Orang);
              }
            }else {
              echo($aK50100->Orang);
            }
          } ?> ,
          y1: <?php foreach($aktifSetor50100 as $aK50100) {
            if ($aK50100->Total=="") {
              echo "0";
            }else {
              echo($aK50100->Total);
            }
          } ?> ,
          color: '#67E0E3'
        }, {
          name: '> 100.000 ',
          y: <?php foreach($aktifSetor100 as $aK100) {
            if ($aK100->Orang=="0") {
              foreach($aktifSetor100AllTime as $tampil) {
                echo($tampil->Orang);
              }
            }else {
              echo($aK100->Orang);
            }
          } ?> ,
          y1: <?php foreach($aktifSetor100 as $aK100) {
            if ($aK100->Total=="") {
              echo "0";
            }else {
              echo($aK100->Total);
            }
          } ?> ,
          color: '#FFDB5C'
        }]
    }]
},
function(chart) {
    var arr = chart.options.exporting.buttons.contextButton.menuItems;
    var index = arr.indexOf("viewData");
    if (index !== -1) arr.splice(index, 1);
});
</script>
</html>
