<?php 
$provin = substr($data->iddesa, 0,2);
$selectedKabkot = substr($data->iddesa, 0,4);
$selectedKec = substr($data->iddesa, 0,7);
$selectedKel = $data->iddesa;
?>
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
          Edit Kawasan
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="<?php echo base_url('data/kawasan') ?>">Kawasan</a></li>
          <li class="active">Edit Kawasan</li>
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
                <h3 class="box-title">Edit Kawasan Form</h3>
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
              <form class="form-horizontal" action="<?php echo base_url("donatur/editKawasan/").$data->kwsn ?>" method="post">
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                      <label for="nama" class="control-label">Nama<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="nama" id="nama" placeholder="input Nama"
                      required value="<?php echo $data->nm_kawasan ?>">
                    </div>

                    <div class="col-sm-5">
                      <label for="rk" class="control-label">RK<span style="color: red"> *</span></label>
                      <select class="form-control selectpicker" name="rk" data-live-search="true" required id="rk">  
                        <option name="rk" value="R">R</option>
                        <option name="rk" value="K">K</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="inspk" class="control-label">Ins Pk<span style="color: red"> *</span></label>
                      <input type="text" class="form-control" name="inspk" id="inspk" placeholder="input ins pk"
                      value="<?php echo $data->ins_pk ?>">
                    </div>

                    <div class="col-sm-5">
                      <label for="prov" class="control-label">Provinsi<span style="color: red"> *</span></label>
                      <select id="prov" class="form-control selectpicker" name="prov" data-live-search="true" required>
                        <option name="prov" value=""> - </option>  
                        <?php foreach($prov as $prov) : ?>  
                          <option name="prov" value="<?php echo $prov->id_prov ?>"><?php echo $prov->nama_prov ?></option>
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

                      </select>                    
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="desa" class="control-label">Desa</label>
                      <select id="desa" class="form-control selectpicker" name="desa" data-live-search="true" required>  

                      </select>
                    </div>

                    <div class="col-sm-5">
                      <label for="inst" class="control-label">Instansi</label>
                      <input type="text" class="form-control" name="inst" id="inst" placeholder="Input Instansi">
                    </div>


                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="almt" class="control-label">Alamat</label>
                      <input type="text" class="form-control" name="almt" id="alamat" placeholder="Input Alamat"
                      value="<?php echo $data->alamat ?>">
                    </div>

                    <div class="col-sm-5">
                      <label for="jnsktr" class="control-label">Jenis Kantor</label>
                      <select class="form-control selectpicker" name="jnsktr" data-live-search="true" required id="jnsktr">
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
                      <input id="kodej" type="text" class="form-control" name="kodej" id="kodej" placeholder="Input Kode jgt" min="0" value="<?php echo $data->kodejgt ?>">
                    </div>
                    <div class="col-sm-5">
                      <label for="koor" class="control-label">Koordinator</label>
                      <input type="text" class="form-control" name="koor" id="koor" placeholder="Input Koordinator" value="<?php echo $data->idkoordinator ?>">
                    </div>


                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <table style="empty-cells: hide;">
                        <tr>
                          <td style="padding-right: 180px;" id="namajgt"><?php echo $jungut->NAMA ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                      <label for="grup" class="control-label">Group Instansi</label>
                      <input type="number" class="form-control" name="grup" id="grup" placeholder="Input Group Instansi" min="0"
                      value="<?php echo $data->group_instansi ?>">
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
      
      var prov = '<?php echo strval($provin) ?>';
      // $('.selectpicker').selectpicker('refresh');
      $("select#prov").selectpicker("val", prov);
      $('select#rk').selectpicker("val" , '<?php  echo $data->rk ?>');

      // $("select#prov").html(cont)
      // $('.selectpicker').selectpicker('refresh');
      
      $("select#prov").change(function() {
        var prov = $(this).children("option:selected").val();
        var cont = '<option value="" selected> - </option>';
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('donatur/getKota') ?>',
          data  : {prov : prov},
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<option  value="'+data[i].id_kabkot+'">'+data[i].nama_kabkot+'</option>';
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
              cont += '<option n value="'+data[i].id_kec+'">'+data[i].nama_kec+'</option>';
            };
            $('#kecamatan').html(cont);
            $("select#kecamatan").selectpicker("val", '<?php echo $selectedKec ?>');
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
              cont += '<option n value="'+data[i].id_kel+'">'+data[i].nama_kel+'</option>';
            };
            $('#desa').html(cont);
            $("select#desa").selectpicker("val", '<?php echo $selectedKel ?>');
            $('.selectpicker').selectpicker('refresh');
          }
        });
      });
      $("#kodej").keyup(function() {
        var kodej = $(this).val();
        var cont = '';
        var nama = "";
        $.ajax({
          type  : 'GET',
          url   : '<?php echo base_url('donatur/getJungut') ?>',
          data  : {kodej : kodej},
          async : true,
          dataType : 'json',
          success : function(data){
            for (var i=0;i<data.length;i++) {
              cont += '<p>'+data[i].NAMA+'</p>';
              nama += data[i].NAMA;
            };
            $('#namajgt').html(cont); 
            // alert(nama);
          }
        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      $('select#jnsktr').selectpicker("val", '<?php echo $data->jnsktr ?>');
      // $('.selectpicker').selectpicker('refresh');
      var prov           = '<?php echo strval($provin) ?>';
      var kabkot = '<?php echo strval($selectedKabkot) ?>';
      var kec    = '<?php echo strval($selectedKec) ?>';
      var kel    = '<?php echo strval($selectedKel) ?>';
      // console.log(selectedKec);
      $("select#prov").selectpicker("val", prov);
      // var provinsi = $(this).children("option:selected").val();
      var cont_kabkot = '<option value="" selected> - </option>';
      $.ajax({
        type  : 'GET',
        url   : '<?php echo base_url('donatur/getKota') ?>',
        data  : {prov : prov},
        async : true,
        dataType : 'json',
        success : function(data){
          for (var i=0;i<data.length;i++) {
            cont_kabkot += '<option  value="'+data[i].id_kabkot+'">'+data[i].nama_kabkot+'</option>';
          }
          $("select#kota").html(cont_kabkot);
          $("select#kota").selectpicker("val", kabkot);
          $('.selectpicker').selectpicker('refresh');
          // var kabkot = $(this).children("option:selected").val();
          var cont_kec = '<option value="" selected> - </option>';
          $.ajax({
            type  : 'GET',
            url   : '<?php echo base_url('donatur/getKec') ?>',
            data  : {kabkot : kabkot},
            async : true,
            dataType : 'json',
            success : function(data){
              for (var i=0;i<data.length;i++) {
                cont_kec += '<option value="'+data[i].id_kec+'">'+data[i].nama_kec+'</option>';
              };
              console.log(cont_kec)
              $("select#kecamatan").html(cont_kec);
              $("select#kecamatan").selectpicker("val", kec);
              // $("select#kecamatan").val(kec);
              $('.selectpicker').selectpicker('refresh');

              // var kec = $(this).children("option:selected").val();
              var cont_kel = '<option value="" selected> - </option>';
              $.ajax({
                type  : 'GET',
                url   : '<?php echo base_url('donatur/getDesa') ?>',
                data  : {kec : kec},
                async : true,
                dataType : 'json',
                success : function(data){
                  for (var i=0;i<data.length;i++) {
                    cont_kel += '<option n value="'+data[i].id_kel+'">'+data[i].nama_kel+'</option>';
                  };
                  $("select#desa").html(cont_kel);
                  $("select#desa").selectpicker("val", kel);
                  $('.selectpicker').selectpicker('refresh');
                }
              });
            }
          });
        }
      });
    });
  </script>

  </html>