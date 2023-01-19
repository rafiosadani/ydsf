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
          Add Kawasan
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url('data/kawasan') ?>">Kawasan</a></li>
          <li class="active">Kawasan Baru</li>
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
                <h3 class="box-title">Add Kawasan Form</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="container-fluid">
                <?php if ($this->session->flashdata('success')): ?>
                  <div class="alert alert-info" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                  </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('error')) : ?>
                  <div class="alert alert-danger" role="alert">
                    <?php echo $this->session->flashdata('error'); ?>
                  </div>
                <?php endif; ?>
              </div>
              <form class="form-horizontal" action="<?php echo base_url("donatur/addKawasan") ?>" method="post">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                      <label for="nama" class="control-label">Nama<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="input Nama"
                      required>
                    </div>

                    <div class="col-sm-5">
                      <label for="rk" class="control-label">RK<span style="color: red"> *</span></label>
                      <select class="form-control selectpicker" name="rk" data-live-search="true" required>  
                        <option name="rk" value="R">R</option>
                        <option name="rk" value="K">K</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="inspk" class="control-label">Ins Pk<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="inspk" id="inspk" placeholder="input ins pk">
                    </div>

                    <div class="col-sm-5">
                      <label for="prov" class="control-label">Provinsi<span style="color: red"> *</span></label>
                      <select id="prov" class="form-control selectpicker" name="prov" data-live-search="true" required>
                        <option name="prov" value=""> - </option>  
                        <?php foreach($prov as $prov) : ?>  
                          <option name="prov" value="<?php echo $prov->IDPROP ?>"><?php echo $prov->NAMA ?></option>
                        <?php endforeach; ?>
                      </select>                    
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="kota" class="control-label">Kota</label>
                      <select id="kota" class="form-control selectpicker" data-live-search="true" name="kota" required>  

                      </select>
                    </div>

                    <div class="col-sm-5">
                      <label for="kec" class="control-label">Kecamatan</label>
                      <select id="kecamatan" class="form-control selectpicker" name="kec" data-live-search="true" required>  

                      </select>                    </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-5">
                        <label for="desa" class="control-label">Desa</label>
                        <select id="desa" class="form-control selectpicker" name="desa" data-live-search="true" required>  

                        </select>
                      </div>

                      <div class="col-sm-5">
                        <label for="inst" class="control-label">Instansi</label>
                        <input type="text" class="form-control" name="instansi" id="inst" placeholder="Input Instansi">
                      </div>


                    </div>
                    <div class="form-group">
                      <div class="col-sm-5">
                        <label for="almt" class="control-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="almt" placeholder="Input Alamat" autocomplete="off">
                      </div>

                      <div class="col-sm-5">
                        <label for="jnsktr" class="control-label">Jenis Kantor</label>
                        <select class="form-control selectpicker" name="jnsktr" data-live-search="true" required>
                          <option name="jnsktr" value=""> - </option>
                          <?php foreach ($jnsktr as $key => $jktr) : ?>
                            <option name="jnsktr" value="<?php echo $jktr->kd_jnsktr ?>"><?php echo $jktr->nm_jnsktr ?></option>
                          <?php endforeach; ?>
                        </select>

                      </div>


                    </div>
                    <div class="form-group">
                      <div class="col-sm-5">
                        <label for="kodej" class="control-label">Kode jgt</label>
                        <input id="kodej" type="text" class="form-control" name="kodej" id="kodej" placeholder="Input Kode jgt" min="0" required>
                      </div>
                      <div class="col-sm-5">
                        <label for="koor" class="control-label">Koordinator</label>
                        <input type="text" class="form-control" name="koor" id="koor" placeholder="Input Koordinator">
                      </div>


                    </div>
                    <div class="form-group">
                      <div class="col-sm-5">
                      <table style="empty-cells: hide;">
                      <tr>
                        <td id="td" style="padding-right: 180px"></td>
                      </tr>
                    </table>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-5">
                        <label for="grup" class="control-label">Group Instansi</label>
                        <input type="number" class="form-control" name="grup" id="grup" placeholder="Input Group Instansi" min="0">
                      </div>



                    </div>

                  </div>

                  <!-- /.box-body -->
                  <div class="box-footer">
                    <div class="col-md-8 col-md-offset-3">
                      <input type="submit" name="btnsave" class="btn btn-md btn-info pull-right" value="Simpan" />
                    </div>
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
  $(function () {
       //Date picker
       $('#tgllahir').datepicker({
        autoclose: true
      })
     })
   </script>
   <script>
    $(document).ready(function() {

      $("select#prov").change(function() {
        var prov = $(this).children("option:selected").val();
        var cont = '<option value="" selected> - </option>';
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('donatur/getKota') ?>',
          data  : {
            prov : prov
          },
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<option value="'+data[i].IDKAB+'">'+data[i].NAMA+'</option>';
            }
            $("select#kota").html(cont);
            $('.selectpicker').selectpicker('refresh');
          }
        });
      });
      
      $("select#kota").change(function() {
        var kabkot = $(this).children("option:selected").val();
        var cont = '<option value="" selected> - </option>';
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('donatur/getKec') ?>',
          data  : {kabkot : kabkot},
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<option value="'+data[i].IDKEC+'">'+data[i].NAMA+'</option>';
            };
            $('#kecamatan').html(cont);
            $('.selectpicker').selectpicker('refresh');
          }
        });
      });

      $("select#kecamatan").change(function() {
        var kec = $(this).children("option:selected").val();
        var cont = '<option value="" selected> - </option>';
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('donatur/getDesa') ?>',
          data  : {kec : kec},
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<option name="id_desa" value="'+data[i].IDDESA+'">'+data[i].NAMA+'</option>';
            };
            $('#desa').html(cont);
            $('.selectpicker').selectpicker('refresh');
          }
        });
      });
      
      $("#kodej").focusout(function() {
        
        var kodej = $(this).val();
        var nama = "";
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('donatur/getJungut') ?>',
          data  : {kodej : kodej},
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              $("#p").remove(); 
              nama += '<p id="p">'+data[i].NAMA+'</p>';
            };
            $("#td").html(nama);           
          }
        });
      });
    });
  </script>

  </html>