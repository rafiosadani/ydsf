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
          Rekap Per Bank
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Per Bank</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Per Bank</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo base_url('keuangan/bank/rekap') ?>" method="post" target="_blank">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Cabang<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="cabang" data-live-search="true">
                    <?php if ($this->session->userdata('superadmin') == TRUE || $this->session->userdata('admin_grup') == TRUE) : ?>
                    <option name="cabang" value="-">SEMUA CABANG</option>
                    <?php endif; ?>
                      <?php foreach ($cabang as $cabang) : ?>
                        <option name="cabang" value="<?php echo $cabang->id_cab ?>"><?php echo $cabang->nm_cabang ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="tglhimpun" class="control-label">Tanggal Himpunan</label>
                    <div class="input-group">
                    <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                    <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-right: 20px;">
                        <span id="tglhimpun"></span><i class="fa fa-caret-down pull-right"></i>
                        <input type="hidden" name="tglhimp" id="tgl1" value="">
                    </div>
                    </div>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="tglval" class="control-label">Tanggal Keuangan</label>
                    <div class="input-group">
                    <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                    <div id="dateval" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-right: 20px;">
                        <span id="tglval"></span><i class="fa fa-caret-down pull-right"></i>
                        <input type="hidden" name="tglval" id="tgl2" value="">
                    </div>
                    </div>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-md-10 pull-right">
                    <input type="submit" name="btnexcel" class="btn btn-lg btn-success" value="Export to excel" />
                    <input type="submit" name="btncetak" class="btn btn-lg btn-info" value="Cetak" />
                    </div>

                   
                  </div>
                  
                  
                <!-- /.box-body -->
                <div class="box-footer">
                  
                </div>
                <!-- /.box-footer -->
              </form>
            </div>
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


</body>
<?php $this->load->view('partials/js') ?>
<!-- <script>
  $(function () {
    $('#example1').DataTable()
  })
</script> -->

<script>
  $('#reportrange').daterangepicker(
  {
    dateLimit: { days: 1000 },
    showDropdowns: true,
    showWeekNumbers: true,
    timePicker: false,
    timePickerIncrement: 1,
    timePicker12Hour: true,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
        'Last 7 Days': [moment().subtract('days', 6), moment()],
        'Last 30 Days': [moment().subtract('days', 29), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
    },
    opens: 'right',
    buttonClasses: ['btn btn-default'],
    applyClass: 'btn-small btn-primary',
    cancelClass: 'btn-small',
    format: 'MM/DD/YYYY',
    separator: ' to ',
    locale: {
        applyLabel: 'Submit',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom Range',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
    }
  },
    function(start, end) {
        console.log("Callback has been called!");
        $('#tglhimpun').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        $('#from').val(start.format('YYYY-MM-DD'));
        $('#to').val(end.format('YYYY-MM-DD'));
        var tglhimp = start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD');
        $('#tgl1').val(tglhimp);
        // console.log(tglhimp);   
      }
    );
    //Set the initial state of the picker label
    $('#tglhimpun').html("input tanggal");
</script>
<script>
  $('#dateval').daterangepicker(
  {
    dateLimit: { days: 1000 },
    showDropdowns: true,
    showWeekNumbers: true,
    timePicker: false,
    timePickerIncrement: 1,
    timePicker12Hour: true,
    ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
        'Last 7 Days': [moment().subtract('days', 6), moment()],
        'Last 30 Days': [moment().subtract('days', 29), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
    },
    opens: 'right',
    buttonClasses: ['btn btn-default'],
    applyClass: 'btn-small btn-primary',
    cancelClass: 'btn-small',
    format: 'MM/DD/YYYY',
    separator: ' to ',
    locale: {
        applyLabel: 'Submit',
        fromLabel: 'From',
        toLabel: 'To',
        customRangeLabel: 'Custom Range',
        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        firstDay: 1
    }
  },
    function(start, end) {
        console.log("Callback has been called!");
        $('#tglval').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        $('#from').val(start.format('YYYY-MM-DD'));
        $('#to').val(end.format('YYYY-MM-DD'));
        var tglval = start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD');
        $('#tgl2').val(tglval);
      }
    );
    //Set the initial state of the picker label
    $('#tglval').html("input tanggal");
</script>

</html>