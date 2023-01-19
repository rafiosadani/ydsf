<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('partials/head') ?>
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
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
          Cetak Donasi
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Batal Setor</li>
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
                <div class="row">
                <form action="<?php echo base_url('Donasi/cetak') ?>" method="post" target="_blank">
                  <div class="form-group">
                    <div class="col-sm-4"> 
                      <label for="kodej" class="control-label">Jungut<span style="color: red"> *</span></label>
                      <select class="form-control selectpicker" id="jungut" name="kodej" data-live-search="true">
                        <option value="null" disabled <?php if(empty($this->session->userdata('jungut'))){echo ("selected");} ?>>Pilih</option>
                        <?php foreach ($jungut as $report) : ?>
                          <option name="kodej" value="<?php echo $report->kodej ?>" <?php if($report->kodej == $this->session->userdata('jungut')){echo ("selected");} ?>><?php echo $report->kodej.' - '.$report->name ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    
                    <div class="col-sm-4"> 
                      <label for="kawasan" class="control-label">Kawasan<span style="color: red"> *</span></label>
                      <select class="form-control selectpicker" id="kawasan" name="kawasan" data-live-search="true">
                      </select>
                    </div>
                    <div class="col-sm-2">
                      <input type="submit" style="margin-top: 24px;" name="cetak" class="btn btn-block btn-success" value="Cetak">
                    </div>
                    <div class="col-sm-2">
                      <input type="submit" style="margin-top:24px;" name="export" class="btn btn-block btn-info" value="Export to txt">
                    </div>
                  </div>  
              </div>
              
              <!-- /.box-body -->
              </div>
              </form>
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
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/js/dataTables.checkboxes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script>
$(document).ready(function(){
  
  $("select#jungut").on('change',function() {

        var kodej = $(this).children("option:selected").val();
        var cont = '<option value="'+kodej+'" selected> all </option>';
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('Donasi/getKawasanJ') ?>',
          data  : {
            kodej : kodej
          },
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<option  value="'+data[i].kwsn_lm+'">'+data[i].kwsn+' - '+data[i].nm_kawasan+' </option>';
            };
            $('select#kawasan').html(cont);
            $('.selectpicker').selectpicker('refresh');
          }
        });
      });

    })  

    //
    // 


</script>


</html>
