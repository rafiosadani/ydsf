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
      <section class="content-header">
        <h1>
          Report
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Rekap Perolehan</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header">
                <h3 class="box-title">Report View</h3>
              </div>
              <!-- /.box-header -->
              <form action="<?php echo base_url('report/rekap') ?>" class="form-horizontal" method="post" target="_blank">
              <div class="box-body" style="height: 333px"> 
              <div class="form-group">
                  <div class="col-sm-5"> 
                    <label for="kodej" class="control-label">Jungut<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="kodej" data-live-search="true">
                    <?php if ($this->session->userdata('superadmin') == TRUE): ?>
                      <?php foreach ($report as $report) : ?>
                        <option name="kodej" value="<?php echo $report->kodej ?>"><?php echo $report->kodej.' - '.$report->name ?></option>
                      <?php endforeach ?>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin_cabang') == TRUE): ?>
                      <?php foreach ($report_dua as $report_dua) : ?>
                        <option name="kodej" value="<?php echo $report_dua->kodej ?>"><?php echo $report_dua->kodej.' - '.$report_dua->name ?></option>
                      <?php endforeach ?>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('admin_grup') == TRUE): ?>
                      <?php foreach ($report_empat as $report_empat) : ?>
                        <option name="kodej" value="<?php echo $report_empat->kodej ?>"><?php echo $report_empat->kodej.' - '.$report_empat->name ?></option>
                      <?php endforeach ?>
                    <?php endif; ?>
                    <?php if ($this->session->userdata('superadmin') != TRUE && $this->session->userdata('admin') != TRUE): ?>
                        <option name="kodej" value="<?php echo $report_tiga->kodej ?>"><?php echo $report_tiga->kodej.' - '.$report_tiga->name ?></option>
                    <?php endif; ?>
                    </select><br><br>
                    <!-- <button type="date" id="daterange-btn" class="btn btn-md btn-default" name="date">
                    <span name="date"> Masukkan Tanggal Rekap
                    </span> 
                    <i class="fa fa-caret-down"></i>
                  </button> -->
                  <div class="input-group date">
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                  <input type="text" class="form-control daterange-btn" name="date" />
                  </div>
                  </div><br>
                  <!-- <div class="col-sm-5">
                  
                </div> -->

                  <div class="col-sm-1">
                    <div class="col-md-12 col-md-offset-3">
                      <input type="submit" class="btn btn-lg btn-info pull-right" value="Cetak" name="cetak" />
                    </div>
                  </div>
                  <div class="col-sm-2">
                    <div class="col-md-8 col-md-offset-3">
                      <input type="submit" class="btn btn-lg btn-success pull-right" value="Export to excel" name="export" />
                    </div>
                  </div>
                </div>
              </div>
              </form>

              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.col -->

        </div>
        <!-- /.row (main row) -->

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
<script>
//   $(function () {
//     $('#example1').DataTable()
//   })
// </script>
<script>
  $(function () {
    $('.daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        locale: {
            format: 'YYYY-MM-DD'
      },
        startDate: moment().startOf('month'),
        endDate  : moment().endOf('month')
      },
      function (start, end) {
        $('.daterange-btn').html(start.format('YYYY-MM-DD') + ' ~ ' + end.format('YYYY-MM-DD'))
      }
      
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })
  })
</script>

</html>