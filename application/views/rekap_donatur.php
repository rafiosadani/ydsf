<!DOCTYPE html>
<html>
<?php $this->load->model('mr_donatur'); ?>
<head>
    <?php $this->load->view('partials/head') ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
    <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css"
        rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script>
      $( function() {
        var availableTags = [
          <?php foreach ($noid as $value) {
            echo '"'.$value->noid.'",';
          } ?>
        ];
        $( "#noid" ).autocomplete({
          source: availableTags
        });
      } );
      </script>
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
                    Data Rekap Donatur
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Data Rekap Donatur</li>
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
                                <h3 class="box-title">Filter Pencarian</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                    <form action="<?php echo base_url('data/rekap-donatur') ?>" method="post">
                                        <div class="form-group">
                                        <div class="row">
                                          <div class="col-sm-3">
                                              <label for="noid" class="control-label">ID Donatur<span style="color: red">
                                                      *</span></label>
                                              <input type="text" name="noid" id="noid" class="form-control">
                                          </div>
                                            <div class="col-sm-3">
                                            <label for="tglhimpun" class="control-label">Tanggal</label>
                                            <div class="input-group">
                                            <div class="input-group-addon">
                                                      <i class="fa fa-calendar"></i>
                                                    </div>
                                            <div id="reportrange" class="form-control" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; margin-right: 20px;">
                                                <span id="tglhimpun"></span><i class="fa fa-caret-down pull-right"></i>
                                                <input type="hidden" name="date" id="tgl1" value="-">
                                            </div>
                                            </div>
                                            </div>



                                          <div class="col-sm-2" style="padding-top:5px;">
                                              <label for="button"> </label>
                                              <button id="btnsubmit" type="submit" name="button" class="btn btn-block btn-success">
                                                  Submit
                                                  <span><i class="fa fa-search"></i></span>
                                              </button>
                                          </div>
                                        </div>

                                      </div>
                                    </form>

                                <!-- /.box-body -->
                            </div>
                            <!-- </form> -->
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>
                <!-- /.row (main row) -->
                <?php if ($this->input->post('noid') && $this->input->post('date')): ?>
                  <script type="text/javascript">
                    $("#noid").val('<?php echo $this->input->post('noid') ?>');
                  </script>
                <div class="row" id="divTable">
                    <div class="col-xs-12">
                        <div class="box box-info">
                            <div class="box-header">
                                <h3 style="padding-top:20px;"
                                 class="box-title">
                                  <?php foreach ($this->mr_donatur->getIdentitas($this->input->post('noid')) as $tampil){ ?>
                                    <?php echo $tampil->nama." - ".$tampil->alamat ?>
                                  <?php } ?>
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                              <th>Noid</th>
                                              <th>Program</th>
                                              <th>Tanggal</th>
                                              <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                          <?php if ($this->input->post('date')=='-'){
                                            $tgl1='0000-00-00';
                                            $tgl2= date('Y-m-d');
                                          }else {
                                            $tgl1=substr($this->input->post('date'),0,10);
                                            $tgl2=substr($this->input->post('date'),13,10);
                                          }
                                            foreach ($this->mr_donatur->getDatadata($this->input->post('noid'),$tgl1,$tgl2) as $tampil): ?>
                                            <tr>
                                              <td><?php echo $tampil->noid ?></td>
                                              <td><?php echo $tampil->NM_PROGRAM ?></td>
                                              <td><?php echo substr($tampil->tanggal,0,10) ?></td>
                                              <td><?php echo number_format($tampil->jumlah,0,'.','.') ?></td>

                                            </tr>
                                          <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!-- /.col -->

                </div>
                <?php endif; ?>

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
<script type="text/javascript"
    src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script>
  $("#table").DataTable();
  $('#reportrange').daterangepicker(
  {
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
        $('#tglhimpun').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('#from').val(start.format('YYYY-MM-DD'));
        $('#to').val(end.format('YYYY-MM-DD'));
        var tglhimp = start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD');
        $('#tgl1').val(tglhimp);
        // console.log(tglhimp);
      }
    );
    //Set the initial state of the picker label
    $('#tglhimpun').html("<?php echo date('Y-m-d').' - '. date('Y-m-d'); ?>");
</script>

</html>
