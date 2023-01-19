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
          Rekap Per Petugas
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Per Petugas</li>
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
                <h3 class="box-title">Per Petugas</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo base_url('report/per-petugas/rekap') ?>" method="post" target="_blank">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Cabang<span style="color: red"> *</span></label>
                    <select id="cabang" class="form-control selectpicker" name="cabang" data-live-search="true">
                    <?php if ($this->session->userdata('superadmin') == TRUE) : ?>
                    <option name="cabang" value="-">SEMUA CABANG</option>
                    <?php else: ?>
                    <option name="cabang" value="">-</option>
                    <?php endif; ?>
                      <?php foreach ($cabang as $cabang) : ?>
                        <option name="cabang" value="<?php echo $cabang->id_cab ?>"><?php echo $cabang->nm_cabang ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="jungut" class="control-label">Jungut<span style="color: red"> *</span></label>
                    <select id="jungut" class="form-control selectpicker" name="jungut" data-live-search="true">
                    <?php if ($this->session->userdata('superadmin') == TRUE) : ?>
                    <option name="jungut" value="-">SEMUA JUNGUT</option>
                    <?php endif; ?>
                    <option name="jungut" value=""></option>
                     
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Tahun<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="tahun" data-live-search="true">
                      <?php foreach ($tahun as $tahun) : ?>
                        <option name="tahun" value="<?php echo $tahun['tahun'] ?>"><?php echo $tahun['tahun'] ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Bulan<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" name="bulan" data-live-search="true">
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
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
$(document).ready(function() {

$("select#cabang").change(function() {
        var cabang = $(this).children("option:selected").val();
        <?php if ($this->session->userdata('superadmin') == TRUE) : ?>
        var cont = '<option name="jungut" value="-">SEMUA JUNGUT</option>';
      <?php else: ?>
        var cont = '<option name="jungut" value="-">SEMUA JUNGUT</option>';
      <?php endif; ?>
        
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('per_petugas/getJungut') ?>',
          data  : {cabang : cabang},
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<option  value="'+data[i].kodej+'">'+data[i].name+'</option>';
            }
            $("select#jungut").html(cont);
            $('.selectpicker').selectpicker('refresh');
          }
        });
      });
    });

</script>

</html>