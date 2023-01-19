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
          Rekap Angsuran
          <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo base_url('dashboard') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Angsuran</li>
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
                <h3 class="box-title">Angsuran</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post" >
                <div class="box-body">
                  <div class="form-group">


                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Nama Angsuran<span style="color: red"> *</span></label>
                    <select  class="form-control selectpicker" id="angsuran" name="slip" data-live-search="true">        
                      <?php foreach ($angsuran as $angsuran) : ?>
                        <option name="slip" value="<?php echo $angsuran->id_vrb?>"><?php echo $angsuran->nm_uraian ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="jungut" class="control-label">Nama Karyawan<span style="color: red"> *</span></label>
                    <select id="karyawan" class="form-control selectpicker" id="karyawan" name="karyawan" data-live-search="true">        
                      <?php foreach ($karyawan as $karyawan) : ?>
                        <option name="karyawan" value="<?php echo $karyawan->nip ?>"><?php echo $karyawan->nama ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  <div class="form-group">
                    <div class="col-sm-5">
                    <label for="cabang" class="control-label">Tahun<span style="color: red"> *</span></label>
                    <select class="form-control selectpicker" id="tahun" name="tahun" data-live-search="true">
                      <?php foreach ($tahun as $tahun) : ?>
                        <option name="tahun" value="<?php echo $tahun['tahun'] ?>"><?php echo $tahun['tahun'] ?></option>
                      <?php endforeach ?>
                    </select>
                    </div>

                  </div>
                  
                  <div class="form-group">
                    <div class="col-md-2">
                    <button type="button" id="btn-submit" name="button" class="btn btn-block btn-success">Submit                                 <span><i class="fa fa-search"></i></span>
                    </button>
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

        <div class="row" id="divTable" style="display:none;">
                    <div class="col-xs-12">
                        <div class="box box-info">                            
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
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Uraian</th>
                                                <th>Jumlah</th>
                                                <th>Bulan</th>
                                                <th>Tahun</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
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
<script>
$(document).ready(function () {

    function price_format(values){
        values=""+values+"";
        var len=values.length;
        var mod=len % 3;
        if(mod==0) mod =3;
        var divided= len/3;
        divided=parseInt(divided);
        var priceFormat=values.substr(0,mod)+",";
        var pointer=0;
        for(var pointer=0;pointer<divided; pointer++)
        {
        priceFormat=priceFormat+""+values.substr((mod+(pointer*3)),3)+",";
        }
        while(priceFormat.substr(priceFormat.length-1,1)==",")
        {
        priceFormat=priceFormat.substr(0,priceFormat.length-1);
        }
        while(priceFormat.substr(0,1)==",")
        {
        priceFormat=priceFormat.substr(1,priceFormat.length-1);
        }
        priceFormat=priceFormat;
        return priceFormat;
}
    $("#table").DataTable();
    $('#btn-submit').click(function () {
                $("#table").DataTable().destroy();
                $('#divTable').show();
                tampil();
            function tampil() {
                var angsuran = $("select#angsuran").children("option:selected").val();
                var karyawan = $("select#karyawan").children("option:selected").val();
                var tahun = $("select#tahun").children("option:selected").val();
                // console.log(date);
                var cont = "";
                $.ajax({
                    type  : 'POST',
                    url   : '<?php echo base_url('angsuran_karyawan/getDatas') ?>',
                    data  : {
                        angsuran : angsuran,
                        karyawan : karyawan,
                        tahun : tahun
                    },
                    async : true,
                    dataType : 'json',
                    success : function(data) {
                        for (var i=0;i<data.length;i++) {                                 
                            cont += '<tr>'+                                
                                '<td>'+ data[i].nip +'</td>'+
                                '<td>'+ data[i].NAMA +'</td>'+
                                '<td>'+ data[i].nm_uraian +'</td>'+
                                '<td>'+ price_format(data[i].jumlah) +'</td>'+
                                '<td>'+data[i].bulan +'</td>'+
                                '<td>'+data[i].tahun +'</td>'+
                                '</tr>';
                        }
                        $("#tbody").html(cont);
                        $("#table").DataTable();
                        // // console.log(kwit);
                        // console.log(data);
                    }
                });
            }



    })
});
</script>
<!-- <script>
  $(function () {
    $('#example1').DataTable()
  })
</script> -->

<!-- <script>
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

</script> -->

</html>